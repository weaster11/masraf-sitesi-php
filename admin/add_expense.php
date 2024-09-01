<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Kategorileri getir
$stmt = $pdo->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'uploads/' . basename($image);
        move_uploaded_file($image_tmp, $image_path);
    } else {
        $image_path = null;
    }

    $stmt = $pdo->prepare("INSERT INTO expenses (title, amount, date, category_id, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $amount, $date, $category_id, $image_path]);

    header("Location: manage_expenses.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masraf Ekle</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Yeni Masraf Ekle</h1>
        <form method="POST" enctype="multipart/form-data" action="add_expense.php">
            <label for="title">Başlık:</label>
            <input type="text" id="title" name="title" required>
            <label for="amount">Tutar:</label>
            <input type="number" id="amount" name="amount" step="0.01" required>
            <label for="date">Tarih:</label>
            <input type="date" id="date" name="date" required>
            <label for="category_id">Kategori:</label>
            <select id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="image">Resim:</label>
            <input type="file" id="image" name="image">
            <button type="submit">Ekle</button>
        </form>
    </div>
</body>
</html>
