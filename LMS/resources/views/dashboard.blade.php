@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar (optional) -->
    <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('dashboard') }}">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('profile.edit') }}">
              <i class="bi bi-person-circle"></i> Edit Profile
            </a>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="nav-link btn btn-link text-start" type="submit">
                <i class="bi bi-box-arrow-right"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome, {{ Auth::user()->name }}</h1>
        <div class="text-muted">Role: <strong>{{ ucfirst(Auth::user()->role) }}</strong></div>
      </div>

      <!-- Dashboard Cards -->
      <div class="row g-4">
        <div class="col-md-6 col-xl-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">My Courses</h5>
              <p class="card-text">View or manage the courses you're enrolled in or created.</p>
              <a href="#" class="btn btn-outline-primary btn-sm">Go to Courses</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">My Profile</h5>
              <p class="card-text">Update your personal and login information.</p>
              <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm">Edit Profile</a>
            </div>
          </div>
        </div>
        <!-- Add more dashboard cards as needed -->
      </div>
    </main>
  </div>
</div>
@endsection

