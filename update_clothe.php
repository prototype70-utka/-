<?php
include 'services/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clothe_id = $_POST['clothe_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    // Обработка загрузки изображения
    if ($image['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $image_name = basename($image['name']);
        $target_file = $upload_dir . $image_name;

        // Перемещение загруженного файла в целевую директорию
        if (move_uploaded_file($image['tmp_name'], $target_file)) {
            // Обновление записи в базе данных с новым изображением
            $stmt = $pdo->prepare("UPDATE clothes SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
            if ($stmt->execute([$name, $description, $price, 'uploads/' . $image_name, $clothe_id])) {
                header('Location: admin_panel.php');
                exit();
            } else {
                echo "Ошибка при обновлении товара";
            }
        } else {
            echo "Ошибка при загрузке файла.";
            exit();
        }
    } else {
        // Обновление записи в базе данных без изменения изображения
        $stmt = $pdo->prepare("UPDATE clothes SET name = ?, description = ?, price = ? WHERE id = ?");
        if ($stmt->execute([$name, $description, $price, $clothe_id])) {
            header('Location: admin_panel.php');
            exit();
        } else {
            echo "Ошибка при обновлении товара";
        }
    }
}
?>