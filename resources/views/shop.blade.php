@extends('layouts.app')
@section('content')
    <style>
        .brand-list li,
        .category-list li {
            line-height: 40px;
        }

        .brand-list li .chk-brand,
        .category-list li .chk-category,
        .shop-sale-filter .chk-on-sale {
            width: 1rem;
            height: 1rem;
            color: #e4e4e4;
            border: 0.125rem solid currentColor;
            border-radius: 0;
            margin-right: 0.75rem;
        }

        .filled-heart {
            color: orange;
        }

        
        .swatch-color {
            display: inline-block;
            border-radius: 50%;
            background-color: currentColor;
        }

        
        .swatch-color.swatch_active {
            border-color: #000 !important;
        }

        
        html[data-theme="dark"] .swatch-color.swatch_active {
            border-color: #f5e6e0 !important;
            box-shadow: 0 0 0 2px #f5e6e0;
        }

        /* Low stock badge – more visible amber in dark mode */
        html[data-theme="dark"] .low-stock-badge {
            background-color: #b45309 !important;
            border: 1px solid #f59e0b;
            color: #fffbeb !important;
        }

        /* Ensure product-card gallery arrows stay clickable above image links */
        .pc__img-wrapper .pc__img-next,
        .pc__img-wrapper .pc__img-prev {
            z-index: 5;
            cursor: pointer;
            pointer-events: auto;
        }

        /* Desktop-only: border, max-height & scroll (mobile drawer uses full-height panel below) */
        @media (min-width: 992px) {
            .shop-sidebar {
                border-right: 1px solid #e9ecef;
                padding-right: 1.25rem;
                max-height: calc(100vh - 120px);
                overflow-y: auto;
            }

            .shop-sidebar::-webkit-scrollbar {
                width: 6px;
            }

            .shop-sidebar::-webkit-scrollbar-thumb {
                background: #d0d4d8;
                border-radius: 999px;
            }
        }

        /* Mobile: right drawer — covers part of the page; slideshow/shop stay visible on the left */
        @media (max-width: 991.98px) {
            #shopFilter.shop-sidebar.side-sticky {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: auto !important;
                right: 0 !important;
                width: min(26.25rem, 88vw) !important;
                max-width: 88vw !important;
                height: 100vh !important;
                height: 100dvh !important;
                min-height: 100vh !important;
                min-height: 100dvh !important;
                max-height: none !important;
                margin: 0 !important;
                box-sizing: border-box;
                padding: 0 1rem 1.75rem;
                border-right: none;
                overflow-x: hidden;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
                z-index: 1060 !important;
                box-shadow: -8px 0 24px rgba(0, 0, 0, 0.12);
                transform: translateX(100%);
                transition: transform 0.35s cubic-bezier(0.39, 0.575, 0.565, 1) !important;
            }

            #shopFilter.shop-sidebar.side-sticky::-webkit-scrollbar {
                width: 0;
                height: 0;
                display: none;
            }

            #shopFilter.shop-sidebar.side-sticky.aside_visible {
                transform: translateX(0) !important;
            }

            #shopFilter .aside-header {
                margin-left: -1rem;
                margin-right: -1rem;
            }

            #shopFilter.side-sticky .accordion {
                padding-left: 0;
                padding-right: 0;
            }
        }

        .shop-filter-title {
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 600;
            color: #5b6168;
            margin-bottom: 1rem;
        }

        .shop-sidebar .accordion-item {
            border: 0;
            border-bottom: 1px solid #eceff2;
            border-radius: 0;
            margin-bottom: 0 !important;
            padding: 0.9rem 0 0.95rem !important;
        }

        .shop-sidebar .accordion-button {
            font-size: 0.85rem !important;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            font-weight: 600;
            color: #111 !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .shop-sidebar .accordion-button::after {
            width: 0.72rem;
            height: 0.72rem;
            background-size: 0.72rem;
        }

        .shop-sidebar .list-item {
            font-size: 0.95rem;
            color: #222;
            display: flex;
            justify-content: space-between;
            align-items: center;
            line-height: 1.5 !important;
            margin-bottom: 0.3rem;
        }

        .shop-sidebar .menu-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .shop-sidebar .chk-brand,
        .shop-sidebar .chk-category,
        .shop-sidebar .chk-on-sale {
            width: 1.05rem !important;
            height: 1.05rem !important;
            border: 1px solid #8f959c !important;
            border-radius: 2px;
            margin-right: 0 !important;
        }

        .shop-sidebar .swatch-size {
            border: 1px solid #c9ced3 !important;
            color: #2b3137;
            min-width: 44px;
            text-align: center;
            font-size: 0.82rem;
            border-radius: 999px;
            text-transform: uppercase;
            padding: 0.28rem 0.8rem;
        }

        .shop-sidebar .swatch-size.btn-primary {
            background: #111 !important;
            color: #fff !important;
            border-color: #111 !important;
        }

        .shop-sidebar .swatch-color {
            width: 22px !important;
            height: 22px !important;
            border-width: 1px !important;
            margin-right: 0.45rem;
            margin-bottom: 0.45rem;
        }

        .shop-sidebar .price-range__info {
            font-size: 0.85rem;
        }

        html[data-theme="dark"] .shop-sidebar {
            border-right-color: #3a4046;
        }

        html[data-theme="dark"] .shop-sidebar .accordion-item {
            border-bottom-color: #373d43;
        }

        html[data-theme="dark"] .shop-sidebar .accordion-button,
        html[data-theme="dark"] .shop-sidebar .list-item,
        html[data-theme="dark"] .shop-filter-title {
            color: #f3f5f7 !important;
        }

        /* Mobile filter top bar: dark grey, slightly darker than panel body (#383B3C) */
        html[data-theme="dark"] #shopFilter .aside-header {
            background-color: #2d3134 !important;
            color: #f3f5f7;
            border-bottom: 1px solid #3a4046;
        }

        html[data-theme="dark"] #shopFilter .aside-header h3 {
            color: #f3f5f7 !important;
        }

        /* Close control visible on dark header */
        html[data-theme="dark"] #shopFilter .aside-header .btn-close-aside,
        html[data-theme="dark"] #shopFilter .aside-header .btn-close-lg {
            filter: invert(1) grayscale(100%);
            opacity: 0.85;
        }

        @media (min-width: 992px) {
            .shop-main {
                position: relative;
                align-items: flex-start;
            }

            .shop-sidebar {
                order: 1;
                width: 260px;
                min-width: 260px;
                flex: 0 0 260px;
                margin-right: 1.25rem;
                transition: transform 0.3s ease, opacity 0.3s ease;
            }

            .shop-list {
                order: 2;
                flex: 1 1 auto;
                min-width: 0;
                transition: max-width 0.3s ease, margin 0.3s ease;
            }

            .shop-main:not(.filters-collapsed) .shop-list {
                max-width: none;
                margin-left: 0;
                margin-right: 0;
            }

            .shop-main:not(.filters-collapsed) {
                height: calc(100vh - 110px);
                overflow: hidden;
            }

            .shop-main:not(.filters-collapsed) .shop-sidebar,
            .shop-main:not(.filters-collapsed) .shop-list {
                max-height: 100%;
                overflow-y: auto;
            }

            .shop-main:not(.filters-collapsed) .shop-sidebar {
                overscroll-behavior-y: contain;
            }

            .shop-main:not(.filters-collapsed) .shop-list {
                overscroll-behavior-y: auto;
            }

            .shop-main:not(.filters-collapsed) .shop-list {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .shop-main:not(.filters-collapsed) .shop-list::-webkit-scrollbar {
                width: 0;
                height: 0;
                display: none;
            }

            .shop-main.filters-collapsed .shop-sidebar {
                position: absolute;
                top: 0;
                left: 0;
                transform: translateX(-110%);
                opacity: 0;
                pointer-events: none;
            }

            .shop-main.filters-collapsed .shop-list {
                max-width: 1120px;
                margin-left: auto;
                margin-right: auto;
            }
        }

        html[data-theme="dark"] #shop-pagination .pagination .page-link,
        html[data-theme="dark"] .shop-list .pagination .page-link {
            color: #e9ecef !important;
            background-color: #2b2f33 !important;
            border-color: #5e656d !important;
        }

        html[data-theme="dark"] #shop-pagination .pagination .page-item.active .page-link,
        html[data-theme="dark"] .shop-list .pagination .page-item.active .page-link {
            color: #ffffff !important;
            background-color: #141618 !important;
            border-color: #141618 !important;
        }

        html[data-theme="dark"] #shop-pagination .pagination .page-item.disabled .page-link,
        html[data-theme="dark"] .shop-list .pagination .page-item.disabled .page-link {
            color: #9aa3ad !important;
            background-color: #22262a !important;
            border-color: #4f565e !important;
            opacity: 1 !important;
        }

        html[data-theme="dark"] #shop-pagination .pagination a.page-link:hover,
        html[data-theme="dark"] #shop-pagination .pagination a.page-link:focus,
        html[data-theme="dark"] .shop-list .pagination a.page-link:hover,
        html[data-theme="dark"] .shop-list .pagination a.page-link:focus {
            color: #ffffff !important;
            background-color: #33383d !important;
            border-color: #6a727a !important;
        }

        html[data-theme="dark"] #shop-pagination .text-muted {
            color: #adb5bd !important;
        }
    </style>

    <main class="pt-90">
        <section class="shop-main container d-flex pt-4 pt-xl-5 filters-collapsed" id="shopMain">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filters</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div>

                <div class="pt-4 pt-lg-0"></div>
                <button type="button" id="js-hide-filter-inside"
                    class="shop-filter-title btn-link d-none d-lg-inline-flex align-items-center p-0 border-0 bg-transparent">
                    Hide Filter
                </button>

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Product Categories
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3 category-list">
                                <ul class="list list-inline mb-0">
                                    @foreach ($categories as $category)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" class="chk-category" name="categories"
                                                    value="{{ $category->id }}"
                                                    @if (in_array($category->id, explode(',', $f_categories))) checked="checked" @endif />
                                                {{ $category->name }}
                                            </span>
                                            <span class="text-right float-right">({{ $category->products->count() }})</span>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion" id="color-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-2" aria-expanded="true"
                                aria-controls="accordion-filter-2">
                                Color
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-1" data-bs-parent="#color-filters">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-wrap">
                                    <a href="#" class="swatch-color js-filter" data-color="Green"
                                        style="color: green; width: 24px; height: 24px; border-radius: 50%; border: 2px solid #ddd;"></a>
                                    <a href="#" class="swatch-color js-filter" data-color="Black"
                                        style="color: black; width: 24px; height: 24px; border-radius: 50%; border: 2px solid #ddd;"></a>
                                    <a href="#" class="swatch-color js-filter" data-color="Pink"
                                        style="color: pink; width: 24px; height: 24px; border-radius: 50%; border: 2px solid #ddd;"></a>
                                    <a href="#" class="swatch-color js-filter" data-color="White"
                                        style="color: white; width: 24px; height: 24px; border-radius: 50%; border: 2px solid #ddd;"></a>
                                    <a href="#" class="swatch-color js-filter" data-color="Grey"
                                        style="color: grey; width: 24px; height: 24px; border-radius: 50%; border: 2px solid #ddd;"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion" id="size-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-size">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-size" aria-expanded="true"
                                aria-controls="accordion-filter-size">
                                Sizes
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-size" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-wrap">
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">S</a>
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">M</a>
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">L</a>
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XL</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion" id="brand-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-brand">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                                aria-controls="accordion-filter-brand">
                                Collections
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                            <div class="search-field multi-select accordion-body px-0 pb-0">
                                <ul class="list list-inline mb-0 brand-list">
                                    @foreach ($brands as $brand)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" name="brands" value="{{ $brand->id }}"
                                                    class="chk-brand"
                                                    @if (in_array($brand->id, explode(',', $f_brands))) checked="checked" @endif>
                                                {{ $brand->name }}
                                            </span>
                                            <span class="text-right float-end">
                                                ({{ $brand->products->count() }})
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shop-sale-filter mb-4 pb-3 border-bottom">
                    <ul class="list list-inline mb-0">
                        <li class="list-item">
                            <span class="menu-link py-1">
                                <input type="checkbox" class="chk-on-sale" id="chk-on-sale"
                                    @if (!empty($onSale ?? false)) checked="checked" @endif />
                                On sale
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="accordion" id="price-filters">
                    <div class="accordion-item mb-4">
                        <h5 class="accordion-header mb-2" id="accordion-heading-price">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true"
                                aria-controls="accordion-filter-price">
                                Price
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                            <input class="price-range-slider" type="text" name="price_range" value=""
                                data-slider-min="1" data-slider-max="250" data-slider-step="5"
                                data-slider-value="[{{ $min_price }},{{ $max_price }}]" data-currency="£" />
                            <div class="price-range__info d-flex align-items-center mt-2">
                                <div class="me-auto">
                                    <span class="text-secondary">Min Price: </span>
                                    <span class="price-range__min">£1</span>
                                </div>
                                <div>
                                    <span class="text-secondary">Max Price: </span>
                                    <span class="price-range__max">£250</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <div class="accordion-item mb-4">
                        <button type="button" onclick="clearAllFilters()"
                            class="btn btn-outline-secondary w-100 text-uppercase py-3">
                            Clear All Filters
                        </button>
                        <button type="button" id="js-apply-filters-mobile" class="btn btn-primary w-100 text-uppercase py-3 mt-2 d-lg-none">
                            Apply filters
                        </button>
                        <button type="button" id="js-apply-filters-desktop" class="btn btn-primary w-100 text-uppercase py-3 mt-2 d-none d-lg-block">
                            Apply filters
                        </button>
                    </div>
                </div>

            </div>

            <div class="shop-list flex-grow-1">
                <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split"
                    data-settings='{
            "autoplay": {
              "delay": 5000,
              "disableOnInteraction": false
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
                    <div class="swiper-wrapper">
                        
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #e8d5d0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Big <br /><strong>SALE</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Selected styles at great prices. Limited time only—shop the best deals on clothing and accessories.</p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #e8d5d0;">
                                        <img loading="lazy" src="https://images.unsplash.com/photo-1607082349566-187342175e2f?w=630&amp;h=450&amp;fit=crop" width="630"
                                            height="450" alt="Sale"
                                            class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #e0e8ec;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Men's <br /><strong>CLOTHING</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Discover sharp, versatile pieces for every occasion. From casual essentials to refined looks.</p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #e0e8ec;">
                                        <img loading="lazy" src="https://images.unsplash.com/photo-1617137968427-85924c800a22?w=630&amp;h=450&amp;fit=crop" width="630"
                                            height="450" alt="Men's clothing"
                                            class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Women's <br /><strong>CLOTHING</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Curated styles to express your look. New arrivals and timeless favourites for every season.</p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <img loading="lazy" src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=630&amp;h=450&amp;fit=crop" width="630"
                                            height="450" alt="Women's clothing"
                                            class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container p-3 p-xl-5">
                        <div
                            class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2">
                        </div>

                    </div>
                </div>

                <div class="mb-3 pb-2 pb-xl-3"></div>

                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="{{ route('home.index') }}"
                            class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                    </div>

                    <div
                        class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                            aria-label="Page Size" id="pagesize" name="pagesize" style="margin-right: 20px;">
                            <option value="12" {{ $size == 12 ? 'selected' : '' }}>Show</option>
                            <option value="24" {{ $size == 24 ? 'selected' : '' }}>24</option>
                            <option value="48" {{ $size == 48 ? 'selected' : '' }}>48</option>
                            <option value="102" {{ $size == 102 ? 'selected' : '' }}>102</option>
                        </select>

                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                            aria-label="Sort Items" name="orderby" id="orderby">
                            <option value="-1" {{ $order == -1 ? 'selected' : '' }}>Default</option>
                            <option value="1" {{ $order == 1 ? 'selected' : '' }}>Date, New to Old</option>
                            <option value="2" {{ $order == 2 ? 'selected' : '' }}>Date, Old to New</option>
                            <option value="3" {{ $order == 3 ? 'selected' : '' }}>Price, Low to High</option>
                            <option value="4" {{ $order == 4 ? 'selected' : '' }}>Price, High to Low</option>
                        </select>

                        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                        <div class="col-size align-items-center order-1 d-none d-lg-flex">
                            <span class="text-uppercase fw-medium me-2">View</span>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                                data-cols="2">2</button>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                                data-cols="3">3</button>
                            <button class="btn-link fw-medium js-cols-size" data-target="products-grid"
                                data-cols="4">4</button>
                        </div>

                        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                                data-aside="shopFilter">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10"
                                    viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                            </button>
                        </div>

                        <div class="shop-filter d-none d-lg-flex align-items-center order-0 order-md-3 ms-3">
                            <button type="button" id="js-desktop-filter-toggle"
                                class="btn-link btn-link_f d-flex align-items-center ps-0">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10"
                                    viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span
                                    class="text-uppercase fw-medium d-inline-block align-middle js-desktop-filter-label">Show Filter</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @php
                        $activeColorFilters = array_values(array_filter(array_map('trim', explode(',', (string) $fcolors))));
                    @endphp
                    @foreach ($products as $product)
                        <div class="product-card-wrapper">
                        <div class="product-card mb-3 mb-md-4 mb-xxl-5" style="position:relative;">
                                
                                @if ($product->stock_status === 'outofstock' || $product->quantity === 0)
                                    <div class="position-absolute top-0 start-0 m-2" style="z-index:10;">
                                        <span class="badge bg-danger" style="font-size:0.7rem; letter-spacing:0.03em;">Out of Stock</span>
                                    </div>
                                @elseif ($product->quantity <= 5)
                                    <div class="position-absolute top-0 start-0 m-2" style="z-index:10;">
                                        <span class="badge bg-danger" style="font-size:0.7rem; letter-spacing:0.03em;">Only {{ $product->quantity }} left!</span>
                                    </div>
                                @elseif ($product->quantity <= 10)
                                    <div class="position-absolute top-0 start-0 m-2" style="z-index:10;">
                                        <span class="badge bg-warning text-dark low-stock-badge" style="font-size:0.7rem; letter-spacing:0.03em;">Low Stock</span>
                                    </div>
                                @endif
                                @php
                                    $cardImage = $product->image;
                                    $cardGallery = $product->images ? array_filter(array_map('trim', explode(',', $product->images))) : [];
                                    $colorMainImages = [];

                                    // Variant products: show one main image per colour in card slider.
                                    if ($product->variants->isNotEmpty()) {
                                        $colorMainImages = [];
                                        foreach ($product->variants as $variant) {
                                            $variantImage = trim((string) $variant->image);
                                            if ($variantImage === '') {
                                                continue;
                                            }
                                            $colorKey = strtolower(trim((string) ($variant->color ?? '')));
                                            if ($colorKey === '') {
                                                $colorKey = '__no_color__';
                                            }
                                            if (!isset($colorMainImages[$colorKey])) {
                                                $colorMainImages[$colorKey] = $variantImage;
                                            }
                                        }

                                        // Keep first-selected active colour as the preferred main card image.
                                        if (!empty($activeColorFilters)) {
                                            foreach ($activeColorFilters as $activeColor) {
                                                $activeColorKey = strtolower(trim((string) $activeColor));
                                                if ($activeColorKey !== '' && isset($colorMainImages[$activeColorKey])) {
                                                    $cardImage = $colorMainImages[$activeColorKey];
                                                    break;
                                                }
                                            }
                                        }

                                        if (!empty($colorMainImages)) {
                                            $cardGallery = array_values(array_filter(
                                                $colorMainImages,
                                                fn($img) => $img !== $cardImage
                                            ));
                                        }
                                    }

                                    $baseProductUrl = route('shop.product.details', ['product_slug' => $product->slug]);
                                    $productUrlMain = $baseProductUrl;
                                    $productUrlGallery = [];

                                    if ($product->variants->isNotEmpty() && !empty($colorMainImages)) {
                                        $makeDetailUrlForVariantImage = function ($imageFilename) use ($product, $colorMainImages, $baseProductUrl) {
                                            if ($imageFilename === '' || $imageFilename === null) {
                                                return $baseProductUrl;
                                            }
                                            $canonicalColor = null;
                                            foreach ($colorMainImages as $key => $img) {
                                                if ($img !== $imageFilename) {
                                                    continue;
                                                }
                                                foreach ($product->variants as $v) {
                                                    $vk = strtolower(trim((string) ($v->color ?? '')));
                                                    if ($key === '__no_color__') {
                                                        if ($vk === '') {
                                                            $canonicalColor = trim((string) $v->color);
                                                            break 2;
                                                        }
                                                    } elseif ($vk === $key) {
                                                        $canonicalColor = trim((string) $v->color);
                                                        break 2;
                                                    }
                                                }
                                            }
                                            if ($canonicalColor === null || $canonicalColor === '') {
                                                return $baseProductUrl;
                                            }
                                            $variantsForColor = $product->variants->filter(function ($v) use ($canonicalColor) {
                                                return trim((string) ($v->color ?? '')) === $canonicalColor;
                                            });
                                            if ($variantsForColor->isEmpty()) {
                                                return $baseProductUrl;
                                            }
                                            $pick = $variantsForColor->first(function ($v) {
                                                return (int) $v->quantity > 0;
                                            }) ?: $variantsForColor->first();
                                            $size = trim((string) ($pick->size ?? ''));
                                            if ($size === '') {
                                                return $baseProductUrl;
                                            }

                                            return $baseProductUrl . '?' . http_build_query([
                                                'color' => $canonicalColor,
                                                'size' => $size,
                                            ]);
                                        };
                                        $productUrlMain = $makeDetailUrlForVariantImage($cardImage);
                                        foreach ($cardGallery as $gimg) {
                                            $productUrlGallery[] = $makeDetailUrlForVariantImage($gimg);
                                        }
                                    } else {
                                        foreach ($cardGallery as $gimg) {
                                            $productUrlGallery[] = $baseProductUrl;
                                        }
                                    }
                                @endphp
                                <div class="pc__img-wrapper">
                                    <div class="swiper-container background-img js-swiper-slider"
                                        data-settings='{"resizeObserver": true}'>
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <a
                                                    href="{{ $productUrlMain }}"><img
                                                        loading="lazy"
                                                        src="{{ asset('uploads/products') }}/{{ $cardImage }}"
                                                        width="330" height="400" alt="{{ $product->name }}"
                                                        class="pc__img"></a>
                                            </div>
                                            @foreach ($cardGallery as $idx => $gimg)
                                            <div class="swiper-slide">
                                                <a
                                                    href="{{ $productUrlGallery[$idx] ?? $baseProductUrl }}"><img
                                                        loading="lazy"
                                                        src="{{ asset('uploads/products') }}/{{ $gimg }}"
                                                        width="330" height="400" alt="{{ $product->name }}"
                                                        class="pc__img"></a>
                                            </div>
                                            @endforeach
                                        </div>
                                        <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_prev_sm" />
                                            </svg></span>
                                        <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_next_sm" />
                                            </svg></span>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $product->category->name }}</p>
                                    <h6 class="pc__title"><a
                                            href="{{ $productUrlMain }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price">
                                            @if ($product->sale_price)
                                                <s>£{{ $product->regular_price }} </s> £{{ $product->sale_price }}
                                            @else
                                                £{{ $product->regular_price }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="product-card__review d-flex align-items-center">
                                        @php
                                            $productReviewCount = $product->reviews->count();
                                            $productAvgRating = $productReviewCount > 0 ? round($product->reviews->avg('rating')) : 0;
                                        @endphp
                                        <div class="reviews-group d-flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"
                                                    style="fill: {{ $i <= $productAvgRating ? '#ffc107' : '#ccc' }}">
                                                    <use href="#icon_star" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-1">
                                            {{ $productReviewCount }} {{ Str::plural('review', $productReviewCount) }}
                                        </span>
                                    </div>

                                    @if (Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                                        <form method="POST"
                                            action="{{ route('wishlist.item.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist filled-heart"
                                                title="Remove from Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('wishlist.add') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}" />
                                            <input type="hidden" name="name" value="{{ $product->name }}" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <input type="hidden" name="price"
                                                value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                                            <button type="submit"
                                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="divider"></div>
                <div class = "flex items-center justify-between flex-wrap gap10 wgp-pagination" id="shop-pagination">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>
    </main>

    <form id="frmfilter" method="GET" action="{{ route('shop.index') }}">
        <input type="hidden" name="page" value="{{ $products->currentPage() }}">
        <input type="hidden" name="size" id="size" value="{{ $size }}" />
        <input type="hidden" name="order" id="order" value="{{ $order }}" />
        <input type="hidden" name="brands" id="hdnBrands" />
        <input type="hidden" name="categories" id="hdnCategories" />
        <input type="hidden" name="min" id="hdnMinPrice" value="{{ $min_price }}" />
        <input type="hidden" name="max" id="hdnMaxPrice" value="{{ $max_price }}" />
        <input type="hidden" name="sizes" id="hdnSizes" />
        <input type="hidden" name="colors" id="hdnColors" />
        <input type="hidden" name="sale" id="hdnSale" value="1" {{ empty($onSale ?? false) ? 'disabled' : '' }} />
    </form>
@endsection

@push('scripts')
    <script>
        function clearAllFilters() {
            $('#hdnBrands, #hdnCategories, #hdnSizes, #hdnColors, #hdnMinPrice, #hdnMaxPrice').val('');
            $('.swatch-size').removeClass('btn-primary').addClass('btn-outline-light');
            $('.swatch-color').removeClass('swatch_active');
            $('.chk-brand, .chk-category').prop('checked', false);
            $('.chk-on-sale').prop('checked', false);
            $('#hdnSale').prop('disabled', true);
            $("[name='price_range']").val('');
            $('#frmfilter').submit();
        }

        $(function() {
            var desktopFilterStateKey = 'shopDesktopFilterOpen';
            var autoApplyTimer = null;
            var pendingFilterRequest = null;
            var selectedColorOrder = [];

            function isDesktopView() {
                return window.innerWidth >= 992;
            }

            function setDesktopFilterOpenState(isOpen) {
                localStorage.setItem(desktopFilterStateKey, isOpen ? '1' : '0');
            }

            function getDesktopFilterOpenState() {
                return localStorage.getItem(desktopFilterStateKey) === '1';
            }

            function setDesktopFilterButtonState(isOpen) {
                var $btn = $('#js-desktop-filter-toggle');
                if (!$btn.length) {
                    return;
                }
                $btn.find('.js-desktop-filter-label').text(isOpen ? 'Hide Filter' : 'Show Filter');
                $btn.attr('aria-expanded', isOpen ? 'true' : 'false');
            }

            function refreshShopLayout() {
                window.requestAnimationFrame(function() {
                    window.requestAnimationFrame(function() {
                        var mainSwiper = document.querySelector('.slideshow.js-swiper-slider');
                        if (mainSwiper && mainSwiper.swiper && typeof mainSwiper.swiper.update === 'function') {
                            mainSwiper.swiper.update();
                        }

                        $('#products-grid .pc__img-wrapper .swiper-container').each(function() {
                            if (this.swiper && typeof this.swiper.update === 'function') {
                                this.swiper.update();
                            }
                        });
                    });
                });
            }

            function initProductCardSliders() {
                if (window.Uomo && window.Uomo.sections && typeof window.Uomo.sections.SwiperSlideshow === 'function') {
                    new window.Uomo.sections.SwiperSlideshow();
                }

                // Bind each card's arrows to its own swiper instance.
                $('#products-grid .pc__img-wrapper .swiper-container').each(function() {
                    var $slider = $(this);
                    var swiper = this.swiper;
                    if (!swiper) {
                        return;
                    }

                    var nextEl = $slider.find('.pc__img-next')[0];
                    var prevEl = $slider.find('.pc__img-prev')[0];
                    if (!nextEl || !prevEl) {
                        return;
                    }

                    swiper.params.navigation = Object.assign({}, swiper.params.navigation, {
                        nextEl: nextEl,
                        prevEl: prevEl,
                    });

                    if (swiper.navigation && typeof swiper.navigation.destroy === 'function') {
                        swiper.navigation.destroy();
                    }
                    if (swiper.navigation && typeof swiper.navigation.init === 'function') {
                        swiper.navigation.init();
                    }
                    if (swiper.navigation && typeof swiper.navigation.update === 'function') {
                        swiper.navigation.update();
                    }
                });
            }

            function syncDesktopFilterLayout() {
                var $shopMain = $('#shopMain');
                if (!$shopMain.length) {
                    return;
                }

                if (isDesktopView()) {
                    var isOpen = getDesktopFilterOpenState();
                    $shopMain.toggleClass('filters-collapsed', !isOpen);
                    setDesktopFilterButtonState(isOpen);
                } else {
                    $shopMain.removeClass('filters-collapsed');
                    setDesktopFilterButtonState(true);
                }

                refreshShopLayout();
            }

            function syncHiddenInputsFromUI() {
                var brands = [];
                $("input[name='brands']:checked").each(function() {
                    brands.push($(this).val());
                });
                $("#hdnBrands").val(brands.join(','));

                var categories = [];
                $("input[name='categories']:checked").each(function() {
                    categories.push($(this).val());
                });
                $("#hdnCategories").val(categories.join(','));

                var selectedSizes = [];
                $('.swatch-size.btn-primary').each(function() {
                    selectedSizes.push($(this).text().trim());
                });
                $('#hdnSizes').val(selectedSizes.join(','));

                var selectedColors = selectedColorOrder.filter(function(color) {
                    return $('.swatch-color[data-color="' + color + '"]').hasClass('swatch_active');
                });

                if (!selectedColors.length) {
                    $('.swatch-color.swatch_active').each(function() {
                        var color = ($(this).data('color') || '').toString().trim();
                        if (color) {
                            selectedColors.push(color);
                        }
                    });
                }

                $('#hdnColors').val(selectedColors.join(','));

                var priceVal = $("[name='price_range']").val();
                if (priceVal && priceVal.includes(',')) {
                    var parts = priceVal.split(',');
                    $("#hdnMinPrice").val(parts[0]);
                    $("#hdnMaxPrice").val(parts[1]);
                }

                var onSaleChecked = $('#chk-on-sale').is(':checked');
                $('#hdnSale').prop('disabled', !onSaleChecked);
            }

            function applyFilters() {
                if (isDesktopView()) {
                    setDesktopFilterOpenState(true);
                }
                requestProductsUpdate(1);
            }

            function requestProductsUpdate(page) {
                syncHiddenInputsFromUI();
                if (page) {
                    $("#frmfilter input[name='page']").val(page);
                }

                var $form = $("#frmfilter");
                var action = $form.attr('action');
                var query = $form.serialize();
                var url = action + (action.indexOf('?') === -1 ? '?' : '&') + query;

                if (pendingFilterRequest && typeof pendingFilterRequest.abort === 'function') {
                    pendingFilterRequest.abort();
                }

                pendingFilterRequest = $.ajax({
                    url: url,
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).done(function(responseHtml) {
                    var $response = $('<div></div>').html(responseHtml);
                    var $newGrid = $response.find('#products-grid');
                    var $newPagination = $response.find('#shop-pagination');

                    if ($newGrid.length) {
                        $('#products-grid').replaceWith($newGrid);
                    }
                    if ($newPagination.length) {
                        $('#shop-pagination').replaceWith($newPagination);
                    }

                    window.history.replaceState({}, '', url);
                    $("#frmfilter input[name='page']").val(page || 1);
                    initProductCardSliders();
                    refreshShopLayout();
                }).fail(function(xhr, status) {
                    if (status !== 'abort') {
                        window.location.href = url;
                    }
                }).always(function() {
                    pendingFilterRequest = null;
                });
            }

            function scheduleApplyFilters(delay) {
                clearTimeout(autoApplyTimer);
                autoApplyTimer = setTimeout(function() {
                    applyFilters();
                }, delay || 250);
            }

            function syncColorSelectionOrder(recentlyClickedColor) {
                var activeColors = [];
                $('.swatch-color.swatch_active').each(function() {
                    var color = ($(this).data('color') || '').toString().trim();
                    if (color) {
                        activeColors.push(color);
                    }
                });

                selectedColorOrder = selectedColorOrder.filter(function(color) {
                    return activeColors.includes(color);
                });

                var clicked = (recentlyClickedColor || '').toString().trim();
                if (clicked && activeColors.includes(clicked) && !selectedColorOrder.includes(clicked)) {
                    selectedColorOrder.push(clicked);
                }

                activeColors.forEach(function(color) {
                    if (!selectedColorOrder.includes(color)) {
                        selectedColorOrder.push(color);
                    }
                });
            }

            function isMobileFilterView() {
                return window.innerWidth < 992;
            }

            function onFilterChange() {
                syncHiddenInputsFromUI();
                scheduleApplyFilters(250);
            }

            $("#js-apply-filters-mobile").on("click", function() {
                applyFilters();
            });

            $("#js-apply-filters-desktop").on("click", function() {
                applyFilters();
            });

            $("#pagesize").on("change", function() {
                $("#size").val($("#pagesize option:selected").val());
                applyFilters();
            });

            $("#orderby").on("change", function() {
                $("#order").val($("#orderby option:selected").val());
                applyFilters();
            });

            $(document).on('click', '#shop-pagination a.page-link', function(e) {
                var href = $(this).attr('href');
                if (!href) {
                    return;
                }
                e.preventDefault();
                var page = new URL(href, window.location.origin).searchParams.get('page') || 1;
                requestProductsUpdate(page);
            });

            // Product title goes to the variant for the currently visible card image (active slide).
            $(document).on('click', '.product-card .pc__title a', function(e) {
                var $card = $(this).closest('.product-card');
                var $activeLink = $card.find('.pc__img-wrapper .swiper-slide-active a').first();
                if (!$activeLink.length) {
                    return;
                }
                var href = $activeLink.attr('href');
                if (!href) {
                    return;
                }
                e.preventDefault();
                window.location.href = href;
            });

            $("input[name='brands']").on("change", function() {
                onFilterChange();
            });

            $("input[name='categories']").on("change", function() {
                onFilterChange();
            });

            $('.chk-on-sale').on('change', function() {
                onFilterChange();
            });

            $("[name='price_range']").on("change", function() {
                syncHiddenInputsFromUI();
                scheduleApplyFilters(350);
            });

            $('.swatch-size').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('btn-primary');
                if ($(this).hasClass('btn-primary')) {
                    $(this).removeClass('btn-outline-light');
                } else {
                    $(this).addClass('btn-outline-light');
                }
                onFilterChange();
            });

            $('.swatch-color').on('click', function(e) {
                e.preventDefault();
                var clickedColor = $(this).data('color');
                setTimeout(function() {
                    syncColorSelectionOrder(clickedColor);
                    onFilterChange();
                }, 0);
            });

            $('#js-desktop-filter-toggle').on('click', function() {
                if (!isDesktopView()) {
                    return;
                }
                var willOpen = $('#shopMain').hasClass('filters-collapsed');
                $('#shopMain').toggleClass('filters-collapsed');
                setDesktopFilterButtonState(willOpen);
                setDesktopFilterOpenState(willOpen);
                refreshShopLayout();
            });

            $('#js-hide-filter-inside').on('click', function() {
                if (!isDesktopView()) {
                    return;
                }
                if (!$('#shopMain').hasClass('filters-collapsed')) {
                    $('#js-desktop-filter-toggle').trigger('click');
                }
            });

            $(window).on('resize', function() {
                syncDesktopFilterLayout();
                refreshShopLayout();
            });

            $(document).ready(function() {
                if (!localStorage.getItem(desktopFilterStateKey)) {
                    setDesktopFilterOpenState(false);
                }

                var urlSizes = new URLSearchParams(window.location.search).get('sizes');
                if (urlSizes) {
                    var sizesArray = urlSizes.split(',');
                    $('.swatch-size').removeClass('btn-primary').addClass('btn-outline-light');
                    $('.swatch-size').each(function() {
                        var buttonText = $(this).text().trim();
                        if (sizesArray.includes(buttonText)) {
                            $(this).removeClass('btn-outline-light').addClass('btn-primary');
                        }
                    });
                }

                var urlColors = new URLSearchParams(window.location.search).get('colors');
                if (urlColors) {
                    var colorsArray = urlColors.split(',');
                    selectedColorOrder = colorsArray.map(function(c) {
                        return (c || '').trim();
                    }).filter(function(c) {
                        return c.length > 0;
                    });
                    $('.swatch-color').removeClass('swatch_active');
                    colorsArray.forEach(function(c) {
                        var color = (c || '').trim();
                        if (color) {
                            $('.swatch-color[data-color="' + color + '"]').addClass('swatch_active');
                        }
                    });
                }

                syncColorSelectionOrder();

                
                syncHiddenInputsFromUI();

                initProductCardSliders();

                syncDesktopFilterLayout();
            });

            // Product card image arrows: force per-card navigation binding
            // so each next/prev controls its own slider reliably.
            $(document).on('click', '#products-grid .pc__img-next, #products-grid .pc__img-prev', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var $slider = $(this).closest('.swiper-container');
                if (!$slider.length || !$slider[0].swiper) return;

                if ($(this).hasClass('pc__img-next')) {
                    $slider[0].swiper.slideNext();
                } else {
                    $slider[0].swiper.slidePrev();
                }
            });


        });
    </script>
@endpush
