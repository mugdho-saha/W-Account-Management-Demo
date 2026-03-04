@extends('layouts.theme')

@section('content')
    <style>
        .nk-ck, .nk-ck-sm {
            position: relative;
            height: 250px; /* Force a height */
            width: 100%;
        }
    </style>

    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Financial Overview</h3>
                    <div class="nk-block-des text-soft">
                        <p>Welcome to your accounting dashboard.</p>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="row g-gs">
                    {{-- Card: Total Cash --}}
                    <div class="col-md-4">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-0">
                                    <div class="card-title"><h6 class="subtitle">Total Cash Position</h6></div>
                                </div>
                                <div class="card-amount">
                                    <span class="amount taka-font">৳ {{ number_format($totalCash, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Monthly Income --}}
                    <div class="col-md-4">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-0">
                                    <div class="card-title"><h6 class="subtitle">Income (This Month)</h6></div>
                                </div>
                                <div class="card-amount">
                                    <span class="amount text-success taka-font">৳ {{ number_format($monthlyIncome, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Monthly Expense --}}
                    <div class="col-md-4">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-0">
                                    <div class="card-title"><h6 class="subtitle">Expense (This Month)</h6></div>
                                </div>
                                <div class="card-amount">
                                    <span class="amount text-danger taka-font">৳ {{ number_format($monthlyExpense, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="row g-gs">
                    {{-- Trend Chart (Line) --}}
                    <div class="col-lg-8">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Financial Performance</h6>
                                        <p>Income vs Expense trend for the last 6 months.</p>
                                    </div>
                                </div>
                                <div class="nk-ck">
                                    {{-- Use a unique ID for our custom data --}}
                                    <canvas class="line-chart" id="financeTrendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Distribution Chart (Doughnut) --}}
                    <div class="col-lg-4">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Expense Breakdown</h6>
                                    </div>
                                </div>
                                <div class="nk-ck-sm">
                                    <canvas class="doughnut-chart" id="expenseDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Transactions Table --}}
            <div class="nk-block mt-4">
                <div class="card card-bordered card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title"><h5 class="title">Recent Transactions</h5></div>
                            </div>
                        </div>
                        <div class="card-inner p-0">
                            <table class="table table-tranx">
                                <thead>
                                <tr class="tb-tnx-head">
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentTransactions as $tnx)
                                    <tr class="tb-tnx-item">
                                        <td>{{ $tnx->date }}</td>
                                        <td>{{ $tnx->description }}</td>
                                        <td>{{ $tnx->debitCategory->category_name ?? 'N/A' }}</td>
                                        <td class="text-end taka-font">৳ {{ number_format($tnx->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Essential for Taka Symbol rendering */
        .taka-font {
            font-family: "DejaVu Sans", sans-serif !important;
        }
    </style>

        <script>
            // This ensures we wait for the browser to finish loading scripts
            window.addEventListener('load', function() {
                console.log("Checking data...", @json($incomeData)); // Check your console (F12) for this!

                // 1. Line Chart
                var ctxLine = document.getElementById('financeTrendChart');
                if(ctxLine) {
                    new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: @json($months),
                            datasets: [
                                {
                                    label: "Income",
                                    data: @json($incomeData),
                                    borderColor: "#1ee0ac",
                                    backgroundColor: "rgba(30, 224, 172, 0.1)",
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: "Expense",
                                    data: @json($expenseData),
                                    borderColor: "#e85347",
                                    backgroundColor: "rgba(232, 83, 71, 0.1)",
                                    fill: true,
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: true }
                            }
                        }
                    });
                }

                // 2. Doughnut Chart
                var ctxPie = document.getElementById('expenseDistributionChart');
                if(ctxPie) {
                    new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: @json($expenseBreakdown->pluck('category_name')),
                            datasets: [{
                                data: @json($expenseBreakdown->pluck('total')),
                                backgroundColor: ["#798bff", "#1ee0ac", "#f4bd0e", "#ffa500", "#ff6384"]
                            }]
                        },
                        options: {
                            maintainAspectRatio: false
                        }
                    });
                }
            });
        </script>
@endsection
