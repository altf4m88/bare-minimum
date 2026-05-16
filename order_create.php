<?php
require_once 'helpers.php';
require_login();

if (current_user_role() !== 'user') {
    redirect_to('admin_dashboard.php');
}

$eventId = (int)($_GET['event_id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT id, title, event_date, location, price, quota FROM events WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $eventId);
mysqli_stmt_execute($stmt);
$event = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$event) {
    set_flash('Event tidak ditemukan.', 'danger');
    redirect_to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = (int)($_POST['quantity'] ?? 1);

    if ($quantity < 1 || $quantity > (int)$event['quota']) {
        set_flash('Jumlah tiket tidak valid.', 'danger');
    } else {
        $totalPrice = $quantity * (float)$event['price'];
        $userId = (int)$_SESSION['user']['id'];

        $insert = mysqli_prepare($conn, "INSERT INTO orders (user_id, event_id, quantity, total_price, payment_status) VALUES (?, ?, ?, ?, 'pending')");
        mysqli_stmt_bind_param($insert, 'iiid', $userId, $eventId, $quantity, $totalPrice);
        mysqli_stmt_execute($insert);

        set_flash('Pemesanan berhasil dibuat. Silakan upload bukti pembayaran.');
        redirect_to('my_orders.php');
    }
}

$pageTitle = 'Pesan Tiket';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Pesan Tiket</h1>
<div class="card p-3 shadow-sm">
    <p class="mb-1"><strong>Event:</strong> <?= esc($event['title']); ?></p>
    <p class="mb-1"><strong>Tanggal:</strong> <?= esc($event['event_date']); ?></p>
    <p class="mb-1"><strong>Harga:</strong> Rp<?= number_format((float)$event['price'], 0, ',', '.'); ?></p>
    <p class="mb-3"><strong>Kuota tersedia:</strong> <?= (int)$event['quota']; ?></p>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Jumlah Tiket</label>
            <input type="number" name="quantity" class="form-control" min="1" max="<?= (int)$event['quota']; ?>" value="1" required>
        </div>
        <button class="btn btn-primary" type="submit">Buat Pesanan</button>
    </form>
</div>
<?php include 'partials/footer.php'; ?>
