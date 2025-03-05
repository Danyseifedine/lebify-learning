<form id="edit-courseResource-form" form-id="editForm" http-request
    route="{{ route('dashboard.courses.resources.update') }}" identifier="single-form-post-handler" feedback close-modal
    success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $courseResource->id }}">

    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select class="form-select form-select-solid" name="course_id" id="course_id" data-control="select2"
            data-placeholder="Select a Course" feedback-id="course_id-feedback">
            <option value="">Select a Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ $courseResource->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}</option>
            @endforeach
        </select>
        <div id="course_id-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="title_en" class="form-label">Title</label>
        <input type="text" class="form-control form-control-solid" name="title_en" id="title_en"
            feedback-id="title_en-feedback" value="{{ $courseResource->title_en }}">
        <div id="title_en-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="description_en" class="form-label">Description (En)</label>
        <textarea class="form-control form-control-solid" name="description_en" id="description_en"
            feedback-id="description_en-feedback">{{ $courseResource->description_en }}</textarea>
        <div id="description_en-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="url" class="form-label">Url</label>
        <input type="text" class="form-control form-control-solid" name="url" id="url"
            feedback-id="url-feedback" value="{{ $courseResource->url }}">
        <div id="url-feedback" class="invalid-feedback"></div>
    </div>
</form>
