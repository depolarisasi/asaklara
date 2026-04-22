<!DOCTYPE html>
<html lang="id" id="html-root" class="{{ request()->cookie('asak-mode', 'light') === 'light' ? 'light' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $meta_description ?? 'ASAK Agency — The Anti-Chaos Agency. Done Right. Done On Time.' }}">
    <title>{{ $title ?? 'ASAK Agency' }} | Creative Digital Agency Based in Bandung</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/logo/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo/favicon-16x16.png">
    <link rel="icon" href="/logo/favicon.ico">

    @vite(['resources/css/app.css'])

    @stack('head')
</head>
<body class="font-body transition-colors duration-300">
    @include('components.public.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.public.footer')

    @vite(['resources/js/app.js'])
    @stack('scripts')

    <!-- Theme Switcher Widget -->
    <div id="theme-switcher" class="fixed bottom-6 right-6 z-50">
        <button
            id="theme-toggle-btn"
            aria-label="Toggle light/dark mode"
            onclick="toggleTheme()"
            class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center border-none cursor-pointer shadow-lg transition-all duration-300 hover:scale-110 active:scale-95"
        >
            <!-- Sun icon (shown in dark mode) -->
            <svg id="icon-sun" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
            </svg>
            <!-- Moon icon (shown in light mode) -->
            <svg id="icon-moon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
            </svg>
        </button>
    </div>

    <script>
        (function() {
            const html = document.getElementById('html-root');
            const btnSun = document.getElementById('icon-sun');
            const btnMoon = document.getElementById('icon-moon');

            // Read from localStorage first, fallback to current html class
            const saved = localStorage.getItem('asak-mode');
            if (saved) {
                if (saved === 'light') {
                    html.classList.add('light');
                } else {
                    html.classList.remove('light');
                }
            }

            function updateIcons() {
                const isLight = html.classList.contains('light');
                if (isLight) {
                    btnSun.classList.add('hidden');
                    btnMoon.classList.remove('hidden');
                } else {
                    btnSun.classList.remove('hidden');
                    btnMoon.classList.add('hidden');
                }
            }

            updateIcons();

            window.toggleTheme = function() {
                const isLight = html.classList.contains('light');
                if (isLight) {
                    html.classList.remove('light');
                    localStorage.setItem('asak-mode', 'dark');
                    document.cookie = 'asak-mode=dark; path=/; max-age=31536000';
                } else {
                    html.classList.add('light');
                    localStorage.setItem('asak-mode', 'light');
                    document.cookie = 'asak-mode=light; path=/; max-age=31536000';
                }
                updateIcons();
            };
        })();
    </script>
</body>
</html>
