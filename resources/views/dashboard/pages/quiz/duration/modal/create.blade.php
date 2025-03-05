<form id="create-duration-form" form-id="createForm" http-request route="{{ route('dashboard.quiz.durations.store') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="minutes" class="form-label">Minutes</label>
            </div>
            <input type="number" class="form-control form-control-solid" feedback-id="minutes-feedback"
                placeholder="Enter minutes" name="minutes" id="minutes">
            <div id="minutes-feedback" class="invalid-feedback"></div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
            </div>
            <input type="text" class="form-control form-control-solid" feedback-id="name-feedback"
                placeholder="Enter name" name="name" id="name">
            <div id="name-feedback" class="invalid-feedback"></div>
        </div>
    </div>
</form>
