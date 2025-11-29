<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cache Cleared</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow p-4 text-center">
            <h2 class="text-success mb-3">✔ Cache Successfully Cleared</h2>
            <p class="text-muted">All system caches, including route, view, and configuration caches, have been successfully cleared.</p>

            <a href="{{ route('web.index') }}" class="btn btn-primary mt-3">Go Back to Home</a>
        </div>
    </div>

</body>

</html>
