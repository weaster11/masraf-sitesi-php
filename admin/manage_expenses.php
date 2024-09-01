<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Masrafları getir
$stmt = $pdo->prepare("SELECT expenses.*, categories.name AS category_name FROM expenses JOIN categories ON expenses.category_id = categories.id");
$stmt->execute();
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masraf Yönetimi</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Masraf Yönetimi</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kategori</th>
                    <th>Başlık</th>
                    <th>Tutar</th>
                    <th>Tarih</th>
                    <th>Resim</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenses as $expense): ?>
                <tr>
                    <td><?= htmlspecialchars($expense['id']) ?></td>
                    <td><?= htmlspecialchars($expense['category_name']) ?></td>
                    <td><?= htmlspecialchars($expense['title']) ?></td>
                    <td><?= htmlspecialchars($expense['amount']) ?> TL</td>
                    <td><?= htmlspecialchars($expense['date']) ?></td>
                    <td>
                        <?php if ($expense['image']): ?>
                            <a href="<?= htmlspecialchars($expense['image']) ?>" target="_blank">Resmi Görüntüle</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_expense.php?id=<?= $expense['id'] ?>">Düzenle</a> | 
                        <a href="delete_expense.php?id=<?= $expense['id'] ?>" onclick="return confirm('Bu masrafı silmek istediğinize emin misiniz?');">Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_expense.php">Yeni Masraf Ekle</a>
    </div>
</body>
</html>
