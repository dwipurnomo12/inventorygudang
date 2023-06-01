<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1, p{
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: center;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h1>Laporan Stok</h1>
    <p>Keterangan : {{ $selectedOption }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $index => $barang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->stok}}  {{ $barang->satuan->satuan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ auth()->user()->name }}<br>
        Tanggal: {{ date('d-m-Y') }}
    </div>
</body>
</html>
