<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    $stmt = $pdo->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?)");
    $stmt->execute([$user_id, $category_name]);

    header("Location: manage_categories.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = ?");
$stmt->execute([$user_id]);
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategoriler</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h1>Kategoriler</h1>
        <form action="manage_categories.php" method="post">
            <div class="form-group">
                <label for="category_name">Yeni Kategori:</label>
                <input type="text" id="category_name" name="category_name" required>
            </div>
            <button type="submit">Kategori Ekle</button>
        </form>

        <h2>Mevcut Kategoriler</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><?= htmlspecialchars($category['name']) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
