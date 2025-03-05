<form id="edit-courseExtention-form" form-id="editForm" http-request
    route="{{ route('dashboard.courses.extensions.update') }}" identifier="single-form-post-handler" feedback close-modal
    success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $courseExtention->id }}">

    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select class="form-select form-select-solid" data-control="select2" feedback-id="course_id-feedback"
            name="course_id" id="course_id">
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ $courseExtention->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="course_id-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">name</label>
        <input type="text" class="form-control form-control-solid" feedback-id="name-feedback" name="name"
            id="name" value="{{ $courseExtention->name }}">
        <div class="invalid-feedback" id="name-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="marketplace_url" class="form-label">Marketplace URL</label>
        <input type="text" class="form-control form-control-solid" feedback-id="marketplace_url-feedback"
            name="marketplace_url" id="marketplace_url" value="{{ $courseExtention->marketplace_url }}">
        <div class="invalid-feedback" id="marketplace_url-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="description_en" class="form-label">Description EN</label>
        <input type="text" class="form-control form-control-solid" feedback-id="description_en-feedback"
            name="description_en" id="description_en" value="{{ $courseExtention->description_en }}">
        <div class="invalid-feedback" id="description_en-feedback"></div>
    </div>
</form>
