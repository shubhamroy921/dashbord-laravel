@extends('layouts.user_type.auth')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="mb-0">Student Details</h5>
                    <a href="{{ route('students.index') }}" class="btn bg-gradient-primary btn-sm float-end">-&nbsp; Back to
                        List</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if ($student->student_photo)
                            <img src="{{ asset('storage/' . $student->student_photo) }}" alt="Student Photo"
                                class="img-fluid">
                        @else
                            <img src="/assets/img/team-2.jpg" class=" img-fluid alt="Default Avatar ">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-primary">Basic Information</h6>
                        <p><strong>ID:</strong> {{ $student->id }}</p>
                        <p><strong>Name:</strong> {{ $student->name }}</p>
                        <p><strong>Gender:</strong> {{ $student->gender }}</p>
                        <p><strong>Father's Name:</strong> {{ $student->father_name }}</p>
                        <p><strong>Mother's Name:</strong> {{ $student->mother_name }}</p>
                        <p><strong>Date of Birth:</strong> {{ $student->dob ? $student->dob->format('Y-m-d') : '' }}</p>
                        <p><strong>Phone Number:</strong> {{ $student->phone_number }}</p>
                        <p><strong>Alternate Number:</strong> {{ $student->alternate_number }}</p>
                        <p><strong>Email ID:</strong> {{ $student->email }}</p>
                        <p><strong>Current Address:</strong> {{ $student->current_address }}</p>
                        <p><strong>Permanent Address:</strong> {{ $student->permanent_address }}</p>
                        <p><strong>Creation Date:</strong> {{ $student->created_at }}</p>
                        <p class="align-items-center d-flex"><strong>Document (ID Proof):</strong>
                            @if ($student->document)
                                <a target="_blank" class="btn ms-3 bg-gradient-primary btn-sm mb-0"
                                    href="{{ asset('storage/' . $student->document) }}">View Docoment</a>
                            @else
                                <span class="ms-2"> ID Proof not Upload</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
