<form id="edit-courseDocument-form" form-id="editForm" http-request
    route="{{ route('dashboard.courses.documents.update') }}" identifier="single-form-post-handler" feedback close-modal
    success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $courseDocument->id }}">

    <div class="mb-3">
        <label for="course_id" class="form-label">course</label>
        <select class="form-select form-select-solid" name="course_id" data-control="select2"
            feedback-id="course_id-feedback" id="course_id">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ $courseDocument->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}</option>
            @endforeach
        </select>
        <div id="course_id-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="title_en" class="form-label">title</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter a title"
            feedback-id="title_en-feedback" name="title_en" id="title_en" value="{{ $courseDocument->title_en }}">
        <div id="title_en-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="content_en" class="form-label">Content English</label>
        <div id="edit-editor_en" class="ace-editor"></div>
        <textarea name="content_en" id="edit-content_en" placeholder="Enter a content" feedback-id="edit-content_en-feedback"
            style="display: none;"></textarea>
        <div id="edit-content_en-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="content_ar" class="form-label">Content Arabic</label>
        <div id="edit-editor_ar" class="ace-editor"></div>
        <textarea name="content_ar" id="edit-content_ar" placeholder="Enter a content" feedback-id="edit-content_ar-feedback"
            style="display: none;"></textarea>
        <div id="edit-content_ar-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="order" class="form-label">order</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter a order"
            feedback-id="order-feedback" name="order" id="order" value="{{ $courseDocument->order }}">
        <div id="order-feedback" class="invalid-feedback"></div>
    </div>

</form>
