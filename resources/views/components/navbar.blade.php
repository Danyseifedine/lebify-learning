<div id="kt_app_header" class="app-header navbar flex-column" data-kt-sticky="true"
    data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
    data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div class="app-container container-xxl d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container" style="height: 400px !important">
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
            <span>
                <div class="d-flex align-items-center">
                    <img alt="Logo" src="{{ asset('vendor/img/logo/lebify-logo.svg') }}"
                        class="h-30px h-50px app-sidebar-logo-default me-1">
                    <div class="d-flex flex-column">
                        <span class="fs-2 fw-bold d-none d-lg-block">Lebify Learning</span>
                        <span class="text-muted fs-8 d-none d-lg-block">By Dany Seifeddine</span>
                    </div>
                </div>
            </span>
        </div>
        <!--end::Logo-->

        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">

            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                    id="kt_app_header_menu" data-kt-menu="true">
                    @guest
                        <div class="menu-item px-3">
                            <a href="/"
                                class="text-hover {{ request()->routeIs('landing') ? 'active-nav' : '' }} menu-link fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.home') }}
                            </a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#join-now-modal"
                                class="text-hover menu-link fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.sessions') }}
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#join-now-modal"
                                class="text-hover menu-link fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.courses') }}
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#join-now-modal"
                                class="text-hover menu-link fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.quizzes') }}
                            </a>
                        </div>
                    @else
                        <div class="menu-item px-3">
                            <a href="/"
                                class="text-hover menu-link {{ request()->routeIs('landing') ? 'active-nav' : '' }} fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.home') }}
                            </a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="" class="text-hover menu-link fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.sessions') }}
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="{{ route('students.courses') }}"
                                class="text-hover {{ request()->routeIs('students.courses') ? 'active-nav' : '' }} menu-link fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.courses') }}
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="" class="text-hover menu-link fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.quizzes') }}
                            </a>
                        </div>
                    @endguest
                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::Theme mode-->
                <div class="app-navbar-item ms-1 ms-md-4">
                    <!--begin::Menu toggle-->
                    <a href="#"
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                        data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <i class="bi bi-brightness-high theme-light-show icon-light fs-2" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Light"></i>
                        <i class="bi bi-moon-stars theme-dark-show fs-2" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Dark"></i>
                    </a>
                    <!--begin::Menu toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2 active" data-kt-element="mode"
                                data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="bi bi-brightness-high icon-light fs-2"></i>
                                </span>
                                <span class="menu-title">
                                    {{ __('common.light') }}
                                </span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="bi bi-moon-stars icon-light fs-2"></i>
                                </span>
                                <span class="menu-title">
                                    {{ __('common.dark') }}
                                </span>
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="bi bi-display fs-2"></i>
                                </span>
                                <span class="menu-title">
                                    {{ __('common.system') }}
                                </span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->

                </div>
                <!--end::Theme mode-->
                {{-- Language --}}
                <div class="d-flex align-items-center justify-content-around gap-20">
                    <div class="app-navbar-item ms-1 ms-md-4">
                        <!--begin::Toggle-->
                        <button class="btn btn-flex btn-link rotate" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                            <i class="bi bi-globe fs-2 icon-light" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" title="Language"></i>
                        </button>
                        <!--end::Toggle-->
                        <!--begin::Menu-->
                        <div class="languageBox menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4"
                            data-kt-menu="true" id="kt_auth_lang_menu">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ LaravelLocalization::getLocalizedURL('en') }}"
                                    class="menu-link d-flex px-5" data-kt-lang="English">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1"
                                            src="{{ asset('vendor/img/flags/united-states.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">{{ __('common.english') }}</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}"
                                    class="menu-link d-flex px-5" data-kt-lang="Saudi-arabia">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1"
                                            src="{{ asset('vendor/img/flags/saudi-arabia.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">{{ __('common.arabic') }}</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ LaravelLocalization::getLocalizedURL('fr') }}"
                                    class="menu-link d-flex px-5" data-kt-lang="French">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1"
                                            src="{{ asset('vendor/img/flags/france.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">{{ __('common.french') }}</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                </div>

                @guest
                    <div class="menu-item px-3 d-flex align-items-center justify-content-center flex-lg-grow-1">
                        <button data-bs-toggle="modal" data-bs-target="#join-now-modal" class="btn btn-sm bg-logo">
                            <i class="bi bi-person text-white me-1"></i>{{ __('common.join_now') }}
                        </button>
                    </div>
                @endguest
                {{-- End Language --}}
                @auth
                    <!--begin::User menu-->
                    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                        <!--begin::Menu wrapper-->
                        <div class="cursor-pointer symbol symbol-35px" style="width: 35px; height: 35px;"
                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <img src="{{ asset('vendor/img/default/default.webp') }}" width="35px" height="35px"
                                class="rounded-3" alt="user">
                        </div>
                        <!--begin::User account menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-350px"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-3">
                                        <img alt="User Avatar" src="{{ asset('vendor/img/default/default.webp') }}"
                                            class="rounded-circle" width="50" height="50">
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::User Info-->
                                    <div class="d-flex flex-column flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="fw-bold fs-5 me-2">{{ auth()->user()->name }}</span>
                                            <span class="badge bg-success text-white fs-8 px-2 py-1">
                                                {{ $role == 'student' ? 'Student' : 'admin' }}
                                            </span>
                                        </div>
                                        <span class="text-muted fs-7">{{ auth()->user()->email }}</span>
                                    </div>
                                    <!--end::User Info-->
                                </div>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-5 my-1">
                                <a href="{{ route('students.profile') }}" class="menu-link px-5">
                                    {{ __('common.profile') }}
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-5 my-1">
                                <button submit-form-id="logout-form" type="submit" class="menu-link logout-button px-5">
                                    {{ __('common.logout') }}
                                </button>
                            </div>
                            <!--end::Menu item-->
                            <form identifier="single-form-post-handler" form-id="logout-form" http-request
                                route="{{ route('logout') }}" on-success="handleSuccess" style="display: none;"
                                success-toast>
                                @csrf
                            </form>
                        </div>
                        <!--end::User account menu-->

                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::User menu-->
                @endauth
                <!--begin::Header menu toggle-->
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px"
                        id="kt_app_header_menu_toggle">
                        <i class="bi bi-grid-3x3-gap-fill fs-1 icon-light"></i>
                    </div>
                </div>
                <!--end::Header menu toggle-->

                <!--begin::Aside toggle-->
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>

<div class="modal fade" identifier="modal-handler" clear-forms role="dialog" tabindex="-1" id="join-now-modal">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="h-100 position-relative" style="min-height: 500px;">
                            <img style="border-top-left-radius:7px; border-bottom-left-radius: 7px;"
                                class="w-100 h-100 object-fit-cover position-absolute"
                                src="{{ asset('vendor/img/card-icon/of.svg') }}"
                                alt="{{ __('common.modal_image') }}">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-opacity-60"></div>
                        </div>
                    </div>
                    <div style="border-top-right-radius: 7px; border-bottom-right-radius: 7px;"
                        class="col-lg-6 modal-body-login d-flex align-items-start justify-content-center">
                        <div class="p-8 w-100">
                            <div class="modal-header border-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ __('common.close') }}"></button>
                            </div>
                            <h3 class="fw-bold mb-7 mt-5 text-center">{{ __('common.access_your_account') }}</h3>
                            <form form-id="student-login-form" http-request route="{{ route('students.login') }}"
                                identifier="single-form-post-handler" serialize-as="formdata" feedback
                                class="needs-validation" on-success="handleSuccess" success-toast close-modal>
                                <div class="mb-6 mt-12">
                                    <label for="uuid"
                                        class="form-label visually-hidden">{{ __('common.uuid') }}</label>
                                    <div class="input-group input-group-lg bg-light">
                                        <input type="text" class="form-control bg-transparent border-0 px-3"
                                            id="uuid" name="uuid" feedback-id="uuid-feedback"
                                            placeholder="{{ __('common.enter_your_uuid') }}" data-uuid-input>
                                    </div>
                                    <div id="uuid-feedback" class="invalid-feedback"></div>
                                </div>
                                <div class="mb-6 mt-5">
                                    <label for="password"
                                        class="form-label visually-hidden">{{ __('common.password') }}</label>
                                    <div class="input-group input-group-lg bg-light">
                                        <input type="password" class="form-control bg-transparent border-0 px-3"
                                            id="password" name="password" feedback-id="password-feedback"
                                            placeholder="{{ __('common.enter_your_password') }}">
                                    </div>
                                    <div id="password-feedback" class="invalid-feedback"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label"
                                            for="rememberMe">{{ __('common.remember_me') }}</label>
                                    </div>
                                </div>
                                <button submit-form-id="student-login-form" type="submit"
                                    class="btn bg-logo d-flex align-items-center justify-content-center gap-4 btn-lg w-100 mb-3">{{ __('common.sign_in') }}</button>
                                <p class="text-center mb-0">{{ __('common.dont_have_account') }} <a
                                        href="https://wa.link/30pyko"
                                        class="text-logo text-decoration-none">{{ __('common.request_one') }}</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function handleSuccess(response) {
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    }
</script>
