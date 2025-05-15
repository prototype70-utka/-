<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clothe_id = $_POST['clothe_id'];
    $quantity = $_POST['quantity'] ?? 1;

    if(isset($_SESSION['user_id'])) {
        // Для авторизованных пользователей
        $user_id = $_SESSION['user_id'];
        
        // Проверяем есть ли уже товар в корзине
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND clothe_id = ?");
        $stmt->execute([$user_id, $clothe_id]);
        $existing = $stmt->fetch();

        if($existing) {
            // Обновляем количество
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE id = ?");
            $stmt->execute([$quantity, $existing['id']]);
        } else {
            // Добавляем новый товар
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, clothe_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $clothe_id, $quantity]);
        }
    } else {
        // Для гостей (в сессии)
        $_SESSION['cart'] = $_SESSION['cart'] ?? [];
        $found = false;
        
        foreach($_SESSION['cart'] as &$item) {
            if($item['clothe_id'] == $clothe_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        if(!$found) {
            $_SESSION['cart'][] = [
                'clothe_id' => $clothe_id,
                'quantity' => $quantity
            ];
        }
    }
    
    header('Location: ../cart.php');
    exit;
}