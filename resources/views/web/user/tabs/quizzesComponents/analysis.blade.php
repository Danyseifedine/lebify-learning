<div class="card-body">
    <h5 class="card-title">{{ __('common.quiz_status') }}</h5>
    <div class="graphs-container">
        <!-- Placeholder for graphs -->
        <canvas id="quiz-status-chart" class="mh-600px" data-chart-data="{{ json_encode($scoreStatistics) }}"></canvas>
    </div>
</div>
