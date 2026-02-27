@extends('layouts.theme')
@section('title','Date-wise Report')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    {{-- Header Block --}}
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-head-content mb-3">
                            <h3 class="nk-block-title page-title">Date-wise Transaction Report</h3>
                        </div>

                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <div class="nk-block-des text-soft">
                                    <p>Showing data from <strong class="text-dark">{{ \Carbon\Carbon::parse($start_date)->format('d M, Y') }}</strong> to <strong class="text-dark">{{ \Carbon\Carbon::parse($end_date)->format('d M, Y') }}</strong></p>
                                </div>
                            </div>

                            <div class="nk-block-head-content">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <form action="{{ route('reports.datewise') }}" method="GET" class="d-flex g-2">
                                            <input type="date" name="start_date" class="form-control form-control-md" value="{{ $start_date }}" required>
                                            <input type="date" name="end_date" class="form-control form-control-md" value="{{ $end_date }}" required>
                                            <button type="submit" class="btn btn-primary">
                                                <em class="icon ni ni-funnel"></em><span>Filter</span>
                                            </button>
                                        </form>
                                    </li>

                                    <li>
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-white btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-download-cloud"></em><span>Export</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="{{ route('reports.datewise.export', ['start_date' => $start_date, 'end_date' => $end_date, 'type' => 'pdf']) }}"><em class="icon ni ni-file-pdf"></em><span>PDF</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <button onclick="window.print()" class="btn btn-white btn-outline-light">
                                            <em class="icon ni ni-printer"></em><span>Print</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Table Block --}}
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner p-0">
                                <div class="table-responsive">
                                    {{-- Notice: Standard Bootstrap classes 'table-bordered' replace 'table-tranx' --}}
                                    <table class="table table-bordered table-striped table-hover mb-0" id="report-table">
                                        <thead class="bg-light">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 15%">Date</th>
                                            <th style="width: 30%">Description</th>
                                            <th style="width: 15%">Debit Category</th>
                                            <th style="width: 15%">Credit Category</th>
                                            <th class="text-end" style="width: 20%">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($transactions as $tnx)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($tnx->date)->format('d-m-Y') }}</td>
                                                <td>{{ $tnx->description }}</td>
                                                <td><span class="text-danger font-weight-bold">{{ $tnx->debitCategory->category_name }}</span></td>
                                                <td><span class="text-success font-weight-bold">{{ $tnx->creditCategory->category_name }}</span></td>
                                                <td class="text-end font-weight-bold taka-font">
                                                    ৳ {{ number_format($tnx->amount, 2) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center p-5 text-muted">
                                                    No transactions found for the selected period.
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                        @if($transactions->count() > 0)
                                            <tfoot class="bg-light">
                                            <tr>
                                                <td colspan="5" class="text-end font-weight-bold">Grand Total:</td>
                                                <td class="text-end text-primary font-weight-bold taka-font">
                                                    ৳ {{ number_format($transactions->sum('amount'), 2) }}
                                                </td>
                                            </tr>
                                            </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* CSS to fix '?' symbol issue and single-row print alignment */
        .taka-font {
            font-family: "DejaVu Sans", sans-serif !important;
        }

        @media print {
            /* Hide UI elements */
            .nk-sidebar, .nk-header, .nk-block-tools, .form-control, .btn, .nk-footer, .nk-block-head-content:has(form) {
                display: none !important;
            }

            .nk-content {
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Reset Table to Standard Behavior */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
                table-layout: fixed !important; /* Forces columns to respect widths */
            }

            th, td {
                display: table-cell !important; /* Crucial: Prevents the stacking you saw */
                border: 1px solid #dbdfea !important;
                padding: 6px !important;
                font-size: 10pt !important;
                vertical-align: middle !important;
            }

            .taka-font, td, th {
                font-family: "DejaVu Sans", sans-serif !important; /* Prevents '?' issue */
            }

            /* Ensure background colors for total row show in print */
            .bg-light {
                background-color: #f5f6fa !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
@endsection
