<!DOCTYPE html>
<html>
<head>
    <title>Transaction Report: {{ $start_date }} to {{ $end_date }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .main-table { width: 100%; border-collapse: collapse; }
        .main-table th { background: #f2f2f2; border: 1px solid #ccc; padding: 8px; text-align: left; }
        .main-table td { border: 1px solid #ccc; padding: 8px; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; font-size: 9px; color: #777; }
        .total-row { background: #eee; font-weight: bold; }
    </style>
</head>
<body>

<div class="header">
    <h2>Transaction Report</h2>
    <p>Period: {{ $start_date }} to {{ $end_date }}</p>
</div>

<table class="main-table">
    <thead>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Debit Category</th>
        <th>Credit Category</th>
        <th class="text-right">Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $tnx)
        <tr>
            <td>{{ \Carbon\Carbon::parse($tnx->date)->format('d-m-Y') }}</td>
            <td>{{ $tnx->description }}</td>
            <td>{{ $tnx->debitCategory->category_name }}</td>
            <td>{{ $tnx->creditCategory->category_name }}</td>
            <td class="text-right">BDT {{ number_format($tnx->amount, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr class="total-row">
        <td colspan="4" class="text-right">GRAND TOTAL</td>
        <td class="text-right">BDT {{ number_format($transactions->sum('amount'), 2) }}</td>
    </tr>
    </tfoot>
</table>

<div class="footer">
    Generated on: {{ now()->format('d M, Y h:i A') }} by {{ auth()->user()->name }}
</div>

</body>
</html>
