<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | BangunMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh;">

<div class="card shadow-sm border-0" style="width: 380px;">
    <div class="card-body p-4">

        <h4 class="text-center mb-3 fw-bold">BangunMart</h4>
        <p class="text-center text-muted mb-4">Silakan login untuk melanjutkan</p>

        {{-- ALERT --}}
        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM LOGIN --}}
        <form method="POST" action="/login">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">
                Login
            </button>
        </form>

        <hr class="my-4">

        {{-- REGISTER --}}
        <p class="text-center mb-2 text-muted">
            Belum punya akun?
        </p>

        <a href="/register" class="btn btn-outline-secondary w-100">
            Daftar Akun Baru
        </a>

    </div>
</div>

</body>
</html>
