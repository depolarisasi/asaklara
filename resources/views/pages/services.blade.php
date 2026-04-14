@extends('layouts.public')
@section('title', 'Services')

@section('content')

<section class="pt-32 pb-20 lg:pt-40 lg:pb-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <p class="text-primary font-medium mb-4">Our Capabilities Stack</p>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-balance"
                style="color: rgb(var(--color-foreground))">We Build Systems That Scale</h1>
            <p class="text-xl leading-relaxed" style="color: rgb(var(--color-muted-foreground))">
                From brand engineering to growth hacking, we deliver maturity—fully tested, fully optimized, and ready for market impact.
            </p>
        </div>
    </div>
</section>

{{-- Services List --}}
<section class="py-20 lg:py-32" style="background: rgba(var(--color-muted), 0.3)">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="space-y-16 lg:space-y-24">
            @foreach($services as $i => $service)
            <div id="{{ $service->slug }}" class="scroll-mt-32">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center {{ $i % 2 === 1 ? 'lg:[grid-template-areas:\'content_image\']' : '' }}">
                    <div class="relative {{ $i % 2 === 1 ? 'lg:order-2' : '' }}">
                        <div class="aspect-square rounded-3xl overflow-hidden shadow-lg">
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 rounded-3xl -z-10" style="background: rgba(var(--color-primary), 0.1)"></div>
                    </div>
                    <div class="{{ $i % 2 === 1 ? 'lg:order-1' : '' }}">
                        <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4"
                            style="color: rgb(var(--color-foreground))">{{ $service->title }}</h2>
                        <p class="text-lg leading-relaxed mb-8" style="color: rgb(var(--color-muted-foreground))">{{ $service->description }}</p>

                        @if($service->features->count())
                        <div class="grid sm:grid-cols-2 gap-4 mb-8">
                            @foreach($service->features as $feature)
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-background/60 backdrop-blur-xl border border-border/50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <span class="text-sm" style="color: rgb(var(--color-foreground))">{{ $feature->feature }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-sm transition-opacity hover:opacity-90"
                           style="background: rgb(var(--color-primary)); color: rgb(var(--color-primary-foreground));">
                            Get Started
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Process Steps --}}
@if($processSteps->count())
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <p class="text-primary font-medium mb-3">Our Process</p>
            <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4">How We Work</h2>
            <p style="color: rgb(var(--color-muted-foreground))">
                Our streamlined process ensures efficient delivery while maintaining the highest quality standards.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($processSteps as $i => $step)
            <div class="relative p-8 rounded-3xl bg-background/60 backdrop-blur-xl border border-border/50 hover:shadow-lg hover:bg-background/80 transition-all">
                @if($i < $processSteps->count() - 1)
                <div class="hidden lg:block absolute top-1/2 -right-3 w-6 h-0.5" style="background: rgb(var(--color-border))"></div>
                @endif
                <span class="font-heading text-5xl font-bold mb-4 block" style="color: rgba(var(--color-primary), 0.2)">{{ $step->step_number }}</span>
                <h3 class="font-heading text-xl font-semibold mb-3" style="color: rgb(var(--color-foreground))">{{ $step->title }}</h3>
                <p class="text-sm leading-relaxed" style="color: rgb(var(--color-muted-foreground))">{{ $step->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="relative rounded-3xl overflow-hidden"
             style="background: rgba(var(--color-foreground), 0.95);
                    backdrop-filter: blur(24px);
                    -webkit-backdrop-filter: blur(24px);">

            {{-- Background decoration — ring-colored glass gradient --}}
            <div class="absolute inset-0" style="pointer-events:none; overflow:hidden;">
                <div class="absolute inset-0"
                     style="background: radial-gradient(ellipse at 70% 50%, rgba(var(--color-ring), 0.50), transparent 70%)"></div>
                <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl"
                     style="background: rgba(var(--color-ring), 0.30)"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl"
                     style="background: rgba(var(--color-ring), 0.15)"></div>
            </div>

            {{-- Content --}}
            <div class="relative py-16 lg:py-24 px-8 lg:px-16 text-center" style="z-index:10">
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6 max-w-3xl mx-auto text-balance"
                    style="color: rgb(var(--color-background))">
                    Let's Build Something Mature.
                </h2>
                <p class="text-lg max-w-2xl mx-auto mb-10"
                   style="color: rgba(var(--color-background), 0.70)">
                    Most agencies sell dreams but deliver nightmares. You deserve a partner who treats your business with military precision. Ready to experience the difference?
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all hover:opacity-90"
                       style="background: rgb(var(--color-background)); color: rgb(var(--color-primary));">
                        Start a Conversation
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
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
