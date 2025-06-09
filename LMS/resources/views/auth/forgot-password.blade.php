<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

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

        <h5 class="mb-3">Forgot Your Password?</h5>
        <p class="text-muted small mb-4">
            No problem. Just enter your email and we'll send you a password reset link.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>