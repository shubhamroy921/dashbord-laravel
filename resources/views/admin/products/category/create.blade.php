@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Add Category</h5>
                            </div>
                            <a href="{{route('admin.categories.index')}}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">-&nbsp; Back</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-2 mx-4">
                        <div class="table-responsive p-0">
                            <form action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Images -->
                                <div class="mb-3">
                                    <label for="student_photo" class="form-label">image</label>
                                    <input accept=".jpg,.jpeg,.png" type="file" name="image" id="image"
                                        class="form-control">
                                </div>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <!-- Sort -->
                                 <div class="mb-3">
                                    <label for="sort" class="form-label">Sort</label>
                                    <input type="number" name="sort" id="sort" value="{{ old('sort') }}"
                                        class="form-control">
                                    @error('sort')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <!-- Status -->
                                 <div class="mb-3 status d-flex align-items-center">
                                    <label for="status" class="form-label mb-0">Status</label>
                                    <div class="check-box flex justify-center items-center mt-2 ms-5">
                                        <input id="status" type="checkbox" class="status-checkbox" name="status" value="1" {{ old('status', $product->status ?? 0) == 1 ? 'checked' : '' }}>
                                    </div>
                                    @error('status')
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

@endsection
