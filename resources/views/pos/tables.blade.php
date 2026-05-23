<!DOCTYPE html>
<html>
<head>
<title>Tables - Warung POS</title>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial}
body{background:#f8f5f2;color:#2b1b16}
.app{display:grid;grid-template-columns:240px 1fr;min-height:100vh}

.sidebar{background:white;padding:30px 20px;border-right:1px solid #eee;position:relative}
.logo{font-size:28px;font-weight:900;color:#9f1239;display:flex;gap:8px;align-items:center}
.sub{color:#666;margin:8px 0 35px}

.nav{display:flex;flex-direction:column;gap:10px;margin-top:30px}
.nav a{text-decoration:none;color:#2d1f1f;padding:14px 16px;border-radius:16px;font-weight:700;display:flex;align-items:center;gap:10px}
.nav a:hover{background:#f3e9df}
.nav a.active{background:#9f1239!important;color:white!important}
.nav a i{font-size:20px}

.logout{position:absolute;bottom:30px;left:20px;right:20px}
.clear{background:#f3e9df;border:none;border-radius:16px;padding:14px;width:100%;font-weight:bold;cursor:pointer}
.clear:hover{background:#9f1239;color:white}

.main{padding:30px}
.stats{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin:25px 0}
.stat{background:white;border:1px solid #eadbd6;border-radius:20px;padding:22px}
.stat h3{color:#6b5148;margin-bottom:10px}
.stat strong{font-size:32px;color:#9f1239}

.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px}
.table-card{background:white;border:1px solid #eadbd6;border-radius:22px;padding:28px;text-align:center;text-decoration:none;color:#2b1b16;transition:.2s}
.table-card:hover{transform:translateY(-4px);box-shadow:0 10px 20px rgba(0,0,0,.08)}
.table-card i{font-size:44px;margin-bottom:12px;color:#9f1239}
.table-card h2{margin-bottom:10px}
.status{display:inline-block;padding:8px 14px;border-radius:999px;font-size:13px;font-weight:bold}
.available{background:#dcfce7;color:#15803d}
</style>
</head>

<body>

<div class="app">

<aside class="sidebar">
    <div class="logo">
        <i class="bx bxs-store"></i> Warung POS
    </div>

    <div class="sub">Premium Restaurant System</div>

    <div class="nav">
        <a href="{{ route('pos.index') }}">
        <a class="active" href="{{ route('pos.tables') }}">
            <i class="bx bx-table"></i> Tables
        </a>
        <a>
            <i class="bx bx-cart"></i> POS Order
        </a>

       

        <a href="{{ route('pos.manageProducts') }}">
            <i class="bx bx-food-menu"></i> Products
        </a>

        <a href="{{ route('pos.manageStaff') }}">
            <i class="bx bx-group"></i> Staff
        </a>

        <a href="{{ route('pos.reports') }}">
            <i class="bx bx-bar-chart-alt-2"></i> Analytics
        </a>
    </div>

    <form class="logout" method="POST" action="{{ route('pos.logout') }}">
        @csrf
        <button class="clear">
            <i class="bx bx-log-out"></i> Logout
        </button>
    </form>
</aside>

<main class="main">

    <h1>Table Selection</h1>
    <p style="color:#666;margin-top:6px;">Select a table for dine-in order</p>

    <div class="stats">
        <div class="stat">
            <h3>Total Tables</h3>
            <strong>{{ count($tables) }}</strong>
        </div>

        <div class="stat">
            <h3>Status</h3>
            <strong style="color:#16a34a;">Available</strong>
        </div>
    </div>

    <div class="grid">
        @foreach($tables as $table)
            <a class="table-card" href="{{ route('pos.selectTable', $table) }}">
                <i class="bx bx-table"></i>
                <h2>Table {{ $table }}</h2>
                <span class="status available">Available</span>
            </a>
        @endforeach
    </div>

</main>

</div>

</body>
</html>