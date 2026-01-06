<!DOCTYPE html>
<html>
<head>
    <title>Activity Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">📜 Activity Log Sistem</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $l)
                    <tr>
                        <td>{{ $l->created_at }}</td>
                        <td>{{ $l->username ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $l->action }}
                            </span>
                        </td>
                        <td>{{ $l->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="/dashboard" class="btn btn-secondary mt-3">
                ⬅ Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

</body>
</html>
