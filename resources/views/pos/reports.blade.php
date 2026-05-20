<!DOCTYPE html>
<html>
<head>
<title>Analytics - Warung POS</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial}
body{background:#f8f5f2;color:#2b1b16}
.app{display:grid;grid-template-columns:240px 1fr;min-height:100vh}
.sidebar{background:white;padding:30px 20px;border-right:1px solid #eee;position:relative}
.logo{font-size:28px;font-weight:900;color:#9f1239}
.sub{color:#666;margin:8px 0 35px}
.nav a{display:block;padding:15px;border-radius:16px;text-decoration:none;color:#2b1b16;font-weight:bold;margin-bottom:12px}
.nav .active{background:#9f1239;color:white}
.logout{position:absolute;bottom:30px;left:20px;right:20px}
.main{padding:30px}
.cards{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:22px}
.card{background:white;padding:22px;border-radius:20px;margin-bottom:22px;border:1px solid #eee}
.stat{background:white;padding:24px;border-radius:20px;border:1px solid #eee}
.stat h3{color:#666;margin-bottom:10px}
.stat strong{font-size:32px;color:#9f1239}
button{border:0;border-radius:14px;padding:13px 18px;background:#9f1239;color:white;font-weight:bold;cursor:pointer}
.clear{background:#f3e9df;color:#2b1b16;width:100%}
table{width:100%;border-collapse:collapse;margin-top:15px}
th{background:#111827;color:white;padding:14px}
td{padding:14px;border-bottom:1px solid #eee}
</style>
</head>
<body>

@php
    $totalSales = 0;
    $totalOrders = 0;

    foreach($daily as $row){
        $totalSales += $row->GunlukToplam;
        $totalOrders += $row->SatisSayisi;
    }

    $bestProduct = count($bestSelling) > 0 ? $bestSelling[0]->UrunAdi : '-';
@endphp

<div class="app">

<aside class="sidebar">
    <div class="logo">🍴 Warung POS</div>
    <div class="sub">Premium Restaurant System</div>

    <div class="nav">
        <a href="{{ route('pos.index') }}">🛒 POS Order</a>
        <a href="{{ route('pos.manageProducts') }}">🍔 Products</a>
        <a href="{{ route('pos.manageStaff') }}">👨‍🍳 Staff</a>
        <a class="active" href="{{ route('pos.reports') }}">📊 Analytics</a>
    </div>

    <form class="logout" method="POST" action="{{ route('pos.logout') }}">
        @csrf
        <button class="clear">Logout</button>
    </form>
</aside>

<main class="main">

    <h1>Analytics Dashboard</h1>
    <p style="margin-bottom:25px;color:#666;">Daily sales and best selling products</p>

    <div class="cards">
        <div class="stat">
            <h3>Total Revenue</h3>
            <strong>₺ {{ number_format($totalSales,2) }}</strong>
        </div>

        <div class="stat">
            <h3>Total Orders</h3>
            <strong>{{ $totalOrders }}</strong>
        </div>

        <div class="stat">
            <h3>Best Product</h3>
            <strong>{{ $bestProduct }}</strong>
        </div>

        <div class="stat">
            <h3>Report Type</h3>
            <strong>POS</strong>
        </div>
    </div>

    <div class="card">
        <h2>Günlük Satış Raporu</h2>

        <table>
            <tr>
                <th>Tarih</th>
                <th>Satış Sayısı</th>
                <th>Günlük Toplam</th>
            </tr>

            @foreach($daily as $row)
                <tr>
                    <td>{{ $row->Tarih }}</td>
                    <td>{{ $row->SatisSayisi }}</td>
                    <td>₺ {{ number_format($row->GunlukToplam,2) }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="card">
        <h2>En Çok Satılan Ürünler</h2>

        <table>
            <tr>
                <th>Ürün</th>
                <th>Toplam Adet</th>
                <th>Toplam Gelir</th>
            </tr>

            @foreach($bestSelling as $row)
                <tr>
                    <td>{{ $row->UrunAdi }}</td>
                    <td>{{ $row->ToplamAdet }}</td>
                    <td>₺ {{ number_format($row->ToplamGelir,2) }}</td>
                </tr>
            @endforeach
        </table>
    </div>

</main>

</div>

</body>
</html>