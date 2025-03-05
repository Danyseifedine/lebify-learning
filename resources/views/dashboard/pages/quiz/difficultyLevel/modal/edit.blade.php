<form id="edit-difficultyLevel-form" form-id="editForm" http-request
    route="{{ route('dashboard.quiz.difficultylevels.update') }}" identifier="single-form-post-handler" feedback
    close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $difficultyLevel->id }}">

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <input type="text" class="form-control form-control-solid" feedback-id="level-feedback"
                    placeholder="Enter Level" id="level" name="level" value="{{ $difficultyLevel->level }}">
                <div id="level-feedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-solid" feedback-id="name-feedback"
                    placeholder="Enter Name" id="name" name="name" value="{{ $difficultyLevel->name }}">
                <div id="name-feedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

</form>
