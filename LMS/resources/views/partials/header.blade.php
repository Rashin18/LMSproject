<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
      <img src="{{ asset('assets/img/logo.png') }}" alt=""> 
      <h1 class="sitename">Learning Management System</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="#hero" class="active">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#services">Features</a></li>
        <li><a href="#contact">Contact</a></li>
        <!-- Add more nav links if needed -->
        @guest
          <li><a href="{{ route('login') }}">Login</a></li>
          <li><a href="{{ route('eoi.create') }}">EOI Submit</a></li>
        @endguest
        
        @auth
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-link nav-link" style="border: none; background: none; padding: 0; color: inherit;">Logout</button>
            </form>
          </li>
        @endauth
      </ul>

      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>


    <a class="btn-getstarted" href="#about">Get Started</a>
    

  </div>
</header>