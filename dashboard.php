<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Kullanıcı Paneli</h1>
        <a href="add_expense.php" class="btn btn-primary">Yeni Masraf Ekle</a>
        <a href="add_category.php" class="btn btn-primary">Yeni Kategori Ekle</a>
        <a href="view_expenses.php" class="btn btn-secondary">Tüm Masrafları Görüntüle</a>
        <a href="logout.php" class="btn btn-danger">Sistemden Çıkış Yap</a>
    </div>
</body>
</html>
