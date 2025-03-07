import { SimpleWatcher } from '../../../core/global/advanced/advanced.js'
import { LOCAL_URL } from '../../../core/global/config/app-config.js';
import { initializeQuizStatusChart } from '../charts/index.js'

new SimpleWatcher({
    targetSelector: 'body',
    watchFor: '.content-container',
    onElementFound: async () => {
        await getData()
        initializeQuizStatusChart()
    }
});


async function getData() {
    const recentAttemptsContainer = document.querySelector('.recent-attempts-container');
    const analysisContainer = document.querySelector('.analysis-container');
    recentAttemptsContainer.innerHTML = `
    <div class="card-body">
        <div class="loading d-flex justify-content-center align-items-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="quiz-attempts-container" style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
        </div>
    </div>
    `;

    analysisContainer.innerHTML = `
    <div class="card-body">
        <div class="loading d-flex justify-content-center align-items-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="quiz-attempts-container" style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
        </div>
    </div>
    `;
    const response = await axios.get(`${LOCAL_URL}/student/profile/quizzes`)
    console.log(response)

    recentAttemptsContainer.innerHTML = response.data.html;
    analysisContainer.innerHTML = response.data.analysis;
}

