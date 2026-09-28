@extends('layouts.app')

@section('content')

    <!-- Project Detail Hero -->
    <section class="project-detail-hero" style="background-image: url('{{ $project->featured_image_url }}');">
        <div class="project-detail-hero-overlay"></div>
        <div class="project-detail-title-card">
            <div class="container">
                <div style="max-width: 800px;">
                    @if($project->category)
                        <span class="eyebrow eyebrow-dark" style="margin-bottom: 12px;">{{ strtoupper($project->category->name) }}</span>
                    @endif
                    <h1 style="color: #ffffff; font-size: clamp(2.4rem, 4.5vw, 3.8rem); line-height: 1.15; margin-bottom: 16px;">
                        {{ $project->title }}
                    </h1>
                    @if($project->location)
                        <p style="color: var(--color-gold); font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            {{ $project->location }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Project Specifications Bar -->
    <div class="container" style="position: relative; z-index: 10; margin-top: -30px;">
        <div class="specs-grid">
            @if($project->bedrooms)
                <div class="spec-box">
                    <div class="spec-box-label">Bedrooms</div>
                    <div class="spec-box-value">{{ $project->bedrooms }}</div>
                </div>
            @endif
            @if($project->bathrooms)
                <div class="spec-box">
                    <div class="spec-box-label">Bathrooms</div>
                    <div class="spec-box-value">{{ $project->bathrooms }}</div>
                </div>
            @endif
            @if($project->garage)
                <div class="spec-box">
                    <div class="spec-box-label">Garage</div>
                    <div class="spec-box-value">{{ $project->garage }} Cars</div>
                </div>
            @endif
            @if($project->land_size)
                <div class="spec-box">
                    <div class="spec-box-label">Land Size</div>
                    <div class="spec-box-value">{{ $project->land_size }}</div>
                </div>
            @endif
            @if($project->house_size)
                <div class="spec-box">
                    <div class="spec-box-label">House Size</div>
                    <div class="spec-box-value">{{ $project->house_size }}</div>
                </div>
            @endif
            @if($project->status)
                <div class="spec-box">
                    <div class="spec-box-label">Status</div>
                    <div class="spec-box-value" style="color: var(--color-gold);">{{ $project->status }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Content Section -->
    <section class="section section-cream" style="padding-top: 40px;">
        <div class="container">

            @if($project->is_external)
                <div style="background: #FFFBEB; border-left: 4px solid var(--color-gold); padding: 20px 24px; border-radius: 4px; margin-bottom: 36px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <strong style="color: #92400E; font-size: 1.05rem;">External Project Showcase</strong>
                        <p style="color: #B45309; margin: 4px 0 0 0; font-size: 0.95rem;">This property is featured on an external listing website.</p>
                    </div>
                    <a href="{{ $project->external_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-gold">
                        Visit External Website ↗
                    </a>
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 60px;">
                <!-- Left: Full Story & Features -->
                <div>
                    <span class="eyebrow">ARCHITECTURAL OVERVIEW</span>
                    <h2 class="section-title" style="font-size: 2.2rem; margin-bottom: 24px;">About the Build</h2>

                    <div style="font-size: 1.05rem; line-height: 1.8; color: var(--color-text-muted); margin-bottom: 40px;">
                        {!! $project->full_description ?? nl2br(e($project->short_description)) !!}
                    </div>

                    @if($project->features->isNotEmpty())
                        <div style="margin-top: 40px;">
                            <h3 style="font-family: var(--font-serif); font-size: 1.5rem; margin-bottom: 20px;">Key Architectural Features</h3>
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                                @foreach($project->features as $feat)
                                    <div style="display: flex; align-items: flex-start; gap: 12px; background: #FFFFFF; padding: 16px; border-radius: 4px; border: 1px solid var(--color-border);">
                                        <div style="color: var(--color-gold); margin-top: 2px;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </div>
                                        <div>
                                            <strong style="color: var(--color-navy-dark); display: block; font-size: 0.95rem;">{{ $feat->title }}</strong>
                                            @if($feat->description)
                                                <span style="font-size: 0.85rem; color: var(--color-text-muted);">{{ $feat->description }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right: Enquiry Sidebar Card -->
                <div>
                    <div style="background: #FFFFFF; padding: 32px; border-radius: 8px; border: 1px solid var(--color-border); box-shadow: var(--shadow-card); position: sticky; top: 100px;">
                        <span class="eyebrow" style="margin-bottom: 12px;">BUILD WITH ARKLE</span>
                        <h3 style="font-family: var(--font-serif); font-size: 1.45rem; margin-bottom: 14px;">Love This Design?</h3>
                        <p style="font-size: 0.92rem; color: var(--color-text-muted); margin-bottom: 24px; line-height: 1.6;">
                            Speak directly with our principal builder Sean to discuss adapting this concept for your site or commencing a bespoke architectural design.
                        </p>

                        <a href="{{ route('contact', ['project' => $project->slug]) }}" class="btn btn-gold" style="width: 100%; margin-bottom: 14px;">
                            Enquire About This Build &rarr;
                        </a>

                        <a href="tel:{{ format_phone(setting('site_phone', '0430 331 187')) }}" class="btn btn-outline-dark" style="width: 100%;">
                            Call 0430 331 187
                        </a>

                        @if($project->is_external)
                            <a href="{{ $project->external_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-gold" style="width: 100%; margin-top: 10px;">
                                View External Listing ↗
                            </a>
                        @endif

                        <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--color-border); font-size: 0.85rem; color: var(--color-text-muted);">
                            ✓ Master Builders Fixed-Price Contracts<br>
                            ✓ Victorian 7-Year Structural Warranty<br>
                            ✓ End-to-End Architectural Management
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Section with Lightbox -->
            @if($project->images->isNotEmpty())
                <div style="margin-top: 80px;">
                    <div class="section-header">
                        <span class="eyebrow">GALLERY</span>
                        <h2 class="section-title">Project Image Gallery</h2>
                        <p class="section-subtitle">Click any image to explore high-resolution architectural photography.</p>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        @foreach($project->images as $img)
                            <a href="{{ $img->url }}" data-lightbox-src="{{ $img->url }}" class="gallery-thumb" style="display: block; height: 260px; overflow: hidden; border-radius: 4px; border: 1px solid var(--color-border); position: relative;">
                                <img src="{{ $img->url }}" alt="{{ $img->alt_text }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Previous / Next Project Navigation -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 80px; padding-top: 30px; border-top: 1px solid var(--color-border);">
                @if($prevProject)
                    <a href="{{ $prevProject->destination_url }}" target="{{ $prevProject->link_target }}" class="btn btn-outline-dark">
                        &larr; Previous: {{ Str::limit($prevProject->title, 25) }}
                    </a>
                @else
                    <div></div>
                @endif

                <a href="{{ route('projects.index') }}" class="btn btn-outline-dark">
                    Back to All Projects
                </a>

                @if($nextProject)
                    <a href="{{ $nextProject->destination_url }}" target="{{ $nextProject->link_target }}" class="btn btn-outline-dark">
                        Next: {{ Str::limit($nextProject->title, 25) }} &rarr;
                    </a>
                @else
                    <div></div>
                @endif
            </div>

            <!-- Related Projects -->
            @if($relatedProjects->isNotEmpty())
                <div style="margin-top: 90px;">
                    <div class="section-header">
                        <span class="eyebrow">EXPLORE MORE</span>
                        <h2 class="section-title">Related Projects</h2>
                    </div>

                    <div class="projects-grid">
                        @foreach($relatedProjects as $relProj)
                            <x-project-card :project="$relProj" />
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
