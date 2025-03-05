<?php

use App\Http\Controllers\Web\QuizzesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:student|admin'])
    ->controller(QuizzesController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/filter', 'filter')->name('filter');
        Route::get('/{quiz}', 'show')->name('show');
        Route::get('/{quiz}/details', 'details')->name('details');
        Route::get('/{quiz}/start', 'getStartComponent')->name('start');
        Route::get('/{quiz}/attempt/{attempt}', 'started')->name('started');
        Route::post('/{quiz}/attempt/{attempt}/abort', 'abortAttempt')->name('abort-attempt');
        Route::post('/{quiz}/attempt/{attempt}/submit', 'submitAttempt')->name('submit-attempt');
    });
