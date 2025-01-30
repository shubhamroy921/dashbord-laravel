<div class="tab-pane fade show" id="footer-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.footer-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Footer Warning and Liquor License -->
                <div class="row">
                    <!-- Footer Warning Notice Text Field -->
                    <div class="col-md-12">
                        <div class="form-group text-field">
                            <label for="footer_warning">Footer Warning Notice</label>
                            <textarea class="form-control" name="footer_warning" id="footer_warning" rows="5">{{ old('footer_warning', config('settings.footer_warning')) }}</textarea>
                        </div>
                    </div>
    
                    <!-- Liquor License Number Text Field -->
                    <div class="col-md-12">
                        <div class="form-group text-field">
                            <label for="liquor_license">Liquor License Number</label>
                            <input type="text" class="form-control" name="liquor_license" id="liquor_license" value="{{ old('liquor_license', config('settings.liquor_license')) }}" />
                        </div>
                    </div>

                    <!-- Social Media Links (Facebook, Twitter, YouTube) with Icons -->
                    <div class="form-group text-field smedia">
                        <label for="social_media">Social Media Links</label>
                        <div class="row">
                            <!-- Facebook Image Upload -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="facebook_logo">Facebook Logo</label>
                                    <div id="image-preview-facebook" class="image-preview"
                                         style="background-image: url('{{ asset(config('settings.facebook_logo', 'default-facebook.png')) }}');">
                                        <label for="facebook-upload" id="image-label-facebook">Choose File</label>
                                        <input type="file" name="facebook_logo" id="facebook-upload" />
                                    </div>
                                    <label for="facebook_link">Facebook Link</label>
                                    <input type="url" name="facebook_link" id="facebook-link" class="form-control" 
                                           value="{{ old('facebook_link', config('settings.facebook_link')) }}" placeholder="Enter Facebook URL" />
                                </div>
                            </div>
                    
                            <!-- Twitter Image Upload -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="twitter_logo">Twitter Logo</label>
                                    <div id="image-preview-twitter" class="image-preview"
                                         style="background-image: url('{{ asset(config('settings.twitter_logo', 'default-twitter.png')) }}');">
                                        <label for="twitter-upload" id="image-label-twitter">Choose File</label>
                                        <input type="file" name="twitter_logo" id="twitter-upload" />
                                    </div>
                                    <label for="twitter_link">Twitter Link</label>
                                    <input type="url" name="twitter_link" id="twitter-link" class="form-control" 
                                           value="{{ old('twitter_link', config('settings.twitter_link')) }}" placeholder="Enter Twitter URL" />
                                </div>
                            </div>
							
							<!-- Instagram Image Upload -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="instagram_logo">Instagram Logo</label>
                                    <div id="image-preview-instagram" class="image-preview"
                                         style="background-image: url('{{ asset(config('settings.instagram_logo', 'default-instagram.png')) }}');">
                                        <label for="instagram-upload" id="image-label-instagram">Choose File</label>
                                        <input type="file" name="instagram_logo" id="instagram-upload" />
                                    </div>
                                    <label for="instagram_link">Instagram Link</label>
                                    <input type="url" name="instagram_link" id="instagram-link" class="form-control" 
                                           value="{{ old('instagram_link', config('settings.instagram_link')) }}" placeholder="Enter Instagram URL" />
                                </div>
                            </div>
                    
                            <!-- YouTube Image Upload -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="youtube_logo">YouTube Logo</label>
                                    <div id="image-preview-youtube" class="image-preview"
                                         style="background-image: url('{{ asset(config('settings.youtube_logo', 'default-youtube.png')) }}');">
                                        <label for="youtube-upload" id="image-label-youtube">Choose File</label>
                                        <input type="file" name="youtube_logo" id="youtube-upload" />
                                    </div>
                                    <label for="youtube_link">YouTube Link</label>
                                    <input type="url" name="youtube_link" id="youtube-link" class="form-control" 
                                           value="{{ old('youtube_link', config('settings.youtube_link')) }}" placeholder="Enter YouTube URL" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Copyright Text -->
                    <div class="col-md-12">
                        <div class="form-group text-field">
                            <label for="footer_copyright">Footer Copyright Text</label>
                            <input type="text" class="form-control" name="footer_copyright" id="footer_copyright" value="{{ old('footer_copyright', config('settings.footer_copyright')) }}" />
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
            // Apply preview to social media logos
            $.uploadPreview({
                input_field: "#facebook-upload", 
                preview_box: "#image-preview-facebook", 
                label_field: "#image-label-facebook",
            });

            $.uploadPreview({
                input_field: "#twitter-upload", 
                preview_box: "#image-preview-twitter", 
                label_field: "#image-label-twitter",
            });
			
			$.uploadPreview({
                input_field: "#instagram-upload", 
                preview_box: "#image-preview-instagram", 
                label_field: "#image-label-instagram",
            });

            $.uploadPreview({
                input_field: "#youtube-upload", 
                preview_box: "#image-preview-youtube", 
                label_field: "#image-label-youtube",
            });
        });
    </script>
@endpush
