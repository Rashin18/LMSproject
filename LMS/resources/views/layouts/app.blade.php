<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>LMS - Learning Management System</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap & Custom CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  @stack('styles')
</head>

<body class="index-page bg-white text-dark">

  {{-- Navbar (light style like index.blade.php) --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
    <a class="navbar-brand" href="{{ 
    Auth::check() ? (
      Auth::user()->role === 'superadmin' ? route('superadmin.dashboard') : 
      (Auth::user()->role === 'admin' ? route('admin.dashboard') : 
      (Auth::user()->role === 'atc' ? route('atc.dashboard') :
      (Auth::user()->role === 'applicant' ? route('applicant.dashboard') :
      (Auth::user()->role === 'teacher' ? route('teacher.dashboard') : 
      route('student.dashboard')))))
    ) : url('/')
  }}">
  <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 40px;">
</a>



      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
        @auth
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown">
                {{ Auth::user()->name }} <small>({{ ucfirst(Auth::user()->role) }})</small>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        @endauth

        @guest
          <ul class="navbar-nav">
            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-dark">Login</a></li>
            
            
          </ul>
        @endguest

      </div>
    </div>
  </nav>

  @if($activeAnnouncements->isNotEmpty())
    <div class="announcement-bar bg-warning bg-opacity-10 border-bottom border-warning">
        <div class="container py-2">
            <div class="alert alert-warning mb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @foreach($activeAnnouncements as $announcement)
                            <div class="mb-2">
                                <strong>{{ $announcement->title }}</strong>
                                <p class="mb-0">{{ $announcement->message }}</p>
                                @if($announcement->start_at || $announcement->end_at)
                                    <small class="text-muted">
                                        {{ $announcement->start_at?->format('M j') }} - 
                                        {{ $announcement->end_at?->format('M j, Y') }}
                                    </small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif

  {{-- Page Content --}}
  <main class="main py-4">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer id="footer" class="footer border-top py-4 mt-5 bg-light">
    <div class="container text-center">
      <p class="mb-0 text-muted">&copy; {{ date('Y') }} My LMS. All rights reserved.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  @stack('scripts')
</body>
</html>
