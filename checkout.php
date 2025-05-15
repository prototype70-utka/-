<?php
include 'components/header.php';
include 'services/db.php';

// Проверка авторизации
if(!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit;
}

// Получаем данные корзины
$stmt = $pdo->prepare("
    SELECT c.*, cl.name, cl.price 
    FROM cart c 
    JOIN clothes cl ON c.clothe_id = cl.id 
    WHERE user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll();

// Вычисляем итоговую сумму
$total = array_sum(array_map(function($item) {
    return $item['price'] * $item['quantity'];
}, $cart_items));

// Оформление заказа
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();
        
        // Создаем заказ
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $order_id = $pdo->lastInsertId();
        
        // Добавляем товары
        foreach($cart_items as $item) {
            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, clothe_id, quantity, price)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $order_id,
                $item['clothe_id'],
                $item['quantity'],
                $item['price']
            ]);
        }
        
        // Очищаем корзину
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        
        $pdo->commit();
        header('Location: profile.php');
        exit;
        
    } catch(Exception $e) {
        $pdo->rollBack();
        die("Ошибка оформления заказа: " . $e->getMessage());
    }
}
?>

<div class="container mx-auto py-16 px-4">
    <h2 class="text-4xl font-bold text-center mb-12">Оформление заказа</h2>
    
    <form method="POST">
        <div class="grid md:grid-cols-1 gap-8">
           
            
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Ваш заказ</h3>
                
                <?php foreach($cart_items as $item): ?>
                    <div class="flex justify-between mb-2">
                        <span><?= htmlspecialchars($item['name']) ?> x<?= $item['quantity'] ?></span>
                        <span><?= number_format($item['price'] * $item['quantity'], 2) ?> руб</span>
                    </div>
                <?php endforeach; ?>
                
                <hr class="my-4">
                
                <div class="flex justify-between text-xl font-bold">
                    <span>Итого:</span>
                    <span><?= number_format($total, 2) ?> руб</span>
                </div>
                
                <button type="submit" 
                        class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-6">
                    Подтвердить заказ
                </button>
            </div>
        </div>
    </form>
</div>

<?php include 'components/footer.php'; ?>