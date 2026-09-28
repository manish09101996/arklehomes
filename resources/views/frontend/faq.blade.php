@extends('layouts.app')

@section('content')

    <section class="page-banner" style="background-image: url('{{ asset('images/hero/hero-facade.jpg') }}');">
        <div class="page-banner-overlay"></div>
        <div class="container">
            <div class="page-banner-content">
                <span class="eyebrow eyebrow-dark">CLEAR ANSWERS</span>
                <h1>{{ $page->title }}</h1>
                <p>{{ $page->subtitle }}</p>
            </div>
        </div>
    </section>

    <section class="section section-cream">
        <div class="container container-narrow">

            @foreach($faqs as $category => $items)
                <div style="margin-bottom: 40px;">
                    <h3 style="font-family: var(--font-serif); font-size: 1.45rem; color: var(--color-navy-dark); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--color-border);">
                        {{ $category }}
                    </h3>

                    @foreach($items as $faq)
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <span>{{ $faq->question }}</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                            <div class="accordion-content">
                                <p>{!! nl2br(e($faq->answer)) !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <!-- Still have questions card -->
            <div style="background: #FFFFFF; padding: 40px; border-radius: 8px; border: 1px solid var(--color-border); text-align: center; margin-top: 50px;">
                <h3 style="font-family: var(--font-serif); font-size: 1.5rem; margin-bottom: 10px;">Have a specific question about your project?</h3>
                <p style="color: var(--color-text-muted); margin-bottom: 24px;">Our principal builder Sean is always available to talk through your site plans and project requirements.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold">Contact Us Today &rarr;</a>
            </div>

        </div>
    </section>

@endsection
