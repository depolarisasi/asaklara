<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="main-navbar">

    <div class="flex items-start justify-between px-4 pt-4 md:px-8 lg:px-10" id="navbar-outer">
        {{-- Pill Kiri --}}
        <nav id="nav-pill-left"
             class="nav-pill flex text-white items-center gap-1 flex-1 md:flex-none rounded-2xl md:rounded-full py-2 px-4 md:pl-5 md:pr-4">
             
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0 mr-4">
                <img src="/logo/asak-horizontal-logo-red.png" alt="ASAK Agency"
                     class="h-10 md:h-12 w-auto">
            </a>

            {{-- Nav Links desktop --}}
            <div class="hidden md:flex items-center gap-1">
                @foreach([['home','Home'],['about','About'],['services','Services'],['portfolio','Portfolio'],['contact','Contact']] as [$route,$label])
                @php $active = request()->routeIs($route); @endphp
                <a href="{{ route($route) }}"
                   class="px-4 py-2 text-sm font-medium rounded-full transition-colors {{ $active ? 'text-[rgb(var(--pub-panel-text))] bg-[rgba(var(--pub-panel-text),0.10)]' : 'text-[rgba(var(--pub-panel-text),0.65)] hover:text-[rgb(var(--pub-panel-text))] hover:bg-[rgba(var(--pub-panel-text),0.05)]' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            {{-- Mobile spacer --}}
            <div class="flex-1 md:hidden"></div>

            {{-- Mobile hamburger --}}
            <button id="mobile-menu-btn"
                    class="md:hidden p-2 rounded-full text-[rgb(var(--pub-panel-text))]"
                    aria-label="Toggle menu">
                <svg class="w-5 h-5" id="menu-icon-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg class="w-5 h-5 hidden" id="menu-icon-close" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </nav>

        {{-- Pill Kanan --}}
        <a href="{{ route('contact') }}"
           id="nav-pill-right"
           class="nav-pill hidden text-white md:inline-flex items-center gap-3 rounded-full text-sm font-semibold py-2.5 pl-6 pr-4 ml-3">
            <span class="text-[rgba(var(--pub-panel-text),0.85)]">Let's talk</span>
            <span class="inline-flex items-center justify-center rounded-full w-8 h-8 bg-[rgba(var(--pub-panel-text),0.12)] text-[rgb(var(--pub-panel-text))]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
        </a>
    </div>

    {{-- Mobile Dropdown Menu --}}
    <div id="mobile-menu" class="hidden md:hidden mx-3 mt-1 p-4 rounded-2xl shadow-2xl bg-[rgba(var(--pub-panel-dark),0.98)] border border-[rgba(var(--pub-panel-text),0.10)] backdrop-blur-2xl">
        <div class="flex flex-col gap-1">
            @foreach([['home','Home'],['about','About'],['services','Services'],['portfolio','Portfolio'],['contact','Contact']] as [$route,$label])
            @php $active = request()->routeIs($route); @endphp
            <a href="{{ route($route) }}"
               class="text-sm font-medium py-3 px-4 rounded-xl transition-colors {{ $active ? 'text-primary bg-[rgba(var(--pub-panel-text),0.07)]' : 'text-[rgba(var(--pub-panel-text),0.65)] hover:text-[rgb(var(--pub-panel-text))]' }}">
                {{ $label }}
            </a>
            @endforeach

            <div class="h-px bg-[rgba(var(--pub-panel-text),0.08)] my-2"></div>

            <a href="{{ route('contact') }}"
               class="inline-flex items-center justify-center gap-2 rounded-full text-sm font-semibold bg-[rgb(var(--pub-panel-text))] text-[rgb(var(--pub-panel-dark))] py-3 px-6">
                Let's talk
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>

</header>

@push('scripts')
<script>
(function () {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('menu-icon-open');
    const iconClose = document.getElementById('menu-icon-close');
    const pillLeft = document.getElementById('nav-pill-left');
    const pillRight = document.getElementById('nav-pill-right');

    if (btn) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
    }

    function onScroll() {
        const scrolled = window.scrollY > 20;
        if (pillLeft) pillLeft.classList.toggle('scrolled', scrolled);
        if (pillRight) pillRight.classList.toggle('scrolled', scrolled);
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();
</script>
@endpush
