<form id="create-courseLesson-form" form-id="createForm" http-request
    route="{{ route('dashboard.courses.lessons.store') }}" identifier="single-form-post-handler" feedback close-modal
    success-toast on-success="RDT">

    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select class="form-select form-select-solid" name="course_id" placeholder="Select Course"
            feedback-id="course_id-feedback" data-control="select2" id="course_id">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
        <div id="course_id-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">title</label>
        <input type="text" class="form-control form-control-solid" feedback-id="title-feedback" name="title"
            id="title" placeholder="Enter Title">
        <div id="title-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="video_url" class="form-label">video_url</label>
        <input type="text" class="form-control form-control-solid" feedback-id="video_url-feedback" name="video_url"
            id="video_url" placeholder="Enter Video URL">
        <div id="video_url-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="language" class="form-label">Language</label>
        <select class="form-select form-select-solid" feedback-id="language-feedback" data-control="select2"
            name="language" id="language">
            <option value="">Select Language</option>
            <option value="0">Arabic</option>
            <option value="1">English</option>
        </select>
        <div id="language-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="description_en" class="form-label">Description</label>
        <textarea class="form-control form-control-solid" feedback-id="description_en-feedback" placeholder="Enter Description"
            name="description_en" id="description_en"></textarea>
        <div id="description_en-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="duration" class="form-label">Duration</label>
        <input type="text" class="form-control form-control-solid" feedback-id="duration-feedback"
            placeholder="Enter Duration" name="duration" id="duration">
        <div id="duration-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail</label>
        <input type="file" class="form-control form-control-solid" feedback-id="thumbnail-feedback" name="thumbnail"
            id="thumbnail">
        <div id="thumbnail-feedback" class="invalid-feedback"></div>
    </div>

</form>
