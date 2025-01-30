@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Page</h5>
                            </div>
                            <div>
                                <a href="{{ route('admin.pages.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                    type="button">+&nbsp; Add</a>
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
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Title
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Slug
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>

                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($pages->isEmpty())
                                        <tr>
                                            <td colspan="11" class="">
                                                <div class="m-4">
                                                    <p class=" font-weight-bold mb-0">No Pages available</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($pages as $page)
                                            <tr data-id="{{ $page->id }}" class="draggable" draggable="true">
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $page->title }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $page->slug }}</p>
                                                </td>
                                                <td class="text-center">

                                                    <div class="check-box flex justify-center items-center mt-2">
                                                        <input type="checkbox" class="status-checkbox"
                                                            data-id="{{ $page->id }}"
                                                            title="{{ $page->status == 1 ? 'Active' : 'Inactive' }}"
                                                            {{ $page->status == 1 ? 'checked' : '' }}>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class=""
                                                        data-bs-toggle="tooltip" data-bs-original-title="Edit Page">
                                                        <i class="fas fa-user-edit text-secondary"></i>
                                                    </a>
                                                    <a class="mx-3" href="{{ route('admin.pages.show', $page->id) }}"
                                                        data-bs-toggle="tooltip" data-bs-original-title="Show Page"><i
                                                            class="fas fa-eye text-secondary"></i></a>
                                                    <form action="{{ route('admin.pages.destroy', $page->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this Page?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-transparent border-0 p-0"
                                                            data-bs-toggle="tooltip" data-bs-original-title="Delete Page">
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
                                {{ $pages->appends(['search' => $search])->links('vendor.pagination.bootstrap-5') }}
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
                    fetch('{{ route('admin.pages.updateStatus') }}', {
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
                                console.log('Page status updated successfully.');
                                toastr.success('Page status updated successfully.');
                            } else {
                                console.error('Failed to update Page status.');
                                toastr.error('Failed to update Page status.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error(
                                'An error occurred while updating the Page status.');

                        });
                });
            });
        });
    </script>


@endsection
