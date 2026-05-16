<?php
require_once 'helpers.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT * FROM events WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$event = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$event) {
    set_flash('Event tidak ditemukan.', 'danger');
    redirect_to('admin_events.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $eventDate = trim($_POST['event_date'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $quota = (int)($_POST['quota'] ?? 0);

    if ($categoryId < 1 || $title === '' || $eventDate === '' || $location === '' || $price <= 0 || $quota <= 0) {
        set_flash('Data event belum lengkap atau tidak valid.', 'danger');
    } else {
        $update = mysqli_prepare($conn, 'UPDATE events SET category_id=?, title=?, description=?, event_date=?, location=?, price=?, quota=? WHERE id=?');
        mysqli_stmt_bind_param($update, 'issssdii', $categoryId, $title, $description, $eventDate, $location, $price, $quota, $id);
        mysqli_stmt_execute($update);

        set_flash('Event berhasil diperbarui.');
        redirect_to('admin_events.php');
    }
}

$categories = mysqli_query($conn, 'SELECT id, name FROM categories ORDER BY name ASC');

$pageTitle = 'Edit Event';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Edit Event</h1>
<form method="POST" class="card p-3 shadow-sm">
    <div class="row g-2">
        <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= (int)$cat['id']; ?>" <?= (int)$event['category_id'] === (int)$cat['id'] ? 'selected' : ''; ?>>
                        <?= esc($cat['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="<?= esc($event['title']); ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal</label>
            <input type="date" name="event_date" class="form-control" value="<?= esc($event['event_date']); ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Lokasi</label>
            <input type="text" name="location" class="form-control" value="<?= esc($event['location']); ?>" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Harga</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= esc((string)$event['price']); ?>" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Kuota</label>
            <input type="number" name="quota" class="form-control" value="<?= (int)$event['quota']; ?>" required>
        </div>
        <div class="col-12">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4"><?= esc($event['description']); ?></textarea>
        </div>
    </div>
    <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan</button>
    <a href="admin_events.php" class="btn btn-secondary mt-2">Kembali</a>
</form>
<?php include 'partials/footer.php'; ?>
