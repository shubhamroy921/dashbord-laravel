@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Staffs</h5>
                            </div>
                            <a href="{{ route('staffs.index') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">-&nbsp; Back</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-2 mx-4">
                        <div class="table-responsive p-0">
                            <form action="{{ route('staffs.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Staff Photo -->
                                <div class="mb-3">
                                    <label for="staff_photo" class="form-label">Staff Photo</label>
                                    <input accept=".jpg,.jpeg,.png" type="file" name="staff_photo" id="staff_photo" class="form-control">
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

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Father Name -->
                                <div class="mb-3">
                                    <label for="father_name" class="form-label">Father's Name</label>
                                    <input type="text" name="father_name" id="father_name"
                                        value="{{ old('father_name') }}" class="form-control">
                                    @error('father_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mother Name -->
                                <div class="mb-3">
                                    <label for="mother_name" class="form-label">Mother's Name</label>
                                    <input type="text" name="mother_name" id="mother_name"
                                        value="{{ old('mother_name') }}" class="form-control">
                                    @error('mother_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" id="dob" value="{{ old('dob') }}"
                                        class="form-control">
                                    @error('dob')
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

                                <!-- Alternate Number -->
                                <div class="mb-3">
                                    <label for="alternate_number" class="form-label">Alternate Number</label>
                                    <input type="text" name="alternate_number" id="alternate_number"
                                        value="{{ old('alternate_number') }}" class="form-control">
                                    @error('alternate_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="Teacher">Teacher</option>
                                        <option value="Principal">Principal</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Support_staff">Support Staff</option>
                                    </select>
                                    @error('role')
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

                                <!-- Current Address -->
                                <div class="mb-3">
                                    <label for="current_address" class="form-label">Current Address</label>
                                    <textarea name="current_address" id="current_address" rows="3" class="form-control">{{ old('current_address') }}</textarea>
                                    @error('current_address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Permanent Address -->
                                <div class="mb-3">
                                    <label for="permanent_address" class="form-label">Permanent Address</label>
                                    <textarea name="permanent_address" id="permanent_address" rows="3" class="form-control">{{ old('permanent_address') }}</textarea>
                                    @error('permanent_address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Document Upload -->
                                <div class="mb-3">
                                    <label for="document" class="form-label">Document (ID Proof)</label>
                                    <input accept=".pdf,.jpg,.jpeg,.png" type="file" name="document" id="document" class="form-control">
                                    @error('document')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn bg-gradient-dark">Add Staff</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
