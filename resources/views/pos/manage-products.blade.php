<!DOCTYPE html>
<html>
<head>
<title>Products - Warung POS</title>
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
.nav a.active{background:#9f1239!important;color:white!important;box-shadow:0 8px 18px rgba(159,18,57,.25)}
.nav a i{font-size:20px}

.logout{position:absolute;bottom:30px;left:20px;right:20px}
.clear{background:#f3e9df;border:none;border-radius:16px;padding:14px;width:100%;font-weight:bold;cursor:pointer}
.clear:hover{background:#9f1239;color:white}

.main{padding:30px}
.card{background:white;padding:22px;border-radius:20px;margin-bottom:22px;border:1px solid #eee}
input,select{width:100%;padding:14px;border-radius:14px;border:1px solid #eee;margin:8px 0 16px}
button{border:0;border-radius:14px;padding:13px 18px;background:#9f1239;color:white;font-weight:bold;cursor:pointer}
.delete{background:#dc2626}
table{width:100%;border-collapse:collapse}
th{background:#111827;color:white;padding:14px}
td{padding:14px;border-bottom:1px solid #eee}
.success{background:#dcfce7;color:#166534;padding:14px;border-radius:14px;margin-bottom:18px}
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
    <a href="{{ route('pos.tables') }}">
    <i class="bx bx-table"></i> Tables
</a>
        <a href="{{ route('pos.index') }}">
            <i class="bx bx-cart"></i> POS Order
        </a>

        <a class="active" href="{{ route('pos.manageProducts') }}">
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

    <h1>Product Management</h1>
    <p style="margin-bottom:25px;color:#666;">Add and manage restaurant menu items</p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <h2>Add Product</h2>

        <form method="POST" action="{{ route('pos.addProduct') }}">
            @csrf

            <input type="text" name="urun_adi" placeholder="Ürün Adı" required>
            <input type="number" step="0.01" name="birim_fiyat" placeholder="Fiyat" required>

            <select name="kategori_id">
                @foreach($categories as $category)
                    <option value="{{ $category->KategoriID }}">
                        {{ $category->KategoriAdi }}
                    </option>
                @endforeach
            </select>

            <button type="submit">
                <i class="bx bx-plus"></i> Add Product
            </button>
        </form>
    </div>

    <div class="card">
        <h2>Products</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Ürün</th>
                <th>Kategori</th>
                <th>Fiyat</th>
                <th>İşlem</th>
            </tr>

            @foreach($products as $product)
                <tr>
                    <td>{{ $product->UrunID }}</td>
                    <td>{{ $product->UrunAdi }}</td>
                    <td>{{ $product->KategoriAdi }}</td>
                    <td>₺ {{ number_format($product->BirimFiyat,2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('pos.deleteProduct', $product->UrunID) }}">
                            @csrf
                            <button class="delete">
                                <i class="bx bx-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

</main>

</div>

</body>
</html>