<header class="fixed top-0 left-0 right-0 z-50" id="main-navbar">

    {{-- ══════════════════════════════════════════
         Outer wrapper:
         Mobile → no horizontal padding (full-width pill)
         Desktop → px-8 / lg:px-10 with margin
    ══════════════════════════════════════════ --}}
    <div class="flex items-start justify-between px-3 pt-3 md:px-8 lg:px-10" id="navbar-outer">

        {{-- ══════════════════════════════════════════
             PILL KIRI — full width on mobile, auto on desktop
             rounded-2xl on mobile (pill look), rounded-full on desktop
        ══════════════════════════════════════════ --}}
        <nav id="nav-pill-left"
             class="flex items-center gap-1 flex-1 md:flex-none rounded-2xl md:rounded-full transition-all duration-300"
             style="background: rgba(var(--color-panel-dark), 0.92);
                    backdrop-filter: blur(24px);
                    -webkit-backdrop-filter: blur(24px);
                    border: 1px solid rgba(var(--color-panel-text), 0.10);
                    padding: 0.5rem 0.75rem 0.5rem 1.25rem;
                    box-shadow: 0 4px 24px rgba(0,0,0,0.20);">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0 mr-4">
                <img src="/logo/asak-horizontal-logo-red.png" alt="ASAK Agency"
                     style="height: 48px; width: auto;">
            </a>

            {{-- Nav Links desktop --}}
            <div class="hidden md:flex items-center flex-1">
                @foreach([['home','Home'],['about','About'],['services','Services'],['portfolio','Portfolio'],['contact','Contact']] as [$route,$label])
                @php $active = request()->routeIs($route); @endphp
                <a href="{{ route($route) }}"
                   class="px-4 py-2 text-sm font-medium rounded-full transition-colors"
                   style="color: {{ $active
                       ? 'rgb(var(--color-panel-text))'
                       : 'rgba(var(--color-panel-text), 0.65)' }};"
                   onmouseenter="this.style.color='rgb(var(--color-panel-text))'"
                   onmouseleave="this.style.color='{{ $active
                       ? 'rgb(var(--color-panel-text))'
                       : 'rgba(var(--color-panel-text), 0.65)' }}'">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            {{-- Mobile: spacer pushes hamburger to far right --}}
            <div class="flex-1 md:hidden"></div>

            {{-- Mobile hamburger --}}
            <button id="mobile-menu-btn"
                    class="md:hidden p-2 rounded-full"
                    style="color: rgb(var(--color-panel-text));"
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

        {{-- ══════════════════════════════════════════
             PILL KANAN — CTA "Let's talk →" (desktop only)
        ══════════════════════════════════════════ --}}
        <a href="{{ route('contact') }}"
           id="nav-pill-right"
           class="hidden md:inline-flex items-center gap-2 rounded-full text-sm font-semibold transition-all flex-shrink-0 ml-3"
           style="background: rgba(var(--color-panel-dark), 0.92);
                  backdrop-filter: blur(24px);
                  -webkit-backdrop-filter: blur(24px);
                  border: 1px solid rgba(var(--color-panel-text), 0.10);
                  color: rgba(var(--color-panel-text), 0.80);
                  padding: 0.625rem 0.75rem 0.625rem 1.375rem;
                  box-shadow: 0 4px 24px rgba(0,0,0,0.20);"
           onmouseenter="this.style.color='rgb(var(--color-panel-text))'; this.style.borderColor='rgba(var(--color-panel-text),0.25)'"
           onmouseleave="this.style.color='rgba(var(--color-panel-text),0.80)'; this.style.borderColor='rgba(var(--color-panel-text),0.10)'">
            Let's talk
            <span class="inline-flex items-center justify-center rounded-full"
                  style="width:1.875rem; height:1.875rem;
                         background: rgba(var(--color-panel-text), 0.12);">
                <svg style="width:0.75rem; height:0.75rem;"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
        </a>

    </div>

    {{-- ══════════════════════════════════════════
         Mobile Dropdown Menu — full width, no margin
    ══════════════════════════════════════════ --}}
    <div id="mobile-menu" class="hidden md:hidden mx-3 mt-1 p-4 rounded-2xl shadow-2xl"
         style="background: rgba(var(--color-panel-dark), 0.98);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border: 1px solid rgba(var(--color-panel-text), 0.10);">
        <div class="flex flex-col gap-1">
            @foreach([['home','Home'],['about','About'],['services','Services'],['portfolio','Portfolio'],['contact','Contact']] as [$route,$label])
            @php $active = request()->routeIs($route); @endphp
            <a href="{{ route($route) }}"
               class="text-sm font-medium py-3 px-4 rounded-xl transition-colors"
               style="color: {{ $active ? 'rgb(var(--color-accent))' : 'rgba(var(--color-panel-text), 0.65)' }};
                      {{ $active ? 'background: rgba(var(--color-panel-text), 0.07);' : '' }}">
                {{ $label }}
            </a>
            @endforeach

            <div style="height:1px; background:rgba(var(--color-panel-text),0.08); margin:0.5rem 0;"></div>

            <a href="{{ route('contact') }}"
               class="inline-flex items-center justify-center gap-2 rounded-full text-sm font-semibold"
               style="background: rgb(var(--color-panel-text));
                      color: rgb(var(--color-panel-dark));
                      padding: 0.75rem 1.5rem;">
                Let's talk
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>

</header>

@push('scripts')
<script>
(function () {
    /* ── Mobile menu toggle ── */
    var btn      = document.getElementById('mobile-menu-btn');
    var menu     = document.getElementById('mobile-menu');
    var iconOpen = document.getElementById('menu-icon-open');
    var iconClose= document.getElementById('menu-icon-close');
    if (btn) {
        btn.addEventListener('click', function () {
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
    }

    /* ── Scroll-aware navbar ──
       On scroll: darken pills to fully opaque so text stays readable
       regardless of the page background color beneath               */
    var pillLeft  = document.getElementById('nav-pill-left');
    var pillRight = document.getElementById('nav-pill-right');

    function applyScrollState(scrolled) {
        var bg     = scrolled ? 'rgba(var(--color-panel-dark), 1)'   : 'rgba(var(--color-panel-dark), 0.92)';
        var shadow = scrolled ? '0 8px 32px rgba(0,0,0,0.35)'        : '0 4px 24px rgba(0,0,0,0.20)';
        var border = scrolled ? 'rgba(var(--color-panel-text), 0.18)' : 'rgba(var(--color-panel-text), 0.10)';

        if (pillLeft) {
            pillLeft.style.background  = bg;
            pillLeft.style.boxShadow   = shadow;
            pillLeft.style.borderColor = border;
        }
        if (pillRight) {
            pillRight.style.background  = bg;
            pillRight.style.boxShadow   = shadow;
            pillRight.style.borderColor = border;
        }
    }

    /* CSS custom properties can't be used in rgba() via CSS vars when the
       variable contains spaces (old browser quirk), so we read the actual
       computed RGB value from the root and apply it as a solid background. */
    function getSolidBg(alpha) {
        var isLight = document.getElementById('html-root')
                        ? document.getElementById('html-root').classList.contains('light')
                        : true;
        /* light mode panel-dark = #1A0806, dark mode = #0A1520 */
        return isLight
            ? 'rgba(26, 8, 6, ' + alpha + ')'
            : 'rgba(10, 21, 32, ' + alpha + ')';
    }

    function onScroll() {
        var scrolled = window.scrollY > 20;
        var bg     = getSolidBg(scrolled ? 1 : 0.92);
        var shadow = scrolled ? '0 8px 32px rgba(0,0,0,0.38)' : '0 4px 24px rgba(0,0,0,0.20)';
        var border = scrolled ? 'rgba(255,255,255,0.14)'       : 'rgba(255,255,255,0.10)';

        if (pillLeft) {
            pillLeft.style.background  = bg;
            pillLeft.style.boxShadow   = shadow;
            pillLeft.style.borderColor = border;
        }
        if (pillRight) {
            pillRight.style.background  = bg;
            pillRight.style.boxShadow   = shadow;
            pillRight.style.borderColor = border;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); /* run once on load */
})();
</script>
@endpush
