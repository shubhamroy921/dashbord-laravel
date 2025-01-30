@extends('layouts.user_type.auth')

@section('content')
    <style>
        .remove-block,
        .duplicate-block,
        .toggle-collapse,
        .drag-handle {
            width: 33px;
            height: 30px;
            border: none;
        }

        .form-control.block-type-select.mb-3 {
            appearance: button;
        }
    </style>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Add Page</h5>
                            </div>
                            <a href="{{ route('admin.pages.index') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">-&nbsp; Back</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-2 mx-4">
                        <div class="table-responsive p-0">
                            <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row m-0">
                                    <div class="col-7">
                                        <!-- Title -->
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                                class="form-control">
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" rows="3" class="form-control ckediter">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Block Container -->
                                        <div id="block-container">
                                            <!-- Blocks will be added here dynamically -->
                                        </div>

                                        <!-- Add New Block Button -->
                                        <div class="mb-3 text-end">
                                            <button type="button" id="add-block" class="btn btn-primary">Add Block</button>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="mb-3">
                                            <button type="submit" class="btn bg-gradient-dark">Save</button>
                                        </div>

                                    </div>
                                    <div class="col-5">
                                        <div class="sidebar sticky-top fix">
                                            @include('components.rightsidebar')
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const blockContainer = document.getElementById('block-container');
            const addBlockButton = document.getElementById('add-block');
            let blockCounter = 1; // Initialize the block counter

            // Function to handle the addition of a new block with block type selection
            function addNewBlock() {
                const blockWrapper = document.createElement('div');
                blockWrapper.classList.add('block', 'mb-3', 'border', 'p-3', 'position-relative');
                blockWrapper.setAttribute('data-block-id', `id${blockCounter}`); // Set a unique block ID

                const blockHeader = document.createElement('div');
                blockHeader.classList.add('d-flex', 'justify-content-between', 'mb-2');
                blockHeader.innerHTML = `
                    <button type="button" class="btn-secondary me-2 duplicate-block rounded-circle"><i class="fas fa-clone fs-5"></i></button>
                    <button type="button" class="btn-danger me-2 remove-block rounded-circle"><i class="fas fa-times fs-5"></i></button>
                    <button type="button" class="btn-info toggle-collapse rounded-circle"><i class="fas fa-caret-up fs-5"></i></button>
                    <button type="button" class="btn-secondary drag-handle rounded-circle"><i class="fas fa-arrows-alt"></i></button>
                `;

                const blockTypeSelect = document.createElement('select');
                blockTypeSelect.classList.add('form-control', 'block-type-select', 'mb-3');
                blockTypeSelect.innerHTML = `
                    <option value="">Select Block Type</option>
                    <option value="default">Default</option>
                    <option value="image">Image Block</option>
                    <option value="video">Video Block</option>
                    <option value="gallery">Gallery Block</option>
                    <option value="hero-section">Hero Section</option>
                    <option value="splitwithimage">Split with Image</option>
                    <option value="threecolumns">Three Columns</option>
                `;

                blockWrapper.appendChild(blockHeader);
                blockWrapper.appendChild(blockTypeSelect);

                // Create hidden input to store block type
                const blockTypeInput = document.createElement('input');
                blockTypeInput.type = 'hidden';
                blockTypeInput.name = 'block_type[]';
                blockWrapper.appendChild(blockTypeInput);

                const blockIDInput = document.createElement('input');
                blockIDInput.type = 'hidden';
                blockIDInput.name = 'block_id[]';
                blockIDInput.value = `id${blockCounter}`; // Store unique block ID
                blockWrapper.appendChild(blockIDInput);

                const blockFields = document.createElement('div');
                blockFields.classList.add('block-fields', 'mt-3');
                blockWrapper.appendChild(blockFields);

                blockContainer.appendChild(blockWrapper);

                blockTypeSelect.addEventListener('change', function() {
                    blockTypeInput.value = blockTypeSelect.value;
                    displayBlockFields(blockWrapper, blockTypeSelect.value);
                });

                handleBlockActions(blockWrapper);
                initializeDrag();
                blockCounter++;
            }

            // Function to display fields based on selected block type
            function displayBlockFields(blockWrapper, selectedType) {
                const blockFields = blockWrapper.querySelector('.block-fields');
                blockFields.innerHTML = '';

                // Default fields (Title and Description)
                blockFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Block Title</label>
                        <input type="text" class="form-control" name="block_title[]">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Block Description</label>
                        <textarea class="form-control ckediter" name="block_description[]" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="text" class="form-control" name="block_link[]">
                    </div>
                `;

                // Additional fields based on block type
                if (selectedType === 'image') {
                    blockFields.innerHTML += `
                        <div class="mb-3">
                            <label class="form-label">Block Image</label>
                            <input type="file" class="form-control" name="block_image[]" onchange="previewImage(event, this)">
                            <div class="image-preview mt-2" style="display: none;">
                                <img id="image-preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                    `;
                } else if (selectedType === 'gallery') {
                    blockFields.innerHTML += `
                        <div class="mb-3">
                            <label class="form-label">Block Gallery Images</label>
                            <div class="gallery-inputs">
                                <div class="gallery-image-field mb-2">
                                    <input type="file" class="form-control" name="block_gallery[${blockContainer.children.length}][]" onchange="previewImage(event, this)">
                                    <button type="button" class="btn btn-danger btn-sm remove-image mt-2">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary add-gallery-image">Add Image</button>
                        </div>
                    `;
                } else if (selectedType === 'hero-section') {
                    blockFields.innerHTML += `
                        <div class="mb-3">
                            <label class="form-label">Hero Section Title</label>
                            <input type="text" class="form-control" name="hero_section_title[]">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hero Section Description</label>
                            <textarea class="form-control ckediter" name="hero_section_description[]" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hero Section Image</label>
                            <input type="file" class="form-control" name="hero_section_image[]" onchange="previewImage(event, this)">
                            <div class="image-preview mt-2" style="display: none;">
                                <img id="hero-image-preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                    `;
                } else if (selectedType === 'splitwithimage') {
                    blockFields.innerHTML += `
                        <div class="mb-3">
                            <label class="form-label">Split with Image Title</label>
                            <input type="text" class="form-control" name="split_with_image_title[]">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Split with Image Description</label>
                            <textarea class="form-control ckediter" name="split_with_image_description[]" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Split with Image Image</label>
                            <input type="file" class="form-control" name="split_with_image_image[]" onchange="previewImage(event, this)">
                            <div class="image-preview mt-2" style="display: none;">
                                <img id="split-with-image-preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image Align</label>
                            <select class="form-control" name="split_with_image_image_align[]">
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Button Text</label>
                            <input type="text" class="form-control" name="split_with_image_button_text[]">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Button Link</label>
                            <input type="text" class="form-control" name="split_with_image_button_link[]">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Button Target</label>
                            <select class="form-control" name="split_with_image_button_target[]">
                                <option value="_self">Self</option>
                                <option value="_blank">Blank</option>
                            </select>
                        </div>
                    `;
                } else if (selectedType === 'threecolumns') {
                    blockFields.innerHTML += `
                        <div class="three-columns-items mt-3"></div>
                        <div class="mb-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary add-three-column-item">Add items</button>
                        </div>
                    `;

                    const addItemButton = blockFields.querySelector('.add-three-column-item');
                    const itemsContainer = blockFields.querySelector('.three-columns-items');
                    let itemCounter = 1;

                    addItemButton.addEventListener('click', function() {
                        const itemWrapper = document.createElement('div');
                        itemWrapper.classList.add('three-column-item', 'border', 'p-3', 'mb-3');
                        itemWrapper.setAttribute('data-item-id', `item${itemCounter}`);

                        itemWrapper.innerHTML = `
                        <input type="hidden" name="three_column_item_ids[]" value="item${itemCounter}">
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" name="three_column_images[]" onchange="previewImage(event, this)">
                                <div class="image-preview mt-2" style="display: none;">
                                    <img class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="three_column_titles[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="three_column_descriptions[]" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Button Link</label>
                                <input type="text" class="form-control" name="three_column_links[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="three_column_button_texts[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Target</label>
                                <select class="form-control" name="three_column_targets[]">
                                    <option value="_self">Same Tab</option>
                                    <option value="_blank">New Tab</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-danger remove-item">Remove</button>
                        `;

                        itemsContainer.appendChild(itemWrapper);
                        itemCounter++;

                        itemWrapper.querySelector('.remove-item').addEventListener('click', function() {
                            itemWrapper.remove();
                        });
                    });
                }
            }

            // Image preview function
            function previewImage(event, inputElement) {
                const file = inputElement.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewDiv = inputElement.closest('.block-fields').querySelector(
                        '.image-preview');
                        previewDiv.style.display = 'block';
                        const imgElement = previewDiv.querySelector('img');
                        imgElement.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Function to handle block actions (duplicate, remove, collapse)
            function handleBlockActions(blockWrapper) {
                const duplicateButton = blockWrapper.querySelector('.duplicate-block');
                const removeButton = blockWrapper.querySelector('.remove-block');
                const toggleButton = blockWrapper.querySelector('.toggle-collapse');
                const blockFields = blockWrapper.querySelector('.block-fields');

                // Duplicate block
                duplicateButton.addEventListener('click', function() {
                    blockCounter++;
                    const clonedBlock = blockWrapper.cloneNode(true);
                    clonedBlock.setAttribute('data-block-id', `id${blockCounter}`);
                    resetBlockFields(clonedBlock);
                    blockContainer.appendChild(clonedBlock);
                    handleBlockActions(clonedBlock);
                });

                // Remove block
                removeButton.addEventListener('click', function() {
                    blockWrapper.remove();
                });

                // Toggle collapse
                toggleButton.addEventListener('click', function() {
                    blockFields.classList.toggle('d-none');
                    toggleButton.innerHTML = blockFields.classList.contains('d-none') ?
                        '<i class="fas fa-chevron-down"></i>' : '<i class="fas fa-chevron-up"></i>';
                });
            }

            // Function to reset all fields in a block
            function resetBlockFields(block) {
                block.querySelectorAll('input[type="text"], textarea, input[type="file"]').forEach(function(input) {
                    input.value = '';
                });
                block.querySelectorAll('select').forEach(function(select) {
                    select.selectedIndex = 0;
                });
            }

            // Initialize drag functionality using SortableJS
            function initializeDrag() {
                new Sortable(blockContainer, {
                    handle: '.drag-handle',
                    animation: 150,
                    onEnd(evt) {
                        console.log('Dragged block moved:', evt);
                    }
                });
            }

            // Event listener for adding a new block
            addBlockButton.addEventListener('click', function() {
                addNewBlock();
            });

            // Initialize existing blocks
            document.querySelectorAll('.block').forEach(function(blockWrapper) {
                handleBlockActions(blockWrapper);

                // Initialize add item button for three columns block
                const addItemButton = blockWrapper.querySelector('.add-three-column-item');
                if (addItemButton) {
                    const itemsContainer = blockWrapper.querySelector('.three-columns-items');
                    addItemButton.addEventListener('click', function() {
                        const itemWrapper = document.createElement('div');
                        itemWrapper.classList.add('three-column-item', 'border', 'p-3', 'mb-3');

                        itemWrapper.innerHTML = `
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" name="three_column_images[]" onchange="previewImage(event, this)">
                                <div class="image-preview mt-2" style="display: none;">
                                    <img class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="three_column_titles[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="three_column_descriptions[]" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Button Link</label>
                                <input type="text" class="form-control" name="three_column_links[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="three_column_button_texts[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Target</label>
                                <select class="form-control" name="three_column_targets[]">
                                    <option value="_self">Same Tab</option>
                                    <option value="_blank">New Tab</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-danger remove-item">Remove</button>
                        `;

                        itemsContainer.appendChild(itemWrapper);

                        itemWrapper.querySelector('.remove-item').addEventListener('click',
                            function() {
                                itemWrapper.remove();
                            });
                    });
                }
            });

            initializeDrag();
        });
    </script>
@endsection
