@extends('layouts.app')

@section('title', 'Contact Us - Aura Cabinets')

@section('styles')
<style>
    /* Contact page specific styles */
    body {
        background-color: #ffffff;
        display: flex;
        flex-direction: column;
    }
    main {
        flex-grow: 1; 
    }
    
    /* Form Input Styles */
    .form-input {
        background-color: transparent;
        border: 0;
        border-bottom: 1px solid #D1D5DB; /* gray-300 */
        padding: 0.75rem 0.25rem;
        transition: border-color 0.3s;
    }
    .form-input:focus {
        outline: none;
        border-bottom-color: #2D2D2D;
    }
</style>
@endsection

@section('content')
<main>
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-12 md:py-20">
        <!-- Page Header -->
        <div class="text-center mb-12 md:mb-20">
            <h1 class="text-4xl md:text-5xl font-light">Get in Touch</h1>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Have a question about our products, need help with a design, or just want to say hello? We'd love to hear from you.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
            <!-- Left Column: Contact Info & Form -->
            <div>
                <!-- Contact Info Blocks -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-12">
                    <div class="flex items-start">
                        <div class="bg-[#F8F7F4] p-3 rounded-lg mr-4">
                           <i data-lucide="phone" class="w-6 h-6 text-accent"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">Call Us</h3>
                            <p class="text-gray-600">Our design experts are here to help.</p>
                            <a href="tel:1-800-555-AURA" class="text-accent font-medium hover:underline">1-800-555-AURA</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                         <div class="bg-[#F8F7F4] p-3 rounded-lg mr-4">
                            <i data-lucide="mail" class="w-6 h-6 text-accent"></i>
                         </div>
                        <div>
                            <h3 class="font-semibold">Email Us</h3>
                            <p class="text-gray-600">Get in touch via email for any inquiries.</p>
                            <a href="mailto:hello@aura.com" class="text-accent font-medium hover:underline">hello@aura.com</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                         <div class="bg-[#F8F7F4] p-3 rounded-lg mr-4">
                            <i data-lucide="map-pin" class="w-6 h-6 text-accent"></i>
                         </div>
                        <div>
                            <h3 class="font-semibold">Our Showroom</h3>
                            <p class="text-gray-600">123 Design Lane,<br>New York, NY 10001</p>
                        </div>
                    </div>
                     <div class="flex items-start">
                         <div class="bg-[#F8F7F4] p-3 rounded-lg mr-4">
                            <i data-lucide="clock" class="w-6 h-6 text-accent"></i>
                         </div>
                        <div>
                            <h3 class="font-semibold">Business Hours</h3>
                            <p class="text-gray-600">Mon - Fri: 9am - 6pm<br>Sat: 10am - 4pm EST</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <form action="#" method="POST" class="space-y-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                       <div>
                            <label for="first-name" class="sr-only">First name</label>
                            <input type="text" name="first-name" id="first-name" placeholder="First Name" class="form-input w-full">
                       </div>
                       <div>
                            <label for="last-name" class="sr-only">Last name</label>
                            <input type="text" name="last-name" id="last-name" placeholder="Last Name" class="form-input w-full">
                       </div>
                    </div>
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email Address" class="form-input w-full">
                    </div>
                     <div>
                        <label for="subject" class="sr-only">Subject</label>
                        <input type="text" name="subject" id="subject" placeholder="Subject" class="form-input w-full">
                    </div>
                    <div>
                        <label for="message" class="sr-only">Message</label>
                        <textarea name="message" id="message" rows="4" placeholder="Your Message" class="form-input w-full resize-none"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full btn-minimal text-lg font-bold py-3 px-8 rounded-md">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Column: Map -->
            <div class="h-80 lg:h-full w-full rounded-2xl overflow-hidden shadow-lg">
                <!-- 
                    Replace this div with your actual Google Maps embed code.
                    Using a placeholder image for demonstration.
                -->
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1572021335469-31706a17aaef?q=80&w=2070&auto=format&fit=crop');">
                    
                </div>
            </div>
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