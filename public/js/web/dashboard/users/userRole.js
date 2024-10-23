// JS for datatable
import { HttpRequest } from '../../../common/base/api/request.js';
import { __API_CFG__ } from '../../../common/base/config/config.js'
import { SweetAlert } from '../../../common/base/messages/sweetAlert.js';
import { Toast } from '../../../common/base/messages/toast.js';
import { FunctionUtility } from '../../../common/base/utils/utils.js';
import { $SingleFormPostController, $DatatableController, $ModalFormFetchController } from '../../../common/core/controllers.js'


const userRoleDataTable = new $DatatableController('userRole-datatable', {

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/user/role/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'role' },
        { data: null },
    ],

    columnDefs: $DatatableController.generateColumnDefs([
        { targets: [0], htmlType: 'selectCheckbox' },
        // note: add your columnDef here
        { targets: [2], htmlType: 'badge', badgeClass: 'badge-light-danger' },
        // example: {
        // example: targets: [4], htmlType: 'toggle',
        // example: checkWhen: (data, type, row) => {
        // example: return data === 'in';
        // example: },
        // example: uncheckWhen: (data, type, row) => {
        // example: return data === 'pending';
        // example: },
        // example: },
        { targets: [-1], htmlType: 'actions', className: 'text-end', actionButtons: { edit: true, delete: false, view: false } },
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
            console.log("Show userRole", id);
        },

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-userRole-form',
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

        _AJAX_CALL_: async function (endpoint, data, onSuccess, onError) {
            try {
                const response = await HttpRequest.post(endpoint, data);
                this.reload();
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/userRole/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => { console.error('Error deleting userRole', err); }
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/user/role/get`,
                    (res) => {
                        console.log('res: ', res);
                        let roleContainer = document.querySelector('#role-container');
                        roleContainer.innerHTML = '';

                        let userRolesContainer = document.createElement('div');
                        userRolesContainer.className = 'mb-4';
                        userRolesContainer.innerHTML = '<h6 class="fw-bold mb-2">Current Roles</h6>';

                        let availableRolesContainer = document.createElement('div');
                        availableRolesContainer.innerHTML = '<h6 class="fw-bold mb-2">Available Roles</h6>';

                        roleContainer.appendChild(userRolesContainer);
                        roleContainer.appendChild(availableRolesContainer);

                        const createRoleBadge = (role, isUserRole) => {
                            let badge = document.createElement('div');
                            badge.className = `d-inline-flex align-items-center ${isUserRole ? 'bg-light-danger' : 'bg-light-success'} rounded p-2 me-2 mb-2`;
                            badge.innerHTML = `
                                <span class="fw-bold ${isUserRole ? 'text-danger' : 'text-success'}">${role.name}</span>
                                <button class="btn btn-sm btn-icon btn-active-light-${isUserRole ? 'danger' : 'success'} ms-2"
                                        data-role-id="${role.id}"
                                        data-user-id="${id}"
                                        aria-label="${isUserRole ? 'Delete' : 'Add'}">
                                    <i class="bi bi-${isUserRole ? 'x' : 'plus'}-lg"></i>
                                </button>
                            `;

                            badge.querySelector('button').addEventListener('click', (e) => {
                                e.preventDefault();
                                const action = isUserRole ? 'delete' : 'add';
                                const confirmMessage = isUserRole ? 'Are you sure you want to remove this role?' : 'Do you want to add this role?';

                                if (confirm(confirmMessage)) {
                                    this.callCustomFunction('_AJAX_CALL_',
                                        `${__API_CFG__.LOCAL_URL}/dashboard/user/role/${action}`,
                                        { user_id: id, role_id: role.id },
                                        (res) => {
                                            console.log(`Role ${action}d successfully`, res);
                                            badge.remove();
                                            createRoleBadge(role, !isUserRole);
                                        },
                                        (err) => console.error(`Error ${action}ing role`, err)
                                    );
                                }
                            });

                            (isUserRole ? userRolesContainer : availableRolesContainer).appendChild(badge);
                        };

                        res.userRoles.forEach(role => createRoleBadge(role, true));
                        res.nonUserRoles.forEach(role => createRoleBadge(role, false));

                        let form = document.querySelector('#edit-userRole-form');
                        if (form) {
                            form.addEventListener('submit', (e) => e.preventDefault());
                        }
                    },
                    (err) => { console.error('Error editing userRole', err); },
                );
            }
        }
    ],

});

function createUserRole() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-userRole-form');
    });

    const createUserRoleConfig = {
        formSelector: '#create-userRole-form',
        externalButtonSelector: '#create-userRole-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/userRole`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-userRole-form');
            });
            userRoleDataTable.reload();
        },
        onError: (err) => { console.error('Error adding userRole', err); },
    };

    const form = new $SingleFormPostController(createUserRoleConfig);
    form.init();
}
createUserRole();

const editUserRole = () => {
    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');
}
editUserRole();


