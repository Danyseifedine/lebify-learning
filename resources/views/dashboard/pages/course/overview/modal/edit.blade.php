<form id="edit-course-form" form-id="editForm" http-request route="{{ route('dashboard.courses.update') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $course->id }}">


    <div class="mb-3">
        <label for="title" class="form-label">title</label>
        <input type="text" class="form-control form-control-solid" value="{{ $course->title }}"
            placeholder="Enter title" name="title" feedback-id="title-feedback" id="title">
        <div class="invalid-feedback" id="title-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Instructor name</label>
        <select class="form-select form-select-solid" name="instructor_id" data-control="select2"
            placeholder="Select Instructor" feedback-id="instructor_id-feedback" id="instructor_id">
            <option value="">Select Instructor</option>
            @foreach ($instructors as $instructor)
                <option value="{{ $instructor->id }}" {{ $course->instructor_id == $instructor->id ? 'selected' : '' }}>
                    {{ $instructor->user->name }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="instructor_id-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="description_en" class="form-label">description en</label>
        <textarea class="form-control form-control-solid" placeholder="Enter description en" name="description_en"
            feedback-id="description_en-feedback" id="description_en">{{ $course->description_en }}</textarea>
        <div class="invalid-feedback" id="description_en-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="difficulty_level" class="form-label">difficulty level</label>
        <select class="form-select form-select-solid" data-control="select2" name="difficulty_level"
            feedback-id="difficulty_level-feedback" id="difficulty_level">
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ $course->difficulty_level == $i ? 'selected' : '' }}>
                    {{ $i }}</option>
            @endfor
        </select>
        <div class="invalid-feedback" id="difficulty_level-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">image</label>
        <input type="file" class="form-control form-control-solid" placeholder="Enter image" name="image"
            feedback-id="image-feedback" id="image">
        <div class="invalid-feedback" id="image-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="duration" class="form-label">duration</label>
        <input type="text" class="form-control form-control-solid" value="{{ $course->duration }}"
            placeholder="Enter duration" name="duration" feedback-id="duration-feedback" id="duration">
        <div class="invalid-feedback" id="duration-feedback"></div>
    </div>

</form>
