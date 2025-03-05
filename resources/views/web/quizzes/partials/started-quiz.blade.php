<div class="quiz-experience-container">
    <!-- Fixed Timer and Controls Bar -->
    <div class="quiz-control-bar">
        <div class="quiz-timer">
            <div class="timer-icon">
                <i class="bi bi-stopwatch fs-1 text-white"></i>
            </div>
            <div class="timer-display">
                <div class="timer-label">Time Remaining</div>
                <div id="timer" class="timer-countdown">00:00</div>
            </div>
        </div>

        <div class="quiz-progress">
            <div class="progress-label">
                <span class="current-question">1</span> / <span class="total-questions">{{ count($questions) }}</span>
                Questions
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
            </div>
        </div>

        <button class="finish-quiz-btn btn bg-logo">
            <i class="bi bi-flag-fill fs-1 text-white"></i>
            <span>Submit Quiz</span>
        </button>
    </div>

    <!-- Main Quiz Content -->
    <div class="quiz-content">
        <div class="quiz-meta-bar">
            <div class="quiz-meta-item">
                <i class="bi bi-trophy"></i>
                <span>Pass: {{ $quiz->passing_score }}%</span>
            </div>
            <div class="quiz-meta-item">
                <i class="bi bi-question-circle"></i>
                <span>{{ count($questions) }} Questions</span>
            </div>
            <div class="quiz-meta-item">
                <i class="bi bi-bar-chart"></i>
                <span>{{ $quiz->getDifficultyLevelName() }}</span>
            </div>
        </div>

        <div class="questions-container">
            @foreach ($questions as $index => $question)
                <div class="question-card" data-question-id="{{ $question->id }}" data-type="{{ $question->type }}"
                    data-index="{{ $index + 1 }}">
                    <div class="question-sidebar"></div>
                    <div class="question-content">
                        <div class="question-header">
                            <div class="question-number">Question {{ $index + 1 }}</div>
                            <div
                                class="question-type-badge {{ $question->type === 'multiple_choice' ? 'multiple-choice' : 'true-false' }}">
                                <i
                                    class="bi {{ $question->type === 'multiple_choice' ? 'bi-list-check' : 'bi-check2-circle' }} question-type-badge-icon fs-4 "></i>
                                <span>{{ $question->type === 'multiple_choice' ? 'Multiple Choice' : 'True/False' }}</span>
                            </div>
                        </div>

                        <h3 class="question-text">{{ $question->question }}</h3>

                        <div
                            class="answers-container {{ $question->type === 'multiple_choice' ? 'grid-layout' : 'list-layout' }}">
                            @foreach ($question->answers as $answer)
                                <div class="answer-card" data-answer-id="{{ $answer->id }}">
                                    <div class="answer-radio">
                                        <div class="radio-outer">
                                            <div class="radio-inner"></div>
                                        </div>
                                    </div>
                                    <div class="answer-text">{{ $answer->answer }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="question-footer">
                            <div class="question-navigation">
                                @if ($index > 0)
                                    <button class="nav-btn prev-btn" data-target="{{ $index }}">
                                        <i class="bi bi-arrow-left"></i> Previous
                                    </button>
                                @endif

                                @if ($index < count($questions) - 1)
                                    <button class="nav-btn next-btn" data-target="{{ $index + 2 }}">
                                        Next <i class="bi bi-arrow-right"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="quiz-navigation">
            <div class="question-map">
                @foreach ($questions as $index => $question)
                    <div class="map-item" data-target="{{ $index + 1 }}">
                        <div class="map-number">{{ $index + 1 }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Quiz Submission Modal -->
<div class="modal fade" id="quizSubmittedModal" tabindex="-1" aria-labelledby="quizSubmittedModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quizSubmittedModalLabel">Quiz Submitted</h5>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/web/quiz/singlePage.js') }}" defer type="module"></script>

<style>
    /* Base Styles */
    .quiz-experience-container {
        display: flex;
        flex-direction: column;
        /* min-height: 100vh; */
        color: var(--bs-body-color);
        padding-top: 0;
        margin-top: 0;
    }

    /* Quiz Control Bar */
    .quiz-control-bar {
        position: fixed;
        top: 70px;
        /* Adjusted to avoid overlap with main navbar */
        left: 0;
        right: 0;
        z-index: 999;
        /* Lower than main navbar */
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    [data-bs-theme="dark"] .quiz-control-bar {
        background: #1e1e1e;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .quiz-timer {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .timer-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F77E15;
        border-radius: 50%;
        color: white;
        font-size: 22px;
    }

    .timer-display {
        display: flex;
        flex-direction: column;
    }

    .timer-label {
        font-size: 14px;
        color: var(--bs-secondary-color);
        margin-bottom: 2px;
    }

    .timer-countdown {
        font-size: 24px;
        font-weight: 700;
        color: #F77E15;
    }

    .quiz-progress {
        flex: 1;
        max-width: 300px;
        margin: 0 30px;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        font-size: 14px;
        color: var(--bs-secondary-color);
    }

    .progress {
        height: 6px;
        background: var(--bs-secondary-bg);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar {
        background: #F77E15;
        transition: width 0.3s ease;
    }


    /* Quiz Content */
    .quiz-content {
        flex: 1;
        padding: 150px 30px 30px;
        /* Increased top padding to account for both navbars */
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    .swal2-container .swal2-html-container {
        max-height: 500px !important;
    }

    .quiz-meta-bar {
        display: flex;
        gap: 30px;
        margin-bottom: 20px;
        padding: 15px 20px;
        background: var(--bs-tertiary-bg);
        border-radius: 10px;
        justify-content: center;
        border: 1px solid var(--bs-border-color);
    }

    [data-bs-theme="dark"] .quiz-meta-bar {
        background: #1e1e1e;
    }

    .quiz-meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
    }

    .question-type-badge-icon {
        color: #F77E15 !important;
    }

    .quiz-meta-item i {
        color: #F77E15;
        font-size: 18px;
    }

    /* Questions Container */
    .questions-container {
        position: relative;
        min-height: 500px;
        margin-bottom: 30px;
    }

    .question-card {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        background: var(--bs-body-bg);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        display: none;
        flex-direction: column;
        border: 1px solid var(--bs-border-color);
        overflow: hidden;
    }

    [data-bs-theme="dark"] .question-card {
        background: #1a1a1a;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .question-sidebar {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 8px;
        background: #F77E15;
    }

    .question-content {
        padding: 30px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .question-number {
        font-size: 18px;
        font-weight: 600;
        color: #F77E15;
    }

    .question-type-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        background: rgba(247, 126, 21, 0.1);
        border-radius: 50px;
        font-size: 14px;
        color: #F77E15;
    }

    .question-text {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 30px;
        line-height: 1.4;
    }

    /* Answers Container */
    .answers-container {
        flex: 1;
        margin-bottom: 30px;
    }

    .answers-container.grid-layout {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .answers-container.list-layout {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .answer-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: var(--bs-tertiary-bg);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        height: 100px;

    }

    [data-bs-theme="dark"] .answer-card {
        background: #2a2a2a;
    }

    .answer-card:hover {
        background: linear-gradient(135deg, #F77E15, #ff4d4d);
        border-color: rgba(247, 126, 21, 0.3);
    }

    .answer-radio {
        width: 24px;
        height: 24px;
        flex-shrink: 0;
    }

    .radio-outer {
        width: 24px;
        height: 24px;
        border: 2px solid var(--bs-secondary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .radio-inner {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: transparent;
        transition: all 0.3s ease;
    }

    .answer-card.selected {
        background: linear-gradient(135deg, #F77E15, #ff4d4d);
        border-color: transparent;
        color: white;
    }

    .answer-card.selected .radio-outer {
        border-color: white;
    }

    .answer-card.selected .radio-inner {
        background: white;
    }

    .answer-text {
        font-size: 16px;
        line-height: 1.5;
        flex: 1;
    }

    /* Question Footer */
    .question-footer {
        margin-top: auto;
    }

    .question-navigation {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }

    .nav-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--bs-tertiary-bg);
        border: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        color: var(--bs-body-color);
    }

    [data-bs-theme="dark"] .nav-btn {
        background: #2a2a2a;
        color: #ccc;
    }

    .nav-btn:hover {
        background: var(--bs-secondary-bg);
        color: #F77E15;
    }

    [data-bs-theme="dark"] .nav-btn:hover {
        background: #333;
    }

    .next-btn {
        background: rgba(247, 126, 21, 0.2);
        color: #F77E15;
    }

    .next-btn:hover {
        background: rgba(247, 126, 21, 0.3);
    }

    /* Quiz Navigation */
    .quiz-navigation {
        margin-top: 30px;
    }

    .question-map {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .map-item {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--bs-tertiary-bg);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--bs-body-color);
    }

    [data-bs-theme="dark"] .map-item {
        background: #2a2a2a;
        color: #ccc;
    }

    .map-item:hover {
        background: var(--bs-secondary-bg);
        color: #F77E15;
    }

    [data-bs-theme="dark"] .map-item:hover {
        background: #333;
    }

    .map-item.active {
        background: #F77E15;
        color: white;
    }

    .map-item.answered {
        background: rgba(247, 126, 21, 0.2);
        color: #F77E15;
    }

    .map-item.active.answered {
        background: #F77E15;
        color: white;
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        .quiz-progress {
            display: none;
        }
    }

    @media (max-width: 767.98px) {
        .quiz-content {
            padding: 140px 15px 20px;
        }

        .quiz-meta-bar {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .question-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .question-text {
            font-size: 20px;
        }

        .answers-container.grid-layout {
            grid-template-columns: 1fr;
        }

        .question-navigation {
            width: 100%;
            justify-content: space-between;
        }
    }

    /* SweetAlert Custom Styling */
    .quiz-submit-modal {
        border-radius: 12px !important;
        max-width: 400px !important;
        background-color: var(--bs-body-bg) !important;
        overflow: hidden !important;
    }

    .no-scroll-container {
        overflow: hidden !important;
        padding-bottom: 0 !important;
    }

    .question-icon-circle {
        width: 60px;
        height: 60px;
        background-color: #F77E15;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .question-icon-circle i {
        font-size: 30px;
        color: white;
    }

    .stat-box {
        width: 90px;
        height: 90px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .stat-box.answered {
        background-color: #28a74520;
    }

    .stat-box.unanswered {
        background-color: #dc354520;
    }

    .stat-icon {
        font-size: 22px;
        margin-bottom: 5px;
    }

    .stat-box.answered .stat-icon {
        color: #28a745;
    }

    .stat-box.unanswered .stat-icon {
        color: #dc3545;
    }

    .stat-value {
        font-size: 28px;
        font-weight: bold;
    }

    .stat-box.answered .stat-value {
        color: #28a745;
    }

    .stat-box.unanswered .stat-value {
        color: #dc3545;
    }

    [data-bs-theme="dark"] .stat-box.answered {
        background-color: #28a74530;
    }

    [data-bs-theme="dark"] .stat-box.unanswered {
        background-color: #dc354530;
    }

    /* Override SweetAlert scrollbar */
    .swal2-html-container::-webkit-scrollbar {
        display: none !important;
    }

    .swal2-html-container {
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }

    .swal2-title {
        margin-bottom: 0.5em !important;
        padding: 0.5em 1em 0 !important;
    }

    .swal2-actions {
        margin-top: 1em !important;
    }

    /* Cool SweetAlert Styling */
    .cool-submit-popup {
        border-radius: 20px !important;
        max-width: 400px !important;
        background-color: var(--bs-body-bg) !important;
        overflow: hidden !important;
        padding: 1.5rem !important;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15) !important;
    }

    [data-bs-theme="dark"] .cool-submit-popup {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3) !important;
    }

    .cool-submit-title {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: var(--bs-heading-color) !important;
        margin-bottom: 1rem !important;
    }

    .cool-submit-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
        padding: 0 !important;
    }

    .progress-ring-container {
        position: relative;
        width: 150px;
        height: 150px;
    }

    .progress-ring {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .progress-ring-svg {
        transform: rotate(-90deg);
        width: 100%;
        height: 100%;
    }

    .progress-ring-circle-bg {
        fill: none;
        stroke: rgba(247, 126, 21, 0.1);
        stroke-width: 8;
    }

    [data-bs-theme="dark"] .progress-ring-circle-bg {
        stroke: rgba(247, 126, 21, 0.2);
    }

    .progress-ring-circle {
        fill: none;
        stroke-width: 8;
        stroke-linecap: round;
        stroke-dasharray: 314;
        transition: stroke 0.5s ease, stroke-dashoffset 0.5s ease;
    }

    .progress-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .progress-percentage {
        font-size: 2.5rem;
        font-weight: 700;
        color: #F77E15;
        line-height: 1;
        transition: color 0.5s ease;
    }

    .progress-label {
        font-size: 0.9rem;
        color: var(--bs-secondary-color);
        margin-top: 0.25rem;
    }

    .stats-container {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        background: var(--bs-tertiary-bg);
        border-radius: 15px;
        padding: 1rem;
    }

    .stat-item {
        flex: 1;
        text-align: center;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--bs-secondary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }

    .stat-divider {
        width: 1px;
        height: 40px;
        background-color: var(--bs-border-color);
        margin: 0 1rem;
    }

    .stat-item:first-child .stat-value {
        color: #28a745;
    }

    .stat-item:first-child .stat-label i {
        color: #28a745;
    }

    .stat-item:last-child .stat-value {
        color: #dc3545;
    }

    .stat-item:last-child .stat-label i {
        color: #dc3545;
    }

    .no-scroll-container {
        overflow: hidden !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Override SweetAlert scrollbar */
    .swal2-html-container::-webkit-scrollbar {
        display: none !important;
    }

    .swal2-html-container {
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }

    .swal2-actions {
        margin-top: 1.5rem !important;
    }

    /* Add this to your existing cool-submit styles */

    .warning-message {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        background-color: rgba(255, 193, 7, 0.1);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 0.5rem;
        width: 100%;
        text-align: left;
    }

    [data-bs-theme="dark"] .warning-message {
        background-color: rgba(255, 193, 7, 0.15);
    }

    .warning-icon {
        color: #ffc107;
        font-size: 1.25rem;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .warning-message p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--bs-body-color);
        line-height: 1.4;
    }

    /* Add these styles for the completed state */
    .progress-ring-circle {
        fill: none;
        stroke-width: 8;
        stroke-linecap: round;
        stroke-dasharray: 314;
        transition: stroke 0.5s ease, stroke-dashoffset 0.5s ease;
    }

    .progress-percentage {
        transition: color 0.5s ease;
    }

    /* Add these styles for the improved quiz submission modal */
    #quizSubmittedModal .modal-content {
        border-radius: 15px;
        border: none;
        overflow: hidden;
    }

    #quizSubmittedModal .modal-dialog {
        max-width: 500px;
    }

    #quizSubmittedModal .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--bs-heading-color);
    }

    .result-animation {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem 0;
    }

    .result-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        animation: scaleIn 0.5s ease-out;
    }

    .result-icon.success {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .result-icon.fail {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }

        70% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .result-summary {
        margin-bottom: 1.5rem;
    }

    .score-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
    }

    .score-circle {
        width: 120px;
        height: 120px;
        position: relative;
        flex-shrink: 0;
    }

    .score-circle svg {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .score-text-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1;
    }

    .score-text-overlay span {
        font-size: 1.2rem;
        margin-left: 2px;
    }

    .score-circle-bg {
        stroke: rgba(255, 255, 255, 0.1);
    }

    .score-circle-fill {
        stroke-linecap: round;
        transition: stroke-dasharray 1.5s ease;
    }

    .score-circle-fill.success {
        stroke: #28a745;
    }

    .score-circle-fill.failure {
        stroke: #dc3545;
    }

    .score-text {
        font-size: 10px;
        font-weight: 700;
        fill: #ffffff;
        text-anchor: middle;
        dominant-baseline: middle;
    }

    .score-info {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .passing-info {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .status-info {
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .status-info.passed {
        color: #28a745;
    }

    .status-info.failed {
        color: #dc3545;
    }

    .questions-info {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .question-summary {
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .summary-heading {
        font-size: 1.1rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 1.25rem;
    }

    .questions-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .question-indicator {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
        color: #ffffff;
        transition: transform 0.2s ease;
    }

    .question-indicator:hover {
        transform: translateY(-3px);
    }

    .question-indicator.answered {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .question-indicator.unanswered {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1));
        border: 1px solid rgba(220, 53, 69, 0.3);
    }

    .question-number {
        font-size: 1.1rem;
    }

    .question-status {
        position: absolute;
        bottom: 5px;
        right: 5px;
        font-size: 0.7rem;
    }

    .question-indicator.answered .question-status {
        color: #28a745;
    }

    .question-indicator.unanswered .question-status {
        color: #dc3545;
    }

    .questions-answered-summary {
        text-align: center;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 1rem;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .action-btn {
        padding: 0.85rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .action-btn.primary {
        background: linear-gradient(135deg, #F77E15, #ff6a00);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(247, 126, 21, 0.3);
    }

    .action-btn.primary:hover {
        background: linear-gradient(135deg, #ff6a00, #F77E15);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(247, 126, 21, 0.4);
    }

    .action-btn.secondary {
        background-color: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .action-btn.secondary:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    @media (max-width: 576px) {
        .elegant-modal-body {
            padding: 1.5rem !important;
        }

        .result-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .score-display {
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }

        .score-info {
            text-align: center;
        }

        .questions-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Perfect Quiz Result Modal Styling */
    #quizSubmittedModal.perfect-theme-modal .modal-dialog {
        max-width: 450px;
    }

    #quizSubmittedModal.perfect-theme-modal .modal-content {
        background-color: #1a1a1a;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .quiz-result-modal {
        padding: 30px !important;
    }

    .quiz-result-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.5rem;
        text-align: left;
    }

    .redirect-timer-container {
        display: inline-block;
        background-color: #222;
        color: #aaa;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        margin-bottom: 1.5rem;
    }

    #redirectTimer {
        color: #F77E15;
        font-weight: 700;
    }

    .score-container {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .score-circle-container {
        flex-shrink: 0;
    }

    .score-circle {
        width: 120px;
        height: 120px;
        position: relative;
    }

    .score-circle svg {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .score-circle-bg {
        stroke: #333;
    }

    .score-circle-fill {
        stroke-linecap: round;
        transition: stroke-dasharray 1.5s ease;
    }

    .score-circle-fill.success {
        stroke: #28a745;
    }

    .score-circle-fill.failure {
        stroke: #dc3545;
    }

    .score-percentage {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.25rem;
        font-weight: 700;
        color: #ffffff;
    }

    .score-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .passing-score {
        font-size: 1rem;
        color: #ffffff;
    }

    .result-status {
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .result-status.passed {
        color: #28a745;
    }

    .result-status.failed {
        color: #dc3545;
    }

    .questions-count {
        font-size: 0.9rem;
        color: #aaa;
    }

    .questions-summary-panel {
        background-color: #222;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .summary-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    .questions-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .question-box {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
        color: #ffffff;
    }

    .question-box.answered {
        background-color: rgba(40, 167, 69, 0.2);
    }

    .question-box.unanswered {
        background-color: rgba(220, 53, 69, 0.2);
    }

    .question-status-icon {
        position: absolute;
        bottom: 3px;
        right: 3px;
        font-size: 0.7rem;
    }

    .question-box.answered .question-status-icon {
        color: #28a745;
    }

    .question-box.unanswered .question-status-icon {
        color: #dc3545;
    }

    .questions-summary-count {
        text-align: center;
        font-size: 0.9rem;
        color: #aaa;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .view-results-btn,
    .back-to-quizzes-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
    }

    .view-results-btn {
        background-color: #F77E15;
        color: #ffffff;
    }

    .view-results-btn:hover {
        background-color: #e67000;
    }

    .back-to-quizzes-btn {
        background-color: transparent;
        color: #aaa;
        border: 1px solid #333;
    }

    .back-to-quizzes-btn:hover {
        background-color: rgba(255, 255, 255, 0.05);
        color: #ffffff;
    }

    @media (max-width: 576px) {
        .score-container {
            flex-direction: column;
            align-items: center;
        }

        .score-details {
            text-align: center;
        }

        .questions-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .action-buttons {
            flex-direction: column;
        }

        .view-results-btn,
        .back-to-quizzes-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
