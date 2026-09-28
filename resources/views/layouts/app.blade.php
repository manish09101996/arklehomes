<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $seo->meta_title ?? setting('site_name', 'Arkle Homes') . ' | ' . setting('site_tagline', 'Designed for Living. Built for Life.') }}</title>
    <meta name="description" content="{{ $seo->meta_description ?? setting('footer_description', 'Bespoke architectural home builder in Victoria.') }}">
    @if(!empty($seo->meta_keywords))
        <meta name="keywords" content="{{ $seo->meta_keywords }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seo->meta_title ?? setting('site_name') }}">
    <meta property="og:description" content="{{ $seo->meta_description ?? setting('footer_description') }}">
    <meta property="og:image" content="{{ !empty($seo->og_image) ? asset($seo->og_image) : asset(setting('hero_bg_image', 'images/hero/hero-facade.jpg')) }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset(setting('site_logo', 'images/logo/arkle-homes-logo.png')) }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/arkle-theme.css') }}">

    @stack('styles')
</head>
<body>

    <!-- Header Navigation -->
    <header class="header-main @if(!Request::is('/')) sticky @endif">
        <div class="container">
            <div class="nav-container">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo-badge" title="Arkle Homes">
                    <img src="{{ asset(setting('site_logo', 'images/logo/arkle-homes-logo.png')) }}" alt="Arkle Homes Logo">
                </a>

                <!-- Desktop Nav Menu -->
                <nav>
                    <ul class="nav-menu">
                        @if(isset($headerNavItems) && $headerNavItems->isNotEmpty())
                            @foreach($headerNavItems as $item)
                                <li>
                                    <a href="{{ $item->formatted_url }}" 
                                       target="{{ $item->target }}" 
                                       class="nav-link {{ Request::is(trim($item->url, '/')) || (Request::is('/') && $item->url === '/') ? 'active' : '' }}">
                                        {{ $item->label }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li><a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                            <li><a href="{{ route('about') }}" class="nav-link {{ Request::is('about') ? 'active' : '' }}">About</a></li>
                            <li><a href="{{ route('design') }}" class="nav-link {{ Request::is('design') ? 'active' : '' }}">Design</a></li>
                            <li><a href="{{ route('projects.index') }}" class="nav-link {{ Request::is('projects*') ? 'active' : '' }}">Projects</a></li>
                            <li><a href="{{ route('testimonials') }}" class="nav-link {{ Request::is('testimonials') ? 'active' : '' }}">Testimonials</a></li>
                            <li><a href="{{ route('contact') }}" class="nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a></li>
                        @endif
                    </ul>
                </nav>

                <!-- Header CTA Button & Hamburger -->
                <div class="nav-cta">
                    <a href="{{ safe_url(setting('header_cta_url', '/contact')) }}" class="btn btn-gold btn-sm">
                        {{ setting('header_cta_text', 'Get in Touch') }} &rarr;
                    </a>

                    <button class="mobile-toggle" aria-label="Open mobile menu">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div class="drawer-backdrop"></div>
    <div class="mobile-nav-drawer">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <img src="{{ asset(setting('site_logo', 'images/logo/arkle-homes-logo.png')) }}" alt="Arkle Homes" style="height: 50px;">
                <button class="drawer-close" style="background: none; border: none; color: #fff; font-size: 28px; cursor: pointer;">&times;</button>
            </div>
            <ul class="mobile-links">
                <li><a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('about') }}" class="{{ Request::is('about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('design') }}" class="{{ Request::is('design') ? 'active' : '' }}">Design</a></li>
                <li><a href="{{ route('projects.index') }}" class="{{ Request::is('projects*') ? 'active' : '' }}">Projects</a></li>
                <li><a href="{{ route('testimonials') }}" class="{{ Request::is('testimonials') ? 'active' : '' }}">Testimonials</a></li>
                <li><a href="{{ route('faq') }}" class="{{ Request::is('faq') ? 'active' : '' }}">FAQ</a></li>
                <li><a href="{{ route('contact') }}" class="{{ Request::is('contact') ? 'active' : '' }}">Contact</a></li>
            </ul>
        </div>
        <div>
            <a href="{{ safe_url(setting('header_cta_url', '/contact')) }}" class="btn btn-gold" style="width: 100%;">
                {{ setting('header_cta_text', 'Get in Touch') }} &rarr;
            </a>
            <div style="margin-top: 18px; color: var(--color-text-muted); font-size: 0.85rem; text-align: center;">
                Call: <a href="tel:{{ format_phone(setting('site_phone', '0430 331 187')) }}" style="color: var(--color-gold);">{{ setting('site_phone', '0430 331 187') }}</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Global CTA Banner (if requested) -->
    @if(!isset($hideCtaBanner) || !$hideCtaBanner)
        <section class="section section-cream" style="padding-top: 40px; padding-bottom: 70px;">
            <div class="container">
                <div class="cta-banner">
                    <div>
                        <h2>{{ setting('cta_title', 'Ready to Create Your Legacy?') }}</h2>
                        <p>{{ setting('cta_description', 'Partner with Arkle Homes to build a timeless residence tailored specifically to your family and lifestyle.') }}</p>
                    </div>
                    <div>
                        <a href="{{ safe_url(setting('cta_btn_url', '/contact')) }}" class="btn btn-gold" style="padding: 16px 36px; font-size: 1rem;">
                            {{ setting('cta_btn_text', 'Start Your Project') }} &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Footer -->
    <footer class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Col 1: Logo & Mission -->
                <div>
                    <div class="footer-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset(setting('site_logo', 'images/logo/arkle-homes-logo.png')) }}" alt="Arkle Homes">
                        </a>
                    </div>
                    <p class="footer-about">
                        {{ setting('footer_description', 'Creating homes of architectural distinction where timeless design meets modern living.') }}
                    </p>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="footer-heading">Quick Links</h4>
                    <ul class="footer-links">
                        @if(isset($footerQuickLinks) && $footerQuickLinks->isNotEmpty())
                            @foreach($footerQuickLinks as $item)
                                <li>
                                    <a href="{{ $item->formatted_url }}" target="{{ $item->target }}">{{ $item->label }}</a>
                                </li>
                            @endforeach

                        @else
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('design') }}">Design Philosophy</a></li>
                            <li><a href="{{ route('projects.index') }}">Projects</a></li>
                            <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Col 3: Contact Info -->
                <div>
                    <h4 class="footer-heading">Contact</h4>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>{{ setting('site_address', '240 Emmersons Road Lovely Banks 3213') }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <a href="tel:{{ format_phone(setting('site_phone', '0430 331 187')) }}" style="color: inherit;">
                            {{ setting('site_phone', '0430 331 187') }}
                        </a>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <a href="mailto:{{ setting('site_email', 'sean@arklehomes.com.au') }}" style="color: inherit;">
                            {{ setting('site_email', 'sean@arklehomes.com.au') }}
                        </a>
                    </div>
                </div>

                <!-- Col 4: Follow Us -->
                <div>
                    <h4 class="footer-heading">Follow Us</h4>
                    <div class="social-links">
                        <a href="{{ setting('facebook_url', 'https://facebook.com') }}" target="_blank" rel="noopener noreferrer" class="social-circle" aria-label="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="{{ setting('instagram_url', 'https://instagram.com') }}" target="_blank" rel="noopener noreferrer" class="social-circle" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="{{ setting('linkedin_url', 'https://linkedin.com') }}" target="_blank" rel="noopener noreferrer" class="social-circle" aria-label="LinkedIn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"></path>
                                <circle cx="4" cy="4" r="2"></circle>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div>
                    {{ setting('footer_copyright', '© ' . date('Y') . ' Arkle Homes. All rights reserved.') }}
                </div>
                <div>
                    <a href="{{ route('privacy') }}">Privacy Policy</a>
                    <span style="margin: 0 10px; opacity: 0.4;">|</span>
                    <a href="{{ route('terms') }}">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Video Modal -->
    <div id="videoModal" class="video-modal">
        <button class="video-modal-close" style="position: absolute; top: 25px; right: 30px; color: #fff; font-size: 32px; background: none; border: none; cursor: pointer;">&times;</button>
        <div class="video-wrapper">
            <iframe id="videoModalIframe" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <!-- Lightbox Modal for Galleries -->
    <div id="lightboxModal" class="lightbox-modal">
        <button class="lightbox-close">&times;</button>
        <button class="lightbox-nav lightbox-prev" aria-label="Previous image">&#10094;</button>
        <img id="lightboxImage" class="lightbox-image" src="" alt="Gallery Preview">
        <button class="lightbox-nav lightbox-next" aria-label="Next image">&#10095;</button>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/arkle-frontend.js') }}"></script>
    @stack('scripts')
</body>
</html>
