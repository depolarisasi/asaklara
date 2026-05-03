@extends('layouts.public')
@section('title', 'Services')

@section('content')

{{-- ============================================================
     HERO
     ============================================================ --}}
<section class="pt-32 pb-16 lg:pt-40 lg:pb-20">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <p class="text-primary font-medium mb-4">Our Capabilities Stack</p>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-balance text-[rgb(var(--pub-fg))]">We Build Systems That Scale</h1>
            <p class="text-xl leading-relaxed mb-10 text-[rgb(var(--pub-muted-fg))]">
                From brand engineering to growth hacking, we deliver maturity—fully tested, fully optimized, and ready for market impact.
            </p>

            {{-- Service Nav Tabs --}}
            @if($services->count())
            <div class="flex flex-wrap gap-3">
                @foreach($services as $service)
                @php
                    $isBrandEngineering = strtolower($service->title) === 'brand engineering';
                    $linkUrl = $isBrandEngineering ? route('design') : '#' . $service->slug;
                @endphp
                <a href="{{ $linkUrl }}"
                   class="px-5 py-2.5 rounded-full text-sm font-medium transition-all border bg-[rgba(var(--pub-primary),0.08)] border-[rgba(var(--pub-primary),0.20)] text-primary hover:bg-[rgba(var(--pub-primary),0.18)]">
                    {{ $service->title }}
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ============================================================
     STATS BAR
     ============================================================ --}}
<section class="py-10 lg:py-14 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            @foreach([
                ['value' => '150+', 'label' => 'Projects Delivered',    'sub' => 'Across 4 service lines'],
                ['value' => '50+',  'label' => 'Happy Clients',         'sub' => 'From startups to enterprises'],
                ['value' => '5+',   'label' => 'Years of Excellence',   'sub' => 'International track record'],
                ['value' => '100%', 'label' => 'On-Time Delivery',      'sub' => 'Zero-Delay Protocol'],
            ] as $stat)
            <div class="text-center lg:text-left">
                <p class="font-heading text-3xl lg:text-4xl font-bold text-primary mb-1">{{ $stat['value'] }}</p>
                <p class="font-semibold text-sm mb-0.5 text-[rgb(var(--pub-fg))]">{{ $stat['label'] }}</p>
                <p class="text-xs text-[rgb(var(--pub-muted-fg))]">{{ $stat['sub'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     SERVICES LIST — alternating layout
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="space-y-24 lg:space-y-3            @foreach($services as $i => $service)
            <div id="{{ $service->slug }}" class="scroll-mt-28">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

                    {{-- Image col --}}
                    <div class="relative {{ $i % 2 === 1 ? 'lg:order-2' : '' }}">
                        <div class="aspect-square rounded-3xl overflow-hidden shadow-xl">
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}"
                                 class="w-full h-full object-cover" loading="lazy">
                        </div>
                        {{-- Floating service number badge --}}
                        <div class="absolute -top-4 -left-4 w-14 h-14 rounded-2xl flex items-center justify-center font-heading font-bold text-lg shadow-lg bg-primary text-[rgb(var(--pub-primary-fg))]">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 rounded-3xl -z-10 bg-[rgba(var(--pub-primary),0.1)]"></div>
                    </div>

                    {{-- Content col --}}
                    <div class="{{ $i % 2 === 1 ? 'lg:order-1' : '' }}">
                        <p class="text-primary font-medium text-sm mb-3 uppercase tracking-wider">Service {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                        <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4 text-[rgb(var(--pub-fg))]">{{ $service->title }}</h2>
                        <p class="text-lg leading-relaxed mb-8 text-[rgb(var(--pub-muted-fg))]">{{ $service->description }}</p>

                        {{-- Features grid --}}
                        @if($service->features->count())
                        <div class="grid sm:grid-cols-2 gap-3 mb-8">
                            @foreach($service->features as $feature)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-[rgba(var(--pub-muted),0.4)] border border-[rgba(var(--pub-border),0.4)]">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-[rgba(var(--pub-primary),0.15)]">
                                    <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-[rgb(var(--pub-fg))]">{{ $feature->feature }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="flex items-center gap-4">
                            @php
                                $isBrandEngineering = strtolower($service->title) === 'brand engineering';
                                $getStartedLink = $isBrandEngineering ? route('design') : route('contact');
                            @endphp
                            <a href="{{ $getStartedLink }}"
                               class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-sm transition-opacity hover:opacity-90 bg-primary text-[rgb(var(--pub-primary-fg))]">
                                {{ $isBrandEngineering ? 'See Plans' : 'Get Started' }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('portfolio') }}"
                               class="text-sm font-medium transition-colors text-[rgb(var(--pub-muted-fg))] hover:text-primary">
                                See our work →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach 
        </div>
    </div>
</section>

{{-- ============================================================
     WHY CHOOSE US — 4 differentiators
     ============================================================ --}}
<section class="py-20 lg:py-28 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <p class="text-primary font-medium mb-3">Why ASAK</p>
            <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4 text-[rgb(var(--pub-fg))]">Not Just Another Agency</h2>
            <p class="text-[rgb(var(--pub-muted-fg))]">
                Every agency promises quality. We back it with a system, a process, and a Definition of Done that ensures you never get "almost there."
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                [
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'Radical Transparency',
                    'desc'  => 'Full visibility into every milestone, every deliverable, every cost. Zero surprises.',
                ],
                [
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'Zero-Delay Protocol',
                    'desc'  => 'Deadlines are contracts. Our structured delivery process ensures we hit every one.',
                ],
                [
                    'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064',
                    'title' => 'Global Standard',
                    'desc'  => 'Hundreds of international projects — we know what works at scale, across markets.',
                ],
                [
                    'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                    'title' => 'Definition of Done',
                    'desc'  => 'Delivered maturity — tested, optimized, documented, and ready for market impact.',
                ],
            ] as $item)
            <div class="service-card p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.60)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.50)] transition-all cursor-default">
                <div class="service-icon-wrap w-14 h-14 rounded-2xl bg-[rgba(var(--pub-bg),0.60)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.50)] flex items-center justify-center mb-6 transition-all">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-heading text-lg font-semibold mb-3 text-[rgb(var(--pub-fg))]">{{ $item['title'] }}</h3>
                <p class="text-sm leading-relaxed text-[rgb(var(--pub-muted-fg))]">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     PROCESS STEPS
     ============================================================ --}}
@if($processSteps->count())
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <p class="text-primary font-medium mb-3">Our Process</p>
            <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4 text-[rgb(var(--pub-fg))]">How We Work</h2>
            <p class="text-[rgb(var(--pub-muted-fg))]">
                A streamlined process engineered to eliminate chaos — from first brief to final delivery.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($processSteps as $i => $step)
            <div class="relative p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.60)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.50)] hover:shadow-lg hover:bg-[rgba(var(--pub-bg),0.80)] transition-all">
                @if($i < $processSteps->count() - 1)
                <div class="hidden lg:block absolute top-1/2 -right-3 w-6 h-0.5 bg-[rgb(var(--pub-border))]"></div>
                @endif
                <span class="font-heading text-5xl font-bold mb-4 block text-[rgba(var(--pub-primary),0.18)]">{{ $step->step_number }}</span>
                <h3 class="font-heading text-xl font-semibold mb-3 text-[rgb(var(--pub-fg))]">{{ $step->title }}</h3>
                <p class="text-sm leading-relaxed text-[rgb(var(--pub-muted-fg))]">{{ $step->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     CTA
     ============================================================ --}}
<section class="py-20 lg:py-32 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="cta-card rounded-3xl">

            <div class="cta-gradient">
                <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl bg-[rgb(var(--pub-accent)/0.30)]"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl bg-[rgb(var(--pub-accent)/0.15)]"></div>
            </div>

            <div class="relative py-16 lg:py-24 px-8 lg:px-16 text-center z-10">
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6 max-w-3xl mx-auto text-balance text-accent">
                    Ready to Build Something Mature?
                </h2>
                <p class="text-lg max-w-2xl mx-auto mb-10 text-white">
                    Most agencies sell dreams but deliver nightmares. You deserve a partner who treats your business with military precision. Ready to experience the difference?
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all hover:opacity-90 bg-[rgb(var(--pub-bg))] text-primary">
                        Start a Conversation
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
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
