<!DOCTYPE html>
<html>
<head>
<title>Staff - Warung POS</title>
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
.card{background:white;padding:22px;border-radius:20px;margin-bottom:22px;border:1px solid #eee}
input,select{width:100%;padding:14px;border-radius:14px;border:1px solid #eee;margin:8px 0 16px}
button{border:0;border-radius:14px;padding:13px 18px;background:#9f1239;color:white;font-weight:bold;cursor:pointer}
.delete{background:#dc2626}
.clear{background:#f3e9df;color:#2b1b16;width:100%}
table{width:100%;border-collapse:collapse}
th{background:#111827;color:white;padding:14px}
td{padding:14px;border-bottom:1px solid #eee}
.success{background:#dcfce7;color:#166534;padding:14px;border-radius:14px;margin-bottom:18px}
</style>
</head>
<body>

<div class="app">

<aside class="sidebar">
    <div class="logo">🍴 Warung POS</div>
    <div class="sub">Premium Restaurant System</div>

    <div class="nav">
        <a href="{{ route('pos.index') }}">🛒 POS Order</a>
        <a href="{{ route('pos.manageProducts') }}">🍔 Products</a>
        <a class="active" href="{{ route('pos.manageStaff') }}">👨‍🍳 Staff</a>
        <a href="{{ route('pos.reports') }}">📊 Analytics</a>
    </div>

    <form class="logout" method="POST" action="{{ route('pos.logout') }}">
        @csrf
        <button class="clear">Logout</button>
    </form>
</aside>

<main class="main">

    <h1>Staff Management</h1>
    <p style="margin-bottom:25px;color:#666;">Add and manage restaurant staff</p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <h2>Add Staff</h2>

        <form method="POST" action="{{ route('pos.addStaff') }}">
            @csrf

            <input type="text" name="ad" placeholder="Ad" required>
            <input type="text" name="soyad" placeholder="Soyad" required>
            <input type="text" name="telefon" placeholder="Telefon" required>

            <select name="gorev">
                <option value="Kasiyer">Kasiyer</option>
                <option value="Yönetici">Yönetici</option>
            </select>

            <button type="submit">Add Staff</button>
        </form>
    </div>

    <div class="card">
        <h2>Staff List</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Telefon</th>
                <th>Görev</th>
                <th>Aktif</th>
                <th>İşlem</th>
            </tr>

            @foreach($staff as $person)
                <tr>
                    <td>{{ $person->PersonelID }}</td>
                    <td>{{ $person->Ad }}</td>
                    <td>{{ $person->Soyad }}</td>
                    <td>{{ $person->Telefon }}</td>
                    <td>{{ $person->Gorev }}</td>
                    <td>{{ $person->AktifMi }}</td>
                    <td>
                        <form method="POST" action="{{ route('pos.deleteStaff', $person->PersonelID) }}">
                            @csrf
                            <button class="delete">Delete</button>
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