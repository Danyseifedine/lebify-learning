<!---------------------------
    Layout
---------------------------->
@extends('dashboard.layout.index')

<!---------------------------
    Title
---------------------------->
@section('title', 'Duration')

<!---------------------------
    Toolbar
---------------------------->
@section('toolbar')
    @include('dashboard.common.toolbar', [
        'title' => 'Duration',
        'currentPage' => 'Duration Management',
    ])
@endsection

<!---------------------------
    Columns
---------------------------->

@php
    $columns = ['minutes', 'name', 'actions'];
@endphp

<!---------------------------
    Main Content
---------------------------->
@section('content')
    <x-lebify-table id="durationTable" :columns="$columns" :filter="false">


        {{-- start Filter Options --}}

    @section('filter-options')


        {{--  Filters... --}}

        {{-- example form field --}}
        {{-- <label class="form-check form-check-sm form-check-custom form-check-solid">
        <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Status" name="status">
            <option></option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </label> --}}
    @endsection
    {{-- End Filter Options --}}

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
<script src="{{ asset('js/dashboard/quiz/duration.js') }}" type="module" defer></script>
@endpush
