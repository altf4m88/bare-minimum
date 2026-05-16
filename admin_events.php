<?php
require_once 'helpers.php';
require_admin();

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
        $stmt = mysqli_prepare($conn, 'INSERT INTO events (category_id, title, description, event_date, location, price, quota) VALUES (?, ?, ?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'issssdi', $categoryId, $title, $description, $eventDate, $location, $price, $quota);
        mysqli_stmt_execute($stmt);
        set_flash('Event berhasil ditambahkan.');
        redirect_to('admin_events.php');
    }
}

$categories = mysqli_query($conn, 'SELECT id, name FROM categories ORDER BY name ASC');
$events = mysqli_query($conn, 'SELECT e.*, c.name AS category_name FROM events e JOIN categories c ON c.id = e.category_id ORDER BY e.id DESC');

$pageTitle = 'Kelola Data Event';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Kelola Data Event</h1>
<a href="admin_dashboard.php" class="btn btn-secondary mb-3">Kembali</a>

<div class="card p-3 mb-4 shadow-sm">
    <h5>Tambah Event</h5>
    <form method="POST" class="row g-2">
        <div class="col-md-4">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                <option value="">Pilih kategori</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= (int)$cat['id']; ?>"><?= esc($cat['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Judul Event</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Event</label>
            <input type="date" name="event_date" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Lokasi</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Harga</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Kuota</label>
            <input type="number" name="quota" class="form-control" required>
        </div>
        <div class="col-12">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-12 d-grid">
            <button class="btn btn-primary" type="submit">Tambah Event</button>
        </div>
    </form>
</div>

<div class="table-responsive bg-white shadow-sm">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th>ID</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Lokasi</th><th>Harga</th><th>Kuota</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($event = mysqli_fetch_assoc($events)): ?>
                <tr>
                    <td><?= (int)$event['id']; ?></td>
                    <td><?= esc($event['title']); ?></td>
                    <td><?= esc($event['category_name']); ?></td>
                    <td><?= esc($event['event_date']); ?></td>
                    <td><?= esc($event['location']); ?></td>
                    <td>Rp<?= number_format((float)$event['price'], 0, ',', '.'); ?></td>
                    <td><?= (int)$event['quota']; ?></td>
                    <td>
                        <a href="admin_event_edit.php?id=<?= (int)$event['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="admin_event_delete.php?id=<?= (int)$event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus event ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'partials/footer.php'; ?>
