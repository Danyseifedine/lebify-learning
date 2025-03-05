@extends('web.layouts.user')

@section('content')
    <div class="page-content">
        <div class="quiz-started-container">
            @include('web.quizzes.partials.started-quiz')
        </div>
    </div>

    @push('scripts')
        {{-- <script src="{{ asset('js/web/quiz/quiz.js', true) }}" type="module"></script> --}}
    @endpush
@endsection
