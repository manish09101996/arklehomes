@forelse($projects as $project)
    <x-project-card :project="$project" />
@empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #fff; border-radius: 8px; border: 1px solid var(--color-border);">
        <h3 style="font-family: var(--font-serif); margin-bottom: 10px;">No projects found</h3>
        <p class="text-muted">There are currently no projects matching this category criteria.</p>
    </div>
@endforelse
