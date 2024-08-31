<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = trim($_POST['category_name']);

    if ($category_name != '') {
        $stmt = $pdo->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?)");
        $stmt->execute([$user_id, $category_name]);
        $success = "Kategori başarıyla eklendi!";
    } else {
        $error = "Kategori ismi boş olamaz!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Ekle</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>Kategori Ekle</h1>

        <?php if (isset($success)): ?>
            <p style="color: green;"><?= $success ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="add_category.php">
            <label for="category_name">Kategori İsmi:</label>
            <input type="text" id="category_name" name="category_name" required>
            <button type="submit">Ekle</button>
        </form>
    </div>
</body>
</html>
