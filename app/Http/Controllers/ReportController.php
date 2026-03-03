<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

    public function datewiseReport(Request $request)
    {
        // Default to the first and last day of the current month
        $start_date = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $transactions = Transaction::whereBetween('date', [$start_date, $end_date])
            ->with(['debitCategory', 'creditCategory', 'user'])
            ->orderBy('date', 'asc')
            ->get();

        return view('reports.datewise', compact('transactions', 'start_date', 'end_date'));
    }

    public function export(Request $request)
    {
        // 1. Capture the date range (defaulting to current month if missing)
        $start_date = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $type = $request->get('type');

        // 2. Fetch transactions within the range
        $transactions = Transaction::whereBetween('date', [$start_date, $end_date])
            ->with(['debitCategory', 'creditCategory'])
            ->orderBy('date', 'asc')
            ->get();

        // 4. Handle PDF Export
        if ($type === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf_datewise', [
                'transactions' => $transactions,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);

            // Optional: Set paper to A4 and orientation to portrait/landscape
            $pdf->setPaper('a4', 'portrait');

            return $pdf->download("Transaction_Report_{$start_date}_to_{$end_date}.pdf");
        }

        return back()->with('error', 'Invalid export type selected.');
    }

    public function balanceSheet(Request $request)
    {
        $as_of_date = $request->get('date', now()->format('Y-m-d'));

        // 1. Fetch all categories with sums
        $allCategories = Category::withSum(['debitTransactions as total_debit' => function($query) use ($as_of_date) {
            $query->where('date', '<=', $as_of_date);
        }], 'amount')
            ->withSum(['creditTransactions as total_credit' => function($query) use ($as_of_date) {
                $query->where('date', '<=', $as_of_date);
            }], 'amount')
            ->get();

        // 2. Map balances and normalize types for filtering
        $allCategories->transform(function($cat) {
            $debit = $cat->total_debit ?? 0;
            $credit = $cat->total_credit ?? 0;

            // Normalize type to lowercase for logic checks
            $type = strtolower(trim($cat->type));

            // Logic: Assets = Debit - Credit | Liabilities/Equity = Credit - Debit
            if ($type === 'asset') {
                $cat->balance = $debit - $credit;
            } else {
                $cat->balance = $credit - $debit;
            }
            return $cat;
        });

        // 3. Filter using case-insensitive check
        $assets = $allCategories->filter(fn($c) => strtolower(trim($c->type)) === 'asset');
        $liabilities = $allCategories->filter(fn($c) => strtolower(trim($c->type)) === 'liability');
        $equity = $allCategories->filter(fn($c) => strtolower(trim($c->type)) === 'equity');

        // Diagnostic Check: If still empty, this will tell us exactly why
        // return response()->json(['all' => $allCategories, 'assets' => $assets]);

        return view('reports.balancesheet', compact('assets', 'liabilities', 'equity', 'as_of_date'));
    }

    public function exportBalanceSheet(Request $request)
    {
        $as_of_date = $request->get('date', now()->format('Y-m-d'));

        // Re-use your logic to get $assets, $liabilities, and $equity
        $allCategories = Category::withSum(['debitTransactions as total_debit' => function($query) use ($as_of_date) {
            $query->where('date', '<=', $as_of_date);
        }], 'amount')
            ->withSum(['creditTransactions as total_credit' => function($query) use ($as_of_date) {
                $query->where('date', '<=', $as_of_date);
            }], 'amount')
            ->get();

        $allCategories->transform(function($cat) {
            $debit = $cat->total_debit ?? 0;
            $credit = $cat->total_credit ?? 0;
            $type = strtolower(trim($cat->type));

            if ($type === 'asset') {
                $cat->balance = $debit - $credit;
            } else {
                $cat->balance = $credit - $debit;
            }
            return $cat;
        });

        $assets = $allCategories->filter(fn($c) => strtolower(trim($c->type)) === 'asset');
        $liabilities = $allCategories->filter(fn($c) => strtolower(trim($c->type)) === 'liability');
        $equity = $allCategories->filter(fn($c) => strtolower(trim($c->type)) === 'equity');

        // Load a dedicated PDF view
        $pdf = Pdf::loadView('reports.pdf_balancesheet', compact('assets', 'liabilities', 'equity', 'as_of_date'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Balance_Sheet_'.$as_of_date.'.pdf');
    }
}
