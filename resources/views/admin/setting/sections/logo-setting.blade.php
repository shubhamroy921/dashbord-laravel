<div class="tab-pane fade show" id="logo-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.logo-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Logo -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Logo</label>
                            <div id="image-preview" class="image-preview logo"
                                 style="background-image: url('{{ asset(config('settings.logo', 'default-logo.png')) }}');">
                                <label for="logo-upload" id="image-label">Choose File</label>
                                <input type="file" name="logo" id="logo-upload" />
                            </div>
                        </div>
                    </div>

                    <!-- Footer Logo -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Footer Logo</label>
                            <div id="image-preview-footer" class="image-preview footer_logo"
                                 style="background-image: url('{{ asset(config('settings.footer_logo', 'default-footer-logo.png')) }}');">
                                <label for="footer-logo-upload" id="image-label-footer">Choose File</label>
                                <input type="file" name="footer_logo" id="footer-logo-upload" />
                            </div>
                        </div>
                    </div>

                    <!-- Favicon -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Favicon</label>
                            <div id="image-preview-favicon" class="image-preview favicon"
                                 style="background-image: url('{{ asset(config('settings.favicon', 'default-favicon.ico')) }}');">
                                <label for="favicon-upload" id="image-label-favicon">Choose File</label>
                                <input type="file" name="favicon" id="favicon-upload" />
                            </div>
                        </div>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Breadcrumb</label>
                            <div id="image-preview-breadcrumb" class="image-preview breadcrumb"
                                 style="background-image: url('{{ asset(config('settings.breadcrumb', 'default-breadcrumb.png')) }}');">
                                <label for="breadcrumb-upload" id="image-label-breadcrumb">Choose File</label>
                                <input type="file" name="breadcrumb" id="breadcrumb-upload" />
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-whisky-bg px-5 py-3 fs-4">Save</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Apply image preview to all file inputs
            $.uploadPreview({
                input_field: "#logo-upload",
                preview_box: "#image-preview",
                label_field: "#image-label",
            });

            $.uploadPreview({
                input_field: "#footer-logo-upload",
                preview_box: "#image-preview-footer",
                label_field: "#image-label-footer",
            });

            $.uploadPreview({
                input_field: "#favicon-upload",
                preview_box: "#image-preview-favicon",
                label_field: "#image-label-favicon",
            });

            $.uploadPreview({
                input_field: "#breadcrumb-upload",
                preview_box: "#image-preview-breadcrumb",
                label_field: "#image-label-breadcrumb",
            });

            // Show uploaded image immediately
            $('input[type="file"]').change(function(e) {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(input).closest('.image-preview').css('background-image', 'url(' + e.target.result + ')');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
@endpush
