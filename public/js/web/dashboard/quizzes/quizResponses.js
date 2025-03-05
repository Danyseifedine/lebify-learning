// JS for datatable
import { HttpRequest } from '../../../common/base/api/request.js';
import { __API_CFG__ } from '../../../common/base/config/config.js'
import { SweetAlert } from '../../../common/base/messages/sweetAlert.js';
import { Toast } from '../../../common/base/messages/toast.js';
import { FunctionUtility } from '../../../common/base/utils/utils.js';
import { $SingleFormPostController, $DatatableController, $ModalFormFetchController } from '../../../common/core/controllers.js'


const quizResponsesDataTable = new $DatatableController('quizResponses-datatable', {

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/responses/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [
        { data: 'id' },
        { data: 'quiz_name', name: 'quiz_name', title: 'Quiz' },
        { data: 'user_name', name: 'user_name', title: 'User' },
        { data: 'question', name: 'question', title: 'Question' },
        { data: 'selected_answer', name: 'selected_answer', title: 'Selected Answer' },
        { data: 'correct_answer', name: 'correct_answer', title: 'Correct Answer' },
        { data: 'status', name: 'status', title: 'Status' },
        { data: null },
    ],

    columnDefs: $DatatableController.generateColumnDefs([
        { targets: [0], htmlType: 'selectCheckbox' },
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
            console.log("Show quizResponses", id);
        },

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-quizResponses-form',
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/responses/delete/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => { console.error('Error deleting quizResponses', err); }
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/responses/get`,
                    (res) => {
                        console.log('res: ', res);
                    },
                    (err) => { console.error('Error editing quizResponses', err); },
                );
            }
        }
    ],

});

function createQuizResponses() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-quizResponses-form');
    });

    const createQuizResponsesConfig = {
        formSelector: '#create-quizResponses-form',
        externalButtonSelector: '#create-quizResponses-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/responses/store`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-quizResponses-form');
            });
            quizResponsesDataTable.reload();
        },
        onError: (err) => { console.error('Error adding quizResponses', err); },
    };

    const form = new $SingleFormPostController(createQuizResponsesConfig);
    form.init();
}
createQuizResponses();

const editQuizResponses = () => {
    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editQuizResponsesConfig = {
        formSelector: '#edit-quizResponses-form',
        externalButtonSelector: '#edit-quizResponses-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/responses/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-quizResponses-form');
            });
            quizResponsesDataTable.reload();
        },
        onError: (err) => { console.error('Error editing quizResponses', err); },
    };

    const form = new $SingleFormPostController(editQuizResponsesConfig);
    form.init();
}
editQuizResponses();
