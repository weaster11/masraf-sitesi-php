<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        echo "Kategori bulunamadı.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];

        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);

        header("Location: manage_categories.php");
        exit;
    }
} else {
    echo "Kategori ID belirtilmedi.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Düzenleme</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h1>Kategori Düzenleme</h1>
        <form method="POST" action="edit_category.php?id=<?= htmlspecialchars($category['id']) ?>">
            <label for="name">Kategori Adı:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
            <button type="submit">Kaydet</button>
        </form>
    </div>
</body>
</html>
