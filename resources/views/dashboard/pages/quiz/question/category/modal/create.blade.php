<form id="create-questionCategory-form" form-id="createForm" http-request
    route="{{ route('dashboard.quiz.questions.categories.store') }}" identifier="single-form-post-handler" feedback
    close-modal success-toast on-success="RDT">

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-solid" name="name" id="name"
                    placeholder="Enter Category Name" feedback-id="name-feedback">
                <div id="name-feedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

</form>
