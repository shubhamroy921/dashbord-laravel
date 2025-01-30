@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Category</h5>
                            </div>
                            {{-- <div>
                                <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex">
                                    <input type="text" name="search" class="form-control form-control-sm me-2 h-25"
                                        placeholder="Search by name..." value="{{ $search ?? '' }}">
                                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i
                                            class="fas fa-search fs-6"></i></button>
                                </form>
                            </div> --}}
                            <div>
                                <a href="{{ route('admin.categories.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                    type="button">+&nbsp; New Category</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="sortable-table">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            image
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Title
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Sort
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($categories->isEmpty())
                                        <tr>
                                            <td colspan="11" class="">
                                                <div class="m-4">
                                                    <p class=" font-weight-bold mb-0">No Categories available</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($categories as $category)
                                            <tr data-id="{{ $category->id }}" class="draggable" draggable="true">
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                                </td>
                                                <td class="ps-4">
                                                    <img width="80" height="80"
                                                        src="{{ asset('storage/' . $category->image) }}"
                                                        alt="{{ $category->name }}">
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $category->name }}</p>
                                                </td>
                                                <td class="text-center">

                                                    <div class="check-box flex justify-center items-center mt-2">
                                                        <input type="checkbox" class="status-checkbox"
                                                            data-id="{{ $category->id }}"
                                                            title="{{ $category->status == 1 ? 'Active' : 'Inactive' }}"
                                                            {{ $category->status == 1 ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $category->sort }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.categories.edit', $category->id) }}?name={{ urlencode($category->name) }}"
                                                        class="ms-3" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Edit Category">
                                                        <i class="fas fa-user-edit text-secondary"></i>
                                                    </a>
                                                    <a href="{{ route('admin.subcategory.create',$category->id) }}?name={{ urlencode($category->name) }}"
                                                        class="mx-3" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Add Sub">
                                                        <i class="fas fa-plus text-secondary"></i>
                                                    </a>
                                                    <a href="{{ route('admin.subcategory.index',$category->id) }}?name={{ urlencode($category->name) }}"
                                                        class="me-3" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Show Sub">
                                                        <i class="fas fa-eye text-secondary"></i>
                                                    </a>

                                                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-transparent border-0 p-0"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="Delete Category">
                                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>
                            <div class="d-flex justify-content-center mt-4 mx-3">
                                {{ $categories->appends(['search' => $search])->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener for checkbox click
            document.querySelectorAll('.status-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let productId = this.getAttribute('data-id');
                    let status = this.checked ? 1 : 0;

                    // Send AJAX request to update the status
                    fetch('{{ route('admin.categories.updateStatus') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                id: productId,
                                status: status
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Category status updated successfully.');
                                toastr.success('Category status updated successfully.');
                            } else {
                                console.error('Failed to update category status.');
                                toastr.error('Failed to update category status.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error(
                                'An error occurred while updating the category status.');

                        });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            new Sortable(document.querySelector('#sortable-table tbody'), {
                animation: 150,
                handle: 'tr',
                draggable: 'tr', // The items that should be draggable
                onEnd: function(evt) {
                    let order = [];
                    document.querySelectorAll('#sortable-table tbody tr').forEach((row, index) => {
                        order.push({
                            id: row.getAttribute('data-id'),
                            sort: index + 1
                        });
                    });

                    console.log("New order:", order); // For debugging

                    // Send the new order to the server
                    fetch('{{ route('admin.categories.reorder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                order: order
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // For debugging
                            if (data.success) {
                                toastr.success('Category order updated successfully.');
                            } else {
                                toastr.error('Failed to update category order.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('An error occurred while updating the category order.');
                        });
                }
            });
        });
    </script>


@endsection
