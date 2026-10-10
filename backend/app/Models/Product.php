<?php
// backend/app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'supplier_id', 
        'category_id', 
        'name',           // <- Bổ sung tên sản phẩm
        'title', 
        'slug',
        'type', 
        'price',          // <- Bổ sung cột price
        'base_price', 
        'stock',          // <- QUAN TRỌNG: Đã thêm cột tồn kho
        'duration_days', 
        'capacity', 
        'cancel_policy', 
        'status',
        'is_featured', 
        'is_discount', 
        'discount_price',
        'origin',         // <- Bổ sung xuất xứ/nguồn gốc
        'location',       // <- Vị trí
        'image',          // <- Đường dẫn ảnh sản phẩm
        'description',    // <- Bổ sung mô tả chi tiết
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'base_price'     => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock'          => 'integer',
        'duration_days'  => 'integer',
        'is_featured'    => 'boolean',
        'is_discount'    => 'boolean',
    ];

    // Accessor: Tự động dùng 'title' nếu 'name' bị trống hoặc ngược lại
    public function getNameAttribute($value)
    {
        return $value ?? $this->attributes['title'] ?? 'Sản phẩm chưa đặt tên';
    }

    // Accessor: Tự động dùng 'base_price' nếu 'price' bị trống
    public function getPriceAttribute($value)
    {
        return $value ?? $this->attributes['base_price'] ?? 0;
    }

    // --- Các quan hệ Eloquent (Relationships) ---
    public function supplier() 
    { 
        return $this->belongsTo(Supplier::class); 
    }

    public function category() 
    { 
        return $this->belongsTo(Category::class); 
    }

    public function itineraries() 
    {
        return $this->hasMany(Itinerary::class)->orderBy('day_no')->orderBy('seq_no');
    }

    public function availabilities() 
    { 
        return $this->hasMany(Availability::class); 
    }

    public function reviews() 
    {
        return $this->hasMany(Review::class)->whereNotNull('moderated_at');
    }

    public function destinations() 
    {
        return $this->hasThrough(Destination::class, Itinerary::class, 'product_id', 'id', 'id', 'destination_id');
    }

    // --- Bộ lọc đa tiêu chí (Local Scope) ---
    public function scopeFilter(Builder $q, array $f): Builder
    {
        return $q->where('status', 'published')
            ->when($f['keyword'] ?? null, fn ($q, $v) => $q->where('title', 'like', "%{$v}%")->orWhere('name', 'like', "%{$v}%"))
            ->when($f['type'] ?? null, fn ($q, $v) => $q->where('type', $v))
            ->when($f['price_min'] ?? null, fn ($q, $v) => $q->where('base_price', '>=', $v))
            ->when($f['price_max'] ?? null, fn ($q, $v) => $q->where('base_price', '<=', $v))
            ->when($f['province'] ?? null, fn ($q, $v) => $q->whereHas('destinations', fn ($d) => $d->where('province', $v)))
            ->when($f['date'] ?? null, fn ($q, $v) => $q->whereHas('availabilities', fn ($a) => $a->where('service_date', $v)
                ->whereRaw('seats_total - seats_held - seats_sold > 0')));
    }
}