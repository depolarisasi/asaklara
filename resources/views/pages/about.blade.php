@extends('layouts.public')
@section('title', 'About Us')

@section('content')

{{-- Hero --}}
<section class="pt-32 pb-20 lg:pt-40 lg:pb-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <p class="text-primary font-medium mb-4">Meet asak digital</p>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-balance text-[rgb(var(--pub-fg))]">
                {{ $about['about.hero_title'] ?? 'The Anti-Chaos Agency' }}
            </h1>
            <p class="text-xl leading-relaxed text-[rgb(var(--pub-muted-fg))]">
                {{ $about['about.hero_subtitle'] ?? 'Born from the high-volume demands of the global gig economy and refined for corporate scalability, we bridge the gap between creative disruption and operational excellence.' }}
            </p>
        </div>
    </div>
</section>

{{-- Story Section --}}
<section class="py-20 lg:py-32 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="relative">
                <div class="aspect-[4/3] rounded-3xl overflow-hidden">
                    <img src="https://picsum.photos/seed/agency-story/800/600" alt="ASAK Agency Story" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-3xl -z-10 bg-[rgba(var(--pub-primary),0.1)]"></div>
            </div>
            <div>
                <p class="text-primary font-medium mb-3">Our Philosophy</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold mb-6 text-[rgb(var(--pub-fg))]">
                    {{ $about['about.philosophy'] ?? '"Asak" Means Mature. Ready.' }}
                </h2>
                <div class="space-y-4 leading-relaxed text-[rgb(var(--pub-muted-fg))]">
                    <p>{{ $about['about.story_text_1'] ?? 'It represents the final state of perfection after a rigorous process. In the digital world, "Asak" is our Definition of Done.' }}</p>
                    <p>{{ $about['about.story_text_2'] ?? 'We believe that great ideas are worthless if they remain "raw" or poorly executed. At asak digital, we bridge the gap between abstract concepts and concrete reality.' }}</p>
                    <p>{{ $about['about.story_text_3'] ?? "We don't just deliver projects; we deliver maturity—fully tested, fully optimized, and ready for market impact." }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <p class="text-primary font-medium mb-3">Why Us?</p>
            <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4 text-[rgb(var(--pub-fg))]">What Sets Us Apart</h2>
            <p class="text-[rgb(var(--pub-muted-fg))]">
                Most agencies sell dreams but deliver nightmares. Missed deadlines, ghosting, and "raw" results are the industry standard. You deserve better.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $coreValues = [
                ['icon' => 'target', 'title' => 'Radical Transparency', 'desc' => 'We got nothing to hide from you. We track every pixel and line of code. You get full visibility, zero surprises.'],
                ['icon' => 'award', 'title' => 'Zero-Delay Protocol', 'desc' => 'Our work process & methodology ensures we hit every milestone. We respect your timeline as much as your budget.'],
                ['icon' => 'users', 'title' => 'Global Standard', 'desc' => 'Experience from hundreds of international projects, brought to your doorstep.'],
                ['icon' => 'heart', 'title' => 'Definition of Done', 'desc' => 'We deliver maturity—fully tested, fully optimized, and ready for market impact.'],
            ];
            @endphp

            @foreach($coreValues as $val)
            <div class="p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.60)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.50)] text-center hover:shadow-lg hover:bg-[rgba(var(--pub-bg),0.80)] transition-all">
                <div class="w-14 h-14 rounded-2xl bg-[rgba(var(--pub-bg),0.60)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.50)] flex items-center justify-center mx-auto mb-6">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($val['icon'] === 'target')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        @elseif($val['icon'] === 'award')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        @elseif($val['icon'] === 'users')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        @endif
                    </svg>
                </div>
                <h3 class="font-heading text-xl font-semibold mb-3 text-[rgb(var(--pub-fg))]">{{ $val['title'] }}</h3>
                <p class="text-sm leading-relaxed text-[rgb(var(--pub-muted-fg))]">{{ $val['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team --}}
@if($team->count())
<section class="py-20 lg:py-32 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <p class="text-primary font-medium mb-3">Our Team</p>
            <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4 text-[rgb(var(--pub-fg))]">Meet the "Comrades"</h2>
            <p class="text-[rgb(var(--pub-muted-fg))]">
                Our diverse team brings together expertise from various disciplines to deliver exceptional results.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($team as $member)
            <div class="p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.60)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.50)] text-center hover:shadow-lg hover:bg-[rgba(var(--pub-bg),0.80)] transition-all">
                <img src="{{ $member->image_url }}" alt="{{ $member->name }}"
                     class="w-24 h-24 rounded-full object-cover mx-auto mb-6">
                <h3 class="font-heading text-lg font-semibold mb-1 text-[rgb(var(--pub-fg))]">{{ $member->name }}</h3>
                <p class="text-sm text-[rgb(var(--pub-muted-fg))]">{{ $member->role }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Stats --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['key' => 'stats.projects', 'default' => '150+', 'label' => 'Projects Completed'],
                ['key' => 'stats.clients', 'default' => '50+', 'label' => 'Happy Clients'],
                ['key' => 'stats.experience', 'default' => '5+', 'label' => 'Years Experience'],
                ['key' => 'stats.awards', 'default' => '15+', 'label' => 'Awards Won'],
            ] as $stat)
            <div class="text-center">
                <p class="font-heading text-4xl lg:text-5xl font-bold text-primary mb-2">
                    {{ $stats[$stat['key']] ?? $stat['default'] }}
                </p>
                <p class="text-[rgb(var(--pub-muted-fg))]">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Client Logos --}}
<section class="py-12 border-t border-[rgba(var(--pub-border),0.50)] bg-[rgba(var(--pub-muted),0.1)] overflow-hidden">
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
