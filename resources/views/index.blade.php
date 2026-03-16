@extends('layouts.app')
@section('content')

@push('styles')
<style>
    .home-page {
        min-height: 100vh;
        background-color: #f4f3f0;
        color: #050608;
    }

    html[data-theme="dark"] .home-page {
        background-color: #f4f3f0;
        color: #000000;
    }

    .home-hero-split {
        position: relative;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        height: calc(100vh - 80px);
        min-height: 670px;
        width: 100%;
        overflow: hidden;
        animation: heroFadeIn 0.8s ease-out forwards;
        opacity: 0;
        
    }

    .home-hero-split__pane {
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transform: scale(1.03);
        transition: transform 1.2s ease-out;
    }

    .home-hero-split::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 10%, rgba(255, 255, 255, 0.24), transparent 55%),
                    radial-gradient(circle at 80% 90%, rgba(0, 0, 0, 0.25), transparent 60%);
        pointer-events: none;
    }

    .home-hero-split__overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        z-index: 2;
        padding: 0 1.5rem;
    }

    .home-hero-kicker {
        letter-spacing: 0.32em;
        text-transform: uppercase;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .home-hero-title {
        font-size: clamp(2.8rem, 5vw, 4rem);
        letter-spacing: 0.14em;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1.75rem;
    }

    .home-hero-links {
        display: inline-flex;
        align-items: center;
        gap: 2.5rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
    }

    .home-hero-link {
        position: relative;
        color: #ffffff;
        text-decoration: none;
        padding-bottom: 0.2rem;
    }

    .home-hero-link::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 1px;
        background-color: #ffffff;
        transform-origin: left;
        transform: scaleX(0);
        transition: transform 220ms ease-out;
    }

    .home-hero-link:hover::after {
        transform: scaleX(1);
    }

    .home-hero-link:hover {
        color: #ffffff;
    }

    @keyframes heroFadeIn {
        from {
            opacity: 0;
            transform: translateY(22px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .home-section-shell {
        max-width: 1620px;
        margin: 0 auto;
        padding: 4rem 1.5rem 5rem;
    }

    .home-collection {
        margin-top: 1.5rem;
        background-color: #f7f5f1;
    }

    html[data-theme="dark"] .home-collection {
        background-color:rgb(155, 179, 171);
    }

    .home-collection__tabs {
        display: flex;
        gap: 2.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
    }

    html[data-theme="dark"] .home-collection__tabs {
        border-bottom-color: rgba(255, 255, 255, 0.1);
    }

    .home-collection__tab {
        position: relative;
        padding: 0 0 0.75rem;
        border: none;
        background: none;
        font-weight: 500;
        color: inherit;
        cursor: pointer;
    }

    .home-collection__tab::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 2px;
        background-color: #111111;
        transform-origin: left;
        transform: scaleX(0);
        transition: transform 220ms ease-out;
    }

    html[data-theme="dark"] .home-collection__tab::after {
        background-color: #ffffff;
    }

    .home-collection__tab.is-active::after {
        transform: scaleX(1);
    }

    .home-collection__grid {
        width: 100%;
    }

    .home-collection__panel {
        display: none;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 2.5rem;
    }

    .home-collection__panel.is-active {
        display: grid;
    }

    @media (max-width: 992px) {
        .home-hero-split {
            grid-template-columns: 1fr;
            height: auto;
        }

        .home-hero-split__pane {
            min-height: 320px;
        }

        .home-collection__panel {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .home-collection__panel {
            grid-template-columns: minmax(0, 1fr);
        }

        .home-hero-links {
            gap: 1.5rem;
        }
    }

    .product-card-modern {
        cursor: pointer;
        transition: transform 300ms ease, box-shadow 300ms ease, background-color 300ms ease;
        border-radius: 5px;
        overflow: hidden;
        background-color: #fdfcf9;
    }

    html[data-theme="dark"] .product-card-modern {
        background-color:rgb(213, 213, 213);
    }

    .product-card-modern__media {
        position: relative;
        overflow: hidden;
        aspect-ratio: 3 / 3;
    }

    .product-card-modern__media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 300ms ease;
    }

    .product-card-modern__body {
        padding: 1.1rem 1.25rem 1.4rem;
    }

    .product-card-modern__title {
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
    }

    .product-card-modern__meta {
        font-size: 0.8rem;
        color: #8b8b86;
        margin-bottom: 0.6rem;
    }

    html[data-theme="dark"] .product-card-modern__meta {
        color:rgb(249, 249, 247);
    }

    .product-card-modern__price {
        font-size: 0.95rem;
        font-weight: 500;
    }

    .product-card-modern:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.16);
    }

    html[data-theme="dark"] .product-card-modern:hover {
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.75);
    }

    .product-card-modern:hover .product-card-modern__media img {
        transform: scale(1.05);
    }

    .home-category-banner {
        position: relative;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        min-height: 420px;
        overflow: hidden;
        margin-top: 0;
    }

    .home-category-banner--hero {
        height: 670px;
        min-height: 670px;
    }

    .home-category-banner + .home-category-banner {
        margin-top: 3rem;
    }

    .home-category-banner__pane {
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transform: scale(1.02);
    }

    .home-category-banner::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 25% 50%, rgba(0, 0, 0, 0.2), transparent 50%),
                    radial-gradient(circle at 75% 50%, rgba(0, 0, 0, 0.2), transparent 50%);
        pointer-events: none;
    }

    .home-category-banner__overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        z-index: 2;
        padding: 3rem 1.5rem;
    }

    .home-category-banner__kicker {
        letter-spacing: 0.3em;
        text-transform: uppercase;
        font-size: 0.78rem;
        margin-bottom: 0.9rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .home-category-banner__title {
        font-size: clamp(2rem, 3.5vw, 2.8rem);
        font-weight: 700;
        letter-spacing: 0.14em;
        color: #ffffff;
        margin-bottom: 1.5rem;
    }

    .home-category-banner__links {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 1.5rem 2.5rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 0.9rem;
    }

    .home-category-banner__link {
        position: relative;
        color: #ffffff;
        text-decoration: none;
        padding-bottom: 0.2rem;
    }

    .home-category-banner__link::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 1px;
        background-color: #ffffff;
        transform-origin: left;
        transform: scaleX(0);
        transition: transform 220ms ease-out;
    }

    .home-category-banner__link:hover::after {
        transform: scaleX(1);
    }

    .home-category-banner__link:hover {
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .home-category-banner {
            grid-template-columns: 1fr;
            min-height: 520px;
        }
    }

    @media (max-width: 640px) {
        .home-category-banner + .home-category-banner {
            margin-top: 2rem;
        }

        .home-category-banner__links {
            gap: 1rem 1.5rem;
        }
    }
</style>
@endpush

<main class="home-page">
    @php
        $heroImage = isset($heroSlide) && $heroSlide
            ? asset('uploads/slides') . '/' . $heroSlide->image
            : asset('assets/images/home/hero-lifestyle.jpg');
    @endphp

    @if (count($homeSections))
        @php
            $heroSection = $homeSections[0];
        @endphp
        <section class="home-category-banner home-category-banner--hero">
            <div class="home-category-banner__pane"
                 style="background-image: url('{{ $heroSection['left_image'] }}');"></div>
            <div class="home-category-banner__pane"
                 style="background-image: url('{{ $heroSection['right_image'] }}');"></div>
            <div class="home-category-banner__overlay">
                <p class="home-category-banner__kicker">{{ $heroSection['kicker'] }}</p>
                <h2 class="home-category-banner__title">{{ $heroSection['title'] }}</h2>
                <div class="home-category-banner__links">
                    @php
                        $heroWomenFilters = array_filter([
                            'categories' => optional($womenCategory)->id,
                        ], fn($value) => $value !== null && $value !== '');
                        $heroMenFilters = array_filter([
                            'categories' => optional($menCategory)->id,
                        ], fn($value) => $value !== null && $value !== '');
                    @endphp
                    <a href="{{ route('shop.index', $heroWomenFilters) }}"
                       class="home-category-banner__link">Women</a>
                    <a href="{{ route('shop.index', $heroMenFilters) }}"
                       class="home-category-banner__link">Men</a>
                </div>
            </div>
        </section>
    @endif


    <section class="home-collection">
        <div class="home-section-shell">
            <div class="home-collection__tabs">
                <button class="home-collection__tab is-active" type="button" data-gender="women">Women</button>
                <button class="home-collection__tab" type="button" data-gender="men">Men</button>
            </div>

            <div class="home-collection__grid js-collection-grid">
                <div class="home-collection__panel is-active" data-panel="women">
                    @foreach ($womenProducts as $product)
                        @php
                            $material = $product->material ?? optional($product->category)->name ?? 'Premium materials';
                        @endphp
                        <article class="product-card-modern">
                            <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"
                               class="product-card-modern__media d-block">
                                <img loading="lazy"
                                     src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                     alt="{{ $product->name }}">
                            </a>
                            <div class="product-card-modern__body">
                                <h3 class="product-card-modern__title">
                                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"
                                       class="stretched-link text-reset text-decoration-none">
                                        {{ strtoupper($product->name) }}
                                    </a>
                                </h3>
                                <p class="product-card-modern__meta">{{ $material }}</p>
                                <div class="product-card-modern__price">
                                    @if ($product->sale_price)
                                        <span><s>£{{ $product->regular_price }}</s> £{{ $product->sale_price }}</span>
                                    @else
                                        <span>£{{ $product->regular_price }}</span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="home-collection__panel" data-panel="men">
                    @foreach ($menProducts as $product)
                        @php
                            $material = $product->material ?? optional($product->category)->name ?? 'Premium materials';
                        @endphp
                        <article class="product-card-modern">
                            <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"
                               class="product-card-modern__media d-block">
                                <img loading="lazy"
                                     src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                     alt="{{ $product->name }}">
                            </a>
                            <div class="product-card-modern__body">
                                <h3 class="product-card-modern__title">
                                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"
                                       class="stretched-link text-reset text-decoration-none">
                                        {{ strtoupper($product->name) }}
                                    </a>
                                </h3>
                                <p class="product-card-modern__meta">{{ $material }}</p>
                                <div class="product-card-modern__price">
                                    @if ($product->sale_price)
                                        <span><s>£{{ $product->regular_price }}</s> £{{ $product->sale_price }}</span>
                                    @else
                                        <span>£{{ $product->regular_price }}</span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @foreach ($homeSections as $index => $section)
        <section class="home-category-banner">
            <div class="home-category-banner__pane"
                 style="background-image: url('{{ $section['left_image'] }}');"></div>
            <div class="home-category-banner__pane"
                 style="background-image: url('{{ $section['right_image'] }}');"></div>
            <div class="home-category-banner__overlay">
                <p class="home-category-banner__kicker">{{ $section['kicker'] }}</p>
                <h2 class="home-category-banner__title">{{ $section['title'] }}</h2>
                <div class="home-category-banner__links">
                    @php
                        $womenFilters = array_filter([
                            'categories' => optional($womenCategory)->id,
                            'brands' => $section['collection_brands'] ?? null,
                        ], fn($value) => $value !== null && $value !== '');
                        $menFilters = array_filter([
                            'categories' => optional($menCategory)->id,
                            'brands' => $section['collection_brands'] ?? null,
                        ], fn($value) => $value !== null && $value !== '');
                    @endphp
                    <a href="{{ route('shop.index', $womenFilters) }}"
                       class="home-category-banner__link">Women</a>
                    <a href="{{ route('shop.index', $menFilters) }}"
                       class="home-category-banner__link">Men</a>
                </div>
            </div>
        </section>
    @endforeach

</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tabs = document.querySelectorAll('.home-collection__tab');
        var panels = document.querySelectorAll('.home-collection__panel');

        if (!tabs.length || !panels.length) return;

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var gender = tab.getAttribute('data-gender') || '';

                tabs.forEach(function (t) {
                    t.classList.toggle('is-active', t === tab);
                });

                panels.forEach(function (panel) {
                    var panelKey = panel.getAttribute('data-panel') || '';
                    panel.classList.toggle('is-active', panelKey === gender);
                });
            });
        });
    });
</script>
@endpush