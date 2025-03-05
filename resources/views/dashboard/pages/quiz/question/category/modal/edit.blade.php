<form id="edit-questionCategory-form" form-id="editForm" http-request
    route="{{ route('dashboard.quiz.questions.categories.update') }}" identifier="single-form-post-handler" feedback
    close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $questionCategory->id }}">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-solid" name="name" id="name"
                    placeholder="Enter Category Name" feedback-id="name-feedback" value="{{ $questionCategory->name }}">
                <div id="name-feedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>
</form>
