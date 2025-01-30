<footer class="bg-gray-800 text-white">
    <!-- Top Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @foreach ($menus as $item)
                <div>
                    <h4 class="font-bold text-lg">{{ $item->name }}</h4>
                    <ul class="mt-4 space-y-2">
                        @foreach ($item->menuItems as $menuItem)
                            <li>
                                <a href="{{ $menuItem->link }}" class="hover:underline">
                                    {{ $menuItem->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <div>
                <h4 class="font-bold text-lg">Newsletter</h4>
                <form class="mt-4" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email"
                        class="w-full px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-white placeholder-gray-400">
                    <input type="hidden" name="user_id" value="{{ auth()->id() ?? '' }}">
                    <button type="submit" class="mt-2 w-full py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">
                        Subscribe
                    </button>
                </form>
            </div>
            <div>
                <h4 class="font-bold text-lg">Follow Us</h4>
                <div class="mt-4 space-x-4 flex">
                    @foreach ($footer as $setting)
                        @if ($setting->key === 'facebook_link')
                            <a href="{{ $setting->value }}"
                                class="bg-[#374151] p-3 w-12 rounded-3xl hover:text-blue-400">
                                <img class="w-12" src="{{ $footer->firstWhere('key', 'facebook_logo')->value ?? '' }}"
                                    alt="Facebook Logo">
                            </a>
                        @elseif($setting->key === 'twitter_link')
                            <a href="{{ $setting->value }}"
                                class="bg-[#374151] p-3 w-12 rounded-3xl hover:text-blue-400">
                                <img class="w-12" src="{{ $footer->firstWhere('key', 'twitter_logo')->value ?? '' }}"
                                    alt="Twitter Logo">
                            </a>
                        @elseif($setting->key === 'instagram_link')
                            <a href="{{ $setting->value }}"
                                class="bg-[#374151] p-3 w-12 rounded-3xl hover:text-blue-400">
                                <img class="w-12"
                                    src="{{ $footer->firstWhere('key', 'instagram_logo')->value ?? '' }}"
                                    alt="Instagram Logo">
                            </a>
                        @elseif($setting->key === 'youtube_link')
                            <a href="{{ $setting->value }}"
                                class="bg-[#374151] p-3 w-12 rounded-3xl hover:text-blue-400">
                                <img class="w-12" src="{{ $footer->firstWhere('key', 'youtube_logo')->value ?? '' }}"
                                    alt="YouTube Logo">
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="bg-gray-700 py-4">
        <div class="container mx-auto text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $footer->firstWhere('id', 12)->value }}</p>
            <p>Terms & Conditions | Privacy Policy</p>
        </div>
    </div>
</footer>

<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if (session('success'))
            toastr.success("{!! session('success') !!}");
        @endif

        // Check for validation errors
        @if ($errors->any())
            // Loop through each error and show as Toastr error message
            @foreach ($errors->all() as $error)
                toastr.error("{!! $error !!}");
            @endforeach
        @endif

        @if (session('error'))
            toastr.error("{!! session('error') !!}");
        @endif


          // Info message
          @if (session('info'))
            toastr.info("{!! session('info') !!}");
        @endif

        // Warning message
        @if (session('warning'))
            toastr.warning("{!! session('warning') !!}");
        @endif
    });
</script>
