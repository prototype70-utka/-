<?php include 'components/header.php'; ?>

<div class="hero bg-cover bg-center h-[800px] relative" style="background-image: url('uploads/отдел.jpg');">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="container mx-auto h-full flex items-center justify-center relative z-10 px-4">
        <div class="text-center text-gray-700 backdrop-blur-sm bg-white/50 p-8 rounded-xl">
            <h1 class="text-5xl font-bold mb-4">Добро пожаловать в <a class="text-blue-700">УЮТНЫЙ ТРИКОТАЖ</a></h1>
            <p class="text-xl font-medium mb-8">Лучший трикотаж по доступным ценам</p>

            <a href="catalog.php"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Посмотреть каталог</a>

        </div>

    </div>
</div>

<div class="container mx-auto py-16 px-4">
    <!-- Слайдер с рекламными предложениями и акциями -->
    <div class="slick-slider">
        <div class="relative">
            <img src="uploads/слайдер1.jpg" alt="Акция 1" class="w-full h-[600px] object-cover rounded-lg">
            <div class="absolute inset-0 flex flex-col justify-end items-start text-white p-4 rounded-lg">
                <h3 class="text-2xl font-bold bg-blue-700 px-4 py-2 rounded-lg">Одежда для всей семьи</h3>

            </div>
        </div>
        <div class="relative">
            <img src="uploads/слайдер2.jpg" alt="Акция 2" class="w-full h-[600px] object-cover rounded-lg">
            <div class="absolute inset-0 flex flex-col justify-end items-start text-white p-4 rounded-lg">
                <h3 class="text-2xl font-bold bg-blue-700 px-4 py-2 rounded-lg">Наши клиенты</h3>

            </div>
        </div>
        <div class="relative">
            <img src="uploads/слайдер3.jpg" alt="Акция 3" class="w-full h-[600px] object-cover rounded-lg">
            <div class="absolute inset-0 flex flex-col justify-end items-start text-white p-4 rounded-lg">
                <h3 class="text-2xl font-bold bg-blue-700 px-4 py-2 rounded-lg">Качественные материалы</h3>

            </div>
        </div>
    </div>

    <!-- Основная информация об организации -->
    <div class="mt-16 bg-white py-16 px-8 rounded-lg shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-4xl font-bold text-center mb-8 text-blue-700">О нас</h2>
            <div class="flex flex-col md:flex-row items-center justify-center">

                <div class="md:w-1/2 md:pl-8">
                    <p class="text-lg leading-relaxed text-gray-700">"Уютный трикотаж" предлагает лучший трикотаж по
                        доступным ценам. Мы гордимся нашим широким выбором и отличным обслуживанием клиентов. Наша
                        цель - предоставить вам комфортные вещи на каждый день.</p>
                    <p class="text-lg leading-relaxed mt-4 text-gray-700">Мы предлагаем различные виды трикотажа, от
                        футболок до нижнего белья, чтобы удовлетворить любые ваши потребности. Наши клиенты
                        всегда довольны нашим товаром и качеством.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Преимущества -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold text-center mb-12">Наши преимущества</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white shadow-lg rounded-lg text-center p-6">
                <div class="text-blue-500 mb-4">
                    <i class="fas fa-tshirt fa-3x"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Большой выбор одежды</h3>
                <p>У нас вы найдете трикотаж на любой вкус и бюджет.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg text-center p-6">
                <div class="text-green-500 mb-4">
                    <i class="fas fa-ruble-sign fa-3x"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Доступные цены</h3>
                <p>Мы предлагаем лучшие цены на рынке.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg text-center p-6">
                <div class="text-yellow-500 mb-4">
                    <i class="fas fa-star fa-3x"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Отличное обслуживание</h3>
                <p>Наши клиенты всегда довольны нашим сервисом.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>