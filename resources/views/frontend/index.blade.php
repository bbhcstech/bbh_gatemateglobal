@extends('frontend.layouts-frontend.app')

@section('title', 'GateMateGlobal - Smart Society Management Software in India')

@section('content')
<main class="overflow-hidden">
    <!-- Hero Section with Parallax -->
    <section id="home" class="hero-section min-vh-100 d-flex align-items-center position-relative">
        <!-- Video Background or Image Slider -->
        <div class="hero-background">
            <div class="hero-slider">
                <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80')"></div>
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80')"></div>
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1554469384-e58fac16e23a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80')"></div>
            </div>
            <div class="overlay"></div>
        </div>

        <div class="container position-relative z-3">
            <div class="row align-items-center g-5">
                <div class="col-lg-7" data-aos="fade-right" data-aos-duration="1200">
                    <div class="hero-badge mb-4 animate__animated animate__fadeInUp">
                        <span class="badge-gradient">
                            <i class="bi bi-stars me-2"></i>
                            <span class="typing-text">Pioneering software for Well-Run Communities since 2024</span>
                        </span>
                    </div>

                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                        The Official App for your
                        <span class="text-gradient">Residential<br>Community</span>
                    </h1>

                    <p class="lead text-white-50 mb-4 animate__animated animate__fadeInUp animate__delay-2s">
                        Zero Ads. Zero Spam. Built with DPDP-ready data privacy for RWAs.
                    </p>

                    <!-- Trust Badges with Modern Design -->
                    <div class="d-flex flex-wrap gap-4 mb-5 animate__animated animate__fadeInUp animate__delay-3s">
                        <div class="trust-badge glass-effect">
                            <div class="avatar-group me-3">
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="avatar" alt="User">
                                <img src="https://images.unsplash.com/photo-1494790108777-766fd5f7a1a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="avatar" alt="User">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="avatar" alt="User">
                                <span class="avatar-more">+2.1k</span>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold text-white">2.1M+</p>
                                <small class="text-white-50">Happy Residents</small>
                            </div>
                        </div>

                        <div class="trust-badge glass-effect">
                            <i class="bi bi-building fs-1 text-white me-3"></i>
                            <div>
                                <p class="mb-0 fw-bold text-white">25k+</p>
                                <small class="text-white-50">Communities</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 animate__animated animate__fadeInUp animate__delay-4s">
                        <a href="{{ route('login') }}" class="btn-primary-custom btn-lg pulse-animation">
                            Get Started Free
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#video" class="btn-outline-custom btn-lg glightbox">
                            <i class="bi bi-play-circle me-2"></i>Watch Demo
                        </a>
                    </div>

                    <!-- Floating Stats -->
                    <div class="live-stats mt-5">
                        <div class="stat-item glass-effect">
                            <i class="bi bi-people-fill"></i>
                            <span class="counter" data-target="2100000">0</span>
                            <small>Active Users</small>
                        </div>
                        <div class="stat-item glass-effect">
                            <i class="bi bi-building"></i>
                            <span class="counter" data-target="25000">0</span>
                            <small>Societies</small>
                        </div>
                        <div class="stat-item glass-effect">
                            <i class="bi bi-shield-check"></i>
                            <span class="counter" data-target="100">0</span>
                            <small>% Secure</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5" data-aos="fade-left" data-aos-duration="1200">
                    <div class="hero-image-wrapper">
                        <!-- Main Dashboard Mockup -->
                        <div class="dashboard-mockup">
                            <div class="mockup-screen">
                                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                     alt="Dashboard Preview"
                                     class="img-fluid rounded-4 shadow-2xl">

                                <!-- Floating UI Elements -->
                                <div class="floating-element element-1">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Visitor Entry</span>
                                </div>
                                <div class="floating-element element-2">
                                    <i class="bi bi-credit-card-fill text-primary"></i>
                                    <span>Payment Received</span>
                                </div>
                                <div class="floating-element element-3">
                                    <i class="bi bi-bell-fill text-warning"></i>
                                    <span>New Notice</span>
                                </div>
                            </div>

                            <!-- App Store Badges -->
                            <div class="store-badges mt-4">
                                <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store">
                                <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Google Play">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="scroll-indicator">
            <a href="#features" class="mouse">
                <span></span>
            </a>
            <p>Scroll to explore</p>
        </div>
    </section>

    <!-- Animated Features Section -->
    <section id="features" class="features-section py-6">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">
                    <i class="bi bi-stars me-2"></i>Powerful Features
                </span>
                <h2 class="display-5 fw-bold mb-3">Everything You Need in One Platform</h2>
                <p class="lead text-muted">Experience the most comprehensive society management solution</p>
            </div>

            <div class="row g-4">
                <!-- Feature Card 1 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card-advanced">
                        <div class="feature-image">
                            <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Visitor Management">
                            <div class="feature-overlay">
                                <div class="feature-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h4>Smart Visitor Management</h4>
                            <p>QR code-based entry, pre-approval system, and real-time notifications</p>
                            <a href="#" class="feature-link">Learn More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card-advanced">
                        <div class="feature-image">
                            <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Online Payments">
                            <div class="feature-overlay">
                                <div class="feature-icon">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h4>Automated Billing & Payments</h4>
                            <p>100+ payment options, automated reminders, and instant receipts</p>
                            <a href="#" class="feature-link">Learn More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Feature Card 3 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card-advanced">
                        <div class="feature-image">
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Community Management">
                            <div class="feature-overlay">
                                <div class="feature-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h4>Community Engagement</h4>
                            <p>Events, polls, forums, and direct messaging with neighbors</p>
                            <a href="#" class="feature-link">Learn More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview Section -->
    <section class="dashboard-preview-section py-6 bg-light">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="preview-content">
                        <span class="badge bg-primary-soft text-primary mb-3">
                            <i class="bi bi-grid-3x3-gap-fill me-2"></i>Intuitive Dashboard
                        </span>
                        <h2 class="display-6 fw-bold mb-4">Beautiful Interface, Powerful Analytics</h2>
                        <p class="text-muted mb-4">Get real-time insights into your community with our advanced dashboard. Track payments, visitor entries, and community engagement all in one place.</p>

                        <div class="feature-list-advanced">
                            <div class="feature-item">
                                <div class="feature-icon-sm bg-primary">
                                    <i class="bi bi-graph-up text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Real-time Analytics</h6>
                                    <p class="text-muted small">Live tracking of all activities</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon-sm bg-success">
                                    <i class="bi bi-bell text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Smart Notifications</h6>
                                    <p class="text-muted small">Instant alerts for important updates</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon-sm bg-warning">
                                    <i class="bi bi-file-text text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Automated Reports</h6>
                                    <p class="text-muted small">Generate reports with one click</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="dashboard-showcase">
                        <div class="main-dashboard">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                 alt="Dashboard"
                                 class="img-fluid rounded-4 shadow-2xl">

                            <!-- Stats Overlay -->
                            <div class="stats-overlay">
                                <div class="stats-card glass-effect">
                                    <div class="stats-header">
                                        <i class="bi bi-arrow-up-right-circle-fill text-success"></i>
                                        <span>Today's Activity</span>
                                    </div>
                                    <div class="stats-body">
                                        <div class="stat-row">
                                            <span>Visitors</span>
                                            <span class="text-success">+24</span>
                                        </div>
                                        <div class="stat-row">
                                            <span>Payments</span>
                                            <span class="text-primary">₹45K</span>
                                        </div>
                                        <div class="stat-row">
                                            <span>Events</span>
                                            <span class="text-warning">3 Today</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Gallery Section -->
    <section id="products" class="products-gallery-section py-6">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i>Our Products
                </span>
                <h2 class="display-5 fw-bold mb-3">Complete Suite for Modern Societies</h2>
                <p class="lead text-muted">Choose the perfect solution for your community needs</p>
            </div>

            <div class="row g-4">
                <!-- Product Card 1 - Core -->
                <div class="col-lg-4 col-md-6" data-aos="flip-left" data-aos-delay="100">
                    <div class="product-card-premium">
                        <div class="product-badge">For Residents</div>
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="GateMate Core">
                            <div class="product-icon-circle">
                                <i class="bi bi-phone"></i>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="h4 fw-bold">GateMate Core</h3>
                            <p class="text-muted small">Complete resident engagement platform</p>

                            <div class="product-features">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Official Communication</span>
                                <span><i class="bi bi-check-circle-fill text-success"></i> Community Helpdesk</span>
                                <span><i class="bi bi-check-circle-fill text-success"></i> Chat with Neighbors</span>
                            </div>

                            <button class="btn-outline-custom w-100 mt-3">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 - ERP (Popular) -->
                <div class="col-lg-4 col-md-6" data-aos="flip-left" data-aos-delay="200">
                    <div class="product-card-premium popular">
                        <div class="product-badge popular-badge">Most Popular</div>
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="GateMate ERP">
                            <div class="product-icon-circle bg-gradient-secondary">
                                <i class="bi bi-building-gear"></i>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="h4 fw-bold">GateMate ERP</h3>
                            <p class="text-muted small">Advanced admin & management tools</p>

                            <div class="product-features">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Facility Management</span>
                                <span><i class="bi bi-check-circle-fill text-success"></i> Staff Management</span>
                                <span><i class="bi bi-check-circle-fill text-success"></i> Parking Management</span>
                            </div>

                            <button class="btn-primary-custom w-100 mt-3">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 - Gatekeeper -->
                <div class="col-lg-4 col-md-6" data-aos="flip-left" data-aos-delay="300">
                    <div class="product-card-premium">
                        <div class="product-badge">For Security</div>
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1558002038-1055907df827?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="GateMate Gatekeeper">
                            <div class="product-icon-circle bg-gradient-success">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="h4 fw-bold">GateMate Gatekeeper</h3>
                            <p class="text-muted small">Advanced security & access control</p>

                            <div class="product-features">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Visitor Management</span>
                                <span><i class="bi bi-check-circle-fill text-success"></i> IoT Integration</span>
                                <span><i class="bi bi-check-circle-fill text-success"></i> Emergency Alerts</span>
                            </div>

                            <button class="btn-outline-custom w-100 mt-3">Learn More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Counter Section with Background Image -->
    <section class="stats-counter-section py-6 position-relative"
             style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');">
        <div class="overlay-dark"></div>
        <div class="container position-relative z-2">
            <div class="row g-4">
                <div class="col-lg-3 col-6" data-aos="zoom-in">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="counter-number" data-target="2100000">0</div>
                        <div class="counter-label">Happy Residents</div>
                        <div class="counter-trend">↑ 25% this year</div>
                    </div>
                </div>

                <div class="col-lg-3 col-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="counter-number" data-target="25000">0</div>
                        <div class="counter-label">Communities</div>
                        <div class="counter-trend">↑ 1k this month</div>
                    </div>
                </div>

                <div class="col-lg-3 col-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="counter-number" data-target="46500000000">0</div>
                        <div class="counter-label">Billing Done</div>
                        <div class="counter-trend">₹ in billions</div>
                    </div>
                </div>

                <div class="col-lg-3 col-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="counter-number" data-target="5000000">0</div>
                        <div class="counter-label">Visitor Entries</div>
                        <div class="counter-trend">100% secure</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Testimonials Section -->
    <section id="testimonials" class="video-testimonials-section py-6">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">
                    <i class="bi bi-camera-reels me-2"></i>Video Testimonials
                </span>
                <h2 class="display-5 fw-bold mb-3">See What Our Clients Say</h2>
                <p class="lead text-muted">Real stories from real community leaders</p>
            </div>

            <div class="row g-4">
                <!-- Video Testimonial 1 -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="video-card">
                        <div class="video-thumbnail-wrapper">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Testimonial 1"
                                 class="img-fluid">
                            <div class="video-play-btn glightbox" data-href="https://www.youtube.com/watch?v=example1">
                                <i class="bi bi-play-circle-fill"></i>
                            </div>
                            <div class="video-duration">3:45</div>
                        </div>
                        <div class="video-content">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                     class="rounded-circle me-3"
                                     width="50"
                                     height="50"
                                     alt="Client">
                                <div>
                                    <h6 class="fw-bold mb-1">Rajesh Kumar</h6>
                                    <p class="text-muted small mb-0">Chairman, Sunrise Apartments</p>
                                </div>
                            </div>
                            <p class="testimonial-quote">"GateMate has transformed our community management completely."</p>
                        </div>
                    </div>
                </div>

                <!-- Video Testimonial 2 -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="video-card featured">
                        <div class="video-thumbnail-wrapper">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Testimonial 2"
                                 class="img-fluid">
                            <div class="video-play-btn glightbox" data-href="https://www.youtube.com/watch?v=example2">
                                <i class="bi bi-play-circle-fill"></i>
                            </div>
                            <div class="video-duration">4:20</div>
                        </div>
                        <div class="video-content">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                     class="rounded-circle me-3"
                                     width="50"
                                     height="50"
                                     alt="Client">
                                <div>
                                    <h6 class="fw-bold mb-1">Priya Sharma</h6>
                                    <p class="text-muted small mb-0">Secretary, Green Valley</p>
                                </div>
                            </div>
                            <p class="testimonial-quote">"The automated billing system saved us countless hours."</p>
                        </div>
                    </div>
                </div>

                <!-- Video Testimonial 3 -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="video-card">
                        <div class="video-thumbnail-wrapper">
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Testimonial 3"
                                 class="img-fluid">
                            <div class="video-play-btn glightbox" data-href="https://www.youtube.com/watch?v=example3">
                                <i class="bi bi-play-circle-fill"></i>
                            </div>
                            <div class="video-duration">2:55</div>
                        </div>
                        <div class="video-content">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                     class="rounded-circle me-3"
                                     width="50"
                                     height="50"
                                     alt="Client">
                                <div>
                                    <h6 class="fw-bold mb-1">Amit Patel</h6>
                                    <p class="text-muted small mb-0">Treasurer, Royal Orchid</p>
                                </div>
                            </div>
                            <p class="testimonial-quote">"Security has improved tremendously with QR code entry."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section with Images -->
    <section class="how-it-works-section py-6 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">
                    <i class="bi bi-diagram-3 me-2"></i>Simple Process
                </span>
                <h2 class="display-5 fw-bold mb-3">How GateMate Works</h2>
                <p class="lead text-muted">Get started in minutes with our easy setup</p>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-card">
                        <div class="step-image">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Step 1">
                            <div class="step-number">1</div>
                        </div>
                        <h5>Sign Up</h5>
                        <p class="text-muted">Create your community account in minutes</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-card">
                        <div class="step-image">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Step 2">
                            <div class="step-number">2</div>
                        </div>
                        <h5>Configure</h5>
                        <p class="text-muted">Set up your society details and preferences</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-card">
                        <div class="step-image">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Step 3">
                            <div class="step-number">3</div>
                        </div>
                        <h5>Invite</h5>
                        <p class="text-muted">Add residents and staff to the platform</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-card">
                        <div class="step-image">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Step 4">
                            <div class="step-number">4</div>
                        </div>
                        <h5>Manage</h5>
                        <p class="text-muted">Start managing your community efficiently</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog/News Section -->
    <section class="blog-section py-6">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">
                    <i class="bi bi-newspaper me-2"></i>Latest Updates
                </span>
                <h2 class="display-5 fw-bold mb-3">News & Insights</h2>
                <p class="lead text-muted">Stay updated with the latest in community management</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Blog 1">
                            <div class="blog-category">DPDP Act</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-calendar"></i> Mar 15, 2024</span>
                                <span><i class="bi bi-clock"></i> 5 min read</span>
                            </div>
                            <h5 class="blog-title">How DPDP Act Affects Your RWA</h5>
                            <p class="blog-excerpt">Learn about the new data protection laws and how we ensure compliance...</p>
                            <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Blog 2">
                            <div class="blog-category">Tips & Tricks</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-calendar"></i> Mar 10, 2024</span>
                                <span><i class="bi bi-clock"></i> 4 min read</span>
                            </div>
                            <h5 class="blog-title">10 Ways to Improve Society Security</h5>
                            <p class="blog-excerpt">Discover effective strategies to enhance security in your community...</p>
                            <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/photo-1554469384-e58fac16e23a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                 alt="Blog 3">
                            <div class="blog-category">Feature Update</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-calendar"></i> Mar 5, 2024</span>
                                <span><i class="bi bi-clock"></i> 3 min read</span>
                            </div>
                            <h5 class="blog-title">New: AI-Powered Visitor Prediction</h5>
                            <p class="blog-excerpt">Our latest feature uses AI to predict and manage visitor traffic...</p>
                            <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section with Accordion -->
    <section id="faq" class="faq-section py-6 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">
                    <i class="bi bi-question-circle me-2"></i>FAQ
                </span>
                <h2 class="display-5 fw-bold mb-3">Frequently Asked Questions</h2>
                <p class="lead text-muted">Everything you need to know about GateMateGlobal</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion modern-accordion" id="faqAccordion">
                        <div class="accordion-item" data-aos="fade-up">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <span class="question-icon">
                                        <i class="bi bi-question-circle"></i>
                                    </span>
                                    What is GateMateGlobal?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    GateMateGlobal is a comprehensive society management software designed to streamline daily operations of housing societies. It helps residents connect, pay dues, manage visitors, and handle accounting tasks efficiently.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <span class="question-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </span>
                                    Is my data secure?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes! GateMateGlobal is ISO 27001 certified and DPDP compliant. We use bank-grade encryption and never share or sell your data. Your privacy is our priority.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <span class="question-icon">
                                        <i class="bi bi-credit-card"></i>
                                    </span>
                                    What payment methods are supported?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We support all major payment methods including UPI, Credit/Debit Cards, Net Banking, and popular wallets. All payments are processed through our secure, PCI-DSS compliant gateway.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <span class="question-icon">
                                        <i class="bi bi-phone"></i>
                                    </span>
                                    Is there a mobile app?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes! GateMateGlobal is available on both iOS and Android. Download from Apple App Store or Google Play Store for on-the-go access to all features.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners/Integrations Section -->
    <section class="partners-section py-6">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">
                    <i class="bi bi-building me-2"></i>Our Partners
                </span>
                <h2 class="display-5 fw-bold mb-3">Trusted by Industry Leaders</h2>
            </div>

            <div class="partners-slider">
                <div class="partner-item">
                    <img src="https://via.placeholder.com/150x50/2563eb/ffffff?text=Partner+1" alt="Partner">
                </div>
                <div class="partner-item">
                    <img src="https://via.placeholder.com/150x50/7c3aed/ffffff?text=Partner+2" alt="Partner">
                </div>
                <div class="partner-item">
                    <img src="https://via.placeholder.com/150x50/10b981/ffffff?text=Partner+3" alt="Partner">
                </div>
                <div class="partner-item">
                    <img src="https://via.placeholder.com/150x50/f59e0b/ffffff?text=Partner+4" alt="Partner">
                </div>
                <div class="partner-item">
                    <img src="https://via.placeholder.com/150x50/ef4444/ffffff?text=Partner+5" alt="Partner">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section with Parallax -->
    <section class="cta-section py-6 position-relative overflow-hidden">
        <div class="cta-background">
            <div class="cta-image" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');"></div>
            <div class="overlay-gradient"></div>
        </div>

        <div class="container position-relative z-2">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="zoom-in">
                    <h2 class="display-5 fw-bold text-white mb-4">Ready to Transform Your Community?</h2>
                    <p class="lead text-white mb-5 opacity-90">Join 25,000+ communities already using GateMateGlobal</p>

                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">
                        <a href="{{ route('login') }}" class="btn-light-custom btn-lg pulse-animation">
                            Start Free Trial
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#contact" class="btn-outline-light btn-lg">
                            <i class="bi bi-headset me-2"></i>
                            Talk to Sales
                        </a>
                    </div>

                    <div class="cta-features">
                        <div class="row justify-content-center g-4">
                            <div class="col-md-3 col-6">
                                <div class="cta-feature">
                                    <i class="bi bi-clock-history"></i>
                                    <span>14-day free trial</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="cta-feature">
                                    <i class="bi bi-headset"></i>
                                    <span>24/7 support</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="cta-feature">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>No credit card</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="cta-feature">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Cancel anytime</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Enhanced CSS with modern design */
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

/* Section Spacing */
.py-6 {
    padding-top: 5rem;
    padding-bottom: 5rem;
}

/* Hero Section */
.hero-section {
    min-height: 100vh;
    position: relative;
    padding-top: 100px;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-slider {
    width: 100%;
    height: 100%;
    position: relative;
}

.hero-slider .slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1s ease;
    animation: zoomEffect 20s infinite;
}

.hero-slider .slide.active {
    opacity: 1;
}

@keyframes zoomEffect {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
}

/* Glass Effect */
.glass-effect {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 1rem;
}

/* Typing Animation */
.typing-text {
    display: inline-block;
    overflow: hidden;
    white-space: nowrap;
    animation: typing 4s steps(40) infinite;
}

@keyframes typing {
    from { width: 0; }
    50% { width: 100%; }
    to { width: 100%; }
}

/* Live Stats */
.live-stats {
    display: flex;
    gap: 2rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    min-width: 120px;
}

.stat-item i {
    font-size: 2rem;
    color: white;
    margin-bottom: 0.5rem;
}

.stat-item span {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.stat-item small {
    color: rgba(255, 255, 255, 0.7);
}

/* Dashboard Mockup */
.dashboard-mockup {
    position: relative;
}

.mockup-screen {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.3);
}

.floating-element {
    position: absolute;
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    animation: float 3s ease-in-out infinite;
}

.element-1 {
    top: 20px;
    left: -30px;
    animation-delay: 0s;
}

.element-2 {
    bottom: 30px;
    right: -30px;
    animation-delay: 1s;
}

.element-3 {
    top: 50%;
    right: -20px;
    animation-delay: 2s;
}

.store-badges {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.store-badges img {
    height: 45px;
    width: auto;
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    z-index: 10;
}

.mouse {
    width: 26px;
    height: 40px;
    border: 2px solid white;
    border-radius: 20px;
    position: relative;
    display: inline-block;
}

.mouse span {
    width: 4px;
    height: 8px;
    background: white;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 2px;
    animation: scroll 2s infinite;
}

@keyframes scroll {
    0% { opacity: 1; transform: translateX(-50%) translateY(0); }
    100% { opacity: 0; transform: translateX(-50%) translateY(15px); }
}

.scroll-indicator p {
    color: white;
    margin-top: 10px;
    font-size: 0.875rem;
    opacity: 0.8;
}

/* Feature Cards Advanced */
.feature-card-advanced {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.feature-card-advanced:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(37, 99, 235, 0.2);
}

.feature-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.feature-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.feature-card-advanced:hover .feature-image img {
    transform: scale(1.1);
}

.feature-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.7));
}

.feature-icon {
    position: absolute;
    bottom: -30px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
}

.feature-content {
    padding: 2rem 1.5rem 1.5rem;
}

.feature-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.feature-link:hover {
    gap: 1rem;
}

/* Dashboard Preview Section */
.dashboard-preview-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

.feature-list-advanced {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.feature-icon-sm {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.dashboard-showcase {
    position: relative;
}

.main-dashboard {
    position: relative;
}

.stats-overlay {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 250px;
}

.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1rem;
}

.stats-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.stats-body {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

/* Product Cards Premium */
.product-card-premium {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
}

.product-card-premium:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 30px 60px rgba(37, 99, 235, 0.2);
}

.product-card-premium.popular {
    border: 2px solid var(--primary);
}

.product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(37, 99, 235, 0.1);
    color: var(--primary);
    padding: 0.25rem 1rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 2;
}

.popular-badge {
    background: var(--primary);
    color: white;
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card-premium:hover .product-image img {
    transform: scale(1.1);
}

.product-icon-circle {
    position: absolute;
    bottom: -30px;
    left: 20px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
}

.product-content {
    padding: 2rem 1.5rem 1.5rem;
}

.product-features {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin: 1rem 0;
}

.product-features span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

/* Counter Section */
.stats-counter-section {
    position: relative;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

.overlay-dark {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.8), rgba(37, 99, 235, 0.8));
}

.counter-card {
    text-align: center;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.counter-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.15);
}

.counter-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: white;
}

.counter-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
}

.counter-label {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0.5rem;
}

.counter-trend {
    color: var(--success);
    font-size: 0.875rem;
}

/* Video Testimonials */
.video-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.video-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(37, 99, 235, 0.2);
}

.video-card.featured {
    border: 2px solid var(--primary);
}

.video-thumbnail-wrapper {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.video-thumbnail-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 3rem;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0.8;
}

.video-play-btn:hover {
    transform: translate(-50%, -50%) scale(1.1);
    opacity: 1;
}

.video-duration {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 5px;
    font-size: 0.75rem;
}

.video-content {
    padding: 1.5rem;
}

.testimonial-quote {
    font-style: italic;
    color: var(--gray);
    margin: 0;
    position: relative;
    padding-left: 1.5rem;
}

.testimonial-quote::before {
    content: '"';
    position: absolute;
    left: 0;
    top: -5px;
    font-size: 2rem;
    color: var(--primary);
    opacity: 0.3;
}

/* How It Works */
.step-card {
    text-align: center;
}

.step-image {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.step-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.step-number {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 40px;
    height: 40px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
}

/* Blog Cards */
.blog-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(37, 99, 235, 0.15);
}

.blog-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.blog-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.blog-card:hover .blog-image img {
    transform: scale(1.1);
}

.blog-category {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: var(--primary);
    color: white;
    padding: 0.25rem 1rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
}

.blog-content {
    padding: 1.5rem;
}

.blog-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
    color: var(--gray);
}

.blog-meta i {
    margin-right: 0.25rem;
}

.blog-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.blog-excerpt {
    font-size: 0.875rem;
    color: var(--gray);
    margin-bottom: 1rem;
}

.blog-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.blog-link:hover {
    gap: 1rem;
}

/* Modern Accordion */
.modern-accordion .accordion-item {
    margin-bottom: 1rem;
    border: none;
    border-radius: 15px !important;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.modern-accordion .accordion-button {
    padding: 1.25rem 1.5rem;
    font-weight: 600;
    background: white;
    border: none;
}

.modern-accordion .accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
}

.modern-accordion .accordion-button:focus {
    box-shadow: none;
}

.question-icon {
    display: inline-flex;
    margin-right: 1rem;
    color: var(--primary);
    font-size: 1.25rem;
}

.accordion-button:not(.collapsed) .question-icon {
    color: white;
}

.accordion-body {
    padding: 1.5rem;
    color: var(--gray);
    line-height: 1.8;
}

/* Partners Slider */
.partners-slider {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 3rem;
    align-items: center;
}

.partner-item {
    padding: 1rem;
    opacity: 0.6;
    transition: all 0.3s ease;
    filter: grayscale(1);
}

.partner-item:hover {
    opacity: 1;
    filter: grayscale(0);
    transform: scale(1.1);
}

.partner-item img {
    max-width: 150px;
    height: auto;
}

/* CTA Section */
.cta-section {
    position: relative;
    min-height: 500px;
    display: flex;
    align-items: center;
}

.cta-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.cta-image {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

.overlay-gradient {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.9), rgba(124, 58, 237, 0.9));
}

.btn-light-custom {
    background: white;
    color: var(--primary);
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-light-custom:hover {
    background: transparent;
    color: white;
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.btn-outline-light {
    background: transparent;
    color: white;
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    border: 2px solid white;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-outline-light:hover {
    background: white;
    color: var(--primary);
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.cta-features {
    margin-top: 3rem;
}

.cta-feature {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: white;
    opacity: 0.9;
}

.cta-feature i {
    font-size: 2rem;
}

/* Section Badge */
.section-badge {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(124, 58, 237, 0.1));
    color: var(--primary-dark);
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    border: 1px solid rgba(37, 99, 235, 0.2);
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
    }
    70% {
        box-shadow: 0 0 0 15px rgba(255, 255, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
    }
}

/* Responsive Design */
@media (max-width: 1199px) {
    .display-3 {
        font-size: 2.5rem;
    }

    .floating-element {
        display: none;
    }
}

@media (max-width: 991px) {
    .hero-section {
        padding-top: 120px;
        text-align: center;
    }

    .live-stats {
        justify-content: center;
    }

    .store-badges {
        margin-top: 2rem;
    }

    .stats-overlay {
        position: relative;
        top: auto;
        left: auto;
        width: 100%;
        margin-top: 1rem;
    }
}

@media (max-width: 768px) {
    .display-3 {
        font-size: 2rem;
    }

    .display-5 {
        font-size: 1.75rem;
    }

    .hero-badge {
        font-size: 0.875rem;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }

    .live-stats {
        flex-direction: column;
        gap: 1rem;
    }

    .stat-item {
        width: 100%;
    }

    .partners-slider {
        gap: 1.5rem;
    }

    .partner-item img {
        max-width: 100px;
    }

    .cta-features .row {
        gap: 1.5rem;
    }
}

@media (max-width: 576px) {
    .display-3 {
        font-size: 1.75rem;
    }

    .section-badge {
        font-size: 0.75rem;
        padding: 0.4rem 1rem;
    }

    .step-image {
        width: 150px;
        height: 150px;
    }

    .store-badges {
        flex-direction: column;
        align-items: center;
    }

    .store-badges img {
        height: 40px;
    }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: var(--light);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, var(--primary-dark), #6d28d9);
}
</style>

<script>
// Enhanced JavaScript with animations
document.addEventListener('DOMContentLoaded', function() {
    // Hero Slider
    const slides = document.querySelectorAll('.hero-slider .slide');
    let currentSlide = 0;

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    setInterval(nextSlide, 5000);

    // Counter Animation
    const counters = document.querySelectorAll('.counter-number, .stat-item span:not(.text-white-50)');

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                if (counter.classList.contains('counter-number')) {
                    animateCounter(counter);
                } else if (counter.classList.contains('counter')) {
                    animateCounter(counter);
                }
                counterObserver.unobserve(counter);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });

    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        let current = 0;
        const increment = target / 100;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.innerText = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.innerText = Math.floor(current).toLocaleString();
            }
        }, 20);
    }

    // Initialize AOS with enhanced settings
    AOS.init({
        duration: 1000,
        once: true,
        offset: 50,
        easing: 'ease-in-out'
    });

    // Initialize GLightbox for videos
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });

    // Parallax Effect
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('[data-parallax]');

        parallaxElements.forEach(element => {
            const speed = element.getAttribute('data-parallax-speed') || 0.5;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Navbar Background Change on Scroll
    window.addEventListener('scroll', () => {
        const header = document.querySelector('.header');
        if (window.scrollY > 50) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
    });

    // Typing Animation Reset
    const typingElement = document.querySelector('.typing-text');
    setInterval(() => {
        typingElement.style.animation = 'none';
        typingElement.offsetHeight; // Trigger reflow
        typingElement.style.animation = 'typing 4s steps(40) infinite';
    }, 8000);
});
</script>
@endsection
