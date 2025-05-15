<?php include 'components/header.php'; ?>

<div class="container mx-auto py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Контакты</h2>
    <div class="flex flex-wrap justify-around px-3">
        <div class="w-full p-4 mb-3 bg-white shadow-lg rounded-lg text-center">
            <div class="block md:flex justify-between">
                <p>Телефон: +7 (123) 456-78-90</p>
                <p>Email: info@forest.ru</p>
                <p>График работы: ежедневно, 10:00 - 19:00</p>
            </div>
        </div>
        <div class="w-full p-4 mb-8 bg-white shadow-lg rounded-lg text-center">
            <h3 class="text-xl font-bold mb-2">Наш адрес</h3>
            <p>улица Попова, 70д, Барнаул, Россия</p>
            <div class="mt-4">
                <div id="map" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);
    function init() {
        var myMap = new ymaps.Map("map", {
            center: [53.37049339907132,83.67534554074241],
            zoom: 16
        });

        var myPlacemark = new ymaps.Placemark([53.37038851627424,83.6753709419462], {
            hintContent: 'улица Попова, 70д',
            balloonContent: 'улица Попова, 70д, Барнаул, Россия'
        });

        myMap.geoObjects.add(myPlacemark);
    }
</script>