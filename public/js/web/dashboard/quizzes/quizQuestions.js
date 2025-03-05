// JS for datatable
import { HttpRequest } from '../../../common/base/api/request.js';
import { __API_CFG__ } from '../../../common/base/config/config.js'
import { SweetAlert } from '../../../common/base/messages/sweetAlert.js';
import { Toast } from '../../../common/base/messages/toast.js';
import { FunctionUtility } from '../../../common/base/utils/utils.js';
import { $SingleFormPostController, $DatatableController, $ModalFormFetchController } from '../../../common/core/controllers.js'


const QuizQuestionsDataTable = new $DatatableController('QuizQuestions-datatable', {

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/questions/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [
        { data: 'id' },
        { data: 'quiz' },
        { data: 'category' },
        { data: 'question' },
        { data: 'type' },
        { data: 'order' },
        { data: null },
    ],

    columnDefs: $DatatableController.generateColumnDefs([
        { targets: [0], htmlType: 'selectCheckbox' },
        // note: add your columnDef here
        { targets: [2], htmlType: 'badge', badgeClass: 'badge-light-danger fs-6' },
        {
            targets: [4], customRender: (data, type, row) => {
                return `<span class="fw-bold">${data}</span>`;
            },
        },
        { targets: [5], htmlType: 'badge', badgeClass: 'badge-light-success fs-6' },
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
            console.log("Show QuizQuestions", id);
        },

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-QuizQuestions-form',
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/questions/delete/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => { console.error('Error deleting QuizQuestions', err); }
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/questions/get`,
                    (res) => {
                        console.log('res: ', res);
                    },
                    (err) => { console.error('Error editing QuizQuestions', err); },
                );
            }
        }
    ],

});

function createQuizQuestions() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-QuizQuestions-form');
    });

    const createQuizQuestionsConfig = {
        formSelector: '#create-QuizQuestions-form',
        externalButtonSelector: '#create-QuizQuestions-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/questions/store`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-QuizQuestions-form');
            });
            QuizQuestionsDataTable.reload();
        },
        onError: (err) => { console.error('Error adding QuizQuestions', err); },
    };

    const form = new $SingleFormPostController(createQuizQuestionsConfig);
    form.init();
}
createQuizQuestions();

const editQuizQuestions = () => {
    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editQuizQuestionsConfig = {
        formSelector: '#edit-QuizQuestions-form',
        externalButtonSelector: '#edit-QuizQuestions-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/questions/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-QuizQuestions-form');
            });
            QuizQuestionsDataTable.reload();
        },
        onError: (err) => { console.error('Error editing QuizQuestions', err); },
    };

    const form = new $SingleFormPostController(editQuizQuestionsConfig);
    form.init();
}
editQuizQuestions();
