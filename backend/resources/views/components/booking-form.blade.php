@props(['product', 'availabilities' => []])

{{-- Biểu mẫu đặt chỗ: Bắt buộc có @csrf --}}
<form method="POST" action="{{ route('bookings.store') }}" novalidate>
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="mb-4">
        <label for="ngay" class="block font-medium">Ngày khởi hành</label>
        <input id="ngay" type="date" name="service_date" required
               min="{{ now()->addDay()->toDateString() }}"
               value="{{ old('service_date') }}"
               class="border rounded p-2 w-full">
        @error('service_date')
            <p class="text-red-500 text-sm mt-1" role="alert">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="pax" class="block font-medium">Số khách</label>
        <input id="pax" type="number" name="pax" min="1" max="30" required
               value="{{ old('pax', 1) }}"
               class="border rounded p-2 w-full">
        @error('pax')
            <p class="text-red-500 text-sm mt-1" role="alert">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Giữ chỗ 15 phút
    </button>
</form>