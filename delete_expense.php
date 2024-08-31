<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $expense_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Masrafın kullanıcının olup olmadığını kontrol et
    $stmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ? AND user_id = ?");
    $stmt->execute([$expense_id, $user_id]);
    $expense = $stmt->fetch();

    if ($expense) {
        // Masrafı sil
        $stmt = $pdo->prepare("DELETE FROM expenses WHERE id = ?");
        $stmt->execute([$expense_id]);
    }

    header("Location: view_expenses.php");
    exit;
} else {
    header("Location: view_expenses.php");
    exit;
}
?>
