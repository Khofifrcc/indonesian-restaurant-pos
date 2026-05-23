<!DOCTYPE html>
<html>
<head>
<title>Login - Indonesian POS</title>
<style>
*{box-sizing:border-box;font-family:Arial}
body{
    margin:0;
    background:#111827;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}
.box{
    width:380px;
    background:white;
    padding:32px;
    border-radius:18px;
}
h1{text-align:center;margin-bottom:22px}
input{
    width:100%;
    padding:13px;
    margin-bottom:14px;
    border:1px solid #ddd;
    border-radius:10px;
}
button{
    width:100%;
    padding:13px;
    background:#9f1239;
    color:white;
    border:0;
    border-radius:10px;
    font-weight:bold;
}
.error{
    background:#fee2e2;
    color:#991b1b;
    padding:10px;
    border-radius:10px;
    margin-bottom:15px;
}
.demo{
    margin-top:20px;
    color:#666;
    font-size:14px;
    text-align:center;
}
</style>
</head>

<body>

<div class="box">
    <h1>Restaurant POS Login</h1>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('pos.login') }}">
        @csrf

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <div class="demo">
        <b>Demo Accounts</b><br><br>
        admin / 1234<br>
        kasir1 / 1111<br>
        kasir2 / 2222
    </div>
</div>

</body>
</html>