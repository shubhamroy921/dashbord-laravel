<div class="tab-pane fade show" id="email-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.email-setting.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Email Header</label>
                    <textarea id="editor" name="email_header" class="form-control">{{ config('settings.email_header') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="">Email Footer</label>
                    <textarea name="email_footer" class="form-control summernote">{{ config('settings.email_footer') }}</textarea>
                </div>
                <button type="submit" class="btn btn-whisky-bg px-5 py-3 fs-4">Save</button>
            </form>
        </div>
    </div>
</div>


