<?php
require_once 'helpers.php';
require_login();

if (current_user_role() !== 'user') {
    redirect_to('admin_dashboard.php');
}

$orderId = (int)($_GET['order_id'] ?? 0);
$userId = (int)$_SESSION['user']['id'];

$stmt = mysqli_prepare($conn, 'SELECT o.*, e.title AS event_title FROM orders o JOIN events e ON e.id = o.event_id WHERE o.id = ? AND o.user_id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'ii', $orderId, $userId);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$order) {
    set_flash('Pesanan tidak ditemukan.', 'danger');
    redirect_to('my_orders.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $path = upload_payment_proof($_FILES['payment_proof'] ?? []);

    if ($path === null) {
        set_flash('Upload gagal. Gunakan JPG/PNG maksimal 2MB.', 'danger');
    } else {
        $update = mysqli_prepare($conn, "UPDATE orders SET payment_proof = ?, payment_status = 'uploaded' WHERE id = ? AND user_id = ?");
        mysqli_stmt_bind_param($update, 'sii', $path, $orderId, $userId);
        mysqli_stmt_execute($update);

        set_flash('Bukti pembayaran berhasil diupload.');
        redirect_to('my_orders.php');
    }
}

$pageTitle = 'Upload Bukti Pembayaran';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Upload Bukti Pembayaran</h1>
<div class="card p-3 shadow-sm">
    <p><strong>Event:</strong> <?= esc($order['event_title']); ?></p>
    <p><strong>Total Bayar:</strong> Rp<?= number_format((float)$order['total_price'], 0, ',', '.'); ?></p>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">File Bukti (JPG/PNG, max 2MB)</label>
            <input type="file" name="payment_proof" class="form-control" accept="image/png, image/jpeg" required>
        </div>
        <button class="btn btn-primary" type="submit">Upload</button>
    </form>
</div>
<?php include 'partials/footer.php'; ?>
