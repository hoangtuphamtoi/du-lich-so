{{-- backend/resources/views/components/site-footer.blade.php --}}
<footer class="site-footer">
    <div class="container mx-auto px-4 text-center">
        <p>
            Học phần <strong>CSE703073 - Lập trình ứng dụng web trong du lịch 2</strong>
            &middot; Nhóm <strong>{{ config('app.team_name', 'Nhom03') }}</strong>
            &middot; Trường Công nghệ thông tin, Đại học Phenikaa
        </p>
        <p class="ghi-chu text-xs mt-1 text-gray-400">
            Sản phẩm học thuật &ndash; phục vụ mục đích đào tạo. Dữ liệu trong hệ thống là dữ liệu mô phỏng hoặc dữ liệu công khai; giao dịch thanh toán ở chế độ thử nghiệm.
        </p>
        <p class="phien-ban text-xs mt-1 text-gray-500">Phiên bản {{ config('app.version', 'v1.0.0') }}</p>
    </div>
</footer>