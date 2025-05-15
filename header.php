<?php
session_start();
include 'services/db.php';

$is_admin = false;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $is_admin = $user['role'] == 'admin';
}
?>
<?php
$cart_count = 0;
if(isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT SUM(quantity) FROM cart WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cart_count = $stmt->fetchColumn() ?? 0;
} elseif(isset($_SESSION['cart'])) {
    $cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Уютный трикотаж</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        /* Скрыть стрелки на мобильных устройствах */
        .quantity-input {
        -moz-appearance: textfield;
        width: 50px;
        text-align: center;
    }
    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .order-details-btn {
        transition: transform 0.2s;
    }
    .order-details-btn:hover {
        transform: scale(1.1);
    }

        /* Сделать стрелки синими и расположить их внутри слайдера на ПК */
        @media (min-width: 309px) {

            .slick-prev,
            .slick-next {
                color: blue !important;
                z-index: 1;
                top: 50%;
                transform: translateY(-50%);
            }

            .slick-prev {
                left: 10px;
            }

            .slick-next {
                right: 10px;
            }


        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">
    <header class="bg-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-blue-700">УЮТНЫЙ ТРИКОТАЖ</a>

            <button id="mobile-menu-btn" class="block lg:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <nav class="hidden lg:flex lg:items-center lg:space-x-4">
                <a href="index.php">Главная</a>
                <a href="catalog.php">Каталог</a>
                <a href="contacts.php">Контакты</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">Профиль</a>
                    <?php if ($is_admin): ?>
                        <a href="admin_panel.php">Админ панель</a>
                    <?php endif; ?>
                    <a href="services/logout.php">Выйти</a>
                <?php else: ?>
                    <a href="auth.php">Войти</a>
                <?php endif; ?>
                <a href="cart.php" class="relative">
        <i class="fas fa-shopping-cart"></i>
        <?php if($cart_count > 0): ?>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">
                <?= $cart_count ?>
            </span>
        <?php endif; ?>
    </a>
            </nav>
        </div>
    </header>

    <nav id="mobile-menu" class="hidden lg:hidden text-center">
        <a href="index.php" class="block py-2">Главная</a>
        <a href="catalog.php" class="block py-2">Каталог</a>
        <a href="contacts.php" class="block py-2">Контакты</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php" class="block py-2">Профиль</a>
            <?php if ($is_admin): ?>
                <a href="admin_panel.php" class="block py-2">Админ панель</a>
            <?php endif; ?>
            <a href="services/logout.php" class="block py-2">Выйти</a>
        <?php else: ?>
            <a href="auth.php" class="block py-2">Войти</a>
        <?php endif; ?>
    </nav>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>