<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clothe_id = $_POST['clothe_id'];
    $quantity = $_POST['quantity'];
    $action = $_POST['action'] ?? null;

    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        if($action == 'increase') {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND clothe_id = ?");
            $stmt->execute([$user_id, $clothe_id]);
        } elseif($action == 'decrease') {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = GREATEST(1, quantity - 1) WHERE user_id = ? AND clothe_id = ?");
            $stmt->execute([$user_id, $clothe_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND clothe_id = ?");
            $stmt->execute([$quantity, $user_id, $clothe_id]);
        }
    } else {
        foreach($_SESSION['cart'] as &$item) {
            if($item['clothe_id'] == $clothe_id) {
                if($action == 'increase') {
                    $item['quantity']++;
                } elseif($action == 'decrease') {
                    $item['quantity'] = max(1, $item['quantity'] - 1);
                } else {
                    $item['quantity'] = $quantity;
                }
                break;
            }
        }
    }
    
    header('Location: ../cart.php');
    exit;
}