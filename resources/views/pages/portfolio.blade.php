@extends('layouts.public')
@section('title', 'Portfolio')

@section('content')

<section class="pt-32 pb-16 lg:pt-40 lg:pb-20">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <p class="text-primary font-medium mb-4">Our Portfolio</p>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-balance"
                style="color: rgb(var(--color-foreground))">Showcasing Our Creative Excellence</h1>
            <p class="text-xl leading-relaxed" style="color: rgb(var(--color-muted-foreground))">
                Explore our collection of projects that demonstrate our commitment to quality, creativity, and client success.
            </p>
        </div>
    </div>
</section>

{{-- Filter --}}
<section class="py-8">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('portfolio') }}"
               class="px-6 py-3 rounded-full text-sm font-medium transition-all {{ !$category ? '' : 'bg-background/60 backdrop-blur-xl border border-border/50 hover:bg-background/80' }}"
               style="{{ !$category ? 'background: rgb(var(--color-primary)); color: rgb(var(--color-primary-foreground))' : 'color: rgb(var(--color-muted-foreground))' }}">
                All
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('portfolio', ['category' => $cat]) }}"
               class="px-6 py-3 rounded-full text-sm font-medium transition-all {{ $category === $cat ? '' : 'bg-background/60 backdrop-blur-xl border border-border/50 hover:bg-background/80' }}"
               style="{{ $category === $cat ? 'background: rgb(var(--color-primary)); color: rgb(var(--color-primary-foreground))' : 'color: rgb(var(--color-muted-foreground))' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Projects Grid --}}
<section class="py-12 lg:py-20">
    <div class="container mx-auto px-6 lg:px-8">
        @if($portfolios->count())
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8">
            @foreach($portfolios as $i => $project)
            <div class="group relative rounded-3xl overflow-hidden bg-background/60 backdrop-blur-xl border border-border/50 hover:shadow-xl hover:bg-background/80 transition-all duration-300 {{ $i === 0 ? 'md:col-span-2' : '' }}">
                <div class="relative overflow-hidden {{ $i === 0 ? 'aspect-[2/1]' : 'aspect-[4/3]' }}">
                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}"
                         class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                         style="background: rgba(var(--color-foreground), 0.8);">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background: rgb(var(--color-primary));">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 style="color: rgb(var(--color-primary-foreground))">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6 lg:p-8">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium" style="background: rgba(var(--color-primary), 0.1); color: rgb(var(--color-primary))">
                            {{ $project->category }}
                        </span>
                        <span class="text-xs" style="color: rgb(var(--color-muted-foreground))">{{ $project->year }}</span>
                    </div>
                    <h3 class="font-heading text-xl lg:text-2xl font-semibold mb-3"
                        style="color: rgb(var(--color-foreground))">{{ $project->title }}</h3>
                    <p class="text-sm leading-relaxed mb-4" style="color: rgb(var(--color-muted-foreground))">{{ $project->description }}</p>
                    <p class="text-sm font-medium" style="color: rgb(var(--color-foreground))">
                        Client: <span style="color: rgb(var(--color-muted-foreground)); font-weight: normal">{{ $project->client }}</span>
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <p class="text-xl" style="color: rgb(var(--color-muted-foreground))">Belum ada portfolio untuk kategori ini.</p>
            <a href="{{ route('portfolio') }}" class="inline-block mt-4 text-primary hover:underline">Lihat semua portfolio</a>
        </div>
        @endif
    </div>
</section>

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
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all"
                       style="background: transparent;
                              border: 1px solid rgba(var(--color-background), 0.30);
                              color: rgb(var(--color-background));"
                       onmouseenter="this.style.background='rgba(var(--color-background), 0.10)'"
                       onmouseleave="this.style.background='transparent'">
                        Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
