import { formatUuidInputField } from "../../../core/global/utils/functions.js";

function initApp() {
    formatUuidInputField('[data-uuid-input]', 2);
    initThemeToggle();
    initNavbar();
}

function initThemeToggle() {
    const themeToggle = document.querySelector('.theme-toggle-float');
    if (!themeToggle) return;

    themeToggle.addEventListener('click', () => {
        // Get current theme
        const currentTheme = document.documentElement.getAttribute('data-bs-theme');

        // Toggle theme
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', newTheme);

        // Save preference
        localStorage.setItem('data-bs-theme', newTheme);

        // Update toggle state
        themeToggle.setAttribute('data-kt-toggle-state', newTheme);
    });
}

function initNavbar() {
    const navbar = document.querySelector('.navbar');
    let lastScrollTop = 0;
    let ticking = false;

    function updateNavbar(scrollTop) {
        if (scrollTop > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        lastScrollTop = scrollTop;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(function () {
                updateNavbar(window.scrollY);
                ticking = false;
            });
            ticking = true;
        }
    });
}


document.addEventListener('DOMContentLoaded', function () {
    initApp();
});



export function filterLoading() {
    return `
        <div class="loading-overlay lebify-logo-loading">
            <div class="loading-content">
                <img src="../../../core/vendor/img/logo/lebify-logo.svg" class="loading-logo animate-spin" alt="Loading...">
            </div>
        </div>
    `
}

export function getFiltersFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    const filters = {};

    // Convert URLSearchParams to object
    urlParams.forEach((value, key) => {
        if (value && value !== '') {
            filters[key] = value;
        }
    });

    return filters;
}

export function initSelectableCards(options = {}) {
    const {
        containerSelector = '.selectable-container', // Container of selectable cards
        cardSelector = '.selectable', // Individual card class
        onSelect = null, // Callback when a card is selected
        multiSelect = false, // Allow multiple selections
        activeClass = 'selected', // Class to add to selected cards
    } = options;

    const containers = document.querySelectorAll(containerSelector);

    containers.forEach(container => {
        const cards = container.querySelectorAll(cardSelector);

        cards.forEach(card => {
            card.addEventListener('click', () => {
                if (!multiSelect) {
                    // Remove selected class from all cards in the same container
                    container.querySelectorAll(cardSelector).forEach(sibling => {
                        sibling.classList.remove(activeClass);
                    });
                }

                // Toggle selected class on clicked card
                card.classList.toggle(activeClass);

                // Call callback if provided
                if (onSelect) {
                    const selectedCards = container.querySelectorAll(`${cardSelector}.${activeClass}`);
                    onSelect({
                        selectedCard: card,
                        selectedCards: Array.from(selectedCards),
                        container: container,
                        isSelected: card.classList.contains(activeClass)
                    });
                }
            });
        });
    });

    return {
        getSelected: (container) => {
            const targetContainer = container || document.querySelector(containerSelector);
            return Array.from(targetContainer.querySelectorAll(`${cardSelector}.${activeClass}`));
        },
        clearSelection: (container) => {
            const targetContainer = container || document.querySelector(containerSelector);
            targetContainer.querySelectorAll(`${cardSelector}.${activeClass}`).forEach(card => {
                card.classList.remove(activeClass);
            });
        },
        selectCard: (card) => {
            if (card) {
                card.classList.add(activeClass);
            }
        }
    };
}


