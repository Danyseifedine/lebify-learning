import { urlIncludes } from "../../../core/global/utils/functions.js";
import { startQuiz } from "./singlePage.js";

if (!urlIncludes('/attempt')) {
    console.log('start quiz btn found');
    startQuiz(document.querySelector('.start-quiz-btn'));
}
