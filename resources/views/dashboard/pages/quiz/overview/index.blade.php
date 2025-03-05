<!---------------------------
    Layout
---------------------------->
@extends('dashboard.layout.index')

<!---------------------------
    Title
---------------------------->
@section('title', 'Quiz')

<!---------------------------
    Toolbar
---------------------------->
@section('toolbar')
    @include('dashboard.common.toolbar', [
        'title' => 'Quiz',
        'currentPage' => 'Quiz Management',
    ])
@endsection

<!---------------------------
    Columns
---------------------------->

@php
    $columns = [
        'title',
        'duration_id',
        'difficulty_level_id',
        'passing_score',
        'is_published',
        'attempts_allowed',
        'actions',
    ];
@endphp

<!---------------------------
    Main Content
---------------------------->
@section('content')
    <x-lebify-table id="quizTable" :columns="$columns">



    @section('filter-options')
        <label class="form-check form-check-sm form-check-custom form-check-solid">
            <select class="form-select form-select-solid" id="filter_duration_id" data-control="select2"
                data-placeholder="Select Duration" name="duration_id">
                <option value="">Select Duration</option>
                @foreach ($durations as $duration)
                    <option value="{{ $duration->id }}">{{ $duration->formatDuration() }}</option>
                @endforeach
            </select>
        </label>
        <label class="form-check form-check-sm form-check-custom mt-3 form-check-solid">
            <select class="form-select form-select-solid" id="filter_difficulty_level_id" data-control="select2"
                data-placeholder="Select Difficulty Level" name="difficulty_level_id">
                <option value="">Select Difficulty Level</option>
                @foreach ($difficulties as $difficulty)
                    <option value="{{ $difficulty->id }}">{{ $difficulty->getDifficultyName() }}</option>
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
<script src="{{ asset('js/dashboard/quiz/overview.js') }}" type="module" defer></script>
@endpush
