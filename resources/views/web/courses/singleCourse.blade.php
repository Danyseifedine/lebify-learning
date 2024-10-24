@extends('layouts.user')

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
        style="background-image: url('{{ asset('vendor/img/bg/course-bg.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;background-size: cover;">
        <div class="container mt-5">
            <div class="row align-items-center">
                <!-- start course image -->
                <div class="col-md-6">
                    <img width="500" src="{{ $course->getFirstMedia('course_images')->getUrl() }}" alt="{{ $course->title }}"
                        class="img-fluid rounded">
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
        <section class="py-5" style="padding-top: 100px !important; padding-bottom: 1000px !important;">
            <div class="container">
                <!-- start course content -->
                <h2 class="mb-4 display-4 fw-bold">{{ __('common.course_content') }}</h2>
                <div class="row mt-12">
                    <div class="col-md-8">
                        <h3 class="mb-8 fw-bold">{{ __('common.full_explanation') }}</h3>
                        @foreach ($documents as $document)
                            <div class="accordion" id="accordion_{{ $document->id }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="accordion_header_{{ $document->id }}">
                                        <button class="accordion-button  fs-4 fw-bold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#accordion_body_{{ $document->id }}"
                                            aria-expanded="true" aria-controls="accordion_body_{{ $document->id }}">
                                            <!-- start course document title -->
                                            {{ $document->getTitle() }}
                                            <!-- end course document title -->
                                        </button>
                                    </h2>
                                    <div id="accordion_body_{{ $document->id }}" class="accordion-collapse collapse show"
                                        aria-labelledby="accordion_header_{{ $document->id }}"
                                        data-bs-parent="#accordion_{{ $document->id }}">
                                        <div class="accordion-body">
                                            <!-- start course document description -->
                                            <p style="text-align: justify">{{ $document->getDescription() }}
                                            </p>
                                            <!-- end course document description -->
                                            <!-- button to move to the document -->
                                            <div class="d-flex mt-5 align-items-center gap-5 justify-content-end">
                                                <a href=""
                                                    class="btn logo-border">{{ __('common.view_full_document') }}
                                                    ({{ __('common.english') }})
                                                </a>
                                                <a href=""
                                                    class="btn logo-border">{{ __('common.view_full_document') }}
                                                    ({{ __('common.arabic') }})</a>
                                            </div>
                                            <!-- end button to move to the document -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        <!-- start helpful links -->
                        <h3 class="mb-8 fw-bold">Helpful Links</h3>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="#" class="text-decoration-none">Additional Resource
                                    1</a></li>
                            <li class="list-group-item"><a href="#" class="text-decoration-none">Additional Resource
                                    2</a></li>
                            <li class="list-group-item"><a href="#" class="text-decoration-none">Additional Resource
                                    3</a></li>
                            <li class="list-group-item"><a href="#" class="text-decoration-none">Additional Resource
                                    4</a></li>
                        </ul>
                        <!-- end helpful links -->
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
