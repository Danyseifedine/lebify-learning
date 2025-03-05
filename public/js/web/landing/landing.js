// Hero Section Animation
function initHeroAnimation() {
    // Create a smooth intro sequence
    const tl = gsap.timeline({
        defaults: {
            ease: "power3.out",
            duration: 1
        }
    });

    // Set initial states with more dramatic starting positions
    gsap.set('.hero-section h1', { opacity: 0, y: 100, rotationX: 45 });
    gsap.set('.hero-section p', { opacity: 0, y: 50 });
    gsap.set('.nav-hero', { opacity: 0, y: 30 });
    gsap.set('.main-illustration', { opacity: 0, scale: 0.8, rotation: -10 });
    gsap.set('.tech-badge', {
        opacity: 0,
        scale: 0.5,
        y: 50,
        rotation: 0
    });
    gsap.set('.floating-shape', { opacity: 0, scale: 0, transformOrigin: "center" });
    gsap.set('.dotted-shape', { opacity: 0, scale: 0, rotation: 180 });
    gsap.set('.scroll-indicator', { opacity: 0, y: 50 });

    // Create a dramatic entrance sequence
    tl.to('.hero-section h1', {
        opacity: 1,
        y: 0,
        rotationX: 0,
        duration: 1.5,
        ease: "elastic.out(1, 0.8)"
    })
        .to('.hero-section p', {
            opacity: 1,
            y: 0,
            duration: 1,
            ease: "power4.out"
        }, "-=0.7")
        .to('.nav-hero', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: "back.out(1.7)"
        }, "-=0.5")
        .to('.main-illustration', {
            opacity: 1,
            scale: 1,
            rotation: 0,
            duration: 1.2,
            ease: "elastic.out(1, 0.8)"
        }, "-=0.8")
        // Improved tech badge entrance animation
        .to('.tech-badge', {
            opacity: 1,
            scale: 1,
            y: 0,
            duration: 1,
            stagger: 0.2,
            ease: "back.out(1.7)",
            onComplete: () => initBadgeFloating()
        })
        .to(['.floating-shape', '.dotted-shape'], {
            opacity: 0.5,
            scale: 1,
            rotation: 0,
            duration: 1,
            stagger: 0.1,
            ease: "elastic.out(1, 0.8)"
        }, "-=0.8");

    // Separate function for badge floating animation
    function initBadgeFloating() {
        gsap.to('.tech-badge', {
            y: 15,
            duration: 2,
            ease: "sine.inOut",
            yoyo: true,
            repeat: -1,
            stagger: {
                each: 0.5,
                from: "random"
            }
        });

        // Subtle rotation and scale
        gsap.to('.tech-badge', {
            rotation: 10,
            scale: 1.05,
            duration: 3,
            ease: "sine.inOut",
            yoyo: true,
            repeat: -1,
            stagger: {
                each: 0.5,
                from: "random"
            }
        });
    }

    // Enhanced hover effect for tech badges with larger images
    document.querySelectorAll('.tech-badge').forEach(badge => {
        // Increase image size
        const img = badge.querySelector('img');
        gsap.set(img, {
            width: '50px',
            height: '50px'
        });

        badge.addEventListener('mouseenter', () => {
            gsap.to(badge, {
                scale: 1.15,
                rotation: 0,
                y: -5,
                duration: 0.3,
                ease: "back.out(1.7)",
                boxShadow: "0 10px 20px rgba(0,0,0,0.15)"
            });
            gsap.to(img, {
                scale: 1.1,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        badge.addEventListener('mouseleave', () => {
            gsap.to(badge, {
                scale: 1,
                y: 0,
                boxShadow: "none",
                duration: 0.3,
                ease: "power2.inOut"
            });
            gsap.to(img, {
                scale: 1,
                duration: 0.3,
                ease: "power2.inOut"
            });
        });
    });

    // Enhanced floating shapes animation
    gsap.to('.floating-shape', {
        keyframes: [
            { x: "random(-50, 50)", y: "random(-50, 50)", rotation: 20, duration: 2 },
            { x: "random(-50, 50)", y: "random(-50, 50)", rotation: -20, duration: 2 },
            { x: "random(-50, 50)", y: "random(-50, 50)", rotation: 0, duration: 2 }
        ],
        repeat: -1,
        yoyo: true,
        ease: "none",
        stagger: {
            amount: 1.5,
            from: "random"
        }
    });

    // Enhanced parallax effect with rotation
    document.querySelector('.hero-section').addEventListener('mousemove', (e) => {
        const mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
        const mouseY = (e.clientY / window.innerHeight - 0.5) * 2;

        gsap.to('.main-illustration', {
            x: mouseX * 30,
            y: mouseY * 30,
            rotateX: -mouseY * 15,
            rotateY: mouseX * 15,
            duration: 1,
            ease: "power2.out"
        });

        gsap.to('.floating-shape', {
            x: mouseX * 50,
            y: mouseY * 50,
            rotateX: -mouseY * 20,
            rotateY: mouseX * 20,
            duration: 1,
            stagger: 0.1,
            ease: "power2.out"
        });

        gsap.to('.tech-badge', {
            x: mouseX * -40,
            y: mouseY * -40,
            rotateX: mouseY * 25,
            rotateY: -mouseX * 25,
            duration: 1,
            stagger: 0.1,
            ease: "power2.out"
        });
    });

    // Smooth scroll indicator animation
    gsap.to('.scroll-indicator', {
        y: 20,
        duration: 1.5,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut",
        opacity: 0.7
    });
}

// Add random shape animations
function initRandomShapes() {
    const randomShapes = document.querySelectorAll('.random-shape');

    // Initial setup
    gsap.set(randomShapes, {
        opacity: 0,
        scale: 0,
        rotation: -180
    });

    // Entrance animation
    gsap.to(randomShapes, {
        opacity: 0.5,
        scale: 1,
        rotation: 0,
        duration: 1,
        stagger: 0.2,
        ease: "back.out(1.7)",
        delay: 1
    });

    // Continuous floating animation
    randomShapes.forEach((shape) => {
        // Random starting position within constraints
        const startX = gsap.utils.random(-50, 50);
        const startY = gsap.utils.random(-50, 50);

        gsap.to(shape, {
            x: startX,
            y: startY,
            rotation: gsap.utils.random(-360, 360),
            duration: gsap.utils.random(15, 20),
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut",
            onComplete: () => {
                // Generate new random positions for next iteration
                gsap.to(shape, {
                    x: gsap.utils.random(-50, 50),
                    y: gsap.utils.random(-50, 50),
                    rotation: gsap.utils.random(-360, 360),
                    duration: gsap.utils.random(15, 20),
                    ease: "sine.inOut"
                });
            }
        });
    });

    // Add parallax effect
    document.addEventListener('mousemove', (e) => {
        const mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
        const mouseY = (e.clientY / window.innerHeight - 0.5) * 2;

        gsap.to('.random-shape', {
            x: (index) => mouseX * (30 + index * 10),
            y: (index) => mouseY * (30 + index * 10),
            rotation: mouseX * 10,
            duration: 1,
            ease: "power2.out"
        });
    });
}

// Statistics Cards Animation
function initStatisticsAnimation() {
    const statsSection = document.querySelector('.statistics-section');
    if (!statsSection) return; // Add check to prevent errors if section doesn't exist

    gsap.set('.stat-item', { opacity: 0, y: 50 });

    ScrollTrigger.create({
        trigger: '.statistics-section',
        start: 'top 70%',
        onEnter: () => {
            gsap.to('.stat-item', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.2,
                ease: 'back.out(1.7)',
                onComplete: animateNumbers
            });
        }
    });
}

// Number Counter Animation
function animateNumbers() {
    const numberElements = document.querySelectorAll('.animate-number');

    numberElements.forEach(element => {
        const endValue = parseInt(element.getAttribute('data-value') || '0');
        if (!isNaN(endValue)) {  // Add check to ensure endValue exists and is a number
            gsap.to(element, {
                textContent: endValue,
                duration: 2,
                ease: 'power1.out',
                snap: { textContent: 1 },
                stagger: 1,
            });
        }
    });
}

// Add hover animations for stat cards
function initStatCardHover() {
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, {
                scale: 1.02,
                duration: 0.3,
                ease: 'power2.out'
            });

            // Animate icon
            const icon = card.querySelector('.icon-stat');
            gsap.to(icon, {
                scale: 1.2,
                rotate: 5,
                duration: 0.3,
                ease: 'back.out(1.7)'
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                scale: 1,
                duration: 0.3,
                ease: 'power2.inOut'
            });

            // Reset icon
            const icon = card.querySelector('.icon-stat');
            gsap.to(icon, {
                scale: 1,
                rotate: 0,
                duration: 0.3,
                ease: 'power2.inOut'
            });
        });
    });
}

// Why Choose Us Section Animation
function initWhyChooseUsAnimation() {
    // Initial states
    gsap.set('.choose-us-image', { opacity: 0, scale: 0.9 });
    gsap.set('.floating-bubble', { opacity: 0, scale: 0 });
    gsap.set('.section-badge', { opacity: 0, y: 20 });
    gsap.set('.choose-us-content h2', { opacity: 0, y: 30 });
    gsap.set('.choose-us-content p', { opacity: 0, y: 30 });
    gsap.set('.feature-item', { opacity: 0, x: -50 });

    // Create timeline
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: '.why-choose-us-section',
            start: 'top 60%',
            end: 'bottom 60%',
            toggleActions: 'play none none reverse'
        }
    });

    // Main image animation with bounce
    tl.to('.choose-us-image', {
        opacity: 1,
        scale: 1,
        duration: 1,
        ease: 'back.out(1.7)'
    })

        // Floating bubbles animation
        .to('.floating-bubble', {
            opacity: 0.7,
            scale: 1,
            stagger: 0.2,
            duration: 0.8,
            ease: 'back.out(2)',
        }, '-=0.5')

        // Content animations
        .to('.section-badge', {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power2.out'
        }, '-=0.4')

        .to('.choose-us-content h2', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power2.out'
        }, '-=0.3')

        .to('.choose-us-content p', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power2.out'
        }, '-=0.6')

        // Feature items staggered animation
        .to('.feature-item', {
            opacity: 1,
            x: 0,
            stagger: 0.2,
            duration: 0.8,
            ease: 'power2.out'
        }, '-=0.4');

    // Add hover animations for feature items
    document.querySelectorAll('.feature-item').forEach(item => {
        const icon = item.querySelector('.feature-icon i');

        item.addEventListener('mouseenter', () => {
            gsap.to(item, {
                x: 15,
                duration: 0.3,
                ease: 'power2.out'
            });

            gsap.to(icon, {
                scale: 1.2,
                color: '#ffffff',
                duration: 0.4,
                ease: 'back.out(1.7)'
            });
        });

        item.addEventListener('mouseleave', () => {
            gsap.to(item, {
                x: 0,
                duration: 0.3,
                ease: 'power2.inOut'
            });

            gsap.to(icon, {
                scale: 1,
                color: '#F77E15',
                duration: 0.4,
                ease: 'power2.inOut'
            });
        });
    });

    // Continuous floating animation for bubbles
    gsap.to('.floating-bubble', {
        y: '-20px',
        duration: 2,
        ease: 'power1.inOut',
        yoyo: true,
        repeat: -1,
        stagger: {
            each: 0.5,
            from: 'random'
        }
    });
}

// Add this function to initialize draggable cards
function initDraggableCards() {
    const cards = document.querySelectorAll('.quiz-feature-card');

    // Initial state for scroll animation
    gsap.set(cards, {
        opacity: 0,
        y: 100,
        scale: 0.8
    });

    // Scroll animation
    gsap.to(cards, {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 0.8,
        stagger: {
            amount: 0.6,
            from: "random"
        },
        ease: "power3.out",
        scrollTrigger: {
            trigger: ".quiz-features-grid",
            start: "top 80%",
            end: "top 30%",
            toggleActions: "play none none reverse"
        }
    });

    // Draggable functionality (existing code)
    cards.forEach(card => {
        Draggable.create(card, {
            type: "x,y",
            bounds: ".quiz-features-grid",
            inertia: true,
            edgeResistance: 0.65,
            dragResistance: 0.5,
            onDragStart: function () {
                gsap.to(this.target, {
                    scale: 1.05,
                    boxShadow: "0 15px 40px rgba(247, 126, 21, 0.2)",
                    zIndex: 1000,
                    duration: 0.2
                });
                this.target.classList.add('dragging');
            },
            onDrag: function () {
                const draggedCard = this.target;
                const draggedRect = draggedCard.getBoundingClientRect();
                const draggedCenter = {
                    x: draggedRect.left + draggedRect.width / 2,
                    y: draggedRect.top + draggedRect.height / 2
                };

                let closestCard = null;
                let closestDistance = Infinity;

                cards.forEach(card => {
                    if (card === draggedCard) return;

                    const cardRect = card.getBoundingClientRect();
                    const cardCenter = {
                        x: cardRect.left + cardRect.width / 2,
                        y: cardRect.top + cardRect.height / 2
                    };

                    const distance = Math.hypot(
                        cardCenter.x - draggedCenter.x,
                        cardCenter.y - draggedCenter.y
                    );

                    if (distance < closestDistance) {
                        closestDistance = distance;
                        closestCard = card;
                    }
                });

                // Swap cards when they are close enough
                if (closestCard && closestDistance < 100) {
                    if (this.lastSwappedCard !== closestCard) {
                        this.lastSwappedCard = closestCard;

                        // Store original positions
                        const originalDraggedTransform = draggedCard._gsap.get();

                        // Update DOM order first
                        const parent = draggedCard.parentNode;
                        const draggedIndex = Array.from(parent.children).indexOf(draggedCard);
                        const targetIndex = Array.from(parent.children).indexOf(closestCard);

                        if (draggedIndex < targetIndex) {
                            parent.insertBefore(closestCard, draggedCard);
                        } else {
                            parent.insertBefore(draggedCard, closestCard);
                        }

                        // Animate to new positions
                        gsap.to(closestCard, {
                            x: originalDraggedTransform.x,
                            y: originalDraggedTransform.y,
                            duration: 0.3,
                            ease: "power2.out"
                        });
                    }
                } else {
                    this.lastSwappedCard = null;
                }
            },
            onDragEnd: function () {
                this.lastSwappedCard = null;

                // Only reset the visual properties, not the position
                gsap.to(this.target, {
                    scale: 1,
                    boxShadow: "0 10px 30px rgba(247, 126, 21, 0.1)",
                    duration: 0.3,
                    ease: "power2.out"
                });

                this.target.classList.remove('dragging');
            }
        });
    });
}

function initWalletAnimation() {
    // Initial setup for the card and content
    gsap.set('.wallet-card', { opacity: 0, scale: 0.8 });
    gsap.set('.info-item', { opacity: 0, y: 30 });
    gsap.set('.section-badge', { opacity: 0, y: 20 });
    gsap.set('.wallet-content h2', { opacity: 0, y: 30 });
    gsap.set('.wallet-content .lead', { opacity: 0, y: 30 });

    // Create timeline for the wallet section
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: '.coin-wallet-section',
            start: 'top 60%',
            end: 'bottom 60%',
            toggleActions: 'play none none reverse'
        }
    });

    // Animate content
    tl.to('.section-badge', {
        opacity: 1,
        y: 0,
        duration: 0.6,
        ease: 'power2.out'
    })
        .to('.wallet-content h2', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power2.out'
        }, '-=0.3')
        .to('.wallet-content .lead', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power2.out'
        }, '-=0.5')
        .to('.info-item', {
            opacity: 1,
            y: 0,
            duration: 0.6,
            stagger: 0.15,
            ease: 'power2.out'
        }, '-=0.3')
        .to('.wallet-card', {
            opacity: 1,
            scale: 1,
            duration: 1,
            ease: 'back.out(1.7)',
            onComplete: initCardHover
        }, '-=0.8');

    // Add hover animation for the card
    function initCardHover() {
        const card = document.querySelector('.wallet-card');
        if (!card) return;

        card.addEventListener('mouseenter', () => {
            gsap.to('.wallet-card', {
                rotateY: 15,
                rotateX: -15,
                scale: 1.05,
                duration: 0.4,
                ease: 'power2.out'
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to('.wallet-card', {
                rotateY: 0,
                rotateX: 0,
                scale: 1,
                duration: 0.4,
                ease: 'power2.inOut'
            });
        });

        // Add mouse move effect
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const mouseX = (e.clientX - rect.left) / rect.width - 0.5;
            const mouseY = (e.clientY - rect.top) / rect.height - 0.5;

            gsap.to('.wallet-card', {
                rotateY: mouseX * 20,
                rotateX: -mouseY * 20,
                duration: 0.1,
                ease: 'power2.out'
            });
        });
    }
}

// Add this function to your existing code
function initYouTubePromoAnimation() {
    gsap.set('.youtube-content', { opacity: 0, y: 50 });
    gsap.set('.youtube-icon-morph', {
        opacity: 0,
        scale: 0.8,
        y: 30
    });

    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: '.youtube-promo-section',
            start: 'top 60%',
            end: 'bottom 60%',
            toggleActions: 'play none none reverse'
        }
    });

    tl.to('.youtube-content', {
        opacity: 1,
        y: 0,
        duration: 1,
        ease: 'power3.out'
    })
        .to('.youtube-icon-morph', {
            opacity: 1,
            scale: 1,
            y: 0,
            duration: 1,
            ease: 'elastic.out(1, 0.5)'
        }, '-=0.5');

    // Enhanced hover effect
    const iconWrapper = document.querySelector('.youtube-icon-wrapper');
    if (iconWrapper) {
        iconWrapper.addEventListener('mousemove', (e) => {
            const rect = iconWrapper.getBoundingClientRect();
            const mouseX = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
            const mouseY = ((e.clientY - rect.top) / rect.height - 0.5) * 2;

            gsap.to('.youtube-icon-morph', {
                rotateY: mouseX * 10,
                rotateX: -mouseY * 10,
                duration: 0.3,
                ease: 'power2.out'
            });
        });

        iconWrapper.addEventListener('mouseleave', () => {
            gsap.to('.youtube-icon-morph', {
                rotateY: 0,
                rotateX: 0,
                duration: 0.5,
                ease: 'power2.out'
            });
        });
    }
}

// Update the testimonials animation function
function initTestimonialsAnimation() {
    // Initial setup
    const tracks = document.querySelectorAll('.testimonials-track');

    tracks.forEach(track => {
        // Clone items for smooth infinite scroll
        const items = track.children;
        const itemCount = items.length;

        // Only clone if we have items
        if (itemCount > 0) {
            // Clone enough items to ensure smooth scrolling
            for (let i = 0; i < itemCount; i++) {
                const clone = items[i].cloneNode(true);
                track.appendChild(clone);
            }
        }
    });

    // Add hover effects for testimonial cards
    const cards = document.querySelectorAll('.testimonial-card');

    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, {
                scale: 1.05,
                duration: 0.3,
                ease: 'power2.out',
                zIndex: 1
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                scale: 1,
                duration: 0.3,
                ease: 'power2.out',
                zIndex: 0
            });
        });
    });

    // Add pause on hover for each scroll track
    const scrollContainers = document.querySelectorAll('.testimonials-scroll');

    scrollContainers.forEach(container => {
        container.addEventListener('mouseenter', () => {
            const track = container.querySelector('.testimonials-track');
            track.style.animationPlayState = 'paused';
        });

        container.addEventListener('mouseleave', () => {
            const track = container.querySelector('.testimonials-track');
            track.style.animationPlayState = 'running';
        });
    });
}

// Initialize all animations
document.addEventListener('DOMContentLoaded', () => {
    initHeroAnimation();
    initRandomShapes();
    initStatisticsAnimation();
    initStatCardHover();
    initWhyChooseUsAnimation();
    initDraggableCards();
    initWalletAnimation();
    initYouTubePromoAnimation();
    initTestimonialsAnimation();
});


document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('scroll', () => {
        const scrollIndicator = document.querySelector('.scroll-indicator');
        if (window.scrollY > 100) {
            scrollIndicator.style.opacity = '0';
        } else {
            scrollIndicator.style.opacity = '0.7';
        }
    });
});
