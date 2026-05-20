<!DOCTYPE html>
<html>
<head>
    <title>Login - Indonesian POS</title>
    <style>
        body {
            margin:0;
            font-family:Arial;
            background:#111827;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .box {
            width:360px;
            background:white;
            padding:30px;
            border-radius:18px;
            box-shadow:0 10px 30px rgba(0,0,0,.3);
        }

        h1 {
            text-align:center;
            margin-bottom:25px;
        }

        input {
            width:100%;
            padding:12px;
            margin-bottom:14px;
            border-radius:10px;
            border:1px solid #ddd;
        }

        button {
            width:100%;
            padding:12px;
            background:#dc2626;
            color:white;
            border:0;
            border-radius:10px;
            font-weight:bold;
            cursor:pointer;
        }

        .error {
            background:#fee2e2;
            color:#991b1b;
            padding:10px;
            border-radius:10px;
            margin-bottom:15px;
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

    <br>

    <p style="text-align:center;color:#666;">
        admin / 1234<br>
        kasiyer / 1234
    </p>
</div>

</body>
</html>