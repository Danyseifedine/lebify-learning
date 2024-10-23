import { Translator } from '../translation/translation.js';
/**
 * Application Configuration
 *
 * This file contains global configuration settings for the application.
 * It defines constants and default values used across different components.
 */

const currEnv = 'development';

// Initialize Translator
export const l10n = new Translator();

// Get the current URL
let url = window.location.href;

// Get the base URL
let baseUrl = url.split('/')[0] + '//' + url.split('/')[2];

// Base URL for API requests, dynamically includes the current locale
export const BASE_URL = `${baseUrl}/${l10n.currentLocale}`;

// Base local URL for development environment
export const LOCAL_URL = `${baseUrl}`;

// Default language for the application
export const APP_LANG = l10n.currentLocale;


/**
 * Environment Settings
 * Defines the current environment and provides boolean flags for easy checks.
 */
export const env = {
    type: currEnv,
    isDevelopment: currEnv === 'development',
    isProduction: currEnv === 'production',
    enableDevTools: false,                        // New configuration to enable/disable dev tools
}


/**
 * Form Handling Configuration
 * Defines attributes and settings for form submission handling.
 */
export const handlers = {

    // Single Form Post Handler
    singleFormPost: {
        attributes: {
            formId: 'form-id',              // Unique identifier for the form
            submitFormId: 'submit-form-id', // Links submit button to its form
            httpRequest: 'http-request',    // Indicates AJAX submission
            route: 'route',                 // Specifies form submission endpoint
            handler: 'identifier',          // Specifies the form processing handler
            serializeAs: 'serialize-as',    // Defines form serialization method
        }
    },

    // Tab Handler
    tabHandler: {
        attributes: {
            handler: 'identifier',          // Specifies the form processing handler
            tabGroupId: 'tab-group-id',     // Specifies the tab group identifier
            tabId: 'tab-id',                // Specifies the tab identifier
            contentId: 'tab-content-id',    // Specifies the tab content identifier
            route: 'tab-route',             // Specifies the tab route
            initial: 'tab-initial',         // Specifies the initial tab
            tabUrl: 'tab-url',              // Specifies whether to update URL with tab ID
            cache: 'cache-tab',             // New attribute for caching
        },
        classes: {
            active: 'active',                // Specifies the active tab class
            loading: 'loading'               // Specifies the loading tab class
        },
        selectors: {
            tabGroup: '[identifier="tab-handler"]', // Specifies the tab group selector
            tabContent: '[tab-content-id]',         // Specifies the tab content selector
            tab: '[tab-id]',                        // Specifies the tab selector
            initialTab: '[tab-initial="true"]',     // Specifies the initial tab selector
        }
    },

    // Counter Handler
    counterHandler: {
        attributes: {
            id: 'counter-id',                   // Unique identifier for the counter
            init: 'counter-init',               // Initial counter value
            step: 'counter-step',               // Increment/decrement step
            min: 'counter-min',                 // Minimum allowed value
            max: 'counter-max',                 // Maximum allowed value
            display: 'counter-display',         // Element to display counter value
            increment: 'counter-inc',           // Increment button
            decrement: 'counter-dec',           // Decrement button
            onIncrease: 'on-increase',          // Custom increase function (button, currentValue, minValue, maxValue, updateFunction)
            onDecrease: 'on-decrease'           // Custom decrease function (button, currentValue, minValue, maxValue, updateFunction)
        },
        defaults: {
            init: 0,                            // Default initial value
            step: 1,                            // Default step value
            min: null,                          // Default minimum (no limit)
            max: null                           // Default maximum (no limit)
        }
    },

    // Modal Handler
    modalHandler: {
        attributes: {
            identifier: 'identifier',                // Identifies the modal handler instance
            clearForms: 'clear-forms',               // Indicates that forms within this modal should be cleared on close or successful submission
            fetchUrl: 'route',                       // URL to fetch modal content
            httpRequest: 'http-request',             // Indicates if the modal should fetch content
            params: 'params',                        // Specifies the attribute name for additional parameters
            itemId: 'item-id',                       // Specifies the attribute name for the item ID
            cache: 'modal-cache'                     // New attribute for caching
        },
    },
}


/**
 * Response Types
 * Defines attributes for response types.
 */
export const responseTypes = {
    successToast: 'success-toast', // Success toast
    errorToast: 'error-toast',     // Error toast
    redirect: 'redirect',          // Redirect to a new page
    closeModal: 'close-modal',      // Close the modal
}


/**
 * Button Configuration
 * Defines settings for various button types.
 */
export const button = {
    attributes: {
        loadingText: 'loading-text',    // Custom loading text
        spinner: 'spinner',             // Enables/disables spinner
        noLoadingText: 'no-loading-text', // Disables loading text
    },
    defaults: {
        loadingText: 'Loading...',      // Default loading text
        showSpinner: false,             // Default spinner visibility
    },
    spinner: {
        html: '<span class="spinner-border mx-2 spinner-border-sm" role="status" aria-hidden="true"></span>'
    }
}


/**
 * Toast Configuration
 * Defines settings for toast notifications.
 */
export const toast = {
    options: {
        position: 'topRight',
        timeout: 5000,
        progressBar: true,
        progressBarColor: '#1b5e38',
        closeOnClick: true,
        pauseOnHover: true,
        resetOnHover: false,
        transitionIn: 'fadeInLeft',
        transitionOut: 'fadeOutRight',
    }
}


/**
 * Validation Configuration
 * Defines settings for validation feedback.
 */
export const validation = {
    attributes: {
        feedback: 'feedback',               // Enables validation feedback
        inputFeedbackId: 'feedback-id',     // Links input to its feedback element
    }
}


/**
 * Event Handling Configuration
 * Defines attributes for custom event handlers.
 */
export const events = {
    attributes: {
        success: 'on-success',              // Success event handler (data, form, button)
        error: 'on-error',                  // Error event handler (data, form, button)
        loading: 'on-loading',              // Loading state event handler (isLoading, form, button)
        loaded: 'on-loaded',                // Loaded event handler (tabId, tabContent)
        log: 'log',                        // Logs the response
    }
}


/**
 * Rate Limiter Configuration
 * Defines attributes for rate limiting and submission tracking.
 */
export const rateLimiter = {
    attributes: {
        rateLimit: 'rate-limit',        // Specifies rate limiting
        lastSubmission: 'last-submission', // Tracks last submission time
    }
}

/**
 * Component Identifiers
 * Defines unique identifiers for various components in the application.
 */
export const identifiers = {
    singleFormPost: 'single-form-post-handler', // Single form post handler
    counterHandler: 'counter-handler',          // Counter handler
    tabHandler: 'tab-handler',                  // Tab handler
    modalHandler: 'modal-handler',              // Modal handler
};


/**
 * Updates the configuration object with new settings.
 * @param {Object} newConfig - The new configuration settings.
 * @example
 * // Update the configuration to change the debounce delay and throttle limit
 * updateConfig({ debounceDelay: 300, throttleLimit: 600 });
 */
export function updateConfig(newConfig) {
    Object.assign(config, newConfig);
}
