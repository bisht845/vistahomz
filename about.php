<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/settings.php';

$page_title = 'About VISTAHOMZ — Thoughtful Design, Lasting Craftsmanship';
$page_desc = 'Discover the VISTAHOMZ philosophy, our mission and vision, thoughtful craftsmanship, and furniture solutions for exceptional spaces.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<main class="vh-about-page">

    <!-- HERO -->
    <section class="vh-about-hero">
        <div class="vh-about-hero-image"></div>
        <div class="vh-about-hero-overlay"></div>

        <div class="vh-container vh-about-hero-content">
            <span class="vh-about-eyebrow">
                DESIGN THAT FEELS LIKE HOME
            </span>

            <h1>
                We believe great spaces<br>
                <em>tell beautiful stories.</em>
            </h1>

            <p>
                At VISTAHOMZ, we bring together thoughtful design,
                enduring materials and everyday comfort to create
                spaces that feel as exceptional as they look.
            </p>

            <a href="#our-story" class="vh-about-btn vh-about-btn-light">
                Discover Our Story
                <span aria-hidden="true">↗</span>
            </a>
        </div>

        <div class="vh-about-hero-note">
            THOUGHTFULLY DESIGNED. BEAUTIFULLY MADE.
        </div>
    </section>


    <!-- INTRO / OUR STORY -->
    <section class="vh-about-section vh-about-story" id="our-story">
        <div class="vh-container vh-about-story-grid">

            <div class="vh-about-story-image-wrap">
                <img
                    src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=1000&q=85"
                    alt="Warm, contemporary interior with carefully selected furniture"
                    class="vh-about-story-image"
                    loading="lazy"
                >

                <div class="vh-about-image-caption">
                    <span class="vh-about-caption-mark">V.</span>
                    <div>
                        <strong>Designed with intention</strong>
                        <span>Made for the way you live.</span>
                    </div>
                </div>
            </div>

            <div class="vh-about-story-copy">
                <span class="vh-about-eyebrow vh-about-eyebrow-dark">
                    THE VISTAHOMZ STORY
                </span>

                <h2>
                    More than furniture.<br>
                    <em>A feeling that stays.</em>
                </h2>

                <p>
                    At J.M. Infrastructure Sales Company, we aim to design furniture that
                    blends timeless style with everyday function. This project focuses on clean
                    lines, quality craftsmanship, and sustainable materials to create beautiful
                    and practical pieces.
                </p>

                <p>
                     Each design reflects our commitment to durability,
                    comfort, and aesthetic harmony.
                </p>

                <!-- <p>
                    From material selection to finishing and installation,
                    our approach focuses on thoughtful details, functional
                    design and quality that stands the test of time.
                </p> -->

                <a href="category.php" class="vh-about-text-link">
                    Explore Our Collection <span aria-hidden="true">→</span>
                </a>
            </div>

        </div>
    </section>


    <!-- MISSION & VISION -->
    <section class="vh-about-section vh-about-purpose">
        <div class="vh-container">

            <div class="vh-about-section-heading">
                <span class="vh-about-eyebrow">WHAT GUIDES US</span>
                <h2>
                    A clear purpose.<br>
                    <em>A lasting vision.</em>
                </h2>
                <p>
                    Every space has a purpose. Our role is to help it
                    become more beautiful, functional and meaningful.
                </p>
            </div>

            <div class="vh-about-purpose-grid">

                <article class="vh-about-purpose-card vh-about-mission">
                    <div class="vh-about-purpose-number">01</div>
                    <div class="vh-about-purpose-icon" aria-hidden="true">✳</div>

                    <span class="vh-about-card-label">OUR MISSION</span>

                    <h3>Make thoughtful design accessible to everyday life.</h3>

                    <p>
                        Our mission is to create furniture and interior
                        solutions that balance aesthetics, comfort and
                        functionality. We aim to make every space more
                        welcoming through careful design, dependable
                        materials and attention to detail.
                    </p>
                </article>

                <article class="vh-about-purpose-card vh-about-vision">
                    <div class="vh-about-purpose-number">02</div>
                    <div class="vh-about-purpose-icon" aria-hidden="true">◉</div>

                    <span class="vh-about-card-label">OUR VISION</span>

                    <h3>Shape spaces that continue to inspire.</h3>

                    <p>
                        Our vision is to be a trusted name in furniture
                        and spatial solutions, known for timeless design,
                        lasting value and a more considered approach to
                        the spaces where people live, work and connect.
                    </p>
                </article>

            </div>
        </div>
    </section>


    <!-- WHY VISTAHOMZ -->
    <section class="vh-about-section vh-about-why">
        <div class="vh-container">

            <div class="vh-about-why-heading">
                <div>
                    <span class="vh-about-eyebrow vh-about-eyebrow-dark">
                        THE DIFFERENCE IS IN THE DETAILS
                    </span>
                    <h2>
                        Why choose<br>
                        <em>VISTAHOMZ?</em>
                    </h2>
                </div>

                <p>
                    Good design is not only about what you see.
                    It is about how a space works, how it feels
                    and how well it serves you over time.
                </p>
            </div>

            <div class="vh-about-benefits-grid">

                <article class="vh-about-benefit">
                    <div class="vh-about-benefit-icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none">
                            <path d="M8 38V10h32v28M8 19h32M17 10v28M31 10v28M8 29h32"
                                stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <h3>Considered Design</h3>
                    <p>
                        Clean forms, thoughtful proportions and
                        practical details that complement modern spaces.
                    </p>
                </article>

                <article class="vh-about-benefit">
                    <div class="vh-about-benefit-icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none">
                            <path d="M24 5l5.5 12.5L42 23l-12.5 5.5L24 41l-5.5-12.5L6 23l12.5-5.5L24 5Z"
                                stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="24" cy="23" r="5" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <h3>Attention to Detail</h3>
                    <p>
                        A focus on finishes, materials and the small
                        touches that bring the complete design together.
                    </p>
                </article>

                <article class="vh-about-benefit">
                    <div class="vh-about-benefit-icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none">
                            <path d="M24 42S7 32 7 18a9 9 0 0 1 17-4 9 9 0 0 1 17 4c0 14-17 24-17 24Z"
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M15 25h7l4-8 4 13 3-5h4"
                                stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <h3>Everyday Comfort</h3>
                    <p>
                        Furniture solutions that consider the people
                        using them, not just the room they occupy.
                    </p>
                </article>

                <article class="vh-about-benefit">
                    <div class="vh-about-benefit-icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none">
                            <path d="M24 5 39 11v11c0 10-6.5 16.5-15 21C15.5 38.5 9 32 9 22V11l15-6Z"
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="m17 24 5 5 10-11"
                                stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <h3>Quality Focus</h3>
                    <p>
                        A considered approach to material selection,
                        finishing and quality checks throughout the process.
                    </p>
                </article>

            </div>
        </div>
    </section>


    <!-- LIFESTYLE IMAGE FEATURE -->
    <section class="vh-about-image-feature">
        <img
            src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=1800&q=85"
            alt="Beautifully styled living space with warm tones and contemporary furniture"
            loading="lazy"
        >

        <div class="vh-about-feature-shade"></div>

        <div class="vh-container vh-about-feature-content">
            <span class="vh-about-eyebrow">
                MADE FOR YOUR SPACE
            </span>
            <h2>
                Where function meets<br>
                <em>feeling.</em>
            </h2>
            <p>
                From welcoming homes to inspiring workplaces,
                we believe every environment deserves thoughtful design.
            </p>
        </div>
    </section>


    <!-- OUR APPROACH -->
    <section class="vh-about-section vh-about-process">
        <div class="vh-container">

            <div class="vh-about-section-heading">
                <span class="vh-about-eyebrow">FROM IDEA TO INSTALLATION</span>
                <h2>
                    Thoughtful at<br>
                    <em>every step.</em>
                </h2>
                <p>
                    A considered approach helps turn your requirements
                    into furniture solutions that work beautifully
                    in your space.
                </p>
            </div>

            <div class="vh-about-process-grid">

                <article class="vh-about-process-item">
                    <span class="vh-about-process-index">01 / DISCOVER</span>
                    <h3>We listen</h3>
                    <p>
                        We start by understanding your space, requirements,
                        preferences and intended use.
                    </p>
                </article>

                <article class="vh-about-process-item">
                    <span class="vh-about-process-index">02 / DESIGN</span>
                    <h3>We plan</h3>
                    <p>
                        We help you explore suitable styles, layouts,
                        materials and furniture solutions.
                    </p>
                </article>

                <article class="vh-about-process-item">
                    <span class="vh-about-process-index">03 / CREATE</span>
                    <h3>We refine</h3>
                    <p>
                        We focus on the details, finishes and quality
                        that bring the selected solution together.
                    </p>
                </article>

                <article class="vh-about-process-item">
                    <span class="vh-about-process-index">04 / COMPLETE</span>
                    <h3>We deliver</h3>
                    <p>
                        We coordinate the next steps toward bringing
                        your furniture vision into your space.
                    </p>
                </article>

            </div>
        </div>
    </section>


    <!-- CTA -->
    <section class="vh-about-cta">
        <div class="vh-about-cta-decoration" aria-hidden="true"></div>

        <div class="vh-container vh-about-cta-inner">
            <span class="vh-about-eyebrow">
                YOUR SPACE. YOUR STORY.
            </span>

            <h2>
                Let's create something<br>
                <em>remarkable together.</em>
            </h2>

            <p>
                Planning a home, refreshing a room or furnishing a
                commercial space? Let's talk about your requirements
                and explore the possibilities.
            </p>

            <div class="vh-about-cta-actions">
                <a href="contact.php" class="vh-about-btn vh-about-btn-light">
                    Book a Consultation
                    <span aria-hidden="true">↗</span>
                </a>
                <a
                    href="https://wa.me/917982895924?text=Hello%20VISTAHOMZ%2C%20I%20would%20like%20to%20discuss%20a%20furniture%20project."
                    class="vh-about-btn vh-about-btn-outline"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M20 11.5a8 8 0 0 1-11.9 7L4 20l1.5-4A8 8 0 1 1 20 11.5Z"
                            stroke="currentColor" stroke-width="1.7"
                            stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 9c.6 2 2 3.4 4 4l1.3-1.1 2 1c-.2 1.4-1.1 2.1-2.5 2.1-3.5-.5-6.2-3.2-6.7-6.7C7.1 7 7.8 6.1 9.2 6l1 2L9 9Z"
                            fill="currentColor"/>
                    </svg>
                    Chat on WhatsApp
                </a>
            </div>

            <span class="vh-about-cta-note">
                LET'S MAKE YOUR NEXT SPACE MEANINGFUL.
            </span>
        </div>
    </section>

</main>


<?php include __DIR__ . '/includes/footer.php'; ?>