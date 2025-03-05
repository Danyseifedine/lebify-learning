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
                <div class="quiz-attempt-item mb-3 p-3 border rounded
                    @if ($attempt->status == 'aborted') bg-light-dark
                    @elseif ($attempt->passed) bg-light-success
                    @else bg-light-danger @endif"
                    style="cursor: pointer; transition: transform 0.2s;" data-bs-toggle="modal"
                    data-bs-target="#attemptModal{{ $attempt->id }}">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">{{ $attempt->quiz->title }}</h6>
                        @if ($attempt->status == 'aborted')
                            <span class="text-white badge bg-danger">{{ __('common.aborted') }}</span>
                        @endif
                        @if ($attempt->passed)
                            <span class="text-white badge bg-success">{{ __('common.passed') }}</span>
                        @endif
                        @if (!$attempt->passed && $attempt->status != 'aborted')
                            <span class="text-white badge bg-danger">{{ __('common.failed') }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted mt-2">{{ __('common.score') }}: {{ $attempt->score }}%</span>
                        <span class="text-muted mt-2">{{ __('common.date') }}:
                            {{ $attempt->created_at->diffForHumans() }}</span>
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
                                                        <span class="text-white-50">{{ __('common.score') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Quiz Details -->
                                    <div class="col-lg-8 details-section p-4">
                                        <div class="quiz-details">
                                            <h6 class="section-title">
                                                <i class="bi bi-info-circle me-2"></i>
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

                                            <div class="reason-section mt-4">
                                                @if ($attempt->reason)
                                                    <div class="detail-card warning">
                                                        <div class="detail-icon">
                                                            <i class="bi bi-exclamation-circle"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <span
                                                                class="detail-value text-warning">{{ __('common.lost_focus_reason') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="description-section mt-4">
                                                <h6 class="section-title">
                                                    <i class="bi bi-file-earmark-text text-muted fs-2 me-2"></i>
                                                    {{ __('common.description') }}
                                                </h6>
                                                <p class="description-text">{{ $attempt->quiz->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer border-0 bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i>{{ __('common.close') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<style>
    .attempt-result-modal .modal-content {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .attempt-result-modal .gradient-header {
        padding: 1.5rem;
    }

    .attempt-result-modal .score-circle-container {
        position: relative;
        padding: 1rem;
    }

    .attempt-result-modal .score-circle {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .attempt-result-modal .score-circle:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .attempt-result-modal .gradient-success {
        background: linear-gradient(135deg, #43cea2 0%, #20de23 100%);
    }

    .attempt-result-modal .gradient-danger {
        background: linear-gradient(135deg, #ff557d 0%, #ff0000 100%);
    }

    .attempt-result-modal .gradient-dark {
        background: linear-gradient(135deg, #6b707d 0%, #607cbe 100%);
    }

    .attempt-result-modal .score-content {
        color: white;
        text-align: center;
    }

    .attempt-result-modal .status-icon-container {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem 2rem;
        border-radius: 15px;
        color: white;
    }

    .attempt-result-modal .status-icon-container i {
        margin-bottom: 0.5rem;
    }

    .attempt-result-modal .status-text {
        font-size: 1.1rem;
        font-weight: 500;
    }

    .attempt-result-modal .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .attempt-result-modal .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .attempt-result-modal .detail-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 12px;
        transition: transform 0.2s ease;
    }

    .attempt-result-modal .detail-card:hover {
        transform: translateY(-2px);
    }

    .attempt-result-modal .detail-icon {
        width: 45px;
        height: 45px;
        background-color: #ff4b2b;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .attempt-result-modal .detail-icon i {
        color: white;
        font-size: 1.5rem;
    }

    .attempt-result-modal .detail-content {
        flex: 1;
    }

    .attempt-result-modal .detail-label {
        display: block;
        font-size: 0.9rem;
    }

    .attempt-result-modal .detail-value {
        display: block;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .attempt-result-modal .warning .detail-icon {
        background-color: #ffc107;
    }

    .attempt-result-modal .description-section {
        padding: 1.5rem;
        border-radius: 12px;
    }

    .attempt-result-modal .description-text {
        line-height: 1.6;
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .attempt-result-modal .details-grid {
            grid-template-columns: 1fr;
        }

        .attempt-result-modal .score-circle {
            width: 150px;
            height: 150px;
        }
    }
</style>
