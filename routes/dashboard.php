<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Pages\Course\CourseController;
use App\Http\Controllers\Dashboard\Pages\Course\CourseExtentionController;
use App\Http\Controllers\Dashboard\Pages\User\InstructorController;
use App\Http\Controllers\Dashboard\Pages\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Pages\Course\CourseLessonController;
use App\Http\Controllers\Dashboard\Pages\Course\CourseRelatedChannelController;
use App\Http\Controllers\Dashboard\Pages\Course\CourseResourceController;
use App\Http\Controllers\Dashboard\Pages\Course\CourseDocumentController;
use App\Http\Controllers\Dashboard\Pages\Quiz\DurationController;
use App\Http\Controllers\Dashboard\Pages\Quiz\DifficultyLevelController;
use App\Http\Controllers\Dashboard\Pages\Quiz\QuestionCategoryController;
use App\Http\Controllers\Dashboard\Pages\Quiz\QuizController;
use App\Http\Controllers\Dashboard\Pages\Quiz\QuizAnswerController;
use App\Http\Controllers\Dashboard\Pages\Quiz\QuizQuestionController;
// Datatable Controllers
use App\Http\Controllers\Dashboard\Pages\QuizAttemptController;
use App\Http\Controllers\Dashboard\Pages\QuizResponseController;




Route::prefix('dashboard')->name('dashboard.')->group(function () {

    // Dashboard routes
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });


    // ======================================================================= //
    // ====================== START USER DATATABLE =========================== //
    // ======================================================================= //

    Route::controller(UserController::class)->prefix("users")->name("users.")->group(function () {
        Route::post('/update', 'update')->name('update');
        Route::get('/{id}/show', 'show')->name('show');
        Route::get('/datatable', 'datatable')->name('datatable');
        Route::patch('/{id}/status', 'status')->name('status');
        Route::patch('/{id}/verify', 'verify')->name('verify');
        Route::patch('/{id}/unverify', 'unverify')->name('unverify');

        Route::controller(InstructorController::class)
            ->prefix('instructors')
            ->name('instructors.')
            ->group(function () {
                Route::post('/update', 'update')->name('update');
                Route::get('/{id}/show', 'show')->name('show');
                Route::get('/datatable', 'datatable')->name('datatable');
            });

        Route::resource('instructors', InstructorController::class)
            ->except(['show', 'update']);
    });
    Route::resource('users', UserController::class)->except(['show', 'update']);

    // ======================================================================= //
    // ====================== END USER DATATABLE ============================= //
    // ======================================================================= //

    // ======================================================================= //
    // ==================== START COURSE DATATABLE =========================== //
    // ======================================================================= //

    Route::controller(CourseController::class)
        ->prefix('courses')
        ->name('courses.')
        ->group(function () {
            Route::post('/update', 'update')->name('update');
            Route::get('/{id}/show', 'show')->name('show');
            Route::get('/datatable', 'datatable')->name('datatable');
            Route::patch('/{id}/status', 'changeStatus')->name('status');
            Route::get('/{id}/preview', 'preview')->name('preview');

            // start Course Extensions
            Route::controller(CourseExtentionController::class)
                ->prefix('extensions')
                ->name('extensions.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                });

            Route::resource('extensions', CourseExtentionController::class)
                ->except(['show', 'update']);
            // end Course Extensions

            // start Course Resources
            Route::controller(CourseResourceController::class)
                ->prefix('resources')
                ->name('resources.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                    Route::patch('/{id}/status', 'status')->name('status');
                });

            Route::resource('resources', CourseResourceController::class)
                ->except(['show', 'update']);
            // end Course Resources

            // start Course Related Channels
            Route::controller(CourseRelatedChannelController::class)
                ->prefix('relatedChannels')
                ->name('relatedChannels.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                    Route::patch('/{id}/status', 'status')->name('status');
                });

            Route::resource('relatedChannels', CourseRelatedChannelController::class)
                ->except(['show', 'update']);
            // end Course Related Channels

            // start Course Lessons
            Route::controller(CourseLessonController::class)
                ->prefix('lessons')
                ->name('lessons.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                    Route::patch('/{id}/status', 'status')->name('status');
                });

            Route::resource('lessons', CourseLessonController::class)
                ->except(['show', 'update']);
            // end Course Lessons

            // start Course Documents
            Route::controller(CourseDocumentController::class)
                ->prefix('documents')
                ->name('documents.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                });

            Route::resource('documents', CourseDocumentController::class)
                ->except(['show', 'update']);
            // end Course Documents
        });

    Route::resource('courses', CourseController::class)
        ->except(['show', 'update']);

    // ======================================================================= //
    // ====================== END COURSE DATATABLE =========================== //
    // ======================================================================= //

    // ======================================================================= //
    // ====================== START QUIZ DATATABLE =========================== //
    // ======================================================================= //

    Route::prefix('quiz')->name('quiz.')->group(function () {
        // Quiz Overview routes
        Route::controller(QuizController::class)
            ->prefix('overview')
            ->name('overview.')
            ->group(function () {
                Route::post('/update', 'update')->name('update');
                Route::get('/{id}/show', 'show')->name('show');
                Route::get('/datatable', 'datatable')->name('datatable');
                Route::patch('/{id}/status', 'status')->name('status');
            });

        Route::resource('overview', QuizController::class)
            ->except(['show', 'update']);

        // Questions and Categories (new nested structure)
        Route::prefix('questions')->name('questions.')->group(function () {

            Route::controller(QuizQuestionController::class)
                ->prefix('overview')
                ->name('overview.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                });

            Route::resource('overview', QuizQuestionController::class)
                ->except(['show', 'update']);

            // start Quiz Answers
            Route::controller(QuizAnswerController::class)
                ->prefix('answers')
                ->name('answers.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                    Route::patch('/{id}/is-correct', 'isCorrect')->name('isCorrect');
                });

            Route::resource('answers', QuizAnswerController::class)
                ->except(['show', 'update']);
            // end Quiz Answers

            //start Question Categories
            Route::controller(QuestionCategoryController::class)
                ->prefix('categories')
                ->name('categories.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                });

            Route::resource('categories', QuestionCategoryController::class)
                ->except(['show', 'update']);
            //end Question Categories

            // start Quiz Responses
            Route::controller(QuizResponseController::class)
                ->prefix('responses')
                ->name('responses.')
                ->group(function () {
                    Route::post('/update', 'update')->name('update');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/datatable', 'datatable')->name('datatable');
                });

            Route::resource('responses', QuizResponseController::class)
                ->except(['show', 'update']);
            // end Quiz Responses
        });

        // start Duration
        Route::controller(DurationController::class)
            ->prefix('durations')
            ->name('durations.')
            ->group(function () {
                Route::post('/update', 'update')->name('update');
                Route::get('/{id}/show', 'show')->name('show');
                Route::get('/datatable', 'datatable')->name('datatable');
            });

        Route::resource('durations', DurationController::class)
            ->except(['show', 'update']);
        // end Duration

        // start Difficulty Level
        Route::controller(DifficultyLevelController::class)
            ->prefix('difficultylevels')
            ->name('difficultylevels.')
            ->group(function () {
                Route::post('/update', 'update')->name('update');
                Route::get('/{id}/show', 'show')->name('show');
                Route::get('/datatable', 'datatable')->name('datatable');
            });

        Route::resource('difficultylevels', DifficultyLevelController::class)
            ->except(['show', 'update']);
        // end Difficulty Level

        // start Quiz Attempts
        Route::controller(QuizAttemptController::class)
            ->prefix('attempts')
            ->name('attempts.')
            ->group(function () {
                Route::post('/update', 'update')->name('update');
                Route::get('/{id}/show', 'show')->name('show');
                Route::get('/datatable', 'datatable')->name('datatable');
            });

        Route::resource('attempts', QuizAttemptController::class)
            ->except(['show', 'update']);
        // end Quiz Attempts
    });

    // ======================================================================= //
    // ======================= END QUIZ DATATABLE ============================ //
    // ======================================================================= //



});
