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
    </style>
</head>

<body>
    <a href="{{ url()->previous() }}" class="back-button">{{ __('common.back') }}</a>
    {!! $content !!}
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>

</html>
