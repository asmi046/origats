<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Верификация брендовой одежды от ТРУ СТАРЗ</title>
    <meta name="description"
        content="Верификация лицензионного мерча Артистов от «Тру Старз». Проверь свой мерч на подлинность.">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ТРУ СТАРЗ">
    <meta property="og:title" content="Верификация брендовой одежды от ТРУ СТАРЗ">
    <meta property="og:description"
        content="Верификация лицензионного мерча Артистов от «Тру Старз». Проверь свой мерч на подлинность.">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ url('/img/og-image.jpg') }}">
    <meta property="og:image:width" content="642">
    <meta property="og:image:height" content="540">
    <meta property="og:locale" content="ru_RU">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Верификация брендовой одежды от ТРУ СТАРЗ">
    <meta name="twitter:description"
        content="Верификация лицензионного мерча Артистов от «Тру Старз». Проверь свой мерч на подлинность.">
    <meta name="twitter:image" content="{{ url('/img/og-image.jpg') }}">

    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

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
            min-height: 100svh;
            background-color: #000;
            background-image: url('/img/main_page_b.webp');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            animation: hero-fade-in 2s ease-out 1.5s both;
        }

        @media (max-width: 768px) {
            .hero {
                background-image: url('/img/main_page_b_mob.webp');
            }
        }

        .hero__logo {
            width: min(40vw, 219px);
            opacity: 0;
            filter: blur(24px);
            transform: scale(1.35);
            animation: logo-stamp 1.6s cubic-bezier(0.16, 1, 0.3, 1) 2.4s both;
        }

        .hero__slogan {
            margin: 2rem 20px 0 20px;
            font-family: 'Bee Three', 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            font-weight: 400;
            font-size: clamp(1.8rem, 4vw, 4rem);
            letter-spacing: 0.1em;
            background: linear-gradient(110deg,
                    #000 0%,
                    #000 46%,
                    #ffd700 50%,
                    #000 54%,
                    #000 100%);
            background-size: 250% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
            text-align: center;
            text-transform: uppercase;
            opacity: 0;
            filter: blur(12px);
            transform: translateY(10px);
            animation: slogan-stamp 1.4s cubic-bezier(0.16, 1, 0.3, 1) 3.3s both,
                slogan-shine 3.5s linear 5s infinite;
            line-height: 1.1;
        }

        @keyframes slogan-shine {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: 0% 0;
            }
        }

        .hero__galo-wrap {
            position: relative;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            width: min(60vw, 150px);
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            animation: galo-fade-in 1.2s ease-out 4.2s both;
        }

        .hero__galo-wrap::before {
            content: '';
            position: absolute;
            inset: -5%;
            border-radius: 50%;
            background: conic-gradient(from 0deg,
                    transparent 0deg,
                    rgba(255, 215, 130, 0.95) 30deg,
                    transparent 80deg,
                    transparent 200deg,
                    rgba(255, 190, 80, 0.7) 240deg,
                    transparent 290deg);
            -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 10px), #000 calc(100% - 10px));
            mask: radial-gradient(farthest-side, transparent calc(100% - 10px), #000 calc(100% - 10px));
            filter: drop-shadow(0 0 6px rgba(255, 200, 100, 0.8));
            animation: galo-spin 8s linear infinite;
        }

        .hero__galo {
            position: relative;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        @keyframes galo-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes galo-fade-in {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
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
            .hero__logo,
            .hero__slogan,
            .hero__galo-wrap {
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
            Ваша продукция оригинальная, при наличии этой голограммы
        </p>
        <div class="hero__galo-wrap">
            <img class="hero__galo" src="/img/galo.webp" alt="Голограмма ТРУ СТАРЗ">
        </div>
    </div>
</body>

</html>
