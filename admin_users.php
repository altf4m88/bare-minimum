<?php
require_once 'helpers.php';
require_admin();

$users = mysqli_query($conn, "SELECT id, name, email, created_at FROM users WHERE role='user' ORDER BY id DESC");

$pageTitle = 'Data User';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Data User</h1>
<a href="admin_dashboard.php" class="btn btn-secondary mb-3">Kembali</a>

<div class="table-responsive bg-white shadow-sm">
    <table class="table table-bordered mb-0">
        <thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Tanggal Daftar</th></tr></thead>
        <tbody>
            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?= (int)$user['id']; ?></td>
                    <td><?= esc($user['name']); ?></td>
                    <td><?= esc($user['email']); ?></td>
                    <td><?= esc($user['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'partials/footer.php'; ?>
