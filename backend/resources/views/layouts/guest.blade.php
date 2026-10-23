<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Đặc sản Việt') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script>

        <!-- CSS BẢO VỆ CHỐNG VỠ GIAO DIỆN & TRÀN KÍCH THƯỚC SVG -->
        <style>
            svg {
                display: inline-block !important;
                vertical-align: middle !important;
                max-width: 100% !important;
            }
            /* Map kích thước cứng cho các class Tailwind của SVG */
            svg.w-4, .w-4 > svg { width: 1rem !important; height: 1rem !important; }
            svg.w-5, .w-5 > svg { width: 1.25rem !important; height: 1.25rem !important; }
            svg.w-6, .w-6 > svg { width: 1.5rem !important; height: 1.5rem !important; }
            svg.w-8, .w-8 > svg { width: 2rem !important; height: 2rem !important; }
            svg.w-12, .w-12 > svg { width: 3rem !important; height: 3rem !important; }
            svg.w-16, .w-16 > svg { width: 4rem !important; height: 4rem !important; }
            svg.w-20, .w-20 > svg { width: 5rem !important; height: 5rem !important; }
            
            /* Khống chế khẩn cấp cho bất kỳ SVG nào bị mất class */
            svg:not([width]):not([class*="w-"]) {
                max-width: 48px !important;
                max-height: 48px !important;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 transition-colors duration-200">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
