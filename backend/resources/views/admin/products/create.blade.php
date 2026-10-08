<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Thêm Sản phẩm / Tour mới') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                ← Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                
                <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Tên sản phẩm -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Tên sản phẩm / Tour <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('title')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Danh mục -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Giá gốc & Giá giảm -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700">Giá gốc (VNĐ) <span class="text-rose-500">*</span></label>
                            <input type="number" name="base_price" id="base_price" value="{{ old('base_price') }}" min="0" step="1000" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('base_price')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_price" class="block text-sm font-medium text-gray-700">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" min="0" step="1000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Bỏ trống nếu không giảm giá">
                            @error('discount_price')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sức chứa / Số lượng chỗ -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700">Sức chứa / Số chỗ</label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('capacity')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nổi bật -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                        <label for="is_featured" class="ml-2 text-sm text-gray-700 font-medium">Đánh dấu là Sản phẩm / Tour Nổi Bật</label>
                    </div>

                    <!-- Nút lưu -->
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg text-sm transition">
                            Lưu sản phẩm
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>