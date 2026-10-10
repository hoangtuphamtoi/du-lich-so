<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý người dùng - Quản trị</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Be Vietnam Pro', sans-serif; background: #F1F5F9; color: #1E293B; margin: 0; padding: 24px; }
        .page-container { max-width: 1200px; margin: 0 auto; }
        
        /* Header */
        .header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; color: #64748B; text-decoration: none; font-size: 14px; font-weight: 600; transition: color 0.2s; }
        .btn-back:hover { color: #0B3B2C; }
        .page-title { font-size: 24px; font-weight: 800; color: #0B3B2C; margin: 0; }

        /* Card container */
        .card { background: #FFFFFF; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #E2E8F0; overflow: hidden; }

        /* Table design */
        .table-responsive { overflow-x: auto; }
        .custom-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        .custom-table th { background: #F8FAFC; color: #0B3B2C; font-weight: 700; padding: 16px 20px; border-bottom: 1.5px solid #E2E8F0; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
        .custom-table td { padding: 16px 20px; border-bottom: 1px solid #F1F5F9; vertical-align: middle; color: #334155; }
        .custom-table tbody tr:hover { background-color: #F8FAFC; }

        /* User Info */
        .user-info { display: flex; align-items: center; gap: 12px; }
        .avatar-circle { width: 38px; height: 38px; border-radius: 50%; background: #0B3B2C; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px; }
        .user-name { font-weight: 700; color: #0F172A; }
        .user-email { font-size: 13px; color: #64748B; }

        /* Badges */
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-admin { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
        .badge-user { background: #E0F2FE; color: #0369A1; border: 1px solid #BAE6FD; }

        /* Action Buttons */
        .btn-action { padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-key { background: #FEF3C7; color: #B45309; }
        .btn-key:hover { background: #FDE68A; }
        .btn-delete { background: #FEE2E2; color: #B91C1C; }
        .btn-delete:hover { background: #FECACA; }

        /* Alerts */
        .alert { padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 600; display: flex; align-items: center; justify-content: space-between; }
        .alert-success { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
        .alert-error { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }

        /* Modal Đổi mật khẩu */
        .modal { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 1000; }
        .modal.active { display: flex; }
        .modal-content { background: #FFFFFF; width: 100%; max-width: 440px; border-radius: 16px; padding: 28px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        .modal-header { font-size: 18px; font-weight: 700; color: #0B3B2C; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #334155; }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; }
        .form-control:focus { border-color: #0B3B2C; box-shadow: 0 0 0 3px rgba(11, 59, 44, 0.1); }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
        .btn-secondary { background: #E2E8F0; color: #475569; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-primary { background: #0B3B2C; color: #FFFFFF; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 700; cursor: pointer; }
        .btn-primary:hover { background: #14532D; }
    </style>
</head>
<body>

<div class="page-container">
    <div class="header-bar">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">← Quay lại trang quản trị</a>
            <h1 class="page-title" style="margin-top: 6px;">Quản lý người dùng</h1>
        </div>
        <div style="font-size: 14px; color: #64748B; font-weight: 600;">
            Tổng cộng: <span style="color: #0B3B2C; font-weight: 800;">{{ $users->count() }}</span> tài khoản
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <span>✓ {{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <span>⚠ {{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <span>⚠ {{ $errors->first() }}</span>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">ID</th>
                        <th>Người dùng</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th style="text-align: right;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as$user): ?>
                            <tr>
                                <td><strong>#{{ $user->id }}</strong></td>
                                <td>
                                    <div class="user-info">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="user-name">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td class="user-email">{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ ($user->role ?? '') === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                        {{ strtoupper($user->role ?? 'USER') }}
                                    </span>
                                </td>
                                <td style="color: #64748B;">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <button class="btn-action btn-key" onclick="openPasswordModal({{ $user->id }}, '{{$user->name }}')">
                                            🔑 Đổi MK
                                        </button>

                                        <?php if (auth()->id() !== $user->id): ?>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản {{ $user->name }}?');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete">🗑️ Xóa</button>
                                            </form>
                                        <?php else: ?>
                                            <span style="font-size: 12px; color: #94A3B8; font-style: italic; padding: 0 4px;">(Bạn)</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #94A3B8;">
                                Chưa có tài khoản người dùng nào.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL ĐỔI MẬT KHẨU -->
<div id="passwordModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span>Đổi mật khẩu</span>
            <button onclick="closePasswordModal()" style="background:none; border:none; font-size: 20px; cursor:pointer; color:#64748B;">✕</button>
        </div>
        <form id="passwordForm" method="POST" action="">
            @csrf
            @method('PUT')
            <p style="font-size: 13px; color: #64748B; margin-top: 0; margin-bottom: 16px;">
                Cập nhật mật khẩu mới cho tài khoản <strong id="modalUserName" style="color: #0B3B2C;"></strong>
            </p>

            <div class="form-group">
                <label class="form-label" for="password">Mật khẩu mới</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập ít nhất 6 ký tự" required minlength="6">
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Xác nhận mật khẩu mới</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới" required minlength="6">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closePasswordModal()">Hủy</button>
                <button type="submit" class="btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPasswordModal(userId, userName) {
        const modal = document.getElementById('passwordModal');
        const form = document.getElementById('passwordForm');
        const nameSpan = document.getElementById('modalUserName');

        form.action = `/quan-tri/nguoi-dung/${userId}/doi-mat-khau`;
        nameSpan.textContent = userName;

        modal.classList.add('active');
    }

    function closePasswordModal() {
        const modal = document.getElementById('passwordModal');
        modal.classList.remove('active');
    }

    window.onclick = function(event) {
        const modal = document.getElementById('passwordModal');
        if (event.target === modal) {
            closePasswordModal();
        }
    }
</script>

</body>
</html>