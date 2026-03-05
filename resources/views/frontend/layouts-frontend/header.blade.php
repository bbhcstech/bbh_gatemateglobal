<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - Socity Mangement System Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('frontend/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset('frontend/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('frontend/assets/css/main.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: eNno
  * Template URL: https://bootstrapmade.com/enno-free-simple-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<style>
  .custom-btn {
    background-color: #7c1f8c !important;
    color: #ffffff !important;
    border: none; /* optional, removes border */
     padding: 0.3rem 0.8rem; /* smaller height */
  font-size: 0.9rem; /* slightly smaller text */
}

.custom-btn:hover {
    background-color: #6a1878 !important; /* a slightly darker shade on hover */
    color: #ffffff !important;
}

</style>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        
        <h1 class="sitename">Socity Mangement System</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <!-- <li><a href="#about">QR Scanner</a></li>
          <li><a href="#services">Pricing</a></li>
          <li><a href="#portfolio">Compare</a></li>
          <li><a href="#team">FAQ</a></li>
          <li><a href="#team">Support</a></li>
          <li class="dropdown">
           <a class="btn custom-btn ps-3 pe-3 rounded-pill d-flex align-items-center text-nowrap" 
              href="/qr-code-generator" id="createNewBtnHeader">
              <span>Create QR Code</span> 
              <i class="bi bi-chevron-down toggle-dropdown ms-2"></i>
            </a>


            <ul>
              <li><a href="#">URL / Link  </a></li>          
              <li><a href="#">PDF</a></li>
              <li><a href="#">Image</a></li>
              <li><a href="#">App Markets</a></li>
              <li><a href="#">Text</a></li>
              <li><a href="#">Maps</a></li>
              <li><a href="#">Wi-Fi</a></li>
              <li><a href="#">Audio</a></li>
              <li><a href="#">WhatsApp</a></li>
              <li><a href="#">YouTube</a></li> 
            </ul>
          </li> -->
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ route('login') }}">Get Started</a>

    </div>
  </header>