@php
    $footerContact = $contact ?? \App\Models\Setting::getGroup('contact');
    $footerSocial  = $social  ?? \App\Models\Setting::getGroup('social');
@endphp

{{-- Footer: selalu gelap pakai --color-panel-dark
     Light mode: #1A0806 dark maroon | Dark mode: #0F1E2D dark navy --}}
<footer style="background: rgb(var(--color-panel-dark));
               border-top: 1px solid rgba(var(--color-panel-text), 0.08);">
    <div class="container mx-auto px-6 lg:px-8">

        {{-- Baris atas: Logo + Newsletter --}}
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-10 py-16"
             style="border-bottom: 1px solid rgba(var(--color-panel-text), 0.08);">

            {{-- Logo & tagline --}}
            <div class="max-w-xs">
                <a href="{{ route('home') }}" class="inline-flex items-center mb-4">
                    <img src="/logo/asak-horizontal-logo-gold.png" alt="ASAK Agency"
                         style="height: 30px; width: auto;">
                </a>
                <p class="text-sm leading-relaxed"
                   style="color: rgba(var(--color-panel-text), 0.42);">
                    Done Right. Done On Time. The anti-chaos agency — we build systems that scale.
                </p>
            </div>

            {{-- Newsletter --}}
            <div class="w-full lg:max-w-sm">
                <p class="text-sm font-semibold mb-4"
                   style="color: rgba(var(--color-panel-text), 0.85);">
                    Sign up to our newsletter
                </p>
                <form class="flex gap-2" onsubmit="return false;">
                    <input
                        type="email"
                        placeholder="your@email.com"
                        class="flex-1 min-w-0 text-sm outline-none rounded-full px-4 py-2.5"
                        style="background: rgba(var(--color-panel-text), 0.07);
                               border: 1px solid rgba(var(--color-panel-text), 0.15);
                               color: rgb(var(--color-panel-text));
                               transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='rgba(var(--color-panel-text),0.35)'"
                        onblur="this.style.borderColor='rgba(var(--color-panel-text),0.15)'"
                    >
                    <button type="submit"
                            class="shrink-0 text-sm font-semibold rounded-full px-5 py-2.5 transition-opacity"
                            style="background: rgb(var(--color-panel-text));
                                   color: rgb(var(--color-panel-dark));
                                   border: none; cursor: pointer;"
                            onmouseenter="this.style.opacity='0.85'"
                            onmouseleave="this.style.opacity='1'">
                        Sign up
                    </button>
                </form>
                <p class="text-xs mt-3 leading-relaxed"
                   style="color: rgba(var(--color-panel-text), 0.28);">
                    By subscribing, you agree to our
                    <a href="#" style="color: rgba(var(--color-panel-text), 0.50);
                                       text-decoration: underline;">privacy policy</a>.
                    Unsubscribe anytime.
                </p>
            </div>
        </div>

        {{-- Kolom link: Services | Company | Contact --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-10 py-14">

            {{-- Services --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-widest mb-5"
                   style="color: rgba(var(--color-panel-text), 0.32); letter-spacing: 0.12em;">
                    Services
                </p>
                <ul class="space-y-3">
                    @foreach([
                        ['services','brand-engineering', 'Brand Engineering'],
                        ['services','tech-development',  'Tech Development'],
                        ['services','growth-hacking',    'Growth Hacking'],
                        ['services','photo-video',       'Photo & Video'],
                        ['services','ui-ux',             'UI/UX Design'],
                        ['services','digital-strategy',  'Digital Strategy'],
                    ] as [$route,$anchor,$label])
                    <li>
                        <a href="{{ route($route) }}#{{ $anchor }}"
                           class="text-sm footer-link"
                           style="color: rgba(var(--color-panel-text), 0.52);
                                  text-decoration: none; transition: color 0.2s;"
                           onmouseenter="this.style.color='rgb(var(--color-panel-text))'"
                           onmouseleave="this.style.color='rgba(var(--color-panel-text),0.52)'">
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Company --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-widest mb-5"
                   style="color: rgba(var(--color-panel-text), 0.32); letter-spacing: 0.12em;">
                    Company
                </p>
                <ul class="space-y-3">
                    @foreach([
                        ['about',     'About Us'],
                        ['portfolio', 'Portfolio'],
                        ['contact',   'Contact'],
                        ['home',      'Home'],
                    ] as [$route,$label])
                    <li>
                        <a href="{{ route($route) }}"
                           class="text-sm"
                           style="color: rgba(var(--color-panel-text), 0.52);
                                  text-decoration: none; transition: color 0.2s;"
                           onmouseenter="this.style.color='rgb(var(--color-panel-text))'"
                           onmouseleave="this.style.color='rgba(var(--color-panel-text),0.52)'">
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                    <li>
                        <a href="#" class="text-sm"
                           style="color: rgba(var(--color-panel-text), 0.52);
                                  text-decoration: none; transition: color 0.2s;"
                           onmouseenter="this.style.color='rgb(var(--color-panel-text))'"
                           onmouseleave="this.style.color='rgba(var(--color-panel-text),0.52)'">
                            Privacy Policy
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact + Social --}}
            <div class="col-span-2 md:col-span-1">
                <p class="text-xs font-bold uppercase tracking-widest mb-5"
                   style="color: rgba(var(--color-panel-text), 0.32); letter-spacing: 0.12em;">
                    Contact
                </p>
                <ul class="space-y-3 mb-7">
                    <li>
                        <a href="mailto:{{ $footerContact['contact.email'] ?? 'hello@asak.agency' }}"
                           class="text-sm"
                           style="color: rgba(var(--color-panel-text), 0.52);
                                  text-decoration: none; transition: color 0.2s;"
                           onmouseenter="this.style.color='rgb(var(--color-panel-text))'"
                           onmouseleave="this.style.color='rgba(var(--color-panel-text),0.52)'">
                            {{ $footerContact['contact.email'] ?? 'hello@asak.agency' }}
                        </a>
                    </li>
                    <li class="text-sm" style="color: rgba(var(--color-panel-text), 0.52);">
                        {{ $footerContact['contact.website'] ?? 'www.asak.agency' }}
                    </li>
                </ul>

                {{-- Social icons --}}
                <div class="flex items-center gap-2">
                    {{-- Instagram --}}
                    <a href="{{ $footerSocial['social.instagram'] ?? '#' }}"
                       target="_blank" rel="noopener" aria-label="Instagram"
                       class="flex items-center justify-center rounded-full transition-all"
                       style="width: 2.25rem; height: 2.25rem;
                              background: rgba(var(--color-panel-text), 0.08);
                              color: rgba(var(--color-panel-text), 0.50);"
                       onmouseenter="this.style.background='rgba(var(--color-panel-text),0.18)'; this.style.color='rgb(var(--color-panel-text))'"
                       onmouseleave="this.style.background='rgba(var(--color-panel-text),0.08)'; this.style.color='rgba(var(--color-panel-text),0.50)'">
                        <svg style="width:1rem;height:1rem;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    {{-- Twitter/X --}}
                    <a href="{{ $footerSocial['social.twitter'] ?? '#' }}"
                       target="_blank" rel="noopener" aria-label="X"
                       class="flex items-center justify-center rounded-full transition-all"
                       style="width: 2.25rem; height: 2.25rem;
                              background: rgba(var(--color-panel-text), 0.08);
                              color: rgba(var(--color-panel-text), 0.50);"
                       onmouseenter="this.style.background='rgba(var(--color-panel-text),0.18)'; this.style.color='rgb(var(--color-panel-text))'"
                       onmouseleave="this.style.background='rgba(var(--color-panel-text),0.08)'; this.style.color='rgba(var(--color-panel-text),0.50)'">
                        <svg style="width:1rem;height:1rem;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    {{-- LinkedIn --}}
                    <a href="{{ $footerSocial['social.linkedin'] ?? '#' }}"
                       target="_blank" rel="noopener" aria-label="LinkedIn"
                       class="flex items-center justify-center rounded-full transition-all"
                       style="width: 2.25rem; height: 2.25rem;
                              background: rgba(var(--color-panel-text), 0.08);
                              color: rgba(var(--color-panel-text), 0.50);"
                       onmouseenter="this.style.background='rgba(var(--color-panel-text),0.18)'; this.style.color='rgb(var(--color-panel-text))'"
                       onmouseleave="this.style.background='rgba(var(--color-panel-text),0.08)'; this.style.color='rgba(var(--color-panel-text),0.50)'">
                        <svg style="width:1rem;height:1rem;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 py-6"
             style="border-top: 1px solid rgba(var(--color-panel-text), 0.08);">
            <p class="text-xs" style="color: rgba(var(--color-panel-text), 0.28);">
                &copy; {{ date('Y') }} ASAK Agency. All rights reserved.
            </p>
            <div class="flex items-center gap-5">
                <a href="#" class="text-xs transition-colors"
                   style="color: rgba(var(--color-panel-text), 0.28); text-decoration: none;"
                   onmouseenter="this.style.color='rgba(var(--color-panel-text),0.60)'"
                   onmouseleave="this.style.color='rgba(var(--color-panel-text),0.28)'">
                    Privacy Policy
                </a>
                <a href="#" class="text-xs transition-colors"
                   style="color: rgba(var(--color-panel-text), 0.28); text-decoration: none;"
                   onmouseenter="this.style.color='rgba(var(--color-panel-text),0.60)'"
                   onmouseleave="this.style.color='rgba(var(--color-panel-text),0.28)'">
                    Terms of Service
                </a>
            </div>
        </div>

    </div>
</footer>
