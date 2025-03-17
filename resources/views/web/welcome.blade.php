@extends('web.layouts.main')

@section('title', 'Full Stack Development with Dany Seifeddine')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/web/landing.css', true) }}">
    @endpush

    {{-- hero --}}
    <header id="hero-section"
        class="hero-section overflow-hidden d-flex align-items-center flex-wrap justify-content-center position-relative position-relative-hero">
        <!-- Background shapes -->
        <img src="{{ asset('core/vendor/img/landing/dotted-shape.svg') }}" alt="" class="dotted-shape dotted-1"
            aria-hidden="true">
        <img src="{{ asset('core/vendor/img/landing/dotted-shape.svg') }}" alt="" class="dotted-shape dotted-2"
            aria-hidden="true">
        <img src="{{ asset('core/vendor/img/landing/second-shape.svg') }}" alt="" class="floating-shape shape-1"
            aria-hidden="true">
        <img src="{{ asset('core/vendor/img/landing/second-shape.svg') }}" alt="" class="floating-shape shape-2"
            aria-hidden="true">
        <img src="{{ asset('core/vendor/img/landing/random-shape-1.svg') }}" class="random-shape random-shape-1"
            alt="React" aria-hidden="true">
        <img src="{{ asset('core/vendor/img/landing/random-shape-2.svg') }}" class="random-shape random-shape-2"
            alt="React" aria-hidden="true">

        <div class="text-start">
            <h1 class="lebify-huge-text mt-5 mb-4">Code Your Future, Build Your Dreams</h1>
            <p class="lebify-medium-text mb-12 mt-5">Join a vibrant community of developers and turn your coding passion
                into professional expertise. Learn through immersive projects, master in-demand technologies, and build
                real-world applications that make an impact.</p>
            <nav class="d-flex nav-hero justify-content-start flex-wrap">
                @guest
                    <button data-bs-toggle="modal" data-bs-target="#join-now-modal" class="btn bg-logo btn-lg me-4">
                        Start Creating Today
                    </button>
                @endguest

                @auth
                    <a href="#courses-features" class="btn logo-border btn-outline-secondary btn-lg">
                        Explore Courses
                    </a>
                @endauth
                <div class="d-flex align-items-center gap-2">
                    <button class="play-video-btn">
                        <i class="fa-solid fa-play text-white p-0"></i>
                    </button>
                    <span class="watch-demo-text">Watch Demo</span>
                </div>
            </nav>
        </div>
        <div class="position-relative">
            <img src="{{ asset('core/vendor/img/landing/landing.svg') }}" alt="Programming Education" width="600"
                class="main-illustration">
            <div class="floating-elements">
                <div class="tech-badge react">
                    <img src="{{ asset('core/vendor/img/landing/react.svg') }}" alt="React" aria-hidden="true">
                </div>
                <div class="tech-badge angular">
                    <img src="{{ asset('core/vendor/img/landing/angular.svg') }}" alt="Angular" aria-hidden="true">
                </div>
                <div class="tech-badge php">
                    <img src="{{ asset('core/vendor/img/landing/php.svg') }}" alt="PHP" aria-hidden="true">
                </div>
            </div>
        </div>

        <!-- Add scroll indicator -->
        <div class="scroll-indicator">
            <div class="mouse"></div>
            <small>Scroll to explore</small>
        </div>
    </header>

    {{-- Statistics Cards Section --}}
    <section class="container statistics-section py-5" id="statistics-section">
        <div class="row g-4 justify-content-center">
            {{-- Online Courses Card --}}
            <div class="col-md-6 col-lg-3">
                <div class="stat-card courses-card">
                    <div class="stat-icon">
                        <i class="bi bi-display icon-stat" style="color: #F5B401 !important;"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">10K</h3>
                        <p class="stat-label fw-bold">Online Courses</p>
                    </div>
                </div>
            </div>

            {{-- Expert Tutors Card --}}
            <div class="col-md-6 col-lg-3">
                <div class="stat-card tutors-card">
                    <div class="stat-icon">
                        <i class="bi bi-person-circle icon-stat" style="color: #2C3E50 !important;"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">200+</h3>
                        <p class="stat-label fw-bold">Expert Tutors</p>
                    </div>
                </div>
            </div>

            {{-- Online Students Card --}}
            <div class="col-md-6 col-lg-3">
                <div class="stat-card students-card">
                    <div class="stat-icon">
                        <i class="bi bi-mortarboard icon-stat" style="color: #8E44AD !important;"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">60K+</h3>
                        <p class="stat-label fw-bold">Online Students</p>
                    </div>
                </div>
            </div>

            {{-- Certified Courses Card --}}
            <div class="col-md-6 col-lg-3">
                <div class="stat-card certified-card">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle icon-stat" style="color: #16A085 !important;"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">6K+</h3>
                        <p class="stat-label fw-bold">Certified Courses</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Choose Us Section --}}
    <section class="why-choose-us-section py-5" id="why-choose-us-section"
        style="margin-top: 100px !important; padding-top: 50px !important;padding-bottom: 50px !important;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="choose-us-image">
                        <div class="image-backdrop"></div>
                        <div class="floating-bubble bubble-1"></div>
                        <div class="floating-bubble bubble-2"></div>
                        <div class="floating-bubble bubble-3"></div>
                        <img src="{{ asset('core/vendor/img/landing/why-us.svg') }}" alt="Why Choose Us"
                            class="img-fluid main-image">
                        <div class="experience-badge">
                            <span class="number">5+</span>
                            <span class="text">Years of Excellence</span>
                        </div>
                        <div class="stats-badge">
                            <div class="stat-item">
                                <span class="number">98%</span>
                                <span class="label">Success Rate</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="choose-us-content">
                        <x-web.section-badge title="WHY CHOOSE US" />
                        <h2 class="display-4 fw-bold mb-4">Transform Your Career With Expert-Led Learning</h2>
                        <p class="lead mb-5">Join thousands of students who have already taken the first step towards their
                            dream career in tech.</p>

                        <div class="features-list">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-code-slash"></i>
                                </div>
                                <div class="feature-text">
                                    <h4>Interactive Learning</h4>
                                    <p>Get hands-on experience with real projects and practical assignments</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div class="feature-text">
                                    <h4>Career Growth</h4>
                                    <p>Clear path to advance your career with industry-recognized certifications</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="feature-text">
                                    <h4>Expert Instructors</h4>
                                    <p>Learn from professionals with real-world experience in top tech companies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Quiz Features Section --}}
    <section class="quiz-features-section" id="quiz-features-section"
        style="margin-top: 100px;background-image: url('{{ asset('core/vendor/img/landing/quiz.svg') }}');background-size: cover;background-position: center;">
        <div class="container">
            <div class="text-center mb-5">
                <x-web.section-badge title="QUIZ SYSTEM" />
                <h2 class="display-4 fw-bold mb-4">Advanced Quiz Features</h2>
                <p class="lead mb-5 mx-auto" style="max-width: 600px">Experience a comprehensive quiz system designed to
                    challenge and track your progress</p>
            </div>

            <div class="quiz-features-grid">
                <div class="quiz-feature-card">
                    <div class="card-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h4>Secure Testing</h4>
                    <p>Anti-cheat system with time tracking and attempt monitoring</p>
                    <div class="card-overlay"></div>
                </div>

                <div class="quiz-feature-card">
                    <div class="card-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4>Real-time Progress</h4>
                    <p>Instant feedback and detailed performance analytics</p>
                    <div class="card-overlay"></div>
                </div>

                <div class="quiz-feature-card">
                    <div class="card-icon">
                        <i class="bi bi-bar-chart-steps"></i>
                    </div>
                    <h4>Difficulty Levels</h4>
                    <p>Progressive difficulty from beginner to advanced</p>
                    <div class="card-overlay"></div>
                </div>

                <div class="quiz-feature-card">
                    <div class="card-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h4>Performance Stats</h4>
                    <p>Detailed statistics for every attempt and topic</p>
                    <div class="card-overlay"></div>
                </div>

                <div class="quiz-feature-card">
                    <div class="card-icon">
                        <i class="bi bi-stopwatch"></i>
                    </div>
                    <h4>Timed Challenges</h4>
                    <p>Time-based quizzes to test your speed and accuracy</p>
                    <div class="card-overlay"></div>
                </div>

                <div class="quiz-feature-card">
                    <div class="card-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h4>Achievement System</h4>
                    <p>Earn badges and track your milestones</p>
                    <div class="card-overlay"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Coin Wallet Section --}}
    <div
        style="background-image: url('{{ asset('core/vendor/img/landing/credit-card-bg.svg') }}');background-size: cover;background-position: center;">
        <section class="coin-wallet-section" style="margin-top: 100px !important;" id="coin-wallet-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wallet-content">
                            <x-web.section-badge title="REWARDS SYSTEM" />
                            <h2 class="display-4 fw-bold mb-4">Earn While You Learn</h2>
                            <p class="lead mb-5">Transform your learning experience with our innovative LFT token system.
                                Earn
                                tokens as you progress and unlock exclusive features.</p>

                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <p>Earn tokens for completing courses and achieving high scores</p>
                                </div>
                                <div class="info-item">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-unlock-fill"></i>
                                    </div>
                                    <p>Access premium content and exclusive learning materials</p>
                                </div>
                                <div class="info-item">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-award-fill"></i>
                                    </div>
                                    <p>Get certified and showcase your achievements</p>
                                </div>
                                <div class="info-item">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-lightning-fill"></i>
                                    </div>
                                    <p>Fast-track your learning with premium features</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="wallet-3d-container">
                            <div class="wallet-card">
                                <div class="wallet-front">
                                    <div class="wallet-balance">
                                        <span class="balance-label">Your Balance</span>
                                        <span class="balance-amount">1,234</span>
                                        <span class="coin-symbol">LFT</span>
                                    </div>
                                    <div class="card-details">
                                        <div class="card-number">**** **** **** 1234</div>
                                        <div class="card-holder">DANY SEIFEDDINE</div>
                                    </div>
                                    <div class="card-chip"></div>
                                    <div class="card-wave"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- YouTube Section --}}
    <section class="youtube-promo-section" id="youtube-promo-section">
        <div class="container">
            <div class="youtube-promo-card">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <div class="youtube-content">
                            <x-web.section-badge title="YOUTUBE CHANNEL" />
                            <h2 class="display-4 fw-bold mb-4">Master Web Development</h2>
                            <p class="lead mb-4">Access a growing library of tutorials and live coding sessions. Learn
                                modern web development through practical, project-based videos.</p>

                            <div class="channel-stats mb-4">
                                <div class="stat-box">
                                    <span class="stat-number">100+</span>
                                    <span class="stat-label-video">Videos</span>
                                </div>
                                <div class="stat-box">
                                    <span class="stat-number">5K+</span>
                                    <span class="stat-label-video">Subscribers</span>
                                </div>
                                <div class="stat-box">
                                    <span class="stat-number">500+</span>
                                    <span class="stat-label-video">Hours</span>
                                </div>
                            </div>

                            <a href="https://www.youtube.com/@lebify" target="_blank" class="btn bg-logo mt-5">
                                <span class="btn-content">
                                    <span>Subscribe Now</span>
                                </span>
                                <span class="btn-shine"></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 position-relative">
                        <div class="youtube-icon-wrapper">
                            <div class="youtube-icon-morph">
                                <svg viewBox="0 0 68 48" class="youtube-icon">
                                    <path class="youtube-icon-bg"
                                        d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"
                                        fill="#F77E15" />
                                    <path class="youtube-icon-play" d="M 45,24 27,14 27,34" fill="#FFFFFF" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials & Contact Section --}}
    <section class="testimonials-section" id="testimonials-section">
        <div class="container">
            {{-- Testimonials Part --}}
            <div class="testimonials-wrapper mb-5">
                <div class="testimonials-header text-center">
                    <x-web.section-badge title="TESTIMONIALS" />
                    <h2 class="display-4 fw-bold">Some valuable feedback from our students</h2>
                    <div class="rating-overview justify-content-center">
                        <div class="rating-circle">
                            <svg viewBox="0 0 36 36" class="rating-circle-svg">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="rgba(247, 126, 21, 0.1)" stroke-width="3" />
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="#F77E15" stroke-width="3" stroke-dasharray="75, 100" />
                            </svg>
                            <div class="rating-content">
                                <span class="rating-value">4.5</span>
                                <span class="rating-label">out of 5.0</span>
                            </div>
                        </div>
                        <div class="rating-info">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p>Based on 76 ratings</p>
                        </div>
                    </div>
                </div>

                <!-- First row - moving right to left -->
                <div class="testimonials-scroll">
                    <div class="testimonials-track">
                        <x-web.testimonial-card image="{{ asset('core/vendor/img/default/girl-default.jpg') }}"
                            name="Dr Alaa Abou Darwish" rating="5.0"
                            text="I think this project shows the ambition the creator has, and it has potential for the upcoming generation." />

                        <x-web.testimonial-card image="{{ asset('core/vendor/img/default/boy-default.jpg') }}"
                            name="Tobi Femi" rating="4.5" role="Full Stack Developer"
                            text="Very detailed and helpful, I've learnt so much already, and feeling much more confident as a full stack developer." />

                        <x-web.testimonial-card image="{{ asset('core/vendor/img/default/boy-default.jpg') }}"
                            name="Hamza Oweidat" rating="4.5" role="Full Stack Developer"
                            text="I've been learning from Dany for a while now and I've learned so much from him. He's a great teacher and I highly recommend him." />

                        <x-web.testimonial-card image="core/vendor/img/default/boy-default.jpg" name="Ahmad Seifeddine"
                            role="Full Stack Developer" rating="5.0"
                            text="The website offers a well-structured and engaging learning experience, making complex topics easy to grasp. ❤️" />

                        <!-- Duplicate first two cards for infinite scroll -->
                        <x-web.testimonial-card image="{{ asset('core/vendor/img/default/boy-default.jpg') }}"
                            name="Tobi Femi" rating="4.5" role="Full Stack Developer"
                            text="Very detailed and helpful, I've learnt so much already, and feeling much more confident as a full stack developer." />

                        <x-web.testimonial-card image="{{ asset('core/vendor/img/default/boy-default.jpg') }}"
                            name="Rafeh Soaifan" rating="4.5" role="Full Stack Developer"
                            text="Learning from Dany has been amazing! 🚀 He's an excellent teacher and I've learned so much! Highly recommend! ⭐" />
                    </div>
                </div>
                <div class="testimonials-scroll reverse">
                    <div class="testimonials-track">
                        <x-web.testimonial-card image="{{ asset('core/vendor/img/testimonials/aya.jpeg') }}"
                            name="Aya Yasser" role="UI/UX Designer" rating="5.0"
                            text="The platform is really helpful and well organized. The explanations are clear and easy to follow. A great learning experience , I highly recommend it! ♥️" />

                        <x-web.testimonial-card image="{{ asset('core/vendor/img/default/girl-default.jpg') }}"
                            name="Omaima Hatiti" rating="4.5" role="Frontend Developer"
                            text="Thanks Dany! I learned so much from your courses. Your support, especially with the project meeting, was invaluable." />

                        <x-web.testimonial-card image="{{ asset('core/vendor/img/testimonials/mohamad-mansour.png') }}"
                            name="Mohamad Mansour" rating="4.5" role="Full Stack Developer"
                            text="This platform offers top-notch web and app development lessons. Perfect for beginners and pros alike! 🖤" />

                        <x-web.testimonial-card image="{{ asset('core/vendor/img/default/boy-default.jpg') }}"
                            name="Ahmad Chebbo" role="Senior Full Stack Developer" rating="5.0"
                            text="The platform offers an exceptional learning experience with well-structured content." />

                        <!-- Duplicate first two cards for infinite scroll -->
                        <x-web.testimonial-card image="{{ asset('core/vendor/img/testimonials/aya.jpeg') }}"
                            name="Aya Yasser" role="UI/UX Designer" rating="5.0"
                            text="The platform is really helpful and well organized. The explanations are clear and easy to follow. A great learning experience , I highly recommend it! ♥️" />

                        <x-web.testimonial-card image="{{ asset('core/vendor/img/default/girl-default.jpg') }}"
                            name="Omaima Hatiti" rating="4.5" role="Frontend Developer"
                            text="Thanks Dany! I learned so much from your courses. Your support, especially with the project meeting, was invaluable." />
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Us Section --}}
    <section class="contact-us-section py-5" id="contact-us-section">
        <div class="container">
            <div class="text-center mb-4">
                <x-web.section-badge title="GET IN TOUCH" />
                <h2 class="display-4 fw-bold mb-3">Need Help? Let's Talk</h2>
                <p class="lead col-md-8 mx-auto">Ready to take your development skills to the next level? Drop us a message
                    and we'll get back to you.</p>
            </div>

            <div class="contact-wrapper mt-12">
                <div class="contact-card">
                    <div class="contact-background-pattern"></div>
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="contact-info-side">
                                <div class="contact-info-content">
                                    <div class="contact-header">
                                        <div class="header-icon">
                                            <i class="bi bi-chat-square-heart-fill text-white fs-3"></i>
                                        </div>
                                        <h3>Let's connect</h3>
                                        <p class="">We're here to help and answer any question you might
                                            have</p>
                                    </div>

                                    <div class="contact-methods">
                                        <div class="contact-method-item">
                                            <div class="icon-box">
                                                <i class="bi bi-envelope-paper-heart text-white fs-3"></i>
                                            </div>
                                            <div class="method-details">
                                                <h5>Email Us</h5>
                                                <p>support@lebify.com</p>
                                            </div>
                                            <div class="hover-indicator"></div>
                                        </div>
                                        <div class="contact-method-item">
                                            <div class="icon-box">
                                                <i class="bi bi-telephone-outbound text-white fs-3"></i>
                                            </div>
                                            <div class="method-details">
                                                <h5>Call Us</h5>
                                                <p>+961 71 777 498</p>
                                            </div>
                                            <div class="hover-indicator"></div>
                                        </div>
                                        <div class="contact-method-item">
                                            <div class="icon-box">
                                                <i class="bi bi-geo-alt-fill text-white fs-3"></i>
                                            </div>
                                            <div class="method-details">
                                                <h5>Visit Us</h5>
                                                <p>Beirut, Lebanon</p>
                                            </div>
                                            <div class="hover-indicator"></div>
                                        </div>
                                    </div>

                                    <div class="contact-social">
                                        <div class="divider">
                                            <span>Follow us on</span>
                                        </div>
                                        <div class="social-icons">
                                            <a href="#" class="social-icon" data-tooltip="Facebook">
                                                <i class="bi bi-facebook fs-3 text-white"></i>
                                                <div class="icon-background"></div>
                                            </a>
                                            <a href="#" class="social-icon" data-tooltip="LinkedIn">
                                                <i class="bi bi-linkedin fs-3 text-white"></i>
                                                <div class="icon-background"></div>
                                            </a>
                                            <a href="#" class="social-icon" data-tooltip="Instagram">
                                                <i class="bi bi-instagram fs-3 text-white"></i>
                                                <div class="icon-background"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 ">
                            <div class="contact-form-side">
                                <form class="contact-form" form-id="feedback-form" http-request feedback
                                    route="{{ route('students.feedback') }}" identifier="single-form-post-handler"
                                    success-toast clear-form>
                                    <div class="contact-form-title">
                                        <h4>Send us a Message</h4>
                                        <p>Fill out the form below, and we'll get back to you shortly.</p>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group-animated">
                                                <input type="text" class="form-control modern-input"
                                                    feedback-id="name-feedback" name="name" id="name"
                                                    placeholder="Your Name" required>
                                            </div>
                                            <div class="invalid-feedback" id="name-feedback"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group-animated">
                                                <input type="email" class="form-control modern-input"
                                                    feedback-id="email-feedback" name="email" id="email"
                                                    placeholder="Your Email" required>
                                            </div>
                                            <div class="invalid-feedback" id="email-feedback"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group-animated">
                                                <select class="form-select modern-input" feedback-id="subject-feedback"
                                                    name="subject" id="subject" required>
                                                    <option value="" selected disabled>
                                                        {{ __('common.choose_subject') }}</option>
                                                    <option value="course_inquiry">{{ __('common.course_inquiry') }}
                                                    </option>
                                                    <option value="technical_support">{{ __('common.technical_support') }}
                                                    </option>
                                                    <option value="partnership">{{ __('common.partnership_opportunity') }}
                                                    </option>
                                                    <option value="feedback">{{ __('common.feedback') }}</option>
                                                    <option value="other">{{ __('common.other') }}</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback" id="subject-feedback"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group-animated">
                                                <textarea class="form-control modern-input" feedback-id="message-feedback" name="message" id="message"
                                                    placeholder="Your Message" required></textarea>
                                            </div>
                                            <div class="invalid-feedback" id="message-feedback"></div>
                                        </div>
                                        <div class="col-12">
                                            <button loading-text="{{ __('common.sending') }}"
                                                submit-form-id="feedback-form" type="submit"
                                                class="btn bg-logo d-flex align-items-center justify-content-center gap-2 btn-lg w-100">
                                                <span class="button-text">Send Message</span>
                                                <span class="button-icon">
                                                    <i class="bi bi-send-fill text-white fs-3"></i>
                                                </span>
                                                <div class="button-background"></div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- @if (auth()->check() && (auth()->user()->email == 'student@lebify.online' || !auth()->user()->hasVerifiedEmail()))
        <div class="modal fade show" id="updateEmailModal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="updateEmailModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-body p-0">
                        <div class="verification-wrapper">
                            <!-- Decorative Elements -->
                            <div class="verification-background">
                                <div class="circle-1"></div>
                                <div class="circle-2"></div>
                            </div>

                            <!-- Header Section -->
                            <div class="verification-header text-center">
                                <div class="verification-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <h4 class="verification-title">{{ __('common.email_verification_required') }}</h4>
                                <p class="verification-subtitle">{{ __('common.update_email_to_continue') }}</p>
                            </div>

                            <!-- Form Section -->
                            <div class="verification-form">
                                <form form-id="verification-form" http-request route="{{ route('verification.resend') }}"
                                    identifier="single-form-post-handler" success-toast feedback method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="email-update" class="form-label">{{ __('common.email') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input type="email" feedback-id="email-update-feedback" name="email-update"
                                                class="form-control" id="email-update"
                                                placeholder="{{ __('common.update_email_placeholder') }}"
                                                value="{{ auth()->user()->email }}">
                                        </div>
                                        <div class="invalid-feedback" id="email-update-feedback"></div>
                                        <div class="form-text">
                                            {{ __('common.update_email_required') }}
                                        </div>
                                    </div>

                                    <button submit-form-id="verification-form" type="submit"
                                        class="verification-button">
                                        <span class="button-content">
                                            <i class="bi text-white fs-3 bi-envelope-check me-2"></i>
                                            {{ __('common.update_email_button') }}
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    @push('scripts')
        <script src="{{ asset('core/packages/gsap/gsap.min.js') }}"></script>
        <script src="{{ asset('core/packages/gsap/ScrollTrigger.min.js') }}"></script>
        <script src="{{ asset('core/packages/gsap/Draggable.min.js') }}"></script>
        <script src="{{ asset('core/packages/gsap/MotionPathPlugin.min.js') }}"></script>
        <script src="{{ asset('js/web/landing/landing.js') }}" type="module" defer></script>
    @endpush
@endsection
