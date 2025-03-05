<form id="create-courseDocument-form" form-id="createForm" http-request
    route="{{ route('dashboard.courses.documents.store') }}" identifier="single-form-post-handler" feedback close-modal
    success-toast on-success="RDT">

    <div class="mb-3">
        <label for="course_id" class="form-label">course</label>
        <select class="form-select form-select-solid" name="course_id" data-control="select2"
            feedback-id="course_id-feedback" id="course_id">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
        <div id="course_id-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="title_en" class="form-label">title</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter a title"
            feedback-id="title_en-feedback" name="title_en" id="title_en">
        <div id="title_en-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="content_en" class="form-label">Content English</label>
        <div id="editor_en" class="ace-editor"></div>
        <textarea name="content_en" id="content_en" placeholder="Enter a content" feedback-id="content_en-feedback"
            style="display: none;"></textarea>
        <div id="content_en-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="content_ar" class="form-label">Content Arabic</label>
        <div id="editor_ar" class="ace-editor"></div>
        <textarea name="content_ar" id="content_ar" placeholder="Enter a content" feedback-id="content_ar-feedback"
            style="display: none;"></textarea>
        <div id="content_ar-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="order" class="form-label">order</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter a order"
            feedback-id="order-feedback" name="order" id="order">
        <div id="order-feedback" class="invalid-feedback"></div>
    </div>

</form>
