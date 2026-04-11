<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Hall Allotment Application')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- add font awesome cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    @include('layouts.nav')
    @yield('content')
    @include('layouts.footer')

    @yield('scripts')
</body>

</html>
