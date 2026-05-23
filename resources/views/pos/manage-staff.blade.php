<!DOCTYPE html>
<html>
<head>
<title>Employees - Warung POS</title>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:28px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat{
    background:white;
    border:1px solid #eadbd6;
    border-radius:20px;
    padding:22px;
}

.stat h3{
    color:#6b5148;
    margin-bottom:12px;
}

.stat strong{
    font-size:30px;
    color:#9f1239;
}

.form-card{
    background:white;
    border:1px solid #eadbd6;
    border-radius:22px;
    padding:25px;
    margin-bottom:25px;
}

input,select{
    width:100%;
    padding:14px;
    border-radius:14px;
    border:1px solid #eadbd6;
    margin-bottom:14px;
}

.submit{
    background:#9f1239;
    color:white;
    border:0;
    border-radius:14px;
    padding:13px 20px;
    font-weight:bold;
    cursor:pointer;
}

.search{
    width:100%;
    padding:16px 20px;
    border-radius:18px;
    border:1px solid #eadbd6;
    margin-bottom:25px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
}

.employee{
    background:white;
    border:1px solid #eadbd6;
    border-radius:22px;
    padding:28px;
}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.avatar{
    width:58px;
    height:58px;
    border-radius:50%;
    background:#f3e1e8;
    color:#9f1239;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    font-weight:bold;
}

.actions{
    display:flex;
    gap:12px;
}

.icon-btn{
    border:0;
    background:white;
    font-size:20px;
    cursor:pointer;
}

.delete{
    color:red;
}

.edit{
    color:#d6a51d;
}

.name{
    font-size:24px;
    font-weight:800;
    margin-bottom:10px;
}

.role{
    color:#6b5148;
    font-size:17px;
    margin-bottom:24px;
}

.info{
    margin-bottom:12px;
    color:#2b1b16;
}

.status{
    display:inline-block;
    margin-top:18px;
    padding:8px 14px;
    border-radius:999px;
    font-weight:bold;
    font-size:13px;
}

.active-status{
    background:#dcfce7;
    color:#15803d;
}

.inactive-status{
    background:#fee2e2;
    color:#991b1b;
}

.success{
    background:#dcfce7;
    color:#166534;
    padding:14px;
    border-radius:14px;
    margin-bottom:18px;
}

@media(max-width:1100px){
    .app{
        grid-template-columns:1fr;
    }

    .grid{
        grid-template-columns:repeat(2,1fr);
    }
}
</style>
</head>

<body>

@php
$totalStaff = count($staff);
$activeStaff = collect($staff)->where('AktifMi', 'E')->count();
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

        <a class="active" href="{{ route('pos.manageStaff') }}">
            <i class='bx bx-group'></i>
            Staff
        </a>

        <a href="{{ route('pos.reports') }}">
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

    <div class="header">
        <div>
            <h1>Employee Management</h1>
            <p style="color:#6b5148;">
                Manage staff and employee status
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="stats">

        <div class="stat">
            <h3>Total Employees</h3>
            <strong>{{ $totalStaff }}</strong>
        </div>

        <div class="stat">
            <h3>Active Staff</h3>
            <strong style="color:#16a34a;">
                {{ $activeStaff }}
            </strong>
        </div>

        <div class="stat">
            <h3>Staff System</h3>
            <strong>POS</strong>
        </div>

    </div>

    <div class="form-card">

        <h2 style="margin-bottom:18px;">
            Add Employee
        </h2>

        <form method="POST"
              action="{{ route('pos.addStaff') }}">
            @csrf

            <input type="text"
                   name="ad"
                   placeholder="Ad"
                   required>

            <input type="text"
                   name="soyad"
                   placeholder="Soyad"
                   required>

            <input type="text"
                   name="telefon"
                   placeholder="Telefon"
                   required>

            <select name="gorev">
                <option value="Kasiyer">Kasiyer</option>
                <option value="Yönetici">Yönetici</option>
            </select>

            <button class="submit" type="submit">
                <i class='bx bx-plus'></i>
                Add Employee
            </button>

        </form>

    </div>

    <input class="search"
           id="staffSearch"
           placeholder="Search by name, position, or phone...">

    <div class="grid" id="staffGrid">

        @foreach($staff as $person)

            @php
                $fullName = $person->Ad . ' ' . $person->Soyad;
                $initial = strtoupper(substr($person->Ad,0,1));
                $isActive = $person->AktifMi == 'E';
            @endphp

            <div class="employee"
                 data-search="{{ strtolower($fullName . ' ' . $person->Telefon . ' ' . $person->Gorev) }}">

                <div class="top">

                    <div class="avatar">
                        {{ $initial }}
                    </div>

                    <div class="actions">

                        <button class="icon-btn edit">
                            <i class='bx bx-edit'></i>
                        </button>

                        <form method="POST"
                              action="{{ route('pos.deleteStaff', $person->PersonelID) }}">
                            @csrf

                            <button class="icon-btn delete"
                                    type="submit">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>

                    </div>

                </div>

                <div class="name">
                    {{ $fullName }}
                </div>

                <div class="role">
                    {{ $person->Gorev }}
                </div>

                <div class="info">
                    <i class='bx bx-phone'></i>
                    {{ $person->Telefon }}
                </div>

                <div class="info">
                    ID: {{ $person->PersonelID }}
                </div>

                @if($isActive)
                    <span class="status active-status">
                        active
                    </span>
                @else
                    <span class="status inactive-status">
                        inactive
                    </span>
                @endif

            </div>

        @endforeach

    </div>

</main>

</div>

<script>
document.getElementById('staffSearch').addEventListener('input', function(){

    const keyword = this.value.toLowerCase();

    document.querySelectorAll('.employee').forEach(card => {

        card.style.display =
            card.dataset.search.includes(keyword)
            ? 'block'
            : 'none';

    });

});
</script>

</body>
</html>