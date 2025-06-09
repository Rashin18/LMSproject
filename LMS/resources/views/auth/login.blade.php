<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Favicon -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png">

    <style>
        body {
            background-color: #f8f9fa;
            position: relative;
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

        .form-check {
            margin-bottom: 1rem;
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

        <div class="auth-box" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-3">Login</h4>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-3">{{ session('status') }}</div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail ID:</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

                <!-- Forgot Password Link -->
                @if (Route::has('password.request'))
                    <div class="mt-3 text-center">
                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>