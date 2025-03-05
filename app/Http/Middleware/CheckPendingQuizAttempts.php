<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\QuizAttempt;

class CheckPendingQuizAttempts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !$this->isQuizRoute($request->route()->getName())) {
            QuizAttempt::abortPendingAttempts();
        }

        return $next($request);
    }

    private function isQuizRoute($routeName)
    {
        return in_array($routeName, [
            'quizzes.start',
            'quizzes.abort-attempt',
            'quizzes.show',
            'quizzes.started',
        ]);
    }
}
