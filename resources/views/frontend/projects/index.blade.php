@extends('layouts.app')

@section('content')

    <!-- Projects Page Banner -->
    <section class="page-banner" style="background-image: url('{{ asset(setting('hero_bg_image', 'images/hero/hero-facade.jpg')) }}');">
        <div class="page-banner-overlay"></div>
        <div class="container">
            <div class="page-banner-content">
                <span class="eyebrow eyebrow-dark" style="margin-bottom: 12px;">PORTFOLIO OF EXCELLENCE</span>
                <h1>Projects</h1>
                <p>Explore our collection of completed homes and architectural projects across Victoria.</p>
            </div>
        </div>
    </section>

    <!-- Projects Archive Section with AJAX Filtering & Sorting -->
    <section class="section section-cream">
        <div class="container">
            
            <!-- Controls: Category Filter Tabs & Sort Dropdown -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 40px;">
                <div class="filter-tabs" style="margin-bottom: 0;">
                    <button type="button" class="filter-tab {{ !request('category') || request('category') === 'all' ? 'active' : '' }}" data-category="all">
                        All
                    </button>
                    @foreach($categories as $cat)
                        <button type="button" class="filter-tab {{ request('category') === $cat->slug ? 'active' : '' }}" data-category="{{ $cat->slug }}">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Sorting Dropdown -->
                <div style="display: flex; align-items: center; gap: 10px;">
                    <label for="projectSortSelect" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--color-text-muted);">
                        Sort:
                    </label>
                    <select id="projectSortSelect" class="form-control" style="width: auto; padding: 8px 16px; border-radius: 4px; font-size: 0.88rem;">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Latest First</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="a-z" {{ $sort === 'a-z' ? 'selected' : '' }}>A - Z</option>
                    </select>
                </div>
            </div>

            <!-- Projects Grid (Replaced smoothly on AJAX filter) -->
            <div id="projectsContainer" class="projects-grid" style="transition: opacity 0.25s ease;">
                @include('frontend.partials.project-cards', ['projects' => $projects])
            </div>

            <!-- Pagination Container -->
            <div id="paginationContainer">
                @include('frontend.partials.pagination', ['paginator' => $projects])
            </div>

        </div>
    </section>

@endsection
