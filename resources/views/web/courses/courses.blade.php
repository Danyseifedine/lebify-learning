@extends('layouts.user')

@section('content')
    <div style="padding-top: 53px !important;">
        <section class="p-20 text-center"
            style="background-image: url('{{ asset('vendor/img/bg/banner-bg.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;background-size: cover;background-color:#F77E15">
            <div class="container">
                <h1 class="display-4 text-white fw-bold mb-4">{{ __('common.explore_our_courses') }}</h1>
                <h2 class="lead fs-1 text-white mb-12 w-lg-50 mx-auto">{{ __('common.discover_learning_journey') }}</h2>
            </div>
        </section>
    </div>

    <section class="py-5">
        <div class="container app-bg py-5">
            <div class="row g-6 g-xl-9">
                @foreach ($courses as $course)
                    @if ($course->is_published || Auth::user()->hasRole('admin'))
                        <!--begin::Col-->
                        <div class="col-md-6 col-xl-4">
                            <!--begin::Card-->
                            <a href="{{ route('students.singleCourse', $course->id) }}" class="card shadow-course-card">
                                <!--begin::Card header-->
                                <div class="card-header border-0 pt-9">
                                    <!--begin::Card Title-->
                                    <div class="card-title m-0">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-50px w-50px bg-light">
                                            @if ($course->getFirstMedia('course_images'))
                                                <img src="{{ $course->getFirstMedia('course_images')->getUrl() }}"
                                                    alt="{{ $course->title }}" class="p-3">
                                            @else
                                                <img src="{{ asset('assets/media/svg/brand-logos/plurk.svg') }}"
                                                    alt="{{ $course->title }}" class="p-3">
                                            @endif
                                        </div>
                                        <!--end::Avatar-->
                                    </div>
                                    <!--end::Car Title-->
                                    <!--begin::Card toolbar-->
                                    <div class="card-toolbar">
                                        @if ($course->is_published)
                                            <span
                                                class="badge badge-light-success fw-bold me-auto px-4 py-3">{{ __('common.published') }}</span>
                                        @endif
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end:: Card header-->
                                <!--begin:: Card body-->
                                <div class="card-body p-9">
                                    <!--begin::Name-->
                                    <div class="fs-3 fw-bold text-gray-900 mb-3">{{ $course->title }}</div>
                                    <!--end::Name-->
                                    <!--begin::Description-->
                                    <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">
                                        {{ $course->getDescription() }}
                                    </p>
                                    <!--end::Description-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap mb-5">
                                        <!--begin::Duration-->
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                            <div class="fs-6 text-gray-800 fw-bold">{{ $course->duration }}
                                                {{ __('common.hours') }}</div>
                                            <div class="fw-semibold text-gray-500">{{ __('common.time_to_master') }}</div>
                                        </div>
                                        <!--end::Duration-->
                                        <!--begin::Level-->
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                            <div class="fs-6 text-gray-800 fw-bold">
                                                {{ $course->created_at->format('d M Y') }}
                                            </div>
                                            <div class="fw-semibold text-gray-500">{{ __('common.published_at') }}</div>
                                        </div>
                                        <!--end::Level-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Progress-->
                                    <h5 class="mb-3">{{ __('common.difficulty_level') }}:
                                        {{ $course->difficulty_level }}/5
                                    </h5>
                                    <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                        aria-label="{{ __('common.difficulty_level') }}: {{ $course->difficulty_level }}"
                                        data-bs-original-title="Difficulty Level: {{ $course->difficulty_level }}"
                                        data-kt-initialized="1">
                                        <div class="rounded h-4px" role="progressbar"
                                            style="width: {{ $course->getDifficultyPercentage() }}%;
                                           background-color: {{ $course->getDifficultyColor() }};"
                                            aria-valuenow="{{ $course->difficulty_level }}" aria-valuemin="1"
                                            aria-valuemax="5">
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end:: Card body-->
                            </a>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
