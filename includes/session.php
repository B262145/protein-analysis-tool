<?php
// Start session and include database connection
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'db_connect.php';
?>
