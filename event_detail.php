<?php
require_once 'helpers.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT e.*, c.name AS category_name FROM events e JOIN categories c ON c.id = e.category_id WHERE e.id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$event = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$event) {
    set_flash('Event tidak ditemukan.', 'danger');
    redirect_to('index.php');
}

$pageTitle = 'Detail Event';
include 'partials/header.php';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <span class="badge text-bg-secondary mb-2"><?= esc($event['category_name']); ?></span>
        <h1 class="h3"><?= esc($event['title']); ?></h1>
        <p><?= nl2br(esc($event['description'])); ?></p>
        <p class="mb-1"><strong>Tanggal:</strong> <?= esc($event['event_date']); ?></p>
        <p class="mb-1"><strong>Lokasi:</strong> <?= esc($event['location']); ?></p>
        <p class="mb-1"><strong>Kuota:</strong> <?= (int)$event['quota']; ?></p>
        <p class="mb-3"><strong>Harga Tiket:</strong> Rp<?= number_format((float)$event['price'], 0, ',', '.'); ?></p>

        <?php if (is_logged_in() && current_user_role() === 'user'): ?>
            <a href="order_create.php?event_id=<?= (int)$event['id']; ?>" class="btn btn-primary">Pesan Tiket</a>
        <?php elseif (!is_logged_in()): ?>
            <a href="login.php" class="btn btn-outline-primary">Login untuk memesan</a>
        <?php endif; ?>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
