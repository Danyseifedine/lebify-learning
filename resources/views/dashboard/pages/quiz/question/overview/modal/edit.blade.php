<form id="edit-quizQuestion-form" form-id="editForm" http-request
    route="{{ route('dashboard.quiz.questions.overview.update') }}" identifier="single-form-post-handler" feedback
    close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $quizQuestion->id }}">


    <div class="row">
        <div class="col-md-6">
            <label for="quiz_id">Quiz</label>
            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Quiz"
                id="quiz_id" name="quiz_id" feedback-id="quiz_id-feedback">
                <option value="">Select Quiz</option>
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}" {{ $quizQuestion->quiz_id == $quiz->id ? 'selected' : '' }}>
                        {{ $quiz->title }}</option>
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
                    <option value="{{ $category->id }}"
                        {{ $quizQuestion->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            <div id="category_id-feedback" class="invalid-feedback"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label for="question">Question</label>
            <textarea class="form-control form-control-solid" id="question" name="question" feedback-id="question-feedback">{{ $quizQuestion->question }}</textarea>
            <div id="question-feedback" class="invalid-feedback"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label for="type">Type</label>
            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Type"
                id="type" name="type" feedback-id="type-feedback">
                <option value="">Select Type</option>
                <option value="multiple_choice" {{ $quizQuestion->type == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                <option value="true_false" {{ $quizQuestion->type == 'true_false' ? 'selected' : '' }}>True False</option>
            </select>
            <div id="type-feedback" class="invalid-feedback"></div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label for="order">Order</label>
            <input type="number" class="form-control form-control-solid" id="order" placeholder="Enter Order"
                name="order" feedback-id="order-feedback" value="{{ $quizQuestion->order }}">
            <div id="order-feedback" class="invalid-feedback"></div>
        </div>
    </div>
</form>
