@extends('layouts.public')
@section('title', 'Home')

@section('content')

{{-- ============================================================
     HERO SECTION — Obsidian-style full-screen
     Semua warna pakai CSS variables (--color-panel-dark / --color-panel-text)
     agar ikut color scheme & theme switcher
     ============================================================ --}}
<section class="hero-container">

    {{-- Background image + gradient overlays --}}
    <div class="hero-media">
        <img src="{{asset('hero-image.png')}}" alt="Hero Image">
        <div class="hero-overlay-directional"></div>
        <div class="hero-overlay-primary"></div>
        <div class="hero-overlay-bottom"></div>
        <div class="hero-accent-glow"></div>
    </div>

    {{-- Content: flex column --}}
    <div class="relative z-10 min-h-screen flex flex-col">

        {{-- Spacer untuk navbar --}}
        <div class="navbar-spacer"></div>

        {{-- Main area --}}
        <div class="flex-1 flex items-end container mx-auto px-6 lg:px-8 pb-16">
            <div class="w-full">

                {{-- Grid 2 kolom --}}
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-end">

                    {{-- KIRI: Counter stats + Carousel --}}
                    <div class="flex flex-col gap-6 order-2 lg:order-1">

                       

                        {{-- Latest Insight Carousel --}}
                        <div class="w-full max-w-md">
                            <div x-data="{ 
                                    activeSlide: 0, 
                                    insights: [
                                        { 
                                            category: 'Brand Engineering', 
                                            title: 'How to build a brand identity system that AI can actually use', 
                                            readTime: '5 min read',
                                            image: '{{ asset('images/insight-ai-brand.png') }}',
                                            link: '{{ route('design') }}'
                                        },
                                        { 
                                            category: 'Tech Development', 
                                            title: 'Future-proofing your tech stack with modular architecture', 
                                            readTime: '7 min read',
                                            image: '{{ asset('images/insight-tech-arch.png') }}',
                                            link: '#'
                                        },
                                        { 
                                            category: 'Growth Hacking', 
                                            title: 'Data-driven growth strategies that scaled $10M+ brands', 
                                            readTime: '6 min read',
                                            image: '{{ asset('images/insight-data-growth.png') }}',
                                            link: '#'
                                        }
                                    ],
                                    next() { this.activeSlide = (this.activeSlide + 1) % this.insights.length },
                                    prev() { this.activeSlide = (this.activeSlide - 1 + this.insights.length) % this.insights.length },
                                    init() { setInterval(() => this.next(), 8000) }
                                 }"
                                 class="relative">
                                
                                <div class="relative overflow-hidden h-[120px] lg:h-[130px]">
                                    <template x-for="(insight, index) in insights" :key="index">
                                        <div x-show="activeSlide === index"
                                             x-transition:enter="transition ease-out duration-700"
                                             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                             x-transition:leave="transition ease-in duration-500 absolute inset-0"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-105"
                                             class="absolute inset-0">
                                            
                                            <a :href="insight.link"
                                               class="insight-card group block p-4 rounded-2xl h-full no-underline">
                                                
                                                <div class="flex gap-5 items-center h-full">
                                                    {{-- Thumbnail --}}
                                                    <div class="relative shrink-0 w-20 h-20 rounded-xl overflow-hidden border border-[rgb(var(--pub-panel-text)/0.10)]">
                                                        <img :src="insight.image" 
                                                             :alt="insight.title" 
                                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                                    </div>
    
                                                    {{-- Text Content --}}
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-accent">Latest Insight</span>
                                                        </div>
                                                        <h3 class="text-sm font-bold leading-tight mb-1.5 line-clamp-2 text-[rgb(var(--pub-panel-text))]"
                                                            x-text="insight.title">
                                                        </h3>
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-[10px] text-white" x-text="insight.category"></span>
                                                            <span class="w-1 h-1 rounded-full bg-[rgb(var(--pub-panel-text)/0.10)]"></span>
                                                            <span class="text-[10px] text-white" x-text="insight.readTime"></span>
                                                        </div>
                                                    </div>
    
                                                    {{-- Arrow --}}
                                                    <div class="shrink-0 flex items-center justify-center w-7 h-7 rounded-full transition-all duration-300 group-hover:bg-accent/10 border border-[rgb(var(--pub-panel-text)/0.05)]">
                                                        <svg class="w-3 h-3 text-[rgb(var(--pub-panel-text)/0.30)]"
                                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                                  d="M7 17L17 7M17 7H7M17 7v10"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </template>
                                </div>
    
                                {{-- Pagination Dots --}}
                                <div class="flex justify-start gap-2 mt-4 ml-1">
                                    <template x-for="(insight, index) in insights" :key="index">
                                        <button @click="activeSlide = index"
                                                class="h-1 rounded-full transition-all duration-300"
                                                :class="activeSlide === index ? 'w-6 bg-accent' : 'w-2 bg-[rgb(var(--pub-panel-text)/0.15)]'">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- END KIRI --}}

                    {{-- KANAN: Glass card --}}
                    <div class="order-1 lg:order-2">
                        <div class="p-8 lg:p-10 rounded-3xl bg-[--white-glass] backdrop-blur-[26px] shadow-[0_8px_32px_rgb(0,0,0,0.18)]">
 
                            <h1 class="font-heading font-bold leading-tight text-balance mb-5 text-[clamp(2rem,5vw,4rem)] text-[rgb(var(--pub-panel-text))]">
                                {{ $hero['hero.headline'] ?? 'Done Right.' }}
                                <em class="not-italic block text-accent">
                                    {{ $hero['hero.headline_accent'] ?? 'Done On Time.' }}
                                </em>
                            </h1>

                            <p class="text-white leading-relaxed mb-7 max-w-[38rem]">
                                {{ $hero['hero.subheadline'] ?? "We are the anti-chaos agency. We bridge the gap between creative disruption and operational excellence. We don't just \"make things\"—we build systems that scale." }}
                            </p>

                            {{-- Service tag pills --}}
                            <div class="flex flex-wrap gap-2 mb-8">
                                @foreach(['Brand Engineering','Tech Development','Growth Hacking','Photo & Video'] as $tag)
                                <span class="px-3.5 py-1.5 rounded-full text-[0.72rem] font-medium text-white bg-[rgb(var(--pub-panel-text)/0.08)] border border-[rgb(var(--pub-panel-text)/0.16)]">
                                    {{ $tag }}
                                </span>
                                @endforeach
                            </div>

                            {{-- CTA Button --}}
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-semibold text-sm transition-all bg-primary text-white hover:opacity-88">
                                {{ $hero['hero.cta_primary'] ?? 'Start a Project' }}
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>

                        </div>
                    </div>
                    {{-- END KANAN --}}

                </div>
            </div>
        </div>

    </div>
</section>
 
<section class="relative overflow-hidden">
    <div class="flex flex-col lg:flex-row min-h-[65vh]">

        {{-- KIRI: Deskripsi + pill tags --}}
        <div class="w-full lg:w-5/12 flex flex-col justify-center px-8 py-16 lg:px-16 xl:px-20 lg:py-20 bg-[rgb(var(--pub-bg))]">

            <p class="text-xs font-bold uppercase tracking-widest mb-6 text-primary tracking-[0.12em]">Services</p>

            <p class="font-medium leading-relaxed mb-10 text-balance text-[clamp(1.1rem,2vw,1.5rem)] leading-[1.6] text-[rgb(var(--pub-fg))]">
                We don't just specialize in our services; we are experts in the
                <em class="italic text-primary">businesses</em>
                of our clients. Fully tested, fully optimized, ready for market impact.
            </p>

            {{-- Pill tags --}}
            <div class="flex flex-wrap gap-2">
                @foreach(['Graphic Design',
                          'Tech Development',
                          'Digital Marketing',
                          'Photography & Videography'] as $tag)
                <span class="px-3.5 py-1.5 rounded-full text-xs font-medium bg-[rgb(var(--pub-muted)/0.50)] border border-[rgb(var(--pub-border)/0.65)] text-[rgb(var(--pub-fg))]">
                    {{ $tag }}
                </span>
                @endforeach
            </div>
        </div>
 
        <div class="w-full lg:w-7/12 flex flex-col justify-center px-8 py-16 lg:px-16 xl:px-20 lg:py-20 bg-[rgb(var(--pub-panel-dark))]">

            <p class="text-xs font-bold uppercase tracking-widest mb-8 text-white tracking-[0.12em]">What We Do</p>

            @php
                $serviceList = (isset($services) && $services->count())
                    ? $services->map(fn($s) => ['title' => $s->title, 'url' => strtolower($s->title) === 'brand engineering' ? route('design') : route('services') . '#' . $s->slug])->toArray()
                    : [
                        ['title' => 'Brand Engineering',   'url' => route('design')],
                        ['title' => 'Tech Development',    'url' => route('services') . '#tech-development'],
                        ['title' => 'Growth Hacking',      'url' => route('services') . '#growth-hacking'],
                        ['title' => 'Photo & Videography', 'url' => route('services') . '#photo-video'],
                      ];
            @endphp

            <div>
                @foreach($serviceList as $svc)
                <a href="{{ $svc['url'] ?? '#' }}"
                   class="services-row flex items-center justify-between py-5 no-underline">
                    <span class="services-title font-heading font-semibold text-[clamp(1.05rem,1.8vw,1.4rem)]">
                        {{ $svc['title'] }}
                    </span>
                    <svg class="services-arrow shrink-0 ml-5 w-5 h-5"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                @endforeach
            </div>

            <a href="{{ route('services') }}"
               class="inline-flex items-center gap-2 mt-8 text-sm font-medium text-white no-underline transition-colors hover:text-[rgb(var(--pub-panel-text))]">
                View all services
                <svg class="w-4 h-4 shrink-0"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>


{{-- ============================================================
     ABOUT PREVIEW
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Visual --}}
            <div class="relative">
                <div class="relative rounded-3xl overflow-hidden aspect-[4/5] bg-[rgb(var(--pub-muted)/0.30)]">
                    <img src="https://picsum.photos/seed/office-team/600/750"
                         alt="ASAK Agency Team"
                         class="absolute inset-0 w-full h-full object-cover">

                    {{-- Glass overlay card --}}
                    <div class="absolute bottom-6 left-6 right-6 p-6 rounded-2xl bg-[var(--white-glass)] backdrop-blur-[26x]">
                        <div class="flex items-center gap-4">
                            {{-- Stacked avatars --}}
                            <div class="flex">
                                @if($team->count())
                                    @foreach($team->take(4) as $member)
                                    <img src="{{ $member->image_url }}"
                                         alt="{{ $member->name }}"
                                         class="w-10 h-10 rounded-full object-cover border-2 border-[rgb(var(--pub-bg))]"
                                         style="{{ $loop->first ? '' : 'margin-left: -12px;' }}">
                                    @endforeach
                                @else
                                    @foreach(['a','b','c','d'] as $si => $seed)
                                    <img src="https://picsum.photos/seed/comrade-{{ $seed }}/40/40"
                                         alt="Team member"
                                         class="w-10 h-10 rounded-full object-cover border-2 border-[rgb(var(--pub-bg))]"
                                         style="{{ $si === 0 ? '' : 'margin-left: -12px;' }}">
                                    @endforeach
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-[rgb(var(--pub-fg))]">Meet the Comrades</p>
                                <p class="text-sm text-[rgb(var(--pub-muted-fg))]">Your dedicated digital partners</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Decorative blob --}}
                <div class="absolute w-32 h-32 rounded-3xl bg-[rgb(var(--pub-primary)/0.10)] -bottom-6 -right-6 -z-10"></div>
            </div>

            {{-- Content --}}
            <div>
                <p class="font-medium mb-3 text-primary">About Us</p>
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6 text-balance text-[rgb(var(--pub-fg))]">
                    {{ $about['about.philosophy'] ?? '"Asak" Means Mature. Ready.' }}
                </h2>
                <p class="text-lg leading-relaxed mb-8 text-[rgb(var(--pub-muted-fg))]">
                    {{ $about['about.story_text_2'] ?? "We believe that great ideas are worthless if they remain \"raw\" or poorly executed. At asak digital, we bridge the gap between abstract concepts and concrete reality. We don't just deliver projects; we deliver maturity—fully tested, fully optimized, and ready for market impact." }}
                </p>

                {{-- Highlights --}}
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
                        <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 bg-[rgb(var(--pub-bg)/0.60)] backdrop-blur-[24px] border border-[rgb(var(--pub-border)/0.50)]">
                            {{-- CheckCircle icon --}}
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-[rgb(var(--pub-fg))]">{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>

                {{-- CTA --}}
                <a href="{{ route('about') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all hover:opacity-90 bg-primary text-[rgb(var(--pub-primary-fg))]">
                    Learn More About Us
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</section>


 
@if($portfolios->count())
<section class="py-20 lg:py-32 bg-[rgb(var(--pub-muted)/0.30)]">
    <div class="container mx-auto px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16">
            <div>
                <p class="font-medium mb-3 text-primary">Our Work</p>
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold text-balance text-[rgb(var(--pub-fg))]">Selected Projects</h2>
            </div>
            <a href="{{ route('portfolio') }}"
               class="inline-flex items-center gap-2 font-medium transition-all text-primary hover:gap-3">
                View All Projects
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        {{-- Grid portfolio --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($portfolios as $project)
            <a href="{{ route('portfolio') }}#{{ $project->slug }}"
               class="group block relative rounded-3xl overflow-hidden bg-[rgb(var(--pub-bg)/0.60)] backdrop-blur-[24px] border border-[rgb(var(--pub-border)/0.50)] no-underline transition-all duration-300">

                {{-- Image --}}
                <div class="relative overflow-hidden aspect-[4/3] bg-[rgb(var(--pub-muted)/0.30)]">
                    <img src="{{ $project->image_url }}"
                         alt="{{ $project->title }}"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                    {{-- Hover overlay --}}
                    <div class="portfolio-overlay absolute inset-0 flex items-center justify-center transition-opacity duration-300 opacity-0 group-hover:opacity-100 bg-[rgb(var(--pub-fg)/0.80)]">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center bg-primary">
                            {{-- ArrowUpRight --}}
                            <svg class="w-6 h-6 text-[rgb(var(--pub-primary-fg))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6">
                    <p class="text-sm font-medium mb-2 text-primary">
                        {{ $project->category }}
                    </p>
                    <h3 class="font-heading text-xl font-semibold mb-2 text-[rgb(var(--pub-fg))]">
                        {{ $project->title }}
                    </h3>
                    <p class="text-sm text-[rgb(var(--pub-muted-fg))]">
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
     CLIENT LOGOS
     ============================================================ --}}
<section class="py-12 border-y border-[rgba(var(--pub-border),0.50)] bg-[rgba(var(--pub-muted),0.1)] overflow-hidden">
    <div class="container mx-auto px-6 lg:px-8">
        <p class="text-center text-sm font-medium text-[rgb(var(--pub-muted-fg))] mb-8 uppercase tracking-wider">Trusted by Industry Leaders</p>
        <div class="owl-carousel client-carousel flex items-center">
            @foreach($clients as $client)
            <div class="flex items-center justify-center p-4 opacity-50 hover:opacity-100 transition-opacity grayscale hover:grayscale-0">
                <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="max-h-12 w-auto object-contain">
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     CTA SECTION
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">

        {{-- Card wrapper --}}
        <div class="cta-card rounded-3xl">

            {{-- Background decoration --}}
            <div class="cta-gradient">
                {{-- Top-right blob --}}
                <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl bg-[rgb(var(--pub-accent)/0.30)]"></div>
                {{-- Bottom-left blob --}}
                <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl bg-[rgb(var(--pub-accent)/0.15)]"></div>
            </div>

            {{-- Content --}}
            <div class="relative py-16 lg:py-24 px-8 lg:px-16 text-center z-10">
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6 max-w-3xl mx-auto text-balance text-accent">
                    Let's Build Something Mature.
                </h2>
                <p class="text-lg max-w-2xl mx-auto mb-10 text-white">
                    Most agencies sell dreams but deliver nightmares. You deserve a partner who treats your business with military precision. Ready to experience the difference?
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    {{-- Primary --}}
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all hover:opacity-90 bg-[rgb(var(--pub-bg))] text-primary">
                        Start a Conversation
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    {{-- Outline --}}
                    <a href="{{ route('portfolio') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all bg-transparent border border-white/30 text-white hover:bg-white/10">
                        Explore Our Work
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $(".client-carousel").owlCarousel({
            loop: true,
            margin: 40,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            responsive:{
                0:{ items:2 },
                576:{ items:3 },
                768:{ items:4 },
                1024:{ items:5 }
            }
        });
    });
</script>
@endpush
