import { SimpleWatcher, LoadingBar } from '../../../core/global/advanced/advanced.js';
import { urlEndsWith, redirectTo, urlIncludes, findUrlPartAfter, redirectToWithReload } from '../../../core/global/utils/functions.js';
import { BASE_URL, LOCAL_URL } from '../../../core/global/config/app-config.js';
import { CountdownTimer } from '../../../core/global/advanced/advanced.js';
import { dynamicContentManager } from './index.js';

const pageContent = document.querySelector('.page-content');

let quizDuration = 0;



function initializeQuiz() {
    // Get DOM elements
    const questions = document.querySelectorAll('.question-card');
    const mapItems = document.querySelectorAll('.map-item');
    const totalQuestions = questions.length;
    const progressBar = document.querySelector('.progress-bar');
    const currentQuestionSpan = document.querySelector('.current-question');
    const totalQuestionsSpan = document.querySelector('.total-questions');

    // Initialize quiz storage
    const quizStorage = new QuizStorage();

    // Set initial state
    let currentQuestion = 1;

    // Set total questions count
    totalQuestionsSpan.textContent = totalQuestions;

    // Initialize event listeners
    setupEventListeners();

    // Show first question
    updateActiveQuestion(1);

    // Load any saved answers
    loadSavedAnswers();

    // Setup all event listeners
    function setupEventListeners() {
        // Map item click handler
        mapItems.forEach(item => {
            item.addEventListener('click', () => {
                const targetQuestion = parseInt(item.dataset.target);
                updateActiveQuestion(targetQuestion);
            });
        });

        // Next/Prev button handlers
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetQuestion = parseInt(btn.dataset.target);
                updateActiveQuestion(targetQuestion);
            });
        });

        // Answer selection handler
        document.querySelectorAll('.answer-card').forEach(card => {
            card.addEventListener('click', () => {
                handleAnswerSelection(card);
            });
        });

        // Submit quiz button handler
        document.querySelector('.finish-quiz-btn')?.addEventListener('click', () => {
            const totalQuestions = document.querySelectorAll('.question-card').length;
            const answeredQuestions = quizStorage.getAnswers().length;
            const percentage = Math.round((answeredQuestions / totalQuestions) * 100);

            // Calculate the gradient color based on percentage
            const gradientColor = getGradientColor(percentage);

            Swal.fire({
                title: 'Ready to Submit?',
                html: `
                    <div class="cool-submit-container">
                        <div class="progress-ring-container">
                            <div class="progress-ring">
                                <svg viewBox="0 0 120 120" class="progress-ring-svg">
                                    <circle class="progress-ring-circle-bg" cx="60" cy="60" r="50"></circle>
                                    <circle class="progress-ring-circle" cx="60" cy="60" r="50"
                                        style="stroke: ${gradientColor}; stroke-dashoffset: ${314 - (percentage * 314 / 100)}"></circle>
                                </svg>
                                <div class="progress-content">
                                    <div class="progress-percentage" style="color: ${gradientColor}">${percentage}%</div>
                                    <div class="progress-label">Completed</div>
                                </div>
                            </div>
                        </div>

                        <div class="warning-message">
                            <i class="bi bi-exclamation-triangle-fill warning-icon"></i>
                            <p>This action cannot be undone. Once submitted, you won't be able to change your answers.</p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Submit Quiz',
                cancelButtonText: 'Continue',
                customClass: {
                    popup: 'cool-submit-popup',
                    confirmButton: 'btn bg-logo text-white rounded-pill px-4 py-2',
                    cancelButton: 'btn btn-outline-secondary rounded-pill px-4 py-2',
                    htmlContainer: 'no-scroll-container',
                    title: 'cool-submit-title'
                },
                buttonsStyling: false,
                background: 'var(--bs-body-bg)',
                color: 'var(--bs-body-color)'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitQuiz(quizStorage.getAnswers(), 'completed');
                }
            });
        });
    }

    // Function to get a gradient color based on percentage
    function getGradientColor(percentage) {
        // Start with orange (#F77E15) and gradually transition to green (#28a745)
        if (percentage <= 25) {
            // 0-25%: Stay orange
            return '#F77E15';
        } else if (percentage <= 50) {
            // 25-50%: Orange to yellow-orange
            return '#F7A015';
        } else if (percentage <= 75) {
            // 50-75%: Yellow-orange to yellow-green
            return '#B4C12A';
        } else {
            // 75-100%: Yellow-green to green
            const greenIntensity = Math.min(100, percentage);
            const red = Math.round(40 + (247 - 40) * (100 - greenIntensity) / 25);
            const green = Math.round(167 + (126 - 167) * (100 - greenIntensity) / 25);
            const blue = Math.round(69 + (21 - 69) * (100 - greenIntensity) / 25);
            return `rgb(${red}, ${green}, ${blue})`;
        }
    }

    // Handle answer selection
    function handleAnswerSelection(card) {
        const questionCard = card.closest('.question-card');
        const questionId = questionCard.dataset.questionId;
        const answerId = card.dataset.answerId;
        const questionType = questionCard.dataset.type;
        const questionIndex = parseInt(questionCard.dataset.index);

        if (questionType === 'multiple_choice' || questionType === 'true_false') {
            // Single selection for multiple choice and true/false
            questionCard.querySelectorAll('.answer-card').forEach(c => {
                c.classList.remove('selected');
            });
            card.classList.add('selected');

            // Store the answer
            quizStorage.addAnswer(questionId, answerId, questionType);
        } else {
            // Toggle selection for other types
            card.classList.toggle('selected');

            // Store or remove the answer
            if (card.classList.contains('selected')) {
                quizStorage.addAnswer(questionId, answerId, questionType);
            } else {
                quizStorage.removeAnswer(questionId, answerId);
            }
        }

        // Mark question as answered in the map
        const mapItem = document.querySelector(
            `.map-item[data-target="${questionIndex}"]`);
        if (mapItem) {
            mapItem.classList.add('answered');
        }
    }

    // Update active question
    function updateActiveQuestion(index) {
        // Hide all questions
        questions.forEach(q => {
            q.style.display = 'none';
        });

        // Show target question
        const targetQuestion = document.querySelector(`.question-card[data-index="${index}"]`);
        if (targetQuestion) {
            targetQuestion.style.display = 'block';

            // Smooth scroll to question
            targetQuestion.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            // Update current question
            currentQuestion = index;
            currentQuestionSpan.textContent = currentQuestion;

            // Update progress bar
            const progress = (currentQuestion / totalQuestions) * 100;
            progressBar.style.width = `${progress}%`;

            // Update map items
            mapItems.forEach(item => {
                const itemIndex = parseInt(item.dataset.target);
                item.classList.toggle('active', itemIndex === currentQuestion);
            });
        }
    }

    // Load saved answers
    function loadSavedAnswers() {
        const savedAnswers = quizStorage.getAnswers();

        savedAnswers.forEach(answer => {
            const questionCard = document.querySelector(`[data-question-id="${answer.question_id}"]`);
            if (questionCard) {
                const answerCard = questionCard.querySelector(`[data-answer-id="${answer.answer_id}"]`);
                if (answerCard) {
                    answerCard.classList.add('selected');
                }
            }
        });
    }

    // Initialize timer
    const timer = new CountdownTimer({
        duration: {
            minutes: quizDuration,
        },
        callbacks: [{
            time: 60,
            callback: () => {
            }
        }],
        elementId: 'timer',
        storageKey: 'quizTimeRemaining',
        onFinish: () => {
            submitQuiz(quizStorage.getAnswers(), 'timeout');
        }
    });

    timer.start();
}

// Quiz Storage class
class QuizStorage {
    constructor() {
        this.answers = this.loadAnswers();
    }

    loadAnswers() {
        try {
            const stored = sessionStorage.getItem('quizAnswers');
            const parsed = stored ? JSON.parse(stored) : [];
            return Array.isArray(parsed) ? parsed : [];
        } catch (e) {
            console.error('Error loading answers:', e);
            return [];
        }
    }

    saveAnswers() {
        try {
            sessionStorage.setItem('quizAnswers', JSON.stringify(this.answers));
        } catch (e) {
            console.error('Error saving answers:', e);
        }
    }

    addAnswer(questionId, answerId, type) {
        // Remove existing answer for single choice questions
        if (type === 'multiple_choice' || type === 'true_false') {
            this.answers = this.answers.filter(answer => answer.question_id !== questionId);
        }

        this.answers.push({
            question_id: questionId,
            answer_id: answerId,
            type: type
        });

        this.saveAnswers();
    }

    removeAnswer(questionId, answerId = null) {
        if (answerId) {
            // Remove specific answer (for multiple answers)
            this.answers = this.answers.filter(answer =>
                !(answer.question_id === questionId && answer.answer_id === answerId)
            );
        } else {
            // Remove all answers for this question
            this.answers = this.answers.filter(answer => answer.question_id !== questionId);
        }
        this.saveAnswers();
    }

    getAnswers() {
        return this.answers;
    }

    clear() {
        this.answers = [];
        sessionStorage.removeItem('quizAnswers');
    }
}

// Update the submitQuiz function with a perfectly designed modal
async function submitQuiz(answers, status) {
    try {
        const quizId = findUrlPartAfter('quizzes');
        const attemptId = findUrlPartAfter('attempt');

        const response = await axios.post(`${LOCAL_URL}/quizzes/${quizId}/attempt/${attemptId}/submit`, {
            responses: answers,
            status: status
        });

        if (response.data.success) {
            // Clear quiz-specific storage items
            sessionStorage.removeItem('quizAnswers');
            sessionStorage.removeItem('quizTimeRemaining');
            localStorage.removeItem('redirectTimer');

            // Get quiz data
            const questions = document.querySelectorAll('.question-card');
            const score = response.data.score || 0;
            const isPassed = response.data.isPassed || false;
            const passingScore = response.data.passingScore || 70;

            // Count answered questions
            const answeredCount = answers.length;
            const totalQuestions = questions.length;

            // Create the modal content with perfect design
            let modalContent = `
                <div class="modal-body quiz-result-modal">
                    <div class="quiz-result-header d-flex justify-content-between">
                        <h2 class="quiz-result-title">Quiz Completed</h2>

                    <div class="redirect-timer-container">
                            Redirecting in <span id="redirectTimer">01:00</span>
                        </div>
                    </div>
                    <div class="score-container">
                        <div class="score-circle-container">
                            <div class="score-circle">
                                <svg viewBox="0 0 36 36">
                                    <path class="score-circle-bg"
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke-width="3" stroke-dasharray="100, 100"/>
                                    <path class="score-circle-fill ${isPassed ? 'success' : 'failure'}"
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke-width="3" stroke-dasharray="${score}, 100"/>
                                </svg>
                                <div class="score-percentage">${score}%</div>
                            </div>
                        </div>

                        <div class="score-details">
                            <div class="passing-score">Passing Score: ${passingScore}%</div>
                            <div class="result-status ${isPassed ? 'passed' : 'failed'}">${isPassed ? 'PASSED' : 'FAILED'}</div>
                        </div>
                    </div>

                    <div class="questions-summary-panel">
                        <h3 class="summary-title">Questions Answered</h3>

                        <div class="questions-grid">`;

            // Add question indicators
            questions.forEach((question, index) => {
                const questionId = question.dataset.questionId;
                const isAnswered = answers.some(answer => answer.question_id === questionId);

                modalContent += `
                    <div class="question-box ${isAnswered ? 'answered' : 'unanswered'}">
                        <span class="question-number">${index + 1}</span>
                        <span class="question-status-icon">
                            <i class="bi ${isAnswered ? 'bi-check' : 'bi-x'}"></i>
                        </span>
                    </div>`;
            });

            modalContent += `
                        </div>

                        <div class="questions-summary-count">
                            ${answeredCount} of ${totalQuestions} questions answered
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="view-results-btn" onclick="window.location.href='${BASE_URL}/student/profile?tab-group-id=quizzes'">
                            <i class="bi bi-bar-chart-fill"></i> View Results
                        </button>
                        <button class="back-to-quizzes-btn" onclick="window.location.href='${BASE_URL}/quizzes'">
                            <i class="bi bi-grid"></i> Back to Quizzes
                        </button>
                    </div>
                </div>
            `;

            // Update modal content
            const modalEl = document.getElementById('quizSubmittedModal');
            modalEl.querySelector('.modal-content').innerHTML = modalContent;

            // Add perfect theme class to modal
            modalEl.classList.add('perfect-theme-modal');

            // Update the redirect timer
            const redirectTimer = new CountdownTimer({
                duration: {
                    minutes: 1,
                    seconds: 0
                },
                onFinish: () => {
                    redirectToWithReload(`${BASE_URL}/student/profile?tab-group-id=quizzes`);
                    localStorage.removeItem('redirectTimer');
                },
                elementId: 'redirectTimer',
                storageKey: 'redirectTimer',
                format: 'mm:ss'
            });

            redirectTimer.start();

            // Show the modal
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    } catch (error) {
        console.error('Error submitting quiz:', error);
        Swal.fire({
            title: 'Error!',
            text: 'Failed to submit quiz. Please try again.',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-danger px-4 rounded-pill'
            },
            buttonsStyling: false
        });
    }
}

const attachQuizLinkListeners = () => {
    const quizLinks = document.querySelectorAll('.quiz-link');
    quizLinks.forEach(link => {
        link.addEventListener('click', async (e) => {
            e.preventDefault();

            const loadingBar = new LoadingBar({
                colors: ['#FFA500', '#FF8C00'],
                height: '3px',
                maxWidth: 90,
                animationSpeed: 2000,
                position: 'top'
            }).start();

            try {
                const quizId = link.dataset.quizId;
                redirectTo(`/quizzes/${quizId}`);
                const response = await axios.get(`${LOCAL_URL}/quizzes/${quizId}/details`);
                loadingBar.complete();
                setTimeout(() => {
                    pageContent.innerHTML = response.data.html;
                }, 400);

                // Scroll to top AFTER content is loaded
                window.scrollTo({ top: 0, behavior: 'auto' });
            } catch (error) {
                loadingBar.error();
            }
        });
    });
};

new SimpleWatcher({
    targetSelector: 'body',
    watchFor: '.quiz-link',
    onElementFound: () => {
        attachQuizLinkListeners();
    },
});

if (urlEndsWith('/quizzes')) {
    dynamicContentManager();
}

export function startQuiz(btn) {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        const loadingBar = new LoadingBar({
            colors: ['#FFA500', '#FF8C00'],
            height: '3px',
            maxWidth: 90,
            animationSpeed: 2000,
            position: 'top'
        }).start();
        try {
            const quizId = btn.dataset.quizId;
            const response = await axios.get(`${LOCAL_URL}/quizzes/${quizId}/start`);
            loadingBar.complete();

            quizDuration = response.data.quiz;
            console.log(quizDuration)

            if (response.data.success) {
                const modal = document.querySelector('#start-quiz-modal');
                const modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();

                // Only clear quiz-specific storage
                localStorage.removeItem('quizTimeRemaining');
                // Don't clear theme or other important settings

                if (response.data.redirectUrl) {
                    redirectTo(response.data.redirectUrl);
                }

                pageContent.innerHTML = response.data.html;
                initializeQuiz();
            }
        } catch (error) {
            loadingBar.error();
        }
    });
}

new SimpleWatcher({
    targetSelector: 'body',
    watchFor: '.start-quiz-btn',
    onElementFound: () => {
        startQuiz(document.querySelector('.start-quiz-btn'));
    },
});


new SimpleWatcher({
    targetSelector: 'body',
    watchFor: '.finish-quiz-btn',
    onElementFound: () => {
        initializeQuiz();
    },
});

if (urlIncludes('/attempt')) {
    initializeQuiz();
}

if (!urlIncludes('/attempt')) {
    // Only clear quiz-specific session storage items
    sessionStorage.removeItem('quizAnswers');
    sessionStorage.removeItem('quizTimeRemaining');
    // Don't clear localStorage entirely
}
