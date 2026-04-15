@extends('layouts.public')
@section('title', 'Contact')

@section('content')

<section class="pt-32 pb-16 lg:pt-40 lg:pb-20">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <p class="text-primary font-medium mb-4">Contact Us</p>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-balance"
                style="color: rgb(var(--color-foreground))">Let's Build Something Mature.</h1>
            <p class="text-xl leading-relaxed" style="color: rgb(var(--color-muted-foreground))">
                Ready to work with a partner who treats your business with military precision? Get in touch and experience radical transparency from day one.
            </p>
        </div>
    </div>
</section>

<section class="py-12 lg:py-20">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-12 lg:gap-16">

            {{-- Contact Info --}}
            <div class="lg:col-span-2">
                <h2 class="font-heading text-2xl font-bold mb-8"
                    style="color: rgb(var(--color-foreground))">Get in Touch</h2>

                <div class="space-y-6 mb-10">
                    @if($contact['contact.email'] ?? null)
                    <a href="mailto:{{ $contact['contact.email'] }}" class="flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-2xl bg-background/60 backdrop-blur-xl border border-border/50 flex items-center justify-center flex-shrink-0 transition-colors group-hover:bg-primary group-hover:border-primary">
                            <svg class="w-5 h-5 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium mb-1">Email</p>
                            <p class="text-sm" style="color: rgb(var(--color-muted-foreground))">{{ $contact['contact.email'] }}</p>
                        </div>
                    </a>
                    @endif

                    @if($contact['contact.website'] ?? null)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-background/60 backdrop-blur-xl border border-border/50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        </div>
                        <div>
                            <p class="font-medium mb-1">Website</p>
                            <p class="text-sm" style="color: rgb(var(--color-muted-foreground))">{{ $contact['contact.website'] }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-background/60 backdrop-blur-xl border border-border/50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium mb-1">Response Time</p>
                            <p class="text-sm" style="color: rgb(var(--color-muted-foreground))">
                                {{ $contact['contact.response_time'] ?? 'Zero-Delay Protocol Active' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-background/60 backdrop-blur-xl border border-border/50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium mb-1">Location</p>
                            <p class="text-sm" style="color: rgb(var(--color-muted-foreground))">
                                {{ $contact['contact.address'] ?? 'Jakarta, Indonesia — International Projects Worldwide' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Social --}}
                <div>
                    <p class="font-medium mb-4">Follow Us</p>
                    <div class="flex items-center gap-3">
                        @if($social['social.instagram'] ?? null)
                        <a href="{{ $social['social.instagram'] }}" target="_blank"
                           class="w-11 h-11 rounded-full bg-background/60 backdrop-blur-xl border border-border/50 flex items-center justify-center transition-colors hover:bg-primary hover:border-primary hover:text-primary-foreground text-muted-foreground"
                           aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        @endif
                        @if($social['social.twitter'] ?? null)
                        <a href="{{ $social['social.twitter'] }}" target="_blank"
                           class="w-11 h-11 rounded-full bg-background/60 backdrop-blur-xl border border-border/50 flex items-center justify-center transition-colors hover:bg-primary hover:border-primary hover:text-primary-foreground text-muted-foreground"
                           aria-label="Twitter">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        @endif
                        @if($social['social.linkedin'] ?? null)
                        <a href="{{ $social['social.linkedin'] }}" target="_blank"
                           class="w-11 h-11 rounded-full bg-background/60 backdrop-blur-xl border border-border/50 flex items-center justify-center transition-colors hover:bg-primary hover:border-primary hover:text-primary-foreground text-muted-foreground"
                           aria-label="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="lg:col-span-3">
                <div class="p-8 lg:p-10 rounded-3xl bg-background/70 backdrop-blur-xl border border-border/50">
                    <h2 class="font-heading text-2xl font-bold mb-2"
                        style="color: rgb(var(--color-foreground))">Send Us a Message</h2>
                    <p class="mb-8" style="color: rgb(var(--color-muted-foreground))">Fill out the form below and we'll get back to you as soon as possible.</p>

                    @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl" style="background: rgba(var(--color-primary), 0.1); border: 1px solid rgba(var(--color-primary), 0.2);">
                        <p class="text-primary font-medium">{{ session('success') }}</p>
                    </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6"
                          x-data="{ sending: false }"
                          @submit="sending = true">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Your Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       placeholder="John Doe"
                                       class="w-full rounded-xl h-12 px-4 text-sm transition-all focus:outline-none"
                                       style="background: rgba(var(--color-card), 0.5); border: 1px solid rgba(var(--color-border), 0.5); color: rgb(var(--color-foreground));"
                                       onfocus="this.style.borderColor='rgb(var(--color-primary))'"
                                       onblur="this.style.borderColor='rgba(var(--color-border),0.5)'">
                                @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Email Address *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       placeholder="john@example.com"
                                       class="w-full rounded-xl h-12 px-4 text-sm transition-all focus:outline-none"
                                       style="background: rgba(var(--color-card), 0.5); border: 1px solid rgba(var(--color-border), 0.5); color: rgb(var(--color-foreground));"
                                       onfocus="this.style.borderColor='rgb(var(--color-primary))'"
                                       onblur="this.style.borderColor='rgba(var(--color-border),0.5)'">
                                @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Subject *</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required
                                   placeholder="How can we help you?"
                                   class="w-full rounded-xl h-12 px-4 text-sm transition-all focus:outline-none"
                                   style="background: rgba(var(--color-card), 0.5); border: 1px solid rgba(var(--color-border), 0.5); color: rgb(var(--color-foreground));"
                                   onfocus="this.style.borderColor='rgb(var(--color-primary))'"
                                   onblur="this.style.borderColor='rgba(var(--color-border),0.5)'">
                            @error('subject')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Message *</label>
                            <textarea name="message" rows="6" required
                                      placeholder="Tell us about your project..."
                                      class="w-full rounded-xl px-4 py-3 text-sm transition-all focus:outline-none resize-none"
                                      style="background: rgba(var(--color-card), 0.5); border: 1px solid rgba(var(--color-border), 0.5); color: rgb(var(--color-foreground));"
                                      onfocus="this.style.borderColor='rgb(var(--color-primary))'"
                                      onblur="this.style.borderColor='rgba(var(--color-border),0.5)'">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit"
                                :disabled="sending"
                                class="w-full py-4 rounded-full font-semibold flex items-center justify-center gap-2 transition-opacity hover:opacity-90 disabled:opacity-60 disabled:cursor-not-allowed"
                                style="background: rgb(var(--color-primary)); color: rgb(var(--color-primary-foreground));">
                            {{-- Loading state --}}
                            <svg x-show="sending" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            {{-- Default state --}}
                            <svg x-show="!sending" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <span x-text="sending ? 'Sending...' : 'Send Message'">Send Message</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
