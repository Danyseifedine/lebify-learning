<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>@yield('title') | Lebify Learning - Your Gateway to Development Mastery</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <meta name="keywords"
        content="Lebify Learning, online courses, web development, programming, full stack, Laravel, PHP, JavaScript, HTML, CSS, database, SQL, React, Vue.js, Node.js, API development, responsive design, version control, Git, Agile methodology, software engineering, coding bootcamp, tech education, career development, IT skills, web applications, mobile development, cloud computing, cybersecurity, data structures, algorithms, user experience, UI/UX design, DevOps, continuous integration, software architecture, test-driven development, scalability, performance optimization, front-end development, back-end development, quizzes, interactive learning">
    <meta name="description"
        content="Lebify Learning: Your premier destination for mastering development skills. Dive into our comprehensive courses, engaging quizzes, and interactive learning experiences. From web development to mobile apps, we offer cutting-edge curriculum to boost your tech career. Join Lebify Learning today and transform your coding journey!">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('core/vendor/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('core/vendor/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('core/vendor/img/favicons/favicon-16x16.png') }}">
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
    <link rel="stylesheet" href="{{ asset('core/packages/iziToast/css/iziToast.min.css') }}">
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
    <link rel="stylesheet" href="{{ asset('core/styles/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    @if (LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
        <link href="{{ url('core/vendor/css/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('core/vendor/css/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('core/vendor/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ url('core/vendor/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('core/vendor/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('core/vendor/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endif
    @stack('styles')

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "EducationalOrganization",
                "name": "Lebify Learning - Your Gateway to Development Mastery",
                "description": "Learn full stack development with Lebify",
                "url": "https://learning.lebify.online/en",
                "logo": "{{ asset('core/vendor/img/favicons/favicon.ico') }}",
        }
    </script>
</head>

<body id="body" class="app-default" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px"
    data-kt-name="metronic">
    <script>
        let defaultThemeMode = "dark";
        let themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedFont = localStorage.getItem('preferred-font');
            if (savedFont) {
                document.documentElement.style.setProperty('--kt-font-family', savedFont, 'important');
                document.body.style.setProperty('font-family', savedFont, 'important');
                // Apply to all elements
                document.querySelectorAll('*').forEach(element => {
                    element.style.setProperty('font-family', savedFont, 'important');
                });
            }
        });
    </script>

    <!-- Font Selector -->

    <div class="d-flex flex-column app-bg flex-root app-root" id="kt_app_root">
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <main class="app-page flex-column flex-column-fluid" id="kt_app_page">
                <div class="mx-5">
                    <!-- Navbar -->
                    @include('web.layouts.partials.navbar')
                </div>
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content mt-5 flex-column-fluid">
                                <div id="kt_app_content_container">
                                    <!-- Page Content -->
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                {{-- @include('web.components.preferences') --}}
            </main>
        </div>

        <script src="{{ asset('core/packages/iziToast/js/iziToast.min.js') }}"></script>
        <script src="{{ asset('core/packages/iziToast/js/iziToast.js') }}"></script>
        <script src="{{ url('core/vendor/js/plugins.bundle.js') }}"></script>
        <script src="{{ url('core/vendor/js/scripts.bundle.js') }}"></script>
        <script src="{{ url('core/vendor/js/datatables.bundle.js') }}"></script>
        <script src="{{ asset('core/global/Launcher.js') }}" type="module"></script>
        <script src="{{ asset('core/js/app.js') }}" type="module"></script>
        @stack('scripts')
</body>

</html>
