<header class="bg-white shadow-md">
    <!-- Top Bar -->
    <div class="bg-gray-100 text-sm py-2">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div class="flex space-x-4">
                <span>Contact: +123 456 7890</span>
                <span>Email: support@example.com</span>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="hover:underline">Language</a>
                <a href="#" class="hover:underline">Currency</a>
                <a href="#" class="hover:text-gray-500">Facebook</a>
                <a href="#" class="hover:text-gray-500">Twitter</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="text-2xl font-bold">ShopLogo</a>

        <!-- Search Bar -->
        <div class="flex-1 mx-4">
            <input type="text" placeholder="Search products..."
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Navigation Menu -->
        <nav class="hidden md:flex space-x-6">
            <a href="#" class="text-gray-700 hover:text-blue-500">Men</a>
            <a href="#" class="text-gray-700 hover:text-blue-500">Women</a>
            <a href="#" class="text-gray-700 hover:text-blue-500">Kids</a>
            <a href="#" class="text-gray-700 hover:text-blue-500">Sale</a>
        </nav>

        <!-- User Icons -->
        <div class="flex space-x-4">
            <a href="{{ route('wishlist.items') }}" class="text-gray-700 hover:text-blue-500">
                <i class="fas fa-heart"></i> <!-- Wishlist -->
            </a>
            <a href="http://127.0.0.1:8000/login" class="text-gray-700 hover:text-blue-500">
                <i class="fas fa-user"></i> <!-- User Account -->
            </a>
            <a href="{{ route('cart.showData') }}" class="text-gray-700 hover:text-blue-500 relative" id="cartButton">
                <i class="fas fa-shopping-cart"></i> <!-- Cart -->
                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1"
                    id="cartCount">0</span>
            </a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cartButton = document.getElementById('cartButton');
        const cartModal = document.getElementById('cartModal');
        const closeCart = document.getElementById('closeCart');

        // Handle opening and closing the modal
        if (cartButton) {
            cartButton.addEventListener('click', () => {
                // Toggle modal visibility
                if (cartModal.classList.contains('hidden')) {
                    cartModal.classList.remove('hidden');
                    setTimeout(() => {
                        cartModal.classList.remove('translate-x-full');
                        cartModal.classList.add('translate-x-0'); // Slide-in effect
                    }, 10);
                    loadCartItems(); // Fetch cart items when the modal is shown
                }
            });
        }

        if (closeCart) {
            closeCart.addEventListener('click', () => {
                cartModal.classList.add('translate-x-full'); // Slide-out effect
                setTimeout(() => {
                    cartModal.classList.add('hidden');
                    cartModal.classList.remove('translate-x-full');
                }, 300); // Match the duration of the transition
            });
        }

        // Close modal when clicking outside of it
        window.addEventListener('click', (event) => {
            if (event.target === cartModal) {
                closeCart.click();
            }
        });

        updateCartCount(); // Fetch and update cart count on page load
    });
    // Fetch and update cart count
    function updateCartCount() {
        fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch cart count');
                }
                return response.json();
            })
            .then(data => {
                const cartCountElement = document.getElementById('cartCount');
                if (cartCountElement) {
                    cartCountElement.textContent = data.cartCount; // Update the cart count in the DOM
                }
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
            });
    }
</script>
