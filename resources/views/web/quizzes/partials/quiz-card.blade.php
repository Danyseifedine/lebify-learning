<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 text-truncate">{{ $quiz->getTitle() }}</h5>
            @if ($quiz->isPublished())
                <span class="badge bg-success">{{ __('common.published') }}</span>
            @else
                <span class="badge bg-warning">{{ __('common.draft') }}</span>
            @endif
        </div>

        <div class="card-body">
            <p class="card-text text-muted mb-4">{{ Str::limit($quiz->getDescription(), 100) }}</p>

            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('core/vendor/img/icon/' . $quiz->difficultyLevel->getDifficultyImage() . '.svg', true) }}"
                        alt="Difficulty" class="me-2" style="width: 24px; height: 24px;">
                    <span>{{ $quiz->getDifficultyLevelName() }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('core/vendor/img/quiz/duration/' . $quiz->duration->getDurationImage() . '.svg', true) }}"
                        alt="Duration" class="me-2" style="width: 24px; height: 24px;">
                    <span>{{ $quiz->duration->formatDuration() }}</span>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-question-circle me-2"></i>
                    <span>{{ $quiz->questionsCount() }} {{ __('common.questions') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-trophy me-2"></i>
                    <span>{{ $quiz->passing_score }}% {{ __('common.to_pass') }}</span>
                </div>
            </div>

            <div class="d-grid">
                <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-primary">
                    <i class="bi bi-play-circle me-2"></i>{{ __('common.start_quiz') }}
                </a>
            </div>
        </div>
    </div>
</div>
