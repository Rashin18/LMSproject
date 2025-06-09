<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .auth-container {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .background-image {
            position: absolute;
            top: 0;
            right: 0;
            max-width: 300px;
            opacity: 0.1;
            z-index: 0;
        }

        .auth-box {
            position: relative;
            z-index: 1;
            background-color: #ffffff;
            border-radius: 15px;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .brand-logo {
            max-width: 70px;
        }
    </style>
</head>
<body>

<div class="auth-container">
    

    <div class="auth-box">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logo.png') }}" class="brand-logo mb-2" alt="App Logo">
            <h4 class="fw-bold">Learning Management System</h4>
        </div>

        <h5 class="mb-3 text-center">Create an Account</h5>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Register As</label>
                <select id="role" name="role" required class="form-select @error('role') is-invalid @enderror">
                    <option value="">-- Select Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="atc" {{ old('role') == 'atc' ? 'selected' : '' }}>ATC</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control" required autocomplete="new-password">
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>

            <div class="text-center">
                <small>Already have an account?</small>
                <a href="{{ route('login') }}" class="text-decoration-none">Log In</a>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>