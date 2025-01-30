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
                                <a href="{{ route('fees.graph', ['studentId' => $student->id]) }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">-&nbsp; View Fee Graph</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-2 mx-4">
                        <div class="table-responsive p-0">
                            <div class="text-center">
                                <h5><strong>Collect Fee for</strong><span
                                        class="ms-2 text-danger">{{ $student->name }}</span> </h5>
                            </div>
                            <form action="{{ route('fees.collect.submit', $student->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
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
