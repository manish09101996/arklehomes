@extends('layouts.app')

@section('content')

    <section class="page-banner" style="background-image: url('{{ asset('images/hero/hero-facade.jpg') }}');">
        <div class="page-banner-overlay"></div>
        <div class="container">
            <div class="page-banner-content">
                <span class="eyebrow eyebrow-dark">{{ $page->hero_badge ?? 'LEGAL & COMPLIANCE' }}</span>
                <h1>{{ $page->title }}</h1>
                <p>{{ $page->subtitle }}</p>
            </div>
        </div>
    </section>

    <section class="section section-cream">
        <div class="container container-narrow">
            <div style="background: #FFFFFF; padding: 48px; border-radius: 8px; border: 1px solid var(--color-border); box-shadow: var(--shadow-card); line-height: 1.8; color: var(--color-text-muted);">
                {!! $page->content !!}
            </div>
        </div>
    </section>

@endsection
