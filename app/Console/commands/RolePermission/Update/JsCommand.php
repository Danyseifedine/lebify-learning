<?php

namespace App\Console\Commands\RolePermission\Update;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class JsCommand extends Command
{
    protected $signature = 'update:js-role-permission';
    protected $description = 'Update JavaScript for role and permission';

    public function handle()
    {
        $this->updatePermissionJs();
        $this->info('JavaScript files have been updated successfully.');

        $this->updateRoleJs();
        $this->info('Javascript files have been updated successfully');
    }

    private function updatePermissionJs()
    {
        $jsPath = public_path('js/web/dashboard/privileges/permission.js');

        if (!File::exists($jsPath)) {
            $this->error('permission.js file does not exist.');
            return;
        }

        $jsContent = $this->getPermissionJsContent();
        File::put($jsPath, $jsContent);

        $this->info('permission.js file has been updated.');
    }

    private function updateRoleJs()
    {
        $jsPath = public_path('js/web/dashboard/privileges/role.js');

        if (!File::exists($jsPath)) {
            $this->error('role.js file does not exist.');
            return;
        }

        $jsContent = $this->getRoleJsContent();
        File::put($jsPath, $jsContent);

        $this->info('role.js file has been updated.');
    }

    private function getPermissionJsContent()
    {
        return <<<'EOD'
// JS for datatable
import { HttpRequest } from '../../../common/base/api/request.js';
import { __API_CFG__ } from '../../../common/base/config/config.js'
import { SweetAlert } from '../../../common/base/messages/sweetAlert.js';
import { Toast } from '../../../common/base/messages/toast.js';
import { FunctionUtility } from '../../../common/base/utils/utils.js';
import { $SingleFormPostController, $DatatableController, $ModalFormFetchController } from '../../../common/core/controllers.js'


const permissionDataTable = new $DatatableController('permission-datatable', {

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/privileges/permissions/datatable`,
        data: (d) => ({
            ...d,
            // note: add your data here such as fiter option
            // example: name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
        })
    },


    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'display_name' },
        { data: 'description' },
        { data: null },
    ],

    columnDefs: $DatatableController.generateColumnDefs([
        { targets: [0], htmlType: 'selectCheckbox' },
        {
            targets: [3], className: 'text-center', customRender: (data, type, row) => {
                if (data) {
                    return `<strong>${data}</strong>`;
                } else {
                    return `<span class="badge bg-danger text-white">N/A</span>`;
                }
            }
        },
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
        _SHOW_ASSIGNED_ROLE_: async function (id, endpoint, onSuccess, onError) {
            const modal = new bootstrap.Modal(document.getElementById('permission-role-modal'));
            modal.show();

            const contentEl = document.getElementById('show-permission-role-content');
            contentEl.innerHTML = '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            try {
                const { permission, allRoles, permissionRoles } = await HttpRequest.get(`${endpoint}/${id}`);

                const renderRole = (role, isAssigned) => `
                    <div class="badge bg-light text-dark p-2 d-flex align-items-center" data-id="${role.id}">
                        <span class="me-2 text-primary">${role.name}</span>
                        <button class="btn btn-sm p-0 ${isAssigned ? 'remove' : 'add'}-role" data-id="${role.id}" style="width: 20px; height: 20px;">
                            <i class="bi bi-${isAssigned ? 'x' : 'check-lg'} fs-3" style="transition: color 0.3s;" onmouseover="this.style.color='${isAssigned ? 'red' : 'lightgreen'}'" onmouseout="this.style.color=''"></i>
                        </button>
                    </div>
                `;

                const renderRoleSet = (title, roles, isAssigned) => `
                    <div class="col-md-6 mb-4">
                        <h4 class="mb-3">${title}</h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2" id="${isAssigned ? 'assigned' : 'available'}-roles">
                                    ${roles.map(role => renderRole(role, isAssigned)).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                contentEl.innerHTML = `
                <div class="mb-6"><h3 class="card-title badge badge-light-info mb-3">${permission.name}</h3></div>
                <div class="row">
                    ${renderRoleSet("Assigned Roles", allRoles.filter(r => permissionRoles.includes(r.id)), true)}
                    ${renderRoleSet("Available Roles", allRoles.filter(r => !permissionRoles.includes(r.id)), false)}
                </div>
            `;

                contentEl.addEventListener('click', async (event) => {
                    const btn = event.target.closest('button');
                    if (!btn) return;

                    const roleId = btn.dataset.id;
                    const isRemoving = btn.classList.contains('remove-role');
                    const endpoint = `${__API_CFG__.LOCAL_URL}/dashboard/privileges/permissions/${permission.id}/roles${isRemoving ? `/${roleId}` : ''}`;

                    const originalContent = btn.innerHTML;
                    btn.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                    btn.disabled = true;

                    try {
                        await (isRemoving ? HttpRequest.del(endpoint) : HttpRequest.post(endpoint, { role_id: roleId }));
                        Toast.showNotificationToast('', `Role ${isRemoving ? 'removed' : 'added'} successfully`);

                        const roleEl = btn.closest('.badge');
                        const targetContainer = document.getElementById(`${isRemoving ? 'available' : 'assigned'}-roles`);
                        btn.className = `btn btn-sm p-0 ${isRemoving ? 'add' : 'remove'}-role`;
                        btn.innerHTML = `<i class="bi bi-${isRemoving ? 'check-lg' : 'x'} fs-3" style="transition: color 0.3s;" onmouseover="this.style.color='${isRemoving ? 'lightgreen' : 'red'}'" onmouseout="this.style.color=''"></i>`;
                        targetContainer.appendChild(roleEl);
                    } catch (error) {
                        console.error('Error updating role', error);
                        Toast.showNotificationToast('Error', 'Failed to update role. Please try again.');
                        btn.innerHTML = originalContent;
                    } finally {
                        btn.disabled = false;
                    }
                });
                onSuccess({ permission, allRoles, permissionRoles });
            } catch (error) {
                contentEl.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    An error occurred while fetching the data. Please try again.
                </div>
            `;
                onError(error);
            }
        },

        // note: edit:
        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-permission-form',
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
                    `${__API_CFG__.LOCAL_URL}/dashboard/privileges/permissions/${id}`,
                    (res) => {
                        if (res.risk) {
                            SweetAlert.error();
                        } else {
                            SweetAlert.deleteSuccess();
                            this.reload();
                        }
                    },
                    (err) => { console.error('Error deleting user', err); }
                );
            }
        },
        {
            event: 'click',
            selector: '.btn-show',
            handler: function (id, event) {
                this.callCustomFunction('_SHOW_ASSIGNED_ROLE_', id, `${__API_CFG__.LOCAL_URL}/dashboard/privileges/permissions/hasRole`, (res) => {
                    console.log(res)
                }, (err) => {
                    console.error('Error showing roles', err);
                });
            }
        },
        {
            event: 'click',
            selector: '.btn-edit',
            handler: function (id, event) {
                this.callCustomFunction('_EDIT_WITH_MODAL_',
                    id,
                    `${__API_CFG__.LOCAL_URL}/dashboard/privileges/permissions/get`,
                    (res) => {
                        console.log('res: ', res);
                    },
                    (err) => { console.error('Error editing permission', err); },
                );
            }
        }
    ],

});

function createPermission() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-permission-form');
    });

    const createPermissionConfig = {
        formSelector: '#create-permission-form',
        externalButtonSelector: '#create-permission-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/privileges/permissions`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-permission-form');
            });
            permissionDataTable.reload();
        },
        onError: (err) => { console.error('Error adding permission', err); },
    };

    const form = new $SingleFormPostController(createPermissionConfig);
    form.init();
}
createPermission();

const editPermission = () => {

    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editPermissionConfig = {
        formSelector: '#edit-permission-form',
        externalButtonSelector: '#edit-permission-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/privileges/permissions/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-permission-form');
            });
            permissionDataTable.reload();
        },
        onError: (err) => { console.error('Error editing navbar', err); },
    };

    const form = new $SingleFormPostController(editPermissionConfig);
    form.init();
}

editPermission();

EOD;
    }

    private function getRoleJsContent()
    {
        return <<<'EOT'
// JS for datatable
import { HttpRequest } from '../../../common/base/api/request.js';
import { __API_CFG__ } from '../../../common/base/config/config.js'
import { SweetAlert } from '../../../common/base/messages/sweetAlert.js';
import { Toast } from '../../../common/base/messages/toast.js';
import { FunctionUtility } from '../../../common/base/utils/utils.js';
import { $SingleFormPostController, $DatatableController, $ModalFormFetchController, } from '../../../common/core/controllers.js'


const roleDataTable = new $DatatableController('role-datatable', {

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
        url: `${__API_CFG__.LOCAL_URL}/dashboard/privileges/roles/datatable`,
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
        data: 'name'
    },
    {
        data: 'display_name'
    },
    {
        data: 'description'
    },
    {
        data: null
    },
    ],

    columnDefs: $DatatableController.generateColumnDefs([{
        targets: [0],
        htmlType: 'selectCheckbox'
    },
    {
        targets: [3], className: 'text-center', customRender: (data, type, row) => {

            if (data) {
                return `<strong>${data}</strong>`;
            } else {
                return `<span class="badge bg-danger text-white">N/A</span>`;
            }
        }
    },
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


    customFunctions: {

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

        _SHOW_ASSIGNED_PERMISSION_: async function (id, endpoint, onSuccess, onError) {
            const modal = new bootstrap.Modal(document.getElementById('role-permission-modal'));
            modal.show();

            const contentEl = document.getElementById('show-role-permission-content');
            contentEl.innerHTML = '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            try {
                const { role, allPermissions, rolePermissions } = await HttpRequest.get(`${endpoint}/${id}`);

                const renderPermission = (perm, isAssigned) => `
                    <div class="badge bg-light text-dark p-2 d-flex align-items-center" data-id="${perm.id}">
                        <span class="me-2 text-primary">${perm.name}</span>
                        <button class="btn btn-sm p-0 ${isAssigned ? 'remove' : 'add'}-permission" data-id="${perm.id}" style="width: 20px; height: 20px;">
                            <i class="bi bi-${isAssigned ? 'x' : 'check-lg'} fs-3" style="transition: color 0.3s;" onmouseover="this.style.color='${isAssigned ? 'red' : 'lightgreen'}'" onmouseout="this.style.color=''"></i>
                        </button>
                    </div>
                `;

                const renderPermissionSet = (title, permissions, isAssigned) => `
                    <div class="col-md-6 mb-4">
                        <h4 class="mb-3">${title}</h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2" id="${isAssigned ? 'assigned' : 'available'}-permissions">
                                    ${permissions.map(perm => renderPermission(perm, isAssigned)).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                contentEl.innerHTML = `
                    <div class="mb-6"><h3 class="card-title badge badge-light-info mb-3">${role.name}</h3></div>
                    <div class="row">
                        ${renderPermissionSet("Assigned Permissions", allPermissions.filter(p => rolePermissions.includes(p.id)), true)}
                        ${renderPermissionSet("Available Permissions", allPermissions.filter(p => !rolePermissions.includes(p.id)), false)}
                    </div>
                `;

                contentEl.addEventListener('click', async (event) => {
                    const btn = event.target.closest('button');
                    if (!btn) return;

                    const permId = btn.dataset.id;
                    const isRemoving = btn.classList.contains('remove-permission');
                    const endpoint = `${__API_CFG__.LOCAL_URL}/dashboard/privileges/roles/${role.id}/permissions${isRemoving ? `/${permId}` : ''}`;

                    // Store original button content and show loading spinner
                    const originalContent = btn.innerHTML;
                    btn.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                    btn.disabled = true;

                    try {
                        await (isRemoving ? HttpRequest.del(endpoint) : HttpRequest.post(endpoint, { permission_id: permId }));
                        Toast.showNotificationToast('', `Permission ${isRemoving ? 'removed' : 'added'} successfully`);

                        const permEl = btn.closest('.badge');
                        const targetContainer = document.getElementById(`${isRemoving ? 'available' : 'assigned'}-permissions`);
                        btn.className = `btn btn-sm p-0 ${isRemoving ? 'add' : 'remove'}-permission`;
                        btn.innerHTML = `<i class="bi bi-${isRemoving ? 'check-lg' : 'x'} fs-3" style="transition: color 0.3s;" onmouseover="this.style.color='${isRemoving ? 'lightgreen' : 'red'}'" onmouseout="this.style.color=''"></i>`;
                        targetContainer.appendChild(permEl);
                    } catch (error) {
                        console.error('Error updating permission', error);
                        Toast.showNotificationToast('Error', 'Failed to update permission. Please try again.');
                        btn.innerHTML = originalContent;
                    } finally {
                        btn.disabled = false;
                    }
                });

                onSuccess({ role, allPermissions, rolePermissions });
            } catch (error) {
                contentEl.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        An error occurred while fetching the data. Please try again.
                    </div>
                `;
                onError(error);
            }
        },

        _EDIT_WITH_MODAL_: async function (id, endpoint, onSuccess, onError) {
            const modalHandler = new $ModalFormFetchController({
                modalId: 'edit-modal',
                endpoint: `${endpoint}`,
                formId: '#edit-role-form',
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


    eventListeners: [{
        event: 'click',
        selector: '.delete-btn',
        handler: function (id, event) {
            this.callCustomFunction(
                '_DELETE_WITH_ALERT_',
                `${__API_CFG__.LOCAL_URL}/dashboard/privileges/roles/${id}`,
                (res) => {
                    if (res.risk) {
                        SweetAlert.error();
                    } else {
                        SweetAlert.deleteSuccess();
                        this.reload();
                    }
                },
                (err) => {
                    console.error('Error deleting user', err);
                }
            );
        }
    },
    {
        event: 'click',
        selector: '.btn-show',
        handler: function (id, event) {
            this.callCustomFunction('_SHOW_ASSIGNED_PERMISSION_', id, `${__API_CFG__.LOCAL_URL}/dashboard/privileges/roles/hasPermission`, (res) => {
                console.log(res)
            }, (err) => {
                console.error('Error editing navbar', err);
            }, (data) => {
                console.log(data)
            });
        }
    },
    {
        event: 'click',
        selector: '.btn-edit',
        handler: function (id, event) {
            this.callCustomFunction('_EDIT_WITH_MODAL_',
                id,
                `${__API_CFG__.LOCAL_URL}/dashboard/privileges/roles/get`,
                (res) => {
                    // console.log(res)
                },
                (err) => {
                    console.error('Error editing navbar', err);
                },
            );
        }
    }
    ],

});


function createRole() {
    FunctionUtility.closeModalWithButton('create-modal', '.close-modal', () => {
        FunctionUtility.clearForm('#create-role-form');
    });

    const createRoleConfig = {
        formSelector: '#create-role-form',
        externalButtonSelector: '#create-role-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/privileges/roles`,
        feedback: true,
        onSuccess: (res) => {
            FunctionUtility.closeModal('create-modal', () => {
                FunctionUtility.clearForm('#create-role-form');
            });
            roleDataTable.reload();
        },
        onError: (err) => {
            console.error('Error adding role', err);
        },
    };

    const form = new $SingleFormPostController(createRoleConfig);
    form.init();
}
createRole();



const editRole = () => {

    FunctionUtility.closeModalWithButton('edit-modal', '.close-modal');

    const editRoleConfig = {
        formSelector: '#edit-role-form',
        externalButtonSelector: '#edit-role-button',
        endpoint: `${__API_CFG__.LOCAL_URL}/dashboard/privileges/roles/edit`,
        feedback: true,
        onSuccess: (res) => {
            Toast.showNotificationToast('', res.message)
            FunctionUtility.closeModal('edit-modal', () => {
                FunctionUtility.clearForm('#edit-role-form');
            });
            roleDataTable.reload();
        },
        onError: (err) => {
            console.error('Error editing navbar', err);
        },
    };

    const form = new $SingleFormPostController(editRoleConfig);
    form.init();
}
editRole();

EOT;
    }
}
