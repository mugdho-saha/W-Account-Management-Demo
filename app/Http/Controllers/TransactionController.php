<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(){
        $user = Auth::user();

        // 1. Get Categories based on Role
        if ($user->hasRole('admin')) {
            // Admins see everything
            $categories = Category::where('status', 'active')->get();
        } else {
            // Moderators only see categories linked in the pivot table
            $categories = $user->categories()->where('status', 'active')->get();
        }

        // Start the query with relationships to avoid N+1 issues
        $query = Transaction::with(['debitCategory', 'creditCategory', 'user']);

        if (!$user->hasRole('admin')) {
            // 1. Get the IDs of categories assigned to this moderator
            $assignedCategoryIds = $user->categories()->pluck('categories.category_id')->toArray();

            // 2. Only show transactions where the user has access to both side of the entry
            $query->where(function($q) use ($assignedCategoryIds) {
                $q->whereIn('debit_category_id', $assignedCategoryIds)
                    ->WhereIn('credit_category_id', $assignedCategoryIds);
            });
        }

        $transactions = $query->latest()->paginate(50);

        return view('transaction.index', compact('transactions','categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // 2. Validate basic inputs
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'debit_category_id' => 'required|exists:categories,category_id',
            'credit_category_id' => 'required|exists:categories,category_id',
            'description' => 'required|string|max:255',
        ]);

        // 3. Security Check: Ensure Moderator owns both categories
        if (!$user->hasRole('admin')) {
            $allowedCategoryIds = $user->categories->pluck('category_id')->toArray();

            if (!in_array($request->debit_category_id, $allowedCategoryIds) ||
                !in_array($request->credit_category_id, $allowedCategoryIds)) {

                return redirect()->back()->with('error', 'Unauthorized Category selection detected.');
            }
        }

        // Check for "Income vs Expense" logic error
        $debitType = Category::find($request->debit_category_id)->type;
        $creditType = Category::find($request->credit_category_id)->type;


// Rule: You must have at least one Balance Sheet account (Asset/Liability/Equity)
// OR one Income/Expense account.
// Directly crossing Income and Expense is usually an error.

        if ($debitType == 'Income' && $creditType == 'Expense') {
            return back()->with('error', 'Nonsensical Entry: Cannot swap Income for Expense.');
        }

        if ($debitType == 'Expense' && $creditType == 'Income') {
            return back()->with('error', 'Nonsensical Entry: Did you mean to record a Refund?');
        }

        // 4. Create Transaction
        Transaction::create([
            'date' => $request->date,
            'description' => $request->description,
            'debit_category_id' => $request->debit_category_id,
            'credit_category_id' => $request->credit_category_id,
            'amount' => $request->amount,
            'user_id' => $user->id,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction posted successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        // Optional: Only allow the person who created it OR an admin to delete
        if (auth()->id() !== $transaction->user_id && !auth()->user()->hasRole('admin')) {
            return back()->with('error', 'You do not have permission to delete this transaction.');
        }

        $transaction->delete();
        return back()->with('success', 'Transaction deleted and balances updated.');
    }

    public function edit(Transaction $transaction)
    {
        $user = auth()->user();

        // 1. Security Check: Is the user allowed to edit THIS specific transaction?
        if (!$user->hasRole('admin')) {
            // Get the array of category IDs assigned to this moderator
            $assignedCategoryIds = $user->categories->pluck('category_id')->toArray();

            // Check if BOTH the debit and credit categories of the transaction are in their list
            if (!in_array($transaction->debit_category_id, $assignedCategoryIds) ||
                !in_array($transaction->credit_category_id, $assignedCategoryIds)) {

                // If not, kick them back with an error
                return redirect()->route('transactions.index')
                    ->with('error', 'Access Denied: You are not assigned to the categories in this transaction.');
            }
        }

        // 2. Load categories for the dropdowns (Admin gets all, Moderator gets assigned)
        if ($user->hasRole('admin')) {
            $categories = Category::where('status', 0)->get();
        } else {
            $categories = $user->categories()->where('status', 0)->get();
        }

        return view('transaction.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'debit_category_id' => 'required|exists:categories,category_id',
            'credit_category_id' => 'required|exists:categories,category_id',
            'description' => 'required|string|max:255',
        ]);

        // Update the transaction
        $transaction->update([
            'date' => $request->date,
            'description' => $request->description,
            'debit_category_id' => $request->debit_category_id,
            'credit_category_id' => $request->credit_category_id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }
}
