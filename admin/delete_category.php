<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: manage_categories.php");
    exit;
} else {
    echo "Kategori ID belirtilmedi.";
    exit;
}
?>
