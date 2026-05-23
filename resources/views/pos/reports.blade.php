<!DOCTYPE html>
<html>
<head>
<title>Analytics - Warung POS</title>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:Arial;
}

body{
    background:#f8f5f2;
    color:#2b1b16;
}

.app{
    display:grid;
    grid-template-columns:240px 1fr;
    min-height:100vh;
}

.sidebar{
    background:white;
    padding:30px 20px;
    border-right:1px solid #eee;
    position:relative;
}

.logo{
    font-size:28px;
    font-weight:900;
    color:#9f1239;
    display:flex;
    align-items:center;
    gap:8px;
}

.sub{
    color:#666;
    margin:8px 0 35px;
}

.nav{
    display:flex;
    flex-direction:column;
    gap:10px;
    margin-top:30px;
}

.nav a{
    text-decoration:none;
    color:#2d1f1f;
    padding:14px 16px;
    border-radius:16px;
    font-weight:700;
    display:flex;
    align-items:center;
    gap:10px;
    transition:.2s;
}

.nav a:hover{
    background:#f3e9df;
}

.nav a.active{
    background:#9f1239!important;
    color:white!important;
    box-shadow:0 8px 18px rgba(159,18,57,.25);
}

.nav a i{
    font-size:20px;
}

.logout{
    position:absolute;
    bottom:30px;
    left:20px;
    right:20px;
}

.clear{
    background:#f3e9df;
    border:none;
    border-radius:16px;
    padding:14px;
    width:100%;
    font-weight:bold;
    cursor:pointer;
    transition:.2s;
}

.clear:hover{
    background:#9f1239;
    color:white;
}

.main{
    padding:30px;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.print-btn{
    background:#9f1239;
    color:white;
    border:none;
    border-radius:14px;
    padding:14px 18px;
    font-weight:bold;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:8px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat,
.card{
    background:white;
    border:1px solid #eadbd6;
    border-radius:22px;
    padding:24px;
}

.stat h3{
    color:#6b5148;
    margin-bottom:12px;
    font-size:16px;
}

.stat strong{
    font-size:34px;
    color:#9f1239;
}

.stat p{
    margin-top:12px;
    color:#16a34a;
    font-weight:bold;
}

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
    margin-bottom:25px;
}

.bottom{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

.card h2{
    margin-bottom:20px;
}

.chart-box{
    height:340px;
}

canvas{
    width:100%!important;
    height:100%!important;
}

.item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #eee;
    padding:14px 0;
}

.item:last-child{
    border-bottom:none;
}

.item small{
    color:#666;
}

.price{
    color:#d69b00;
    font-weight:bold;
}

.status{
    padding:6px 12px;
    border-radius:999px;
    font-size:13px;
}

.green{
    background:#dcfce7;
    color:#15803d;
}

@media(max-width:1100px){

    .app{
        grid-template-columns:1fr;
    }

    .stats{
        grid-template-columns:repeat(2,1fr);
    }

    .grid,
    .bottom{
        grid-template-columns:1fr;
    }

}

@media print{

    body{
        background:white;
    }

    .sidebar,
    .print-btn{
        display:none!important;
    }

    .app{
        display:block;
    }

    .main{
        padding:0;
    }

    .stat,
    .card{
        break-inside:avoid;
        page-break-inside:avoid;
        box-shadow:none;
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

$avgOrder = $totalOrders > 0
    ? $totalSales / $totalOrders
    : 0;

$bestProduct = count($bestSelling) > 0
    ? $bestSelling[0]->UrunAdi
    : '-';
@endphp

<div class="app">

<aside class="sidebar">

    <div class="logo">
        <i class='bx bxs-store'></i>
        Warung POS
    </div>

    <div class="sub">
        Premium Restaurant System
    </div>

    <div class="nav">
    <a href="{{ route('pos.tables') }}">
    <i class="bx bx-table"></i> Tables
</a>

        <a href="{{ route('pos.index') }}">
            <i class='bx bx-cart'></i>
            POS Order
        </a>

        <a href="{{ route('pos.manageProducts') }}">
            <i class='bx bx-food-menu'></i>
            Products
        </a>

        <a href="{{ route('pos.manageStaff') }}">
            <i class='bx bx-group'></i>
            Staff
        </a>

        <a class="active" href="{{ route('pos.reports') }}">
            <i class='bx bx-bar-chart-alt-2'></i>
            Analytics
        </a>

    </div>

    <form class="logout"
          method="POST"
          action="{{ route('pos.logout') }}">
        @csrf

        <button class="clear">
            <i class='bx bx-log-out'></i>
            Logout
        </button>
    </form>

</aside>

<main class="main">

    <div class="topbar">

        <div>
            <h1>Analytics Dashboard</h1>
            <p style="color:#666;margin-top:6px;">
                Restaurant sales performance overview
            </p>
        </div>

        <button class="print-btn"
                onclick="window.print()">
            <i class='bx bx-printer'></i>
            Print Report
        </button>

    </div>

    <div class="stats">

        <div class="stat">
            <h3>Total Revenue</h3>
            <strong>
                ₺ {{ number_format($totalSales,2) }}
            </strong>
            <p>↗ From sales report</p>
        </div>

        <div class="stat">
            <h3>Total Orders</h3>
            <strong>{{ $totalOrders }}</strong>
            <p>↗ Completed orders</p>
        </div>

        <div class="stat">
            <h3>Best Product</h3>
            <strong style="font-size:24px;">
                {{ $bestProduct }}
            </strong>
            <p>↗ Top selling item</p>
        </div>

        <div class="stat">
            <h3>Avg Order Value</h3>
            <strong>
                ₺ {{ number_format($avgOrder,2) }}
            </strong>
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

    @foreach($recentTransactions as $trx)
        <div class="item">
            <div>
                <strong>Order #{{ $trx->SatisID }}</strong><br>
                <small>{{ $trx->SatisTarihiSaat }}</small><br>
                <small>{{ $trx->SatisTipi }} @if($trx->MasaNo) - Table {{ $trx->MasaNo }} @endif</small><br>
                <small>Cashier: {{ $trx->Ad }} {{ $trx->Soyad }}</small>
            </div>

            <div style="text-align:right;">
                <span class="status green">{{ $trx->OdemeYontemi }}</span><br><br>
                <div class="price">₺ {{ number_format($trx->ToplamTutar,2) }}</div>
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

    type:'bar',

    data:{
        labels:labels,

        datasets:[{
            label:'Revenue',
            data:salesData,
            backgroundColor:'#9f1239',
            borderRadius:10,
            maxBarThickness:60
        }]
    },

    options:{
        responsive:true,
        maintainAspectRatio:false
    }

});

new Chart(document.getElementById('ordersChart'), {

    type:'bar',

    data:{
        labels:labels,

        datasets:[{
            label:'Orders',
            data:orderData,
            backgroundColor:'#d6a51d',
            borderRadius:10,
            maxBarThickness:60
        }]
    },

    options:{
        responsive:true,
        maintainAspectRatio:false
    }

});

</script>

</body>
</html>