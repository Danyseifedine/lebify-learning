<!DOCTYPE html>
<html lang="en" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism-okaidia.min.css">
    <link rel="stylesheet" href="{{ asset('css/document.css') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $document->getTitle() }}</title>
    <style>
        .back-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            z-index: 1000;
        }

        .next-button {
            position: fixed;
            top: 70px;
            right: 20px;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            z-index: 1000;
        }

        .change-language-button {
            position: fixed;
            top: 120px;
            right: 20px;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
</head>

<body>

    {!! $content !!}
    <div class="d-flex mt-5 align-items-center gap-5 justify-content-end">
        @if ($document->order > 1)
            <a href="{{ route('students.document', ['name' => $course, 'lang' => $lang, 'id' => $document->id, 'order' => $document->order - 1]) }}"
                class="btn logo-border back-button">
                {{ __('common.previous_lesson') }}
            </a>
        @endif
        @if ($document->order < $document->course->documents->count())
            <a href="{{ route('students.document', ['name' => $course, 'lang' => $lang, 'id' => $document->id, 'order' => $document->order + 1]) }}"
                class="btn logo-border next-button">
                {{ __('common.next_lesson') }}
            </a>
        @endif
        <a href="{{ route('students.document', ['name' => $course, 'lang' => $lang == 'ar' ? 'en' : 'ar', 'id' => $document->id, 'order' => $document->order]) }}"
            class="btn logo-border change-language-button">
            {{ __('common.change_language') }}
        </a>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>

</html>
