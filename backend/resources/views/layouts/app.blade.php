{{-- backend/resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="vi" data-theme="{{ $theme ?? session('theme', 'sang') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <meta name="description" content="@yield('meta_description', '')">
    @stack('schema') {{-- Dữ liệu có cấu trúc schema.org --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#noi-dung">Bỏ qua điều hướng</a>
    <x-site-header /> {{-- Component điều hướng dùng chung --}}

    @if (session('status'))
        <div class="alert alert--info" role="status">{{ session('status') }}</div>
    @endif

    <main id="noi-dung">
        @yield('content')
    </main>

    <x-site-footer /> {{-- Chân trang bắt buộc theo Mục 2.4 Đề thi --}}
</body>
</html>