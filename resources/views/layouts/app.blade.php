<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Dashboard - KSR PMI UNHAS' }}</title>
        
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