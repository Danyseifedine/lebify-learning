<form id="create-courseRelatedChannel-form" form-id="createForm" http-request
    route="{{ route('dashboard.courses.relatedChannels.store') }}" identifier="single-form-post-handler" feedback
    close-modal success-toast on-success="RDT">

    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select class="form-control form-control-solid" name="course_id" id="course_id" data-control="select2"
            data-placeholder="Select Course" feedback-id="course_id-feedback">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
        <div id="course_id-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="channel_name" class="form-label">Channel Name</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter Channel Name"
            name="channel_name" id="channel_name" feedback-id="channel_name-feedback">
        <div id="channel_name-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="url" class="form-label">Url</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter Url" name="url"
            id="url" feedback-id="url-feedback">
        <div id="url-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control form-control-solid" placeholder="Upload Image" name="image"
            id="image" feedback-id="image-feedback">
        <div id="image-feedback" class="invalid-feedback"></div>
    </div>

</form>
