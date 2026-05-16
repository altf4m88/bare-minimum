<?php
require_once 'helpers.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'DELETE FROM categories WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

set_flash('Kategori berhasil dihapus.');
redirect_to('admin_categories.php');
?>
