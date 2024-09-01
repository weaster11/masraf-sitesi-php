<?php
// Veritabanı bağlantısı
require '../db.php';

// Kullanıcının giriş yapıp yapmadığını kontrol et
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Masrafları almak için SQL sorgusu
$query = "SELECT expenses.*, users.username FROM expenses JOIN users ON expenses.user_id = users.id ORDER BY expenses.date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masrafları Görüntüle</title>
    <link href="admin_styles.css" rel="stylesheet">
    <style>
        .expense-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .expense-table th, .expense-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .expense-table th {
            background-color: #f4f4f4;
        }
        .expense-table td img {
            max-width: 100px;
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }
        .modal img {
            max-width: 90%;
            max-height: 90%;
        }
        .modal.active {
            display: flex;
        }
        .close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Paneli</h1>
        <nav class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_users.php">Kullanıcılar</a>
            <a href="add_expense.php">Masraf Ekle</a>
            <a href="view_expenses.php">Masrafları Görüntüle</a>
            <a href="logout.php">Çıkış</a>
        </nav>
    </header>
    <div class="container">
        <h2>Masrafları Görüntüle</h2>
        <table class="expense-table">
            <thead>
                <tr>
                    <th>Kullanıcı Adı</th>
                    <th>Miktar</th>
                    <th>Kategori</th>
                    <th>Tarih</th>
                    <th>Fatura/Resim</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($expenses) > 0): ?>
                    <?php foreach ($expenses as $expense): ?>
                        <tr>
                            <td><?= htmlspecialchars($expense['username']) ?></td>
                            <td><?= htmlspecialchars($expense['amount']) ?> TL</td>
                            <td><?= htmlspecialchars($expense['category']) ?></td>
                            <td><?= htmlspecialchars($expense['date']) ?></td>
                            <td>
                                <?php if ($expense['receipt']): ?>
                                    <img src="uploads/<?= htmlspecialchars($expense['receipt']) ?>" alt="Fatura/Resim" class="open-modal" data-img="uploads/<?= htmlspecialchars($expense['receipt']) ?>">
                                <?php else: ?>
                                    - 
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Hiç masraf kaydedilmemiş.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for image preview -->
    <div class="modal" id="imageModal">
        <button class="close" id="closeModal">&times;</button>
        <img id="modalImage" src="" alt="Resim">
    </div>

    <script>
        // Open modal for image preview
        document.querySelectorAll('.open-modal').forEach(img => {
            img.addEventListener('click', () => {
                const modal = document.getElementById('imageModal');
                const modalImg = document.getElementById('modalImage');
                modalImg.src = img.dataset.img;
                modal.classList.add('active');
            });
        });

        // Close modal
        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('imageModal').classList.remove('active');
        });

        // Close modal when clicking outside of image
        window.addEventListener('click', (e) => {
            if (e.target === document.getElementById('imageModal')) {
                document.getElementById('imageModal').classList.remove('active');
            }
        });
    </script>
</body>
</html>
