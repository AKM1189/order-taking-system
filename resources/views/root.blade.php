<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
        @spladeHead
        @vite('resources/js/app.js')
        @vite('resources/js/bootstrap.js')
    </head>
    <body class="font-sans antialiased">
        @splade

        <script src="{{ asset('/bootstrap/js/bootstrap.js')}}"></script>
    </body>
</html>
