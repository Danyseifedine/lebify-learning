@if ($quizzes->count() > 0)
    <section class="py-8">
        <div class="container">
            <div class="quiz-grid">
                @foreach ($quizzes as $quiz)
                    <div href="javascript:void(0);" class="quiz-card quiz-link" data-quiz-id="{{ $quiz->id }}">
                        <!-- Difficulty Icon -->
                        <div class="difficulty-section">
                            <div class="difficulty-icon">
                                <img src="{{ asset('core/vendor/img/icon/' . $quiz->difficultyLevel->getDifficultyImage() . '.svg', true) }}"
                                    alt="{{ $quiz->getDifficultyLevelName() }}">
                            </div>
                        </div>

                        <!-- Quiz Info -->
                        <div class="quiz-info">
                            <h3 class="quiz-title">{{ $quiz->title }}</h3>
                            <div class="time-badge">
                                {{ $quiz->duration->formatDuration() }}
                            </div>
                        </div>

                        <!-- Quiz Description -->
                        <div class="quiz-description">
                            <p>{{ $quiz->description }}</p>
                        </div>

                        <!-- Stats Grid -->
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-value">{{ $questionCounts[$quiz->id]->total ?? 0 }}</div>
                                <div class="stat-label">Questions</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $questionCounts[$quiz->id]->multiple_choice ?? 0 }}</div>
                                <div class="stat-label">Choices</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $questionCounts[$quiz->id]->true_false ?? 0 }}</div>
                                <div class="stat-label">True/False</div>
                            </div>
                        </div>

                        <div style="width: 100%; height: 250px;">
                            <canvas class="performance-distribution-chart"
                                id="performance-distribution-chart-{{ $quiz->id }}"
                                data-chart-data='@json($stats[$loop->index])'></canvas>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
<x-web.dynamic-pagination :data="$quizzes" emptyText="No quizzes found for your search please try again"
    emptyImage="core/vendor/img/icon/quiz-icon.svg" />
