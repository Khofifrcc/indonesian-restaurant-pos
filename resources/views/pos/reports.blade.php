<!DOCTYPE html>
<html>
<head>
<title>Analytics - Warung POS</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    @media print{
    .sidebar,
    button{
        display:none !important;
    }

    .app{
        display:block;
    }

    .main{
        padding:0;
    }

    body{
        background:white;
    }

    .card,
    .stat{
        box-shadow:none;
        page-break-inside:avoid;
    }
}
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
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:25px}
.stat,.card{background:white;border:1px solid #eadbd6;border-radius:20px;padding:24px;box-shadow:0 4px 12px rgba(0,0,0,.04)}
.stat h3{color:#6b5148;font-size:16px;margin-bottom:12px}
.stat strong{font-size:34px;color:#9f1239}
.stat p{margin-top:12px;color:#16a34a;font-weight:bold}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:25px;margin-bottom:25px}
.bottom{display:grid;grid-template-columns:1fr 1fr;gap:25px}
.card h2{margin-bottom:20px}
.item{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding:14px 0}
.item small{color:#666}
.price{color:#d69b00;font-weight:bold}
.status{padding:6px 12px;border-radius:999px;font-size:13px}
.green{background:#dcfce7;color:#15803d}
button{border:0;border-radius:14px;padding:13px 18px;background:#9f1239;color:white;font-weight:bold;cursor:pointer}
.clear{background:#f3e9df;color:#2b1b16;width:100%}
.chart-box{height:300px}
canvas{width:100%!important;height:100%!important}
@media print{

body{
    background:white !important;
}

.sidebar,
.logout,
button{
    display:none !important;
}

.app{
    display:block !important;
}

.main{
    padding:0 !important;
}

.stats{
    grid-template-columns:repeat(4,1fr) !important;
}

.grid,
.bottom{
    grid-template-columns:1fr 1fr !important;
}

.stat,
.card{
    break-inside:avoid;
    page-break-inside:avoid;
    box-shadow:none !important;
}

canvas{
    max-height:250px !important;
}

h1{
    margin-bottom:10px;
}
}
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

    $avgOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
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
    <p style="color:#666;margin-bottom:25px;">Restaurant sales performance overview</p>
    <button onclick="window.print()" style="margin:15px 0;">
    🖨 Print Report
</button>
    <div class="stats">
        <div class="stat">
            <h3>Total Revenue</h3>
            <strong>₺ {{ number_format($totalSales,2) }}</strong>
            <p>↗ From sales report</p>
        </div>

        <div class="stat">
            <h3>Total Orders</h3>
            <strong>{{ $totalOrders }}</strong>
            <p>↗ Completed orders</p>
        </div>

        <div class="stat">
            <h3>Best Product</h3>
            <strong style="font-size:26px;">{{ $bestProduct }}</strong>
            <p>↗ Top selling item</p>
        </div>

        <div class="stat">
            <h3>Avg Order Value</h3>
            <strong>₺ {{ number_format($avgOrder,2) }}</strong>
            <p>↗ Calculated</p>
        </div>
    </div>

    <div class="grid">
        <div class="card">
            <h2>Daily Sales Revenue</h2>
            <div class="chart-box">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="card">
            <h2>Daily Order Count</h2>
            <div class="chart-box">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bottom">

        <div class="card">
            <h2>Best Selling Menu</h2>

            @foreach($bestSelling as $row)
                <div class="item">
                    <div>
                        <strong>{{ $row->UrunAdi }}</strong><br>
                        <small>{{ $row->ToplamAdet }} sold</small>
                    </div>

                    <div class="price">
                        ₺ {{ number_format($row->ToplamGelir,2) }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card">
            <h2>Recent Transactions</h2>

            @foreach($bestSelling as $row)
                <div class="item">
                    <div>
                        <strong>{{ $row->UrunAdi }}</strong><br>
                        <small>{{ $row->ToplamAdet }} item sold</small>
                    </div>

                    <div style="text-align:right;">
                        <span class="status green">Completed</span><br><br>
                        <div class="price">₺ {{ number_format($row->ToplamGelir,2) }}</div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</main>

</div>

<script>
const labels = [
@foreach($daily as $row)
    "{{ $row->Tarih }}",
@endforeach
];

const salesData = [
@foreach($daily as $row)
    {{ $row->GunlukToplam }},
@endforeach
];

const orderData = [
@foreach($daily as $row)
    {{ $row->SatisSayisi }},
@endforeach
];

new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Revenue',
            data: salesData,
            backgroundColor: '#9f1239',
            borderRadius: 10,
            maxBarThickness: 80
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

new Chart(document.getElementById('ordersChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Orders',
            data: orderData,
            backgroundColor: '#d6a51d',
            borderRadius: 10,
            maxBarThickness: 80
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>


</body>
</html>