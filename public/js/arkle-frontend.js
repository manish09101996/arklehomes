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

    // 8. Premium Testimonials Infinite Carousel
    (function initTestimonialCarousel() {
        const carousel = document.getElementById('testimonialCarousel');
        if (!carousel) return;

        const viewport = carousel.querySelector('.testimonial-carousel-viewport');
        const track = carousel.querySelector('.testimonial-carousel-track');
        const prevBtn = carousel.querySelector('.carousel-arrow-prev');
        const nextBtn = carousel.querySelector('.carousel-arrow-next');
        const dotsContainer = document.getElementById('testimonialDots');

        if (!viewport || !track) return;

        const originalSlides = Array.from(track.querySelectorAll('.testimonial-slide'));
        const originalCount = originalSlides.length;
        if (originalCount === 0) return;

        let visibleCount = getVisibleCount();
        let currentIndex = 0;
        let isTransitioning = false;
        let autoSlideTimer = null;
        const autoSlideInterval = 4500;

        function getVisibleCount() {
            const width = window.innerWidth;
            if (width > 992) return 3; // Desktop: 3
            if (width > 600) return 2; // Tablet: 2
            return 1;                  // Mobile: 1
        }

        function setupCarousel() {
            track.innerHTML = '';

            let itemsToUse = [...originalSlides];
            while (itemsToUse.length < visibleCount + 2) {
                itemsToUse = itemsToUse.concat(originalSlides.map(s => s.cloneNode(true)));
            }

            const slideWidthPercent = 100 / visibleCount;

            // Prepend clones from end
            const headClones = itemsToUse.slice(-visibleCount).map(s => {
                const clone = s.cloneNode(true);
                clone.classList.add('is-clone');
                return clone;
            });

            // Append clones from start
            const tailClones = itemsToUse.slice(0, visibleCount).map(s => {
                const clone = s.cloneNode(true);
                clone.classList.add('is-clone');
                return clone;
            });

            headClones.forEach(s => track.appendChild(s));
            itemsToUse.forEach(s => track.appendChild(s.cloneNode(true)));
            tailClones.forEach(s => track.appendChild(s));

            const allSlides = track.querySelectorAll('.testimonial-slide');
            allSlides.forEach(slide => {
                slide.style.width = slideWidthPercent + '%';
            });

            currentIndex = visibleCount;
            track.style.transition = 'none';
            track.style.transform = `translateX(-${currentIndex * slideWidthPercent}%)`;

            buildDots(originalCount);
            updateDots();
        }

        function buildDots(count) {
            if (!dotsContainer) return;
            dotsContainer.innerHTML = '';
            for (let i = 0; i < count; i++) {
                const dot = document.createElement('button');
                dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
                dot.setAttribute('type', 'button');
                dot.setAttribute('aria-label', `Go to testimonial slide ${i + 1}`);
                dot.addEventListener('click', () => {
                    if (isTransitioning) return;
                    goToRealSlide(i);
                    resetAutoSlide();
                });
                dotsContainer.appendChild(dot);
            }
        }

        function updateDots() {
            if (!dotsContainer) return;
            const dots = dotsContainer.querySelectorAll('.carousel-dot');
            if (dots.length === 0) return;

            const realIndex = ((currentIndex - visibleCount) % originalCount + originalCount) % originalCount;
            dots.forEach((dot, idx) => {
                if (idx === realIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function moveTo(index, animate = true) {
            const slideWidthPercent = 100 / visibleCount;
            if (animate) {
                isTransitioning = true;
                track.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
            } else {
                track.style.transition = 'none';
            }
            currentIndex = index;
            track.style.transform = `translateX(-${currentIndex * slideWidthPercent}%)`;
            updateDots();
        }

        function nextSlide() {
            if (isTransitioning) return;
            moveTo(currentIndex + 1);
        }

        function prevSlide() {
            if (isTransitioning) return;
            moveTo(currentIndex - 1);
        }

        function goToRealSlide(targetOriginalIndex) {
            const currentRealIndex = ((currentIndex - visibleCount) % originalCount + originalCount) % originalCount;
            const diff = targetOriginalIndex - currentRealIndex;
            moveTo(currentIndex + diff);
        }

        track.addEventListener('transitionend', function () {
            isTransitioning = false;
            const allSlides = track.querySelectorAll('.testimonial-slide');
            const totalSlides = allSlides.length;
            const totalReal = totalSlides - 2 * visibleCount;
            const slideWidthPercent = 100 / visibleCount;

            if (currentIndex >= totalSlides - visibleCount) {
                track.style.transition = 'none';
                currentIndex = currentIndex - totalReal;
                track.style.transform = `translateX(-${currentIndex * slideWidthPercent}%)`;
                void track.offsetWidth;
            } else if (currentIndex < visibleCount) {
                track.style.transition = 'none';
                currentIndex = currentIndex + totalReal;
                track.style.transform = `translateX(-${currentIndex * slideWidthPercent}%)`;
                void track.offsetWidth;
            }
            updateDots();
        });

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                nextSlide();
                resetAutoSlide();
            });
        }
        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                prevSlide();
                resetAutoSlide();
            });
        }

        function startAutoSlide() {
            stopAutoSlide();
            autoSlideTimer = setInterval(nextSlide, autoSlideInterval);
        }

        function stopAutoSlide() {
            if (autoSlideTimer) {
                clearInterval(autoSlideTimer);
                autoSlideTimer = null;
            }
        }

        function resetAutoSlide() {
            stopAutoSlide();
            startAutoSlide();
        }

        carousel.addEventListener('mouseenter', stopAutoSlide);
        carousel.addEventListener('mouseleave', startAutoSlide);

        // Touch & Swipe gestures
        let startX = 0;
        let startY = 0;
        let currentX = 0;
        let isDragging = false;
        let isHorizontalSwipe = null;

        viewport.addEventListener('touchstart', function (e) {
            if (isTransitioning) return;
            const touch = e.touches[0];
            startX = touch.clientX;
            startY = touch.clientY;
            currentX = startX;
            isDragging = true;
            isHorizontalSwipe = null;
            stopAutoSlide();
        }, { passive: true });

        viewport.addEventListener('touchmove', function (e) {
            if (!isDragging) return;
            const touch = e.touches[0];
            currentX = touch.clientX;
            const deltaX = currentX - startX;
            const deltaY = touch.clientY - startY;

            if (isHorizontalSwipe === null) {
                if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 6) {
                    isHorizontalSwipe = true;
                } else if (Math.abs(deltaY) > 6) {
                    isHorizontalSwipe = false;
                }
            }

            if (isHorizontalSwipe) {
                if (e.cancelable) e.preventDefault();
                const slideWidthPercent = 100 / visibleCount;
                const basePercent = -(currentIndex * slideWidthPercent);
                const deltaPercent = (deltaX / viewport.offsetWidth) * 100;
                track.style.transition = 'none';
                track.style.transform = `translateX(${basePercent + deltaPercent}%)`;
            }
        }, { passive: false });

        function handleTouchEnd() {
            if (!isDragging) return;
            isDragging = false;
            const deltaX = currentX - startX;

            if (isHorizontalSwipe) {
                const threshold = 40;
                if (deltaX < -threshold) {
                    nextSlide();
                } else if (deltaX > threshold) {
                    prevSlide();
                } else {
                    moveTo(currentIndex, true);
                }
            }
            isHorizontalSwipe = null;
            resetAutoSlide();
        }

        viewport.addEventListener('touchend', handleTouchEnd);
        viewport.addEventListener('touchcancel', handleTouchEnd);

        let resizeTimeout;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function () {
                const newVisible = getVisibleCount();
                if (newVisible !== visibleCount) {
                    visibleCount = newVisible;
                    setupCarousel();
                } else {
                    const slideWidthPercent = 100 / visibleCount;
                    track.style.transition = 'none';
                    track.style.transform = `translateX(-${currentIndex * slideWidthPercent}%)`;
                }
            }, 150);
        });

        setupCarousel();
        startAutoSlide();
    })();
});

