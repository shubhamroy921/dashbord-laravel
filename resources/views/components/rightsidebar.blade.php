<div class="form-group">
    <label for="slug">Slug</label>
    <input type="text" id="slug" name="slug" class="form-control" placeholder="Enter slug"
        value="{{ old('slug', $page->slug ?? '') }}" required>
</div>

<!-- Other Fields -->
<div class="form-group">
    <label for="status">Status</label>
    <input type="checkbox" id="status" name="status" value="1" class="form-check-input"
        {{ old('status', $page->status ?? 0) ? 'checked' : '' }}>
</div>

<div class="form-group">
    <label for="created-at">Created At</label>
    <input type="text" id="created-at" name="created-at" class="form-control" value="{{ $page->created_at ?? '' }}">
</div>

<div class="form-group">
    <label for="updated-at">Updated At</label>
    <input type="text" id="updated-at" name="updated-at" class="form-control" value="{{ $page->updated_at ?? '' }}"
        disabled>
</div>
<div class="form-group d-flex justify-content-end">
    <button type="submit" class="btn bg-gradient-dark">Save</button>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        if (titleInput) {
            titleInput.addEventListener('input', function() {
                const title = this.value;
                const slug = title.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]+/g, '')
                    .replace(/(^-|-$)/g, '');
                slugInput.value = slug;
            });
        }
    });
</script>
