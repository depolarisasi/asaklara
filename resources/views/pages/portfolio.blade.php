@extends('layouts.public')
@section('title', 'Portfolio')

@section('content')

{{-- ============================================================
     HERO
     ============================================================ --}}
<section class="pt-32 pb-12 lg:pt-40 lg:pb-16">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <p class="text-primary font-medium mb-4">Our Portfolio</p>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-balance text-[rgb(var(--pub-fg))]">Proof Over Promises</h1>
            <p class="text-xl leading-relaxed text-[rgb(var(--pub-muted-fg))]">
                Every project here is a result of radical transparency, zero-delay execution, and a relentless pursuit of "done right." No mockups — real work, real results.
            </p>
        </div>
    </div>
</section>

{{-- ============================================================
     STATS BAR
     ============================================================ --}}
<section class="py-10 lg:py-12 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $totalPortfolios = \App\Models\Portfolio::active()->count();
            $totalCategories = \App\Models\Portfolio::active()->distinct()->count('category');
            @endphp
            @foreach([
                ['value' => $totalPortfolios . '+',   'label' => 'Projects Completed'],
                ['value' => $totalCategories,          'label' => 'Service Categories'],
                ['value' => '50+',                     'label' => 'Happy Clients'],
                ['value' => '100%',                    'label' => 'Client Retention'],
            ] as $stat)
            <div class="text-center">
                <p class="font-heading text-3xl lg:text-4xl font-bold text-primary mb-1">{{ $stat['value'] }}</p>
                <p class="text-sm text-[rgb(var(--pub-muted-fg))]">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     CATEGORY FILTERS
     ============================================================ --}}
<section class="py-8">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('portfolio') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all {{ !$category
                   ? 'bg-primary text-[rgb(var(--pub-primary-fg))]'
                   : 'bg-[rgba(var(--pub-bg),0.6)] backdrop-blur-3xl border border-[rgba(var(--pub-border),0.5)] text-[rgb(var(--pub-muted-fg))] hover:bg-[rgba(var(--pub-bg),0.8)]' }}">
                All
                @if(!$category)
                <span class="ml-1 text-xs opacity-70">({{ $portfolios->count() }})</span>
                @endif
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('portfolio', ['category' => $cat]) }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all {{ $category === $cat
                   ? 'bg-primary text-[rgb(var(--pub-primary-fg))]'
                   : 'bg-[rgba(var(--pub-bg),0.6)] backdrop-blur-3xl border border-[rgba(var(--pub-border),0.5)] text-[rgb(var(--pub-muted-fg))] hover:bg-[rgba(var(--pub-bg),0.8)]' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     PROJECTS GRID
     ============================================================ --}}
<section class="py-8 pb-20 lg:pb-32">
    <div class="container mx-auto px-6 lg:px-8">
        @if($portfolios->count())
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8"            @foreach($portfolios as $i => $project)
            <div class="portfolio-card group relative rounded-3xl overflow-hidden bg-[rgba(var(--pub-bg),0.60)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.50)] hover:shadow-xl transition-all duration-300 {{ $i === 0 && !$category ? 'md:col-span-2' : '' }}">

                {{-- Image --}}
                <div class="relative overflow-hidden {{ $i === 0 && !$category ? 'aspect-[16/7]' : 'aspect-[4/3]' }}">
                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="{{ $i < 2 ? 'eager' : 'lazy' }}">

                    {{-- Hover overlay --}}
                    <div class="portfolio-overlay absolute inset-0 opacity-0 transition-opacity duration-300 flex items-center justify-center bg-[rgba(var(--pub-fg),0.75)] group-hover:opacity-100">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center shadow-xl bg-primary">
                            <svg class="w-7 h-7 text-[rgb(var(--pub-primary-fg))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Featured badge --}}
                    @if($project->featured)
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold shadow-lg bg-primary text-[rgb(var(--pub-primary-fg))]">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Featured
                        </span>
                    </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="{{ $i === 0 && !$category ? 'p-6 lg:p-8 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4' : 'p-6 lg:p-7' }}">
                    <div class="{{ $i === 0 && !$category ? 'flex-1' : '' }}">
                        {{-- Meta --}}
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[rgba(var(--pub-primary),0.10)] text-primary">
                                {{ $project->category }}
                            </span>
                            <span class="text-xs text-[rgb(var(--pub-muted-fg))]">{{ $project->year }}</span>
                            <span class="text-xs text-[rgba(var(--pub-border),0.8)]">·</span>
                            <span class="text-xs font-medium text-[rgb(var(--pub-muted-fg))]">{{ $project->client }}</span>
                        </div>

                        <h3 class="font-heading {{ $i === 0 && !$category ? 'text-2xl lg:text-3xl' : 'text-xl' }} font-semibold mb-2 text-[rgb(var(--pub-fg))]">{{ $project->title }}</h3>
                        <p class="text-sm leading-relaxed text-[rgb(var(--pub-muted-fg))]">{{ Str::limit($project->description, $i === 0 && !$category ? 180 : 110) }}</p>
                    </div>

                    {{-- CTA link on featured card --}}
                    @if($i === 0 && !$category)
                    <div class="flex-shrink-0 self-end">
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition-opacity hover:opacity-90 whitespace-nowrap bg-primary text-[rgb(var(--pub-primary-fg))]">
                            Work with us
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
ch
        </div>

        {{-- Empty state for filtered view --}}
        @else
        <div class="text-center py-24">
            <div class="w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6 bg-[rgba(var(--pub-muted),0.5)]">
                <svg class="w-9 h-9 text-[rgb(var(--pub-muted-fg))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-heading text-xl font-semibold mb-2 text-[rgb(var(--pub-fg))]">No projects in this category yet</h3>
            <p class="mb-6 text-[rgb(var(--pub-muted-fg))]">Check back soon or explore all our work.</p>
            <a href="{{ route('portfolio') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-sm font-semibold transition-opacity hover:opacity-90 bg-primary text-[rgb(var(--pub-primary-fg))]">
                View all projects
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ============================================================
     CTA
     ============================================================ --}}
<section class="py-20 lg:py-28 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="cta-card rounded-3xl">

            <div class="cta-gradient">
                <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl bg-[rgba(var(--pub-primary),0.30)]"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl bg-[rgba(var(--pub-primary),0.15)]"></div>
            </div>

            <div class="relative py-16 lg:py-24 px-8 lg:px-16 text-center z-10">
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6 max-w-3xl mx-auto text-balance text-[rgb(var(--pub-bg))]">
                    Ready to Be Our Next Success Story?
                </h2>
                <p class="text-lg max-w-2xl mx-auto mb-10 text-[rgba(var(--pub-bg),0.70)]">
                    Join 50+ clients who chose execution over excuses. Let's build something that belongs in this portfolio.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-full text-sm font-semibold transition-all hover:opacity-90 bg-[rgb(var(--pub-bg))] text-primary">
                        Start a Conversation
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('services') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-full text-sm font-medium transition-all bg-transparent border border-[rgba(var(--pub-bg),0.30)] text-[rgb(var(--pub-bg))] hover:bg-[rgba(var(--pub-bg),0.10)]">
                        See Our Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
