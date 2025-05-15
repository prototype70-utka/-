<footer class="bg-white text-black p-4 mt-8">
    <div class="container mx-auto md:flex justify-between text-center">
        <p>&copy; 2025 ООО "ФОРЕСТ". Все права защищены.</p>
        <p class="font-medium">улица Попова, 70д, Барнаул</p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function () {
        $('.slick-slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            nextArrow: '<button type="button" class="slick-next">Next</button>',
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
        });
    });
</script>
</body>

</html>