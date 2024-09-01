<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ?");
    $stmt->execute([$id]);
    $expense = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$expense) {
        echo "Masraf bulunamadı.";
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
            $image_path = $expense['image'];
        }

        $stmt = $pdo->prepare("UPDATE expenses SET title = ?, amount = ?, date = ?, category_id = ?, image = ? WHERE id = ?");
        $stmt->execute([$title, $amount, $date, $category_id, $image_path, $id]);

        header("Location: manage_expenses.php");
        exit;
    }
} else {
    echo "Masraf ID belirtilmedi.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masraf Düzenleme</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Masraf Düzenleme</h1>
        <form method="POST" enctype="multipart/form-data" action="edit_expense.php?id=<?= htmlspecialchars($expense['id']) ?>">
            <label for="title">Başlık:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($expense['title']) ?>" required>
            <label for="amount">Tutar:</label>
            <input type="number" id="amount" name="amount" value="<?= htmlspecialchars($expense['amount']) ?>" step="0.01" required>
            <label for="date">Tarih:</label>
            <input type="date" id="date" name="date" value="<?= htmlspecialchars($expense['date']) ?>" required>
            <label for="category_id">Kategori:</label>
            <select id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $expense['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="image">Resim:</label>
            <input type="file" id="image" name="image">
            <?php if ($expense['image']): ?>
                <img src="<?= htmlspecialchars($expense['image']) ?>" alt="Masraf Resmi" width="100">
            <?php endif; ?>
            <button type="submit">Kaydet</button>
        </form>
    </div>
</body>
</html>
