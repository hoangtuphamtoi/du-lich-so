<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PythonDataService
{
    private string $base = '';
    private string $token = '';

    public function __construct()
    {
        $this->base = rtrim(config('services.python.url'), '/');
        $this->token = (string) config('services.python.token');
    }

    /**
     * Gợi ý sản phẩm liên quan; có bộ đệm 30 phút và phương án dự phòng.
     */
    public function recommend(int $productId, int $k = 6): array
    {
        return Cache::remember("recommend:{$productId}:{$k}", now()->addMinutes(30), function () use ($productId, $k) {
            try {
                $res = Http::withHeaders(['X-Service-Token' => $this->token])
                    ->timeout(3) // không để người dùng chờ lâu
                    ->retry(2, 200)
                    ->get("{$this->base}/recommend/{$productId}", ['k' => $k]);

                if ($res->successful()) {
                    return $res->json('items', []);
                }

                Log::warning('Dịch vụ Python trả về lỗi', ['status' => $res->status()]);
            } catch (\Throwable $e) {
                Log::error('Không gọi được dịch vụ Python', ['loi' => $e->getMessage()]);
            }

            return $this->duPhong($productId, $k);
        });
    }

    /**
     * Dự phòng: cùng danh mục, giá gần nhau - bảo đảm trang vẫn có nội dung.
     */
    private function duPhong(int $productId, int $k): array
    {
        $p = \App\Models\Product::find($productId);
        if (! $p) {
            return [];
        }

        return \App\Models\Product::where('status', 'published')
            ->where('id', '!=', $productId)
            ->where('category_id', $p->category_id)
            ->whereBetween('base_price', [$p->base_price * 0.4, $p->base_price * 1.6])
            ->limit($k)
            ->get(['id as product_id', 'title'])
            ->toArray();
    }
}