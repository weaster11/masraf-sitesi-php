<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: manage_users.php");
    exit;
} else {
    echo "Kullanıcı ID belirtilmedi.";
    exit;
}
?>
