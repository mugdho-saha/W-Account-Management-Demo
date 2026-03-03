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
                            <h3 class="nk-block-title page-title">Balance Sheet Report</h3>
                        </div>

                        <div class="nk-block-between g-3">

                            <div class="nk-block-head-content">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-white btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-download-cloud"></em><span>Export</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="{{ route('reports.balancesheet.export') }}"><em class="icon ni ni-file-pdf"></em><span>PDF</span></a></li>
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
                                    <table class="table table-bordered table-report">
                                        <thead class="bg-light">
                                        <tr>
                                            <th>Account Description</th>
                                            <th class="text-end">Amount (BDT)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{-- ASSETS SECTION --}}
                                        <tr class="bg-lighter">
                                            <td colspan="2"><strong>ASSETS</strong></td>
                                        </tr>
                                        @foreach($assets as $asset)
                                            <tr>
                                                <td class="ps-4 italic">{{ $asset->category_name }}</td>
                                                <td class="text-end taka-font">৳ {{ number_format($asset->balance, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="font-weight-bold">
                                            <td>Total Assets</td>
                                            <td class="text-end border-top-double taka-font">৳ {{ number_format($assets->sum('balance'), 2) }}</td>
                                        </tr>

                                        {{-- LIABILITIES SECTION --}}
                                        <tr class="bg-lighter">
                                            <td colspan="2"><strong>LIABILITIES</strong></td>
                                        </tr>
                                        @foreach($liabilities as $liability)
                                            <tr>
                                                <td class="ps-4">{{ $liability->category_name }}</td>
                                                <td class="text-end taka-font">৳ {{ number_format($liability->balance, 2) }}</td>
                                            </tr>
                                        @endforeach

                                        {{-- EQUITY SECTION --}}
                                        <tr class="bg-lighter">
                                            <td colspan="2"><strong>EQUITY</strong></td>
                                        </tr>
                                        @foreach($equity as $eq)
                                            <tr>
                                                <td class="ps-4">{{ $eq->category_name }}</td>
                                                <td class="text-end taka-font">৳ {{ number_format($eq->balance, 2) }}</td>
                                            </tr>
                                        @endforeach

                                        <tr class="bg-dark text-white">
                                            <td><strong>TOTAL LIABILITIES & EQUITY</strong></td>
                                            <td class="text-end taka-font"><strong>৳ {{ number_format($liabilities->sum('balance') + $equity->sum('balance'), 2) }}</strong></td>
                                        </tr>
                                        </tbody>
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
