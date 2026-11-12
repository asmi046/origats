<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body {
                background-color: #000;
            }

            .hero {
                min-height: 100vh;
                background-color: #000;
                background-image: url('/img/main_page_b.webp');
                background-size: cover;
                background-position: center;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                animation: hero-fade-in 2s ease-out both;
            }

            .hero__logo {
                width: min(45vw, 280px);
                opacity: 0;
                filter: blur(24px);
                transform: scale(1.35);
                animation: logo-stamp 1.6s cubic-bezier(0.16, 1, 0.3, 1) 0.9s both;
            }

            .hero__slogan {
                margin-top: 2rem;
                font-family: ui-sans-serif, system-ui, sans-serif;
                font-size: clamp(1rem, 2.5vw, 1.5rem);
                letter-spacing: 0.06em;
                color: rgba(255, 255, 255, 0.85);
                text-align: center;
                text-transform: uppercase;
                opacity: 0;
                filter: blur(12px);
                transform: translateY(10px);
                animation: slogan-stamp 1.4s cubic-bezier(0.16, 1, 0.3, 1) 1.8s both;
            }

            @keyframes slogan-stamp {
                0% {
                    opacity: 0;
                    filter: blur(12px);
                    transform: translateY(10px);
                }
                100% {
                    opacity: 1;
                    filter: blur(0);
                    transform: translateY(0);
                }
            }

            @keyframes hero-fade-in {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes logo-stamp {
                0% {
                    opacity: 0;
                    filter: blur(24px);
                    transform: scale(1.35);
                }
                60% {
                    opacity: 1;
                }
                100% {
                    opacity: 1;
                    filter: blur(0);
                    transform: scale(1);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .hero,
                .hero__logo {
                    animation: none;
                    opacity: 1;
                    filter: none;
                    transform: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="hero">
            <img class="hero__logo" src="/img/logo.svg" alt="{{ config('app.name', 'Laravel') }}">
            <p class="hero__slogan">
                Ваша продукция оригинальная,<br>при наличии галограммы
            </p>
        </div>
    </body>
</html>
