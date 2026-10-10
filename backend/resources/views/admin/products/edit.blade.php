<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chỉnh sửa sản phẩm #{{ $product->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container" style="max-width: 700px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">✏️ Chỉnh sửa sản phẩm: {{ $product->name }}</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Tên sản phẩm:</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá bán (VNĐ):</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-success">Số lượng tồn kho:</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 10) }}" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Xuất xứ / Nguồn gốc:</label>
                    <input type="text" name="origin" class="form-control" value="{{ old('origin', $product->origin ?? 'Sơn La') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả sản phẩm:</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
                    <button type="submit" class="btn btn-success px-4">💾 Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>