// JS for datatable
import {
    HttpRequest
} from '../../../common/base/api/request.js';
import {
    __API_CFG__
} from '../../../common/base/config/config.js'
import {
    SweetAlert
} from '../../../common/base/messages/sweetAlert.js';
import {
    Toast
} from '../../../common/base/messages/toast.js';
import {
    FunctionUtility
} from '../../../common/base/utils/utils.js';
import {
    $SingleFormPostController,
    $DatatableController,
    $ModalFormFetchController
} from '../../../common/core/controllers.js'

const quizzesDataTable = new $DatatableController('quizzes-datatable', {

    lengthMenu: [
        [5, 10, 20, 50, -1],
        [5, 10, 20, 50, 'All']
    ],

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [{
        data: 'id'
    },
    {
        data: 'title'
    },
    {
        data: 'passing_score'
    },

    {
        data: 'attempts_allowed'
    },

    {
        data: 'duration',
    },
    {
        data: 'difficulty'
    },
    {
        data: 'translated'
    },
    {
        data: 'is_published'
    },
    {
        data: null
    },
    ],

    columnDefs: $DatatableController.generateColumnDefs([{
        targets: [0],
        htmlType: 'selectCheckbox'
    },
    // note: add your columnDef here
    {
        targets: [4],
        customRender: (data, type, row) => {
            return `<span class="badge bg-light-primary">${data} minutes</span>`;
        }
    },

    {
        targets: [5],
        customRender: (data, type, row) => {
            return `<span class="badge bg-light-danger">${data}</span>`;
        }
    },
    {
        targets: [6],
        htmlType: 'toggle',
        dataClassName: 'status-toggle',
        checkWhen: (data, type, row) => {
            // console.log(data);
            return data == true;
        },
        uncheckWhen: (data, type, row) => {
            // console.log(data);
            return data == false;
        }
    },
    {
        targets: [-1],
        htmlType: 'actions',
        className: 'text-end',
        actionButtons: {
            edit: true,
            delete: true,
            view: true
        }
    },
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
            console.log("Show quizzes", id);
        },

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-quizzes-form',
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

        changeStatus: async function (endpoint, onSuccess, onError) {
            try {
                const response = await
                    HttpRequest.put(endpoint);
                onSuccess(response);
            } catch (error) {
                onError(error);
            }
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
                this.callCustomFunction('changeStatus', `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/status/${id}`, (res) => {
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/delete/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => {
                        console.error('Error deleting quizzes', err);
                    }
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/get`,
                    (res) => {
                        console.log('res: ', res);
                    },
                    (err) => {
                        console.error('Error editing quizzes', err);
                    },
                );
            }
        }
    ],

});

function createQuizzes() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-quizzes-form');
    });

    const createQuizzesConfig = {
        formSelector: '#create-quizzes-form',
        externalButtonSelector: '#create-quizzes-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/store`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-quizzes-form');
            });
            quizzesDataTable.reload();
        },
        onError: (err) => {
            console.error('Error adding quizzes', err);
        },
    };

    const form = new $SingleFormPostController(createQuizzesConfig);
    form.init();
}
createQuizzes();

const editQuizzes = () => {
    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editQuizzesConfig = {
        formSelector: '#edit-quizzes-form',
        externalButtonSelector: '#edit-quizzes-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/quizzes/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-quizzes-form');
            });
            quizzesDataTable.reload();
        },
        onError: (err) => {
            console.error('Error editing quizzes', err);
        },
    };

    const form = new $SingleFormPostController(editQuizzesConfig);
    form.init();
}
editQuizzes();
