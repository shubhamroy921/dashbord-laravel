@foreach ($pages as $page)
<a href="/pages/{{ $page->slug }}">
    <div class="max-w-sm mx-auto my-4 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800">{{ $page->title }}</h2>
        </div>
        <div class="p-4">
            <div class="text-gray-700">
                {!! $page->description !!}
            </div>
        </div>
    </div>
</a>
@endforeach
