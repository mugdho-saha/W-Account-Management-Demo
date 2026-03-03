<!DOCTYPE html>
<html>
<head>
    <title>Balance Sheet</title>
    <style>
        /* Essential for Taka Symbol rendering in DomPDF */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .text-end { text-align: right; }
        .bg-light { background-color: #f4f4f4; }
        .fw-bold { font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
        .border-double { border-top: 3px double #000; }
    </style>
</head>
<body>
<div class="header">
    <h2>Company Name</h2>
    <h3>Balance Sheet</h3>
    <p>As of {{ date('d M, Y', strtotime($as_of_date)) }}</p>
</div>

<table>
    <thead>
    <tr class="bg-light">
        <th>Account Description</th>
        <th class="text-end">Balance (BDT)</th>
    </tr>
    </thead>
    <tbody>
    <tr><td colspan="2" class="fw-bold">ASSETS</td></tr>
    @foreach($assets as $asset)
        <tr>
            <td style="padding-left: 20px;">{{ $asset->category_name }}</td>
            <td class="text-end">BDT {{ number_format($asset->balance, 2) }}</td>
        </tr>
    @endforeach
    <tr class="fw-bold bg-light">
        <td>TOTAL ASSETS</td>
        <td class="text-end">BDT {{ number_format($assets->sum('balance'), 2) }}</td>
    </tr>

    <tr><td colspan="2" class="fw-bold">LIABILITIES & EQUITY</td></tr>
    @foreach($liabilities as $l)
        <tr><td style="padding-left: 20px;">{{ $l->category_name }}</td><td class="text-end">BDT {{ number_format($l->balance, 2) }}</td></tr>
    @endforeach
    @foreach($equity as $e)
        <tr><td style="padding-left: 20px;">{{ $e->category_name }}</td><td class="text-end">BDT {{ number_format($e->balance, 2) }}</td></tr>
    @endforeach

    <tr class="fw-bold" style="background: #333; color: #fff;">
        <td>TOTAL LIABILITIES & EQUITY</td>
        <td class="text-end border-double">BDT {{ number_format($liabilities->sum('balance') + $equity->sum('balance'), 2) }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
