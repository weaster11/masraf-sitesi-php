<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Kategori filtreleme
$category_filter = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Kategoriler
$stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = ?");
$stmt->execute([$user_id]);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Masraflar
$query = "SELECT * FROM expenses WHERE user_id = ?";
$params = [$user_id];

if ($category_filter > 0) {
    $query .= " AND category_id = ?";
    $params[] = $category_filter;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masrafları Görüntüle</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <style>
        /* Tablo stil ayarları */
        .expense-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .expense-table th, .expense-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .expense-table th {
            background-color: #007bff;
            color: #fff;
        }

        .expense-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .expense-table tr:hover {
            background-color: #ddd;
        }

        .expense-table img {
            max-width: 150px;
            height: auto;
        }

        .expense-table .no-image {
            text-align: center;
            color: #888;
        }

        .btn-delete {
            color: #fff;
            background-color: #dc3545;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .filter-form {
            margin-bottom: 20px;
        }

        .filter-form select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Masrafları Görüntüle</h1>
        
        <!-- Kategori Filtreleme Formu -->
        <form class="filter-form" action="view_expenses.php" method="get">
            <label for="category_id">Kategori Seçin:</label>
            <select id="category_id" name="category_id">
                <option value="0">Tümü</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category_filter == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrele</button>
        </form>

        <!-- Masraflar Tablosu -->
        <table class="expense-table">
            <thead>
                <tr>
                    <th>Tutar</th>
                    <th>Açıklama</th>
                    <th>Kayıt Tarihi</th>
                    <th>Kategori</th>
                    <th>Fatura Resmi</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td><?= htmlspecialchars($expense['amount']) ?> ₺</td>
                        <td><?= htmlspecialchars($expense['description']) ?></td>
                        <td><?= htmlspecialchars($expense['created_at']) ?></td>
                        <td>
                            <?php
                            // Kategori adı almak
                            $category_stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
                            $category_stmt->execute([$expense['category_id']]);
                            $category = $category_stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <?= htmlspecialchars($category['name']) ?>
                        </td>
                        <td>
                            <?php if ($expense['receipt_image']): ?>
                                <a href="<?= htmlspecialchars($expense['receipt_image']) ?>" data-lightbox="expense-images" data-title="Fatura Resmi">
                                    <img src="<?= htmlspecialchars($expense['receipt_image']) ?>" alt="Fatura Resmi">
                                </a>
                            <?php else: ?>
                                <span class="no-image">Resim Yok</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="delete_expense.php?id=<?= $expense['id'] ?>" class="btn-delete" onclick="return confirm('Bu masrafı silmek istediğinizden emin misiniz?');">Sil</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</body>
</html>
