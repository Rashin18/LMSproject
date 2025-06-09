<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>LMS - Learning Management System</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Bootstrap & Template CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

  @include('partials.header') {{-- Optional: include if you modularize header --}}

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 d-flex flex-column justify-content-center">
            <h1>Welcome to Our Learning Management System</h1>
            <p>Manage courses, students, and learning — all in one place.</p>
            <div>
            
              <a href="#about" class="btn-get-started">Get Started</a>
              
            </div>
          </div>
          <div class="col-lg-6 hero-img">
            <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated" alt="Hero Image">
          </div>
        </div>
      </div>
    </section>


<!-- About LMS -->
<section id="about" class="about section">
  <div class="container section-title text-center" data-aos="fade-up">
    <span>About Us</span>
    <h2>About</h2>
    <p>A quick look into what our Learning Management System offers.</p>
  </div>

  <div class="container">
    <div class="row gy-4">
      <!-- Left Column - Image -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <img src="{{ asset('assets/img/about1.png') }}" class="img-fluid animated" alt="About LMS">
        
      </div>

      <!-- Right Column - Content -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
        <h3>Empowering Learning Through Technology</h3>
        <p class="fst-italic">
          A Learning Management System (LMS) is a digital platform designed to streamline the delivery, tracking, and management of educational content.
        </p>
        <ul>
          <li><i class="bi bi-check2-all text-success"></i> Easy content creation and upload – including videos, documents, and quizzes.</li>
          <li><i class="bi bi-check2-all text-success"></i> Personalized learning paths based on user progress.</li>
          <li><i class="bi bi-check2-all text-success"></i> Role-based dashboards for students, teachers, and administrators.</li>
          <li><i class="bi bi-check2-all text-success"></i> Real-time tracking of performance, attendance, and course completion.</li>
          <li><i class="bi bi-check2-all text-success"></i> Seamless communication through announcements, messaging, and feedback.</li>
        </ul>
        <p>
          By leveraging our LMS, organizations can reduce administrative overhead, ensure consistent delivery of content, and enhance learner engagement.
          Whether you're managing a small classroom or a large institution, our LMS scales with your needs — making digital education more accessible and effective.
        </p>
      </div>
    </div>
  </div>
</section>




    <!-- Services (replace with LMS features) -->
    <section id="services" class="services section bg-light" style="background: url('{{ asset('assets/img/feature.png') }}') no-repeat center center; background-size: cover;">
    <div class="container">
        <div class="section-title">
          <h2>Features</h2>
          <p>Here's what you can do with our LMS:</p>
        </div>
        <div class="row gy-4">
          <div class="col-lg-4">
            <div class="service-item">
              <i class="bi bi-play-circle icon"></i>
              <h4>Video Courses</h4>
              <p>Upload, watch, and track video-based lessons easily.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="service-item">
              <i class="bi bi-people icon"></i>
              <h4>Role-Based Access</h4>
              <p>Custom dashboards for students, staff, and admins.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="service-item">
              <i class="bi bi-bar-chart-line icon"></i>
              <h4>Progress Tracking</h4>
              <p>Monitor student learning progress and assessments.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
<section id="contact" class="contact section">
  <div class="container section-title text-center" data-aos="fade-up">
    <span>Get in Touch</span>
    <h2>Contact</h2>
    <p>We’d love to hear from you. Reach out with questions or feedback.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">

      <!-- Left Column: Contact Info -->
      <div class="col-lg-5">
        <div class="info-wrap">

          <div class="info-item d-flex mb-4">
            <i class="bi bi-geo-alt flex-shrink-0 fs-4 text-primary me-3"></i>
            <div>
              <h5>Address</h5>
              <p>Thiruvanthapuram,Kerala,India</p>
            </div>
          </div>

          <div class="info-item d-flex mb-4">
            <i class="bi bi-telephone flex-shrink-0 fs-4 text-primary me-3"></i>
            <div>
              <h5>Call Us</h5>
              <p>+91 90043435553</p>
            </div>
          </div>

          <div class="info-item d-flex mb-4">
            <i class="bi bi-envelope flex-shrink-0 fs-4 text-primary me-3"></i>
            <div>
              <h5>Email Us</h5>
              <p>example@gmail.com</p>
            </div>
          </div>

          <div class="info-item">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.4394839343267!2d76.902750139043!3d8.553668296284586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05bec50ad5506d%3A0xfdab2e5165736ae6!2sPangappara%2C%20Thiruvananthapuram%2C%20Kerala%20695581!5e0!3m2!1sen!2sin!4v1747214114321!5m2!1sen!2sin"
              width="100%" height="270" frameborder="0" style="border:0;" allowfullscreen loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>

        </div>
      </div>

      <!-- Right Column: Contact Form -->
      <div class="col-lg-7">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" class="php-email-form">
          @csrf
          <div class="row gy-4">
            <div class="col-md-6">
              <label for="name-field" class="pb-2">Your Name</label>
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>

            <div class="col-md-6">
            <label for="name-field" class="pb-2">Your Email</label>
              <input type="email" name="email" class="form-control" placeholder="Your Email" required>
            </div>

            <div class="col-md-12">
            <label for="name-field" class="pb-2">Message</label>
              <textarea name="message" class="form-control" rows="6" placeholder="Message" required></textarea>
            </div>

            <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary px-5">Send Message</button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</section>


  </main>

  <footer id="footer" class="footer">
    <div class="container text-center">
      <p>&copy; {{ date('Y') }} My LMS. All rights reserved.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
