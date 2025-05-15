<?php
include 'components/header.php';
include 'services/db.php';

// Получаем содержимое корзины
$cart = [];
if(isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("
        SELECT c.*, cl.name, cl.price, cl.image 
        FROM cart c 
        JOIN clothes cl ON c.clothe_id = cl.id 
        WHERE user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $cart = $stmt->fetchAll();
} elseif(isset($_SESSION['cart'])) {
    $ids = array_column($_SESSION['cart'], 'clothe_id');
    if(!empty($ids)) {
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $pdo->prepare("SELECT * FROM clothes WHERE id IN ($in)");
        $stmt->execute($ids);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($_SESSION['cart'] as $item) {
            foreach($products as $product) {
                if($product['id'] == $item['clothe_id']) {
                    $cart[] = [
                        'clothe_id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $product['image'],
                        'quantity' => $item['quantity']
                    ];
                }
            }
        }
    }
}
?>

<div class="container mx-auto py-16 px-4">
    <h2 class="text-4xl font-bold text-center mb-12">Корзина</h2>
    
    <?php if(empty($cart)): ?>
        <p class="text-center">Корзина пуста</p>
    <?php else: ?>
        <div class="grid gap-8">
            <?php $total = 0; ?>
            <?php foreach($cart as $item): ?>
                <div class="bg-white shadow-lg rounded-lg p-6 flex gap-6">
                <img src="<?= htmlspecialchars($item['image']) ?>" 
         alt="<?= htmlspecialchars($item['name']) ?>" 
         class="w-32 h-32 object-cover">
                    
                    <div class="flex-grow">
                        <h3 class="text-xl font-bold"><?= htmlspecialchars($item['name']) ?></h3>
                        <div class="flex items-center gap-4 mt-4">
                            <form action="services/update_cart.php" method="POST" class="flex items-center gap-2">
                                <input type="hidden" name="clothe_id" value="<?= $item['clothe_id'] ?>">
                                <button type="submit" name="action" value="decrease" 
                                        class="bg-gray-200 px-3 py-1 rounded">-</button>
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" 
                                       class="w-16 text-center" min="1">
                                <button type="submit" name="action" value="increase" 
                                        class="bg-gray-200 px-3 py-1 rounded">+</button>
                            </form>
                            
                            <form action="services/remove_from_cart.php" method="POST">
                                <input type="hidden" name="clothe_id" value="<?= $item['clothe_id'] ?>">
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-xl font-bold">
                            <?= number_format($item['price'] * $item['quantity'], 2) ?> руб
                        </p>
                    </div>
                </div>
                <?php $total += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>
            
            <div class="bg-white shadow-lg rounded-lg p-6 mt-8">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold">Итого: <?= number_format($total, 2) ?> руб</h3>
                    <a href="checkout.php" 
                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Оформить заказ
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'components/footer.php'; ?>