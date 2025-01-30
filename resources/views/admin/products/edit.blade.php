@extends('layouts.user_type.auth')

@section('content')
    <style>
        .upload-container {
            border: 2px dashed #ccc;
            /* Dashed border */
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            position: relative;
            cursor: pointer;
            background-color: #f9f9f9;
            transition: background-color 0.3s;
        }

        .upload-container:hover {
            background-color: #f1f1f1;
            /* Lighten background color when hovered */
        }

        .upload-label {
            display: inline-block;
            width: 100%;
            height: 100%;
        }

        .upload-message {
            font-size: 16px;
            color: #888;
            font-weight: bold;
            margin-top: 10px;
        }

        .upload-container input[type="file"] {
            display: none;
            /* Hide the default file input */
        }

        .upload-container:hover .upload-message {
            color: #555;
            /* Darken text when hovering */
        }

        /* Positioning the remove icon at the top-right corner */
        .remove-icon {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 24px;
            /* Adjust the size of the icon */
            height: 24px;
            cursor: pointer;
            z-index: 10;
            /* Make sure the icon appears on top of the image */
        }

        /* Optional hover effect for the remove icon */
        .remove-icon:hover {
            opacity: 0.7;
        }
    </style>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Edit Product</h5>
                            </div>
                            <a href="{{ route('admin.products.index') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">-&nbsp; Back</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-2 mx-4">
                        <div class="table-responsive p-0">
                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Title</label>
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', $product->title) }}" class="form-control">
                                    @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Categories -->
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">select Category</option>
                                        @foreach ($productCategory as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) === $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="3" class="form-control ckeditor">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sort -->
                                <div class="mb-3">
                                    <label for="sort" class="form-label">Sort</label>
                                    <input type="number" name="sort" id="sort"
                                        value="{{ old('sort', $product->sort) }}" class="form-control">
                                    @error('sort')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Status -->
                                <div class="mb-3 status d-flex align-items-center">
                                    <label for="status" class="form-label mb-0">Status</label>
                                    <div class="check-box flex justify-center items-center mt-2 ms-5">
                                        <input id="status" type="checkbox" class="status-checkbox" name="status"
                                            value="1"
                                            {{ old('status', $product->status ?? 0) == 1 ? 'checked' : '' }}>
                                    </div>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Image Upload and Alt Tags -->
                                <div class="mb-3">
                                    <label for="images" class="form-label">Product Images</label>
                                    <div class="upload-container">
                                        <label for="images" class="upload-label">
                                            <div class="upload-message">
                                                <p>Upload Image or Drag and Drop</p>
                                            </div>
                                        </label>
                                        <input type="file" name="images[]" id="images" multiple class="form-control"
                                            onchange="previewImages()" hidden>
                                        @error('images')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div id="image-previews" class="row" style="display: flex; flex-wrap: wrap;">
                                    <!-- Image previews and alt inputs will be inserted here -->
                                    @foreach ($product->images as $index => $image)
                                        <div class="col-3 mb-2 image-item  position-relative" draggable="true" data-index="{{ $index }}">
                                            <img src="{{ asset('storage/'.$image->path) }}" alt="Image Preview {{ $index + 1 }}" style="max-width: 100%;" class="me-2">
                                            <input type="text" name="image_alts[]" value="{{ old('image_alts.' . $index, $image->alt) }}" class="form-control mt-1">
                                            <img src="/storage/logos/crossicon.svg" alt="Remove" class="remove-icon" data-index="{{ $index }}" onclick="removeImage({{ $index }})">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Sell Price -->
                                <div class="mb-3">
                                    <label for="sell_price" class="form-label">Sell Price</label>
                                    <input type="text" name="sell_price" id="sell_price"
                                        value="{{ old('sell_price', $product->sell_price) }}" class="form-control">
                                    @error('sell_price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Discount Price -->
                                <div class="mb-3">
                                    <label for="discount_price" class="form-label">Discount Price</label>
                                    <input type="text" name="discount_price" id="discount_price"
                                        value="{{ old('discount_price', $product->discount_price) }}" class="form-control">
                                    @error('discount_price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                        value="{{ old('slug', $product->slug) }}" class="form-control">
                                    @error('slug')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn bg-gradient-dark">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add some inline JavaScript to handle the removal button -->
    {{-- <script>
        function previewImages() {
            const previewContainer = document.getElementById('image-previews');
            const files = document.getElementById('images').files;

            Array.from(files).forEach((file, index) => {
                // Check if the image is already previewed
                if (previewContainer.querySelector(`[data-index='${index}']`)) return; // Skip if already previewed

                const reader = new FileReader();

                reader.onload = function(e) {
                    const imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('col-3', 'mb-2', 'image-item');
                    imageWrapper.setAttribute('draggable', 'true');
                    imageWrapper.setAttribute('data-index', index);
                    imageWrapper.style.position = 'relative'; // For absolute positioning of the icon

                    // Image preview
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = `Image Preview ${index + 1}`;
                    img.style.maxWidth = '100%';
                    img.classList.add('me-2');

                    // Alt text input
                    const altInput = document.createElement('input');
                    altInput.type = 'text';
                    altInput.name = `image_alts[]`;
                    altInput.placeholder = `Alt text for image ${index + 1}`;
                    altInput.classList.add('form-control', 'mt-1');

                    // Remove icon (styled as an image, e.g., trash icon)
                    const removeIcon = document.createElement('img');
                    removeIcon.src = '/storage/logos/crossicon.svg'; // Replace with actual trash icon path
                    removeIcon.alt = 'Remove';
                    removeIcon.classList.add('remove-icon');
                    removeIcon.setAttribute('data-index', index);
                    removeIcon.addEventListener('click', function() {
                        removeImage(index);
                    });

                    // Append elements to the wrapper
                    imageWrapper.appendChild(img);
                    imageWrapper.appendChild(altInput);
                    imageWrapper.appendChild(removeIcon);

                    // Add to preview container
                    previewContainer.appendChild(imageWrapper);

                    // Enable drag-and-drop functionality
                    imageWrapper.addEventListener('dragstart', function(e) {
                        e.dataTransfer.setData('index', index);
                    });
                };

                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            const previewContainer = document.getElementById('image-previews');
            const imageItem = previewContainer.querySelector(`[data-index='${index}']`);
            if (imageItem) {
                previewContainer.removeChild(imageItem);
            }
        }
    </script> --}}
    <script>
        function previewImages() {
            const previewContainer = document.getElementById('image-previews');
            const files = document.getElementById('images').files;

            Array.from(files).forEach((file, index) => {
                // Check if the image is already previewed
                if (previewContainer.querySelector(`[data-index='${index}']`)) return;

                const reader = new FileReader();

                reader.onload = function(e) {
                    const imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('col-3', 'mb-2', 'image-item');
                    imageWrapper.setAttribute('draggable', 'true');
                    imageWrapper.setAttribute('data-index', index);
                    imageWrapper.style.position = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = `Image Preview ${index + 1}`;
                    img.style.maxWidth = '100%';
                    img.classList.add('me-2');

                    const altInput = document.createElement('input');
                    altInput.type = 'text';
                    altInput.name = `image_alts[]`;
                    altInput.placeholder = `Alt text for image ${index + 1}`;
                    altInput.classList.add('form-control', 'mt-1');

                    const removeIcon = document.createElement('img');
                    removeIcon.src = '/storage/logos/crossicon.svg';
                    removeIcon.alt = 'Remove';
                    removeIcon.classList.add('remove-icon');
                    removeIcon.setAttribute('data-index', index);
                    removeIcon.addEventListener('click', function() {
                        removeImage(index);
                    });

                    imageWrapper.appendChild(img);
                    imageWrapper.appendChild(altInput);
                    imageWrapper.appendChild(removeIcon);

                    previewContainer.appendChild(imageWrapper);
                };

                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            const previewContainer = document.getElementById('image-previews');
            const imageItem = previewContainer.querySelector(`[data-index='${index}']`);
            if (imageItem) {
                previewContainer.removeChild(imageItem);
            }
        }
    </script>
@endsection
