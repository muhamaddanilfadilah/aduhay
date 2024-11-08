@extends('layout.template')


@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-end">
        <a href="{{ route('tambah.pembelian')}}" class="btn btn-block btn-outline-success">Pembelian Baru</a>
    </div>
</div>

<h1 class="display-4 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 3.8rem; letter-spacing: 2px; color: rgb(72, 176, 74); text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3); animation: fadeIn 1.5s ease-in-out;">
    Selamat Datang, di menu pembelian!
</h1>

<!-- Horizontal Line with smooth animation -->
<hr class="my-4" style="border-color: #fff; width: 50%; margin: 20px auto; opacity: 0.6; transform: scaleX(0.8); animation: scaleLine 1.5s ease-in-out forwards;">

<!-- Description with smooth fade-in -->
<p style="font-size: 1.3rem; color: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.8; animation: fadeIn 2s ease-in-out;">
    Aplikasi ini digunakan hanya oleh pegawai administrator APOTEK. Digunakan untuk mengelola data obat, penyetokan, juga pembelian (kasir). Dengan tampilan yang bersih dan intuitif, nikmati pengalaman pengelolaan obat yang lebih cepat dan efisien.
</p>

<!-- Floating circles for added elegance -->
<div class="floating-circle" style="position: absolute; bottom: -60px; left: -60px; width: 100px; height: 100px; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2); animation: floatCircle 6s ease-in-out infinite;"></div>
<div class="floating-circle" style="position: absolute; top: -60px; right: -60px; width: 100x; height: 100px; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2); animation: floatCircle 6s ease-in-out infinite;"></div>
</div>

<!-- Stylish Section for Features -->
<div class="container mt-5 text-center">
<h2 style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #28a745; font-size: 2.5rem; margin-bottom: 30px; text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);">
    Klik pojok kanan atas untuk melakukan pembelian
</h2>

<div class="row justify-content-center">
    
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Pembeli</th>
                <th>Obat</th>
                <th>Total Bayar</th>
                <th>Kasir</th>
                <th>Tanggal Beli</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($orders as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $item['name_customer'] }}</td>
                <td>
                    {{-- karena kolom medicines pada tabel orders bertipe JSON yang diubah formatnya menjadi array, maka untuk mengakses/menampilkan item-nya perlu menggunakan looping --}}
                    @foreach ($item['medicines'] as $medicine)
                <ol>
                    <li>
                         {{-- mengakses key array assoc dari tiap item array value column medicines --}}
            {{ $medicine['name_medicine'] }} ( Rp. {{ number_format($medicine['price'], 0, ',', '.') }} ) : Rp. {{ number_format($medicine['sub_price'], 0, ',', '.') }}
            <small>Qty {{ $medicine['qty'] }}</small>
        </li>
        @endforeach
    </ol>
</td>

<td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
{{-- karena nama kasir terdapat pada table users dan relasi antara order dan users telah didefinisikan pada function relasi bernama user, maka untuk mengakses column pada table users melalui relasi antara keduanya dapat dilakukan dengan $var['namaFuncRelasi']['columnDariTableLainnya'] --}}
<td>{{ $item['user']['name'] }}</td>
<td>{{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('j F Y') }}</td>
<td>
    <a href="{{ route('download-pdf', $item->id) }}" class="btn btn-secondary">Download Struk</a>
</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        {{-- jika data ada atau > 0 --}}
        @if ($orders->count() > 0)
            {{-- munculkan tampilan pagination --}}
            {{ $orders->links() }}
        @endif
    </div>
  
    
</div>
</div>

<!-- Animations -->
<style>
/* Animations */
@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes scaleLine {
    0% { transform: scaleX(0); }
    100% { transform: scaleX(1); }
}

@keyframes floatCircle {
    0% { transform: translateY(0); opacity: 0.1; }
    50% { transform: translateY(-30px); opacity: 0.5; }
    100% { transform: translateY(0); opacity: 0.1; }
}

/* Hover Effects for Cards */
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}
</style>
@endsection


{{-- 
@extends('layout.template')
@section('content')

<div class="container mt-3">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('tambah.pembelian') }}" class="btn btn-primary">Pembelian Baru</a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Pembeli</th>
                <th>Obat</th>
                <th>Total Bayar</th>
                <th>Kasir</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($orders as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $item['name_customer'] }}</td>
                <td>
                    @foreach ($item['medicines'] as $medicine)
                <ol>
                    <li>
            {{ $medicine['name_medicine'] }} ( Rp. {{ number_format($medicine['price'], 0, ',', '.') }} ) : Rp. {{ number_format($medicine['sub_price'], 0, ',', '.') }}
            <small>Qty {{ $medicine['qty'] }}</small>
        </li>
        @endforeach
    </ol>
</td>

<td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
<td>{{ $item['user']['name'] }}</td>
<td>
    <a href="" class="btn btn-secondary">Download Struk</a>
</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        @if ($orders->count() > 0)
            {{ $orders->links() }}
        @endif
    </div>
@endse --}}
