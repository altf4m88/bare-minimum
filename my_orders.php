<?php
require_once 'helpers.php';
require_login();

if (current_user_role() !== 'user') {
    redirect_to('admin_dashboard.php');
}

$userId = (int)$_SESSION['user']['id'];
$stmt = mysqli_prepare($conn, 'SELECT o.*, e.title AS event_title, e.event_date FROM orders o JOIN events e ON e.id = o.event_id WHERE o.user_id = ? ORDER BY o.created_at DESC');
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$orders = mysqli_stmt_get_result($stmt);

$pageTitle = 'Status Pemesanan Tiket';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Status Pemesanan Tiket</h1>

<div class="table-responsive">
    <table class="table table-striped table-bordered bg-white">
        <thead>
            <tr>
                <th>Event</th>
                <th>Tanggal Event</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($orders) === 0): ?>
                <tr><td colspan="6" class="text-center">Belum ada pesanan.</td></tr>
            <?php endif; ?>

            <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                <tr>
                    <td><?= esc($order['event_title']); ?></td>
                    <td><?= esc($order['event_date']); ?></td>
                    <td><?= (int)$order['quantity']; ?></td>
                    <td>Rp<?= number_format((float)$order['total_price'], 0, ',', '.'); ?></td>
                    <td>
                        <span class="badge badge-status text-bg-<?= $order['payment_status'] === 'paid' ? 'success' : ($order['payment_status'] === 'rejected' ? 'danger' : 'warning'); ?>">
                            <?= esc($order['payment_status']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($order['payment_status'] !== 'paid'): ?>
                            <a href="upload_payment.php?order_id=<?= (int)$order['id']; ?>" class="btn btn-sm btn-outline-primary">Upload Bukti</a>
                        <?php else: ?>
                            <span class="text-success">Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'partials/footer.php'; ?>
