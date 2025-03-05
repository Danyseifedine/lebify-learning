<link rel="stylesheet" href="{{ asset('css/web/quiz/quiz-detail.css', true) }}">

<div class="quiz-details-container container">
    <!-- Hero Section -->
    <div class="quiz-hero {{ $attemptsEnded ? 'attempts-ended' : '' }}">
        <div class="quiz-hero-pattern"></div>
        <div class="quiz-hero-content">
            <div class="quiz-badge text-white">{{ $quiz->getDifficultyLevelName() }} Level</div>
            <h1 class="quiz-title text-white">{{ $quiz->getTitle() }}</h1>

            <div class="quiz-meta">
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="meta-text">{{ $quiz->duration->formatDuration() }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <div class="meta-text">{{ $quiz->passing_score }}% to Pass</div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <div class="meta-text">{{ $questionsCount }} Questions</div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="bi bi-repeat"></i>
                    </div>
                    <div class="meta-text">{{ $userAttemptsCount }} / {{ $quiz->attempts_allowed }} Attempts</div>
                </div>
            </div>

            <div class="quiz-actions">
                @if ($quiz->isPublished() && !$attemptsEnded)
                    <button data-bs-toggle="modal" data-bs-target="#start-quiz-modal" class="action-btn start-btn">
                        <i class="bi bi-play-circle fs-1"></i>
                        <span>Start Quiz</span>
                    </button>
                @elseif ($attemptsEnded)
                    <button class="action-btn start-btn" disabled>
                        <i class="bi bi-x-circle"></i>
                        <span>No Attempts Left</span>
                    </button>
                @else
                    <button class="action-btn start-btn" disabled>
                        <i class="bi bi-info-circle"></i>
                        <span>Not Published Yet</span>
                    </button>
                @endif

                <a href="{{ route('quizzes.index') }}" class="action-btn back-btn">
                    <i class="bi bi-arrow-left fs-1 text-white"></i>
                    <span>Back to Quizzes</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Three-column layout -->
    <div class="three-column-layout">
        <!-- Left Column: Action Card -->
        <div class="left-column">
            <div class="action-card {{ $attemptsEnded ? 'attempts-ended' : '' }}">
                <div class="action-card-pattern"></div>
                <div class="action-card-content">
                    @if ($attemptsEnded)
                        <h3 class="action-card-title text-white">All Attempts Used</h3>
                        <p class="action-card-text">You have used all your available attempts for this quiz. Check your
                            results or try other quizzes.</p>
                        <button class="action-card-btn" disabled>
                            <i class="bi bi-x-circle"></i>
                            <span>No Attempts Left</span>
                        </button>
                    @else
                        <h3 class="action-card-title text-white">Ready to Test Your Knowledge?</h3>
                        <p class="action-card-text text-white">Challenge yourself with this quiz and see how well you
                            understand
                            the material.</p>

                        @if ($quiz->isPublished())
                            <button data-bs-toggle="modal" data-bs-target="#start-quiz-modal"
                                class="action-card-btn pulse-on-hover">
                                <i class="bi bi-play-circle"></i>
                                <span>Start Quiz Now</span>
                            </button>
                        @else
                            <button class="action-card-btn" disabled>
                                <i class="bi bi-info-circle"></i>
                                <span>Not Published Yet</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Coming Soon Card -->
            <div class="coming-soon-card">
                <div class="coming-soon-card-pattern"></div>
                <div class="coming-soon-card-content">
                    <div class="coin-icon-wrapper">
                        <div class="coin-icon">
                            <i class="bi bi-coin"></i>
                        </div>
                    </div>
                    <div class="coming-soon-text-content">
                        <div class="coming-soon-badge">Coming Soon</div>
                        <h3 class="coming-soon-title">Quiz Rewards System</h3>
                        <p class="coming-soon-text">Earn coins by completing quizzes to unlock premium content and
                            features.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Center Column: Main Content -->
        <div class="center-column">
            <!-- Description Section -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <h2 class="section-title">Description</h2>
                </div>
                <div class="section-body">
                    <div class="quiz-description-detail">{{ $quiz->description }}</div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-bar-chart"></i>
                    </div>
                    <h2 class="section-title">Quiz Statistics</h2>
                </div>
                <div class="section-body">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value primary">{{ $totalAttemptsCount }}</div>
                                <div class="stat-label">Total Attempts</div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value success">{{ $totalPassedAttemptsCount }}</div>
                                <div class="stat-label">Passed Attempts</div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="bi bi-x-circle"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value warning">{{ $totalFailedAttemptsCount }}</div>
                                <div class="stat-label">Failed Attempts</div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon info">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value info">{{ $totalAbortedAttemptsCount }}</div>
                                <div class="stat-label">Aborted Attempts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Types Section -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <h2 class="section-title">Question Types</h2>
                </div>
                <div class="section-body">
                    <div class="question-types">
                        <div class="question-type">
                            <div class="type-icon multiple-choice">
                                <i class="bi bi-list-check"></i>
                            </div>
                            <div class="type-count multiple-choice">{{ $multipleChoiceCount }}</div>
                            <div class="type-label">Multiple Choice</div>
                        </div>

                        <div class="question-type">
                            <div class="type-icon true-false">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <div class="type-count true-false">{{ $trueFalseCount }}</div>
                            <div class="type-label">True/False</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Difficulty and Details -->
        <div class="right-column">
            <!-- Difficulty Card -->
            <div class="difficulty-card">
                <div class="difficulty-body">
                    <img src="{{ asset('core/vendor/img/icon/' . $quiz->difficultyLevel->getDifficultyImage() . '.svg', true) }}"
                        alt="{{ $quiz->getDifficultyLevelName() }}" class="difficulty-icon">
                    <div class="difficulty-level">{{ $quiz->getDifficultyLevelName() }}</div>
                </div>
            </div>

            <!-- Quiz Details -->
            <div class="details-card">
                <div class="details-header">
                    <h3 class="details-title">Quiz Details</h3>
                </div>
                <div class="details-body">
                    <div class="details-list">
                        <div class="detail-item">
                            <div class="detail-icon primary">
                                <i class="bi bi-stopwatch"></i>
                            </div>
                            <div class="detail-info">
                                <div class="detail-label">Duration</div>
                                <div class="detail-value">{{ $quiz->getDurationName() }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon success">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="detail-info">
                                <div class="detail-label">Created On</div>
                                <div class="detail-value">{{ $quiz->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon info">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="detail-info">
                                <div class="detail-label">Your Attempts</div>
                                <div class="detail-value">
                                    {{ $userAttemptsCount }} / {{ $quiz->attempts_allowed }}
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon danger">
                                <i class="bi bi-award"></i>
                            </div>
                            <div class="detail-info">
                                <div class="detail-label">Passing Score</div>
                                <div class="detail-value">{{ $quiz->passing_score }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Quiz Modal -->
<div class="modal fade" id="start-quiz-modal" tabindex="-1" aria-labelledby="start-quiz-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header quiz-modal-header border-0">
                <h5 class="modal-title" id="quizGuideModalLabel">
                    Start Quiz
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Simple Tips Section -->
                <div class="quiz-modal-simple-tips">
                    <div class="tips-header">
                        <i class="bi bi-lightbulb"></i>
                        <span>Before You Begin</span>
                    </div>
                    <ul class="simple-tips-list">
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Attempts will be used</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Ensure Stable Connection</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Read Questions Carefully</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Manage Time Wisely</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" data-quiz-id="{{ $quiz->id }}"
                    class="btn start-quiz-btn start-btn-modal bg-logo">
                    Start Now
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/web/quiz/quiz.js', true) }}" type="module"></script>
@endpush
