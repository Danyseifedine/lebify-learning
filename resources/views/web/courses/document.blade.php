<!DOCTYPE html>
<html lang="en" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism-okaidia.min.css">
    <link rel="stylesheet" href="{{ asset('css/document.css', true) }}">
    <link rel="stylesheet" href="{{ asset('css/components/navbar.css', true) }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $document->getTitle() }}</title>

</head>
@if ($lang == 'en')
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
@elseif ($lang == 'ar')
    <style>
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
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
            left: 20px;
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
            left: 20px;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
@endif

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="/"><img class="navbar-logo" width="50"
                    src="{{ asset('vendor/img/logo/lebify-logo.svg') }}" alt="Lebify Logo">Lebify</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link language-button"
                        href="{{ route('students.document', ['name' => $course, 'lang' => $lang == 'ar' ? 'en' : 'ar', 'id' => encrypt($document->id), 'order' => encrypt($document->order)]) }}">
                        {{ $lang == 'ar' ? 'اللغة' : 'Language' }}
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper">
        {!! $content !!}
    </div>

    <div class="navigation-footer">
        <div class="navigation-container">
            <div class="navigation-row">
                @if ($prevDocument)
                    <div class="navigation-item">
                        <a class="navigation-link navigation-link-outline"
                            href="{{ route('students.document', ['name' => $course, 'lang' => $lang, 'id' => encrypt($prevDocument->id), 'order' => encrypt($prevDocument->order)]) }}">
                            <i class="fas fa-chevron-left"></i> {{ $lang == 'ar' ? 'الدرس السابق' : 'Previous Lesson' }}
                        </a>
                    </div>
                @endif
                @if ($nextDocument)
                    <div class="navigation-item">
                        <a class="navigation-link navigation-link-primary"
                            href="{{ route('students.document', ['name' => $course, 'lang' => $lang, 'id' => encrypt($nextDocument->id), 'order' => encrypt($nextDocument->order)]) }}">
                            {{ $lang == 'ar' ? 'الدرس اللاحق' : 'Next Lesson' }} <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>

</html>
