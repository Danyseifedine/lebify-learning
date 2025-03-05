@extends('web.layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/web/quiz/quiz-detail.css', true) }}">
@endpush

@section('content')
    <div class="page-content">
        @include('web.quizzes.partials.quiz-details')
    </div>

    @push('scripts')
        <script src="{{ asset('js/web/quiz/quiz.js', true) }}" type="module"></script>
        {{-- <script src="{{ asset('js/web/quiz/singlePage.js', true) }}" type="module"></script> --}}
    @endpush
@endsection
