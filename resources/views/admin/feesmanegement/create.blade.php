@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Fee Management</h5>
                            </div>
                            <a href="{{ route('fees.index') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">-&nbsp; Back</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-2 mx-4">
                        <div class="table-responsive p-0">
                            <form action="{{ route('fees.collect.submit', $student->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf



                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>




                                <!-- Amount Number -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                                        class="form-control">
                                    @error('amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Due Date -->
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Due Date</label>
                                    <input type="date" name="due_date" id="dob" {{-- value="{{ old('due_date', $student->dob ? $student->due_date->format('Y-m-d') : '') }}" --}}
                                        class="form-control">
                                    @error('due_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number"
                                        value="{{ old('phone_number') }}" class="form-control">
                                    @error('phone_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="form-control">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn bg-gradient-dark"> Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
