@extends('layouts.public')
@section('title', 'Design Subscription')
@section('meta_description', 'Flat-rate design subscription for UMKM, startups, and growing brands. Dedicated designer, 48-hour turnaround, unlimited revisions. From Rp 750K/month — pause anytime.')

@section('content')

{{-- ============================================================
     HERO
     ============================================================ --}}
<section class="pt-32 pb-16 lg:pt-40 lg:pb-20 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-[rgb(var(--pub-primary)/0.1)] rounded-full blur-3xl -z-10"></div>
    <div class="container mx-auto px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl">
            <p class="text-primary font-medium mb-4 tracking-wide uppercase text-sm">Design Subscription</p>
            <h1 class="font-heading text-4xl md:text-6xl lg:text-7xl font-bold mb-6 text-balance text-[rgb(var(--pub-fg))] leading-tight">
                Your Brand.<br/>
                <span class="text-[rgb(var(--pub-muted-fg))]">Designed. Every Week.</span>
            </h1>
            <p class="text-xl leading-relaxed mb-10 text-[rgb(var(--pub-fg))] max-w-2xl font-medium">
                A dedicated designer. Flat monthly rate. No contracts, no hiring, no waiting.
                <span class="text-[rgb(var(--pub-muted-fg))]">Just great design — delivered.</span>
            </p>

            <div class="flex flex-wrap items-center gap-4 mb-6">
                <a href="#pricing" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full text-sm font-semibold transition-all hover:opacity-90 bg-[rgb(var(--pub-primary))] text-[rgb(var(--pub-primary-fg))]">
                    See Plans
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ route('portfolio') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full text-sm font-semibold transition-all bg-[rgba(var(--pub-muted),0.5)] border border-[rgba(var(--pub-border),0.5)] text-[rgb(var(--pub-fg))] hover:bg-[rgba(var(--pub-muted),0.8)]">
                    View Sample Work
                </a>
            </div>
            
            <p class="text-sm text-[rgb(var(--pub-muted-fg))] flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Trusted by brands in Indonesia, US, and EU. Pause anytime.
            </p>
        </div>
    </div>
</section>

{{-- ============================================================
     PROBLEM / AGITATION
     ============================================================ --}}
<section class="py-20 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-primary font-medium mb-3 text-sm tracking-wide uppercase">The Real Cost of "Figuring It Out"</p>
                <h2 class="font-heading text-3xl md:text-5xl font-bold mb-6 text-[rgb(var(--pub-fg))]">You've been doing it the hard way.</h2>
            </div>
            <div class="text-lg leading-relaxed text-[rgb(var(--pub-muted-fg))] space-y-4 font-medium">
                <p>Chasing freelancers who ghost. Briefs that get lost in WhatsApp threads. In-house designers who cost Rp 5M/month before you add tools, BPJS, and downtime.</p>
                <p>Meanwhile, your feed looks inconsistent. Your brand looks smaller than it is. And you're spending hours on design instead of running your business.</p>
                <p class="text-[rgb(var(--pub-fg))] font-semibold">There's a better way.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SOLUTION / PILLARS
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 lg:mb-24">
            <p class="text-primary font-medium mb-3 text-sm tracking-wide uppercase">What We Do</p>
            <h2 class="font-heading text-3xl md:text-5xl font-bold mb-6 text-[rgb(var(--pub-fg))]">Design as a Subscription.</h2>
            <p class="text-xl text-[rgb(var(--pub-muted-fg))]">One flat monthly rate. One dedicated designer who actually knows your brand. Submit a request, get it done in 48 hours. Revise until it's right. No surprises.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Pillar 1 --}}
            <div class="p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.6)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.5)] hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-[rgba(var(--pub-primary),0.05)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                <div class="w-12 h-12 rounded-2xl bg-[rgba(var(--pub-primary),0.1)] flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-heading text-xl font-bold mb-3 text-[rgb(var(--pub-fg))]">Dedicated Designer</h3>
                <p class="text-[rgb(var(--pub-muted-fg))] leading-relaxed text-sm">Not a pool. Not a bot. One designer assigned to your brand — who learns your style, tone, and standards over time. Briefs get shorter. Output gets better.</p>
            </div>
            {{-- Pillar 2 --}}
            <div class="p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.6)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.5)] hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-[rgba(var(--pub-primary),0.05)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                <div class="w-12 h-12 rounded-2xl bg-[rgba(var(--pub-primary),0.1)] flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-heading text-xl font-bold mb-3 text-[rgb(var(--pub-fg))]">Flat Rate. Transparent.</h3>
                <p class="text-[rgb(var(--pub-muted-fg))] leading-relaxed text-sm">Know exactly what you're paying. No hidden fees, no per-revision charges, no "outside scope" talks. One price covers everything in your plan.</p>
            </div>
            {{-- Pillar 3 --}}
            <div class="p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.6)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.5)] hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-[rgba(var(--pub-primary),0.05)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                <div class="w-12 h-12 rounded-2xl bg-[rgba(var(--pub-primary),0.1)] flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-heading text-xl font-bold mb-3 text-[rgb(var(--pub-fg))]">Pause Anytime</h3>
                <p class="text-[rgb(var(--pub-muted-fg))] leading-relaxed text-sm">Off-season? Big internal project? Just pause your subscription. Your unused days are saved and ready when you come back. No penalties.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     HOW IT WORKS
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 lg:mb-20">
            <p class="text-primary font-medium mb-3 text-sm tracking-wide uppercase">Our Process</p>
            <h2 class="font-heading text-3xl md:text-5xl font-bold text-[rgb(var(--pub-fg))]">From Brief to Delivered.<br>In 48 Hours.</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 relative">
            @php
            $steps = [
                ['title' => 'Subscribe & Onboard', 'desc' => 'Pick a plan. Tell us your brand vibe. We set up your Notion board and Drive folder.'],
                ['title' => 'Submit Request', 'desc' => 'Drop a brief via Notion. Attach references. No email chains.'],
                ['title' => 'We Design', 'desc' => 'Dedicated designer gets to work. Delivered within 48 hours.'],
                ['title' => 'Review & Approve', 'desc' => 'Review in Drive. Leave feedback. We revise until it\'s perfect.'],
            ];
            @endphp

            @foreach($steps as $index => $step)
            <div class="relative p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.60)] backdrop-blur-xl border border-[rgba(var(--pub-border),0.50)] hover:shadow-lg hover:-translate-y-1 transition-all">
                @if($index < count($steps) - 1)
                <div class="hidden lg:block absolute top-1/2 -right-3 w-6 h-0.5 bg-[rgba(var(--pub-border),0.5)]"></div>
                @endif
                <span class="font-heading text-5xl font-bold mb-4 block text-[rgba(var(--pub-primary),0.18)]">0{{ $index + 1 }}</span>
                <h3 class="font-heading text-xl font-semibold mb-3 text-[rgb(var(--pub-fg))]">{{ $step['title'] }}</h3>
                <p class="text-sm leading-relaxed text-[rgb(var(--pub-muted-fg))]">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     PRICING
     ============================================================ --}}
<section id="pricing" class="py-20 lg:py-32 bg-[rgba(var(--pub-muted),0.3)] scroll-mt-20 relative overflow-hidden" x-data="{ currency: 'IDR' }">
    <div class="absolute top-1/4 left-1/4 w-[30rem] h-[30rem] bg-[rgb(var(--pub-primary)/0.12)] rounded-full blur-[120px] pointer-events-none -z-0"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[25rem] h-[25rem] bg-[rgb(var(--pub-accent)/0.08)] rounded-full blur-[100px] pointer-events-none -z-0"></div>
    <div class="container mx-auto px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary font-medium mb-3 text-sm tracking-wide uppercase">Simple Pricing</p>
            <h2 class="font-heading text-3xl md:text-5xl font-bold mb-6 text-[rgb(var(--pub-fg))]">Less than a junior designer.<br>Better than a freelancer.</h2>
            <p class="text-[rgb(var(--pub-muted-fg))] mb-8">No onboarding fees. No long-term contracts. Cancel or pause anytime.</p>
            
            {{-- Currency Toggle --}}
            <div class="inline-flex items-center p-1 rounded-full bg-[rgba(var(--pub-bg),0.8)] border border-[rgba(var(--pub-border),0.5)] shadow-sm">
                <button @click="currency = 'IDR'" :class="currency === 'IDR' ? 'bg-primary text-white shadow-md' : 'text-[rgb(var(--pub-fg))] hover:bg-[rgba(var(--pub-muted),0.5)]'" class="px-6 py-2 rounded-full text-sm font-semibold transition-all">
                    IDR (Lokal)
                </button>
                <button @click="currency = 'USD'" :class="currency === 'USD' ? 'bg-primary text-white shadow-md' : 'text-[rgb(var(--pub-fg))] hover:bg-[rgba(var(--pub-muted),0.5)]'" class="px-6 py-2 rounded-full text-sm font-semibold transition-all">
                    USD (Global)
                </button>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            
            {{-- Starter Tier --}}
            <div class="p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.6)] backdrop-blur-2xl border border-[rgba(var(--pub-border),0.5)] flex flex-col transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-[rgba(var(--pub-primary),0.03)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                <h3 class="font-heading text-2xl font-bold mb-2 text-[rgb(var(--pub-fg))]">Starter</h3>
                <div class="mb-4">
                    <span class="text-4xl font-bold text-[rgb(var(--pub-fg))]" x-text="currency === 'IDR' ? 'Rp 750k' : '$149'"></span>
                    <span class="text-[rgb(var(--pub-muted-fg))]">/mo</span>
                </div>
                <p class="text-sm text-[rgb(var(--pub-muted-fg))] mb-8">For brands that need consistent visual output without the overhead.</p>
                
                <ul class="space-y-4 mb-8 flex-1">
                    @php
                    $starterFeatures = [
                        '15 designs per month',
                        '1 active request at a time',
                        '48-hour avg. turnaround',
                        'Unlimited revisions',
                        '1 active brand',
                        'Figma-native delivery',
                    ];
                    @endphp
                    @foreach($starterFeatures as $feature)
                    <li class="flex items-start gap-3 text-sm text-[rgb(var(--pub-fg))]">
                        <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('contact') }}?plan=starter" class="block w-full py-3 px-6 text-center rounded-full text-sm font-semibold border border-[rgba(var(--pub-border),0.8)] text-[rgb(var(--pub-fg))] hover:bg-[rgba(var(--pub-muted),0.5)] transition-colors">
                    Get Started
                </a>
            </div>

            {{-- Pro Tier --}}
            <div class="p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.75)] backdrop-blur-3xl border-2 border-primary flex flex-col relative shadow-[0_8px_32px_rgba(var(--pub-primary),0.2)] scale-105 z-10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-[rgba(var(--pub-primary),0.05)] to-transparent pointer-events-none"></div>
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary text-white px-4 py-1 rounded-full text-xs font-bold tracking-widest uppercase">Most Popular</div>
                <h3 class="font-heading text-2xl font-bold mb-2 text-[rgb(var(--pub-fg))]">Pro</h3>
                <div class="mb-4">
                    <span class="text-4xl font-bold text-primary" x-text="currency === 'IDR' ? 'Rp 1.49m' : '$299'"></span>
                    <span class="text-[rgb(var(--pub-muted-fg))]">/mo</span>
                </div>
                <p class="text-sm text-[rgb(var(--pub-muted-fg))] mb-8">For growing brands that need more volume and faster output.</p>
                
                <ul class="space-y-4 mb-8 flex-1">
                    @php
                    $proFeatures = [
                        '20 designs per month',
                        '36-hour avg. turnaround',
                        'Unlimited revisions',
                        '2 active brands',
                        'Source files included',
                        'Priority queue',
                        'Monthly PM check-in',
                    ];
                    @endphp
                    @foreach($proFeatures as $feature)
                    <li class="flex items-start gap-3 text-sm text-[rgb(var(--pub-fg))] font-medium">
                        <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('contact') }}?plan=pro" class="block w-full py-3 px-6 text-center rounded-full text-sm font-semibold bg-primary text-white hover:opacity-90 transition-opacity shadow-lg shadow-primary/20">
                    Get Started
                </a>
            </div>

            {{-- Scale Tier --}}
            <div class="p-8 rounded-3xl bg-[rgba(var(--pub-bg),0.6)] backdrop-blur-2xl border border-[rgba(var(--pub-border),0.5)] flex flex-col transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-[rgba(var(--pub-primary),0.03)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                <h3 class="font-heading text-2xl font-bold mb-2 text-[rgb(var(--pub-fg))]">Scale</h3>
                <div class="mb-4">
                    <span class="text-4xl font-bold text-[rgb(var(--pub-fg))]" x-text="currency === 'IDR' ? 'Rp 2.49m' : '$549'"></span>
                    <span class="text-[rgb(var(--pub-muted-fg))]">/mo</span>
                </div>
                <p class="text-sm text-[rgb(var(--pub-muted-fg))] mb-8">For agencies, high-growth brands, and teams with ongoing design demand.</p>
                
                <ul class="space-y-4 mb-8 flex-1">
                    @php
                    $scaleFeatures = [
                        'Unlimited designs (queued)',
                        '24-hour avg. turnaround',
                        '2 active requests simultaneously',
                        'Unlimited brands',
                        'Source files + Brand guidelines',
                        'Top priority queue',
                        'Dedicated PM + weekly sync',
                    ];
                    @endphp
                    @foreach($scaleFeatures as $feature)
                    <li class="flex items-start gap-3 text-sm text-[rgb(var(--pub-fg))]">
                        <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('contact') }}?plan=scale" class="block w-full py-3 px-6 text-center rounded-full text-sm font-semibold border border-[rgba(var(--pub-border),0.8)] text-[rgb(var(--pub-fg))] hover:bg-[rgba(var(--pub-muted),0.5)] transition-colors">
                    Get Started
                </a>
            </div>
        </div>

        <p class="text-center text-sm text-[rgb(var(--pub-muted-fg))] mt-12 max-w-2xl mx-auto">All prices in IDR/USD. Billed monthly. Pause anytime — unused days roll over. Payment via Stripe, PayPal, Wise, or Bank Transfer.</p>
    </div>
</section>

{{-- ============================================================
     SCOPE & COMPARISON
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16">
            {{-- Scope --}}
            <div>
                <p class="text-primary font-medium mb-3 text-sm tracking-wide uppercase">What We Design</p>
                <h2 class="font-heading text-3xl font-bold mb-6 text-[rgb(var(--pub-fg))]">Almost everything.<br><span class="text-[rgb(var(--pub-muted-fg))] text-2xl font-normal">(And we'll tell you upfront when it's not.)</span></h2>
                
                <div class="mb-8">
                    <h4 class="font-semibold text-lg text-[rgb(var(--pub-fg))] mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Included
                    </h4>
                    <p class="text-[rgb(var(--pub-muted-fg))] leading-relaxed">Social media posts & stories · Banners & display ads · Thumbnails · Flyers & posters · Email headers · Slide decks · Packaging mockups · UI screens · Print design · Brand assets · Infographics · And more.</p>
                </div>
                
                <div>
                    <h4 class="font-semibold text-lg text-[rgb(var(--pub-fg))] mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Not Included
                    </h4>
                    <p class="text-[rgb(var(--pub-muted-fg))] leading-relaxed">Logo & brand identity, mascot & custom illustration, motion graphics, and video editing are available as add-ons — priced separately, with full transparency before we start.</p>
                </div>
            </div>

            {{-- Comparison Table --}}
            <div>
                <p class="text-primary font-medium mb-3 text-sm tracking-wide uppercase">How We Compare</p>
                <h2 class="font-heading text-3xl font-bold mb-8 text-[rgb(var(--pub-fg))]">Not the cheapest option.<br>The smartest one.</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[rgba(var(--pub-border),0.8)]">
                                <th class="py-4 px-2 font-medium text-[rgb(var(--pub-muted-fg))] w-1/3">Feature</th>
                                <th class="py-4 px-2 font-medium text-[rgb(var(--pub-muted-fg))]">Freelancer</th>
                                <th class="py-4 px-2 font-medium text-[rgb(var(--pub-muted-fg))]">In-House</th>
                                <th class="py-4 px-2 font-bold text-primary">ASAK Sub</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr class="border-b border-[rgba(var(--pub-border),0.4)]">
                                <td class="py-4 px-2 text-[rgb(var(--pub-fg))]">Consistent output</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">✗</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">✓</td>
                                <td class="py-4 px-2 text-primary font-bold">✓</td>
                            </tr>
                            <tr class="border-b border-[rgba(var(--pub-border),0.4)]">
                                <td class="py-4 px-2 text-[rgb(var(--pub-fg))]">Dedicated designer</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">✗</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">✓</td>
                                <td class="py-4 px-2 text-primary font-bold">✓</td>
                            </tr>
                            <tr class="border-b border-[rgba(var(--pub-border),0.4)]">
                                <td class="py-4 px-2 text-[rgb(var(--pub-fg))]">Pause anytime</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">✗</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">✗</td>
                                <td class="py-4 px-2 text-primary font-bold">✓</td>
                            </tr>
                            <tr class="border-b border-[rgba(var(--pub-border),0.4)]">
                                <td class="py-4 px-2 text-[rgb(var(--pub-fg))]">Fast turnaround</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">Varies</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">✓</td>
                                <td class="py-4 px-2 text-primary font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-[rgb(var(--pub-fg))] font-medium">Monthly cost</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">Varies</td>
                                <td class="py-4 px-2 text-[rgb(var(--pub-muted-fg))]">High</td>
                                <td class="py-4 px-2 text-primary font-bold">Predictable</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FAQ
     ============================================================ --}}
<section class="py-20 lg:py-32 bg-[rgba(var(--pub-muted),0.3)]">
    <div class="container mx-auto px-6 lg:px-8 max-w-4xl">
        <div class="text-center mb-16">
            <p class="text-primary font-medium mb-3 text-sm tracking-wide uppercase">Questions</p>
            <h2 class="font-heading text-3xl md:text-5xl font-bold text-[rgb(var(--pub-fg))]">Straight answers.</h2>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @php
            $faqs = [
                ['q' => 'What exactly counts as "one design"?', 'a' => 'One design = one asset, one concept, one primary size. A feed post and a story version of the same post = two designs. We\'ll always tell you upfront if a request spans multiple slots.'],
                ['q' => 'How does pausing work?', 'a' => 'Your subscription runs on a 31-day billing cycle. If you pause on day 18, the remaining 13 days are saved. When you resume, those 13 days pick up exactly where you left off. Unused days from your design quota don\'t carry over — only billing days do.'],
                ['q' => 'What if I\'m not happy with the output?', 'a' => 'Revise until you are. Unlimited revisions are included in every plan — no caps, no extra charges. We iterate until the output is right.'],
                ['q' => 'Who will be designing my work?', 'a' => 'A dedicated designer is assigned to your account — not a rotating pool. They stay with you, learn your brand, and get better at your briefs over time.'],
                ['q' => 'Do you work with international clients?', 'a' => 'Yes. Global plans are priced in USD, communicate in English, and deliver via Figma + Notion. Payment via Stripe, PayPal, or Wise.'],
            ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="border border-[rgba(var(--pub-border),0.5)] rounded-2xl bg-[rgba(var(--pub-bg),0.5)] backdrop-blur-lg overflow-hidden transition-all hover:bg-[rgba(var(--pub-bg),0.7)]">
                <button @click="active === {{ $index }} ? active = null : active = {{ $index }}" class="w-full px-6 py-5 text-left flex justify-between items-center font-semibold text-[rgb(var(--pub-fg))] hover:bg-[rgba(var(--pub-muted),0.3)] transition-colors">
                    {{ $faq['q'] }}
                    <svg class="w-5 h-5 text-primary transform transition-transform duration-200" :class="active === {{ $index }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === {{ $index }}" x-collapse class="px-6 pb-6 text-[rgb(var(--pub-muted-fg))] leading-relaxed text-sm">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     CTA
     ============================================================ --}}
<section class="py-20 lg:py-32">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="cta-card rounded-3xl">
            <div class="cta-gradient">
                <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl bg-[rgb(var(--pub-accent)/0.30)]"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl bg-[rgb(var(--pub-accent)/0.15)]"></div>
            </div>
            
            <div class="relative py-16 lg:py-24 px-8 lg:px-16 text-center z-10">
                <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6 max-w-3xl mx-auto text-balance text-accent">
                    Ready to stop figuring out design?
                </h2>
                <p class="text-lg max-w-2xl mx-auto mb-10 text-white">
                    Start today. Your first design can be in the queue within 24 hours.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#pricing" class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all hover:opacity-90 bg-[rgb(var(--pub-bg))] text-primary">
                        See Plans
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-full text-sm font-medium transition-all bg-transparent border border-white/30 text-white hover:bg-white/10">
                        Talk to Us First
                    </a>
                </div>
                <p class="text-xs text-white/60 mt-6">No setup fees. No long-term commitment. Pause anytime.</p>
            </div>
        </div>
    </div>
</section>

@endsection
