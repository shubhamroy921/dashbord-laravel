<style>
    /* Custom Styling for the Slider */
    .slick-slide {
        transition: transform 0.5s ease;
    }
</style>
<!-- Slick Slider CSS -->
<link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" rel="stylesheet">
<!-- jQuery (required for Slick Slider) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Slick Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<!-- Banner Slider Section -->
<div class="mx-auto mt-8">
    <div class="banner-slider">
        <!-- Slide 1 -->
        <div class="relative">
            <img src="{{ asset('storage/'.'uploads/1737091664_maintainence.png') }}" alt="Banner 1" class="w-40 h-auto rounded-lg">
            <div class="absolute top-0 left-0 w-40 h-auto bg-black opacity-50"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white">
                <h2 class="text-4xl font-bold text-gray-800">Welcome to Our Store!</h2>
                <p class="mt-2 text-lg text-gray-500">Best deals and discounts await you!</p>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="relative">
            <img src="{{ asset('storage/'.'uploads/1737091664_maintainence.png') }}" alt="Banner 2"
                class="w-40 h-auto rounded-lg">
            <div class="absolute top-0 left-0 w-40 h-auto bg-black opacity-50"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white">
                <h2 class="text-4xl font-bold text-gray-800">Huge Sale on Electronics!</h2>
                <p class="mt-2 text-lg text-gray-500">Save up to 50% off on all gadgets.</p>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="relative">
            <img src="{{ asset('storage/'.'uploads/1737091664_maintainence.png') }}" alt="Banner 3"
                class="w-40 h-auto rounded-lg">
            <div class="absolute top-0 left-0 w-40 h-auto bg-black opacity-50"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white">
                <h2 class="text-4xl font-bold text-gray-800">Seasonal Collection Available</h2>
                <p class="mt-2 text-lg text-gray-500">Discover the latest trends in fashion!</p>
            </div>
        </div>
    </div>
</div>

<!-- Initialize Slick Slider -->
<script>
    $(document).ready(function() {
        $('.banner-slider').slick({
            dots: true, // Show navigation dots
            arrows: false, // Hide next/prev arrows
            autoplay: true, // Enable autoplay
            autoplaySpeed: 3000, // Set autoplay speed (in ms)
            fade: true, // Smooth fade transition between slides
            speed: 1000, // Transition speed (in ms)
            easing: 'ease-in-out', // Apply easing for a smooth effect
        });
    });
</script>
