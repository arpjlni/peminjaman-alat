<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peminjaman Alat</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body { background: #2c3e50; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-box { background: #fff; padding: 30px; border-radius: 6px; width: 380px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .login-box h3 { text-align: center; margin-bottom: 25px; color: #2c3e50; }
    </style>
</head>
<body>
<div class="login-box">
    <h3><span class="glyphicon glyphicon-wrench"></span> Peminjaman Alat</h3>
    <form method="POST" action="/login">
        @csrf
        <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Masukkan username" required>
            @if($errors->has('username'))
                <span class="help-block">{{ $errors->first('username') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
