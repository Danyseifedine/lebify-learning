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

const courseExtentionDataTable = new $DatatableController('courseExtention-datatable', {

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/course/extentions/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [
        { data: 'id' },
        { data: 'course_title' },
        { data: 'name' },
        { data: 'marketplace_url' },
        { data: 'is_published' },
        { data: null },
    ],

    columnDefs: $DatatableController.generateColumnDefs([
        { targets: [0], htmlType: 'selectCheckbox' },
        {
            targets: [4],
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

        changeStatus: async function (endpoint, onSuccess, onError) {
            try {
                const response = await
                    HttpRequest.put(endpoint);
                onSuccess(response);
            } catch (error) {
                onError(error);
            }
        },

        // note: show:
        _SHOW_: async function (id, endpoint, onSuccess, onError) {
            console.log("Show courseExtention", id);
        },

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-courseExtention-form',
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
                this.callCustomFunction('changeStatus', `${__API_CFG__.LOCAL_URL}/dashboard/course/extentions/status/${id}`, (res) => {
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/course/extentions/delete/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => { console.error('Error deleting courseExtention', err); }
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/course/extentions/get`,
                    (res) => {
                        // console.log('res: ', res);
                    },
                    (err) => { console.error('Error editing courseExtention', err); },
                );
            }
        }
    ],

});

function createCourseExtention() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-courseExtention-form');
    });

    const createCourseExtentionConfig = {
        formSelector: '#create-courseExtention-form',
        externalButtonSelector: '#create-courseExtention-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/course/extentions/store`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-courseExtention-form');
            });
            courseExtentionDataTable.reload();
        },
        onError: (err) => { console.error('Error adding courseExtention', err); },
    };

    const form = new $SingleFormPostController(createCourseExtentionConfig);
    form.init();
}
createCourseExtention();

const editCourseExtention = () => {
    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editCourseExtentionConfig = {
        formSelector: '#edit-courseExtention-form',
        externalButtonSelector: '#edit-courseExtention-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/course/extentions/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-courseExtention-form');
            });
            courseExtentionDataTable.reload();
        },
        onError: (err) => { console.error('Error editing courseExtention', err); },
    };

    const form = new $SingleFormPostController(editCourseExtentionConfig);
    form.init();
}
editCourseExtention();