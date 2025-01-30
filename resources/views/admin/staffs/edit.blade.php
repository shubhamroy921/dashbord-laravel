@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Edit Staff</h5>
                            </div>
                            <a href="{{ route('staffs.index') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">-&nbsp; Back</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-2 mx-4">
                        <div class="table-responsive p-0">
                            <form action="{{ route('staffs.update', $staff->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                               
                                <div class="mb-3">
                                    <label for="staff_photo" class="form-label">Staff Photo</label>
                                    <input accept=".jpg,.jpeg,.png" type="file" name="staff_photo" id="staff_photo"
                                        class="form-control">

                                    @if ($staff->staff_photo)
                                        <!-- Display the image if it exists -->
                                        <img src="{{ asset('storage/' . $staff->staff_photo) }}"
                                            alt="{{ old('name', $staff->name) }}" class="img-fluid mt-2 ifhere"
                                            style="max-width: 100px;">

                                        <!-- Add Remove Button -->
                                        <button type="button" class="btn bg-gradient-primary btn-sm mt-2" id="removePhotoBtn"><i
                                                class="fas fa-times"></i></button>

                                        <!-- Hidden input to track removal -->
                                        <input type="hidden" name="remove_photo" id="remove_photo" value="0">
                                    @endif
                                </div>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $staff->name) }}" class="form-control">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="male" {{ $staff->gender == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ $staff->gender == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other" {{ $staff->gender == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Father Name -->
                                <div class="mb-3">
                                    <label for="father_name" class="form-label">Father's Name</label>
                                    <input type="text" name="father_name" id="father_name"
                                        value="{{ old('father_name', $staff->father_name) }}" class="form-control">
                                    @error('father_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mother Name -->
                                <div class="mb-3">
                                    <label for="mother_name" class="form-label">Mother's Name</label>
                                    <input type="text" name="mother_name" id="mother_name"
                                        value="{{ old('mother_name', $staff->mother_name) }}" class="form-control">
                                    @error('mother_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" id="dob"
                                        value="{{ old('dob', $staff->dob ? $staff->dob->format('Y-m-d') : '') }}"
                                        class="form-control">
                                    @error('dob')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number"
                                        value="{{ old('phone_number', $staff->phone_number) }}" class="form-control">
                                    @error('phone_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alternate Number -->
                                <div class="mb-3">
                                    <label for="alternate_number" class="form-label">Alternate Number</label>
                                    <input type="text" name="alternate_number" id="alternate_number"
                                        value="{{ old('alternate_number', $staff->alternate_number) }}"
                                        class="form-control">
                                    @error('alternate_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="Teacher" {{ $staff->role == 'Teacher' ? 'selected' : '' }}>Teacher
                                        </option>
                                        <option value="Principal" {{ $staff->role == 'Principal' ? 'selected' : '' }}>
                                            Principal</option>
                                        <option value="Admin" {{ $staff->role == 'Admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="Support_staff"
                                            {{ $staff->role == 'Support_staff' ? 'selected' : '' }}>Support Staff</option>
                                    </select>
                                    @error('role')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $staff->email) }}" class="form-control">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Current Address -->
                                <div class="mb-3">
                                    <label for="current_address" class="form-label">Current Address</label>
                                    <textarea name="current_address" id="current_address" rows="3" class="form-control">{{ old('current_address', $staff->current_address) }}</textarea>
                                    @error('current_address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Permanent Address -->
                                <div class="mb-3">
                                    <label for="permanent_address" class="form-label">Permanent Address</label>
                                    <textarea name="permanent_address" id="permanent_address" rows="3" class="form-control">{{ old('permanent_address', $staff->permanent_address) }}</textarea>
                                    @error('permanent_address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Document Upload -->
                                <div class="mb-3">
                                    <label for="document" class="form-label">Document (ID Proof)</label>
                                    <input accept=".pdf,.jpg,.jpeg,.png" type="file" name="document" id="document"
                                        class="form-control">
                                    @if ($staff->document)
                                        <a href="{{ asset('storage/' . $staff->document) }}" target="_blank"
                                            class="d-block mt-2">View Current Document</a>
                                    @endif
                                    @error('document')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn bg-gradient-dark">Update Staff</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add some inline JavaScript to handle the removal button -->
    <script>
        document.getElementById('removePhotoBtn').addEventListener('click', function() {
            // Hide the image and remove button
            document.querySelector('.ifhere').style.display = 'none';
            this.style.display = 'none';

            // Set the hidden input value to mark the photo for removal
            document.getElementById('remove_photo').value = '1';
        });
    </script>
@endsection
