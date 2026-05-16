<?php
require_once __DIR__ . '/config.php';

function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect_to(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function current_user_role(): ?string
{
    return $_SESSION['user']['role'] ?? null;
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect_to('login.php');
    }
}

function require_admin(): void
{
    require_login();
    if (current_user_role() !== 'admin') {
        redirect_to('index.php');
    }
}

function set_flash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function upload_payment_proof(array $file): ?string
{
    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $maxSize = 2 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        return null;
    }

    $allowedMime = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    $mime = mime_content_type($file['tmp_name']);

    if (!isset($allowedMime[$mime])) {
        return null;
    }

    $ext = $allowedMime[$mime];
    $filename = 'proof_' . time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
    $target = __DIR__ . '/uploads/payments/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        return null;
    }

    return 'uploads/payments/' . $filename;
}
?>
