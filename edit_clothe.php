<?php

include 'components/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../admin_panel.php');
    exit();
}

$clothe_id = $_GET['id'];
$clothe_stmt = $pdo->prepare("SELECT * FROM clothes WHERE id = ?");
$clothe_stmt->execute([$clothe_id]);
$clothe = $clothe_stmt->fetch();

if (!$clothe) {
    echo "Одежда не найдена";
    exit();
}
?>

<div class="container mx-auto py-16">
    <div class="flex justify-center">
        <div class="w-full md:w-3/4 bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">Редактировать товар</h2>
            <form action="update_clothe.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="clothe_id" value="<?php echo $clothe['id']; ?>">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Название:</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1"
                        value="<?php echo htmlspecialchars($clothe['name']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Описание:</label>
                    <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded mt-1"
                        required><?php echo htmlspecialchars($clothe['description']); ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Цена:</label>
                    <input type="number" id="price" name="price" class="w-full p-2 border border-gray-300 rounded mt-1"
                        value="<?php echo htmlspecialchars($clothe['price']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-gray-700">Изображение:</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded mt-1">
                    <p>Текущее изображение: <img src="<?php echo htmlspecialchars($clothe['image']); ?>"
                            alt="<?php echo htmlspecialchars($clothe['name']); ?>" class="w-16 h-16 object-cover"></p>
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Сохранить
                    изменения</button>
            </form>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>