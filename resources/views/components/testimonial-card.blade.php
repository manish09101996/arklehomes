@props(['testimonial'])

<div class="testimonial-card">
    <div class="testimonial-top">
        <div class="star-rating" aria-label="{{ $testimonial->rating }} stars">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $testimonial->rating)
                    <span class="star-filled">★</span>
                @else
                    <span class="star-empty">☆</span>
                @endif
            @endfor
        </div>
        
        <p class="testimonial-review">
            &ldquo;{{ $testimonial->review }}&rdquo;
        </p>
    </div>

    <div class="testimonial-author">
        @if(!empty($testimonial->avatar))
            <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->client_name }}" class="testimonial-avatar" loading="lazy">
        @endif
        <div class="testimonial-author-meta">
            <div class="testimonial-name">{{ $testimonial->client_name }}</div>
            <div class="testimonial-role">
                {{ $testimonial->client_role ?? 'Home Owner' }}
                @if(!empty($testimonial->location))
                    <span class="testimonial-location">&bull; {{ $testimonial->location }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
