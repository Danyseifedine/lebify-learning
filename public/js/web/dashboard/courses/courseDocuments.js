// JS for datatable
import { HttpRequest } from '../../../common/base/api/request.js';
import { __API_CFG__ } from '../../../common/base/config/config.js'
import { SweetAlert } from '../../../common/base/messages/sweetAlert.js';
import { Toast } from '../../../common/base/messages/toast.js';
import { FunctionUtility } from '../../../common/base/utils/utils.js';
import { $SingleFormPostController, $DatatableController, $ModalFormFetchController } from '../../../common/core/controllers.js'


const courseDocumentsDataTable = new $DatatableController('courseDocuments-datatable', {

    lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, 'All']],

    search: true,
    toggleToolbar: true,
    columnVisibility: true,
    filter: true,
    resetFilter: true,

    selectedAction: (selectedIds) => {
        // note: Perform action on selected IDs (the checked rows)
        // example: console.log('ids: ', selectedIds);
    },

    ajax: {
        url: `${__API_CFG__.LOCAL_URL}/dashboard/course/documents/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [
        { data: 'id' },
        { data: 'course', name: 'courses.title' },
        { data: 'title_en', name: 'course_documents.title_en' },
        { data: 'order', name: 'course_documents.order' },
        { data: null },  // For actions
    ],

    columnDefs: $DatatableController.generateColumnDefs([
        { targets: [0], htmlType: 'selectCheckbox' },
        // note: add your columnDef here
        // example: { targets: [1], htmlType: 'badge', badgeClass: 'badge-light-danger' },
        // example: {
        // example: targets: [4], htmlType: 'toggle',
        // example: checkWhen: (data, type, row) => {
        // example: return data === 'in';
        // example: },
        // example: uncheckWhen: (data, type, row) => {
        // example: return data === 'pending';
        // example: },
        // example: },
        { targets: [-1], htmlType: 'actions', className: 'text-end', actionButtons: { edit: true, delete: true, view: true } },
    ]),



    // note: built-in function:
    customFunctions: {

        // note delete, show, edit
        _DELETE_WITH_ALERT_: async function (endpoint, onSuccess, onError) {
            try {
                const result = await SweetAlert.deleteAction();
                if (result) {
                    const response = await HttpRequest.del(endpoint);
                    onSuccess(response);
                }
            } catch (error) {
                onError(error);
            }
        },

        // note: show:
        _SHOW_: async function (id, endpoint, onSuccess, onError) {
            console.log("Show courseDocuments", id);
        },

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-courseDocuments-form',
                // quillSelector: '#edit_content',
                onSuccess: (data) => {
                    onSuccess(data);
                },
                onError: (error) => {
                    onError(error);
                },
            });

            modalHandler.show(id);
        },

        _PUT_: async function (endpoint, onSuccess, onError) {
            try {
                const response = await
                    HttpRequest.put(endpoint);
                onSuccess(response);
            } catch (error) {
                onError(error);
            }
        },
    },


    eventListeners: [
        {
            event: 'click',
            selector: '.delete-btn',
            handler: function (id, event) {
                this.callCustomFunction(
                    '_DELETE_WITH_ALERT_',
                    `${__API_CFG__.LOCAL_URL}/dashboard/course/documents/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => { console.error('Error deleting courseDocuments', err); }
                );
            }
        },
        {
            event: 'click',
            selector: '.btn-show',
            handler: function (id, event) {
                this.callCustomFunction('_SHOW_', id);
            }
        },
        {
            event: 'click',
            selector: '.btn-edit',
            handler: function (id, event) {
                this.callCustomFunction('_EDIT_WITH_MODAL_',
                    id,
                    `${__API_CFG__.LOCAL_URL}/dashboard/course/documents/get`,
                    (res) => {
                        console.log('res: ', res);
                    },
                    (err) => { console.error('Error editing courseDocuments', err); },
                );
            }
        }
    ],

});

function createCourseDocuments() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-courseDocuments-form');
        // Reset Ace Editors
        ace.edit("editor_en").setValue("");
        ace.edit("editor_ar").setValue("");
    });

    const createCourseDocumentsConfig = {
        formSelector: '#create-courseDocuments-form',
        externalButtonSelector: '#create-courseDocuments-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/course/documents/store`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-courseDocuments-form');
                // Reset Ace Editors
                ace.edit("editor_en").setValue("");
                ace.edit("editor_ar").setValue("");
            });
            courseDocumentsDataTable.reload();
        },
        onError: (err) => { console.error('Error adding courseDocuments', err); },
    };

    const form = new $SingleFormPostController(createCourseDocumentsConfig);
    form.init();
}

createCourseDocuments();

const editCourseDocuments = () => {
    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editCourseDocumentsConfig = {
        formSelector: '#edit-courseDocuments-form',
        externalButtonSelector: '#edit-courseDocuments-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/course/documents/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-courseDocuments-form');
            });
            courseDocumentsDataTable.reload();
        },
        onError: (err) => { console.error('Error editing courseDocuments', err); },
    };

    const form = new $SingleFormPostController(editCourseDocumentsConfig);
    form.init();
}
editCourseDocuments();
