@extends('frontend.layouts.app')
@section('title', 'Order Success')

@section('content')
<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Order Successful</h2>
        <p class="mt-4 text-base text-gray-600 dark:text-gray-400">Thank you for your purchase! Your order has been successfully placed.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-flex items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Continue Shopping
        </a>
    </div>
</section>
@endsection
