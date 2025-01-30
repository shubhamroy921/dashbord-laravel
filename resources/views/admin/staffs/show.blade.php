@extends('layouts.user_type.auth')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="mb-0">Staff Details</h5>
                    <a href="{{ route('staffs.index') }}" class="btn bg-gradient-primary btn-sm float-end">-&nbsp; Back to
                        List</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if ($staff->staff_photo)
                            <img src="{{ asset('storage/' . $staff->staff_photo) }}" alt="{{ $staff->name }}"
                                class="img-fluid">
                        @else
                            <img src="/assets/img/team-2.jpg" class=" img-fluid alt="Default Avatar ">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-primary">Basic Information</h6>
                        <p><strong>ID:</strong> {{ $staff->id }}</p>
                        <p><strong>Name:</strong> {{ $staff->name }}</p>
                        <p><strong>Gender:</strong> {{ $staff->gender }}</p>
                        <p><strong>Father's Name:</strong> {{ $staff->father_name }}</p>
                        <p><strong>Mother's Name:</strong> {{ $staff->mother_name }}</p>
                        <p><strong>Date of Birth:</strong> {{ $staff->dob ? $staff->dob->format('Y-m-d') : '' }}</p>
                        <p><strong>Phone Number:</strong> {{ $staff->phone_number }}</p>
                        <p><strong>Alternate Number:</strong> {{ $staff->alternate_number }}</p>
                        <p><strong>Role:</strong> {{ $staff->role }}</p>
                        <p><strong>Email ID:</strong> {{ $staff->email }}</p>
                        <p><strong>Current Address:</strong> {{ $staff->current_address }}</p>
                        <p><strong>Permanent Address:</strong> {{ $staff->permanent_address }}</p>
                        <p><strong>Creation Date:</strong> {{ $staff->created_at }}</p>
                        <p class="align-items-center d-flex"><strong>Document (ID Proof):</strong> <a  class="btn ms-3 bg-gradient-primary btn-sm mb-0" target="_blank" href="{{ asset('storage/' .$staff->document) }}">View Docoment</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
