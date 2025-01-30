@extends('layouts.user_type.auth')

@section('content')

<section class="section">
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Settings</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2">
                        <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab4" data-bs-toggle="tab" href="#general-setting"
                                    role="tab" aria-controls="home" aria-selected="true">General Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab4" data-bs-toggle="tab" href="#logo-setting" role="tab"
                                    aria-controls="home" aria-selected="true">Logo Settings</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" id="home-tab4" data-bs-toggle="tab" href="#appearance-setting" role="tab"
                                    aria-controls="home" aria-selected="true">Appearance Settings</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab4" data-bs-toggle="tab" href="#pusher-setting"
                                    role="tab" aria-controls="profile" aria-selected="false">Pusher Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="" data-bs-toggle="tab" href="#mail-setting" role="tab"
                                    aria-controls="contact" aria-selected="false">Mail Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="" data-bs-toggle="tab" href="#email-setting" role="tab"
                                    aria-controls="contact" aria-selected="false">Email Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="" data-bs-toggle="tab" href="#seo-setting" role="tab"
                                    aria-controls="contact" aria-selected="false">Seo Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="" data-bs-toggle="tab" href="#footer-setting" role="tab"
                                    aria-controls="contact" aria-selected="false">Footer Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                        <div class="tab-content no-padding" id="myTab2Content">

                            @include('admin.setting.sections.general-setting')

                            @include('admin.setting.sections.logo-setting')

                            <!-- @include('admin.setting.sections.appearance-setting') -->

                            @include('admin.setting.sections.pusher-setting')

                            @include('admin.setting.sections.mail-setting')

                            @include('admin.setting.sections.email-setting')

                            @include('admin.setting.sections.seo-setting')

                            @include('admin.setting.sections.footer-setting')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<style>
.image-preview, #callback-preview {
  background-size: contain;
  background-repeat: no-repeat;
}
.smedia .image-preview, #callback-preview {
  color: #fff;
  background-color: #800!important;
  background-size: 45px auto;
  background-position: center 35px;
  background-repeat: no-repeat;
}
	</style>
@endsection
