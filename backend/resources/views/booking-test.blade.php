<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt Vé Tour Du Lịch</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f6f8; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; width: 350px; }
        .btn-book { background-color: #276A3C; color: white; border: none; padding: 12px 24px; font-size: 16px; font-weight: bold; border-radius: 6px; cursor: pointer; width: 100%; margin-top: 15px; }
        .btn-book:hover { background-color: #1f522e; }
        #status-msg { margin-top: 15px; font-size: 15px; font-weight: bold; min-height: 24px; }
    </style>
</head>
<body>

<div class="card">
    <h3>Tour Du Lịch Mẫu (ID: 1)</h3>
    <p>Số lượng đặt: <b>1 vé</b></p>
    <button id="btn-book" class="btn-book" onclick="placeOrder()">ĐẶT VÉ NGAY</button>
    <div id="status-msg"></div>
</div>

<script>
async function placeOrder() {
    const msg = document.getElementById('status-msg');
    msg.style.color = '#333';
    msg.innerText = '⏳ Đang xử lý giao dịch...';

    try {
        const response = await fetch('/api/v1/bookings', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: 1, quantity: 1 })
        });

        const data = await response.json();

        if (response.ok) {
            msg.style.color = 'green';
            msg.innerText = '✅ ' + data.message;
        } else {
            msg.style.color = 'red';
            msg.innerText = '❌ ' + data.message;
        }
    } catch (err) {
        msg.style.color = 'red';
        msg.innerText = '❌ Kết nối thất bại!';
    }
}
</script>

</body>
</html>