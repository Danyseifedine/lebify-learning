import { LOCAL_URL } from '../../../core/global/config/app-config.js';
import { DynamicContentManager } from '../../../core/global/advanced/advanced.js';
import { filterLoading, getFiltersFromURL } from '../../../core/js/app.js';
import { initializePerformanceDistributionChart } from '../charts/index.js';



export const dynamicContentManager = () => new DynamicContentManager({
    contentSection: '.quizzes-section',
    filterForm: '#filterForm',
    searchBtn: '#filterButton',
    route: `${LOCAL_URL}/quizzes/filter`,
    clearFilterBtn: '#clearFilterButton',
    toggleSubmitButtonOnFormInput: true,
    config: {
        initialLoad: true
    },

    cacheOptions: {
        enabled: true,
        maxEntries: 100,
        maxAge: 300000,
    },
    callbacks: {
        onLoading: (section) => {
            section.innerHTML = filterLoading();
        },

        onSuccess: (response) => {
            updateActiveFilters(getFiltersFromURL());
            initializePerformanceDistributionChart();
        },
        onCacheHit: () => {
            updateActiveFilters(getFiltersFromURL());
            initializePerformanceDistributionChart();
        }
    },
});
function initBannerAnimations() {
    gsap.to('.quiz-banner', {
        opacity: 1,
        duration: 0.5,
        ease: 'power2.out'
    });

    gsap.to('.banner-element', {
        opacity: 1,
        y: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power2.out'
    });

    gsap.to('.banner-illustration', {
        opacity: 1,
        x: 0,
        duration: 1,
        delay: 0.5,
        ease: 'power2.out'
    });
}
function updateActiveFilters(filters) {
    const activeFiltersContainer = document.querySelector('.active-filters');

    // Clear existing filters
    activeFiltersContainer.innerHTML = '';

    // Check if we have any active filters
    const hasActiveFilters = Object.values(filters).some(value => value && value !== '');

    if (hasActiveFilters) {
        Object.entries(filters).forEach(([key, value]) => {
            if (value && value !== '') {
                const filterLabel = getFilterLabel(key, value);
                const tag = document.createElement('div');
                tag.className = 'active-filter-tag';
                tag.textContent = filterLabel;
                activeFiltersContainer.appendChild(tag);
            }
        });
    }
}
function getFilterLabel(key, value) {
    const labels = {
        name: `Search: "${value}"`,
        difficulty_level: `Difficulty: ${getDifficultyLabel(value)}`,
        duration: `Duration: ${getDurationLabel(value)}`
    };
    return labels[key] || `${key}: ${value}`;
}
function getDifficultyLabel(value) {
    const levels = {
        '1': 'Beginner',
        '2': 'Elementary',
        '3': 'Intermediate',
        '4': 'Advanced',
        '5': 'Expert'
    };
    return levels[value] || value;
}
function getDurationLabel(value) {
    const durations = {
        '10': '10 Min',
        '5': '5 Min',
        '2': '2 Min',
        '1': '1 Min'
    };
    return durations[value] || value;
}
function initQuizGuideModal() {
    const modal = document.getElementById('quizGuideModal');
    if (!modal) return;

    const steps = modal.querySelectorAll('.step');
    const stepDots = modal.querySelectorAll('.step-dot');
    const prevBtn = modal.querySelector('.prev-step');
    const nextBtn = modal.querySelector('.next-step');
    const progressBar = modal.querySelector('.progress-bar');
    const currentStepSpan = modal.querySelector('.current-step');
    const rulesAgreement = modal.querySelector('#rulesAgreement');
    let currentStep = 1;

    function showStep(stepNumber) {
        // Hide all steps first
        steps.forEach(step => {
            step.classList.remove('active');
            step.style.display = 'none';
        });

        // Show the current step
        const currentStepEl = steps[stepNumber - 1]; // Use array index instead of querySelector
        if (currentStepEl) {
            currentStepEl.style.display = 'block';
            // Force a reflow
            currentStepEl.offsetHeight;
            currentStepEl.classList.add('active');
        }

        // Update progress bar
        const progress = (stepNumber / steps.length) * 100;
        progressBar.style.width = `${progress}%`;

        // Update step dots
        stepDots.forEach((dot, index) => {
            dot.classList.toggle('active', index + 1 <= stepNumber);
        });

        // Update current step number
        currentStepSpan.textContent = stepNumber;

        // Update button visibility
        prevBtn.classList.toggle('d-none', stepNumber === 1);
        nextBtn.classList.toggle('d-none', stepNumber === steps.length);

    }

    // Initialize the modal when it's about to be shown
    modal.addEventListener('show.bs.modal', () => {
        currentStep = 1;
        // Wait for modal to be fully visible
        setTimeout(() => {
            showStep(1);
        }, 150);
    });

    // Handle step navigation with dots
    stepDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentStep = index + 1;
            showStep(currentStep);
        });
    });

    // Handle next button click
    nextBtn.addEventListener('click', () => {
        if (currentStep < steps.length) {
            currentStep++;
            showStep(currentStep);
        }
    });

    // Handle previous button click
    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Handle rules agreement checkbox
    rulesAgreement?.addEventListener('change', () => {
        finishBtn.disabled = !rulesAgreement.checked;
    });

    // Handle selectable cards
    const selectableCards = modal.querySelectorAll('.selectable');
    selectableCards.forEach(card => {
        card.addEventListener('click', () => {
            const parent = card.closest('.difficulty-cards, .duration-cards');
            if (parent) {
                parent.querySelectorAll('.selectable').forEach(sibling => {
                    sibling.classList.remove('selected');
                });
            }
            card.classList.add('selected');
        });
    });

    // Reset modal when hidden
    modal.addEventListener('hidden.bs.modal', () => {
        currentStep = 1;
        steps.forEach(step => {
            step.classList.remove('active');
            step.style.display = 'none';
        });
        selectableCards.forEach(card => card.classList.remove('selected'));
        if (rulesAgreement) rulesAgreement.checked = false;
    });

    // Show first step immediately
    showStep(1);
}

document.addEventListener('DOMContentLoaded', function () {
    initQuizGuideModal();
    initBannerAnimations();

    const filterDrawer = document.getElementById('filterDrawer');
    const overlay = document.querySelector('.filter-overlay-quiz');

    // Show overlay when drawer opens
    filterDrawer.addEventListener('show.bs.collapse', function () {
        overlay.classList.add('show');
    });

    // Hide overlay when drawer closes
    filterDrawer.addEventListener('hide.bs.collapse', function () {
        overlay.classList.remove('show');
    });

    // Close drawer when clicking overlay
    overlay.addEventListener('click', function () {
        const bsCollapse = new bootstrap.Collapse(filterDrawer);
        bsCollapse.hide();
    });
});
