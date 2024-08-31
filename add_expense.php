<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Kullanıcıyı kontrol et
$stmt = $pdo->prepare("SELECT membership_type, used_storage FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size']; // Resim boyutu

    if ($image) {
        // Resim boyutunu kontrol et
        $max_storage = ($user['membership_type'] == 'vip') ? 500 * 1024 * 1024 : 50 * 1024 * 1024; // MB cinsinden
        $total_storage = $user['used_storage'] + $image_size;

        if ($total_storage > $max_storage) {
            echo "Depolama limitinizi aştınız.";
            exit;
        }

        // Resmi yükle
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'uploads/' . basename($image);
        move_uploaded_file($image_tmp, $image_path);

        // Yüklenen resmi kaydet
        $stmt = $pdo->prepare("INSERT INTO uploaded_images (user_id, file_path, file_size) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $image_path, $image_size]);

        // Kullanıcının kullanılan depolama miktarını güncelle
        $stmt = $pdo->prepare("UPDATE users SET used_storage = used_storage + ? WHERE id = ?");
        $stmt->execute([$image_size, $user_id]);
    }

    // Masrafı kaydet
    $stmt = $pdo->prepare("INSERT INTO expenses (title, amount, date, category_id, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $amount, $date, $category_id, $image_path]);

    header("Location: view_expenses.php");
    exit;
}
?>
