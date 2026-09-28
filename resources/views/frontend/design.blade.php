@extends('layouts.app')

@section('content')

    <!-- Banner -->
    <section class="page-banner" style="background-image: url('{{ asset('images/hero/hero-facade.jpg') }}');">
        <div class="page-banner-overlay"></div>
        <div class="container">
            <div class="page-banner-content">
                <span class="eyebrow eyebrow-dark">OUR ARCHITECTURAL PHILOSOPHY</span>
                <h1>{{ $page->title }}</h1>
                <p>{{ $page->subtitle }}</p>
            </div>
        </div>
    </section>

    <!-- Philosophy Core -->
    <section class="section section-cream">
        <div class="container">
            <div class="about-grid">
                <div class="about-text-content">
                    <span class="eyebrow">THE PHILOSOPHY</span>
                    <h2 class="section-title">Form, Function & Light in Perfect Equilibrium</h2>
                    <div style="font-size: 1.05rem; line-height: 1.8; color: var(--color-text-muted); margin-bottom: 24px;">
                        {!! $page->content !!}
                    </div>
                    <p style="font-size: 1.05rem; line-height: 1.8; color: var(--color-text-muted);">
                        We believe that modern Australian architecture must respond intimately to its natural surroundings. Whether harnessing northern light to naturally illuminate open-plan living rooms or selecting durable timber and render that age gracefully, our designs are conceived for lifetime resilience.
                    </p>
                </div>

                <div class="about-image-wrapper">
                    <img src="{{ asset('images/hero/hero-facade.jpg') }}" alt="Arkle Homes Architectural Facade">
                </div>
            </div>
        </div>
    </section>

    <!-- Pillars of Design -->
    <section class="section section-white">
        <div class="container">
            <div class="section-header text-center">
                <span class="eyebrow eyebrow-center">OUR PILLARS</span>
                <h2 class="section-title">Pillars of Architectural Distinction</h2>
                <p class="section-subtitle" style="margin: 0 auto;">Every blueprint balances aesthetic refinement with functional longevity.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; margin-top: 50px;">
                <div style="background: var(--color-cream-bg); padding: 36px 30px; border-radius: 6px; border: 1px solid var(--color-border);">
                    <div style="color: var(--color-gold); margin-bottom: 16px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                    </div>
                    <h3 style="font-family: var(--font-serif); font-size: 1.35rem; margin-bottom: 12px;">Passive Solar & Orientation</h3>
                    <p style="font-size: 0.94rem; color: var(--color-text-muted); line-height: 1.7;">
                        Maximizing natural winter sun while buffering harsh summer heat. Our site layouts prioritize orientation to minimize ongoing energy costs and create airy, sunlit spaces.
                    </p>
                </div>

                <div style="background: var(--color-cream-bg); padding: 36px 30px; border-radius: 6px; border: 1px solid var(--color-border);">
                    <div style="color: var(--color-gold); margin-bottom: 16px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <h3 style="font-family: var(--font-serif); font-size: 1.35rem; margin-bottom: 12px;">Premium Materiality</h3>
                    <p style="font-size: 0.94rem; color: var(--color-text-muted); line-height: 1.7;">
                        Natural stone, architectural brickwork, engineered European oak, and commercial-grade aluminum joinery that withstands Victoria’s diverse climatic conditions.
                    </p>
                </div>

                <div style="background: var(--color-cream-bg); padding: 36px 30px; border-radius: 6px; border: 1px solid var(--color-border);">
                    <div style="color: var(--color-gold); margin-bottom: 16px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
                        </svg>
                    </div>
                    <h3 style="font-family: var(--font-serif); font-size: 1.35rem; margin-bottom: 12px;">Sustainable Innovation</h3>
                    <p style="font-size: 0.94rem; color: var(--color-text-muted); line-height: 1.7;">
                        Exceeding Victorian 7-Star energy ratings through double and triple glazing, high-performance insulation envelopes, rainwater retention, and heat-pump hot water.
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection
