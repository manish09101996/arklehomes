@extends('layouts.app')

@section('content')

    <section class="page-banner" style="background-image: url('{{ asset('images/hero/hero-facade.jpg') }}');">
        <div class="page-banner-overlay"></div>
        <div class="container">
            <div class="page-banner-content">
                <span class="eyebrow eyebrow-dark">GET IN TOUCH</span>
                <h1>{{ $page->title ?? 'Contact Us' }}</h1>
                <p>{{ $page->subtitle ?? 'Speak directly with our principal builder today to discuss your new custom home.' }}</p>
            </div>
        </div>
    </section>

    <section class="section section-cream">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1.25fr; gap: 60px;">
                
                <!-- Left: Contact Details -->
                <div>
                    <span class="eyebrow">HEAD OFFICE</span>
                    <h2 class="section-title" style="font-size: 2.2rem; margin-bottom: 24px;">Start Your Conversation</h2>
                    <p style="font-size: 1.02rem; line-height: 1.8; color: var(--color-text-muted); margin-bottom: 36px;">
                        Whether you are looking to build a bespoke luxury residence, construct multi-unit townhouses, or embark on a major architectural renovation, we welcome your enquiry.
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 24px; margin-bottom: 40px;">
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--color-gold); color: #0c1b23; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <strong style="display: block; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted);">Office Location</strong>
                                <span style="font-size: 1.05rem; font-weight: 600; color: var(--color-navy-dark);">{{ setting('site_address', '240 Emmersons Road Lovely Banks 3213') }}</span>
                            </div>
                        </div>

                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--color-gold); color: #0c1b23; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div>
                                <strong style="display: block; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted);">Direct Phone</strong>
                                <a href="tel:{{ format_phone(setting('site_phone', '0430 331 187')) }}" style="font-size: 1.05rem; font-weight: 600; color: var(--color-navy-dark);">
                                    {{ setting('site_phone', '0430 331 187') }}
                                </a>
                            </div>
                        </div>

                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--color-gold); color: #0c1b23; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div>
                                <strong style="display: block; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted);">Email Address</strong>
                                <a href="mailto:{{ setting('site_email', 'sean@arklehomes.com.au') }}" style="font-size: 1.05rem; font-weight: 600; color: var(--color-navy-dark);">
                                    {{ setting('site_email', 'sean@arklehomes.com.au') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps Embed -->
                    <div style="border-radius: 6px; overflow: hidden; height: 240px; border: 1px solid var(--color-border); box-shadow: var(--shadow-soft);">
                        <iframe src="{{ setting('google_maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100412.3918579493!2d144.29656461937965!3d-38.077271896796334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad416fef464d1f5%3A0x5045675218cd1d0!2sLovely%20Banks%20VIC%203213%2C%20Australia!5e0!3m2!1sen!2sau!4v1700000000000!5m2!1sen!2sau') }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div>
                    <div style="background: #FFFFFF; padding: 40px; border-radius: 8px; border: 1px solid var(--color-border); box-shadow: var(--shadow-card);">
                        <h3 style="font-family: var(--font-serif); font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 24px;">Send an Enquiry</h3>

                        <div id="formAlert" style="display: none;"></div>

                        <form id="contactForm" action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            
                            <!-- Honeypot -->
                            <div style="display: none;">
                                <input type="text" name="website_url" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="clientName" class="form-label">Full Name *</label>
                                <input type="text" id="clientName" name="name" class="form-control" placeholder="e.g. Sarah Jenkins" required>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div class="form-group">
                                    <label for="clientEmail" class="form-label">Email Address *</label>
                                    <input type="email" id="clientEmail" name="email" class="form-control" placeholder="name@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="clientPhone" class="form-label">Phone Number</label>
                                    <input type="tel" id="clientPhone" name="phone" class="form-control" placeholder="0400 000 000">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="projectType" class="form-label">Project Type</label>
                                <select id="projectType" name="project_type" class="form-control">
                                    <option value="Custom Home">New Custom Home</option>
                                    <option value="Townhouse Development">Townhouse / Multi-Unit Development</option>
                                    <option value="Luxury Renovation">Architectural Renovation / Extension</option>
                                    <option value="Interior Architecture">Interior Architecture & Joinery</option>
                                    <option value="General Enquiry">General Consultation</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="clientMessage" class="form-label">Tell Us About Your Project *</label>
                                <textarea id="clientMessage" name="message" class="form-control" placeholder="Share your site location, anticipated timeline, architectural ideas or budget..." required></textarea>
                            </div>

                            <button type="submit" id="submitBtn" class="btn btn-gold" style="width: 100%; padding: 16px;">
                                Submit Enquiry &rarr;
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
