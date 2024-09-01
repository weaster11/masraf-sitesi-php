<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Admin Paneli</h1>
        <nav class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_users.php">Kullanıcılar</a>
            <a href="add_expense.php">Masraf Ekle</a>
            <a href="view_expenses.php">Masrafları Görüntüle</a>
            <a href="logout.php">Çıkış</a>
        </nav>
    </header>
    <div class="container">
        <h2>Dashboard</h2>
        <p>Hoş geldiniz! Burada sisteminizin genel durumu hakkında bilgi bulabilirsiniz.</p>
        <!-- Dashboard içeriği buraya gelecek -->
    </div>
</body>
</html>

