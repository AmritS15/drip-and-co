@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="container pb-5 mb-5">
        <div class="mw-930 legal-page">
            <h1 class="page-title">Accessibility</h1>
            <p class="text-secondary mb-4">Last updated: March 2026</p>

            <h2 class="h4 mt-4">Our commitment</h2>
            <p class="fs-6">Drip&amp;Co wants everyone who shops with us — including people with disabilities — to be able to use our website and find what they need. We are working to improve accessibility over time and welcome your feedback when something does not work well for you.</p>

            <h2 class="h4 mt-4">What we aim for</h2>
            <p class="fs-6">We design and update dripandco.com with accessibility in mind, including:</p>
            <ul class="fs-6">
                <li>Clear structure and headings so pages are easier to navigate with a keyboard or assistive technology.</li>
                <li>Readable text and sufficient contrast where we control colours and typography.</li>
                <li>Meaningful labels on forms and controls so checkout and account tasks are easier to complete.</li>
                <li>Descriptive text for images where it helps users who rely on screen readers.</li>
            </ul>
            <p class="fs-6">We do not claim perfect conformance with every standard on every page at all times, but accessibility is part of how we think about the site.</p>

            <h2 class="h4 mt-4">Adjustments on your device</h2>
            <p class="fs-6">You can often improve your experience without changing our site:</p>
            <ul class="fs-6">
                <li>Use your browser’s zoom to enlarge text.</li>
                <li>Use built-in or third-party screen readers, voice control, or keyboard navigation.</li>
                <li>Adjust contrast or text size in your operating system settings.</li>
            </ul>
            <p class="fs-6">Our site includes a light/dark theme option where available; choose whichever is more comfortable for you.</p>

            <h2 class="h4 mt-4">Third-party content</h2>
            <p class="fs-6">Some parts of our service (for example payment providers or embedded media) are provided by third parties. We choose partners carefully, but we cannot fully control how their interfaces behave. If you hit a barrier in checkout or elsewhere, tell us and we will do our best to help or suggest an alternative.</p>

            <h2 class="h4 mt-4">Feedback and help</h2>
            <p class="fs-6">If you have difficulty using any part of Drip&amp;Co’s website, or if you have suggestions on how we can improve accessibility, please contact us. We take reports seriously and will try to respond promptly.</p>
            <p class="fs-6 mb-0">You can reach us via our <a href="{{ route('home.contact') }}">Contact Us</a> page. Please describe the page or feature you were using and what would make it easier for you to use — that helps us prioritise fixes.</p>
        </div>
    </section>
</main>
@endsection
