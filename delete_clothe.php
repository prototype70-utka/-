<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clothe_id = $_POST['clothe_id'];

    try {
        $pdo->beginTransaction();

        // 1. Удаляем связанные записи из order_items
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE clothe_id = ?");
        $stmt->execute([$clothe_id]);

        // 2. Удаляем связанные записи из cart
        $stmt = $pdo->prepare("DELETE FROM cart WHERE clothe_id = ?");
        $stmt->execute([$clothe_id]);

        // 3. Удаляем запись из clothes
        $stmt = $pdo->prepare("DELETE FROM clothes WHERE id = ?");
        $stmt->execute([$clothe_id]);

        $pdo->commit();
        header('Location: ../admin_panel.php');
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Ошибка удаления: " . $e->getMessage());
    }
}
?>