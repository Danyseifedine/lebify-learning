<div class="card-body">
    <h5 class="card-title text-center">Quiz Performance</h5>
    <div class="graphs-container">
        <!-- Placeholder for graphs -->
        @if ($attempts->count() > 0)
            <canvas id="quiz-status-chart" data-chart-data="{{ json_encode($scoreStatistics) }}"></canvas>
        @else
            <div class="text-center" style="padding-top: 100px;">
                <img src="{{ asset('core/vendor/img/icon/trend.svg', true) }}" class="mw-250px mb-7" alt="">
                <p>No data available</p>
            </div>
        @endif
    </div>
</div>
