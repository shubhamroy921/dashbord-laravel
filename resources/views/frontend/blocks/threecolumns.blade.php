<section id="Our Products" class="threecolumns fade" style="opacity: 1;">
    <style>
        .background-yellow {
            background-color: #d04109;
        }
    </style>
    <div class="subject">
        <div class="py-10 xl:py-16 text-center relative trax gray">
            <div class="mx-auto max-w-6xl px-6 lg:px-8 container">
                <div class="mx-auto max-w-7xl lg:px-8 container">
                    <div class="mx-auto text-center mb-5 sm:mb-12 back">
                        @foreach ($blocks as $block)
                            @if ($block['type'] === 'threecolumns')
                                <h2
                                    class="mt-3 mx-auto max-w-3xl font-bold space-x-9 lg:text-4xl md:text-3xl sm:text-3xl text-2xl">
                                    {{ $block['title'] ?? 'Default Title' }}
                                </h2>
                                <div class="mt-4 sm:mt-6 md:mt-8 font-normal fs-22 fw-600 gab max-w-3xl mx-auto">
                                    <p>{{ $block['description'] ?? 'Default description' }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="mx-auto mt-16 max-w-2xl sm:mt-8 lg:mt-12 lg:max-w-none remrr">
                        <dl
                            class="grid max-w-5xl grid-cols-1 gap-x-8 gap-y-12 lg:max-w-none lg:grid-cols-3 text-center ment">
                            @foreach ($blocks as $block)
                                @if ($block['type'] === 'threecolumns')
                                    @foreach ($block['three_column_items'] as $item)
                                        <div
                                            class="flex flex-col overflow-hidden rounded-lg shadow p-5 border h-full relative">
                                            <dt class="text-center">
                                                <div class="flex justify-center">
                                                    <div class="fs-22 leading-8 font-bold">
                                                        {{ $item['title'] ?? 'Default Item Title' }}</div>
                                                </div>
                                            </dt>
                                            <dd class="mt-1 flex flex-auto flex-col">
                                                <div class="flex-auto mt-2 text-sm leading-6 fw-400 fs-16 text-center">
                                                    <p>{{ $item['description'] ?? 'Default item description' }}</p>
                                                </div>
                                                <div class="mt-auto">
                                                    @if (isset($item['button_text']) && isset($item['button_link']))
                                                        <div class="flex flex-auto flex-col text-sm leading-7 mt-7">
                                                            <p>
                                                                <a href="{{ $item['button_link'] }}"
                                                                    class="poppins-regular inline-flex rounded-full px-5 py-2 text-base text-white shadow-sm background-yellow"
                                                                    target="{{ $item['target'] ?? '_self' }}">
                                                                    {{ $item['button_text'] }}
                                                                </a>
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </dd>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
