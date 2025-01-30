<div class="container mx-auto p-4">
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($products as $product)
            <!-- Product Card {{ $loop->iteration }}-->
            <div
                class=" hover:shadow-md transform transition duration-500 hover:scale-104 flex flex-row lg:flex-col mb-3 bg-white mx-auto rounded-md relative cursor-pointer">
                <section class="mx-auto relative w-2/5 lg:w-full  border-b "><!--lg:h-[325px]-->
                    <section
                        class="absolute flex flex-row items-center top-0 left-0 text-xs z-10 text-primaryFont font-semibold">
                        <div class="py-1 desktop:px-2 px-3 lg:flex flex-row items-center bg-green-600 text-white hidden">
                            <i class="fi fi-sr-bolt text-primaryCyan pt-1 pr-1"></i>
                            <span>Flash Sale</span>
                        </div>
                        <div
                            class="flex flex-row items-center bg-green-400 pr-4 py-1 text-[11px] rounded-br-3xl text-white pl-2">
                            🕔
                            <span class="pl-1">23 : 23: 00</span>
                        </div>
                    </section>
                    <!-- Product Image with Wishlist Icon -->
                    <div class="relative">
                        @if ($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                                alt="{{ $product->images->first()->alt }}"
                                class="mx-auto lg:rounded-t-md lg:rounded-b-none rounded-md p-1 lg:p-0" />
                        @else
                            <img src="{{ asset('assets/default/pexels-photo-821651.jpeg') }}" alt="Product Name"
                                class="mx-auto lg:rounded-t-md lg:rounded-b-none rounded-md p-1 lg:p-0" />
                        @endif
                        <div onclick="addToWishlist({{ $product->id }}, this)"
                            class="absolute top-2 right-2 text-black group-hover:opacity-100 transition-opacity duration-300 cursor-pointer">
                            <i
                                class="far fa-heart text-xl heart-icon-{{ $product->id }}  {{ in_array($product->id, $wishlistProductIds) ? 'fas fa-heart text-red-500' : '' }}"></i>
                        </div>
                    </div>
                </section>
                <a class="" href="/product/{{ $product->id }}">
                    <section class="p-2 w-3/5 lg:w-full h-[150px] relative">
                        <section class="flex flex-row items-start">
                            <h1 class="text-base text-black line-clamp-2 capitalize" title="{{ $product->title }}">
                                {{ $product->title }}
                            </h1>
                        </section>
                        <section class="flex flex-row items-center mt-1">
                            <div class="text-green-700 text-xl font-bold mr-2">
                                ₹ {{ $product->discount_price }}
                            </div>
                            <div class="text-black-200 text-base line-through">
                                ₹{{ $product->sell_price }}
                            </div>
                        </section>
                        <section class="flex flex-row items-center mb-1">
                            @php
                                // Calculate the amount saved and the percentage discount
                                $amountSaved = $product->sell_price - $product->discount_price;
                                $percentageOff = ($amountSaved / $product->sell_price) * 100;
                            @endphp

                            <span class="text-xs text-gray-600 font-medium">
                                You Save ₹ {{ number_format($amountSaved) }}
                            </span>
                            <span class="text-xs text-green-900 ml-1 font-medium">
                                ({{ number_format($percentageOff, 0) }}% off)
                            </span>
                        </section>
                        <section>
                            <p class="text-gray-600 text-xs ">
                                EMI starts from <span>Rs.333/month</span>
                            </p>
                            <div class="flex flex-row items-center mt-1 text-red-400 text-sm ">
                                <span class="ml-1">Delivery in 6 days</span>
                            </div>
                        </section>
                    </section>
                </a>
            </div>
        @endforeach
    </section>
    <script>
        function addToWishlist(productId, iconElement) {
            let icon = iconElement.querySelector('i');

            // Toggle the icon immediately when clicked
            let isInWishlist = icon.classList.contains('fas') && icon.classList.contains('text-red-500');

            if (isInWishlist) {
                // If the product is already in the wishlist, remove it
                icon.classList.remove('fas', 'text-red-500');
                icon.classList.add('far');
            } else {
                // If the product is not in the wishlist, add it
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-red-500');
            }

            // Make the API call to add or remove from wishlist
            fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // If the action (add or remove) was successful, show the appropriate message
                        if (isInWishlist) {
                            toastr.error(data.message); // Removed from wishlist
                        } else {
                            toastr.success(data.message); // Added to wishlist
                        }
                    } else {
                        // If there's an error, revert the icon
                        icon.classList.remove('fas', 'text-red-500');
                        icon.classList.add('far');
                        toastr.error('There was an error with your wishlist action. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error updating wishlist:', error);
                    // If an error occurs, revert the icon and show error message
                    icon.classList.remove('fas', 'text-red-500');
                    icon.classList.add('far');
                    toastr.error('Could not update your wishlist. Please try again.');
                });
        }
    </script>
</div>
