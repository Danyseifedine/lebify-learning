<form id="create-quizQuestion-form" form-id="createForm" http-request
    route="{{ route('dashboard.quiz.questions.overview.store') }}" identifier="single-form-post-handler" feedback
    close-modal success-toast on-success="RDT">


    <div class="row">
        <div class="col-md-6">
            <label for="quiz_id">Quiz</label>
            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Quiz"
                id="quiz_id" name="quiz_id" feedback-id="quiz_id-feedback">
                <option value="">Select Quiz</option>
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                @endforeach
            </select>
            <div id="quiz_id-feedback" class="invalid-feedback"></div>
        </div>
        <div class="col-md-6">
            <label for="category_id">Category</label>
            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Category"
                id="category_id" name="category_id" feedback-id="category_id-feedback">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <div id="category_id-feedback" class="invalid-feedback"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label for="question">Question</label>
            <textarea class="form-control form-control-solid" id="question" name="question" feedback-id="question-feedback"></textarea>
            <div id="question-feedback" class="invalid-feedback"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label for="type">Type</label>
            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Type"
                id="type" name="type" feedback-id="type-feedback">
                <option value="">Select Type</option>
                <option value="multiple_choice">Multiple Choice</option>
                <option value="true_false">True False</option>
            </select>
            <div id="type-feedback" class="invalid-feedback"></div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label for="order">Order</label>
            <input type="number" class="form-control form-control-solid" id="order" placeholder="Enter Order"
                name="order" feedback-id="order-feedback">
            <div id="order-feedback" class="invalid-feedback"></div>
        </div>
    </div>
</form>
