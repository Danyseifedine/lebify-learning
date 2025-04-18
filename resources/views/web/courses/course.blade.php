@extends('web.layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/web/course/course.css', true) }}">
@endpush

@section('content')
    <div style="padding-top: 53px !important;">
        <section class="text-center course-banner">
            <div class="container"
                style="background-image: url('{{ asset('core/vendor/img/bg/banner-bg.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;background-size: contains;padding:100px;">
                <h1 class="display-4 text-white fw-bold mb-4">{{ $course->title }}</h1>
            </div>
        </section>
    </div>

    <section
        style="background-image: url('{{ asset('core/vendor/img/bg/single-course-bg.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;background-size: cover;">
        <div class="container mt-5">
            <div class="row align-items-center">
                <!-- start course image -->
                <div class="col-md-6">
                    <img width="500" src="{{ $course->getFirstMedia('course_images')->getUrl() }}"
                        alt="{{ $course->title }}" class="img-fluid rounded">
                </div>
                <!-- end course image -->
                <!-- start course details -->
                <div class="col-md-6 g-5 d-flex flex-column justify-content-evenly">
                    <!-- start course title -->
                    <h1 class="mb-6 fw-bold display-4">{{ $course->title }}</h1>
                    <!-- end course title -->
                    <!-- start course description -->
                    <p class="mb-12 lead" style="text-align: justify">{{ $course->getDescription(false) }}</p>
                    <!-- end course description -->
                    <!-- start course time and date -->
                    <div class="d-flex mb-6 justify-content-between align-items-center mb-3">
                        <span class="badge bg-danger fw-bold text-white px-4 py-3">{{ __('common.time_to_master') }}:
                            {{ $course->duration }} {{ __('common.hours') }}</span>
                        <span class="text-muted">
                            {{ $course->created_at->diffForHumans() }}</span>
                    </div>
                    <!-- end course time and date -->
                    <!-- start course difficulty -->
                    <div class="mb-4">
                        <h5 class="mb-4">{{ __('common.difficulty_level') }}:</h5>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $course->getDifficultyPercentage() }}%; background-color: {{ $course->getDifficultyColor() }};"
                                aria-valuenow="{{ $course->difficulty_level }}" aria-valuemin="0" aria-valuemax="5">
                                {{ $course->difficulty_level }}/5
                            </div>
                        </div>
                    </div>
                    <!-- end course difficulty -->
                </div>
                <!-- end course details -->
            </div>
        </div>
        <section class="py-5" style="padding-top: 100px !important; padding-bottom: 100px !important;">
            <div class="container">
                <h2 class="mb-4 display-4 fw-bold">{{ __('common.course_content') }}</h2>
                {{-- start course documents --}}
                <div class="row course-documents mt-12">
                    <div class="col-md-8">
                        <h3 class="mb-8 fw-bold">{{ __('common.full_explanation') }}</h3>
                        <div class="documents-list">
                            @foreach ($documents as $index => $document)
                                <div class="document-card">
                                    <div class="document-icon">
                                        <i class="bi bi-file-earmark-text fs-1 text-white"></i>
                                        <span class="document-number">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="document-content">
                                        <h4>{{ $document->getTitle() }}</h4>
                                        <div class="document-actions">
                                            <a href="{{ route('courses.document', ['name' => $course->title, 'lang' => 'en', 'id' => encrypt($document->id), 'order' => encrypt($document->order)]) }}"
                                                class="btn-document special-text-color special-bg-color">
                                                <i class="bi px-1 fs-4 text-white bi-translate"></i>
                                                <span>EN</span>
                                            </a>
                                            <a href="{{ route('courses.document', ['name' => $course->title, 'lang' => 'ar', 'id' => encrypt($document->id), 'order' => encrypt($document->order)]) }}"
                                                class="btn-document">
                                                <i class="bi px-1 fs-4 text-white bi-translate"></i>
                                                <span>AR</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- end course documents --}}
                    {{-- start break line --}}
                    <div class="col-md-1 mt-12"></div>
                    {{-- end break line --}}
                    {{-- start helpful links --}}
                    <div class="col-md-3 helpful-links">
                        <h3 class="mb-8 fw-bold">{{ __('common.helpful_links') }}</h3>
                        @if (count($resources) > 0 || $role == 'admin')
                            <div class="d-flex flex-column gap-3">
                                @foreach ($resources as $resource)
                                    @if ($resource->is_published)
                                        <div class="hover-elevate-up" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-custom-class="resource-tooltip"
                                            title="{{ $resource->getDescription() }}">
                                            <a href="{{ $resource->url }}" target="_blank"
                                                class="card d-flex align-items-center flex-row gap-2 justify-content-center resource-link p-3 rounded-3 bg-light-hover">
                                                <i class="bi bi-link fs-2 text-muted"></i>
                                                <span class="fw-semibold">{{ $resource->getTitle() }}</span>
                                            </a>
                                            <div class="separator separator-dashed border-dark my-5"></div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">{{ __('common.we_are_working_on_it') }}</p>
                            <img src="{{ asset('core/vendor/img/icon/not-available-light.svg') }}" width="100"
                                alt="Empty Helpful Links">
                        @endif
                    </div>
                    {{-- end helpful links --}}
                </div>
                {{-- start lessons --}}
                <div class="row lessons mt-12">
                    <div class="d-flex align-items-center gap-2">
                        <h3 class="display-6 fw-bold">{{ __('common.lesson') }}</h3>
                        <div class="d-none d-md-block">
                            <img class="theme-light-show" src="{{ asset('core/vendor/img/default/arrow-up-light.svg') }}"
                                alt="" width="70"
                                style="position: relative;bottom: 15px !important;opacity: 0.5;{{ app()->getLocale() == 'ar' ? 'transform: scaleX(-1);' : '' }}">
                            <img class="theme-dark-show" src="{{ asset('core/vendor/img/default/arrow-up-dark.svg') }}"
                                alt="" width="70"
                                style="position: relative;bottom: 15px !important;opacity: 0.5;{{ app()->getLocale() == 'ar' ? 'transform: scaleX(-1);' : '' }}">
                        </div>
                    </div>
                    <p class="text-muted mb-12">{{ __('common.lessons_explain_document') }}</p>

                    @if (count($lessons) > 0)
                        @foreach ($lessons as $lesson)
                            @if ($lesson->is_published || $role == 'admin')
                                <div class="col-12 px-3 mb-4">
                                    <div class="card shadow-lg overflow-hidden h-100">
                                        <div class="row g-0">
                                            <!-- Lesson Thumbnail -->
                                            <div class="col-md-4 position-relative">
                                                <div class="lesson-thumbnail"
                                                    style="background-image: url('{{ $lesson->thumbnail_url }}'); background-size: cover; background-position: center;">
                                                </div>
                                            </div>
                                            <!-- Lesson Details -->
                                            <div class="col-md-8">
                                                <div class="card-body p-4 p-lg-6 d-flex flex-column h-100">
                                                    <!-- Header -->
                                                    <div class="d-flex justify-content-between align-items-start mb-4">
                                                        <div>
                                                            <h4 class="card-title fw-bold mb-2">{{ $lesson->title }}</h4>
                                                            <div class="text-muted">{{ $lesson->language }}</div>
                                                        </div>
                                                        <span class="badge bg-danger text-white px-3 py-2 rounded-pill">
                                                            <i class="bi bi-clock px-1 fs-3 text-white me-1"></i>
                                                            {{ $lesson->duration_for_humans }}
                                                        </span>
                                                    </div>

                                                    <!-- Description -->
                                                    <p class="card-text mb-4 flex-grow-1"
                                                        style="text-align: justify; color: #6c757d;">
                                                        {{ $lesson->description }}
                                                    </p>

                                                    <!-- Footer Actions -->
                                                    <div
                                                        class="d-flex flex-column justify-content-between flex-md-row gap-3 mt-auto">
                                                        <button type="button"
                                                            class="btn bg-logo d-flex align-items-center justify-content-center w-100 w-md-auto"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#videoModal{{ $lesson->id }}">
                                                            <i class="bi fs-3 bi-play-circle-fill text-white me-2"></i>
                                                            <span>{{ __('common.watch_lesson') }}</span>
                                                        </button>

                                                        <a href="{{ $lesson->video_url }}" target="_blank"
                                                            class="btn bg-logo d-flex align-items-center justify-content-center w-100 w-md-auto">
                                                            <i class="bi bi-youtube fs-3 text-white me-2"></i>
                                                            <span>{{ __('common.watch_on_youtube') }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="videoModal{{ $lesson->id }}" tabindex="-1"
                                    aria-labelledby="videoModalLabel{{ $lesson->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content bg-dark">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title text-white"
                                                    id="videoModalLabel{{ $lesson->id }}">
                                                    {{ $lesson->title }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="{{ $lesson->embed_video_url }}" class="rounded-0"
                                                        frameborder="0" loading="lazy"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen referrerpolicy="strict-origin-when-cross-origin"
                                                        sandbox="allow-same-origin allow-scripts allow-popups allow-forms"
                                                        title="{{ $lesson->title }}"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <p class="text-muted">{{ __('common.no_lessons_available') }}</p>
                            <img src="{{ asset('core/vendor/img/icon/not-available-light.svg') }}" width="100"
                                alt="Empty Lessons">
                        </div>
                    @endif
                </div>

                {{-- start extension --}}
                <div class="row extension mt-12">
                    <h3 class="mb-4 display-6 fw-bold">{{ __('common.extension') }}</h3>
                    <p class="text-muted mb-8">{{ __('common.extension_description') }}</p>

                    @if (count($extensions) > 0 || $role == 'admin')
                        <div class="row row-cols-1 row-cols-md-5 g-4">
                            @foreach ($extensions as $extension)
                                <div class="col">
                                    <div class="card h-100 border-0 shadow-sm hover-elevate-up">
                                        <div class="card-body p-4">
                                            <!-- Extension Icon/Logo -->
                                            <div
                                                class="d-flex btn-sm btn-light justify-content-between align-items-center mb-4">
                                                <div class="extension-icon bg-light rounded p-2">
                                                    <i class="bi bi-puzzle-fill fs-1"
                                                        style="color: {{ $extension->randomColor() }};"></i>
                                                </div>
                                                <!-- Info Button -->
                                                <button class="btn border-logo d-flex align-items-center gap-1 small"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#extensionModal{{ $extension->id }}">
                                                    <i class="bi p-0 m-0 fs-2 text-muted bi-info-circle"></i>
                                                </button>
                                            </div>

                                            <!-- Extension Name -->
                                            <h5 class="card-title fw-bold mb-2">{{ $extension->name }}</h5>
                                            <a href="{{ $extension->marketplace_url }}" target="_blank"
                                                class="btn mt-5 btn-sm float-end btn-light">
                                                {{ __('common.visit_marketplace') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for this extension -->
                                <div class="modal fade" id="extensionModal{{ $extension->id }}" tabindex="-1"
                                    aria-labelledby="extensionModalLabel{{ $extension->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0">
                                            <div class="modal-header border-0"
                                                style="background-color: {{ $extension->randomColor() }};">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="extension-icon bg-white rounded p-2">
                                                        <i class="bi bi-puzzle-fill fs-1"
                                                            style="color: {{ $extension->randomColor() }};"></i>
                                                    </div>
                                                    <h5 class="modal-title text-white mb-0"
                                                        id="extensionModalLabel{{ $extension->id }}">
                                                        {{ $extension->name }}
                                                    </h5>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-4">
                                                    <h6 class="fw-bold mb-2">{{ __('common.description') }}</h6>
                                                    <p style="text-align: justify;">{{ $extension->getDescription() }}</p>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-4">
                                                    <span class="text-muted small">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $extension->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-12 text-center">
                            <p class="text-muted">{{ __('common.no_extensions_available') }}</p>
                            <img src="{{ asset('core/vendor/img/icon/not-available-light.svg') }}" width="100"
                                alt="Empty Extensions" class="mt-4">
                        </div>
                    @endif
                </div>
                {{-- end extension --}}

                {{-- end lessons --}}
                {{-- start related channels --}}
                <div class="row related-channels mt-12">
                    <h3 class="mb-12 display-6 fw-bold">{{ __('common.courses_you_may_like') }}</h3>
                    @if (count($relatedChannels) > 0)
                        @foreach ($relatedChannels as $relatedChannel)
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="card h-100 shadow-sm hover-elevate-up">
                                    <div class="position-relative">
                                        <img src="{{ $relatedChannel->getUrl() }}" class="card-img-top"
                                            alt="{{ $relatedChannel->channel_name }}"
                                            style="height: 200px; object-fit: cover;background-position: center;background-repeat: no-repeat;background-size: cover;filter: brightness(0.8);">
                                        <div class="position-absolute top-0 end-0 p-3">
                                            <a href="{{ $relatedChannel->url }}" target="_blank"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                <i class="bi bi-link fs-2 text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-4 d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="card-title fw-bold text-truncate">
                                                {{ $relatedChannel->channel_name }}
                                            </h5>
                                            <p class="text-muted small mb-5 mb-0">
                                                {{ $relatedChannel->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ $relatedChannel->url }}" target="_blank"
                                                class="btn btn-sm bg-logo flex-grow-1">
                                                <i class="bi bi-link fs-2 text-white me-2"></i>
                                                {{ __('common.visit_channel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <p class="text-muted">{{ __('common.no_related_channels_available') }}</p>
                            <img src="{{ asset('core/vendor/img/icon/not-available-light.svg') }}" width="100"
                                alt="">

                        </div>
                    @endif
                </div>
                {{-- end related channels --}}
            </div>
        </section>
    </section>
@endsection
