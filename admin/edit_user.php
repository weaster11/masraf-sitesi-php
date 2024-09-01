<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Kullanıcı bulunamadı.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;

        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, is_admin = ? WHERE id = ?");
        $stmt->execute([$username, $email, $is_admin, $id]);

        header("Location: manage_users.php");
        exit;
    }
} else {
    echo "Kullanıcı ID belirtilmedi.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Düzenleme</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h1>Kullanıcı Düzenleme</h1>
        <form method="POST" action="edit_user.php?id=<?= htmlspecialchars($user['id']) ?>">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <label for="is_admin">Admin:</label>
            <input type="checkbox" id="is_admin" name="is_admin" <?= $user['is_admin'] ? 'checked' : '' ?>>
            <button type="submit">Kaydet</button>
        </form>
    </div>
</body>
</html>
