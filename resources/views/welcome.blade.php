@extends('layouts.main')

@section('title', 'Full Stack Development with Dany Seifeddine')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    @endpush

    {{-- hero --}}
    <header
        class="container-fluid hero-section overflow-hidden d-flex align-items-center justify-content-center position-relative">
        <div class="icon-container position-absolute w-100 h-100" aria-hidden="true">
            <img id="icon-pencil" src="{{ asset('vendor/img/default/pencil.png') }}" width="50" height="50"
                alt="Pencil icon" class="floating-icon">
            <img id="icon-rocket" src="{{ asset('vendor/img/default/rocket.png') }}" width="50" height="50"
                alt="Rocket icon" class="floating-icon">
            <img id="icon-tool-box" src="{{ asset('vendor/img/default/tool-box.png') }}" width="50" height="50"
                alt="Tool box icon" class="floating-icon">
            <img id="icon-video-lesson" src="{{ asset('vendor/img/default/video-lesson.png') }}" width="50"
                height="50" alt="Video lesson icon" class="floating-icon">
            <img id="wrench" src="{{ asset('vendor/img/default/wrench.png') }}" width="50" height="50"
                alt="Wrench icon" class="floating-icon">
            <img id="browser" src="{{ asset('vendor/img/default/browser.png') }}" width="50" height="50"
                alt="Browser icon" class="floating-icon">
        </div>
        <div class="text-center">
            <h1 class="display-2 fw-bold mt-5 mb-4"><span class="gsap-typewriter"></span></h1>
            <p class="lead fs-2 mb-5 mt-5"><span class="gsap-typewriter underline-oblique"></span></p>
            <h2 class="h2 mb-4 mt-5"><span class="gsap-typewriter"></span></h2>
            <p class="fs-4 mb-5 mt-5">
                <span class="gsap-typewriter"></span><br>
                <span class="gsap-typewriter"></span>
            </p>
            <nav class="d-flex justify-content-center gsap-fade-up" style="margin-top: 50px;">
                <button data-bs-toggle="modal" data-bs-target="#join-now-modal"
                    class="btn bg-logo btn-lg me-3 gsap-button">{{ __('common.join_now') }}</button>
                <a href="#courses-features"
                    class="btn logo-border btn-outline-secondary btn-lg gsap-button">{{ __('common.learn_more') }}</a>
            </nav>
        </div>
    </header>

    {{-- video --}}
    <section class="d-flex video-section pb-20 align-items-center justify-content-center app-bg">
        <div id="video-container" class="screen-container shadow-lg" aria-label="{{ __('common.promotional_video') }}"
            style="position: relative; z-index: 0; overflow: hidden; height: 50vh; max-width: 70%; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); margin: 40px auto;">
            <div class="screen-frame"
                style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 20px solid #333; border-radius: 20px; pointer-events: none;">
            </div>
            <div class="screen-content" style="position: relative; height: 100%; overflow: hidden; border-radius: 10px;">
                <div class="video-overlay"
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.3); z-index: 1;">
                </div>
                <video autoplay loop muted playsinline preload="metadata" loading="lazy"
                    style="width: 100%; height: 100%; object-fit: cover; position: relative; z-index: 0;">
                    <source src="{{ asset('vendor/vid/vid.mp4') }}" type="video/mp4">
                    <track kind="captions" src="{{ asset('path/to/captions.vtt') }}" srclang="en"
                        label="{{ __('common.english') }}">
                    {{ __('common.video_not_supported') }} <a
                        href="{{ asset('vendor/vid/vid.mp4') }}">{{ __('common.download_video') }}</a>.
                </video>
            </div>
            <div class="screen-reflection"
                style="position: absolute; top: 0; left: 0; right: 0; height: 40%; background: linear-gradient(to bottom, rgba(255,255,255,0.15), transparent); pointer-events: none;">
            </div>
        </div>
    </section>

    {{-- features --}}
    <section id="courses-features" class="container-fluid app-bg relative py-5 why-choose-our-courses"
        style="padding-top: 100px !important;">
        <div class="container">
            <h2 class="text-center display-4 fw-bold mb-6">{{ __('common.why_choose_our_courses') }}</h2>
            <p class="text-center lead mb-5">{{ __('common.transformative_journey') }}</p>
            <div class="separator mb-5" aria-hidden="true"></div>

            <div class="row g-5 justify-content-center pt-12">
                <div class="col-lg-4 col-md-6 mb-5">
                    <article class="feature-card">
                        <div class="feature-number">
                            <img src="{{ asset('vendor/img/card-icon/one.png') }}" width="40" height="40"
                                alt="{{ __('common.number_one_icon') }}">
                        </div>
                        <div class="feature-icon">
                            <div class="feature-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('vendor/img/card-icon/rocket.png') }}" width="100" height="100"
                                    alt="{{ __('common.rocket_icon') }}">
                            </div>
                        </div>
                        <h3 class="text-center">{{ __('common.cutting_edge_curriculum') }}</h3>
                        <p class="text-center">{{ __('common.cutting_edge_curriculum_desc') }}</p>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <article class="feature-card">
                        <div class="feature-number">
                            <img src="{{ asset('vendor/img/card-icon/two.png') }}" width="40" height="40"
                                alt="{{ __('common.number_two_icon') }}">
                        </div>
                        <div class="feature-icon">
                            <div class="feature-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('vendor/img/card-icon/laptop-screen.png') }}" width="100"
                                    height="100" alt="{{ __('common.laptop_screen_icon') }}">
                            </div>
                        </div>
                        <h3 class="text-center">{{ __('common.hands_on_projects') }}</h3>
                        <p class="text-center">{{ __('common.hands_on_projects_desc') }}</p>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <article class="feature-card">
                        <div class="feature-number">
                            <img src="{{ asset('vendor/img/card-icon/three.png') }}" width="40" height="40"
                                alt="{{ __('common.number_three_icon') }}">
                        </div>
                        <div class="feature-icon">
                            <div class="feature-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('vendor/img/card-icon/rating.png') }}" width="100" height="100"
                                    alt="{{ __('common.rating_icon') }}">
                            </div>
                        </div>
                        <h3 class="text-center">{{ __('common.expert_mentorship') }}</h3>
                        <p class="text-center">{{ __('common.expert_mentorship_desc') }}</p>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <article class="feature-card">
                        <div class="feature-number">
                            <img src="{{ asset('vendor/img/card-icon/four.png') }}" width="40" height="40"
                                alt="{{ __('common.number_four_icon') }}">
                        </div>
                        <div class="feature-icon">
                            <div class="feature-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('vendor/img/card-icon/yoga.png') }}" width="100" height="100"
                                    alt="{{ __('common.yoga_icon') }}">
                            </div>
                        </div>
                        <h3 class="text-center">{{ __('common.flexible_learning') }}</h3>
                        <p class="text-center">{{ __('common.flexible_learning_desc') }}</p>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <article class="feature-card">
                        <div class="feature-number">
                            <img src="{{ asset('vendor/img/card-icon/five.png') }}" width="40" height="40"
                                alt="{{ __('common.number_five_icon') }}">
                        </div>
                        <div class="feature-icon d-flex align-items-center justify-content-center">
                            <img src="{{ asset('vendor/img/card-icon/quiz.png') }}" width="100" height="100"
                                alt="{{ __('common.quiz_icon') }}">
                        </div>
                        <h3 class="text-center">{{ __('common.comprehensive_quizzes') }}</h3>
                        <p class="text-center">{{ __('common.comprehensive_quizzes_desc') }}</p>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <article class="feature-card">
                        <div class="feature-number">
                            <img src="{{ asset('vendor/img/card-icon/six.png') }}" width="40" height="40"
                                alt="{{ __('common.number_six_icon') }}">
                        </div>
                        <div class="feature-icon">
                            <div class="feature-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('vendor/img/card-icon/help-desk.png') }}" width="100"
                                    height="100" alt="{{ __('common.help_desk_icon') }}">
                            </div>
                        </div>
                        <h3 class="text-center">{{ __('common.community_support') }}</h3>
                        <p class="text-center">{{ __('common.community_support_desc') }}</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- Comprehensive Learning Path --}}
    <section class="container-fluid app-bg comprehensive-learning-path relative py-12"
        style="padding-top: 100px !important;">
        <div class="container">
            <h2 class="text-center display-4 fw-bold mb-6">{{ __('common.comprehensive_learning_path') }}</h2>
            <p class="text-center lead mb-5">{{ __('common.beginner_to_expert') }}</p>
            <div class="separator mb-5" aria-hidden="true"></div>

            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" style="padding-top: 40px;">
                    <h3 class="h2 fw-bold mb-4 mt-12">{{ __('common.unlock_potential') }}</h3>
                    <p class="lead mb-4">{{ __('common.join_lebify') }}</p>
                    <ul class="list-unstyled mt-12">
                        <li class="mb-7 mt-7">
                            <img class="mx-5" src="{{ asset('vendor/img/card-icon/internet.png') }}" width="50"
                                height="50" alt="{{ __('common.web_icon') }}" aria-hidden="true">
                            {{ __('common.full_stack_web_dev') }}
                        </li>
                        <li class="mb-7 mt-7">
                            <img class="mx-5" src="{{ asset('vendor/img/card-icon/development.png') }}" width="50"
                                height="50" alt="{{ __('common.mobile_app_icon') }}" aria-hidden="true">
                            {{ __('common.mobile_app_dev') }}
                        </li>
                        <li class="mb-7 mt-7">
                            <img class="mx-5" src="{{ asset('vendor/img/card-icon/database-file.png') }}"
                                width="50" height="50" alt="{{ __('common.database_icon') }}"
                                aria-hidden="true">
                            {{ __('common.database_management') }}
                        </li>
                        <li class="mb-7 mt-7">
                            <img class="mx-5" src="{{ asset('vendor/img/card-icon/server.png') }}" width="50"
                                height="50" alt="{{ __('common.cloud_icon') }}" aria-hidden="true">
                            {{ __('common.cloud_computing') }}
                        </li>
                        <li class="mb-7 mt-7">
                            <img class="mx-5" src="{{ asset('vendor/img/card-icon/analytics.png') }}" width="50"
                                height="50" alt="{{ __('common.ai_icon') }}" aria-hidden="true">
                            {{ __('common.ai_ml') }}
                        </li>
                        <li class="mb-12">
                            <img class="mx-5" src="{{ asset('vendor/img/card-icon/cyber-security.png') }}"
                                width="50" height="50" alt="{{ __('common.security_icon') }}"
                                aria-hidden="true">
                            {{ __('common.cybersecurity') }}
                        </li>
                    </ul>
                    <a href="#" class="btn bg-logo btn-lg mt-4"
                        role="button">{{ __('common.explore_all_courses') }}</a>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative comprehensive-learning-path-image">
                        <img src="{{ asset('vendor/img/card-icon/learning-path.svg') }}"
                            alt="{{ __('common.learning_path_illustration') }}" class="img-fluid rounded">
                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Us Section --}}
    <section class="container-lg-fluid app-bg py-5" style="padding-top: 100px !important;">
        <div class="container contact-us-section">
            <h2 class="text-center display-4 fw-bold mb-6">{{ __('common.get_in_touch') }}</h2>
            <p class="text-center lead mb-5">{{ __('common.wed_love_to_hear') }}</p>
            <div class="separator mb-5" aria-hidden="true"></div>

            <div
                class="d-flex align-items-center flex-lg-nowrap flex-wrap gap-12 justify-content-center mt-12 rounded-3 overflow-hidden">
                <div class="w-100 h-100">
                    <div class="d-flex flex-column gap-12 p-5">
                        <h3 class="h4 mb-4">{{ __('common.contact_information') }}</h3>
                        <p class="mb-4">{{ __('common.were_here_to_help') }}</p>
                        <ul class="list-unstyled">
                            <li class="mb-3"><img src="{{ asset('vendor/img/card-icon/map.png') }}" width="40"
                                    height="40" alt="{{ __('common.location_icon') }}" aria-hidden="true"><span
                                    class="mx-5 fw-bold">{{ __('common.barja_lebanon') }}</span></li>
                            <li class="mb-3"><img src="{{ asset('vendor/img/card-icon/phone.png') }}" width="40"
                                    height="40" alt="{{ __('common.phone_icon') }}" aria-hidden="true"><span
                                    class="mx-5 fw-bold">{{ __('common.phone_number') }}</span></li>
                            <li class="mb-3"><img src="{{ asset('vendor/img/card-icon/mail.png') }}" width="40"
                                    height="40" alt="{{ __('common.email_icon') }}" aria-hidden="true"><span
                                    class="mx-5 fw-bold">{{ __('common.email_address') }}</span></li>
                        </ul>
                        <div class="mt-4">
                            <h4 class="h5 mb-3">{{ __('common.how_we_can_help') }}</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2">• {{ __('common.technical_support') }}</li>
                                <li class="mb-2">• {{ __('common.feedback_on_learning') }}</li>
                                <li class="mb-2">• {{ __('common.suggestions_for_courses') }}</li>
                                <li class="mb-2">• {{ __('common.partnership_inquiries') }}</li>
                                <li class="mb-2">• {{ __('common.general_questions') }}</li>
                            </ul>
                        </div>
                        <p class="mt-3">{{ __('common.we_value_your_input') }}</p>
                        <div class="d-flex flex-column">
                            <div>
                                <h4 class="h5 mb-3 mt-4">{{ __('common.follow_us') }}</h4>
                            </div>
                            <div>
                                <a target="_blank" href="https://github.com/Danyseifedine" class="me-3 text-dark"
                                    aria-label="GitHub"><img src="{{ asset('vendor/img/card-icon/github.png') }}"
                                        width="50" height="50" alt="" aria-hidden="true"></a>
                                <a target="_blank" href="https://www.linkedin.com/in/dany-seifeddine-ab6558247/"
                                    class="me-3 text-dark" aria-label="LinkedIn"><img
                                        src="{{ asset('vendor/img/card-icon/linkedin.png') }}" width="50"
                                        height="50" alt="" aria-hidden="true"></a>
                                <a target="_blank" href="https://www.instagram.com/danny__seifeddine/" class="text-dark"
                                    aria-label="Instagram"><img src="{{ asset('vendor/img/card-icon/instagram.png') }}"
                                        width="50" height="50" alt="" aria-hidden="true"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="separator-vertical d-none d-xl-block my-5" aria-hidden="true"></div>
                <div class="p-5 w-100 d-flex flex-column gap-4 justify-content-evenly"
                    style="max-width: 800px; margin: 0 auto;">
                    <div>
                        <h2 class="h3 mb-4 text-center">{{ __('common.send_us_a_message') }}</h2>
                        <p class="text-muted mb-4">{{ __('common.excited_to_hear_from_you') }}</p>
                    </div>
                    <form form-id="feedback-form" http-request feedback route="{{ route('students.feedback') }}"
                        identifier="single-form-post-handler" success-toast on-success="clearForm"
                        serialize-as="formdata" id="contact-form" class="p-4 rounded">
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('common.full_name') }}</label>
                            <input type="text" name="name" feedback-id="name-feedback"
                                class="form-control form-control-lg" id="name"
                                placeholder="{{ __('common.enter_full_name') }}">
                            <div class="invalid-feedback" id="name-feedback"></div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('common.email') }}</label>
                            <input type="email" name="email" feedback-id="email-feedback"
                                class="form-control form-control-lg" id="email"
                                placeholder="{{ __('common.enter_email_address') }}">
                            <div id="email-feedback" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-4">
                            <label for="subject" class="form-label">{{ __('common.subject') }}</label>
                            <select feedback-id="subject-feedback" name="subject" class="form-select form-select-lg"
                                id="subject">
                                <option value="" selected disabled>{{ __('common.choose_subject') }}</option>
                                <option value="course_inquiry">{{ __('common.course_inquiry') }}</option>
                                <option value="technical_support">{{ __('common.technical_support') }}</option>
                                <option value="partnership">{{ __('common.partnership_opportunity') }}</option>
                                <option value="feedback">{{ __('common.feedback') }}</option>
                                <option value="other">{{ __('common.other') }}</option>
                            </select>
                            <div class="invalid-feedback" id="subject-feedback"></div>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label">{{ __('common.your_message') }}</label>
                            <textarea feedback-id="message-feedback" name="message" class="form-control form-control-lg" id="message"
                                rows="6" placeholder="{{ __('common.type_your_message') }}"></textarea>
                            <div class="invalid-feedback" id="message-feedback"></div>
                        </div>
                        <button type="submit" loading-text="{{ __('common.sending') }}" submit-form-id="feedback-form"
                            class="btn bg-logo btn-lg w-100 py-3">{{ __('common.send_message') }}</button>
                    </form>

                    <div class="d-flex flex-column mt-12 align-items-center text-center">
                        <p class="text-muted mb-2">{{ __('common.website_by_dany') }}</p>
                        <p class="text-muted">{{ __('common.dedicated_to_learning') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/TextPlugin.min.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/MotionPathPlugin.min.js" defer></script>
        <script src="{{ asset('js/web/landing/landing.js') }}" type="module" defer></script>
    @endpush
@endsection





<!--Grid column-->
{{-- <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                            <h5 class="text-uppercase mb-4">Courses</h5>

                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-graduation-cap pe-3"></i>Web Development</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-graduation-cap pe-3"></i>Data Science</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-graduation-cap pe-3"></i>Mobile App Development</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-graduation-cap pe-3"></i>Machine Learning</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-graduation-cap pe-3"></i>UI/UX Design</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-graduation-cap pe-3"></i>Cloud Computing</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-graduation-cap pe-3"></i>Cybersecurity</a>
                                </li>
                            </ul>
                        </div> --}}
<!--Grid column-->

<!--Grid column-->
{{-- <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                            <h5 class="text-uppercase mb-4">Resources</h5>

                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-book pe-3"></i>Learning Paths</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-book pe-3"></i>Blog</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-book pe-3"></i>Tutorials</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-book pe-3"></i>FAQ</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-book pe-3"></i>Community Forum</a>
                                </li>
                                <li class="mb-2">
                                    <a href="#!" class="text-white"><i class="fas fa-book pe-3"></i>Career Services</a>
                                </li>
                            </ul>
                        </div> --}}
<!--Grid column-->
