<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['user_id']);
$session_username = $is_logged_in ? $_SESSION['username'] : '';
?>
