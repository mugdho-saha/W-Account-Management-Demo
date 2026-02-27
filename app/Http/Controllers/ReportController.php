<?php

namespace App\Http\Controllers;

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
}
