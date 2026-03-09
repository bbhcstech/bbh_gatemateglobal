<footer id="footer" class="footer">
    <div class="footer-newsletter py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-6">
                    <h4 class="fw-bold mb-3">Stay Updated</h4>
                    <p class="text-muted mb-4">Subscribe to our newsletter for the latest updates and features</p>
                    <form action="#" method="post" class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email" required>
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container footer-top py-5">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-about">
                    <a href="/" class="logo mb-3 d-block">
                        <span class="logo">GateMate<span style="color: var(--primary);">Global</span></span>
                    </a>
                    <p class="text-muted">Making society management smart, simple, and secure. Trusted by 500+ residential societies across India.</p>
                    <div class="social-links mt-4">
                        <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3">
                <h5 class="fw-bold mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#hero">Home</a></li>
                    <li class="mb-2"><a href="#features">Features</a></li>
                    <li class="mb-2"><a href="#pricing">Pricing</a></li>
                    <li class="mb-2"><a href="#testimonials">Testimonials</a></li>
                    <li class="mb-2"><a href="#contact">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3">
                <h5 class="fw-bold mb-4">Features</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#">Visitor Management</a></li>
                    <li class="mb-2"><a href="#">Resident Management</a></li>
                    <li class="mb-2"><a href="#">Billing & Payments</a></li>
                    <li class="mb-2"><a href="#">Helpdesk</a></li>
                    <li class="mb-2"><a href="#">Security</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h5 class="fw-bold mb-4">Contact Info</h5>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex">
                        <i class="bi bi-geo-alt-fill text-primary me-3"></i>
                        <span>123 Business Park, Andheri East, Mumbai - 400001</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="bi bi-telephone-fill text-primary me-3"></i>
                        <span>+91 98765 43210</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="bi bi-envelope-fill text-primary me-3"></i>
                        <span>info@gatemateglobal.com</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container copyright text-center py-4">
        <div class="row">
            <div class="col-12">
                <p class="mb-0">© <span>Copyright</span> <strong class="px-1">GateMateGlobal</strong> <span>All Rights Reserved</span></p>
                <p class="small text-muted mt-2">
                    <a href="#" class="text-muted me-3">Privacy Policy</a>
                    <a href="#" class="text-muted me-3">Terms of Service</a>
                    <a href="#" class="text-muted">Cookie Policy</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('frontend/assets/vendor/aos/aos.js')}}"></script>
<script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

<!-- Main JS File -->
<script src="{{ asset('frontend/assets/js/main.js')}}"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Scroll to top
    const scrollTop = document.querySelector('#scroll-top');
    if (scrollTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        });

        scrollTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Footer styles
    const style = document.createElement('style');
    style.textContent = `
        .footer {
            background: #fff;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .footer-newsletter .form-control {
            padding: 0.8rem;
            border-radius: 50px 0 0 50px;
            border: 1px solid rgba(0,0,0,0.1);
        }

        .footer-newsletter .btn {
            border-radius: 0 50px 50px 0;
            padding: 0.8rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
        }

        .footer-newsletter .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .footer ul {
            padding-left: 0;
        }

        .footer ul li a {
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer ul li a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border-radius: 50%;
            margin-right: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .scroll-top {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 10px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            background: var(--secondary);
            transform: translateY(-3px);
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #preloader::before {
            content: "";
            width: 40px;
            height: 40px;
            border: 3px solid rgba(67, 97, 238, 0.2);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);

    // Hide preloader on load
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.transition = 'opacity 0.5s ease';
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    });
</script>

</body>
</html>
