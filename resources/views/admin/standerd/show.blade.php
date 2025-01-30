<!-- resources/views/standerd/class.blade.php -->

@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6">
                <div class="row gx-4">
                    {{-- <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="../assets/img/bruce-mars.jpg" alt="..." class="w-100 border-radius-lg shadow-sm">
                            <a href="javascript:;"
                                class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Edit Image"></i>
                            </a>
                        </div>
                    </div> --}}
                    {{-- <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ __('Alec Thompson') }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ __(' CEO / Co-Founder') }}
                            </p>
                        </div>
                    </div> --}}
                    <div class="col-lg-12  mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4 mx-4">
                                        <div class="d-flex justify-content-between">
                                            <div class=" pb-0">
                                                <h5 class="mb-0">Standerd Wise Students </h5>
                                            </div>
                                            <div>
                                                <a href="{{ route('students.create') }}"
                                                    class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New
                                                    Student</a>
                                            </div>
                                        </div>
                                        <div class=" px-0 pt-0 pb-2">
                                            <div class="table-responsive p-0">
                                                <div class="row mt-4">
                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 'NORSAY') }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">NORSAY</a></div>

                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 'LKG') }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">LKG</a></div>

                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 'UKG') }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">UKg</a></div>

                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 1) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 1</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 2) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 2</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 3) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 3</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 4) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 4</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 5) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 5</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 6) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 6</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 7) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 7</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 8) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 8</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 9) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 9</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 10) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 10</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 11) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 11</a></div>


                                                    <div class="col-md-3"> <a
                                                            href="{{ route('students.filterByClass', 12) }}"
                                                            class="btn btn-primary py-5 w-100 fs-3">Class 12</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
