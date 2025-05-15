<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/'; 
        $fileName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;
        $image = 'uploads/' . $fileName; 
        
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    } else {
        die("Ошибка загрузки изображения");
    }

    $stmt = $pdo->prepare("INSERT INTO clothes (name, description, price, image) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$name, $description, $price, $image])) {
        header('Location: ../admin_panel.php');
    } else {
        echo "Ошибка при добавлении одежды";
    }
}
?>