<footer class="bg-[rgb(var(--pub-panel-dark))] text-[rgb(var(--pub-panel-text))] pt-20 pb-10 border-t border-[rgba(var(--pub-panel-text),0.05)]">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-8">
            
            {{-- Sisi Kiri: Logo, Language --}}
            <div class="lg:col-span-5 flex flex-col items-start">
                {{-- Logo --}}
                <div class="mb-10">
                    <a href="{{ route('home') }}" class="block">
                        {{-- Menggunakan logo horizontal gold yang kontras di bg gelap --}}
                        <img src="/logo/asak-horizontal-logo-gold.png" alt="ASAK Agency" class="h-12 w-auto">
                    </a>
                </div>
 
            </div>

            {{-- Sisi Kanan: 2 Kolom Link --}}
            <div class="lg:col-span-7 grid grid-cols-2 gap-8">
                
                {{-- Column 1: SERVICES --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-[0.2em] mb-8 text-[rgba(var(--pub-panel-text),0.3)]">Services</h4>
                    <ul class="flex flex-col gap-4">
                        @php
                            $services = [
                                'Brand Engineering', 'Tech Development', 'Growth Hacking', 'Photo & Videography'
                            ];
                        @endphp
                        @foreach($services as $service)
                            <li>
                                <a href="{{ route('services') }}" class="text-sm text-[rgba(var(--pub-panel-text),0.6)] hover:text-white transition-colors">
                                    {{ $service }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Column 2: COMPANY --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-[0.2em] mb-8 text-[rgba(var(--pub-panel-text),0.3)]">Company</h4>
                    <ul class="flex flex-col gap-4">
                        <li><a href="{{ route('about') }}" class="text-sm text-[rgba(var(--pub-panel-text),0.6)] hover:text-white transition-colors">About us</a></li>
                        <li><a href="{{ route('portfolio') }}" class="text-sm text-[rgba(var(--pub-panel-text),0.6)] hover:text-white transition-colors">Portfolio</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-[rgba(var(--pub-panel-text),0.6)] hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Bottom Copyright (Keep it minimal as in mockup) --}}
        <div class="mt-24 pt-8 border-t border-[rgba(var(--pub-panel-text),0.05)] flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] text-[rgba(var(--pub-panel-text),0.3)]">
                &copy; {{ date('Y') }} ASAK Agency. All rights reserved. 
                 
            </p>
            <div class="flex items-center gap-6">
                {{-- Social Icons if needed, though mockup was very clean --}}
            </div>
        </div>
    </div>
</footer>
