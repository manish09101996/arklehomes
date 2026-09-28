@extends('layouts.app')

@section('content')

    <section class="section section-cream" style="min-height: 75vh; display: flex; align-items: center; text-align: center; padding-top: 140px;">
        <div class="container container-narrow">
            <span class="eyebrow eyebrow-center">ERROR 404</span>
            <h1 style="font-family: var(--font-serif); font-size: clamp(3rem, 6vw, 5rem); color: var(--color-navy-dark); margin-bottom: 20px;">
                Page Not Found
            </h1>
            <p style="font-size: 1.15rem; color: var(--color-text-muted); max-width: 540px; margin: 0 auto 36px auto; line-height: 1.7;">
                The architectural space or project you are seeking is either relocated or no longer accessible.
            </p>
            <div style="display: flex; justify-content: center; gap: 16px;">
                <a href="{{ route('home') }}" class="btn btn-gold">
                    Back to Home &rarr;
                </a>
                <a href="{{ route('projects.index') }}" class="btn btn-outline-dark">
                    Explore Projects
                </a>
            </div>
        </div>
    </section>

@endsection
