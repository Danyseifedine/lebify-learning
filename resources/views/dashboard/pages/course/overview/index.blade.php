<!---------------------------
    Layout
---------------------------->
@extends('dashboard.layout.index')

<!---------------------------
    Title
---------------------------->
@section('title', 'Course')

<!---------------------------
    Toolbar
---------------------------->
@section('toolbar')
    @include('dashboard.common.toolbar', [
        'title' => 'Course',
        'currentPage' => 'Course Management',
    ])
@endsection

<!---------------------------
    Columns
---------------------------->

@php
    $columns = ['title', 'views', 'instructor_id', 'duration', 'difficulty_level', 'is_published', 'actions'];
@endphp

<!---------------------------
    Main Content
---------------------------->
@section('content')
    <x-lebify-table id="courseTable" :columns="$columns" {{-- create="true"                         // BY DEFAULT TRUE
    selected="true"                            // BY DEFAULT TRUE
    filter="true"                              // BY DEFAULT TRUE
    showCheckbox="true"                        // BY DEFAULT TRUE
    showSearch="true"                          // BY DEFAULT TRUE
    showColumnVisibility="true"                // BY DEFAULT TRUE
    columnVisibilityPlacement="bottom-end"     // BY DEFAULT BOTTOM-END
    columnSettingsTitle="Column Settingss"     // BY DEFAULT COLUMN SETTINGS
    columnToggles=""                           // BY DEFAULT EMPTY
    tableClass="table-class"                   // BY DEFAULT EMPTY
    searchPlaceholder="Search..."              // BY DEFAULT SEARCH...
    selectedText="Selected"                    // BY DEFAULT SELECTED
    selectedActionButtonClass="btn-success"    // BY DEFAULT btn-danger
    selectedActionButtonText="Delete Selected" // BY DEFAULT DELETE SELECTED
    selectedAction=""                          // BY DEFAULT EMPTY
    --}}>



    @section('filter-options')
        <label class="form-check form-check-sm form-check-custom form-check-solid">
            <select class="form-select form-select-solid" id="filter_instructor_id" data-control="select2"
                data-placeholder="Select Instructor" name="filter_instructor_id">
                <option></option>
                @foreach ($instructors as $instructor)
                    <option value="{{ $instructor['id'] }}">{{ $instructor['name'] }}</option>
                @endforeach
            </select>
        </label>
        <div class="separator border-2 my-3"></div>
        <div class="d-flex gap-3 justify-content-between">
            <label class="form-check mt-3 form-check-sm form-check-custom form-check-solid">
                <input type="checkbox" id="filter_is_published" class="form-check-input" name="is_published">
                <span class="form-check-label">Is Published</span>
            </label>
            <label class="form-check mt-3 form-check-sm form-check-custom form-check-solid">
                <input type="checkbox" id="filter_is_not_published" class="form-check-input" name="is_not_published">
                <span class="form-check-label">Is Not Published</span>
            </label>
        </div>
    @endsection

</x-lebify-table>
@endsection


<!---------------------------
Filter Options
---------------------------->


<!---------------------------
Modals
---------------------------->
<x-lebify-modal modal-id="create-modal" size="lg" submit-form-id="createForm" title="Create"></x-lebify-modal>
<x-lebify-modal modal-id="edit-modal" size="lg" submit-form-id="editForm" title="Edit"></x-lebify-modal>
<x-lebify-modal modal-id="show-modal" size="lg" :show-submit-button="false" title="Show"></x-lebify-modal>

<!---------------------------
Scripts
---------------------------->
@push('scripts')
<script src="{{ asset('js/dashboard/course/overview.js') }}" type="module" defer></script>
@endpush
