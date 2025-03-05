<form id="edit-quizAnswer-form" form-id="editForm" http-request
    route="{{ route('dashboard.quiz.questions.answers.update') }}" identifier="single-form-post-handler" feedback
    close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $quizAnswer->id }}">

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="question_id" class="form-label">Question</label>
                <select class="form-select form-select-solid" id="question_id" feedback-id="question_id-feedback"
                    data-control="select2" data-placeholder="Select Question" name="question_id">
                    <option value="">Select Question</option>
                    @foreach ($quizQuestion as $question)
                        <option value="{{ $question->id }}" {{ $quizAnswer->question_id == $question->id ? 'selected' : '' }}>
                            {{ $question->question }}</option>
                    @endforeach
                </select>
                <div id="question_id-feedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="answer" class="form-label">Answer</label>
                <input type="text" class="form-control form-control-solid" id="answer"
                    feedback-id="answer-feedback" name="answer" value="{{ $quizAnswer->answer }}">
                <div id="answer-feedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 d-flex align-items-center gap-3">
                <label for="is_correct pt-2" class="form-label">Is Correct</label>
                <input type="checkbox" class="form-check-input form-check-solid" value="1" placeholder="Is Correct"
                    id="is_correct" name="is_correct" {{ $quizAnswer->is_correct ? 'checked' : '' }}>
            </div>
        </div>
    </div>
</form>
