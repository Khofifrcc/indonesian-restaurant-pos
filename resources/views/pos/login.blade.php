<!DOCTYPE html>
<html>
<head>
<title>Login - Warung POS</title>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
*{box-sizing:border-box;font-family:Arial}

body{
    margin:0;
    min-height:100vh;
    background:
        radial-gradient(circle at top left, rgba(159,18,57,.35), transparent 35%),
        linear-gradient(135deg,#0f172a,#111827);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#2b1b16;
}

.login-card{
    width:430px;
    background:rgba(255,255,255,.95);
    padding:38px;
    border-radius:28px;
    box-shadow:0 30px 70px rgba(0,0,0,.35);
}

.logo{
    width:70px;
    height:70px;
    background:#9f1239;
    color:white;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:36px;
    margin:0 auto 18px;
}

h1{
    text-align:center;
    font-size:34px;
    margin:0;
    color:#111827;
}

.subtitle{
    text-align:center;
    color:#666;
    margin:10px 0 28px;
}

.input-group{
    position:relative;
    margin-bottom:16px;
}

.input-group i{
    position:absolute;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    color:#9f1239;
    font-size:20px;
}

input{
    width:100%;
    padding:16px 16px 16px 48px;
    border:1px solid #eadbd6;
    border-radius:16px;
    font-size:15px;
}

button{
    width:100%;
    padding:16px;
    background:#9f1239;
    color:white;
    border:0;
    border-radius:16px;
    font-weight:bold;
    font-size:16px;
    cursor:pointer;
    margin-top:8px;
    box-shadow:0 12px 24px rgba(159,18,57,.25);
}

button:hover{
    background:#7f0f2f;
}

.error{
    background:#fee2e2;
    color:#991b1b;
    padding:12px;
    border-radius:14px;
    margin-bottom:16px;
    text-align:center;
}

.demo{
    margin-top:26px;
    background:#f8f5f2;
    padding:18px;
    border-radius:18px;
    text-align:center;
    color:#555;
    line-height:1.6;
}

.demo b{
    color:#9f1239;
}

.footer{
    text-align:center;
    color:#aaa;
    margin-top:20px;
    font-size:13px;
}
</style>
</head>

<body>

<div class="login-card">

    <div class="logo">
        <i class="bx bxs-store"></i>
    </div>

    <h1>Warung POS</h1>

    <div class="subtitle">
        Restaurant Point of Sale System
    </div>

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('pos.login') }}">
        @csrf

        <div class="input-group">
            <i class="bx bx-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <i class="bx bx-lock-alt"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">
            <i class="bx bx-log-in"></i>
            Login
        </button>
    </form>

    <div class="demo">
        <b>Demo Accounts</b><br><br>
        admin / 1234<br>
        kasir1 / 1111<br>
        kasir2 / 2222
    </div>

    <div class="footer">
        Laravel + MySQL Restaurant System
    </div>

</div>

</body>
</html>