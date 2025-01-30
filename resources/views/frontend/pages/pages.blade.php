@extends('frontend.layouts.app')

@section('title', $page->title . ' | Page')

@section('content')
    <div class="page-content">
        <!-- Page Title -->
        <h1 class="text-3xl font-semibold mb-4">{{ $page->title }}</h1>

        <!-- Page Description -->
        <div class="mb-8 text-lg text-gray-700">
            {!! $page->description !!}
        </div>

        <!-- Loop through and display the blocks -->
        @foreach ($blocks as $block)
            @php
                // Handle block types dynamically
                $blockType = $block['type'] ?? 'default';
            @endphp
            <div class="block-container mb-8">
                @include('frontend.blocks.' . $blockType, ['block' => $block])
            </div>
        @endforeach
    </div>
@endsection
