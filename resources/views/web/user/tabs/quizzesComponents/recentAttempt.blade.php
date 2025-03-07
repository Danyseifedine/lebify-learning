<div class="card-body">
    <h5 class="card-title recent-attempts mb-5">{{ __('common.recent_attempts') }} ( {{ $attempts->count() }} )</h5>
    <div class="quiz-attempts-container" style="max-height: 500px; overflow-y: auto;">
        @if ($attempts->isEmpty())
            <div class="text-center" style="padding-top: 100px;">
                <img src="{{ asset('vendor/img/icon/quiz-icon.svg', true) }}" class="mw-250px mb-7" alt="">
                <p>{{ __('common.no_recent_attempts_found') }}</p>
            </div>
        @else
            @foreach ($attempts as $attempt)
                <!-- Minimalist Quiz Attempt Item -->
                <div class="quiz-attempt-item mb-3 position-relative" data-bs-toggle="modal"
                    data-bs-target="#attemptModal{{ $attempt->id }}">

                    <!-- Status indicator strip -->
                    <div
                        class="status-indicator
                        @if ($attempt->status == 'aborted') status-aborted
                        @elseif ($attempt->passed) status-passed
                        @else status-failed @endif">
                    </div>

                    <div class="attempt-content">
                        <div class="quiz-title-section">
                            <h6 class="quiz-title">{{ $attempt->quiz->title }}</h6>

                            @if ($attempt->status == 'aborted')
                                <span class="status-badge aborted">
                                    <i class="bi bi-x-circle"></i> {{ __('common.aborted') }}
                                </span>
                            @elseif ($attempt->passed)
                                <span class="status-badge passed">
                                    <i class="bi bi-check-circle text-success"></i> {{ __('common.passed') }}
                                </span>
                            @else
                                <span class="status-badge failed ">
                                    <i class="bi bi-x-circle text-danger"></i> {{ __('common.failed') }}
                                </span>
                            @endif
                        </div>

                        <div class="quiz-stats">
                            <div class="stat-item">
                                <i class="bi bi-trophy"></i>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $attempt->score }}%</span>
                                    <span class="stat-label">Score</span>
                                </div>
                            </div>

                            <div class="stat-item">
                                <i class="bi bi-calendar"></i>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $attempt->created_at->diffForHumans() }}</span>
                                    <span class="stat-label">Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Modal with Advanced Design -->
                <div class="modal fade attempt-result-modal" id="attemptModal{{ $attempt->id }}" tabindex="-1"
                    aria-labelledby="attemptModalLabel{{ $attempt->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header with Gradient -->
                            <div class="modal-header gradient-header border-0">
                                <h5 class="modal-title fw-bold" id="attemptModalLabel{{ $attempt->id }}">
                                    {{ $attempt->quiz->title }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="{{ __('common.close') }}"></button>
                            </div>

                            <div class="modal-body p-0">
                                <div class="row g-0">
                                    <!-- Left Column - Score and Status -->
                                    <div class="col-md-4 score-section p-4">
                                        <div class="text-center">
                                            <div class="score-circle-container">
                                                <div
                                                    class="score-circle mb-4
                                                    @if ($attempt->status == 'aborted') gradient-dark
                                                    @elseif ($attempt->passed) gradient-success
                                                    @else gradient-danger @endif">
                                                    <div class="score-content">
                                                        <h1 class="display-4 mb-0 fw-bold">{{ $attempt->score }}%</h1>
                                                        <span>{{ __('common.score') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <span
                                                    class="badge fs-6 py-2 px-4
                                                    @if ($attempt->status == 'aborted') bg-secondary
                                                    @elseif ($attempt->passed) bg-success
                                                    @else bg-danger @endif">
                                                    @if ($attempt->status == 'aborted')
                                                        <i
                                                            class="bi bi-x-octagon text-white me-2"></i>{{ __('common.aborted') }}
                                                    @elseif ($attempt->passed)
                                                        <i
                                                            class="bi bi-check-circle text-white me-2"></i>{{ __('common.passed') }}
                                                    @else
                                                        <i
                                                            class="bi bi-x-circle text-white me-2"></i>{{ __('common.failed') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Quiz Details -->
                                    <div class="col-lg-8 details-section">
                                        <div class="quiz-details">
                                            <h6 class="section-title">
                                                <i class="bi bi-info-circle"></i>
                                                {{ __('common.quiz_details') }}
                                            </h6>

                                            <div class="details-grid">
                                                <div class="detail-card">
                                                    <div class="detail-icon">
                                                        <i class="bi bi-calendar"></i>
                                                    </div>
                                                    <div class="detail-content">
                                                        <span class="detail-label">{{ __('common.date') }}</span>
                                                        <span
                                                            class="detail-value">{{ $attempt->created_at->format('M d, Y H:i') }}</span>
                                                    </div>
                                                </div>

                                                <div class="detail-card">
                                                    <div class="detail-icon">
                                                        <i class="bi bi-question-square"></i>
                                                    </div>
                                                    <div class="detail-content">
                                                        <span
                                                            class="detail-label">{{ __('common.total_questions') }}</span>
                                                        <span
                                                            class="detail-value">{{ $attempt->quiz->questionsCount() }}</span>
                                                    </div>
                                                </div>

                                                <div class="detail-card">
                                                    <div class="detail-icon">
                                                        <i class="bi bi-star-fill"></i>
                                                    </div>
                                                    <div class="detail-content">
                                                        <span class="detail-label">{{ __('common.difficulty') }}</span>
                                                        <span
                                                            class="detail-value">{{ $attempt->quiz->difficultyLevel->name }}</span>
                                                    </div>
                                                </div>

                                                <div class="detail-card">
                                                    <div class="detail-icon">
                                                        <i class="bi bi-hourglass-split"></i>
                                                    </div>
                                                    <div class="detail-content">
                                                        <span class="detail-label">{{ __('common.duration') }}</span>
                                                        <span
                                                            class="detail-value">{{ $attempt->quiz->duration->minutes }}
                                                            {{ __('common.minutes') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($attempt->reason)
                                                <div class="reason-section mt-4">
                                                    <div class="detail-card warning">
                                                        <div class="detail-icon">
                                                            <i class="bi bi-exclamation-circle"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <span
                                                                class="detail-label">{{ __('common.lost_focus_reason') }}</span>
                                                            <span class="detail-value">{{ $attempt->reason }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="description-section mt-4">
                                                <h6 class="section-title">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                    {{ __('common.description') }}
                                                </h6>
                                                <p class="description-text">{{ $attempt->quiz->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
