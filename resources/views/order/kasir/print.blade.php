<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        #receipt {
            width: 400px; /* Lebar struk diperbesar */
            padding: 20px;
            margin: 0 auto;
            font-size: 1rem; /* Ukuran font sedikit lebih besar */
            color: #333;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        #top {
            text-align: center;
            margin-bottom: 30px;
        }

        #top h2 {
            font-size: 1.5rem; /* Ukuran font judul lebih besar */
            margin: 0;
            font-weight: normal;
        }

        #top .info {
            font-size: 1rem;
            margin: 0;
        }

        #top .info p {
            margin: 0;
        }

        #back-wrap {
            margin: 20px 0;
            text-align: center;
        }

        .btn-back {
            padding: 8px 15px;
            color: #fff;
            background: #666;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn-back:hover {
            background-color: #444;
        }

        #mid {
            margin-top: 30px;
        }

        #mid .info p {
            margin: 0;
            font-size: 1rem;
            color: #555;
        }

        #bot {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem; /* Ukuran font tabel lebih besar */
        }

        td {
            padding: 8px;
            text-align: left;
        }

        td:last-child {
            text-align: right;
        }

        .tabletitle {
            font-weight: bold;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .service {
            border-bottom: 1px solid #ddd;
        }

        .total-price {
            font-weight: bold;
        }

        .payment {
            font-weight: bold;
            font-size: 1.2rem; /* Ukuran font harga lebih besar */
            text-align: center;
        }

        .btn-print {
            display: block;
            margin: 20px auto;
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-print:hover {
            background-color: #444;
        }

        .legalcopy {
            font-size: 1rem;
            color: #555;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div id="back-wrap">
        <a href="{{ route('pembelian') }}" class="btn-back">Kembali</a>
    </div>

    <div id="receipt">
        <div id="top">
            <h2>Apotek Jaya Abadi</h2>
            <div class="info">
                <p>Alamat: sepanjang jalan kenangan</p>
                <p>Email: apotekjayaabadi@gmail.com</p>
                <p>Phone: 000-111-2222</p>
            </div>
        </div>

        <div id="mid">
            <table>
                <tr class="tabletitle">
                    <td>Obat</td>
                    <td>Total</td>
                    <td>Harga</td>
                </tr>

                @foreach ($order['medicines'] as $medicine)
                <tr class="service">
                    <td>{{ $medicine['name_medicine'] }}</td>
                    <td>{{ $medicine['qty'] }}</td>
                    <td>Rp. {{ number_format($medicine['price'], 0, ',', '.') }}</td>
                </tr>
                @endforeach

                <tr class="tabletitle">
                    <td></td>
                    <td>PPN (10%)</td>
                    @php
                        $ppn = $order['total_price'] * 0.01;
                    @endphp
                    <td>Rp. {{ number_format($ppn, 0, ',', '.') }}</td>
                </tr>

                <tr class="tabletitle">
                    <td></td>
                    <td>Total Harga</td>
                    <td>Rp. {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div id="bot">
            <p class="payment">Terima kasih atas pembelian Anda!</p>
            <a href="{{ route('download-pdf', $order->id) }}" class="btn-print">Cetak (.pdf)</a>
        </div>

        <div class="legalcopy">
            <p><strong>Apotek Jaya Abadi</strong><br>Alamat: sepanjang jalan kenangan</p>
        </div>
        
    </div>
    

</body>
</html>
