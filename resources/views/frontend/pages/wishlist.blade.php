@extends('frontend.layouts.app')
@section('title', 'Wishlist')

@section('content')
    <div class="container mx-auto  my-9">
        <div class="mt-6 grid grid-cols-4 gap-4 sm:mt-8">
            @foreach ($wishlistItems as $item)
                <div
                    class="space-y-6 overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <a href="/product/{{ $item->product->id }}" class="overflow-hidden rounded">
                        @if ($item->product->images->isNotEmpty())
                            <img class="mx-auto h-44 w-44 dark:hidden"
                                src="{{ Storage::url($item->product->images->first()->path) }}"
                                alt="{{ $item->product->images->first()->alt }}">
                            <img class="mx-auto hidden h-44 w-44 dark:block"
                                src="{{ Storage::url($item->product->images->first()->path) }}"
                                alt="{{ $item->product->images->first()->alt }}">
                        @else
                            <img class="mx-auto h-44 w-44 dark:hidden"
                                src="{{ asset('assets/default/pexels-photo-821651.jpeg') }}" alt="product image">
                            <img class="mx-auto hidden h-44 w-44 dark:block"
                                src="{{ asset('assets/default/pexels-photo-821651.jpeg') }}" alt="product image">
                        @endif
                    </a>
                    <div>
                        <a href="#"
                            class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">{{ $item->product->title }}</a>
                        <div class="mt-2 text-base font-normal text-gray-500 dark:text-gray-400">{!! $item->product->description !!}
                        </div>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            <span class="line-through"> ${{ $item->product->sell_price }} </span>
                        </p>
                        <p class="text-lg font-bold leading-tight text-red-600 dark:text-red-500">
                            ${{ $item->product->discount_price }}</p>
                    </div>
                    <div class="mt-6 flex items-center gap-2.5">
                        <button type="button"
                            class="wishlist-toggle-button inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white p-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring-4 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                            data-product-id="{{ $item->product->id }}">
                            @php
                                $isInWishlist = true; // Replace with your actual condition
                            @endphp
                            @if ($isInWishlist)
                                <!-- Heart in red if in wishlist -->
                                <svg class="h-5 w-5 text-red-600 wishlist-icon" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                </svg>
                            @else
                                <!-- Default outline heart if not in wishlist -->
                                <svg class="h-5 w-5 wishlist-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z">
                                    </path>
                                </svg>
                            @endif
                        </button>
                        <div id="favourites-tooltip-{{ $item->id }}" role="tooltip"
                            class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                            Add to favourites
                            <div class="tooltip-arrow" data-popper-arrow=""></div>
                        </div>
                        <button type="button"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium  text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4">
                                </path>
                            </svg>
                            Add to cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        document.querySelectorAll('.wishlist-toggle-button').forEach((button) => {
            button.addEventListener('click', async (e) => {
                try {
                    const buttonElement = e.currentTarget;
                    if (!buttonElement) {
                        console.error('Button element is not found.');
                        return;
                    }

                    const productId = buttonElement.dataset.productId;
                    if (!productId) {
                        console.error('Product ID is missing.');
                        return;
                    }

                    // Send an AJAX request to remove the product from the wishlist
                    const response = await fetch(`/wishlist/remove/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    });

                    if (response.ok) {
                        // Remove the parent card element of the item from the DOM
                        const wishlistItem = buttonElement.closest('.space-y-6');
                        if (wishlistItem) {
                            wishlistItem.remove();
                            toastr.success('Item removed from the wishlist!');
                        } else {
                            console.error('Wishlist item container not found.');
                            toastr.error('Failed to find the wishlist item container.');
                        }
                    } else {
                        console.error('Failed to remove the item from the wishlist.');
                        toastr.error('Failed to remove the item from the wishlist.');
                    }
                } catch (error) {
                    console.error('An error occurred:', error);
                    console.error('An error occurred:', error);
                }
            });
        });
    </script>


@endsection
