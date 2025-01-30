@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Show Page</h5>
                            </div>
                            <a href="{{ route('admin.pages.index') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">-&nbsp; Back</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-2 mx-4">
                        <div class="table-responsive p-0">
                            <div class="row">
                                <div class="col-7">
                                    <!-- Title -->
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <p>{{ $page->title }}</p>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <p>{{ $page->description }}</p>
                                    </div>

                                    <!-- Block Container -->
                                    <div id="block-container">
                                        @foreach (json_decode($page->blocks) as $block)
                                            <div class="block {{ $block->type }}">
                                                <h3>{{ $block->title }}</h3>
                                                <p>{{ $block->description }}</p>
                                                <a href="{{ $block->link }}" target="_blank">Read More</a>

                                                <!-- Handle Block Types -->
                                                @if ($block->type == 'image' && isset($block->image_path))
                                                    <div class="block-image">
                                                        <img src="{{ asset('storage/' . $block->image_path) }}"
                                                            alt="{{ $block->title }}" class="img-fluid">
                                                    </div>
                                                @elseif ($block->type == 'video')
                                                    <div class="block-video">
                                                        <!-- Assuming the video link is a YouTube URL -->
                                                        <iframe width="560" height="315" src="{{ $block->link }}"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    </div>
                                                @elseif ($block->type == 'quote')
                                                    <blockquote>
                                                        <p>{{ $block->description }}</p>
                                                        <footer>- {{ $block->title }}</footer>
                                                    </blockquote>
                                                @elseif ($block->type == 'gallery')
                                                    <div class="block-gallery">
                                                        <!-- You can use a carousel or grid layout for the gallery items -->
                                                        <p>{{ $block->description }}</p>
                                                        @if (isset($block->gallery_paths) && is_array($block->gallery_paths) && count($block->gallery_paths) > 0)
                                                            <div class="block-gallery">
                                                                <!-- Gallery images display -->
                                                                <p>{{ $block->description }}</p>
                                                                @foreach ($block->gallery_paths as $galleryPath)
                                                                    <img src="{{ asset('storage/' . $galleryPath) }}"
                                                                        alt="Gallery Image" class="img-fluid">
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                    </div>
                                                @elseif ($block->type == 'custom')
                                                    <div class="block-custom">
                                                        <p>{{ $block->description }}</p>
                                                    </div>
                                                @elseif ($block->type == 'hero-section')
                                                    <div class="block-hero">
                                                        <h4>{{ $block->hero_section_title }}</h4>
                                                        <p>{{ $block->hero_section_description }}</p>
                                                        @if (isset($block->hero_section_image))
                                                            <img src="{{ asset('storage/' . $block->hero_section_image) }}"
                                                                alt="Hero Image" class="img-fluid">
                                                        @endif
                                                    </div>
                                                @elseif ($block->type == 'splitwithimage')
                                                    <div class="block-split-with-image">
                                                        <h4>{{ $block->split_with_image_title }}</h4>
                                                        <p>{{ $block->split_with_image_description }}</p>
                                                        <a href="{{ $block->split_with_image_button_link }}"
                                                            target="{{ $block->split_with_image_button_target }}">
                                                            {{ $block->split_with_image_button_text }}</a>

                                                        @if (isset($block->split_with_image_image))
                                                            <img src="{{ asset('storage/' . $block->split_with_image_image) }}"
                                                                alt="Split With Image" class="img-fluid">
                                                        @endif
                                                    </div>
                                                @elseif ($block->type == 'threecolumns')
                                                    <div class="block-three-columns">
                                                        @foreach ($block->three_column_items as $threeColumnItem)
                                                            <div class="column-item">
                                                                <h5>{{ $threeColumnItem->title }} </h5>
                                                                <p>{{ $threeColumnItem->description }}</p>

                                                                @if (isset($threeColumnItem->image_path))
                                                                    <img src="{{ asset('storage/' . $threeColumnItem->image_path) }}"
                                                                        alt="{{ $threeColumnItem->title }}"
                                                                        class="img-fluid">
                                                                @endif
                                                                @if (isset($threeColumnItem->button_text))
                                                                    <a href="{{ $threeColumnItem->button_link }}"
                                                                        target="{{ $threeColumnItem->target }}">
                                                                        {{ $threeColumnItem->button_text }}</a>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Sidebar with additional information -->
                                <div class="col-5">
                                    @include('components.rightsidebar', [
                                        'statusText' => $page->status ? 'Active' : 'Inactive',
                                        'slug' => $page->slug,
                                        'createdAt' => $page->created_at,
                                        'updatedAt' => $page->updated_at,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
