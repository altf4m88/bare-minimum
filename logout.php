<?php
require_once 'helpers.php';
session_unset();
session_destroy();
session_start();
set_flash('Logout berhasil.');
redirect_to('login.php');
?>
