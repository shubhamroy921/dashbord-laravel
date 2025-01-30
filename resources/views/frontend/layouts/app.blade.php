<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Welcome to Our Store!')</title>
    @if (isset($footer))
        <link rel="icon" href="{{ $footer->firstWhere('id', 29)->value }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('assets/default/favicon.webp') }}" type="image/x-icon">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body class="bg-gray-100">
    @include('frontend.layouts.header.header')
    @yield('content')
    @include('frontend.layouts.footer.footer')

    @stack('scripts') <!-- Allow individual pages to push additional scripts -->
</body>

</html>
