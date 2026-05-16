<?php
require_once 'helpers.php';
require_admin();

$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM events'))['total'] ?? 0;
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='user'"))['total'] ?? 0;
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM orders'))['total'] ?? 0;
$totalSales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_price),0) AS total FROM orders WHERE payment_status='paid'"))['total'] ?? 0;

$pageTitle = 'Admin Dashboard';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Dashboard Admin</h1>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card p-3 shadow-sm"><h6>Total Event</h6><h3><?= (int)$totalEvents; ?></h3></div></div>
    <div class="col-md-3"><div class="card p-3 shadow-sm"><h6>Total User</h6><h3><?= (int)$totalUsers; ?></h3></div></div>
    <div class="col-md-3"><div class="card p-3 shadow-sm"><h6>Total Pesanan</h6><h3><?= (int)$totalOrders; ?></h3></div></div>
    <div class="col-md-3"><div class="card p-3 shadow-sm"><h6>Total Penjualan</h6><h5>Rp<?= number_format((float)$totalSales, 0, ',', '.'); ?></h5></div></div>
</div>

<div class="list-group">
    <a href="admin_categories.php" class="list-group-item list-group-item-action">Kelola Kategori Event</a>
    <a href="admin_events.php" class="list-group-item list-group-item-action">Kelola Data Event</a>
    <a href="admin_users.php" class="list-group-item list-group-item-action">Lihat Data User</a>
    <a href="admin_orders.php" class="list-group-item list-group-item-action">Lihat Data Pemesanan & Ubah Status Pembayaran</a>
    <a href="admin_report.php" class="list-group-item list-group-item-action">Laporan Penjualan Tiket</a>
</div>
<?php include 'partials/footer.php'; ?>
