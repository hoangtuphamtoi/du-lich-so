<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Đặc sản Việt') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script>

        <!-- CSS CỐ ĐỊNH KÍCH THƯỚC CHO TẤT CẢ ICON SVG (CHỐNG VỠ GIAO DIỆN ABSOLUTE) -->
        <style>
            svg {
                display: inline-block !important;
                vertical-align: middle !important;
                max-width: 100% !important;
            }
            /* Tự động gán kích thước chuẩn cho các class Tailwind của SVG ngay cả khi mất CSS */
            svg.w-4, .w-4 > svg { width: 1rem !important; height: 1rem !important; }
            svg.w-5, .w-5 > svg { width: 1.25rem !important; height: 1.25rem !important; }
            svg.w-6, .w-6 > svg { width: 1.5rem !important; height: 1.5rem !important; }
            svg.w-7, .w-7 > svg { width: 1.75rem !important; height: 1.75rem !important; }
            svg.w-8, .w-8 > svg { width: 2rem !important; height: 2rem !important; }
            svg.w-10, .w-10 > svg { width: 2.5rem !important; height: 2.5rem !important; }
            svg.w-12, .w-12 > svg { width: 3rem !important; height: 3rem !important; }
            svg.w-16, .w-16 > svg { width: 4rem !important; height: 4rem !important; }
            svg.w-20, .w-20 > svg { width: 5rem !important; height: 5rem !important; }
            
            /* Khống chế khẩn cấp cho bất kỳ SVG nào không khai báo chiều rộng */
            svg:not([width]):not([class*="w-"]) {
                max-width: 32px !important;
                max-height: 32px !important;
            }
        </style>

        <!-- SCRIPT XỬ LÝ DARK MODE -->
        <script>
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Alpine.js CDN -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts & Styles qua Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-200">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            function toggleDarkMode() {
                document.documentElement.classList.toggle('dark');
                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                } else {
                    localStorage.setItem('theme', 'light');
                }
            }
        </script>
    </body>
</html>
