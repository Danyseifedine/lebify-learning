/*=============================================================================
 * Course Management Module
 *
 * This module handles all course-related operations in the dashboard including:
 * - CRUD operations through DataTable
 * - Modal interactions
 * - Event handling
 * - API communications
 *============================================================================*/

import { HttpRequest } from '../../../core/global/services/httpRequest.js';
import { DASHBOARD_URL } from '../../../core/global/config/app-config.js';
import { SweetAlert } from '../../../core/global/notifications/sweetAlert.js';
import { $DatatableController } from '../../../core/global/advanced/advanced.js';
import { ModalLoader } from '../../../core/global/advanced/advanced.js';
import { initSelect2 } from '../../../core/global/utils/functions.js';

/*---------------------------------------------------------------------------
 * Utility Functions
 * @function defaultErrorHandler - Global error handler for consistency
 * @function reloadDataTable - Refreshes the DataTable after operations
 * @function buildApiUrl - Constructs API endpoints for course operations
 *--------------------------------------------------------------------------*/
const defaultErrorHandler = (err) => console.error('Error:', err);
const reloadDataTable = () => courseTable.reload();
const buildApiUrl = (path) => `${DASHBOARD_URL}/courses/${path}`;

/*---------------------------------------------------------------------------
 * Modal Configuration Factory
 * Creates consistent modal configurations with error handling
 * @param {Object} config - Modal configuration options
 * @returns {ModalLoader} Configured modal instance
 *--------------------------------------------------------------------------*/
const createModalLoader = (config) => new ModalLoader({
    modalBodySelector: config.modalBodySelector || '.modal-body',
    endpoint: config.endpoint,
    triggerSelector: config.triggerSelector,
    onSuccess: config.onSuccess,
    onError: config.onError || defaultErrorHandler
});

/*=============================================================================
 * API Operation Handlers
 * Manages all HTTP requests with consistent error handling and response processing
 * Each method follows a similar pattern:
 * 1. Executes the request
 * 2. Handles success callback
 * 3. Manages errors through defaultErrorHandler
 *============================================================================*/
const apiOperations = {
    _DELETE_: async (endpoint, onSuccess) => {
        try {
            const confirmDelete = await SweetAlert.deleteAction();
            if (confirmDelete) {
                const response = await HttpRequest.del(endpoint);
                onSuccess(response);
            }
        } catch (error) {
            defaultErrorHandler(error);
        }
    },

    _SHOW_: async (id, endpoint) => {
        createModalLoader({
            modalBodySelector: '#show-modal .modal-body',
            endpoint,
            onError: defaultErrorHandler
        });
    },

    _EDIT_: async (id, endpoint, onSuccess) => {
        createModalLoader({
            modalBodySelector: '#edit-modal .modal-body',
            endpoint,
            onSuccess,
            onError: defaultErrorHandler
        });
    },

    _POST_: async (endpoint, onSuccess) => {
        try {
            const response = await HttpRequest.post(endpoint);
            onSuccess(response);
        } catch (error) {
            defaultErrorHandler(error);
        }
    },

    _PATCH_: async (endpoint, onSuccess) => {
        try {
            const response = await HttpRequest.patch(endpoint);
            onSuccess(response);
        } catch (error) {
            defaultErrorHandler(error);
        }
    },

    _GET_: async (endpoint, onSuccess) => {
        try {
            const response = await HttpRequest.get(endpoint);
            onSuccess(response);
        } catch (error) {
            defaultErrorHandler(error);
        }
    },

    _PUT_: async (endpoint, onSuccess) => {
        try {
            const response = await HttpRequest.put(endpoint);
            onSuccess(response);
        } catch (error) {
            defaultErrorHandler(error);
        }
    },
};

/*=============================================================================
 * User Interface Event Handlers
 * Manages user interactions and connects them to appropriate API operations
 * Each handler:
 * 1. Receives user input
 * 2. Calls appropriate API operation
 * 3. Handles the response (success/error)
 *============================================================================*/
const userActionHandlers = {
    delete: function (id) {
        this.callCustomFunction('_DELETE_', buildApiUrl(id), (response) => {
            response.risk ? SweetAlert.error() : (SweetAlert.deleteSuccess(), reloadDataTable());
        });
    },

    show: function (id) {
        this.callCustomFunction('_SHOW_', id, buildApiUrl(`${id}/show`));
    },

    edit: function (id) {
        this.callCustomFunction('_EDIT_', id, buildApiUrl(`${id}/edit`), (response) => {
            initSelect2('#instructor_id', '#edit-modal');
            initSelect2('#difficulty_level', '#edit-modal');
        });
    },

    status: function (id) {
        this.callCustomFunction('_PATCH_', buildApiUrl(`${id}/status`), (response) => {
            console.log(response);
        });
    }
};

/*---------------------------------------------------------------------------
 * Event Listener Configurations
 * Maps DOM events to their respective handlers
 * Structure:
 * - event: The DOM event to listen for
 * - selector: The DOM element selector to attach the listener to
 * - handler: The function to execute when the event occurs
 *--------------------------------------------------------------------------*/
const uiEventListeners = [
    { event: 'click', selector: '.delete-btn', handler: userActionHandlers.delete },
    { event: 'click', selector: '.btn-show', handler: userActionHandlers.show },
    { event: 'click', selector: '.btn-edit', handler: userActionHandlers.edit },
    { event: 'click', selector: '.status-toggle', handler: userActionHandlers.status },
];

/*---------------------------------------------------------------------------
 * DataTable Configuration
 * Defines the structure and behavior of the Course management table
 *--------------------------------------------------------------------------*/
const tableColumns = [
    {
        "data": "id"
    },
    {
        "data": "image",
        "title": "Image"
    },
    {
        "data": "title",
        "title": "Title"
    },

    {
        "data": "instructor_id",
        "title": "Teacher",
        "className": "text-center"
    },
    {
        "data": "duration",
        "title": "Duration",
        "className": "text-center"
    },
    {
        "data": "difficulty_level",
        "title": "Difficulty Level",
        "className": "text-center"
    },
    {
        "data": "views",
        "title": "Views",
        "className": "text-center"
    },
    {
        "data": "is_published",
        "title": "Is Published"
    },
    {
        "data": null,
        "title": "Actions",
        "className": "text-end"
    }
];

const tableColumnDefinitions = [
    { targets: [0], orderable: false, htmlType: 'selectCheckbox' },

    { targets: [6], htmlType: 'badge', badgeClass: 'badge-light-primary' },
    {
        targets: [7],
        htmlType: 'toggle',
        dataClassName: 'status-toggle',
    },
    {
        targets: [-1],
        htmlType: 'dropdownActions',
        orderable: false,
        actionButtons: {
            edit: {
                icon: 'bi bi-pencil',
                text: 'Edit',
                type: 'modal',
                class: 'btn-edit',
                modalTarget: '#edit-modal',
                color: 'primary'
            },
            divider1: { divider: true },
            download: {
                icon: 'bi bi-eye',
                text: 'Preview',
                class: 'btn-download',
                color: 'success',
                type: 'redirect',
                url: (row) => buildApiUrl(`${row.id}/preview`)
            },

            divider2: { divider: true },
            delete: {
                icon: 'bi bi-trash',
                text: 'Delete',
                class: 'delete-btn',
                color: 'danger'
            }
        }
    },
];

/*---------------------------------------------------------------------------
 * Bulk Action Handler
 * Processes operations on multiple selected courses
 * @param {Array} selectedIds - Array of selected course IDs
 *--------------------------------------------------------------------------*/
const handleBulkActions = (selectedIds) => {
    // Implementation for bulk actions
    // Example: Delete multiple courses, change status, etc.
};

/*=============================================================================
 * DataTable Initialization
 * Creates and configures the main course management interface
 *============================================================================*/


// Add a namespace prefix for filter selects
const FILTER_PREFIX = 'filter_';

// Update the ajax data function to use prefixed selectors
export const courseTable = new $DatatableController('courseTable', {
    lengthMenu: [[15, 50, 100, 200, -1], [15, 50, 100, 200, 'All']],
    selectedAction: handleBulkActions,
    ajax: {
        url: buildApiUrl('datatable'),
        data: function (d) {
            return {
                ...d,
                filter_instructor_id: $(`#${FILTER_PREFIX}instructor_id`).val(),
                filter_is_published: $(`#${FILTER_PREFIX}is_published`).is(':checked') ? 1 : '',
                filter_is_not_published: $(`#${FILTER_PREFIX}is_not_published`).is(':checked') ? 1 : ''
            };
        }
    },
    columns: tableColumns,
    columnDefs: $DatatableController.generateColumnDefs(tableColumnDefinitions),
    customFunctions: apiOperations,
    eventListeners: uiEventListeners
});

// Initialize create course modal
createModalLoader({
    triggerSelector: '.create',
    endpoint: buildApiUrl('create'),
    onSuccess: (response) => {
        initSelect2('#instructor_id', '#create-modal');
        initSelect2('#difficulty_level', '#create-modal');
    }
});

// Global access for table reload
window.RDT = reloadDataTable;
