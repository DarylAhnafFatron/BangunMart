<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi | BangunMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh;">

<div class="card shadow-sm border-0" style="width: 400px;">
    <div class="card-body p-4">

        <h4 class="text-center mb-3 fw-bold">Registrasi Akun</h4>
        <p class="text-center text-muted mb-4">
            Buat akun kasir untuk masuk ke sistem
        </p>

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

        {{-- FORM REGISTER --}}
        <form method="POST" action="/register">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            {{-- ROLE DIKUNCI --}}
            <input type="hidden" name="role" value="kasir">

            <button class="btn btn-success w-100">
                Daftar
            </button>
        </form>

        <hr class="my-4">

        <p class="text-center mb-0">
            Sudah punya akun?
            <a href="/login" class="text-decoration-none fw-semibold">
                Login
            </a>
        </p>

    </div>
</div>

</body>
</html>
