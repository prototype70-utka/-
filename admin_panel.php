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

if ($user['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

$users_stmt = $pdo->query("SELECT * FROM users");
$users = $users_stmt->fetchAll();

$clothes_stmt = $pdo->query("SELECT * FROM clothes");
$clothes = $clothes_stmt->fetchAll();


?>

<div class="container mx-auto py-16 px-4">
    <div class="flex justify-center">
        <div class="w-full lg:w-3/4 bg-white p-2 md:p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">Панель управления</h2>

            <!-- Пользователи -->
            <h3 class="text-xl font-bold mb-4">Пользователи</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto mb-8">
                    <thead>
                        <tr>
                            <th class="px-2 md:px-4 py-2">ID</th>
                            <th class="px-2 md:px-4 py-2">Имя</th>
                            <th class="px-2 md:px-4 py-2">Email</th>
                            <th class="px-2 md:px-4 py-2">Роль</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="border px-2 md:px-4 py-2"><?php echo $user['id']; ?></td>
                                <td class="border px-2 md:px-4 py-2"><?php echo htmlspecialchars($user['name']); ?></td>
                                <td class="border px-2 md:px-4 py-2"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="border px-2 md:px-4 py-2"><?php echo $user['role']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Добавить нового админа -->
            <h3 class="text-xl font-bold mb-4">Добавить нового админа</h3>
            <form action="services/register_admin.php" method="POST" class="mb-8">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Имя:</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1"
                        required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Пароль:</label>
                    <input type="password" id="password" name="password"
                        class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Добавить
                    админа</button>
            </form>

            <!-- Одежда -->
            <h3 class="text-xl font-bold mb-4">Одежда</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto mb-8">
                    <thead>
                        <tr>
                            <th class="px-2 md:px-4 py-2">ID</th>
                            <th class="px-2 md:px-4 py-2">Название</th>
                            <th class="px-2 md:px-4 py-2">Описание</th>
                            <th class="px-2 md:px-4 py-2">Цена</th>
                            <th class="px-2 md:px-4 py-2">Изображение</th>
                            <th class="px-2 md:px-4 py-2">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clothes as $clothe): ?>
                            <tr>
                                <td class="border px-2 md:px-4 py-2"><?php echo $clothe['id']; ?></td>
                                <td class="border px-2 md:px-4 py-2"><?php echo htmlspecialchars($clothe['name']); ?></td>
                                <td class="border px-2 md:px-4 py-2"><?php echo htmlspecialchars($clothe['description']); ?>
                                </td>
                                <td class="border px-2 md:px-4 py-2"><?php echo htmlspecialchars($clothe['price']); ?></td>
                                <td class="border px-2 md:px-4 py-2"><img
                                        src="<?php echo htmlspecialchars($clothe['image']); ?>"
                                        alt="<?php echo htmlspecialchars($clothe['name']); ?>" class="w-16 h-16 object-cover">
                                </td>
                                <td class="border px-2 md:px-4 py-2">
                                    <a href="edit_clothe.php?id=<?php echo $clothe['id']; ?>"
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Редактировать</a>
                                    <form action="services/delete_clothe.php" method="POST" class="inline">
                                        <input type="hidden" name="clothe_id" value="<?php echo $clothe['id']; ?>">
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Добавить новую одежду -->
            <h3 class="text-xl font-bold mb-4">Добавить новую одежду</h3>
            <form action="services/add_clothe.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Название:</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1"
                        required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Описание:</label>
                    <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded mt-1"
                        required></textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Цена:</label>
                    <input type="number" id="price" name="price" class="w-full p-2 border border-gray-300 rounded mt-1"
                        required>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-gray-700">Изображение:</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded mt-1"
                        required>
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Добавить
                    </button>
            </form>

            
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>