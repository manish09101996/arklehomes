@props(['project'])

@php
    $url = $project->destination_url;
    $target = $project->link_target;
    $rel = $project->link_rel;
    $isExternal = $project->is_external;
@endphp

<article class="project-card" onclick="window.open('{{ $url }}', '{{ $target }}')" role="link" tabindex="0" onkeydown="if(event.key === 'Enter') window.open('{{ $url }}', '{{ $target }}');">
    <div class="project-card-image">
        <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" loading="lazy">
        @if($isExternal)
            <span class="project-card-badge external-badge">External Website ↗</span>
        @elseif($project->category)
            <span class="project-card-badge">{{ $project->category->name }}</span>
        @endif
    </div>

    <div class="project-card-body">
        <div class="project-card-meta">
            @if($project->category)
                <span class="project-category-tag">{{ strtoupper($project->category->name) }}</span>
            @endif
            <h3 class="project-card-title">
                <a href="{{ $url }}" target="{{ $target }}" @if($rel) rel="{{ $rel }}" @endif onclick="event.stopPropagation();">
                    {{ $project->title }}
                </a>
            </h3>
            @if($project->location)
                <div class="project-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>{{ $project->location }}</span>
                </div>
            @endif
        </div>

        @if($project->bedrooms || $project->bathrooms || $project->garage)
            <div class="project-card-specs">
                @if($project->bedrooms)
                    <span title="{{ $project->bedrooms }} Bedrooms">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 4v16M2 8h18a2 2 0 0 1 2 2v10M2 17h20M6 8v9"></path>
                        </svg>
                        {{ $project->bedrooms }} Bed
                    </span>
                @endif
                @if($project->bathrooms)
                    <span title="{{ $project->bathrooms }} Bathrooms">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 6h6a3 3 0 0 1 3 3v12H6V9a3 3 0 0 1 3-3z"></path>
                        </svg>
                        {{ $project->bathrooms }} Bath
                    </span>
                @endif
                @if($project->garage)
                    <span title="{{ $project->garage }} Car Garage">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                            <circle cx="7.5" cy="16.5" r="1.5"></circle>
                            <circle cx="16.5" cy="16.5" r="1.5"></circle>
                        </svg>
                        {{ $project->garage }} Car
                    </span>
                @endif
            </div>
        @endif

        <div class="project-card-footer">
            <span class="project-view-link">
                @if($isExternal)
                    View Property ↗
                @else
                    View Project &rarr;
                @endif
            </span>
            <div style="color: var(--color-gold);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </div>
        </div>
    </div>
</article>
