<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>404 | Lebify Learning - Your Gateway to Development Mastery</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <meta name="keywords"
        content="Lebify Learning, online courses, web development, programming, full stack, Laravel, PHP, JavaScript, HTML, CSS, database, SQL, React, Vue.js, Node.js, API development, responsive design, version control, Git, Agile methodology, software engineering, coding bootcamp, tech education, career development, IT skills, web applications, mobile development, cloud computing, cybersecurity, data structures, algorithms, user experience, UI/UX design, DevOps, continuous integration, software architecture, test-driven development, scalability, performance optimization, front-end development, back-end development, quizzes, interactive learning">
    <meta name="description"
        content="Lebify Learning: Your premier destination for mastering development skills. Dive into our comprehensive courses, engaging quizzes, and interactive learning experiences. From web development to mobile apps, we offer cutting-edge curriculum to boost your tech career. Join Lebify Learning today and transform your coding journey!">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('core/vendor/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('core/vendor/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('core/vendor/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('core/vendor/img/favicons/favicon.ico') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="msapplication-TileColor" content="#008382">
    <meta name="msapplication-TileImage" content="{{ asset('core/vendor/img/favicons/mstile-150x150.png') }}">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Lebify Learning - Your Gateway to Development Mastery">
    <meta property="og:description"
        content="Elevate your coding skills with Lebify Learning. Explore our diverse range of development courses, interactive quizzes, and hands-on projects. Start your journey to becoming a proficient developer today!">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Lebify Learning - Your Gateway to Development Mastery">
    <meta property="twitter:description"
        content="Elevate your coding skills with Lebify Learning. Explore our diverse range of development courses, interactive quizzes, and hands-on projects. Start your journey to becoming a proficient developer today!">
    <!-- ===============================================-->
    <!--    Package-->
    <!-- ===============================================-->
    <link rel="stylesheet" href="{{ asset('packages/iziToast/css/iziToast.min.css') }}">
    <!-- ===============================================-->
    <!--    Meta-->
    <!-- ===============================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#FFFFFF" />
    <meta name="author" content="Lebify Learning">
    <meta name="robots" content="index, follow">
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="stylesheet" href="{{ asset('core/styles/loading/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('core/styles/app.css') }}">
    <link rel="stylesheet" href="{{ asset('core/styles/components/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('core/styles/components/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ url('core/vendor/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @stack('styles')

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "EducationalOrganization",
                "name": "Lebify Learning - Your Gateway to Development Mastery",
                "description": "Learn full stack development with Lebify",
                "url": "https://learning.lebify.online/en",
                "logo": "{{ asset('vendor/img/favicons/favicon.ico') }}",
        }
    </script>
</head>

<body id="body" class="app-default" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px"
    data-kt-name="metronic">
    <div class="d-flex flex-column app-bg flex-root app-root" id="kt_app_root">
        <div id="kt_app_content_container">
            <header
                class="container-fluid hero-section overflow-hidden flex-column d-flex align-items-center justify-content-center position-relative min-vh-100">
                <img src="{{ asset('core/vendor/img/default/404.svg') }}" alt="404 page" class="img-fluid mb-4">
                <h1 class="display-4">{{ __('common.cant_be_found') }}</h1>
                <p class="lead mt-2">{{ __('common.maybe_try_links') }}</p>
                <div class="d-flex gap-3">
                    <a href="/" class="btn mt-5 bg-logo">{{ __('common.go_back_to_homepage') }}</a>
            </header>
        </div>
    </div>
</body>

</html>
