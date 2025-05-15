<?php include 'components/header.php'; ?>

<div class="container mx-auto min-h-screen flex justify-center items-center">
    <div class="w-full md:w-1/2 lg:w-1/3 bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Регистрация</h2>
        <form action="services/register_action.php" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Имя:</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Пароль:</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Зарегистрироваться</button>
        </form>
        <p class="text-center mt-4">Уже есть аккаунт? <a href="auth.php" class="text-blue-500">Войти</a></p>
    </div>
</div>

<?php include 'components/footer.php'; ?>