<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Surf Forecast' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white text-gray-900" style="font-family: 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', 'Hiragino Kaku Gothic Pro', 'Yu Gothic', 'Meiryo', sans-serif;">
        <header class="border-b fixed top-0 left-0 right-0 z-50" style="background-color: #003057;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="text-lg font-semibold text-white">surf forecast</a>
                <nav class="flex items-center gap-6 text-sm text-white">
                    <a href="{{ route('index') }}" class="hover:text-gray-200">サーフスポットを探す</a>
                </nav>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        @stack('scripts')
    </body>
    </html>


