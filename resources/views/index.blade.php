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
        background-color: #383B3C;
        color: #f9fafb;
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
        margin-top: 0;
        margin-bottom: 3rem;
        background-color: #f7f5f1;
    }

    .home-collection--featured {
        margin-top: 3rem;
        margin-bottom: 0.5rem;
    }

    .home-collection--featured .home-section-shell {
        padding-bottom: 1rem;
    }

    html[data-theme="dark"] .home-collection {
        background-color: rgb(155, 179, 171);
    }

    .home-collection__heading {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-weight: 500;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        padding-bottom: 0.75rem;
    }

    html[data-theme="dark"] .home-collection__heading {
        border-bottom-color: rgba(255, 255, 255, 0.1);
    }

    .home-collection__tabs {
        display: flex;
        flex-wrap: wrap;
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

    .home-collection__panel {
        display: none;
    }

    .home-collection__panel.is-active {
        display: block;
    }

    .home-collection__slider-wrap {
        padding: 0 2.5rem;
    }

    .home-collection__swiper .swiper-slide {
        height: auto;
    }

    /* Compact product cards in category sliders (e-commerce style) */
    .home-collection__swiper .product-card-modern__media {
        aspect-ratio: 1 / 1.15;
    }

    .home-collection__swiper .product-card-modern__body {
        padding: 0.65rem 0.85rem 0.9rem;
    }

    .home-collection__swiper .product-card-modern__title {
        font-size: 0.7rem;
        letter-spacing: 0.08em;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }

    .home-collection__swiper .product-card-modern__meta {
        font-size: 0.7rem;
        margin-bottom: 0.2rem;
    }

    .home-collection__swiper .product-card-modern__price {
        font-size: 0.8rem;
    }

    .home-collection__swiper .product-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
    }

    @media (max-width: 992px) {
        .home-hero-split {
            grid-template-columns: 1fr;
            height: auto;
        }

        .home-hero-split__pane {
            min-height: 320px;
        }
    }

    @media (max-width: 640px) {
        .home-collection__slider-wrap {
            padding: 0 2rem;
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

    /* No gap between the collection image banners (outerwear, accessories, etc.) */
    .home-category-banner + .home-category-banner {
        margin-top: 0;
    }

    /* Scroll reveal: category slider and collection banners appear/disappear smoothly on scroll */
    .js-scroll-reveal {
        opacity: 0;
        transform: translateY(32px);
        transition: opacity 0.65s ease-out, transform 0.65s ease-out;
    }
    .js-scroll-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
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
        text-transform: capitalize;
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
        text-transform: capitalize;
    }

    .home-category-banner__links {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 1.5rem 2.5rem;
        text-transform: capitalize;
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

    .home-category-banner__subtitle {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 1rem;
        max-width: 420px;
        text-transform: capitalize;
    }

    .home-category-banner__cta {
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 0.9rem;
        color: #fff;
        text-decoration: none;
        padding-bottom: 0.2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.8);
    }

    .home-hero-slideshow {
        height: 100vh;
        min-height: 500px;
        overflow: hidden;
    }

    .home-hero-slideshow__swiper {
        height: 100%;
    }

    .home-hero-slideshow__swiper .swiper-wrapper {
        height: 100%;
    }

    .home-hero-slideshow__slide {
        height: 100%;
    }

    .home-hero-slideshow__slide .home-category-banner {
        height: 100%;
        min-height: 100%;
    }

    .home-category-banner--in-slider {
        margin-top: 0;
    }

    .home-category-banner--single {
        grid-template-columns: 1fr;
    }

    .home-category-banner--single .home-category-banner__pane--full {
        position: absolute;
        inset: 0;
        background-image: var(--slide-bg-image);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transform: scale(1.02);
    }

    .home-hero-slideshow__standard-slide {
        display: block;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    .home-hero-slideshow__standard-slide .home-category-banner {
        height: 100%;
    }

    .home-hero-slideshow__pagination {
        bottom: 0.75rem !important;
    }

    .home-hero-slideshow__pagination .swiper-pagination-bullet {
        width: 4px;
        height: 4px;
        background: rgba(0, 0, 0, 0.35);
        opacity: 1;
    }

    .home-hero-slideshow__pagination .swiper-pagination-bullet-active {
        background: rgba(0, 0, 0, 0.7);
    }

    @media (max-width: 768px) {
        .home-category-banner {
            grid-template-columns: 1fr;
            min-height: 520px;
        }

        .home-hero-slideshow {
            height: 100vh;
            min-height: 400px;
        }
    }

    @media (max-width: 640px) {
        .home-category-banner + .home-category-banner {
            margin-top: 0;
        }

        .home-category-banner__links {
            gap: 1rem 1.5rem;
        }
    }
</style>
@endpush

<main class="home-page">
    @php
        $staticHero = count($homeSections ?? []) ? $homeSections[0] : null;
        $heroSlides = $heroSlides ?? collect();
        $hasStandardSlides = isset($standardSlides) && $standardSlides->count() > 0;
        $slideCount = ($staticHero ? 1 : 0) + $heroSlides->count() + ($hasStandardSlides ? $standardSlides->count() : 0);
        $showSlideshow = $slideCount > 0;
    @endphp

    @if ($showSlideshow)
        <section class="home-hero-slideshow position-relative">
            <div class="swiper-container js-swiper-slider home-hero-slideshow__swiper"
                 data-settings='{
                    "autoplay": { "delay": 5000 },
                    "slidesPerView": 1,
                    "effect": "fade",
                    "loop": {{ $slideCount > 1 ? 'true' : 'false' }},
                    "pagination": { "el": ".home-hero-slideshow__pagination", "type": "bullets", "clickable": true }
                 }'>
                <div class="swiper-wrapper">
                    {{-- First slide: always the static original hero (two images + overlay) --}}
                    @if ($staticHero)
                        <div class="swiper-slide home-hero-slideshow__slide">
                            <div class="home-category-banner home-category-banner--hero home-category-banner--in-slider">
                                <div class="home-category-banner__pane"
                                     style="background-image: url('{{ $staticHero['left_image'] }}');"></div>
                                <div class="home-category-banner__pane"
                                     style="background-image: url('{{ $staticHero['right_image'] }}');"></div>
                                <div class="home-category-banner__overlay">
                                    <p class="home-category-banner__kicker">{{ $staticHero['kicker'] }}</p>
                                    <h2 class="home-category-banner__title">{{ $staticHero['title'] }}</h2>
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
                            </div>
                        </div>
                    @endif
                    @foreach ($heroSlides as $heroSlide)
                        <div class="swiper-slide home-hero-slideshow__slide">
                            <div class="home-category-banner home-category-banner--hero home-category-banner--in-slider">
                                <div class="home-category-banner__pane"
                                     style="background-image: url('{{ asset('uploads/slides') }}/{{ $heroSlide->image }}');"></div>
                                <div class="home-category-banner__pane"
                                     style="background-image: url('{{ $heroSlide->image_right ? asset('uploads/slides') . "/" . $heroSlide->image_right : asset('uploads/slides') . "/" . $heroSlide->image }}');"></div>
                                <div class="home-category-banner__overlay">
                                    <p class="home-category-banner__kicker">{{ $heroSlide->tagline }}</p>
                                    <h2 class="home-category-banner__title">{{ $heroSlide->title }}</h2>
                                    <div class="home-category-banner__links">
                                        @if ($heroSlide->link_left_text && $heroSlide->link)
                                            <a href="{{ $heroSlide->link }}" class="home-category-banner__link">{{ $heroSlide->link_left_text }}</a>
                                        @endif
                                        @if ($heroSlide->link_right_text && $heroSlide->link_right)
                                            <a href="{{ $heroSlide->link_right }}" class="home-category-banner__link">{{ $heroSlide->link_right_text }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if ($hasStandardSlides)
                        @foreach ($standardSlides as $slide)
                            <div class="swiper-slide home-hero-slideshow__slide">
                                <a href="{{ $slide->link ?: '#' }}" class="home-hero-slideshow__standard-slide">
                                    <div class="home-category-banner home-category-banner--hero home-category-banner--single home-category-banner--in-slider"
                                         style="--slide-bg-image: url('{{ asset('uploads/slides') }}/{{ $slide->image }}');">
                                        <div class="home-category-banner__pane home-category-banner__pane--full"></div>
                                        <div class="home-category-banner__overlay">
                                            <p class="home-category-banner__kicker">{{ $slide->tagline }}</p>
                                            <h2 class="home-category-banner__title">{{ $slide->title }}</h2>
                                            @if ($slide->subtitle)
                                                <p class="home-category-banner__subtitle">{{ $slide->subtitle }}</p>
                                            @endif
                                            @if ($slide->link)
                                                <span class="home-category-banner__cta">Shop now</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="home-hero-slideshow__pagination swiper-pagination"></div>
            </div>
        </section>
    @endif

    @if (count($categorySliders) > 0)
    <section class="home-collection js-scroll-reveal">
        <div class="home-section-shell">
            <div class="home-collection__tabs">
                @foreach ($categorySliders as $index => $category)
                    <button class="home-collection__tab {{ $index === 0 ? 'is-active' : '' }}" type="button" data-category-id="{{ $category->id }}">{{ $category->name }}</button>
                @endforeach
            </div>

            <div class="home-collection__panels">
                @foreach ($categorySliders as $index => $category)
                    <div class="home-collection__panel {{ $index === 0 ? 'is-active' : '' }}" data-panel="{{ $category->id }}">
                        @if ($category->products->count() > 0)
                        <div id="category-slider-{{ $category->id }}" class="home-collection__slider-wrap position-relative">
                            <div class="swiper-container js-swiper-slider home-collection__swiper"
                                 data-settings='{
                                "autoplay": false,
                                "slidesPerView": 4,
                                "slidesPerGroup": 4,
                                "spaceBetween": 16,
                                "effect": "none",
                                "loop": {{ $category->products->count() > 4 ? 'true' : 'false' }},
                                "navigation": {
                                    "nextEl": "#category-slider-{{ $category->id }} .products-carousel__next",
                                    "prevEl": "#category-slider-{{ $category->id }} .products-carousel__prev"
                                },
                                "breakpoints": {
                                    "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 12 },
                                    "640": { "slidesPerView": 3, "slidesPerGroup": 3, "spaceBetween": 14 },
                                    "992": { "slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 16 }
                                }
                            }'>
                                <div class="swiper-wrapper">
                                    @foreach ($category->products as $product)
                                        @php
                                            $material = $product->material ?? optional($product->category)->name ?? 'Premium materials';
                                        @endphp
                                        <div class="swiper-slide">
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
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="products-carousel__prev position-absolute top-50 start-0 d-flex align-items-center justify-content-center">
                                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_md" /></svg>
                            </div>
                            <div class="products-carousel__next position-absolute top-50 end-0 d-flex align-items-center justify-content-center">
                                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_md" /></svg>
                            </div>
                        </div>
                        @else
                        <p class="home-collection__empty text-muted small mb-0">No products in this category yet.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @foreach ($homeSections as $index => $section)
        <section class="home-category-banner js-scroll-reveal">
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
                            'brands' => $section['women_collection_brands'] ?? null,
                        ], fn($value) => $value !== null && $value !== '');
                        $menFilters = array_filter([
                            'categories' => optional($menCategory)->id,
                            'brands' => $section['men_collection_brands'] ?? null,
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

    @if ($fproducts && $fproducts->count() > 0)
    <section class="home-collection home-collection--featured js-scroll-reveal">
        <div class="home-section-shell">
            <h2 class="home-collection__heading">Featured</h2>
            <div id="featured-slider-wrap" class="home-collection__slider-wrap position-relative">
                <div class="swiper-container js-swiper-slider home-collection__swiper"
                     data-settings='{
                        "autoplay": false,
                        "slidesPerView": 4,
                        "slidesPerGroup": 4,
                        "spaceBetween": 16,
                        "effect": "none",
                        "loop": {{ $fproducts->count() > 4 ? 'true' : 'false' }},
                        "navigation": {
                            "nextEl": "#featured-slider-wrap .products-carousel__next",
                            "prevEl": "#featured-slider-wrap .products-carousel__prev"
                        },
                        "breakpoints": {
                            "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 12 },
                            "640": { "slidesPerView": 3, "slidesPerGroup": 3, "spaceBetween": 14 },
                            "992": { "slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 16 }
                        }
                    }'>
                    <div class="swiper-wrapper">
                        @foreach ($fproducts as $product)
                            @php
                                $material = $product->material ?? optional($product->category)->name ?? 'Premium materials';
                            @endphp
                            <div class="swiper-slide">
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
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="products-carousel__prev position-absolute top-50 start-0 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_md" /></svg>
                </div>
                <div class="products-carousel__next position-absolute top-50 end-0 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_md" /></svg>
                </div>
            </div>
        </div>
    </section>
    @endif

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
                var categoryId = tab.getAttribute('data-category-id') || '';

                tabs.forEach(function (t) {
                    t.classList.toggle('is-active', t === tab);
                });

                panels.forEach(function (panel) {
                    var panelId = panel.getAttribute('data-panel') || '';
                    var isActive = String(panelId) === String(categoryId);
                    panel.classList.toggle('is-active', isActive);
                    // Swipers inside hidden panels were initialized with 0 width; update when panel becomes visible
                    if (isActive && typeof Swiper !== 'undefined') {
                        var swiperEl = panel.querySelector('.home-collection__swiper');
                        if (swiperEl && swiperEl.swiper) {
                            requestAnimationFrame(function () {
                                swiperEl.swiper.update();
                            });
                        }
                    }
                });
            });
        });

        // Hero slideshow: reset autoplay timer to 5s when a pagination bullet is clicked
        var heroSlideshow = document.querySelector('.home-hero-slideshow__swiper');
        if (heroSlideshow) {
            heroSlideshow.addEventListener('click', function (e) {
                if (e.target.classList.contains('swiper-pagination-bullet') || e.target.closest('.swiper-pagination-bullet')) {
                    var swiper = heroSlideshow.swiper;
                    if (swiper && swiper.autoplay) {
                        swiper.autoplay.stop();
                        swiper.autoplay.start();
                    }
                }
            });
        }

        // Scroll reveal: smoothly show/hide category slider and collection banners when they enter or leave the viewport
        var revealEls = document.querySelectorAll('.js-scroll-reveal');
        if (revealEls.length && 'IntersectionObserver' in window) {
            var revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    } else {
                        entry.target.classList.remove('is-visible');
                    }
                });
            }, { rootMargin: '0px 0px -8% 0px', threshold: 0 });
            revealEls.forEach(function (el) {
                revealObserver.observe(el);
            });
        } else {
            revealEls.forEach(function (el) {
                el.classList.add('is-visible');
            });
        }
    });
</script>
@endpush