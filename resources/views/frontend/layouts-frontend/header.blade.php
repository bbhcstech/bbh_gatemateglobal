<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'GateMateGlobal - Smart Society Management Software in India')</title>
  <meta name="description" content="The Official App for your Residential Community. Zero Ads. Zero Spam. Built with DPDP-ready data privacy for RWAs.">
  <meta name="keywords" content="society management software, apartment management, RWA software, community app">

  <!-- Favicons -->
  <link href="{{ asset('frontend/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset('frontend/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
      --primary: #2563eb;
      --primary-dark: #1d4ed8;
      --secondary: #7c3aed;
      --accent: #06b6d4;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --dark: #0f172a;
      --light: #f8fafc;
      --gray: #64748b;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--dark);
      overflow-x: hidden;
    }

    .header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      padding: 1rem 0;
      transition: all 0.3s ease;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .header.scrolled {
      padding: 0.5rem 0;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 800;
      text-decoration: none;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .nav-link {
      color: var(--dark) !important;
      font-weight: 500;
      padding: 0.5rem 1rem !important;
      transition: all 0.3s ease;
      position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
      color: var(--primary) !important;
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
      width: 70%;
    }

    .btn-primary-custom {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
      border: none;
    }

    .btn-primary-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(37, 99, 235, 0.3);
      color: white;
    }

    .btn-outline-custom {
      background: transparent;
      color: var(--primary);
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      text-decoration: none;
      border: 2px solid var(--primary);
      transition: all 0.3s ease;
    }

    .btn-outline-custom:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-2px);
    }

    @media (max-width: 991px) {
      .navbar-collapse {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: 1rem;
      }

      .nav-link::after {
        display: none;
      }
    }
  </style>
</head>

<body>
  <header id="header" class="header fixed-top">
    <div class="container">
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid p-0">
          <a class="navbar-brand logo" href="/">GateMateGlobal</a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
              <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
              <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
              <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
              <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
              <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
              <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
              <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
              <li class="nav-item ms-lg-3">
                <a class="btn-primary-custom" href="{{ route('login') }}">Get Started</a>
              </li>
              <li class="nav-item ms-lg-2">
                <a class="btn-outline-custom" href="#demo">Live Demo</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
