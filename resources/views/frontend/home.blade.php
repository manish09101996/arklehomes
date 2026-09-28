@extends('layouts.app')

@section('content')

    <!-- =========================================================================
         SECTION 1: HERO
         ========================================================================= -->
    <section class="hero-section" style="background-image: url('{{ asset(setting('hero_bg_image', 'images/hero/hero-facade.jpg')) }}');">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <span class="hero-eyebrow">{{ setting('hero_eyebrow', 'CUSTOM HOMES | TOWNHOUSES | RENOVATIONS') }}</span>
                    <h1 class="hero-heading">
                        {{ setting('hero_heading_1', 'Designed for Living.') }}
                        <span class="gold">{{ setting('hero_heading_2', 'Built for Life.') }}</span>
                    </h1>
                    <p class="hero-description">
                        {{ setting('hero_description', 'We create modern, functional and timeless homes that reflect your lifestyle and stand the test of time.') }}
                    </p>
                    <div class="hero-actions">
                        <a href="{{ safe_url(setting('hero_btn_1_url', '/projects')) }}" class="btn btn-gold">
                            {{ setting('hero_btn_1_text', 'Our Projects') }} &rarr;
                        </a>
                        <button type="button" class="btn btn-video" data-video-modal data-video-url="{{ setting('hero_video_url', 'https://www.youtube.com/embed/dQw4w9WgXcQ') }}">
                            <span class="play-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </span>
                            {{ setting('hero_btn_2_text', 'Watch Our Work') }}
                        </button>
                    </div>
                </div>

                <!-- Floating Credential Card (Bottom-Right of Hero) -->
                <div class="hero-floating-card">
                    <div class="hero-credential-item">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <span>Quality Construction</span>
                    </div>
                    <div class="hero-credential-item">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Modern Designs</span>
                    </div>
                    <div class="hero-credential-item">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Customer Focused</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         SECTION 2: ABOUT ARKLE HOMES & FEATURE SERVICES
         ========================================================================= -->
    <section class="section section-cream">
        <div class="container">
            <div class="about-grid">
                <div class="about-text-content">
                    <span class="eyebrow">{{ setting('about_eyebrow', 'ABOUT ARKLE HOMES') }}</span>
                    <h2 class="section-title">
                        {{ setting('about_heading', 'Crafting Timeless Spaces for Modern Living') }}
                    </h2>
                    <p class="about-paragraph">
                        {{ setting('about_description', 'At Arkle Homes, we combine innovative design, quality materials and expert craftsmanship to deliver homes that inspire. From concept to completion, we focus on every detail to create spaces that are beautiful, functional and built to last.') }}
                    </p>
                    <a href="{{ safe_url(setting('about_btn_url', '/about')) }}" class="btn btn-outline-dark">
                        {{ setting('about_btn_text', 'Learn More') }} &rarr;
                    </a>
                </div>

                <div class="about-image-wrapper">
                    <img src="{{ asset(setting('about_image', 'images/about/about-kitchen.jpg')) }}" alt="Arkle Homes Crafted Kitchen">
                </div>
            </div>

            <!-- 4 Circular Icon Feature Service Cards -->
            <div class="services-grid">
                @foreach($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- =========================================================================
         SECTION 3: FEATURED PROJECTS
         ========================================================================= -->
    <section class="section section-white">
        <div class="container">
            <div class="section-header flex-between">
                <div>
                    <span class="eyebrow">OUR WORK</span>
                    <h2 class="section-title">Featured Projects</h2>
                    <p class="section-subtitle">Explore a selection of our residential projects, each designed with care, precision and a focus on modern living.</p>
                </div>
                <div>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline-dark">
                        View All Projects &rarr;
                    </a>
                </div>
            </div>

            <div class="projects-grid">
                @forelse($featuredProjects as $project)
                    <x-project-card :project="$project" />
                @empty
                    <p>No featured projects available.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- =========================================================================
         SECTION 4: COMMITMENT / DARK CINEMATIC STATS
         ========================================================================= -->
    <section class="commitment-section" style="background-image: url('{{ asset(setting('commitment_bg', 'images/hero/commitment-bg.jpg')) }}');">
        <div class="commitment-overlay"></div>
        <div class="container">
            <div class="commitment-grid">
                <div class="commitment-text">
                    <span class="eyebrow eyebrow-dark">{{ setting('commitment_eyebrow', 'OUR COMMITMENT') }}</span>
                    <h2 class="section-title" style="color: #ffffff;">
                        {{ setting('commitment_heading', 'We Build More Than Homes') }}
                    </h2>
                    <p class="section-subtitle" style="color: var(--color-text-light);">
                        {{ setting('commitment_description', 'Every project is a partnership. We are committed to delivering exceptional quality, honest communication and homes that inspire for generations.') }}
                    </p>
                </div>

                <div class="stats-grid">
                    @foreach($statistics as $stat)
                        <div class="stat-item">
                            <div class="stat-icon">
                                @if($stat->icon === 'users')
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                @elseif($stat->icon === 'trophy')
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                        <path d="M4 22h16"></path>
                                        <path d="M10 14.66V17c0 .55-.45 1-1 1H8v2h8v-2h-1c-.55 0-1-.45-1-1v-2.34"></path>
                                        <path d="M18 4H6v7a6 6 0 0 0 12 0V4z"></path>
                                    </svg>
                                @else
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                @endif
                            </div>
                            <div class="stat-number">{{ $stat->number }}</div>
                            <div class="stat-label">{{ $stat->label }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         SECTION 5: TESTIMONIALS
         ========================================================================= -->
    <section class="section section-cream">
        <div class="container">
            <div class="section-header text-center">
                <span class="eyebrow eyebrow-center">TESTIMONIALS</span>
                <h2 class="section-title">What Our Clients Say</h2>
                <p class="section-subtitle" style="margin: 0 auto;">We take pride in building lasting relationships and homes our clients love.</p>
            </div>

            <div class="testimonials-grid">
                @foreach($testimonials as $t)
                    <x-testimonial-card :testimonial="$t" />
                @endforeach
            </div>
        </div>
    </section>

@endsection
