@extends('layouts.app')
@section('content')
    <style>
        .shop-landing {
            padding-top: 5.5rem;
            padding-bottom: 3rem;
        }

        .shop-landing__header {
            max-width: 42rem;
            margin: 0 auto 1.75rem;
            text-align: center;
        }

        .shop-landing__title {
            font-size: clamp(1.8rem, 2.4vw, 2.5rem);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .shop-landing__subtitle {
            margin: 0;
            color: #5b6168;
        }

        .shop-landing__grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .shop-landing__card {
            position: relative;
            border-radius: 0.9rem;
            overflow: hidden;
            min-height: 17rem;
            display: flex;
            align-items: flex-end;
            padding: 1.35rem;
            color: #fff !important;
            text-decoration: none;
            background-size: cover;
            background-position: center;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 10px 26px rgba(0, 0, 0, 0.12);
        }

        .shop-landing__card,
        .shop-landing__card:hover,
        .shop-landing__card:focus,
        .shop-landing__card:visited,
        .shop-landing__card .shop-landing__card-title,
        .shop-landing__card .shop-landing__card-text {
            color: #fff !important;
        }

        .shop-landing__card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(20, 20, 20, 0.1) 20%, rgba(20, 20, 20, 0.72) 100%);
        }

        .shop-landing__card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.16);
        }

        .shop-landing__card-content {
            position: relative;
            z-index: 1;
        }

        .shop-landing__card-title {
            font-size: 1.25rem;
            margin-bottom: 0.2rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .shop-landing__card-text {
            margin: 0;
            opacity: 0.93;
        }

        @media (min-width: 768px) {
            .shop-landing__grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        html[data-theme="dark"] .shop-landing__subtitle {
            color: #d4d8dd;
        }
    </style>

    <main class="shop-landing">
        <div class="container">
            <div class="shop-landing__header">
                <h1 class="shop-landing__title">Shop</h1>
                <p class="shop-landing__subtitle">Pick a section to start browsing.</p>
            </div>

            <div class="shop-landing__grid">
                <a href="{{ route('shop.all') }}" class="shop-landing__card"
                    style="background-image: url('https://images.unsplash.com/photo-1483985988355-763728e1935b?w=900&h=1200&fit=crop');">
                    <div class="shop-landing__card-content">
                        <h2 class="shop-landing__card-title">Shop All</h2>
                        <p class="shop-landing__card-text">Browse everything in one place.</p>
                    </div>
                </a>

                <a href="{{ $shopMensUrl }}" class="shop-landing__card"
                    style="background-image: url('{{ asset('assets/images/shop/mens-clothing-slide.png') }}');">
                    <div class="shop-landing__card-content">
                        <h2 class="shop-landing__card-title">Mens</h2>
                        <p class="shop-landing__card-text">Everyday and statement pieces.</p>
                    </div>
                </a>

                <a href="{{ $shopWomensUrl }}" class="shop-landing__card"
                    style="background-image: url('{{ asset('assets/images/shop/womens-clothing-slide.png') }}');">
                    <div class="shop-landing__card-content">
                        <h2 class="shop-landing__card-title">Womens</h2>
                        <p class="shop-landing__card-text">Fresh fits for every season.</p>
                    </div>
                </a>
            </div>
        </div>
    </main>
@endsection
