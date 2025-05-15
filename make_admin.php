<?php
include __DIR__ . '/db.php'; // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
    if ($stmt->execute([$user_id])) {
        header('Location: ../admin_panel.php');
    } else {
        echo "Ошибка при назначении админа";
    }
}
?>