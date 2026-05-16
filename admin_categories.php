<?php
require_once 'helpers.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        set_flash('Nama kategori wajib diisi.', 'danger');
    } else {
        $stmt = mysqli_prepare($conn, 'INSERT INTO categories (name) VALUES (?)');
        mysqli_stmt_bind_param($stmt, 's', $name);
        mysqli_stmt_execute($stmt);
        set_flash('Kategori berhasil ditambahkan.');
        redirect_to('admin_categories.php');
    }
}

$categories = mysqli_query($conn, 'SELECT * FROM categories ORDER BY id DESC');

$pageTitle = 'Kelola Kategori Event';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Kelola Kategori Event</h1>
<a href="admin_dashboard.php" class="btn btn-secondary mb-3">Kembali</a>
<div class="row g-3">
    <div class="col-md-5">
        <div class="card p-3 shadow-sm">
            <h5>Tambah Kategori</h5>
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Nama kategori" required>
                </div>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </form>
        </div>
    </div>
    <div class="col-md-7">
        <div class="table-responsive bg-white shadow-sm">
            <table class="table table-bordered mb-0">
                <thead><tr><th>ID</th><th>Nama</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                        <tr>
                            <td><?= (int)$cat['id']; ?></td>
                            <td><?= esc($cat['name']); ?></td>
                            <td>
                                <a href="admin_category_edit.php?id=<?= (int)$cat['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="admin_category_delete.php?id=<?= (int)$cat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
