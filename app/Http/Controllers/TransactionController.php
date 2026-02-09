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

            // 2. Only show transactions where the user has access to either side of the entry
            $query->where(function($q) use ($assignedCategoryIds) {
                $q->whereIn('debit_category_id', $assignedCategoryIds)
                    ->orWhereIn('credit_category_id', $assignedCategoryIds);
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
}
