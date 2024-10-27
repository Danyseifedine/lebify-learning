@extends('web.layouts.user')

@section('content')
    <div style="padding-top: 53px !important;">
        <section class="text-center"
            style="background-image: url('{{ asset('vendor/img/bg/banner-bg.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;background-size: cover;padding:100px;background-color:{{ $course->color }};">
            <div class="container">
                <h1 class="display-4 text-white fw-bold mb-4">{{ $course->title }}</h1>
            </div>
        </section>
    </div>

    <section
        style="background-image: url('{{ asset('vendor/img/bg/single-course-bg.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;background-size: cover;">
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
                <!-- start course content -->
                <h2 class="mb-4 display-4 fw-bold">{{ __('common.course_content') }}</h2>
                <div class="row mt-12">
                    <div class="col-md-8">
                        <h3 class="mb-8 fw-bold">{{ __('common.full_explanation') }}</h3>
                        <div class="accordion" id="courseAccordion">
                            @foreach ($documents as $index => $document)
                                <div class="accordion-item mt-3">
                                    <h2 class="accordion-header" id="accordion_header_{{ $document->id }}">
                                        <button class="accordion-button collapsed fs-4 fw-bold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#accordion_body_{{ $document->id }}"
                                            aria-expanded="false" aria-controls="accordion_body_{{ $document->id }}">
                                            <!-- start course document title -->
                                            <span class="me-3 fs-3 text-muted"
                                                style="min-width: 30px;">{{ $index + 1 }}.</span>
                                            {{ $document->getTitle() }}
                                            <!-- end course document title -->
                                        </button>
                                    </h2>
                                    <div id="accordion_body_{{ $document->id }}" class="accordion-collapse collapse"
                                        aria-labelledby="accordion_header_{{ $document->id }}"
                                        data-bs-parent="#courseAccordion">
                                        <div class="accordion-body">
                                            <!-- start course document description -->
                                            <p style="text-align: justify">{{ $document->getDescription() }}
                                            </p>
                                            <!-- end course document description -->
                                            <!-- button to move to the document -->
                                            <div class="d-flex mt-5 align-items-center gap-5 justify-content-end">
                                                <a href="{{ route('students.document', ['name' => $course->title, 'lang' => 'en', 'id' => encrypt($document->id), 'order' => encrypt($document->order)]) }}"
                                                    class="btn logo-border">{{ __('common.view_full_document') }}
                                                    ({{ __('common.english') }})
                                                </a>
                                                <a href="{{ route('students.document', ['name' => $course->title, 'lang' => 'ar', 'id' => encrypt($document->id), 'order' => encrypt($document->order)]) }}"
                                                    class="btn logo-border">{{ __('common.view_full_document') }}
                                                    ({{ __('common.arabic') }})</a>
                                            </div>
                                            <!-- end button to move to the document -->
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-1 mt-12"></div>
                    <div class="col-md-3">
                        <!-- start helpful links -->
                        <h3 class="mb-8 fw-bold">{{ __('common.helpful_links') }}</h3>
                        <p class="text-muted">{{ __('common.we_are_working_on_it') }}</p>
                        <!-- end helpful links -->
                    </div>
                </div>
                <!-- start related channels -->
                <div class="row mt-12">
                    <h3 class="mb-12 display-5 fw-bold">{{ __('common.courses_you_may_like') }}</h3>
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
                                            <i class="fas fa-external-link-alt"></i>
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
                                            <i class="fas fa-external-link-alt text-white me-2"></i>
                                            {{ __('common.visit_channel') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- end related channels -->
            </div>
        </section>
    </section>
@endsection
