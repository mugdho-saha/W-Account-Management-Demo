<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // --- 1. Summary Card Data ---

        // Total Cash Position (Assets)
        $categories = Category::withSum(['debitTransactions as total_debit'], 'amount')
            ->withSum(['creditTransactions as total_credit'], 'amount')
            ->get();

        // Calculation: Assets = Debit - Credit
        $totalCash = $categories->where('type', 'Asset')->sum(fn($c) => ($c->total_debit ?? 0) - ($c->total_credit ?? 0));

        // Monthly Income & Expense
        $monthlyIncome = Transaction::whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->whereHas('debitCategory', fn($q) => $q->where('type', 'Income'))
            ->sum('amount');

        $monthlyExpense = Transaction::whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->whereHas('debitCategory', fn($q) => $q->where('type', 'Expense'))
            ->sum('amount');


        // --- 2. Chart Data ---

        $months = [];
        $incomeData = [];
        $expenseData = [];

        // Trend Data (Last 6 Months)
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');

            $incomeData[] = Transaction::whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->whereHas('debitCategory', fn($q) => $q->where('type', 'Income'))
                ->sum('amount');

            $expenseData[] = Transaction::whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->whereHas('debitCategory', fn($q) => $q->where('type', 'Expense'))
                ->sum('amount');
        }

        // Expense Breakdown (Pie Chart)
        $expenseBreakdown = Transaction::whereHas('debitCategory', fn($q) => $q->where('type', 'Expense'))
            ->join('categories', 'transactions.debit_category_id', '=', 'categories.category_id')
            ->select('categories.category_name', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.category_name')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();


        // --- 3. Table Data ---

        $recentTransactions = Transaction::with(['debitCategory', 'creditCategory'])
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalCash',
            'monthlyIncome',
            'monthlyExpense',
            'months',
            'incomeData',
            'expenseData',
            'expenseBreakdown',
            'recentTransactions'
        ));
    }
}
