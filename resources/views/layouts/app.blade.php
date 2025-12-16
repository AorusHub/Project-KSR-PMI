<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'KSR PMI UNHAS')</title>
        <link rel="icon" type="image/png" sizes="30x64" href="{{ asset('images/logo-ksr-pmi.png') }}">

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        
        @stack('styles')
    </head>
    <body class="bg-gray-50">
        {{-- Gunakan navbar yang sama --}}
        @include('components.navbar')

        <main> 
            @yield('content')
        </main>

        @include('components.footer')

        @stack('scripts')
    </body>
</html>