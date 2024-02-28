<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Keluar</title>
    <style>
        /* Add custom styles here */
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
            padding: 0px;
            font-family: Arial, sans-serif;
        }
        .container {
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Laporan Barang Keluar</h2>
    <table class="table">
        <thead>
        <tr>
            <th>No</th>
            <th>No.Transaksi</th>
            <th>Nama Distributor</th>
            <th>Nama Customer</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Total</th>
            <th>User</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($laporan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->no }}</td>
                <td>{{ $item->distributor->nama_distributor }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->barangs->nama }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->barangs->harga }}</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->user->name }}</td>
                @if($item->status === 0)
                    <td>
                        <span class="badge bg-warning">Pending</span>
                    </td>
                @else
                    <td>
                        <span class="badge bg-success">Approved</span>
                    </td>
                @endif
                <td>{{ $item->tanggal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
