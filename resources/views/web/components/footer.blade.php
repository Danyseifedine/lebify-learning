<footer class="container-fluid app-bg" style="padding-bottom: 50px !important;">
    <div class="container pt-12">
        <div class="text-center footer-bg text-lg-start">
            <!-- Grid container -->
            <div class="container p-4">
                <!--Grid row-->
                <div class="row my-4">
                    <!--Grid column-->
                    <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                        <div class="d-flex align-items-center">
                            <img alt="{{ __('common.lebify_learning_logo') }}" src="/vendor/img/logo/lebify-logo.svg"
                                class="h-50px h-lg-50px app-sidebar-logo-default me-1">
                            <h2 class="h1">{{ __('common.lebify_learning') }}</h2>
                        </div>
                        <p class="pt-5 mx-5">{{ __('common.footer_description') }}</p>
                        <ul class="list-unstyled mx-5 pt-5 d-flex justify-content-center justify-content-lg-start">
                            <li><a target="_blank" href="https://github.com/Danyseifedine" class="me-3 text-dark"
                                    aria-label="GitHub"><img src="{{ asset('vendor/img/card-icon/github.png') }}"
                                        width="30" height="30" alt="" aria-hidden="true"></a></li>
                            <li><a target="_blank" href="https://www.linkedin.com/in/dany-seifeddine-ab6558247/"
                                    class="me-3 text-dark" aria-label="LinkedIn"><img
                                        src="{{ asset('vendor/img/card-icon/linkedin.png') }}" width="30"
                                        height="30" alt="" aria-hidden="true"></a></li>
                            <li><a target="_blank" href="https://www.instagram.com/danny__seifeddine/" class="text-dark"
                                    aria-label="Instagram"><img src="{{ asset('vendor/img/card-icon/instagram.png') }}"
                                        width="30" height="30" alt="" aria-hidden="true"></a></li>
                        </ul>
                    </div>
                    <!--Grid column-->
                    <div class="col-lg-3 d-flex flex-column justify-content-center col-md-6 mb-4 mb-md-0">
                    </div>

                    <!--Grid column-->
                    <div class="col-lg-3 d-flex flex-column justify-content-center col-md-6 mb-4 mb-md-0">
                        <h3 class="h5 text-uppercase mb-4">{{ __('common.contact') }}</h3>
                        <ul class="list-unstyled">
                            <li>
                                <p><img src="{{ asset('vendor/img/card-icon/map.png') }}" class="me-3" width="30"
                                        height="30" alt=""
                                        aria-hidden="true">{{ __('common.barja_lebanon') }}</p>
                            </li>
                            <li>
                                <p><img src="{{ asset('vendor/img/card-icon/phone.png') }}" class="me-3"
                                        width="30" height="30" alt=""
                                        aria-hidden="true">{{ __('common.phone_number') }}</p>
                            </li>
                            <li>
                                <p><img src="{{ asset('vendor/img/card-icon/mail.png') }}" class="me-3"
                                        width="30" height="30" alt=""
                                        aria-hidden="true">{{ __('common.email_address') }}</p>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </div>
            <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                {{ __('common.copyright') }}
                <a class="text-white" href="https://www.lebify.com">Lebify.com</a>
            </div>
            <!-- Copyright -->
        </div>
    </div>
</footer>
