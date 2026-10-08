{{-- backend/resources/views/components/site-header.blade.php --}}
<header class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="font-bold text-xl text-blue-600">
            {{ config('app.name', 'Du Lịch Số') }}
        </a>
        <nav aria-label="Điều hướng chính" class="flex items-center space-x-6">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 font-medium">Trang chủ</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Đăng xuất</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Đăng nhập</a>
            @endauth
        </nav>
    </div>
</header>