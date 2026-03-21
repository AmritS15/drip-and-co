@extends('layouts.app')
@section('content')
<main class="pt-90 page-about">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
        <div class="mw-930">
            <h2 class="page-title about-reveal">About US</h2>
        </div>

        <div class="about-us__content pb-5 mb-5">
            <div class="mw-930">
                <p class="mb-5 about-reveal about-reveal--delay-1">
                    <img loading="lazy" class="w-100 h-auto d-block" src="{{ asset('assets/images/about/about-1.jpg') }}"
                        width="1410" height="550" alt="" />
                </p>
                <h3 class="mb-4 about-reveal">OUR STORY</h3>
                <p class="fs-6 fw-medium mb-4 about-reveal about-reveal--delay-1">From Birmingham streets to your wardrobe. Drip & Co crafts affordable streetwear for
                    teens and young adults. Simple tees, tough joggers, oversized hoodies—designed for real
                    life. We blend fresh street style with timeless basics that actually last.
                </p>
                <p class="mb-4 about-reveal about-reveal--delay-2">Our pieces bridge the gap between hype and everyday. Hoodies soft enough for Netflix
                    marathons, joggers flexible for skate sessions, tees that survive endless washes. We source
                    sustainable cottons and recycled blends, partner with ethical factories, and obsess over
                    details like reinforced stitching and perfect sleeve drops. Birmingham grit meets global
                    streetwear standards—affordable drip that actually lasts.
                </p>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="mb-3 about-reveal">Our Mission</h5>
                        <p class="mb-3 about-reveal about-reveal--delay-1">We exist to make quality streetwear accessible to everyone. No logos screaming for
                            attention, no trends that die in a month—just honest garments that let your style speak.
                            Every stitch prioritises comfort, durability, and that perfect fit you feel good in from
                            the first wear. Simple. Real. Yours.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3 about-reveal about-reveal--delay-1">Our Vision</h5>
                        <p class="mb-3 about-reveal about-reveal--delay-2">A world where young people dress with confidence, not compromise. We see a future where
                            sustainable materials are standard, fair wages are non-negotiable, and every piece in your
                            wardrobe tells your story—not a factory's. Drip & Co leads by staying true: quality over
                            quantity, community over corporations, creativity over conformity.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mw-930 d-lg-flex align-items-lg-center">
                <div class="image-wrapper col-lg-6 about-reveal">
                    <img class="h-auto w-100" loading="lazy" src="{{ asset('assets/images/about/about-2.png') }}"
                        width="450" height="500" alt="">
                </div>
                <div class="content-wrapper col-lg-6 px-lg-4 about-reveal about-reveal--delay-1">
                    <h5 class="mb-3">The Company</h5>
                    <p class="mb-0">Launched in 2025 from a Birmingham garage, Drip & Co now ships UK-wide with warehouses optimised
                        for next-day delivery. Our team handpicks every fabric and approves every print. We partner with ethical manufacturers who prioritise worker
                        safety and environmental responsibility. 100% UK-based operations. 80% sustainable materials. 100% obsessed with getting it right.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
    <style>
        .page-about .about-reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }

        .page-about .about-reveal.about-reveal--delay-1 {
            transition-delay: 0.08s;
        }

        .page-about .about-reveal.about-reveal--delay-2 {
            transition-delay: 0.16s;
        }

        .page-about .about-reveal.is-inview {
            opacity: 1;
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            .page-about .about-reveal {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
                will-change: auto;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.querySelectorAll('.page-about .about-reveal').forEach(function(el) {
                    el.classList.add('is-inview');
                });
                return;
            }

            var nodes = document.querySelectorAll('.page-about .about-reveal');
            if (!nodes.length || !('IntersectionObserver' in window)) {
                nodes.forEach(function(el) {
                    el.classList.add('is-inview');
                });
                return;
            }

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-inview');
                    } else {
                        entry.target.classList.remove('is-inview');
                    }
                });
            }, {
                root: null,
                rootMargin: '0px 0px -6% 0px',
                threshold: 0.06
            });

            nodes.forEach(function(el) {
                observer.observe(el);
            });
        })();
    </script>
@endpush
