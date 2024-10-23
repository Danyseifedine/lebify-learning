import { env } from '../../config/app-config.js';

export class ErrorLogger {
    constructor() {
        this.environment = env.type;
        this.isDevelopment = env.isDevelopment;
    }

    /**
     * Logs a detailed, documented error message for missing attributes if in development environment.
     * @param {string} componentName - The name of the component or class reporting the error.
     * @param {string} attributeName - The name of the missing attribute.
     * @param {string} elementType - The type of element (e.g., 'form', 'button') that should have the attribute.
     * @param {string} location - Where the attribute should be placed (e.g., 'opening tag', 'as a data attribute').
     * @param {string} description - A brief description of the attribute's purpose or importance.
     */
    logMissingAttributeError(componentName, attributeName, elementType, location, description) {
        if (this.isDevelopment) {
            const errorMessage = `
[${componentName}] Missing required attribute: '${attributeName}'
Element Type: ${elementType}
Location: ${location}
Description: ${description}
Example: <${elementType} ${attributeName}="value">

This attribute is necessary for proper functionality of the ${componentName}.
Please add the missing attribute to resolve this issue.
`;
            console.error(errorMessage);
        } else {
            console.error(`Configuration error occurred.`);
        }
    }

    /**
     * Generic error logger that respects the current environment.
     * @param {string} message - The error message.
     * @param {Error} [error] - The error object, if available.
     */
    logError(message, error = null) {
        if (this.isDevelopment) {
            console.error(message, error);
        } else {
            console.error('An error occurred.');
        }
    }

    /**
     * Logs a warning message.
     * @param {string} message - The warning message.
     */
    logWarning(message) {
        if (this.isDevelopment) {
            console.warn(message);
        }
    }

    /**
     * Logs information. Only logs in development environment.
     * @param {string} message - The information message.
     */
    logInfo(message) {
        if (this.isDevelopment) {
            console.info(message);
        }
    }
}

// Create and export a singleton instance
export const errorLogger = new ErrorLogger();
