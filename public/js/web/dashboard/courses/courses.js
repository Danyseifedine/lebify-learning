// JS for datatable
import { HttpRequest } from '../../../common/base/api/request.js';
import { __API_CFG__ } from '../../../common/base/config/config.js'
import { SweetAlert } from '../../../common/base/messages/sweetAlert.js';
import { Toast } from '../../../common/base/messages/toast.js';
import { FunctionUtility } from '../../../common/base/utils/utils.js';
import { $SingleFormPostController, $DatatableController, $ModalFormFetchController } from '../../../common/core/controllers.js'


const coursesDataTable = new $DatatableController('courses-datatable', {

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/course/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [
        { data: 'id' },
        { data: 'image', name: 'image' },
        { data: 'title' },
        { data: 'instructor_name' },
        { data: 'is_published' },
        { data: 'duration' },
        { data: null },
    ],

    columnDefs: $DatatableController.generateColumnDefs([
        { targets: [0], htmlType: 'selectCheckbox' },
        // note: add your columnDef here
        // example: { targets: [1], htmlType: 'badge', badgeClass: 'badge-light-danger' },
        {
            targets: [4],
            htmlType: 'toggle', dataClassName: 'status-toggle',
            checkWhen: (data, type, row) => {
                return data == true;
            },
            uncheckWhen: (data, type, row) => {
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

        // note: show:
        _SHOW_: async function (id, endpoint, onSuccess, onError) {
            console.log("Show course", id);
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

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-courses-form',
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
                this.callCustomFunction('changeStatus', `${__API_CFG__.LOCAL_URL}/dashboard/course/status/${id}`, (res) => {
                }, (err) => { console.error('Error changing status', err); });
            }
        },

        {
            event: 'click',
            selector: '.delete-btn',
            handler: function (id, event) {
                this.callCustomFunction(
                    '_DELETE_WITH_ALERT_',
                    `${__API_CFG__.LOCAL_URL}/dashboard/course/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => { console.error('Error deleting courses', err); }
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/course/get`,
                    (res) => {
                        console.log('res: ', res);
                    },
                    (err) => { console.error('Error editing courses', err); },
                );
            }
        }
    ],

});

function createCourses() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-courses-form');
    });

    const createCoursesConfig = {
        formSelector: '#create-courses-form',
        externalButtonSelector: '#create-courses-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/course/store`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-courses-form');
            });
            coursesDataTable.reload();
        },
        onError: (err) => { console.error('Error adding courses', err); },
    };

    const form = new $SingleFormPostController(createCoursesConfig);
    form.init();
}
createCourses();

const editCourses = () => {
    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editCoursesConfig = {
        formSelector: '#edit-courses-form',
        externalButtonSelector: '#edit-courses-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/course/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-courses-form');
            });
            coursesDataTable.reload();
        },
        onError: (err) => { console.error('Error editing courses', err); },
    };

    const form = new $SingleFormPostController(editCoursesConfig);
    form.init();
}
editCourses();
