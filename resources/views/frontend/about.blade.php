@extends('layouts.app')

@section('content')

    <!-- Banner -->
    <section class="page-banner" style="background-image: url('{{ asset($page->hero_image ? 'storage/' . $page->hero_image : 'images/about/about-kitchen.jpg') }}');">
        <div class="page-banner-overlay"></div>
        <div class="container">
            <div class="page-banner-content">
                <span class="eyebrow eyebrow-dark">{{ $page->hero_badge ?? 'OUR HERITAGE & VISION' }}</span>
                <h1>{{ $page->title }}</h1>
                <p>{{ $page->subtitle }}</p>
            </div>
        </div>
    </section>

    <!-- The Arkle Story -->
    <section class="section section-cream">
        <div class="container">
            <div class="about-grid">
                <div class="about-text-content">
                    <span class="eyebrow">OUR STORY</span>
                    <h2 class="section-title">Built on Trust, Crafted for Generations</h2>
                    <div style="font-size: 1.05rem; line-height: 1.8; color: var(--color-text-muted);">
                        {!! $page->content !!}
                    </div>
                </div>

                <div class="about-image-wrapper">
                    <img src="{{ asset('images/about/about-kitchen.jpg') }}" alt="Arkle Homes Luxury Build">
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="section section-white">
        <div class="container">
            <div class="section-header text-center">
                <span class="eyebrow eyebrow-center">CORE VALUES</span>
                <h2 class="section-title">The Principles Guiding Every Build</h2>
                <p class="section-subtitle" style="margin: 0 auto;">We hold our workmanship to the highest benchmark in Victorian residential construction.</p>
            </div>

            <div class="services-grid" style="margin-top: 40px;">
                @foreach($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Step-by-Step Building Process -->
    <section class="section section-cream">
        <div class="container">
            <div class="section-header text-center">
                <span class="eyebrow eyebrow-center">OUR PROCESS</span>
                <h2 class="section-title">From Concept to Handover</h2>
                <p class="section-subtitle" style="margin: 0 auto;">A transparent, collaborative journey designed to provide total peace of mind.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-top: 40px;">
                <div style="background: #fff; padding: 30px; border-radius: 6px; border: 1px solid var(--color-border);">
                    <div style="font-family: var(--font-serif); font-size: 2.2rem; color: var(--color-gold); font-weight: 700; margin-bottom: 8px;">01</div>
                    <h4 style="font-family: var(--font-serif); font-size: 1.25rem; margin-bottom: 10px;">Discovery & Site Assessment</h4>
                    <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6;">We analyze your site topography, solar orientation, and discuss your lifestyle requirements and budget parameters.</p>
                </div>

                <div style="background: #fff; padding: 30px; border-radius: 6px; border: 1px solid var(--color-border);">
                    <div style="font-family: var(--font-serif); font-size: 2.2rem; color: var(--color-gold); font-weight: 700; margin-bottom: 8px;">02</div>
                    <h4 style="font-family: var(--font-serif); font-size: 1.25rem; margin-bottom: 10px;">Architectural Concept Design</h4>
                    <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6;">Collaborate on detailed floor plans, 3D visualizations, material selections, and passive thermal considerations.</p>
                </div>

                <div style="background: #fff; padding: 30px; border-radius: 6px; border: 1px solid var(--color-border);">
                    <div style="font-family: var(--font-serif); font-size: 2.2rem; color: var(--color-gold); font-weight: 700; margin-bottom: 8px;">03</div>
                    <h4 style="font-family: var(--font-serif); font-size: 1.25rem; margin-bottom: 10px;">Fixed-Price Contract & Permits</h4>
                    <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6;">Complete transparency with a detailed Master Builders contract. We coordinate engineering, energy ratings, and council permits.</p>
                </div>

                <div style="background: #fff; padding: 30px; border-radius: 6px; border: 1px solid var(--color-border);">
                    <div style="font-family: var(--font-serif); font-size: 2.2rem; color: var(--color-gold); font-weight: 700; margin-bottom: 8px;">04</div>
                    <h4 style="font-family: var(--font-serif); font-size: 1.25rem; margin-bottom: 10px;">Construction & Handover</h4>
                    <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6;">Supervised daily by principal builder Sean with continuous progress updates, leading to a flawless key handover.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
