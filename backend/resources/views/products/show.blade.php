{{-- backend/resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->title . ' | ' . config('app.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->cancel_policy), 150))

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    "@context" => "https://schema.org",
    "@type" => "TouristAttraction",
    "name" => $product->title,
    "address" => [
        "@type" => "PostalAddress",
        "addressRegion" => $product->destinations->first()?->province,
    ],
], JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<nav aria-label="Đường dẫn" class="breadcrumb">
    <a href="{{ route('home') }}">Trang chủ</a> /
    <a href="{{ route('products.index') }}">Sản phẩm</a> /
    <span aria-current="page">{{ $product->title }}</span>
</nav>

<h1>{{ $product->title }}</h1>

<x-booking-form :product="$product" :availabilities="$availabilities" />

<section aria-labelledby="lich-trinh">
    <h2 id="lich-trinh">Lịch trình</h2>
    @foreach ($product->itineraries->groupBy('day_no') as $day => $stops)
        <h3>Ngày {{ $day }}</h3>
        <ol>
            @foreach ($stops as $s)
                <li>{{ $s->destination->name }} ({{ $s->duration_min }} phút)</li>
            @endforeach
        </ol>
    @endforeach
</section>

{{-- Gợi ý do mô-đun Python tính --}}
<x-related-products :items="$related" />
@endsection
