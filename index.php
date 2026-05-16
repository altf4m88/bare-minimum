<?php
require_once 'helpers.php';

$keyword = trim($_GET['q'] ?? '');
$categoryId = (int)($_GET['category_id'] ?? 0);

$categories = mysqli_query($conn, 'SELECT id, name FROM categories ORDER BY name ASC');

$sql = "SELECT e.*, c.name AS category_name FROM events e JOIN categories c ON c.id = e.category_id WHERE 1=1";
$params = [];
$types = '';

if ($keyword !== '') {
    $sql .= ' AND (e.title LIKE ? OR e.location LIKE ?)';
    $like = '%' . $keyword . '%';
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

if ($categoryId > 0) {
    $sql .= ' AND e.category_id = ?';
    $params[] = $categoryId;
    $types .= 'i';
}

$sql .= ' ORDER BY e.event_date ASC';
$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$events = mysqli_stmt_get_result($stmt);

$pageTitle = 'Daftar Event';
include 'partials/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Daftar Event</h1>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" class="form-control" name="q" value="<?= esc($keyword); ?>" placeholder="Cari event atau lokasi...">
    </div>
    <div class="col-md-4">
        <select class="form-select" name="category_id">
            <option value="0">Semua Kategori</option>
            <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                <option value="<?= (int)$cat['id']; ?>" <?= $categoryId === (int)$cat['id'] ? 'selected' : ''; ?>>
                    <?= esc($cat['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-md-3 d-grid">
        <button class="btn btn-primary" type="submit">Cari Event</button>
    </div>
</form>

<div class="row g-3">
    <?php if (mysqli_num_rows($events) === 0): ?>
        <div class="col-12">
            <div class="alert alert-secondary">Event tidak ditemukan.</div>
        </div>
    <?php endif; ?>

    <?php while ($event = mysqli_fetch_assoc($events)): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card card-event shadow-sm">
                <div class="card-body d-flex flex-column">
                    <p class="text-muted mb-1"><?= esc($event['category_name']); ?></p>
                    <h5 class="card-title"><?= esc($event['title']); ?></h5>
                    <p class="mb-1"><strong>Tanggal:</strong> <?= esc($event['event_date']); ?></p>
                    <p class="mb-1"><strong>Lokasi:</strong> <?= esc($event['location']); ?></p>
                    <p class="mb-3"><strong>Harga:</strong> Rp<?= number_format((float)$event['price'], 0, ',', '.'); ?></p>
                    <a href="event_detail.php?id=<?= (int)$event['id']; ?>" class="btn btn-outline-primary mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'partials/footer.php'; ?>
