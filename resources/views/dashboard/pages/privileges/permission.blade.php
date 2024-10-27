@extends('dashboard.layout.dashboard')

@section('title', 'Permission')

<!-- start header -->
@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Permission</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <span class="text-muted text-hover-primary">Dashboard</span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">Table</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
@endsection
<!-- end header -->


@section('content')
    <div class="row g-6 g-xl-9">
        <div class="card">
            <div class="card-body">
                <div class="datatable-body mb-5">
                    <div class="d-flex align-items-center position-relative my-1">

                        <!-- start search -->
                        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                                class="path2"></span></i>
                        <input type="text" data-table-filter="search"
                            class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers" />
                        <!-- end search -->


                        <!-- start column visibility -->
                        <div class="column-visibility-container ms-5">
                            <button class="btn btn-icon btn-sm btn-light" type="button" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="bi bi-gear text-warning"></i>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true">
                                <div class="px-7 py-5">
                                    <div class="fs-5 fw-bolder">Column Settings</div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5" id="column-toggles">
                                    <!-- Column toggles will be dynamically inserted here -->
                                </div>
                            </div>
                        </div>
                        <!-- end column visibility -->
                    </div>
                    <div class="d-flex filter-toolbar flex-wrap align-items-center gap-2 gap-lg-3">


                        <!-- start filter -->
                        <div class="m-0">
                            <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>Filter
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="filter-menu" style="">
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5">
                                    <div class="mb-10">
                                        <label class="form-label fw-semibold">Name:</label>
                                        <div class="d-flex">
                                            <!-- start of option in here -->
                                            <!-- example: -->
                                            <!-- <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                <input class="form-check-input" type="checkbox" name="name_with_4_letter" value="4_letter">
                                                                <span class="form-check-label">4 letter</span>
                                                            </label> -->
                                            <!-- end of option -->
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button data-kt-docs-table-filter="reset" type="reset"
                                            class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-table-reset="filter" data-kt-menu-dismiss="true">Reset</button>
                                        <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true"
                                            data-table-filter="filter">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end filter -->


                        <!-- start create -->
                        <a href="#" class="btn btn-sm create fw-bold btn-primary" data-bs-toggle="modal"
                            data-bs-target="#create-modal">Create</a>
                        <!-- end create -->

                        <div data-table-toggle-base="base">
                            <!-- Your existing toolbar buttons -->
                        </div>
                    </div>

                    <!-- start checkbox toolbar -->
                    <div class="d-flex justify-content-end align-items-center d-none" data-table-toggle-selected="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-table-toggle-select-count="selected_count"></span> Selected
                        </div>
                        <button type="button" class="btn btn-danger" data-table-toggle-action-btn="selected_action">
                            Delete Selected
                        </button>
                    </div>
                    <!-- end checkbox toolbar -->
                </div>


                <!-- start table -->
                <table id="permission-datatable" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input select-all-checkbox" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_datatable_example_1 .row-select-checkbox"
                                        value="1" />
                                </div>
                            </th>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>
                <!-- end table -->
            </div>
        </div>
    </div>

    <!-- start create modal -->
    <div class="modal fade" tabindex="-1" id="create-modal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h3 class="modal-title">Create</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 float-end close-modal">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="create-permission-form">
                        <div class="mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="display_name" class="form-label required">Display Name</label>
                            <input type="text" class="form-control" name="display_name" id="display_name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="description">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn close-modal btn-light">Close</button>
                    <button type="button" with-spinner="true" class="btn btn-primary" id="create-permission-button">
                        <span class="ld-span">Create</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end create modal -->


    <!-- start edit modal -->
    <div class="modal fade" tabindex="-1" id="edit-modal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h3 class="modal-title">Edit</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 float-end close-modal">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="edit-permission-form">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="display_name" class="form-label required">Display Name</label>
                            <input type="text" class="form-control" name="display_name" id="display_name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="description">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn close-modal btn-light">Close</button>
                    <button type="button" with-spinner="true" class="btn btn-primary" id="edit-permission-button">
                        <span class="ld-span">Edit</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end edit modal -->
    <!-- start show modal -->
    <div class="modal fade" tabindex="-1" id="permission-role-modal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Permission Roles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="show-permission-role-content">
                        <div id="loading-spinner" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end show modal -->
@endsection

@push('scripts')
    <script src="{{ asset('js/web/dashboard/privileges/permission.js', true) }}" type="module"></script>
@endpush
