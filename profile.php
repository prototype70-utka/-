<?php
include 'components/header.php';
include 'services/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$orders_stmt = $pdo->prepare("
    SELECT o.id, o.created_at, o.total, o.status, 
           GROUP_CONCAT(cl.name SEPARATOR ', ') AS items_list 
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN clothes cl ON oi.clothe_id = cl.id
    WHERE o.user_id = ?
    GROUP BY o.id
    ORDER BY o.created_at DESC
");
$orders_stmt->execute([$user['id']]);
$orders = $orders_stmt->fetchAll();
?>

<div class="container mx-auto h-[800px] flex justify-center items-center px-2">
    <div class="w-full md:w-1/2 lg:w-1/3 bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Личный кабинет</h2>
        <p><strong>Имя:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Роль:</strong> <?php echo $user['role'] == 'admin' ? 'Админ' : 'Пользователь'; ?></p>

        <h3 class="text-xl font-bold mt-6 mb-4">История заказов</h3>
<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="text-left py-2 px-4">№</th>
                <th class="text-left py-2 px-4">Дата</th>
                <th class="text-left py-2 px-4">Сумма</th>
                <th class="text-left py-2 px-4">Статус</th>
                <th class="text-left py-2 px-4">Детали</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $orders_stmt = $pdo->prepare("
                SELECT o.*, 
                COUNT(oi.id) AS items_count 
                FROM orders o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                WHERE o.user_id = ?
                GROUP BY o.id
                ORDER BY o.created_at DESC
            ");
            $orders_stmt->execute([$_SESSION['user_id']]);
            $orders = $orders_stmt->fetchAll();
            ?>
            
            <?php foreach($orders as $order): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-2 px-4">#<?= $order['id'] ?></td>
                    <td class="py-2 px-4"><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                    <td class="py-2 px-4"><?= number_format($order['total'], 2) ?> руб</td>
                    <td class="py-2 px-4">
                        <span class="px-2 py-1 rounded 
                            <?= $order['status'] == 'completed' ? 'bg-green-200' : 
                               ($order['status'] == 'cancelled' ? 'bg-red-200' : 'bg-yellow-200') ?>">
                            <?= $order['status'] ?>
                        </span>
                    </td>
                    <td class="py-2 px-4">
                        <button class="text-blue-500 hover:text-blue-700 order-details-btn" 
                                data-order-id="<?= $order['id'] ?>">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- Детали заказа (скрытый блок) -->
                <tr class="hidden details-row-<?= $order['id'] ?>">
                    <td colspan="5" class="px-4 py-2 bg-gray-50">
                        <div class="order-details-content">
                            <h4 class="font-bold mb-2">Состав заказа:</h4>
                            <ul>
                                <?php
                                $items_stmt = $pdo->prepare("
                                    SELECT oi.*, cl.name 
                                    FROM order_items oi
                                    JOIN clothes cl ON oi.clothe_id = cl.id
                                    WHERE order_id = ?
                                ");
                                $items_stmt->execute([$order['id']]);
                                $items = $items_stmt->fetchAll();
                                ?>
                                
                                <?php foreach($items as $item): ?>
                                    <li class="mb-2">
                                        <?= htmlspecialchars($item['name']) ?> 
                                        x<?= $item['quantity'] ?> 
                                        (<?= number_format($item['price'], 2) ?> руб/шт)
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    </div>
</div>
<script>
document.querySelectorAll('.order-details-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const orderId = btn.dataset.orderId;
        const detailsRow = document.querySelector(`.details-row-${orderId}`);
        detailsRow.classList.toggle('hidden');
    });
});
</script>
<?php include 'components/footer.php'; ?>