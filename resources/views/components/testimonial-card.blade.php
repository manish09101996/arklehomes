@props(['testimonial'])

<div class="testimonial-card">
    <div>
        <div class="star-rating" aria-label="{{ $testimonial->rating }} stars">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $testimonial->rating)
                    ★
                @else
                    ☆
                @endif
            @endfor
        </div>
        <p class="testimonial-review">
            "{{ $testimonial->review }}"
        </p>
    </div>

    <div class="testimonial-author">
        <div>
            <div class="testimonial-name">{{ $testimonial->client_name }}</div>
            <div class="testimonial-role">{{ $testimonial->client_role ?? 'Home Owner' }}</div>
        </div>
    </div>
</div>
