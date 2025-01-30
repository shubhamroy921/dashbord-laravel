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
                            <div>
                                <form action="{{ route('fees.index') }}" method="GET" class="d-flex">
                                    <input type="text" name="search" class="form-control form-control-sm me-2 h-25"
                                        placeholder="Search by name..." value="{{ request()->query('search') }}">
                                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i
                                            class="fas fa-search fs-6"></i></button>
                                </form>
                            </div>
                            <div>
                                <a href="{{ route('fees.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                    type="button">+&nbsp; New Student</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Student ID</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Student Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Standard</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Phone Number</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Fee Amount</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Payment Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Due Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($students->isEmpty())
                                        <tr>
                                            <td colspan="11">
                                                <div class="m-4">
                                                    <p class="font-weight-bold mb-0">No Students Available</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($students as $student)
                                            <tr>
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $student->student_id }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $student->name }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $student->class }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $student->phone_number }}
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <!-- Display fee amount -->
                                                    @if ($student->fees->isNotEmpty())
                                                        @foreach ($student->fees as $fee)
                                                            <p class="text-xs font-weight-bold mb-0">{{ $fee->amount }}</p>
                                                        @endforeach
                                                    @else
                                                        <p class="text-xs font-weight-bold mb-0">No Data</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Display payment date -->
                                                    @if ($student->fees->isNotEmpty())
                                                        @foreach ($student->fees as $fee)
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $fee->created_at ? $fee->created_at->format('d-m-Y') : 'No Data' }}
                                                            </p>
                                                        @endforeach
                                                    @else
                                                        <p class="text-xs font-weight-bold mb-0">No Data</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Display due date -->
                                                    @if ($student->fees->isNotEmpty())
                                                        @foreach ($student->fees as $fee)
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $fee->due_date ? $fee->due_date->format('Y-m-d') : 'No Data' }}
                                                            </p>
                                                        @endforeach
                                                    @else
                                                        <p class="text-xs font-weight-bold mb-0">No Data</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Collect fee action button -->
                                                    <a href="{{ route('fees.collect', $student->id) }}"
                                                        class="btn btn-sm bg-gradient-primary">Collect Fee</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-4 mx-3">
                                <!-- Pagination Links -->
                                {{ $students->appends(['search' => request()->query('search')])->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
