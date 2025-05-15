<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clothe_id = $_POST['clothe_id'];

    if(isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND clothe_id = ?");
        $stmt->execute([$_SESSION['user_id'], $clothe_id]);
    } else {
        $_SESSION['cart'] = array_filter($_SESSION['cart'] ?? [], function($item) use ($clothe_id) {
            return $item['clothe_id'] != $clothe_id;
        });
    }
    
    header('Location: ../cart.php');
    exit;
}