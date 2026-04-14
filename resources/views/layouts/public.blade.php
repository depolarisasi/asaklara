<!DOCTYPE html>
<html lang="id" id="html-root" class="{{ request()->cookie('asak-mode', 'light') === 'light' ? 'light' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $meta_description ?? 'ASAK Agency — The Anti-Chaos Agency. Done Right. Done On Time.' }}">
    <title>{{ $title ?? 'ASAK Agency' }} | The Anti-Chaos Agency</title>

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

    <style>
        :root {
            --font-heading: 'Space Grotesk', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;

            /* Light mode default — Burgundy & Gold */
            --color-primary: 143 26 0;           /* #8F1A00 Burgundy */
            --color-primary-foreground: 251 248 240; /* #FBF8F0 Cream */
            --color-background: 251 248 240;     /* #FBF8F0 Warm Cream */
            --color-foreground: 26 8 6;          /* #1A0806 Deep Brown */
            --color-muted: 240 222 184;          /* #F0DEB8 Warm Sand */
            --color-muted-foreground: 122 53 32; /* #7A3520 Warm Muted */
            --color-border: 232 212 160;         /* #E8D4A0 Gold Border */
            --color-card: 255 255 255;
            --color-accent: 251 194 70;          /* #FBC246 Gold — for hover accents */
            --color-accent-foreground: 26 8 6;   /* #1A0806 Dark */
            --color-ring: 251 194 70;            /* #FBC246 Gold — for focus ring & CTA gradient */
            --color-panel-dark: 26, 8, 6;          /* always-dark panel bg: dark maroon in light mode */
            --color-panel-text: 251, 248, 240;     /* always-light text on dark panel: cream */
        }

        /* Dark mode — Deep Navy & Gold */
        html:not(.light) {
            --color-primary: 251, 194, 70;         /* #FBC246 True Gold */
            --color-primary-foreground: 23, 34, 43; /* #17222B Dark Navy */
            --color-background: 10, 21, 32;        /* #0A1520 Deep Navy */
            --color-foreground: 245, 237, 216;     /* #F5EDD8 Warm Cream */
            --color-muted: 22, 38, 53;             /* #162635 Dark Muted */
            --color-muted-foreground: 143, 168, 191; /* #8FA8BF Blue-Grey */
            --color-border: 30, 48, 69;            /* #1E3045 Navy Border */
            --color-card: 15, 30, 45;              /* #0F1E2D Dark Card */
            --color-accent: 168, 48, 48;           /* #A83030 Dark Burgundy */
            --color-accent-foreground: 245, 237, 216; /* #F5EDD8 Cream */
            --color-ring: 251, 194, 70;            /* #FBC246 Gold */
            --color-panel-dark: 15, 30, 45;        /* always-dark panel bg: dark navy card in dark mode */
            --color-panel-text: 245, 237, 216;     /* always-light text on dark panel: warm cream */
        }

        .light {
            --color-primary: 143, 26, 0;           /* #8F1A00 Burgundy */
            --color-primary-foreground: 251, 248, 240;
            --color-background: 251, 248, 240;
            --color-foreground: 26, 8, 6;
            --color-muted: 240, 222, 184;
            --color-muted-foreground: 122, 53, 32;
            --color-border: 232, 212, 160;
            --color-card: 255, 255, 255;
            --color-accent: 251, 194, 70;          /* #FBC246 Gold */
            --color-accent-foreground: 26, 8, 6;   /* #1A0806 Dark */
            --color-ring: 251, 194, 70;            /* #FBC246 Gold */
            --color-panel-dark: 26, 8, 6;          /* light mode: dark maroon */
            --color-panel-text: 251, 248, 240;     /* light mode: cream */
        }

        * { box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background-color: rgb(var(--color-background));
            color: rgb(var(--color-foreground));
            min-height: 100vh;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .font-heading { font-family: var(--font-heading); }

        /* Glass effect */
        .glass {
            background: rgba(var(--color-background), 0.6);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(var(--color-border), 0.5);
        }
        .glass:hover { background: rgba(var(--color-background), 0.8); }

        /* Primary color utilities */
        .text-primary { color: rgb(var(--color-primary)); }
        .bg-primary { background-color: rgb(var(--color-primary)); }
        .border-primary { border-color: rgb(var(--color-primary)); }

        /* Opacity color utilities — mirrors Tailwind /opacity modifier */
        .bg-primary\/10  { background-color: rgba(var(--color-primary), 0.10); }
        .bg-primary\/20  { background-color: rgba(var(--color-primary), 0.20); }
        .bg-primary\/90  { background-color: rgba(var(--color-primary), 0.90); }
        .bg-background\/60 { background-color: rgba(var(--color-background), 0.60); }
        .bg-background\/70 { background-color: rgba(var(--color-background), 0.70); }
        .bg-background\/95 { background-color: rgba(var(--color-background), 0.95); }
        .bg-foreground\/95 { background-color: rgba(var(--color-foreground), 0.95); }
        .bg-foreground\/80 { background-color: rgba(var(--color-foreground), 0.80); }
        .bg-muted\/30    { background-color: rgba(var(--color-muted), 0.30); }
        .bg-muted\/50    { background-color: rgba(var(--color-muted), 0.50); }
        .border-border\/50 { border-color: rgba(var(--color-border), 0.50); }
        .border-border\/20 { border-color: rgba(var(--color-border), 0.20); }
        .border-primary\/30 { border-color: rgba(var(--color-primary), 0.30); }
        .border-foreground\/20 { border-color: rgba(var(--color-foreground), 0.20); }
        .text-background    { color: rgb(var(--color-background)); }
        .text-background\/70 { color: rgba(var(--color-background), 0.70); }
        .text-background\/50 { color: rgba(var(--color-background), 0.50); }
        .text-primary\/80   { color: rgba(var(--color-primary), 0.80); }
        .text-muted\/50     { color: rgba(var(--color-muted), 0.50); }
        .bg-accent          { background-color: rgb(var(--color-accent)); }
        .text-accent-foreground { color: rgb(var(--color-accent-foreground)); }

        /* Glassmorphism variants — backdrop-blur-xl = 24px */
        .glass-bg {
            background: rgba(var(--color-background), 0.60);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(var(--color-border), 0.50);
        }
        .glass-card {
            background: rgba(var(--color-background), 0.70);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(var(--color-border), 0.50);
        }

        /* Text balance — mirrors Tailwind text-balance */
        .text-balance { text-wrap: balance; }

        /* Transition helpers */
        .transition-all-300 { transition: all 0.3s ease; }
        .transition-all-500 { transition: all 0.5s ease; }

        /* Group hover — JS-driven for pure CSS fallback */
        .service-card:hover .service-icon-wrap {
            background-color: rgb(var(--color-primary));
            border-color: rgb(var(--color-primary));
            color: rgb(var(--color-primary-foreground));
        }
        .service-card:hover .service-icon-wrap svg {
            color: rgb(var(--color-primary-foreground));
        }
        .service-card:hover .service-learn-more {
            opacity: 1;
        }
        .service-card:hover {
            border-color: rgba(var(--color-primary), 0.30);
            background-color: rgba(var(--color-background), 0.80);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        .portfolio-card:hover .portfolio-overlay {
            opacity: 1;
        }
        .portfolio-card:hover {
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: rgb(var(--color-muted)); }
        ::-webkit-scrollbar-thumb { background: rgb(var(--color-primary)); border-radius: 3px; }

        /* Theme-aware logo switching */
        html.light .logo-light { display: block; }
        html.light .logo-dark  { display: none;  }
        html:not(.light) .logo-light { display: none;  }
        html:not(.light) .logo-dark  { display: block; }
    </style>

    @stack('head')
</head>
<body>
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
            style="
                width: 48px; height: 48px; border-radius: 50%;
                background: rgb(var(--color-primary));
                color: #fff; border: none; cursor: pointer;
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                transition: transform 0.2s, box-shadow 0.2s;
            "
            onmouseenter="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 28px rgba(0,0,0,0.4)'"
            onmouseleave="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.3)'"
        >
            <!-- Sun icon (shown in dark mode) -->
            <svg id="icon-sun" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
            </svg>
            <!-- Moon icon (shown in light mode) -->
            <svg id="icon-moon" class="w-5 h-5" style="display:none;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                    html.classList.remove('dark');
                } else {
                    html.classList.remove('light');
                    html.classList.remove('dark');
                }
            }

            function updateIcons() {
                const isLight = html.classList.contains('light');
                btnSun.style.display = isLight ? 'none' : 'block';
                btnMoon.style.display = isLight ? 'block' : 'none';
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
