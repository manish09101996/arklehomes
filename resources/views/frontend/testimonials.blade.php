@extends('layouts.app')

@section('content')

    <section class="page-banner" style="background-image: url('{{ asset('images/hero/hero-facade.jpg') }}');">
        <div class="page-banner-overlay"></div>
        <div class="container">
            <div class="page-banner-content">
                <span class="eyebrow eyebrow-dark">VERIFIED REVIEWS</span>
                <h1>{{ $page->title }}</h1>
                <p>{{ $page->subtitle }}</p>
            </div>
        </div>
    </section>

    <section class="section section-cream">
        <div class="container">
            <div class="testimonials-grid">
                @foreach($testimonials as $t)
                    <x-testimonial-card :testimonial="$t" />
                @endforeach
            </div>

            @include('frontend.partials.pagination', ['paginator' => $testimonials])
        </div>
    </section>

@endsection
