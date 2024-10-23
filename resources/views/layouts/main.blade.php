<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Full Stack Development') | {{ env('APP_NAME') }}</title>
    <meta name="description" content="@yield('meta_description', 'Learn full stack development with Dany Seifeddine. Master web technologies and advance your career with our comprehensive courses.')">
    <meta name="keywords" content="@yield('meta_keywords', 'full stack development, web development, coding, programming, online courses, Dany Seifeddine')">
    <meta name="author" content="Dany Seifeddine">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'Full Stack Development with Lebify')">
    <meta property="og:description" content="@yield('og_description', 'Master web development and advance your career with our comprehensive courses.')">
    <meta property="og:image" content="@yield('og_image', asset('vendor/img/favicons/favicon.ico'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', 'Full Stack Development with Lebify')">
    <meta property="twitter:description" content="@yield('twitter_description', 'Master web development and advance your career with our comprehensive courses.')">
    <meta property="twitter:image" content="@yield('twitter_image', asset('vendor/img/favicons/favicon.ico'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('vendor/img/favicons/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#008382">
    <meta name="msapplication-TileImage" content="{{ asset('vendor/img/favicons/favicon.ico') }}">
    <!-- ===============================================-->
    <!--    Package-->
    <!-- ===============================================-->
    <link rel="stylesheet" href="{{ asset('packages/iziToast/css/iziToast.min.css') }}">
    <!-- ===============================================-->
    <!--    Meta-->
    <!-- ===============================================-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#FFFFFF" />
    <meta name="author" content="Dany Seifeddine">
    <meta name="robots" content="index, nofollow">
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="stylesheet" href="{{ asset('css/loading/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    @if (LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
        <link href="{{ url('vendor/css/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('vendor/css/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('vendor/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ url('vendor/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('vendor/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('vendor/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endif
    @stack('styles')

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "EducationalOrganization",
                "name": "{{ env('APP_NAME') }}",
                "description": "Learn full stack development with Lebify",
                "url": "{{ url('/') }}",
                "logo": "{{ asset('vendor/img/favicons/favicon.ico') }}",
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
    </script>

    <div class="d-flex flex-column app-bg flex-root app-root" id="kt_app_root">
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <main class="app-page flex-column flex-column-fluid" id="kt_app_page">
                <div class="mx-5">
                    <!-- Navbar -->
                    @include('components.navbar')
                </div>
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content mt-5 flex-column-fluid">
                                <div id="kt_app_content_container">
                                    <!-- Page Content -->
                                    @yield('content')
                                    @include('components.footer')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
            </main>
        </div>

        <script src="{{ asset('packages/iziToast/js/iziToast.min.js') }}"></script>
        <script src="{{ asset('packages/iziToast/js/iziToast.js') }}"></script>
        <script src="{{ url('vendor/js/plugins.bundle.js') }}"></script>
        <script src="{{ url('vendor/js/scripts.bundle.js') }}"></script>
        <script src="{{ url('vendor/js/datatables.bundle.js') }}"></script>
        <script src="{{ asset('global/Launcher.js') }}" type="module"></script>
        <script src="{{ asset('js/web/landing/navbar.js') }}"></script>
        @stack('scripts')
</body>

</html>
