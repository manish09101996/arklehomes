/**
 * Arkle Homes Admin CMS Scripts
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Link Type Toggle (Internal Project Page vs External Website)
    const linkTypeSelect = document.getElementById('projectLinkType');
    const externalUrlGroup = document.getElementById('externalUrlGroup');

    function checkLinkType() {
        if (!linkTypeSelect || !externalUrlGroup) return;
        if (linkTypeSelect.value === 'external') {
            externalUrlGroup.style.display = 'block';
        } else {
            externalUrlGroup.style.display = 'none';
        }
    }

    if (linkTypeSelect) {
        linkTypeSelect.addEventListener('change', checkLinkType);
        checkLinkType(); // Run on init
    }

    // 2. Specifications Repeater
    const addSpecBtn = document.getElementById('addSpecRowBtn');
    const specsContainer = document.getElementById('specsContainer');

    if (addSpecBtn && specsContainer) {
        addSpecBtn.addEventListener('click', function () {
            const index = specsContainer.children.length;
            const row = document.createElement('div');
            row.className = 'repeater-row';
            row.innerHTML = `
                <input type="text" name="specs[${index}][name]" class="admin-form-control" placeholder="Spec Name (e.g. Ceiling Height)">
                <input type="text" name="specs[${index}][value]" class="admin-form-control" placeholder="Value (e.g. 2.7m)">
                <button type="button" class="repeater-remove-btn" onclick="this.parentElement.remove()">&times;</button>
            `;
            specsContainer.appendChild(row);
        });
    }

    // 3. Features Repeater
    const addFeatBtn = document.getElementById('addFeatRowBtn');
    const featuresContainer = document.getElementById('featuresContainer');

    if (addFeatBtn && featuresContainer) {
        addFeatBtn.addEventListener('click', function () {
            const index = featuresContainer.children.length;
            const row = document.createElement('div');
            row.className = 'repeater-row';
            row.innerHTML = `
                <input type="text" name="features[${index}][title]" class="admin-form-control" placeholder="Feature Highlight (e.g. Butler's Pantry)">
                <button type="button" class="repeater-remove-btn" onclick="this.parentElement.remove()">&times;</button>
            `;
            featuresContainer.appendChild(row);
        });
    }

    // 4. Delete Gallery Image AJAX
    const deleteImgBtns = document.querySelectorAll('.btn-delete-gallery-img');
    deleteImgBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            if (!confirm('Are you sure you want to delete this gallery image?')) return;
            const url = this.getAttribute('data-delete-url');
            const item = this.closest('.gallery-preview-item');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && item) {
                    item.remove();
                }
            })
            .catch(err => console.error('Error deleting image:', err));
        });
    });

    // 5. Toggle Featured & Published on Project list
    const toggleBtns = document.querySelectorAll('[data-toggle-action]');
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(err => console.error('Error toggling status:', err));
        });
    });

    // 6. Auto-dismiss alerts
    const alerts = document.querySelectorAll('.admin-alert');
    setTimeout(() => {
        alerts.forEach(al => {
            al.style.transition = 'opacity 0.4s ease';
            al.style.opacity = '0';
            setTimeout(() => al.remove(), 400);
        });
    }, 4500);
});
