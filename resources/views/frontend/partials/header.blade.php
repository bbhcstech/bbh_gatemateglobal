<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'GateMateGlobal - Smart Society Management System')</title>
  <meta name="description" content="Manage residents, visitors, billing and security from a single powerful dashboard">
  <meta name="keywords" content="society management, resident management, visitor management, billing system">

  <!-- Favicons -->
  <link href="{{ asset('frontend/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset('frontend/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('frontend/assets/css/main.css')}}" rel="stylesheet">

  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --success: #4cc9f0;
      --info: #4895ef;
      --warning: #f72585;
      --danger: #e63946;
      --dark: #1e1b4b;
      --light: #f8f9fa;
    }

    body {
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
    }

    .navbar {
      padding: 1rem 0;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      padding: 0.5rem 0;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .nav-link {
      font-weight: 500;
      color: var(--dark) !important;
      margin: 0 0.5rem;
      position: relative;
      transition: all 0.3s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      transition: width 0.3s ease;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
      width: 80%;
    }

    .btn-get-started {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      padding: 0.8rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      border: none;
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
    }

    .btn-get-started:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(67, 97, 238, 0.3);
      color: white;
    }

    .btn-live-demo {
      background: transparent;
      color: var(--primary);
      padding: 0.8rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      border: 2px solid var(--primary);
      margin-left: 1rem;
      transition: all 0.3s ease;
    }

    .btn-live-demo:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-2px);
    }

    @media (max-width: 768px) {
      .navbar-collapse {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
      }

      .btn-live-demo {
        margin-left: 0;
        margin-top: 0.5rem;
      }
    }
  </style>
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <span class="logo">GateMate<span style="color: var(--primary);">Global</span></span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul class="nav d-flex align-items-center">
          <li class="nav-item"><a href="#hero" class="nav-link active">Home</a></li>
          <li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
          <li class="nav-item"><a href="#pricing" class="nav-link">Pricing</a></li>
          <li class="nav-item"><a href="#testimonials" class="nav-link">Testimonials</a></li>
          <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-flex align-items-center">
        <a class="btn-get-started" href="{{ route('login') }}">Get Started</a>
        <a class="btn-live-demo d-none d-md-block" href="#demo">Live Demo</a>
      </div>
    </div>
  </header>
