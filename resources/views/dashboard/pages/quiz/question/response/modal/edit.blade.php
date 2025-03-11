<form id="edit-quizResponse-form" form-id="editForm" http-request route="{{ route('dashboard.quizresponses.update') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $quizResponse->id }}">

     {{-- form fields ... --}}

     {{-- example form field --}}
    {{-- <div class="mb-3">
        <label for="name" class="form-label">name</label>
        <input type="text" value="{{ $quizResponse->name }}" feedback-id="name-feedback" class="form-control form-control-solid"
            name="name" id="name">
        <div id="name-feedback" class="invalid-feedback"></div>
    </div> --}}
</form>
