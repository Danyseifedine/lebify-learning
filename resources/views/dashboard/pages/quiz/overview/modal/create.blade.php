<form id="create-quiz-form" form-id="createForm" http-request route="{{ route('dashboard.quiz.overview.store') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control form-control-solid" feedback-id="title-feedback"
                    name="title" id="title" placeholder="Enter quiz title">
                <div id="title-feedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control form-control-solid" feedback-id="description-feedback" name="description" id="description"
                    rows="3" placeholder="Enter quiz description"></textarea>
                <div id="description-feedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="form-group">
                <label for="duration" class="form-label">Duration</label>
                <select class="form-select form-select-solid" feedback-id="duration-feedback" data-control="select2"
                    data-placeholder="Select duration" name="duration_id" id="duration">
                    <option value="">Select duration</option>
                    @foreach ($durations as $duration)
                        <option value="{{ $duration->id }}">{{ $duration->formatDuration() }}</option>
                    @endforeach
                </select>
                <div id="duration-feedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="difficulty" class="form-label">Difficulty Level</label>
                <select class="form-select form-select-solid" feedback-id="difficulty-feedback" data-control="select2"
                    data-placeholder="Select difficulty" name="difficulty_level_id" id="difficulty">
                    <option value="">Select difficulty</option>
                    @foreach ($difficulties as $difficulty)
                        <option value="{{ $difficulty->id }}">{{ $difficulty->getDifficultyName() }}
                        </option>
                    @endforeach
                </select>
                <div id="difficulty-feedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="passing_score" class="form-label">Passing Score (%)</label>
                <input type="number" class="form-control form-control-solid" feedback-id="passing-score-feedback"
                    name="passing_score" id="passing_score" min="0" max="100"
                    placeholder="Enter passing score">
                <div id="passing-score-feedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="attempts_allowed" class="form-label">Attempts Allowed</label>
                <input type="number" class="form-control form-control-solid" feedback-id="attempts-allowed-feedback"
                    name="attempts_allowed" id="attempts_allowed" min="1" placeholder="Enter allowed attempts">
                <div id="attempts-allowed-feedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

</form>
