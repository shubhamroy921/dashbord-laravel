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
                            <div>
                                <form action="{{ route('staffs.index') }}" method="GET" class="d-flex">
                                    <input type="text" name="search" class="form-control form-control-sm me-2 h-25"
                                        placeholder="Search by name..." value="{{ request()->query('search') }}">
                                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i
                                            class="fas fa-search fs-6"></i></button>
                                </form>
                            </div>


                            <div>
                                <a href="{{ route('staffs.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                    type="button">+&nbsp; New Staff</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>

                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Farher's Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Mother's Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date Of Birth
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Role
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Phone Number
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Alternate Number
                                        </th>

                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Current Address
                                        </th>


                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Creation Date
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($staffs->isEmpty())
                                        <tr>
                                            <td colspan="11" class="">
                                                <div class="m-4">
                                                    <p class="font-weight-bold mb-0">No Staff available</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($staffs as $staff)
                                            <tr>
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $staff->name }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $staff->father_name }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $staff->mother_name }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $staff->dob ? $staff->dob->format('Y-m-d') : '' }}
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $staff->role }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $staff->phone_number }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $staff->alternate_number }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $staff->current_address }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $staff->created_at ? $staff->created_at->format('Y-m-d') : '' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('staffs.show', $staff->id) }}?name={{ urlencode($staff->name) }}"
                                                        data-bs-toggle="tooltip" data-bs-original-title="View Staff">
                                                        <i class="fas fa-eye text-secondary"></i>
                                                    </a>
                                                    <a href="{{ route('staffs.edit', $staff->id) }}?name={{ urlencode($staff->name) }}"
                                                        class="mx-3" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Edit Staff">
                                                        <i class="fas fa-user-edit text-secondary"></i>
                                                    </a>
                                                    <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this staff?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-transparent border-0 p-0"
                                                            data-bs-toggle="tooltip" data-bs-original-title="Delete Staff">
                                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-4">

                                {{ $staffs->appends(['search' => request()->query('search')])->links('vendor.pagination.bootstrap-5') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
