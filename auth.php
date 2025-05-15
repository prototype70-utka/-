<?php include 'components/header.php'; ?>

<div class="container mx-auto min-h-screen flex justify-center items-center">
    <div class="w-full md:w-1/2 lg:w-1/3 bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Авторизация</h2>
        <form action="services/login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Пароль:</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Войти</button>
        </form>
        <p class="text-center mt-4">Нет аккаунта? <a href="register.php" class="text-blue-500">Зарегистрироваться</a></p>
    </div>
</div>

<?php include 'components/footer.php'; ?>