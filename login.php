<?php
require_once 'helpers.php';

if (is_logged_in()) {
    redirect_to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare($conn, 'SELECT id, name, email, password, role FROM users WHERE email = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if (!$user || !password_verify($password, $user['password'])) {
        set_flash('Email atau password salah.', 'danger');
    } else {
        unset($user['password']);
        $_SESSION['user'] = $user;
        set_flash('Login berhasil.');

        if ($user['role'] === 'admin') {
            redirect_to('admin_dashboard.php');
        }

        redirect_to('index.php');
    }
}

$pageTitle = 'Login';
include 'partials/header.php';
?>
<h1 class="h3 mb-3">Login</h1>
<form method="POST" class="card p-3 shadow-sm">
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary" type="submit">Masuk</button>
</form>
<?php include 'partials/footer.php'; ?>
