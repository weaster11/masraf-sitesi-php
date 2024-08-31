<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap / Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
        }
        .container {
            display: flex;
            width: 80%;
            height: 60%;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.2);
        }
        .left-pane {
            width: 40%;
            padding: 20px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        .right-pane {
            width: 60%;
            background-color: #000;
            position: relative;
        }
        .right-pane video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .btn-custom {
            width: 80%;
            margin: 10px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-pane">
            <h2>Hoşgeldiniz</h2>
            <a href="register.php" class="btn btn-primary btn-custom">Kayıt Ol</a>
            <a href="login.php" class="btn btn-secondary btn-custom">Giriş Yap</a>
        </div>
        <div class="right-pane">
            <video autoplay muted loop>
                <source src="https://www.cagrigungor.com/wp-content/uploads/2019/08/deniz.mp4" type="video/mp4">
                Tarayıcınız video etiketini desteklemiyor.
            </video>
        </div>
    </div>
</body>
</html>
