// JS for datatable
import { HttpRequest } from '../../../common/base/api/request.js';
import { __API_CFG__ } from '../../../common/base/config/config.js'
import { SweetAlert } from '../../../common/base/messages/sweetAlert.js';
import { Toast } from '../../../common/base/messages/toast.js';
import { FunctionUtility } from '../../../common/base/utils/utils.js';
import { $SingleFormPostController, $DatatableController, $ModalFormFetchController } from '../../../common/core/controllers.js'

const QuizAnswersDataTable = new $DatatableController('QuizAnswers-datatable', {

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/answers/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [
        { data: 'id' },
        { data: 'quiz_name' },
        { data: 'quiz_question' },
        { data: 'answer' },
        { data: 'is_correct' },
        { data: null },
    ],

    columnDefs: $DatatableController.generateColumnDefs([
        { targets: [0], htmlType: 'selectCheckbox' },
        // note: add your columnDef here
        // example: { targets: [1], htmlType: 'badge', badgeClass: 'badge-light-danger' },
        // example: {
        {
            targets: [4], htmlType: 'toggle',
            dataClassName: 'status-toggle',
            checkWhen: (data, type, row) => {
                // console.log(data)
                return data == true;
            },
            uncheckWhen: (data, type, row) => {
                // console.log(data)
                return data == false;
            },
        },
        { targets: [-1], htmlType: 'actions', className: 'text-end', actionButtons: { edit: true, delete: true, view: true } },
    ]),



    // note: built-in function:
    customFunctions: {

        changeStatus: async function (endpoint, onSuccess, onError) {
            try {
                const response = await
                    HttpRequest.put(endpoint);
                onSuccess(response);
            } catch (error) {
                onError(error);
            }
        },

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
            console.log("Show QuizAnswers", id);
        },

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-QuizAnswers-form',
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
            event: 'change',
            selector: '.status-toggle',
            handler: function (id, event) {
                // console.log(id)
                this.callCustomFunction('changeStatus', `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/answers/status/${id}`, (res) => {
                    // console.log(res);
                }, (err) => {
                    console.error('Error changing status', err);
                });
            }
        },
        {
            event: 'click',
            selector: '.delete-btn',
            handler: function (id, event) {
                this.callCustomFunction(
                    '_DELETE_WITH_ALERT_',
                    `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/answers/delete/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => { console.error('Error deleting QuizAnswers', err); }
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/answers/get`,
                    (res) => {
                        console.log('res: ', res);
                    },
                    (err) => { console.error('Error editing QuizAnswers', err); },
                );
            }
        }
    ],

});

function createQuizAnswers() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-QuizAnswers-form');
    });

    const createQuizAnswersConfig = {
        formSelector: '#create-QuizAnswers-form',
        externalButtonSelector: '#create-QuizAnswers-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/answers/store`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-QuizAnswers-form');
            });
            QuizAnswersDataTable.reload();
        },
        onError: (err) => { console.error('Error adding QuizAnswers', err); },
    };

    const form = new $SingleFormPostController(createQuizAnswersConfig);
    form.init();
}
createQuizAnswers();

const editQuizAnswers = () => {
    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editQuizAnswersConfig = {
        formSelector: '#edit-QuizAnswers-form',
        externalButtonSelector: '#edit-QuizAnswers-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/answers/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-QuizAnswers-form');
            });
            QuizAnswersDataTable.reload();
        },
        onError: (err) => { console.error('Error editing QuizAnswers', err); },
    };

    const form = new $SingleFormPostController(editQuizAnswersConfig);
    form.init();
}
editQuizAnswers();
