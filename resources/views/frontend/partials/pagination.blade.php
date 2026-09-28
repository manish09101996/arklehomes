@if ($paginator->hasPages())
    <div style="display: flex; justify-content: center; gap: 8px; margin-top: 50px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn btn-outline-dark" style="opacity: 0.5; pointer-events: none;">&laquo; Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-dark">&laquo; Previous</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="btn btn-gold" style="min-width: 44px;">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="btn btn-outline-dark" style="min-width: 44px;">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-dark">Next &raquo;</a>
        @else
            <span class="btn btn-outline-dark" style="opacity: 0.5; pointer-events: none;">Next &raquo;</span>
        @endif
    </div>
@endif
