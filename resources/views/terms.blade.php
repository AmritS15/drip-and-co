@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="container pb-5 mb-5">
        <div class="mw-930 legal-page">
            <h1 class="page-title">Terms &amp; Conditions</h1>
            <p class="text-secondary mb-4">Last updated: March 2026</p>

            <h2 class="h4 mt-4">1. Introduction</h2>
            <p class="fs-6">These terms and conditions ("Terms") govern your use of the Drip&amp;Co website at www.dripandco.com ("Site") and any purchases made through it. By accessing the Site or placing an order, you agree to be bound by these Terms. Please read them carefully before using our Site. If you do not agree, please do not use our Site.</p>
            <p class="fs-6">Drip&amp;Co is a trading name of Drip and Co Ltd, registered in England and Wales (Company No. XXXXXXXX), with a registered address at 14 Drip Drive, Dripstone City, UK B4 7ET.</p>

            <h2 class="h4 mt-4">2. Eligibility</h2>
            <p class="fs-6">You must be at least 18 years old to place an order on our Site. By placing an order, you confirm that you meet this requirement. We reserve the right to cancel any order where we believe this condition has not been met.</p>

            <h2 class="h4 mt-4">3. Orders &amp; Contract Formation</h2>
            <p class="fs-6">When you place an order, you are making an offer to purchase goods from us. A contract is only formed when we send you an order confirmation email. We reserve the right to decline or cancel any order at our discretion — for example, due to stock unavailability, pricing errors, or suspected fraudulent activity. If we cancel an order after payment has been taken, a full refund will be issued promptly.</p>
            <p class="fs-6">All orders are subject to product availability. We cannot guarantee that items displayed on the Site are in stock at the time of your order.</p>

            <h2 class="h4 mt-4">4. Pricing &amp; Payment</h2>
            <p class="fs-6">All prices are displayed in British Pounds Sterling (GBP) and are inclusive of VAT where applicable. Prices are subject to change without notice, but changes will not affect orders already confirmed. We accept payment via [Visa, Mastercard, PayPal, etc.]. Payment is taken at the point of order. We use secure third-party payment processors and do not store your full card details.</p>

            <h2 class="h4 mt-4">5. Delivery</h2>
            <p class="fs-6">We aim to dispatch orders within 5 working days. Delivery times are estimates and not guaranteed. We are not responsible for delays caused by third-party couriers or circumstances beyond our control. Risk of loss or damage to goods passes to you upon delivery. For full details, please see our <a href="/delivery">Delivery Policy</a>.</p>

            <h2 class="h4 mt-4">6. Returns &amp; Refunds</h2>
            <p class="fs-6">Under the Consumer Contracts Regulations 2013, you have the right to cancel your order within 14 days of receiving your goods, without giving a reason. To exercise this right, please contact us at returns@dripandco.com. Items must be returned in their original, unworn, and unwashed condition with tags attached. We reserve the right to refuse a refund on items that do not meet these conditions. For full details, please see our <a href="/returns">Returns Policy</a>.</p>

            <h2 class="h4 mt-4">7. Product Descriptions</h2>
            <p class="fs-6">We make every effort to ensure that product images, colours, and descriptions are accurate. However, we cannot guarantee that your screen's display of colours will be entirely accurate. Minor variations in appearance do not constitute a defect and do not entitle you to a refund.</p>

            <h2 class="h4 mt-4">8. Intellectual Property</h2>
            <p class="fs-6">All content on this Site — including but not limited to text, images, logos, graphics, and product designs — is the property of Drip&amp;Co or its licensors and is protected by copyright and other intellectual property laws. You may not reproduce, distribute, or use any content from this Site without our prior written consent.</p>

            <h2 class="h4 mt-4">9. User Conduct</h2>
            <p class="fs-6">You agree not to use our Site for any unlawful purpose, to transmit any harmful or offensive material, to attempt to gain unauthorised access to any part of our systems, or to engage in any conduct that could damage, disable, or impair the Site.</p>

            <h2 class="h4 mt-4">10. Privacy &amp; Cookies</h2>
            <p class="fs-6">Your use of our Site is also governed by our <a href="{{ route('home.privacy') }}">Privacy Policy</a> and <a href="/cookies">Cookie Policy</a>, which are incorporated into these Terms by reference. By using our Site, you consent to the processing of your personal data as described therein.</p>

            <h2 class="h4 mt-4">11. Limitation of Liability</h2>
            <p class="fs-6">To the fullest extent permitted by applicable law, Drip&amp;Co shall not be liable for any indirect, incidental, special, or consequential loss or damage arising out of or in connection with your use of the Site or purchase of goods. Our total liability to you in respect of any claim shall not exceed the total price paid for the goods in question. Nothing in these Terms limits our liability for death or personal injury caused by negligence, fraud, or any other liability that cannot be excluded by law.</p>

            <h2 class="h4 mt-4">12. Disclaimer of Warranties</h2>
            <p class="fs-6">Our Site and its content are provided on an "as is" and "as available" basis. We make no warranty that the Site will be uninterrupted, error-free, or free of viruses or other harmful components. We reserve the right to suspend, withdraw, or modify the Site at any time without notice.</p>

            <h2 class="h4 mt-4">13. Third-Party Links</h2>
            <p class="fs-6">Our Site may contain links to third-party websites. These links are provided for your convenience only. We have no control over the content of those sites and accept no responsibility for them or for any loss or damage that may arise from your use of them.</p>

            <h2 class="h4 mt-4">14. Changes to These Terms</h2>
            <p class="fs-6">We reserve the right to update or amend these Terms at any time. The most current version will always be available on this page. Continued use of our Site following any changes constitutes your acceptance of the revised Terms.</p>

            <h2 class="h4 mt-4">15. Governing Law &amp; Disputes</h2>
            <p class="fs-6">These Terms are governed by and construed in accordance with the laws of England and Wales. Any disputes arising under or in connection with these Terms shall be subject to the exclusive jurisdiction of the courts of England and Wales. If you are a consumer, you may also be entitled to use the EU Online Dispute Resolution platform or contact your local trading standards office.</p>

            <h2 class="h4 mt-4">16. Contact Us</h2>
            <p class="fs-6">If you have any questions about these Terms, please contact us at:</p>
            <p class="fs-6 mb-0">
                Drip&amp;Co<br>
                [Address Line 1]<br>
                [City, Postcode]<br>
                Email: hello@dripandco.com<br>
                Phone: [+44 XXXX XXXXXX]
            </p>
        </div>
    </section>
</main>
@endsection
