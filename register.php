<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Şifreyi güvenli bir şekilde hash'le
    $membership_type = $_POST['membership_type']; // Üyelik türünü al

    // Kullanıcıyı veritabanına ekle
    $stmt = $pdo->prepare("INSERT INTO users (username, password, membership_type) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $membership_type]);

    echo "Kayıt başarılı!";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Kayıt Ol</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Kullanıcı Adı</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Kayıt Ol</button>
        </form>
    </div>

    <div class="container">
        <h1>Kayıt Ol</h1>
        <form method="POST" action="register.php" enctype="multipart/form-data">
            <label for="username" class="form-label">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password" class="form-label">Şifre:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="membership_type" class="form-label">Üyelik Türü:</label>
            <select id="membership_type" name="membership_type">
                <option value="standard">Standart Üye</option>
                <option value="vip">VIP Üye</option>
            </select>
            
            <button type="submit" class="btn btn-primary">Kayıt Ol</button>
        </form>
    </div>
</body>
</html>
