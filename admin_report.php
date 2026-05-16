<?php
require_once 'helpers.php';
require_admin();

$rows = mysqli_query(
    $conn,
    "SELECT e.title, SUM(o.quantity) AS sold_tickets, SUM(o.total_price) AS total_sales
     FROM orders o
     JOIN events e ON e.id = o.event_id
     WHERE o.payment_status = 'paid'
     GROUP BY o.event_id
     ORDER BY total_sales DESC"
);

$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_price),0) AS grand_total FROM orders WHERE payment_status='paid'"));

$pageTitle = 'Laporan Penjualan Tiket';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Laporan Penjualan Tiket</h1>
<a href="admin_dashboard.php" class="btn btn-secondary mb-3">Kembali</a>

<div class="table-responsive bg-white shadow-sm mb-3">
    <table class="table table-bordered mb-0">
        <thead><tr><th>Event</th><th>Tiket Terjual</th><th>Total Penjualan</th></tr></thead>
        <tbody>
            <?php if (mysqli_num_rows($rows) === 0): ?>
                <tr><td colspan="3" class="text-center">Belum ada penjualan berstatus paid.</td></tr>
            <?php endif; ?>
            <?php while ($row = mysqli_fetch_assoc($rows)): ?>
                <tr>
                    <td><?= esc($row['title']); ?></td>
                    <td><?= (int)$row['sold_tickets']; ?></td>
                    <td>Rp<?= number_format((float)$row['total_sales'], 0, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="alert alert-success">
    <strong>Grand Total Penjualan:</strong> Rp<?= number_format((float)$total['grand_total'], 0, ',', '.'); ?>
</div>
<?php include 'partials/footer.php'; ?>
