@extends('layouts.app')

@section('title', 'Privacy Policy - Aura Cabinets')

@section('styles')
<style>
    /* Privacy page specific styles */
    body {
        background-color: #F8F7F4; /* Lightest brown background */
        display: flex;
        flex-direction: column;
    }
    main {
        flex-grow: 1; 
    }
    
    /* Styles for the legal text content */
    .policy-content h2 {
        font-size: 1.5rem; /* 24px */
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #EAEAEA;
    }
     .policy-content h3 {
        font-size: 1.25rem; /* 20px */
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
    .policy-content p {
        line-height: 1.75;
        margin-bottom: 1rem;
    }
    .policy-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .policy-content li {
        margin-bottom: 0.5rem;
    }
    .policy-content a {
        color: #E86A33; /* Accent color */
        text-decoration: underline;
    }
    .policy-content a:hover {
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<main class="bg-white py-12 md:py-20">
    <div class="max-w-4xl mx-auto px-6 md:px-10">
        <h1 class="text-4xl md:text-5xl font-light text-center">Privacy Policy</h1>
        <p class="text-center text-gray-500 mt-2">Last Updated: July 25, 2025</p>

        <div class="policy-content text-gray-700 mt-12">
            <p>Aura Cabinets ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how your personal information is collected, used, and disclosed by Aura Cabinets. This Privacy Policy applies to our website, and its associated subdomains (collectively, our "Service") alongside our application, Aura Cabinets. By accessing or using our Service, you signify that you have read, understood, and agree to our collection, storage, use, and disclosure of your personal information as described in this Privacy Policy and our Terms of Service.</p>

            <h2>1. Information We Collect</h2>
            <p>We collect information from you when you visit our website, place an order, subscribe to our newsletter, respond to a survey or fill out a form.</p>
            <ul>
                <li><strong>Personal Identification Information:</strong> Name, email address, mailing address, phone number, credit card information.</li>
                <li><strong>Order Information:</strong> Details about the products you purchase, order history, and shipping information.</li>
                <li><strong>Technical Data:</strong> IP address, browser type and version, time zone setting and location, browser plug-in types and versions, operating system and platform, and other technology on the devices you use to access this website.</li>
                <li><strong>Usage Data:</strong> Information about how you use our website, products, and services.</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <p>Any of the information we collect from you may be used in one of the following ways:</p>
            <ul>
                <li><strong>To process transactions:</strong> Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.</li>
                <li><strong>To personalize your experience:</strong> Your information helps us to better respond to your individual needs.</li>
                <li><strong>To improve our website:</strong> We continually strive to improve our website offerings based on the information and feedback we receive from you.</li>
                <li><strong>To improve customer service:</strong> Your information helps us to more effectively respond to your customer service requests and support needs.</li>
                <li><strong>To send periodic emails:</strong> The email address you provide for order processing may be used to send you information and updates pertaining to your order, in addition to receiving occasional company news, updates, related product or service information, etc.</li>
            </ul>

            <h2>3. How We Protect Your Information</h2>
            <p>We implement a variety of security measures to maintain the safety of your personal information when you place an order or enter, submit, or access your personal information. We offer the use of a secure server. All supplied sensitive/credit information is transmitted via Secure Socket Layer (SSL) technology and then encrypted into our Payment gateway providers database only to be accessible by those authorized with special access rights to such systems, and are required to keep the information confidential.</p>

            <h2>4. Do We Use Cookies?</h2>
            <p>Yes. Cookies are small files that a site or its service provider transfers to your computer's hard drive through your Web browser (if you allow) that enables the sites or service providers systems to recognize your browser and capture and remember certain information. We use cookies to help us remember and process the items in your shopping cart, understand and save your preferences for future visits and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>
            
            <h2>5. Do We Disclose Any Information to Outside Parties?</h2>
            <p>We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others' rights, property, or safety.</p>

            <h2>6. Your Rights</h2>
            <p>Depending on your location, you may have the following rights regarding your personal information:</p>
            <ul>
                <li>The right to access – You have the right to request copies of your personal data.</li>
                <li>The right to rectification – You have the right to request that we correct any information you believe is inaccurate.</li>
                <li>The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</li>
                <li>The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</li>
            </ul>
            <p>To exercise these rights, please contact us using the contact information below.</p>
            
            <h2>7. Changes to Our Privacy Policy</h2>
            <p>If we decide to change our privacy policy, we will post those changes on this page, and/or update the Privacy Policy modification date at the top of this page. We encourage you to periodically review this page for the latest information on our privacy practices.</p>

            <h2>8. Contacting Us</h2>
            <p>If there are any questions regarding this privacy policy, you may contact us using the information below:</p>
            <p>
                <strong>Aura Cabinets</strong><br>
                123 Design Avenue<br>
                New York, NY 10001<br>
                Email: <a href="mailto:privacy@aura.com">privacy@aura.com</a>
            </p>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();
});
</script>
@endsection 