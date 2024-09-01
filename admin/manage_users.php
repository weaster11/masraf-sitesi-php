<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Kullanıcıları getir
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Yönetimi</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Kullanıcı Yönetimi</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['is_admin'] ? 'Evet' : 'Hayır' ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id'] ?>">Düzenle</a> | 
                        <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
