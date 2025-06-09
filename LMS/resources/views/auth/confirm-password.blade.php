<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
        position: relative;
    }

    .bg-corner {
        position: absolute;
        top: 0;
        right: 0;
        width: 250px;
        height: auto;
        opacity: 0.2;
        z-index: 0;
    }

    .auth-card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 500px;
    }

    .app-logo {
        width: 60px;
        height: auto;
    }
</style>


</head>
<body>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm p-4 border-0 auth-card bg-white">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logo.png') }}" class="app-logo mb-2" alt="Logo">
            <h4 class="mb-0">Learning Management System</h4>
        </div>

        <h5 class="mb-3">Confirm Password</h5>
        <p class="text-muted small mb-4">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>