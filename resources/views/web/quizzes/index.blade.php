

@extends('web.layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/web/quiz/index.css', true) }}">
    <link rel="stylesheet" href="{{ asset('css/web/quiz/quiz-card.css', true) }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="banner-wrapper" style="margin-top: 53px">
            <section class="quiz-banner position-relative overflow-hidden py-20">
                <!-- Animated Background Grid -->
                <div class="animated-grid banner-element"></div>

                <!-- Gradient Overlay -->
                <div class="gradient-overlay banner-element"></div>

                <!-- Animated Shapes -->
                <div class="banner-bg-elements">
                    <div class="banner-shape-1 banner-element"></div>
                    <div class="banner-shape-2 banner-element"></div>
                    <div class="banner-shape-3 banner-element"></div>
                </div>

                <div class="container position-relative z-1">
                    <div class="row align-items-center">
                        <div class="col-lg-6 text-center text-lg-start">
                            <div class="banner-content">
                                <x-web.section-badge title="FEATURED QUIZZES" class="mb-4 banner-element" />
                                <h1 class="display-4 fw-bolder mb-4 banner-title banner-element">
                                    Test Your Knowledge<br>
                                    Through <span class="gradient-text">Interactive Quizzes</span>
                                </h1>
                                <p class="lead fs-3 mb-5 banner-subtitle banner-element text-white-50">
                                    {{ __('common.there_is_tons_of_quizzes') }}
                                </p>

                                <!-- Stats Row -->
                                <div class="banner-stats d-flex gap-4 mb-5 banner-element">
                                    <div class="stat-item text-center">
                                        <div class="stat-value fw-bold display-6 gradient-text">100+</div>
                                        <div class="stat-label text-muted">Total Quizzes</div>
                                    </div>
                                    <div class="stat-item text-center">
                                        <div class="stat-value fw-bold display-6 gradient-text">1000+</div>
                                        <div class="stat-label text-muted">Questions</div>
                                    </div>
                                    <div class="stat-item text-center">
                                        <div class="stat-value fw-bold display-6 gradient-text">500+</div>
                                        <div class="stat-label text-muted">Students</div>
                                    </div>
                                </div>

                                <button type="button" class="btn bg-logo d-flex align-items-center gap-2 btn-lg"
                                    data-bs-toggle="modal" data-bs-target="#quizGuideModal">
                                    <i class="bi bi-shield-fill-check text-white fs-2 me-2"></i>Read Rules
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="banner-illustration banner-element">
                                <img src="{{ asset('core/vendor/img/bg/quiz-banner.svg') }}" alt="Quiz Illustration"
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="filter-overlay-quiz"></div>

        <div class="container app-bg py-8">
            <div class="active-filter-wrapper-header d-flex align-items-start flex-wrap justify-content-between mb-4">
                <div>
                    <h2 class="mb-0">All Quizzes</h2>
                    <p class="text-muted mb-0">Explore our collection of quizzes</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="active-filters d-flex gap-2 flex-wrap">
                        <!-- Active filters will be added here dynamically -->
                    </div>
                    <div class="filter-actions d-flex gap-2">
                        <button class="filter-trigger-btn" data-bs-toggle="collapse" data-bs-target="#filterDrawer">
                            <i class="bi bi-funnel"></i>
                            <span>Filter Quizzes</span>
                        </button>
                        <button class="btn btn-light rounded-pill" id="clearFilterButton">
                            <i class="bi bi-arrow-counterclockwise fs-2"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <section class="quizzes-section">
        </section>

        <!-- Quiz Guide Modal -->
        <div class="modal fade" id="quizGuideModal" tabindex="-1" aria-labelledby="quizGuideModalLabel" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header border-0">
                        <div class="modal-title-wrapper">
                            <div class=" gap-3 mb-2">
                                <span class="modal-step-badge">Step <span class="current-step">1</span> of 4</span>
                                <div class="step-dots mx-3 mt-5 mb-12">
                                    <span class="step-dot active" data-step="1"></span>
                                    <span class="step-dot" data-step="2"></span>
                                    <span class="step-dot" data-step="3"></span>
                                    <span class="step-dot" data-step="4"></span>
                                </div>
                            </div>
                            <h5 class="modal-title display-6 fw-bold" id="quizGuideModalLabel">
                                How Quizzes Work
                            </h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-2">
                        <!-- Progress Bar -->
                        <div class="progress-wrapper mb-4">
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" role="progressbar" style="width: 33%"></div>
                            </div>
                        </div>

                        <div class="steps-container">
                            <!-- Step 1: Difficulty Levels -->
                            <div class="step" data-step="1">
                                <div class="step-header">
                                    <div class="step-icon">
                                        <i class="bi ico fs-4 bi-bar-chart-steps"></i>
                                    </div>
                                    <div>
                                        <h5 class="step-title">Quiz Difficulty Levels</h5>
                                        <p class="step-description">Choose the difficulty that matches your expertise level
                                        </p>
                                    </div>
                                </div>

                                <div class="selectable-container">
                                    <div class="rule-item" data-difficulty="beginner">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-star"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Beginner</h6>
                                            <p>Perfect for those just starting out. Basic concepts and straightforward
                                                questions.</p>
                                        </div>
                                    </div>

                                    <div class="rule-item" data-difficulty="intermediate">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-stars"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Intermediate</h6>
                                            <p>For users with some experience. Moderate difficulty with more complex
                                                scenarios.</p>
                                        </div>
                                    </div>

                                    <div class="rule-item" data-difficulty="advanced">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-award"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Advanced</h6>
                                            <p>Challenging questions for experienced users. Tests in-depth knowledge.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Duration Types -->
                            <div class="step" data-step="2">
                                <div class="step-header">
                                    <div class="step-icon">
                                        <i class="bi ico fs-4 bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <h5 class="step-title">Quiz Duration Types</h5>
                                        <p class="step-description">Select the time format that works best for you</p>
                                    </div>
                                </div>

                                <div class="selectable-container">
                                    <div class="rule-item" data-duration="rapid">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-lightning-charge"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Rapid</h6>
                                            <p>30-minute comprehensive assessments</p>
                                        </div>
                                    </div>

                                    <div class="rule-item" data-duration="blitz">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-stopwatch"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Blitz</h6>
                                            <p>Quick 5-minute quizzes for rapid assessment</p>
                                        </div>
                                    </div>

                                    <div class="rule-item" data-duration="bullet">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-alarm"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Bullet</h6>
                                            <p>15-minute quizzes for balanced timing</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Rules -->
                            <div class="step" data-step="3">
                                <div class="step-header">
                                    <div class="step-icon">
                                        <i class="bi ico fs-4 bi-shield-check"></i>
                                    </div>
                                    <div>
                                        <h5 class="step-title">Important Quiz Rules</h5>
                                        <p class="step-description">Make sure to follow these guidelines for the best
                                            experience</p>
                                    </div>
                                </div>

                                <div class="rules-list">
                                    <div class="rule-item">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-shield-check"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Limited Attempts</h6>
                                            <p>Each quiz has a limited number of attempts. Your final grade will be
                                                calculated as the average of all your attempts.</p>
                                        </div>
                                    </div>

                                    <div class="rule-item">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-clock-history"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Time Management</h6>
                                            <p>Once started, the quiz timer cannot be paused. Make sure you have enough time
                                                to complete it.</p>
                                        </div>
                                    </div>

                                    <div class="rule-item">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-check-circle"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Answer Review</h6>
                                            <p>You can review and change your answers before final submission within the
                                                time limit.</p>
                                        </div>
                                    </div>

                                    <div class="rule-item">
                                        <div class="rule-icon">
                                            <i class="bi ico fs-4 bi-exclamation-triangle"></i>
                                        </div>
                                        <div class="rule-content">
                                            <h6>Browser Navigation</h6>
                                            <p>Do not use browser navigation buttons during the quiz. This may result in
                                                losing your progress.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Security Rules -->
                            <div class="step" data-step="4">
                                <div class="security-warning-header">
                                    <i class="bi ico fs-4 bi-shield-lock security-icon-large"></i>
                                    <h4 class="security-title text-white">Important Security Notice</h4>
                                    <p class="security-subtitle">Please read these security measures carefully before
                                        proceeding</p>
                                </div>

                                <div class="security-rules-container">
                                    <div class="rule-item">
                                        <div class="security-rule-icon">
                                            <i class="bi ico fs-4 bi-display"></i>
                                        </div>
                                        <div class="security-rule-content">
                                            <h6>Screen Focus</h6>
                                            <p>Switching tabs or leaving the quiz window will result in automatic attempt
                                                abortion. Keep the quiz window active.</p>
                                        </div>
                                    </div>

                                    <div class="rule-item">
                                        <div class="security-rule-icon">
                                            <i class="bi ico fs-4 bi-mouse"></i>
                                        </div>
                                        <div class="security-rule-content">
                                            <h6>Cursor Boundaries</h6>
                                            <p>Your cursor must remain within the quiz area. Moving outside may trigger a
                                                warning.</p>
                                        </div>
                                    </div>

                                    <div class="rule-item">
                                        <div class="security-rule-icon">
                                            <i class="bi ico fs-4 bi-clipboard-x"></i>
                                        </div>
                                        <div class="security-rule-content">
                                            <h6>Copy Prevention</h6>
                                            <p>Copy, paste, and right-click functions are disabled during the quiz.</p>
                                        </div>
                                    </div>

                                    <div class="rule-item">
                                        <div class="security-rule-icon warning">
                                            <i class="bi ico fs-4 bi-exclamation-triangle"></i>
                                        </div>
                                        <div class="security-rule-content">
                                            <h6>Warning System</h6>
                                            <p>You'll receive warnings for security violations. Multiple violations will
                                                abort the attempt.</p>
                                        </div>
                                    </div>
                                    <div class="security-notice">
                                        <i class="bi bi-info-circle"></i>
                                        <p>These security measures are in place to maintain academic integrity and ensure
                                            fair assessment for all students.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <div class="d-flex justify-content-between w-100">
                            <button type="button" class="btn btn-outline-secondary prev-step d-none">
                                Previous
                            </button>
                            <div class="ms-auto">
                                <button type="button" class="btn bg-logo next-step">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse" id="filterDrawer">
            <div class="filter-drawer">
                <div class="container">
                    <div class="filter-header d-flex justify-content-between align-items-center mb-4">
                        <h5 class="m-0">Filter Quizzes</h5>
                        <button class="btn-close" data-bs-toggle="collapse" data-bs-target="#filterDrawer"></button>
                    </div>

                    <form method="GET" id="filterForm" action="" class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label">Search by title</label>
                            <input type="text" name="search" class="form-control"
                                placeholder="{{ __('common.search_by_title') }}" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('common.duration') }}</label>
                            <select name="duration" class="form-select">
                                <option value="">{{ __('common.all') }}</option>
                                @foreach ($durations as $duration)
                                    <option value="{{ $duration->id }}"
                                        {{ request('duration') == $duration->id ? 'selected' : '' }}>
                                        {{ $duration->getDurationName() }} ({{ $duration->minutes }}
                                        {{ __('common.minutes') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('common.difficulty_level') }}</label>
                            <select name="difficulty" class="form-select">
                                <option value="">{{ __('common.all') }}</option>
                                @foreach ($difficulties as $difficulty)
                                    <option value="{{ $difficulty->id }}"
                                        {{ request('difficulty') == $difficulty->id ? 'selected' : '' }}>
                                        {{ $difficulty->getDifficultyName() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <div class="filter-footer mt-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <button id="filterButton" class="btn bg-logo" data-bs-toggle="collapse"
                                data-bs-target="#filterDrawer">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/web/quiz/index.js', true) }}" type="module"></script>
    <script src="{{ asset('js/web/quiz/singlePage.js', true) }}" type="module"></script>
    <script src="{{ asset('core/packages/gsap/gsap.min.js') }}"></script>
@endpush
