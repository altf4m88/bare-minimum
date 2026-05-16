<?php
require_once 'helpers.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = (int)($_POST['order_id'] ?? 0);
    $status = $_POST['payment_status'] ?? 'pending';
    $allowed = ['pending', 'uploaded', 'paid', 'rejected'];

    if (!in_array($status, $allowed, true)) {
        set_flash('Status pembayaran tidak valid.', 'danger');
    } else {
        $stmt = mysqli_prepare($conn, 'UPDATE orders SET payment_status = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'si', $status, $orderId);
        mysqli_stmt_execute($stmt);
        set_flash('Status pembayaran berhasil diubah.');
        redirect_to('admin_orders.php');
    }
}

$orders = mysqli_query(
    $conn,
    'SELECT o.*, u.name AS user_name, u.email, e.title AS event_title
     FROM orders o
     JOIN users u ON u.id = o.user_id
     JOIN events e ON e.id = o.event_id
     ORDER BY o.id DESC'
);

$pageTitle = 'Data Pemesanan Tiket';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Data Pemesanan Tiket</h1>
<a href="admin_dashboard.php" class="btn btn-secondary mb-3">Kembali</a>

<div class="table-responsive bg-white shadow-sm">
    <table class="table table-bordered mb-0 align-middle">
        <thead>
            <tr>
                <th>ID</th><th>User</th><th>Event</th><th>Qty</th><th>Total</th><th>Bukti</th><th>Status</th><th>Ubah Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                <tr>
                    <td><?= (int)$order['id']; ?></td>
                    <td><?= esc($order['user_name']); ?><br><small><?= esc($order['email']); ?></small></td>
                    <td><?= esc($order['event_title']); ?></td>
                    <td><?= (int)$order['quantity']; ?></td>
                    <td>Rp<?= number_format((float)$order['total_price'], 0, ',', '.'); ?></td>
                    <td>
                        <?php if (!empty($order['payment_proof'])): ?>
                            <a href="<?= esc($order['payment_proof']); ?>" target="_blank" class="btn btn-sm btn-outline-info">Lihat</a>
                        <?php else: ?>
                            <span class="text-muted">Belum ada</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge text-bg-secondary"><?= esc($order['payment_status']); ?></span></td>
                    <td>
                        <form method="POST" class="d-flex gap-1">
                            <input type="hidden" name="order_id" value="<?= (int)$order['id']; ?>">
                            <select name="payment_status" class="form-select form-select-sm" required>
                                <?php foreach (['pending', 'uploaded', 'paid', 'rejected'] as $status): ?>
                                    <option value="<?= $status; ?>" <?= $order['payment_status'] === $status ? 'selected' : ''; ?>><?= $status; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'partials/footer.php'; ?>
