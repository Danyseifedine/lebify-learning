import { l10n } from '../../../global/config/app-config.js'

document.addEventListener('DOMContentLoaded', function () {
    // Register GSAP plugins
    gsap.registerPlugin(TextPlugin, ScrollTrigger);

    // Hero section animations
    function animateHeroSection() {
        const texts = [
            l10n.getRandomTranslation("_1_"),
            l10n.getRandomTranslation("_2_"),
            l10n.getRandomTranslation("_3_"),
            l10n.getRandomTranslation("_4_"),
            l10n.getRandomTranslation("_5_")
        ];

        const typewriterElements = document.querySelectorAll('.gsap-typewriter');
        let masterTimeline = gsap.timeline();

        typewriterElements.forEach((element, index) => {
            let tl = gsap.timeline();
            tl.to(element, { duration: 0, opacity: 1, ease: "none" })
                .to(element, { duration: 1.5, text: texts[index], ease: "none" });

            if (index < typewriterElements.length - 1) {
                tl.to({}, { duration: 0 }); // Pause between texts
            }

            masterTimeline.add(tl);
        });

        masterTimeline.add(gsap.from('.gsap-button', {
            scale: 0.5,
            opacity: 0,
            duration: 0.5,
            ease: 'back.out(1.7)',
            stagger: 0.1
        }));
    }

    // Video container animation
    function animateVideoContainer() {
        const videoContainer = document.getElementById('video-container');
        if (!videoContainer) return;

        gsap.timeline({
            scrollTrigger: {
                trigger: "#video-container",
                start: "top bottom",
                end: "bottom top",
                scrub: true,
                toggleActions: "play none none none"
            }
        })
            .to("#video-container", {
                width: () => window.innerWidth <= 1086 ? "90%" : "90%",
                height: () => window.innerWidth <= 1086 ? "50vh" : "75vh",
                duration: 1,
                ease: "power2.inOut"
            })
            .to("#video-container", {
                width: () => window.innerWidth <= 1086 ? "50%" : "50%",
                height: () => window.innerWidth <= 1086 ? "50vh" : "50vh",
                duration: 1,
                ease: "power2.inOut"
            });
    }

    // Floating icons animation
    function animateFloatingIcons() {
        const iconConfigs = [
            { id: 'icon-pencil', initialPos: { x: -500, y: 1000 }, moveRange: 55 },
            { id: 'icon-rocket', initialPos: { x: -1000, y: 300 }, moveRange: 55 },
            { id: 'icon-tool-box', initialPos: { x: -3000, y: 1000 }, moveRange: 55 },
            { id: 'icon-video-lesson', initialPos: { x: -2300, y: 200 }, moveRange: 55 },
            { id: 'wrench', initialPos: { x: -2000, y: 1350 }, moveRange: 55 },
        ];

        iconConfigs.forEach(config => {
            const icon = document.getElementById(config.id);
            if (!icon) return;

            gsap.set(icon, {
                x: `${config.initialPos.x}%`,
                y: `${config.initialPos.y}%`,
                opacity: 0,
                rotation: gsap.utils.random(-15, 15)
            });

            gsap.to(icon, {
                opacity: 1,
                duration: 1,
                delay: gsap.utils.random(0, 0.5)
            });

            gsap.to(icon, {
                x: `-=${gsap.utils.random(-config.moveRange, config.moveRange)}`,
                y: `+=${gsap.utils.random(-config.moveRange, config.moveRange)}`,
                rotation: gsap.utils.random(-30, 30),
                duration: gsap.utils.random(3, 5),
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        });
    }

    // Comprehensive Learning Path section animation
    function animateComprehensiveLearningPath() {
        const section = document.querySelector('.comprehensive-learning-path');
        if (!section) return;

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: "top 80%",
                end: "bottom 20%",
                once: true
            }
        });

        tl.from(section.querySelector('h2'), {
            x: 50,
            opacity: 0,
            duration: 0.8,
            ease: "power3.out"
        })
            .from(section.querySelector('p.lead'), {
                x: 30,
                opacity: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.4")
            .from(section.querySelector('.separator'), {
                scaleX: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.4")
            .from(section.querySelector('h3'), {
                x: 30,
                opacity: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.4")
            .from(section.querySelector('.col-lg-6 p.lead'), {
                x: 30,
                opacity: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.6")
            .from(section.querySelectorAll('.list-unstyled li'), {
                x: 30,
                opacity: 0,
                duration: 0.5,
                stagger: 0.1,
                ease: "power3.out"
            }, "-=0.6")
            .from(section.querySelector('.btn'), {
                scale: 0.5,
                opacity: 0,
                duration: 0.5,
                ease: "back.out(1.7)"
            }, "-=0.4")
            .from(section.querySelector('.col-lg-6 img'), {
                x: -50,
                opacity: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.8")
            .from(section.querySelectorAll('.list-unstyled li img'), {
                scale: 0.5,
                opacity: 0,
                duration: 0.5,
                stagger: 0.1,
                ease: "back.out(1.7)"
            }, "-=0.8")
            .to(section.querySelectorAll('.list-unstyled li img'), {
                y: "random(-5, 5)",
                x: "random(-5, 5)",
                rotation: "random(-5, 5)",
                duration: 2,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut",
                stagger: {
                    each: 0.2,
                    from: "random"
                }
            }, "-=0.4");
    }

    function animateWhyChooseOurCourses() {
        const section = document.querySelector('.why-choose-our-courses');
        if (!section) return;

        gsap.set(section.querySelectorAll('.feature-card'), {
            opacity: 0,
            x: -50,
            rotationY: -15,
            transformPerspective: 1000
        });

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: "top 80%",
                end: "bottom 20%",
                toggleActions: "play none none none",
                once: true
            }
        });

        tl.from(section.querySelector('h2'), {
            x: 50,
            opacity: 0,
            duration: 0.8,
            ease: "power3.out"
        })
            .from(section.querySelector('p.lead'), {
                x: 30,
                opacity: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.4")
            .from(section.querySelector('.separator'), {
                scaleX: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.4")
            .to(section.querySelectorAll('.feature-card'), {
                opacity: 1,
                x: 0,
                rotationY: 0,
                stagger: 0.2,
                duration: 0.8,
                ease: "back.out(1.7)"
            }, "-=0.4")
            .from(section.querySelectorAll('.feature-number'), {
                scale: 0,
                opacity: 0,
                duration: 0.5,
                stagger: 0.1,
                ease: "back.out(1.7)"
            }, "-=1")

        // Add slow movement to feature numbers
        section.querySelectorAll('.feature-number img').forEach(img => {
            gsap.to(img, {
                y: "random(-10, 10)",
                x: "random(-10, 10)",
                rotation: "random(-10, 10)",
                duration: "random(3, 5)",
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut",
                delay: "random(0, 2)"
            });
        });

        // Add slow movement to feature icons
        section.querySelectorAll('.feature-icon img').forEach(img => {
            gsap.to(img, {
                y: "random(-3, 3)",
                x: "random(-3, 3)",
                rotation: "random(-3, 3)",
                duration: "random(4, 6)",
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut",
                delay: "random(0, 2)"
            });
        });

        // Add hover effect to feature cards
        section.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, {
                    x: 10,
                    boxShadow: "0 10px 20px rgba(0,0,0,0.2)",
                    duration: 0.3
                });
            });
            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    x: 0,
                    boxShadow: "0 5px 15px rgba(0,0,0,0.1)",
                    duration: 0.3
                });
            });
        });
    }

    function animateFooter() {
        const footer = document.querySelector('footer');
        if (!footer) return;

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: footer,
                start: "top 80%",
                once: true
            }
        });

        // Animate the logo and title
        tl.from(footer.querySelector('.d-flex.align-items-center'), {
            x: 30,
            opacity: 0,
            duration: 0.8,
            ease: "power3.out"
        })
            .from(footer.querySelector('p.pt-5.mx-5'), {
                x: 20,
                opacity: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.4")
            .from(footer.querySelectorAll('.list-unstyled.mx-5.pt-5 a'), {
                scale: 0,
                opacity: 0,
                duration: 0.5,
                stagger: 0.1,
                ease: "back.out(1.7)"
            }, "-=0.4");

        tl.from(footer.querySelectorAll('.col-lg-3 h5, .col-lg-3 ul li'), {
            x: 20,
            opacity: 0,
            duration: 0.5,
            stagger: 0.1,
            ease: "power3.out"
        }, "-=0.4");

        // Animate the copyright text
        tl.from(footer.querySelector('.text-center.p-3'), {
            y: 20,
            opacity: 0,
            duration: 0.8,
            ease: "power3.out"
        }, "-=0.4");

        // Add subtle floating animation to all images in the footer
        footer.querySelectorAll('img').forEach(img => {
            gsap.to(img, {
                y: "random(-5, 5)",
                x: "random(-5, 5)",
                rotation: "random(-3, 3)",
                duration: "random(3, 5)",
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut",
                delay: "random(0, 2)"
            });
        });
    }

    // Call all animation functions
    animateHeroSection();
    animateVideoContainer();
    animateFloatingIcons();
    animateComprehensiveLearningPath();
    animateWhyChooseOurCourses();
    animateContactUsSection();
    animateFooter();
});
