<header
    id="site-navbar"
    data-navbar
    data-scrolled="false"
    class="fixed top-0 inset-x-0 z-50 transition-colors duration-300"
>
    <nav class="w-full mx-auto px-7 h-24 flex items-center justify-between" aria-label="Main navigation">
        <a href="{{ route('index') }}" class="shrink-0">
            <img
                data-navbar-logo
                src="{{ asset('assets/img/metadata/logo/logo.png') }}"
                alt="{{ config('app.name') }}"
                class="h-20 w-auto transition-[filter] duration-300"
            >
        </a>

        {{-- Desktop --}}
        <ul class="hidden lg:flex items-center gap-8">
            @foreach ($navbarmenu as $menu)
                @if (!empty($menu['sub_menu']))
                    <li class="relative group">
                        @if (filled($menu['url']))
                            <a
                                href="{{ $menu['url'] }}"
                                data-navbar-link
                                data-active="{{ $menu['active'] ? 'true' : 'false' }}"
                                class="flex items-center gap-1 text-fluid-body font-medium transition-colors duration-300"
                            >
                        @else
                            <button
                                type="button"
                                data-navbar-link
                                data-active="{{ $menu['active'] ? 'true' : 'false' }}"
                                aria-haspopup="true"
                                class="flex items-center gap-1 text-fluid-body font-medium transition-colors duration-300"
                            >
                        @endif
                            {{ $menu['title'] }}
                            <svg class="w-3 h-3 transition-transform duration-300 group-hover:rotate-180 group-focus-within:rotate-180" viewBox="0 0 12 8" fill="none" aria-hidden="true">
                                <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @if (filled($menu['url']))
                            </a>
                        @else
                            </button>
                        @endif

                        <ul class="absolute left-0 top-full pt-3 min-w-[220px]
                                   opacity-0 invisible translate-y-2
                                   group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                                   group-focus-within:opacity-100 group-focus-within:visible group-focus-within:translate-y-0
                                   transition-all duration-300">
                            <li class="bg-background border border-theme shadow-lg py-2">
                                <ul>
                                    @foreach ($menu['sub_menu'] as $sub)
                                        <li>
                                            <a
                                                href="{{ $sub['url'] }}"
                                                @if ($sub['active']) aria-current="page" @endif
                                                class="block px-5 py-2 text-fluid-body hover:bg-section hover:text-primary transition-colors duration-200 {{ $sub['active'] ? 'text-primary' : 'text-body' }}"
                                            >
                                                {{ $sub['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a
                            href="{{ $menu['url'] }}"
                            data-navbar-link
                            data-active="{{ $menu['active'] ? 'true' : 'false' }}"
                            @if ($menu['active']) aria-current="page" @endif
                            class="text-fluid-body font-medium transition-colors duration-300"
                        >
                            {{ $menu['title'] }}
                        </a>
                    </li>
                @endif
            @endforeach

            @if (filled($bookUrl))
                <li>
                    <a
                        href="{{ $bookUrl }}"
                        target="_blank"
                        rel="noopener"
                        data-navbar-cta
                        class="btn inline-block text-fluid-body"
                    >
                        Book Now
                    </a>
                </li>
            @endif
        </ul>

        {{-- Mobile toggle --}}
        <button
            type="button"
            data-navbar-toggle
            aria-label="Menu"
            aria-expanded="false"
            aria-controls="navbar-mobile"
            class="lg:hidden"
        >
            <svg data-navbar-burger class="w-7 h-7 transition-colors duration-300" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </button>
    </nav>

    {{-- Mobile menu --}}
    <ul id="navbar-mobile" data-navbar-mobile class="lg:hidden hidden bg-background border-t border-theme px-7 py-4 space-y-1 max-h-[calc(100vh-6rem)] overflow-y-auto">
        @foreach ($navbarmenu as $menu)
            <li>
                @if (!empty($menu['sub_menu']))
                    <div class="flex items-center justify-between">
                        @if (filled($menu['url']))
                            <a
                                href="{{ $menu['url'] }}"
                                @if ($menu['active']) aria-current="page" @endif
                                class="block py-2 text-fluid-body font-medium {{ $menu['active'] ? 'text-primary' : 'text-body' }}"
                            >
                                {{ $menu['title'] }}
                            </a>
                        @else
                            <span class="block py-2 text-fluid-body font-medium text-body">
                                {{ $menu['title'] }}
                            </span>
                        @endif

                        <button
                            type="button"
                            data-navbar-subtoggle
                            aria-label="Toggle {{ $menu['title'] }}"
                            aria-expanded="{{ $menu['active'] ? 'true' : 'false' }}"
                            class="p-2 text-body"
                        >
                            <svg class="w-3 h-3 transition-transform duration-300 {{ $menu['active'] ? 'rotate-180' : '' }}" viewBox="0 0 12 8" fill="none" aria-hidden="true">
                                <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <ul data-navbar-submenu class="pl-4 space-y-1 {{ $menu['active'] ? '' : 'hidden' }}">
                        @foreach ($menu['sub_menu'] as $sub)
                            <li>
                                <a
                                    href="{{ $sub['url'] }}"
                                    @if ($sub['active']) aria-current="page" @endif
                                    class="block py-1.5 text-fluid-body {{ $sub['active'] ? 'text-primary' : 'text-muted' }}"
                                >
                                    {{ $sub['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <a
                        href="{{ $menu['url'] }}"
                        @if ($menu['active']) aria-current="page" @endif
                        class="block py-2 text-fluid-body font-medium {{ $menu['active'] ? 'text-primary' : 'text-body' }}"
                    >
                        {{ $menu['title'] }}
                    </a>
                @endif
            </li>
        @endforeach

        @if (filled($bookUrl))
            <li class="pt-3">
                <a href="{{ $bookUrl }}" target="_blank" rel="noopener" class="btn inline-block text-fluid-body">
                    Book Now
                </a>
            </li>
        @endif
    </ul>
</header>