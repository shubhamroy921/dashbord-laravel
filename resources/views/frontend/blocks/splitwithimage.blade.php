@foreach ($blocks as $block)
    @if ($block['type'] === 'splitwithimage')

    {{-- @dd($block) --}}
            <section id="Who are SeeByte?" class="splitewithimage">
                <div class="white subject">
                    <div class="mx-auto max-w-8xl lg:px-0">
                        <div class="container mx-auto lg:py-24 py-14 lg:px-5 px-5 md:px-0">
                            <div
                                class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 items-center max-w-8xl mx-auto leftimage ">
                                <div
                                    class="flex justify-center sm:justify-center lg:justify-start md:p-0  pt-4 pb-0 md:pb-4 lg:mr-10">
                                    <img class="object-cover rounded-lg xl:mr-20 xl:w-auto md:w-full md:h-auto sm:w-full sm:h-auto w-full"
                                        src="https://seebyte-dev.basedev.co.uk/images/section/uploads/Homepage/_splitwithimage/MCM-Toolbox-Mission-Autonomy-5861.jpg"
                                        alt="Who are SeeByte?">
                                </div>
                                <div class="md:px-0 lg:mt-0 mt-8">
                                    <h2 class="xl:mt-3 mt-0 lg:text-4xl text-2xl font-bold tracking-tight ">{{ $block['title']}}</h2>
                                    <p class="md:mt-5 mt-4 fs-22 xl:w-5/6 lg:w-1/1 lg:pr-3 pr-0 font-normal">
                                        We are a software company specialising in maritime technology.&nbsp;We help our
                                        customers&nbsp;solve the most difficult problems in challenging
                                        environments&nbsp;and
                                        deliver intelligent&nbsp;solutions to enhance the capabilities or their
                                        autonomous
                                        systems.&nbsp;As a trusted military partner across the globe, our software suite
                                        has
                                        been&nbsp;widely deployed in&nbsp;naval applications for over 20 years.</p>
                                    <a href="{{ $block['split_with_image_button_link'] }}" target="{{ $block['split_with_image_button_target']  }}"
                                        class="poppins-regular md:mt-5 mt-2 inline-flex rounded-full px-5 py-2 text-base text-white shadow-sm background-yellow">
                                        Find out more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    @endif
@endforeach

