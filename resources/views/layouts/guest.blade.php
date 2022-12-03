<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Font Awesome Link Icon -->
        <link href="{{ url('fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

        <style>
            #cent{
                margin: auto;
                width: 50%;
            }
            body{
                background-color: #212529;
            }
        </style>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        @toastr_css
    </head>
    <body>
        <div id="cent" class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
@jquery
@toastr_js
@toastr_render
</html>
