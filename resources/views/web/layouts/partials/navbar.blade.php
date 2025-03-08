<div id="kt_app_header" class="app-header navbar flex-column" data-kt-sticky="true"
    data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
    data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div class="app-container container-xxl d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container" style="height: 80px !important">
        <!--begin::Logo section-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
            <span>
                <div class="d-flex align-items-center">
                    <img alt="Logo" src="{{ asset('core/vendor/img/logo/lebify-logo.svg') }}"
                        class="h-30px h-50px app-sidebar-logo-default me-1">
                    <div class="d-flex flex-column">
                        <span class="fs-2 fw-bold d-none d-lg-block">Lebify Learning</span>
                        <span class="text-muted fs-8 d-none d-lg-block">Under Development</span>
                    </div>
                </div>
            </span>
        </div>
        <!--end::Logo section-->

        <!--begin::Menu section - center-->
        <div class="d-flex align-items-stretch justify-content-center flex-lg-grow-1" id="kt_app_header_wrapper">
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="300px" data-kt-drawer-direction="start"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-center fw-semibold px-2 px-lg-0"
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
                        <div class="menu-item px-3 dropdown-click-item">
                            <a href="javascript:void(0)"
                                class="text-hover menu-link d-flex align-items-center justify-content-between fs-5 text-logo-hover-color fw-bold px-3 py-2 dropdown-toggle-full {{ request()->routeIs('courses.index') ? 'active-nav' : '' }}">
                                {{ __('common.courses') }}
                                <i class="bi bi-chevron-down dropdown-indicator ms-2"></i>
                            </a>
                            <div class="menu-dropdown-container">
                                <div class="menu-dropdown-inner">
                                    <div class="dropdown-header p-6 d-flex align-items-center justify-content-between">
                                        <span>Course Levels</span>
                                        <a href="{{ route('courses.index') }}" class="dropdown-header-link text-logo">
                                            All Courses <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-items-grid">
                                        <a href="{{ route('courses.index', ['difficulty_level' => 1]) }}"
                                            class="dropdown-item-card">
                                            <div class="item-icon">
                                                <i class="bi bi-code-slash fs-2"></i>
                                            </div>
                                            <div class="item-content">
                                                <h6>Beginner Level</h6>
                                            </div>
                                        </a>
                                        <a href="{{ route('courses.index', ['difficulty_level' => 2]) }}"
                                            class="dropdown-item-card">
                                            <div class="item-icon">
                                                <i class="bi bi-phone fs-2"></i>
                                            </div>
                                            <div class="item-content">
                                                <h6>Intermediate Level</h6>
                                            </div>
                                        </a>
                                        <a href="{{ route('courses.index', ['difficulty_level' => 3]) }}"
                                            class="dropdown-item-card">
                                            <div class="item-icon">
                                                <i class="bi bi-database fs-2"></i>
                                            </div>
                                            <div class="item-content">
                                                <h6>Advanced Level</h6>
                                            </div>
                                        </a>
                                        <a href="{{ route('courses.index', ['difficulty_level' => 4]) }}"
                                            class="dropdown-item-card">
                                            <div class="item-icon">
                                                <i class="bi bi-cloud fs-2"></i>
                                            </div>
                                            <div class="item-content">
                                                <h6>Expert Level</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="menu-item px-3">
                            <a href="{{ route('quizzes.index') }}"
                                class="text-hover menu-link {{ request()->routeIs('quizzes.index') ? 'active-nav' : '' }} fs-5 text-logo-hover-color fw-bold px-3 py-2">
                                {{ __('common.quizzes') }}
                            </a>
                        </div>
                    @endguest
                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
        </div>
        <!--end::Menu section-->

        <!--begin::Navbar section - right-->
        <div class="d-flex align-items-stretch flex-shrink-0">
            <div class="app-navbar d-flex align-items-stretch">
                <!--begin::Theme mode-->
                <div class="app-navbar-item ms-1 ms-md-4">
                    @if (auth()->check() && !auth()->user()->hasCoinWallet())
                        <div class="menu-item px-3 d-flex align-items-center justify-content-center">
                            <a href="{{ route('students.createWallet') }}" class="btn btn-sm bg-logo">
                                <i class="bi bi-wallet fs-4 text-white me-1"></i>{{ __('common.create_wallet') }}
                            </a>
                        </div>
                    @endif
                </div>
                <!--end::Theme mode-->
                @guest
                    <div class="menu-item px-3 d-flex align-items-center">
                        <button data-bs-toggle="modal" data-bs-target="#join-now-modal" class="btn btn-sm bg-logo">
                            <i class="bi bi-person text-white me-1"></i>{{ __('common.join_now') }}
                        </button>
                    </div>
                @else
                    <!--begin::User menu-->
                    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                        <!--begin::Menu wrapper-->
                        <div class="cursor-pointer symbol symbol-35px" style="width: 35px; height: 35px;"
                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <img src="{{ asset('core/vendor/img/default/default.webp') }}" width="35px" height="35px"
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
                                        <img alt="User Avatar" src="{{ asset('core/vendor/img/default/default.webp') }}"
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
                @endguest
                <!--begin::Header menu toggle-->
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn ms-5 btn-flex btn-icon btn-active-color-primary w-30px h-30px"
                        id="kt_app_header_menu_toggle">
                        <svg width="44px" height="44px" stroke-width="0.5" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" color="currentColor">
                            <path
                                d="M21 7.35304L21 16.647C21 16.8649 20.8819 17.0656 20.6914 17.1715L12.2914 21.8381C12.1102 21.9388 11.8898 21.9388 11.7086 21.8381L3.30861 17.1715C3.11814 17.0656 3 16.8649 3 16.647L2.99998 7.35304C2.99998 7.13514 3.11812 6.93437 3.3086 6.82855L11.7086 2.16188C11.8898 2.06121 12.1102 2.06121 12.2914 2.16188L20.6914 6.82855C20.8818 6.93437 21 7.13514 21 7.35304Z"
                                stroke="currentColor" stroke-width="0.5" stroke-linecap="round"
                                stroke-linejoin="round">
                            </path>
                            <path
                                d="M20.5 16.7222L12.2914 12.1619C12.1102 12.0612 11.8898 12.0612 11.7086 12.1619L3.5 16.7222"
                                stroke="currentColor" stroke-width="0.5" stroke-linecap="round"
                                stroke-linejoin="round">
                            </path>
                            <path
                                d="M3.52844 7.29357L11.7086 11.8381C11.8898 11.9388 12.1102 11.9388 12.2914 11.8381L20.5 7.27777"
                                stroke="currentColor" stroke-width="0.5" stroke-linecap="round"
                                stroke-linejoin="round">
                            </path>
                            <path d="M12 21L12 3" stroke="currentColor" stroke-width="0.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </div>
                </div>
                <!--end::Header menu toggle-->

                <!--begin::Aside toggle-->
                <!--end::Header menu toggle-->
            </div>
        </div>
        <!--end::Navbar section-->
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
                                src="{{ asset('core/vendor/img/card-icon/of.svg') }}"
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

<div class="theme-toggle-float" data-kt-toggle="true" data-kt-toggle-state="light" data-kt-toggle-target="body"
    data-kt-toggle-name="app-theme-mode">
    <i class="bi bi-brightness-high fs-2 theme-light-show"></i>
    <i class="bi bi-moon-stars fs-2 theme-dark-show"></i>
</div>

<script>
    function handleSuccess(response) {
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    }
</script>
