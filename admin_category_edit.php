<?php
require_once 'helpers.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT * FROM categories WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$category = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$category) {
    set_flash('Kategori tidak ditemukan.', 'danger');
    redirect_to('admin_categories.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        set_flash('Nama kategori wajib diisi.', 'danger');
    } else {
        $update = mysqli_prepare($conn, 'UPDATE categories SET name = ? WHERE id = ?');
        mysqli_stmt_bind_param($update, 'si', $name, $id);
        mysqli_stmt_execute($update);
        set_flash('Kategori berhasil diperbarui.');
        redirect_to('admin_categories.php');
    }
}

$pageTitle = 'Edit Kategori';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Edit Kategori</h1>
<form method="POST" class="card p-3 shadow-sm">
    <div class="mb-3">
        <label class="form-label">Nama Kategori</label>
        <input type="text" name="name" class="form-control" value="<?= esc($category['name']); ?>" required>
    </div>
    <button class="btn btn-primary" type="submit">Update</button>
    <a href="admin_categories.php" class="btn btn-secondary mt-2">Kembali</a>
</form>
<?php include 'partials/footer.php'; ?>
