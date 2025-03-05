import { DynamicContentManager } from "../../../core/global/advanced/advanced.js";
import { LOCAL_URL } from "../../../core/global/config/app-config.js";
import { filterLoading, getFiltersFromURL } from "../../../core/js/app.js";



// Wait for DOM to be fully loaded
const commonConfig = {
    cacheOptions: {
        enabled: true,
        maxEntries: 5,
        maxAge: 300000,
    },
    callbacks: {
        onLoading: (section) => {
            section.innerHTML = filterLoading();
        },
        onClearFilters: () => {
            // Clear active filters immediately
            const activeFiltersContainer = document.querySelector('.active-filters');
            if (activeFiltersContainer) {
                activeFiltersContainer.innerHTML = '';
            }
        },
        onSuccess: (response) => {
            updateActiveFilters(getFiltersFromURL());
        },
        onCacheHit: () => {
            updateActiveFilters(getFiltersFromURL());
        }
    },
};

// Create configurations array
const configs = [
    {
        ...commonConfig,
        contentSection: '.courses-section',
        filterForm: '#filterForm',
        searchBtn: '#filterButton',
        route: `${LOCAL_URL}/courses/filter`,
        clearFilterBtn: '#clearFilterButton',
        toggleSubmitButtonOnFormInput: true,
        config: {
            initialLoad: true
        }
    },
    {
        ...commonConfig,
        contentSection: '.courses-section',
        filterForm: '#filterByNameForm',
        searchBtn: '#filterByNameButton',
        clearFilterBtn: '#clearFilterButton',
        route: `${LOCAL_URL}/courses/filter`,
        toggleSubmitButtonOnFormInput: true,
        config: {
            initialLoad: false
        }
    }
];

// Create a single instance of DynamicContentManager
const dynamicContentManager = () => new DynamicContentManager(configs);

// Update the animation setup to include category buttons
function setupAnimations() {
    gsap.set(".banner-element", { opacity: 0, y: 30 });

    const timeline = gsap.timeline({
        defaults: { ease: "power3.out", duration: .4 }
    });

    timeline
        .to(".courses-banner", { opacity: 1, duration: .5, ease: "power2.out" })
        .to(".animated-grid, .gradient-overlay", { opacity: .5, duration: .5, stagger: .1 }, "-=0.25")
        .to(".banner-shape-1, .banner-shape-2, .banner-shape-3", { opacity: 1, y: 0, stagger: .1, duration: .5 }, "-=0.4")
        .to(".banner-element", { opacity: 1, y: 0, stagger: .05, duration: .4 }, "-=0.25")
        .to(".banner-illustration", { opacity: 1, x: 0, duration: .5, ease: "power2.out" }, "-=0.5");

    // Category button hover animations
    gsap.utils.toArray(".popular-category").forEach(element => {
        element.addEventListener("mouseenter", () => {
            gsap.to(element, {
                scale: 1.05,
                duration: .15,
                ease: "power2.out",
                backgroundColor: "#f8f9fa"
            });
        });
        element.addEventListener("mouseleave", () => {
            gsap.to(element, {
                scale: 1,
                duration: .15,
                ease: "power2.out",
                backgroundColor: "#ffffff"
            });
        });
    });
}

// Add this function to update active filters
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

// Helper function to get human-readable filter labels
function getFilterLabel(key, value) {
    const labels = {
        name: `Search: "${value}"`,
        difficulty_level: `Difficulty: ${getDifficultyLabel(value)}`,
        published_date: `Date: ${getDateLabel(value)}`,
        sort_by: `Sort: ${getSortLabel(value)}`,
        duration_min: `Duration: ${value} Hrs Min`,
        duration_max: `Duration: ${value} Hrs Max`
    };
    return labels[key] || `${key}: ${value}`;
}

// Helper functions for specific filter types
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

function getDateLabel(value) {
    const dates = {
        'today': 'Today',
        'this_week': 'This Week',
        'this_month': 'This Month',
        'last_3_months': 'Last 3 Months',
        'this_year': 'This Year'
    };
    return dates[value] || value;
}

function getSortLabel(value) {
    const sorts = {
        'oldest': 'Oldest First',
        'difficulty_asc': 'Easiest First',
        'difficulty_desc': 'Hardest First',
        'duration_asc': 'Shortest First',
        'duration_desc': 'Longest First'
    };
    return sorts[value] || value;
}


// Add intersection observer for cards
const cards = document.querySelectorAll('.shadow-course-card');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
        }
    });
}, {
    threshold: 0.1
});

cards.forEach(card => observer.observe(card));


// Initialize everything when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    setupAnimations();

    // Remove the tag-related code and keep the rest
    document.querySelectorAll('.col-md-6').forEach((card, index) => {
        card.style.setProperty('--card-index', index);
    });

    // Initialize content manager
    dynamicContentManager();
});
