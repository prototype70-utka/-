<?php
include 'components/header.php';
include 'services/db.php';

$stmt = $pdo->query("SELECT * FROM clothes");
$clothes = $stmt->fetchAll();
?>

<div class="container mx-auto py-16 px-2 md:px-4">
    <h2 class="text-4xl font-bold text-center mb-12 text-blue-700">Каталог</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($clothes as $clothe): ?>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
                <img src="<?php echo htmlspecialchars($clothe['image']); ?>"
                    alt="<?php echo htmlspecialchars($clothe['name']); ?>" class="w-full h-96 object-cover">
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold mb-2 text-gray-800"><?php echo htmlspecialchars($clothe['name']); ?></h3>
                    <p class="text-gray-600 mb-4 flex-grow"><?php echo htmlspecialchars($clothe['description']); ?></p>
                    <p class="text-lg font-semibold text-gray-900 mb-4">Цена:
                        <?php echo htmlspecialchars($clothe['price']); ?> руб
                    </p>
                    <form action="services/add_to_cart.php" method="POST" class="mt-auto flex flex-col">
    <input type="hidden" name="clothe_id" value="<?= $clothe['id'] ?>">
    <div class="flex items-center gap-2 mb-4">
        <button type="button" class="quantity-minus bg-gray-200 px-3 py-1 rounded">-</button>
        <input type="number" name="quantity" value="1" min="1" class="w-16 text-center">
        <button type="button" class="quantity-plus bg-gray-200 px-3 py-1 rounded">+</button>
    </div>
    <button type="submit" 
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        В корзину
    </button>
</form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
document.querySelectorAll('.quantity-minus').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = btn.nextElementSibling;
        if(input.value > 1) input.value--;
    });
});

document.querySelectorAll('.quantity-plus').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = btn.previousElementSibling;
        input.value++;
    });
});
</script>
<?php include 'components/footer.php'; ?>