<form id="create-courseExtention-form" form-id="createForm" http-request
    route="{{ route('dashboard.courses.extensions.store') }}" identifier="single-form-post-handler" feedback close-modal
    success-toast on-success="RDT">

    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select class="form-select form-select-solid" feedback-id="course_id-feedback" data-control="select2"
            name="course_id" id="course_id">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="course_id-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter Name" name="name"
            feedback-id="name-feedback" id="name">
        <div class="invalid-feedback" id="name-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="marketplace_url" class="form-label">Marketplace URL</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter Marketplace URL"
            name="marketplace_url" feedback-id="marketplace_url-feedback" id="marketplace_url">
        <div class="invalid-feedback" id="marketplace_url-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="description_en" class="form-label">Description EN</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter Description EN"
            name="description_en" feedback-id="description_en-feedback" id="description_en">
        <div class="invalid-feedback" id="description_en-feedback"></div>
    </div>

</form>
