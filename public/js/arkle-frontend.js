/**
 * Arkle Homes Frontend Script
 * Modern Luxury Architectural Website
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Sticky Header on Scroll
    const header = document.querySelector('.header-main');
    if (header) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 40) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        });
    }

    // 2. Mobile Drawer Navigation
    const mobileToggle = document.querySelector('.mobile-toggle');
    const mobileDrawer = document.querySelector('.mobile-nav-drawer');
    const drawerBackdrop = document.querySelector('.drawer-backdrop');
    const closeDrawerBtn = document.querySelector('.drawer-close');

    function toggleDrawer(open) {
        if (mobileDrawer && drawerBackdrop) {
            if (open) {
                mobileDrawer.classList.add('open');
                drawerBackdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            } else {
                mobileDrawer.classList.remove('open');
                drawerBackdrop.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => toggleDrawer(true));
    }
    if (closeDrawerBtn) {
        closeDrawerBtn.addEventListener('click', () => toggleDrawer(false));
    }
    if (drawerBackdrop) {
        drawerBackdrop.addEventListener('click', () => toggleDrawer(false));
    }

    // 3. Video Modal (Watch Our Work)
    const videoBtns = document.querySelectorAll('[data-video-modal]');
    const videoModal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoModalIframe');
    const closeVideoBtn = document.querySelector('.video-modal-close');

    if (videoModal && videoFrame) {
        videoBtns.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const videoUrl = this.getAttribute('data-video-url');
                if (videoUrl) {
                    videoFrame.src = videoUrl + (videoUrl.includes('?') ? '&autoplay=1' : '?autoplay=1');
                    videoModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        function closeVideo() {
            videoModal.classList.remove('active');
            videoFrame.src = '';
            document.body.style.overflow = '';
        }

        if (closeVideoBtn) {
            closeVideoBtn.addEventListener('click', closeVideo);
        }
        videoModal.addEventListener('click', function (e) {
            if (e.target === videoModal) closeVideo();
        });
    }

    // 4. Accordion FAQ
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function () {
            const item = this.parentElement;
            const content = this.nextElementSibling;
            const isOpen = item.classList.contains('active');

            // Close siblings in same container
            document.querySelectorAll('.accordion-item.active').forEach(sibling => {
                if (sibling !== item) {
                    sibling.classList.remove('active');
                    sibling.querySelector('.accordion-content').style.maxHeight = null;
                }
            });

            if (isOpen) {
                item.classList.remove('active');
                content.style.maxHeight = null;
            } else {
                item.classList.add('active');
                content.style.maxHeight = content.scrollHeight + 30 + 'px';
            }
        });
    });

    // 5. Lightbox for Project Gallery
    const galleryItems = document.querySelectorAll('[data-lightbox-src]');
    const lightboxModal = document.getElementById('lightboxModal');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxClose = document.querySelector('.lightbox-close');
    const lightboxPrev = document.querySelector('.lightbox-prev');
    const lightboxNext = document.querySelector('.lightbox-next');

    let currentLightboxIndex = 0;
    const lightboxList = [];

    galleryItems.forEach((item, index) => {
        const src = item.getAttribute('data-lightbox-src');
        lightboxList.push(src);
        item.addEventListener('click', function (e) {
            e.preventDefault();
            currentLightboxIndex = index;
            showLightbox(index);
        });
    });

    function showLightbox(index) {
        if (!lightboxModal || !lightboxImage || lightboxList.length === 0) return;
        currentLightboxIndex = (index + lightboxList.length) % lightboxList.length;
        lightboxImage.src = lightboxList[currentLightboxIndex];
        lightboxModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        if (!lightboxModal) return;
        lightboxModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', function (e) {
            e.stopPropagation();
            showLightbox(currentLightboxIndex - 1);
        });
    }
    if (lightboxNext) {
        lightboxNext.addEventListener('click', function (e) {
            e.stopPropagation();
            showLightbox(currentLightboxIndex + 1);
        });
    }
    if (lightboxModal) {
        lightboxModal.addEventListener('click', function (e) {
            if (e.target === lightboxModal) closeLightbox();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (lightboxModal && lightboxModal.classList.contains('active')) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') showLightbox(currentLightboxIndex - 1);
            if (e.key === 'ArrowRight') showLightbox(currentLightboxIndex + 1);
        }
        if (videoModal && videoModal.classList.contains('active')) {
            if (e.key === 'Escape') closeVideo();
        }
    });

    // 6. Projects AJAX Filter & Sort
    const filterTabs = document.querySelectorAll('.filter-tab');
    const sortSelect = document.getElementById('projectSortSelect');
    const projectsContainer = document.getElementById('projectsContainer');

    function fetchProjects(category, sort) {
        if (!projectsContainer) return;
        projectsContainer.style.opacity = '0.5';

        const url = new URL(window.location.origin + '/projects');
        if (category && category !== 'all') url.searchParams.set('category', category);
        if (sort) url.searchParams.set('sort', sort);

        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.html) {
                projectsContainer.innerHTML = data.html;
                const paginationContainer = document.getElementById('paginationContainer');
                if (paginationContainer && data.pagination) {
                    paginationContainer.innerHTML = data.pagination;
                }
            }
            projectsContainer.style.opacity = '1';
            window.history.pushState({}, '', url.toString());
        })
        .catch(err => {
            console.error('Error filtering projects:', err);
            projectsContainer.style.opacity = '1';
        });
    }

    if (filterTabs.length > 0) {
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const cat = this.getAttribute('data-category');
                const sort = sortSelect ? sortSelect.value : 'latest';
                fetchProjects(cat, sort);
            });
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            const activeTab = document.querySelector('.filter-tab.active');
            const cat = activeTab ? activeTab.getAttribute('data-category') : 'all';
            fetchProjects(cat, this.value);
        });
    }

    // 7. Contact Form AJAX
    const contactForm = document.getElementById('contactForm');
    const formAlert = document.getElementById('formAlert');
    const submitBtn = document.getElementById('submitBtn');

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Sending Enquiry...';
            }

            const formData = new FormData(contactForm);

            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(({ status, body }) => {
                if (status === 200 && body.success) {
                    if (formAlert) {
                        formAlert.className = 'alert alert-success';
                        formAlert.innerHTML = `<strong>Success!</strong> ${body.message}`;
                        formAlert.style.display = 'flex';
                    }
                    contactForm.reset();
                } else {
                    let errMsg = body.message || 'Validation error occurred. Please check the fields.';
                    if (body.errors) {
                        errMsg = Object.values(body.errors).flat().join('<br>');
                    }
                    if (formAlert) {
                        formAlert.className = 'alert alert-error';
                        formAlert.innerHTML = `<strong>Error:</strong><br>${errMsg}`;
                        formAlert.style.display = 'flex';
                    }
                }
            })
            .catch(err => {
                if (formAlert) {
                    formAlert.className = 'alert alert-error';
                    formAlert.innerHTML = 'An unexpected error occurred. Please call 0430 331 187.';
                    formAlert.style.display = 'flex';
                }
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Send Message';
                }
            });
        });
    }
});
