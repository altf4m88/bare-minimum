<?php
require_once 'helpers.php';

if (is_logged_in()) {
    redirect_to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        set_flash('Semua field wajib diisi.', 'danger');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash('Format email tidak valid.', 'danger');
    } else {
        $check = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ? LIMIT 1');
        mysqli_stmt_bind_param($check, 's', $email);
        mysqli_stmt_execute($check);
        $exists = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($exists) > 0) {
            set_flash('Email sudah terdaftar.', 'danger');
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
            mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $hashed);
            mysqli_stmt_execute($stmt);
            set_flash('Registrasi berhasil. Silakan login.');
            redirect_to('login.php');
        }
    }
}

$pageTitle = 'Registrasi User';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Registrasi</h1>
<form method="POST" class="card p-3 shadow-sm">
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary" type="submit">Daftar</button>
</form>
<?php include 'partials/footer.php'; ?>
