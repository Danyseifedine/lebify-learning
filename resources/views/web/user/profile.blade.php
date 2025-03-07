@extends('web.layouts.user')

@section('title', 'Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/web/profile.css', true) }}">
@endpush

@section('content')
    <div class="mx-5">
        <div class="container p-5 card card-bg px-12 mb-5 mb-xxl-8" style="margin-top: 100px !important;border-radius: 10px;">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ asset('vendor/img/default/default.webp') }}" alt="image">
                            <div
                                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                            </div>
                        </div>
                    </div>
                    <!--end::Pic-->

                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <span
                                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $user->name }}</span>
                                </div>
                                <!--end::Name-->

                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 pe-2">
                                    <span class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        {{ $role }}
                                    </span>
                                </div>
                                <!--end::Info-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <span class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        {{ $user->email }}
                                    </span>
                                </div>
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->
                <!--begin::Navs-->
                <ul identifier="tab-handler" tab-group-id="tab-group-id" tab-route="{{ route('students.profile.tabs') }}"
                    tab-list tab-url="true" on-loading="handleTabLoading" on-success="handleTabSuccess"
                    class="nav nav-stretch mt-5 nav-line-tabs nav-line-tabs-2x border-transparent pt-12 fs-5 fw-bold">
                    <!--begin::Nav item-->
                    <li tab-id="overview" cache-tab="false" tab-initial="true" class="nav-item tab-item mx-5 mt-2">
                        {{ __('common.overview') }}
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li tab-id="settings" cache-tab="true" class="nav-item tab-item mx-5 mt-2">
                        {{ __('common.settings') }}
                    </li>
                    <!--end::Nav item-->
                    <li tab-id="quizzes" cache-tab="true" class="nav-item tab-item mx-5 mt-2">
                        {{ __('common.quizzes') }}
                    </li>
                    <!--begin::Nav item-->
                    <li tab-id="preferences" class="nav-item tab-item mx-5 mt-2">
                        {{ __('common.preferences') }}
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--begin::Navs-->
            </div>
        </div>
        <div tab-content-id="tab-group-id"></div>
    </div>
@endsection


@push('scripts')
    <script>
        window.handleTabLoading = function(isLoading, tabId, tabContent) {
            if (isLoading) {
                if (tabId === 'quizzes') {
                    tabContent.innerHTML = `

                    `;
                } else {
                    tabContent.innerHTML = `
                    <div class="container card card-bg d-flex justify-content-center align-items-center" style="height: 300px;">
                        <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `;
                }
            }
        }
    </script>
    <script src="{{ asset('js/web/profile/profile.js') }}" type="module"></script>
@endpush
