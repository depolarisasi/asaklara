@extends('layouts.public')
@section('title', 'Home')

@section('content')

{{-- ============================================================
     HERO SECTION — Obsidian-style full-screen
     Semua warna pakai CSS variables (--color-panel-dark / --color-panel-text)
     agar ikut color scheme & theme switcher
     ============================================================ --}}
<section style="position:relative; min-height:100vh; overflow:hidden; background:rgb(var(--color-panel-dark));">

    {{-- Background image + gradient overlays --}}
    <div style="position:absolute; inset:0;">
        <img src="{{asset('hero-image.png')}}"
             alt=""
             style="width:100%; height:100%; object-fit:cover; opacity:0.85;">
        {{-- Directional gradient: kiri gelap (area teks), kanan lebih transparan (area foto) --}}
        <div style="position:absolute; inset:0;
                    background: linear-gradient(110deg,
                        rgba(var(--color-panel-dark),0.92) 0%,
                        rgba(var(--color-panel-dark),0.30) 60%,
                        rgba(var(--color-panel-dark),0.55) 100%);"></div>
        {{-- Bottom fade --}}
        <div style="position:absolute; inset:0;
                    background: linear-gradient(to top,
                        rgba(var(--color-panel-dark),1) 0%,
                        transparent 50%);"></div>
        {{-- Accent glow top-right --}}
        <div style="position:absolute; top:0; right:0; width:24rem; height:24rem;
                    border-radius:9999px;
                    background:rgba(var(--color-accent),0.10);
                    filter:blur(80px);"></div>
    </div>

    {{-- Content: flex column — fills full height, no absolute overlap --}}
    <div style="position:relative; z-index:10; min-height:100vh;
                display:flex; flex-direction:column;">

        {{-- Spacer untuk navbar --}}
        <div style="height:6.5rem; flex-shrink:0;"></div>

        {{-- Main area: flex-grow, konten di bawah (items-end) --}}
        <div class="flex-1 flex items-end container mx-auto px-6 lg:px-8 pb-16">
            <div class="w-full">

                {{-- Grid 2 kolom: kiri counter + insight, kanan konten utama --}}
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-end">

                    {{-- KIRI: Counter stats (atas) + Latest Insight card (bawah) --}}
                    <div class="flex flex-col gap-6 order-2 lg:order-1">

                        {{-- Stats / Counters --}}
                        <div class="grid grid-cols-3 gap-4">
                            @foreach([
                                ['100s',  'International Projects'],
                                ['100%',  'Radical Transparency'],
                                ['Zero',  'Delay Protocol'],
                            ] as [$num, $label])
                            <div class="p-5 rounded-2xl text-center"
                                 style="background: rgba(var(--color-panel-text), 0.06);
                                        backdrop-filter: blur(24px);
                                        -webkit-backdrop-filter: blur(24px);
                                        border: 1px solid rgba(var(--color-panel-text), 0.12);">
                                <p class="font-heading font-bold mb-1"
                                   style="font-size: clamp(1.4rem, 3vw, 2rem);
                                          color: rgb(var(--color-panel-text));">
                                    {{ $num }}
                                </p>
                                <p class="text-xs leading-snug"
                                   style="color: rgba(var(--color-panel-text), 0.50);">
                                    {{ $label }}
                                </p>
                            </div>
                            @endforeach
                        </div>

                        {{-- Latest Insight card --}}
                        <a href="#"
                           class="group block p-6 rounded-2xl transition-all duration-300"
                           style="background: rgba(var(--color-panel-text), 0.07);
                                  backdrop-filter: blur(24px);
                                  -webkit-backdrop-filter: blur(24px);
                                  border: 1px solid rgba(var(--color-panel-text), 0.14);
                                  text-decoration: none;"
                           onmouseenter="this.style.background='rgba(var(--color-panel-text),0.11)'"
                           onmouseleave="this.style.background='rgba(var(--color-panel-text),0.07)'">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold uppercase tracking-widest"
                                      style="color: rgb(var(--color-accent));">Latest Insight</span>
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                     style="color: rgba(var(--color-panel-text), 0.35);"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 17L17 7M17 7H7M17 7v10"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold leading-snug"
                               style="color: rgba(var(--color-panel-text), 0.88);">
                                How to build a brand identity system that AI can actually use
                            </p>
                            <p class="text-xs mt-2"
                               style="color: rgba(var(--color-panel-text), 0.40);">
                                Brand Engineering · 5 min read
                            </p>
                        </a>

                    </div>
                    {{-- END KIRI --}}

                    {{-- KANAN: Glass card — Badge + Headline + subheadline + tags + CTA --}}
                    <div class="order-1 lg:order-2">
                        <div class="p-8 lg:p-10 rounded-3xl"
                             style="background: rgba(var(--color-panel-text), 0.06);
                                    backdrop-filter: blur(28px);
                                    -webkit-backdrop-filter: blur(28px);
                                    border: 1px solid rgba(var(--color-panel-text), 0.13);
                                    box-shadow: 0 8px 32px rgba(0,0,0,0.18);">

                            {{-- Badge anti-chaos --}}
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full mb-6"
                                 style="background: rgb(var(--color-primary));
                                        border: 1px solid rgba(var(--color-primary), 0.30);">
                                <span class="w-1.5 h-1.5 rounded-full" style="background: white;"></span>
                                <span class="text-xs font-semibold" style="color: white;">The Anti-Chaos Agency</span>
                            </div>

                            <h1 class="font-heading font-bold leading-tight text-balance mb-5"
                                style="font-size:clamp(2rem,5vw,4rem); color:rgb(var(--color-panel-text));">
                                {{ $hero['hero.headline'] ?? 'Done Right.' }}
                                <em class="not-italic block" style="color:rgb(var(--color-primary))">
                                    {{ $hero['hero.headline_accent'] ?? 'Done On Time.' }}
                                </em>
                            </h1>

                            <p class="text-base leading-relaxed mb-7"
                               style="color: rgba(var(--color-panel-text), 0.75); max-width:38rem;">
                                {{ $hero['hero.subheadline'] ?? "We are the anti-chaos agency. We bridge the gap between creative disruption and operational excellence. We don't just \"make things\"—we build systems that scale." }}
                            </p>

                            {{-- Service tag pills --}}
                            <div class="flex flex-wrap gap-2 mb-8">
                                @foreach(['Brand Engineering','Tech Development','Growth Hacking','UI/UX Design','Photo & Video','Digital Strategy'] as $tag)
                                <span style="padding:0.35rem 0.9rem; border-radius:9999px;
                                             font-size:0.72rem; font-weight:500;
                                             color: rgba(var(--color-panel-text), 0.80);
                                             background:rgba(var(--color-panel-text),0.08);
                                             border:1px solid rgba(var(--color-panel-text),0.16);">
                                    {{ $tag }}
                                </span>
                                @endforeach
                            </div>

                            {{-- CTA Button --}}
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-semibold text-sm transition-all"
                               style="background:rgb(var(--color-primary)); color: white;"
                               onmouseenter="this.style.opacity='0.88'"
                               onmouseleave="this.style.opacity='1'">
                                {{ $hero['hero.cta_primary'] ?? 'Start a Project' }}
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>


{{-- ============================================================
     SERVICES PREVIEW — Obsidian-style 2-column layout
     Pakai Tailwind classes untuk responsif, tanpa <style> di dalam body
     ============================================================ --}}
<section class="relative overflow-hidden">
    <div class="flex flex-col lg:flex-row" style="min-height: 65vh;">

        {{-- KIRI: Deskripsi + pill tags — background halaman biasa --}}
        <div class="w-full lg:w-5/12 flex flex-col justify-center px-8 py-16 lg:px-16 xl:px-20 lg:py-20"
             style="background: rgb(var(--color-background));">

            <p class="text-xs font-bold uppercase tracking-widest mb-6"
               style="color: rgb(var(--color-primary)); letter-spacing: 0.12em;">Services</p>

            <p class="font-medium leading-relaxed mb-10 text-balance"
               style="font-size: clamp(1.1rem, 2vw, 1.5rem); line-height: 1.6;
                      color: rgb(var(--color-foreground));">
                We don't just specialize in our services; we are experts in the
                <em style="font-style: italic; color: rgb(var(--color-primary))">businesses</em>
                of our clients. Fully tested, fully optimized, ready for market impact.
            </p>

            {{-- Pill tags --}}
            <div class="flex flex-wrap gap-2">
                @foreach(['Brand Engineering','UI/UX Design','Visual Identity','Graphic & Video',
                          'Tech Development','Web Apps','Custom Software',
                          'Growth Hacking','SEO & SEM','Data-Driven Marketing',
                          'Photo & Video','Content Creation'] as $tag)
                <span class="px-3.5 py-1.5 rounded-full text-xs font-medium"
                      style="background: rgba(var(--color-muted), 0.50);
                             border: 1px solid rgba(var(--color-border), 0.65);
                             color: rgb(var(--color-foreground));">
                    {{ $tag }}
                </span>
                @endforeach
            </div>
        </div>

        {{-- KANAN: Service list accordion — selalu gelap (panel-dark) --}}
        <div class="w-full lg:w-7/12 flex flex-col justify-center px-8 py-16 lg:px-16 xl:px-20 lg:py-20"
             style="background: rgb(var(--color-panel-dark));">

            <p class="text-xs font-bold uppercase tracking-widest mb-8"
               style="color: rgba(var(--color-panel-text), 0.35); letter-spacing: 0.12em;">What We Do</p>

            @php
                $serviceList = (isset($services) && $services->count())
                    ? $services->map(fn($s) => ['title' => $s->title, 'anchor' => $s->slug])->toArray()
                    : [
                        ['title' => 'Brand Engineering',   'anchor' => 'brand-engineering'],
                        ['title' => 'Tech Development',    'anchor' => 'tech-development'],
                        ['title' => 'Growth Hacking',      'anchor' => 'growth-hacking'],
                        ['title' => 'Photo & Videography', 'anchor' => 'photo-video'],
                      ];
            @endphp

            <div>
                @foreach($serviceList as $svc)
                <a href="{{ route('services') }}#{{ $svc['anchor'] }}"
                   class="services-list-row flex items-center justify-between py-5"
                   style="border-bottom: 1px solid rgba(var(--color-panel-text), 0.09);
                          text-decoration: none;">
                    <span class="services-list-title font-heading font-semibold"
                          style="font-size: clamp(1.05rem, 1.8vw, 1.4rem);
                                 color: rgb(var(--color-panel-text));
                                 transition: color 0.2s;">
                        {{ $svc['title'] }}
                    </span>
                    <svg class="services-list-arrow shrink-0 ml-5"
                         style="width: 1.25rem; height: 1.25rem;
                                color: rgba(var(--color-panel-text), 0.30);
                                transition: transform 0.2s, color 0.2s;"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                @endforeach
            </div>

            <a href="{{ route('services') }}"
               class="services-viewall inline-flex items-center gap-2 mt-8 text-sm font-medium"
               style="color: rgba(var(--color-panel-text), 0.40); text-decoration: none;
                      transition: color 0.2s;">
                View all services
                <svg style="width: 1rem; height: 1rem; flex-shrink: 0;"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>

@push('scripts')
<script>
(function () {
    document.querySelectorAll('.services-list-row').forEach(function (row) {
        var title = row.querySelector('.services-list-title');
        var arrow = row.querySelector('.services-list-arrow');
        row.addEventListener('mouseenter', function () {
            title.style.color = 'rgb(var(--color-accent))';
            arrow.style.color = 'rgb(var(--color-accent))';
            arrow.style.transform = 'translateX(8px)';
        });
        row.addEventListener('mouseleave', function () {
            title.style.color = 'rgb(var(--color-panel-text))';
            arrow.style.color = 'rgba(var(--color-panel-text), 0.30)';
            arrow.style.transform = 'translateX(0)';
        });
    });
    document.querySelectorAll('.services-viewall').forEach(function (a) {
        a.addEventListener('mouseenter', function () { a.style.color = 'rgb(var(--color-panel-text))'; });
        a.addEventListener('mouseleave', function () { a.style.color = 'rgba(var(--color-panel-text), 0.40)'; });
    });
})();
</script>
@endpush


{{-- ============================================================
     ABOUT PREVIEW
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Visual: aspect-[4/5] rounded-3xl overflow-hidden --}}
            <div class="relative">
                <div class="relative rounded-3xl overflow-hidden"
                     style="aspect-ratio: 4/5; background: rgba(var(--color-muted), 0.30)">
                    <img src="https://picsum.photos/seed/office-team/600/750"
                         alt="ASAK Agency Team"
                         class="absolute inset-0 w-full h-full object-cover">

                    {{-- Glass overlay card: absolute bottom-6 left-6 right-6 p-6 rounded-2xl bg-background/70 backdrop-blur-xl --}}
                    <div class="absolute bottom-6 left-6 right-6 p-6 rounded-2xl"
                         style="background: rgba(var(--color-background), 0.70);
                                backdrop-filter: blur(24px);
                                -webkit-backdrop-filter: blur(24px);
                                border: 1px solid rgba(var(--color-border), 0.50);">
                        <div class="flex items-center gap-4">
                            {{-- Stacked avatars --}}
                            <div class="flex">
                                @if($team->count())
                                    @foreach($team->take(4) as $member)
                                    <img src="{{ $member->image_url }}"
                                         alt="{{ $member->name }}"
                                         class="w-10 h-10 rounded-full object-cover"
                                         style="border: 2px solid rgb(var(--color-background)); {{ $loop->first ? '' : 'margin-left: -12px;' }}">
                                    @endforeach
                                @else
                                    @foreach(['a','b','c','d'] as $si => $seed)
                                    <img src="https://picsum.photos/seed/comrade-{{ $seed }}/40/40"
                                         alt="Team member"
                                         class="w-10 h-10 rounded-full object-cover"
                                         style="border: 2px solid rgb(var(--color-background)); {{ $si === 0 ? '' : 'margin-left: -12px;' }}">
                                    @endforeach
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold" style="color: rgb(var(--color-foreground))">Meet the Comrades</p>
                                <p class="text-sm" style="color: rgb(var(--color-muted-foreground))">Your dedicated digital partners</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Decorative: absolute -bottom-6 -right-6 w-32 h-32 rounded-3xl bg-primary/10 -z-10 --}}
                <div class="absolute w-32 h-32 rounded-3xl"
                     style="background: rgba(var(--color-primary), 0.10); bottom: -24px; right: -24px; z-index: -1;"></div>
            </div>

            {{-- Content --}}
            <div>
                <p class="font-medium mb-3" style="color: rgb(var(--color-primary))">About Us</p>
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6 text-balance"
                    style="color: rgb(var(--color-foreground))">
                    {{ $about['about.philosophy'] ?? '"Asak" Means Mature. Ready.' }}
                </h2>
                <p class="text-lg leading-relaxed mb-8" style="color: rgb(var(--color-muted-foreground))">
                    {{ $about['about.story_text_2'] ?? "We believe that great ideas are worthless if they remain \"raw\" or poorly executed. At asak digital, we bridge the gap between abstract concepts and concrete reality. We don't just deliver projects; we deliver maturity—fully tested, fully optimized, and ready for market impact." }}
                </p>

                {{-- Highlights: flex items-center gap-3, circle icon glass, CheckCircle text-primary --}}
                <ul class="space-y-4 mb-10">
                    @php
                        $highlights = [
                            'Radical Transparency - Full visibility, zero surprises',
                            'Zero-Delay Protocol - We hit every milestone',
                            'Global Standard - Hundreds of international projects',
                            'Definition of Done - Fully tested, fully optimized',
                        ];
                    @endphp
                    @foreach($highlights as $item)
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0"
                             style="background: rgba(var(--color-background), 0.60);
                                    backdrop-filter: blur(24px);
                                    -webkit-backdrop-filter: blur(24px);
                                    border: 1px solid rgba(var(--color-border), 0.50);">
                            {{-- CheckCircle icon --}}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 style="color: rgb(var(--color-primary))">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span style="color: rgb(var(--color-foreground))">{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>

                {{-- CTA: size lg = h-10 rounded-full px-8 --}}
                <a href="{{ route('about') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all hover:opacity-90"
                   style="background: rgb(var(--color-primary)); color: rgb(var(--color-primary-foreground));">
                    Learn More About Us
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</section>


{{-- ============================================================
     PORTFOLIO PREVIEW
     ============================================================ --}}
@if($portfolios->count())
<section class="py-20 lg:py-32" style="background: rgba(var(--color-muted), 0.30)">
    <div class="container mx-auto px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16">
            <div>
                <p class="font-medium mb-3" style="color: rgb(var(--color-primary))">Our Work</p>
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold text-balance"
                    style="color: rgb(var(--color-foreground))">Selected Projects</h2>
            </div>
            <a href="{{ route('portfolio') }}"
               class="inline-flex items-center gap-2 font-medium transition-all"
               style="color: rgb(var(--color-primary))"
               onmouseenter="this.style.gap='12px'" onmouseleave="this.style.gap=''">
                View All Projects
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        {{-- Equal 3 columns, aspect-[4/3] --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($portfolios as $project)
            <a href="{{ route('portfolio') }}#{{ $project->slug }}"
               class="portfolio-card group relative rounded-3xl overflow-hidden transition-all duration-300"
               style="background: rgba(var(--color-background), 0.60);
                      backdrop-filter: blur(24px);
                      -webkit-backdrop-filter: blur(24px);
                      border: 1px solid rgba(var(--color-border), 0.50);
                      display: block;
                      text-decoration: none;">

                {{-- Image: aspect-[4/3] --}}
                <div class="relative overflow-hidden" style="aspect-ratio: 4/3; background: rgba(var(--color-muted), 0.30)">
                    <img src="{{ $project->image_url }}"
                         alt="{{ $project->title }}"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                    {{-- Hover overlay: bg-foreground/80 + ArrowUpRight in primary circle --}}
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center transition-opacity duration-300"
                         style="background: rgba(var(--color-foreground), 0.80); opacity: 0;">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center"
                             style="background: rgb(var(--color-primary));">
                            {{-- ArrowUpRight --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 style="color: rgb(var(--color-primary-foreground))">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6">
                    <p class="text-sm font-medium mb-2" style="color: rgb(var(--color-primary))">
                        {{ $project->category }}
                    </p>
                    <h3 class="font-heading text-xl font-semibold mb-2" style="color: rgb(var(--color-foreground))">
                        {{ $project->title }}
                    </h3>
                    <p class="text-sm" style="color: rgb(var(--color-muted-foreground))">
                        {{ $project->client ?? $project->description }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ============================================================
     CTA SECTION
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">

        {{-- Card wrapper — matches Next.js: foreground/95% bg + backdrop-blur --}}
        <div class="relative rounded-3xl overflow-hidden relative rounded-3xl bg-foreground/95 backdrop-blur-xl border border-foreground/20 overflow-hidden"
             style="background: rgba(var(--color-foreground), 0.95);
                    backdrop-filter: blur(24px);
                    -webkit-backdrop-filter: blur(24px);
                    border: 1px solid rgba(var(--color-primary), 0.20);">

            {{-- Background decoration — ring-colored glass gradient (matches Next.js) --}}
            <div class="absolute inset-0" style="pointer-events:none; overflow:hidden;">
                {{-- Full radial gradient overlay --}}
                <div class="absolute inset-0"
                     style="background: radial-gradient(ellipse at 70% 50%, rgba(var(--color-primary), 0.50), transparent 70%)"></div>
                {{-- Top-right blob --}}
                <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl"
                     style="background: rgba(var(--color-accent), 0.30)"></div>
                {{-- Bottom-left blob --}}
                <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl"
                     style="background: rgba(var(--color-accent), 0.15)"></div>
            </div>

            {{-- Content --}}
            <div class="relative py-16 lg:py-24 px-8 lg:px-16 text-center" style="z-index:10">
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6 max-w-3xl mx-auto text-balance"
                    style="color: rgb(var(--color-primary))">
                    Let's Build Something Mature.
                </h2>
                <p class="text-lg max-w-2xl mx-auto mb-10"
                   style="color: rgba(var(--color-background), 0.70)">
                    Most agencies sell dreams but deliver nightmares. You deserve a partner who treats your business with military precision. Ready to experience the difference?
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    {{-- Primary: bg-background text-primary (cream button, maroon text) --}}
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all hover:opacity-90"
                       style="background: rgb(var(--color-background)); color: rgb(var(--color-primary));">
                        Start a Conversation
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    {{-- Outline --}}
                    <a href="{{ route('portfolio') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all"
                       style="background: transparent;
                              border: 1px solid rgba(var(--color-background), 0.30);
                              color: rgb(var(--color-background));"
                       onmouseenter="this.style.background='rgba(var(--color-background), 0.10)'"
                       onmouseleave="this.style.background='transparent'">
                        Explore Our Work
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
