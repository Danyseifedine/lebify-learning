<div class="mt-12 footer-container">
    <footer class="modern-footer">
        <div class="footer-content">
            <div class="container">
                <!-- Logo and Newsletter Section -->
                <div class="footer-logo-section mb-12">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center gap-3">
                                <img alt="{{ __('common.lebify_learning_logo') }}"
                                    src="{{ asset('core/vendor/img/logo/lebify-logo.svg') }}" class="footer-logo">
                                <h2 class="brand-title mb-0">{{ __('common.lebify_learning') }}</h2>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="newsletter-wrapper">
                                <h3 class="newsletter-title mt-5">Subscribe to Our Newsletter</h3>
                                <form class="newsletter-form" form-id="newsletter-form-submit" http-request
                                    route="{{ route('submit-newsletter') }}" success-toast
                                    identifier="single-form-post-handler" feedback rate-limit="5000">
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="email"
                                            feedback-id="newsletter-form-feedback" placeholder="Enter your email">
                                        <button type="submit" submit-form-id="newsletter-form-submit"
                                            class="btn bg-logo">Subscribe</button>
                                    </div>
                                </form>
                                <div class="feedback-message d-flex justify-content-end feedback invalid-feedback"
                                    id="newsletter-form-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Navigation Links -->
                <div class="row g-5 mb-12">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-section">
                            <h3 class="footer-title">Home</h3>
                            <ul class="footer-nav">
                                <li><a href="#hero-section">Hero</a></li>
                                <li><a href="#statistics-section">Statistics</a></li>
                                <li><a href="#why-choose-us-section">Why Choose Us</a></li>
                                <li><a href="#quiz-features-section">Quiz</a></li>
                                <li><a href="#coin-wallet-section">Coin Wallet</a></li>
                                <li><a href="#youtube-promo-section">Youtube Promo</a></li>
                                <li><a href="#testimonials-section">Testimonials</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-section">
                            <h3 class="footer-title">Learning</h3>
                            <ul class="footer-nav">
                                <li><a href="#quiz-features">Quiz System</a></li>
                                <li><a href="#coin-wallet">Rewards System</a></li>
                                <li><a href="#youtube-promo">Video Tutorials</a></li>
                                <li><a href="#testimonials">Success Stories</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-section">
                            <h3 class="footer-title">Contact</h3>
                            <div class="contact-info">
                                <p><i class="bi bi-geo-alt me-2"></i>Barja, Mount Lebanon</p>
                                <p><i class="bi bi-telephone me-2"></i>+961 03 004 699</p>
                                <p><i class="bi bi-envelope me-2"></i>lebify@gmail.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-section">
                            <h3 class="footer-title">Business</h3>
                            <ul class="footer-nav">
                                <li><a href="#contact">Contact Us</a></li>
                                <li><a href="#partnership">Partnership</a></li>
                                <li><a href="#about-us">About Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Copyright Bar -->
                <div class="footer-divider"></div>
                <div class="footer-bottom-content py-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="copyright-text mb-0">
                                {{ __('common.copyright') }} <a href="https://www.lebify.online">Lebify.online</a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="footer-extra-links">
                                <a href="#">Privacy Policy</a>
                                <a href="#">Terms of Service</a>
                                <a href="#">Cookie Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
