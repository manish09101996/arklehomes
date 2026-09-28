<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\ProjectCategory;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectFeature;
use App\Models\ProjectSpecification;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\SeoMeta;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Users
        User::updateOrCreate(
            ['email' => 'admin@arklehomes.com.au'],
            [
                'name' => 'Arkle Admin',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@arklehomes.com.au'],
            [
                'name' => 'Arkle Editor',
                'password' => Hash::make('password123'),
                'role' => 'editor',
                'status' => 'active',
            ]
        );

        // 2. Site Settings
        $settings = [
            // Branding & General
            ['key' => 'site_name', 'value' => 'Arkle Homes', 'group' => 'branding', 'label' => 'Company Name'],
            ['key' => 'site_tagline', 'value' => 'Designed for Living. Built for Life.', 'group' => 'branding', 'label' => 'Tagline'],
            ['key' => 'site_logo', 'value' => 'images/logo/arkle-homes-logo.svg', 'group' => 'branding', 'type' => 'image', 'label' => 'Header Logo'],
            ['key' => 'site_logo_horizontal', 'value' => 'images/logo/arkle-homes-logo-horizontal.svg', 'group' => 'branding', 'type' => 'image', 'label' => 'Footer Logo'],
            ['key' => 'site_email', 'value' => 'sean@arklehomes.com.au', 'group' => 'contact', 'label' => 'Contact Email'],
            ['key' => 'site_phone', 'value' => '0430 331 187', 'group' => 'contact', 'label' => 'Phone Number'],
            ['key' => 'site_address', 'value' => '240 Emmersons Road Lovely Banks VIC 3213', 'group' => 'contact', 'label' => 'Office Address'],
            ['key' => 'site_abn', 'value' => '82 612 849 012', 'group' => 'contact', 'label' => 'ABN / License'],
            ['key' => 'opening_hours', 'value' => 'Monday - Friday: 8:30 AM - 5:00 PM | Saturday by Appointment', 'group' => 'contact', 'label' => 'Opening Hours'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100412.3918579493!2d144.29656461937965!3d-38.077271896796334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad416fef464d1f5%3A0x5045675218cd1d0!2sLovely%20Banks%20VIC%203213%2C%20Australia!5e0!3m2!1sen!2sau!4v1700000000000!5m2!1sen!2sau', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Google Maps Embed URL'],

            // Social
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/arklehomes', 'group' => 'social', 'label' => 'Facebook URL'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/arklehomes', 'group' => 'social', 'label' => 'Instagram URL'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/arklehomes', 'group' => 'social', 'label' => 'LinkedIn URL'],

            // Hero Section Settings
            ['key' => 'hero_eyebrow', 'value' => 'CUSTOM HOMES | TOWNHOUSES | RENOVATIONS', 'group' => 'hero', 'label' => 'Hero Eyebrow'],
            ['key' => 'hero_heading_1', 'value' => 'Designed for Living.', 'group' => 'hero', 'label' => 'Hero Heading (White)'],
            ['key' => 'hero_heading_2', 'value' => 'Built for Life.', 'group' => 'hero', 'label' => 'Hero Heading (Gold Accent)'],
            ['key' => 'hero_description', 'value' => 'We create modern, functional and timeless homes that reflect your lifestyle and stand the test of time.', 'group' => 'hero', 'type' => 'textarea', 'label' => 'Hero Description'],
            ['key' => 'hero_bg_image', 'value' => 'images/hero/hero-facade.jpg', 'group' => 'hero', 'type' => 'image', 'label' => 'Hero Background Image'],
            ['key' => 'hero_btn_1_text', 'value' => 'Our Projects', 'group' => 'hero', 'label' => 'Hero Button 1 Text'],
            ['key' => 'hero_btn_1_url', 'value' => '/projects', 'group' => 'hero', 'label' => 'Hero Button 1 URL'],
            ['key' => 'hero_btn_2_text', 'value' => 'Watch Our Work', 'group' => 'hero', 'label' => 'Hero Button 2 Text'],
            ['key' => 'hero_video_url', 'value' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'group' => 'hero', 'label' => 'Video Modal URL'],

            // Header CTA
            ['key' => 'header_cta_text', 'value' => 'Get in Touch', 'group' => 'header', 'label' => 'Header Button Text'],
            ['key' => 'header_cta_url', 'value' => '/contact', 'group' => 'header', 'label' => 'Header Button URL'],

            // About Section on Home
            ['key' => 'about_eyebrow', 'value' => 'ABOUT ARKLE HOMES', 'group' => 'homepage', 'label' => 'About Section Eyebrow'],
            ['key' => 'about_heading', 'value' => 'Crafting Timeless Spaces for Modern Living', 'group' => 'homepage', 'label' => 'About Section Heading'],
            ['key' => 'about_description', 'value' => 'At Arkle Homes, we combine innovative design, quality materials and expert craftsmanship to deliver homes that inspire. From concept to completion, we focus on every detail to create spaces that are beautiful, functional and built to last.', 'group' => 'homepage', 'type' => 'textarea', 'label' => 'About Section Description'],
            ['key' => 'about_image', 'value' => 'images/about/about-kitchen.jpg', 'group' => 'homepage', 'type' => 'image', 'label' => 'About Section Image'],
            ['key' => 'about_btn_text', 'value' => 'Learn More', 'group' => 'homepage', 'label' => 'About Button Text'],
            ['key' => 'about_btn_url', 'value' => '/about', 'group' => 'homepage', 'label' => 'About Button URL'],

            // Commitment Section
            ['key' => 'commitment_eyebrow', 'value' => 'OUR COMMITMENT', 'group' => 'homepage', 'label' => 'Commitment Eyebrow'],
            ['key' => 'commitment_heading', 'value' => 'We Build More Than Homes', 'group' => 'homepage', 'label' => 'Commitment Heading'],
            ['key' => 'commitment_description', 'value' => 'Every project is a partnership. We are committed to delivering exceptional quality, honest communication and homes that inspire for generations.', 'group' => 'homepage', 'type' => 'textarea', 'label' => 'Commitment Description'],
            ['key' => 'commitment_bg', 'value' => 'images/hero/commitment-bg.jpg', 'group' => 'homepage', 'type' => 'image', 'label' => 'Commitment Background Image'],

            // CTA Banner
            ['key' => 'cta_title', 'value' => 'Ready to Create Your Legacy?', 'group' => 'homepage', 'label' => 'Global CTA Title'],
            ['key' => 'cta_description', 'value' => 'Partner with Arkle Homes to build a timeless residence tailored specifically to your family and lifestyle.', 'group' => 'homepage', 'type' => 'textarea', 'label' => 'Global CTA Description'],
            ['key' => 'cta_btn_text', 'value' => 'Start Your Project', 'group' => 'homepage', 'label' => 'Global CTA Button Text'],
            ['key' => 'cta_btn_url', 'value' => '/contact', 'group' => 'homepage', 'label' => 'Global CTA Button URL'],

            // Footer
            ['key' => 'footer_description', 'value' => 'Creating homes of architectural distinction where timeless design meets modern living.', 'group' => 'footer', 'label' => 'Footer Description'],
            ['key' => 'footer_copyright', 'value' => '© 2026 Arkle Homes. All rights reserved.', 'group' => 'footer', 'label' => 'Footer Copyright Text'],
        ];

        foreach ($settings as $item) {
            SiteSetting::updateOrCreate(
                ['key' => $item['key']],
                [
                    'value' => $item['value'],
                    'group' => $item['group'],
                    'type' => $item['type'] ?? 'text',
                    'label' => $item['label'] ?? ucwords(str_replace('_', ' ', $item['key'])),
                ]
            );
        }

        // 3. Project Categories
        $categoriesData = [
            ['name' => 'Custom Homes', 'slug' => 'custom-homes', 'description' => 'Architecturally designed bespoke homes built to individual specifications.', 'order' => 1],
            ['name' => 'Townhouses', 'slug' => 'townhouses', 'description' => 'Sophisticated multi-dwelling and contemporary townhouse developments.', 'order' => 2],
            ['name' => 'Renovations', 'slug' => 'renovations', 'description' => 'Transformative high-end architectural extensions and luxury renovations.', 'order' => 3],
            ['name' => 'Interiors', 'slug' => 'interiors', 'description' => 'Refined interior fitouts, custom joinery, and luxury living spaces.', 'order' => 4],
            ['name' => 'Residential', 'slug' => 'residential', 'description' => 'Premium single-dwelling modern family residences.', 'order' => 5],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = ProjectCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Projects (with dynamic external URL support matching screenshot & prompt)
        $projectsData = [
            [
                'title' => 'Modern Family Home',
                'slug' => 'modern-family-home',
                'category_id' => $categories['residential']->id,
                'location' => 'Geelong, VIC',
                'short_description' => 'A refined contemporary single-storey family home crafted with warm cedar accents, natural render and expansive glass.',
                'full_description' => '<p>Designed for effortless family living, this modern residence brings together timeless materiality and contemporary architectural clarity. An open-concept living zone is illuminated by high ceilings and expansive windows, connecting the designer stone kitchen seamlessly to the landscaped outdoor entertaining deck.</p><p>Featuring custom joinery throughout, zoned ducted climate control, energy-efficient glazing, and a private master retreat, this home embodies Arkle Homes\' signature craftsmanship.</p>',
                'status' => 'Completed',
                'completion_date' => '2025-08-15',
                'client_name' => 'Private Client',
                'project_type' => 'Residential',
                'bedrooms' => 4,
                'bathrooms' => 2,
                'garage' => 2,
                'land_size' => '540 m²',
                'house_size' => '285 m²',
                'year' => '2025',
                'featured_image' => 'projects/project-1-modern-family.jpg',
                'is_featured' => true,
                'is_published' => true,
                'order' => 1,
                'link_type' => 'internal',
                'external_url' => null,
                'open_new_tab' => false,
                'seo_title' => 'Modern Family Home Geelong | Arkle Homes',
                'seo_description' => 'Explore this contemporary residential family home built by Arkle Homes in Geelong, VIC.',
            ],
            [
                'title' => 'Contemporary Townhouse',
                'slug' => 'contemporary-townhouse',
                'category_id' => $categories['townhouses']->id,
                'location' => 'Lovely Banks, VIC',
                'short_description' => 'Striking two-storey modern townhouse development blending industrial architectural elements with warm Scandinavian interior tones.',
                'full_description' => '<p>A masterclass in modern spatial efficiency and architectural elegance. This dual-level townhouse showcases bold charcoal cladding juxtaposed against warm off-white renders, black-framed commercial-grade glazing, and designer exterior lighting.</p><p>Internally, generous floor-to-ceiling proportions create an inviting, luminous ambience. Engineered European oak floors lead toward a gourmet kitchen equipped with integrated European appliances and engineered quartz surfaces.</p>',
                'status' => 'Completed',
                'completion_date' => '2025-04-20',
                'client_name' => 'Boutique Property Group',
                'project_type' => 'Townhouse',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'garage' => 2,
                'land_size' => '380 m²',
                'house_size' => '220 m²',
                'year' => '2025',
                'featured_image' => 'projects/project-2-townhouse.jpg',
                'is_featured' => true,
                'is_published' => true,
                'order' => 2,
                'link_type' => 'internal',
                'external_url' => null,
                'open_new_tab' => false,
                'seo_title' => 'Contemporary Townhouse Lovely Banks | Arkle Homes',
                'seo_description' => 'Modern luxury townhouse development in Lovely Banks by Arkle Homes.',
            ],
            [
                'title' => 'Elegant Interiors',
                'slug' => 'elegant-interiors',
                'category_id' => $categories['interiors']->id,
                'location' => 'Newtown, VIC',
                'short_description' => 'Curated luxury interior overhaul highlighting bespoke timber finishes, recessed architectural lighting, and natural textures.',
                'full_description' => '<p>Every line, texture, and light source was carefully calibrated in this bespoke interior design project. The living room radiates warmth and calm through a harmonious palette of soft linen upholstery, fluted oak millwork, and brass accent details.</p><p>The adjoining open kitchen features custom shaker-profile cabinets, soft-close Blum hardware, and seamless marble countertops with an under-mount sink.</p>',
                'status' => 'Completed',
                'completion_date' => '2024-11-10',
                'client_name' => 'The Gill Residence',
                'project_type' => 'Interiors',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'garage' => 2,
                'land_size' => '620 m²',
                'house_size' => '340 m²',
                'year' => '2024',
                'featured_image' => 'projects/project-3-interiors.jpg',
                'is_featured' => true,
                'is_published' => true,
                'order' => 3,
                'link_type' => 'internal',
                'external_url' => null,
                'open_new_tab' => false,
                'seo_title' => 'Luxury Interior Architecture Newtown | Arkle Homes',
                'seo_description' => 'Bespoke modern residential interior architecture and custom joinery by Arkle Homes.',
            ],
            [
                'title' => 'Sunbury Haven',
                'slug' => 'sunbury-haven',
                'category_id' => $categories['custom-homes']->id,
                'location' => 'Sunbury, VIC',
                'short_description' => 'Grand custom architectural estate featuring open-plan luxury living, premium alfresco entertaining, and panoramic valley views.',
                'full_description' => '<p>Crafted to the highest standard of luxury living, Sunbury Haven showcases expansive entertaining zones, soaring ceilings, bespoke custom cabinetry, and seamless indoor-outdoor integration.</p>',
                'status' => 'Completed',
                'completion_date' => '2024-06-30',
                'client_name' => 'Private Buyer',
                'project_type' => 'Custom Home',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'garage' => 2,
                'land_size' => '650 m²',
                'house_size' => '320 m²',
                'year' => '2024',
                'featured_image' => 'projects/project-4-coastal.jpg',
                'is_featured' => true,
                'is_published' => true,
                'order' => 4,
                // User explicit demonstration: External redirect
                'link_type' => 'external',
                'external_url' => 'https://www.realestate.com.au/sold/property-house-vic-sunbury-142916044',
                'open_new_tab' => true,
                'seo_title' => 'Sunbury Haven Luxury Home | Arkle Homes',
                'seo_description' => 'Sold architectural custom home in Sunbury VIC.',
            ],
            [
                'title' => 'The Bellarine Coastal Villa',
                'slug' => 'the-bellarine-coastal-villa',
                'category_id' => $categories['custom-homes']->id,
                'location' => 'Ocean Grove, VIC',
                'short_description' => 'Modern coastal residence built to withstand maritime climate with ram-earth feature walls and expansive timber sundecks.',
                'full_description' => '<p>Perched near the Bellarine coast, this striking modern villa blends high thermal-performance construction with relaxed coastal opulence. Large-format glazed doors retract completely to merge internal lounge spaces with outdoor salt-water pool terraces.</p>',
                'status' => 'Completed',
                'completion_date' => '2025-01-18',
                'client_name' => 'Coastal Investments',
                'project_type' => 'Custom Home',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'garage' => 3,
                'land_size' => '850 m²',
                'house_size' => '410 m²',
                'year' => '2025',
                'featured_image' => 'projects/project-5-minimalist.jpg',
                'is_featured' => false,
                'is_published' => true,
                'order' => 5,
                'link_type' => 'internal',
                'external_url' => null,
                'open_new_tab' => false,
                'seo_title' => 'The Bellarine Coastal Villa | Arkle Homes',
                'seo_description' => 'Bespoke coastal luxury home in Ocean Grove VIC by Arkle Homes.',
            ],
            [
                'title' => 'The Minimalist Pavilion',
                'slug' => 'the-minimalist-pavilion',
                'category_id' => $categories['custom-homes']->id,
                'location' => 'Barwon Heads, VIC',
                'short_description' => 'Minimalist pavilion home focusing on natural light, cross-ventilation, and seamless connection to native landscape.',
                'full_description' => '<p>An architectural triumph prioritizing restraint, balance, and spatial purity. The living wing floats lightly above landscaped native gardens, framed by slimline black aluminium glazing and burnished concrete floors.</p>',
                'status' => 'Under Construction',
                'completion_date' => '2026-03-30',
                'client_name' => 'Private Residence',
                'project_type' => 'Custom Home',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'garage' => 2,
                'land_size' => '720 m²',
                'house_size' => '360 m²',
                'year' => '2026',
                'featured_image' => 'projects/project-6-residence.jpg',
                'is_featured' => false,
                'is_published' => true,
                'order' => 6,
                'link_type' => 'internal',
                'external_url' => null,
                'open_new_tab' => false,
                'seo_title' => 'The Minimalist Pavilion | Arkle Homes',
                'seo_description' => 'Award-winning minimalist architecture in Barwon Heads by Arkle Homes.',
            ],
        ];

        foreach ($projectsData as $pData) {
            $project = Project::updateOrCreate(['slug' => $pData['slug']], $pData);

            // Add specifications
            if ($project->bedrooms) {
                ProjectSpecification::updateOrCreate(
                    ['project_id' => $project->id, 'spec_name' => 'Bedrooms'],
                    ['spec_value' => (string)$project->bedrooms, 'order' => 1]
                );
            }
            if ($project->bathrooms) {
                ProjectSpecification::updateOrCreate(
                    ['project_id' => $project->id, 'spec_name' => 'Bathrooms'],
                    ['spec_value' => (string)$project->bathrooms, 'order' => 2]
                );
            }
            if ($project->garage) {
                ProjectSpecification::updateOrCreate(
                    ['project_id' => $project->id, 'spec_name' => 'Garage Spaces'],
                    ['spec_value' => (string)$project->garage, 'order' => 3]
                );
            }
            if ($project->land_size) {
                ProjectSpecification::updateOrCreate(
                    ['project_id' => $project->id, 'spec_name' => 'Land Size'],
                    ['spec_value' => $project->land_size, 'order' => 4]
                );
            }
            if ($project->house_size) {
                ProjectSpecification::updateOrCreate(
                    ['project_id' => $project->id, 'spec_name' => 'House Size'],
                    ['spec_value' => $project->house_size, 'order' => 5]
                );
            }

            // Add features
            $sampleFeatures = [
                'Architectural Open-Plan Living',
                'Custom Stone Benchtop & Butler’s Pantry',
                'Commercial Double-Glazed Joinery',
                'Zoned Climate Control & Smart Automation',
            ];
            foreach ($sampleFeatures as $idx => $fTitle) {
                ProjectFeature::updateOrCreate(
                    ['project_id' => $project->id, 'title' => $fTitle],
                    ['description' => 'Premium architectural standard.', 'order' => $idx + 1]
                );
            }

            // Add gallery images
            $gallery = [
                'projects/gallery-1.jpg',
                'projects/gallery-2.jpg',
                'projects/gallery-3.jpg',
                'projects/gallery-4.jpg',
            ];
            foreach ($gallery as $gIdx => $gPath) {
                ProjectImage::updateOrCreate(
                    ['project_id' => $project->id, 'image_path' => $gPath],
                    ['caption' => $project->title . ' Interior view', 'alt_text' => $project->title, 'order' => $gIdx + 1]
                );
            }
        }

        // 5. Services (4 Feature Cards matching the screenshot)
        $servicesData = [
            [
                'title' => 'Custom Designs',
                'slug' => 'custom-designs',
                'description' => 'Tailored homes to suit your lifestyle.',
                'icon' => 'home',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Premium Quality',
                'slug' => 'premium-quality',
                'description' => 'Superior materials and craftsmanship.',
                'icon' => 'diamond',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'End-to-End Service',
                'slug' => 'end-to-end-service',
                'description' => 'From design to handover, we manage it all.',
                'icon' => 'settings',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Client Focused',
                'slug' => 'client-focused',
                'description' => 'Your vision, our priority.',
                'icon' => 'users',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($servicesData as $s) {
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }

        // 6. Statistics (Commitment counters matching screenshot)
        $statsData = [
            ['number' => '50+', 'label' => 'Homes Built', 'icon' => 'home', 'order' => 1],
            ['number' => '100+', 'label' => 'Happy Clients', 'icon' => 'users', 'order' => 2],
            ['number' => '10+', 'label' => 'Years Experience', 'icon' => 'trophy', 'order' => 3],
        ];

        foreach ($statsData as $st) {
            Statistic::updateOrCreate(['label' => $st['label']], $st);
        }

        // 7. Testimonials (exact quotes from screenshot)
        $testimonialsData = [
            [
                'client_name' => 'S. Kaur',
                'client_role' => 'Home Owner',
                'review' => 'Arkle Homes made the entire process stress-free. The quality and attention to detail exceeded our expectations.',
                'rating' => 5,
                'location' => 'Geelong, VIC',
                'is_featured' => true,
                'is_published' => true,
                'order' => 1,
            ],
            [
                'client_name' => 'R. Singh',
                'client_role' => 'Home Owner',
                'review' => 'Professional, reliable and easy to work with. Our new home is exactly what we envisioned.',
                'rating' => 5,
                'location' => 'Lovely Banks, VIC',
                'is_featured' => true,
                'is_published' => true,
                'order' => 2,
            ],
            [
                'client_name' => 'A. Gill',
                'client_role' => 'Home Owner',
                'review' => 'From design to completion, the team was outstanding. Highly recommend Arkle Homes.',
                'rating' => 5,
                'location' => 'Newtown, VIC',
                'is_featured' => true,
                'is_published' => true,
                'order' => 3,
            ],
            [
                'client_name' => 'Marcus & Elena V.',
                'client_role' => 'Custom Home Clients',
                'review' => 'The architectural integrity and transparent communication throughout our build gave us absolute peace of mind. Arkle Homes is the gold standard.',
                'rating' => 5,
                'location' => 'Ocean Grove, VIC',
                'is_featured' => true,
                'is_published' => true,
                'order' => 4,
            ],
        ];

        foreach ($testimonialsData as $t) {
            Testimonial::updateOrCreate(['client_name' => $t['client_name']], $t);
        }

        // 8. FAQs
        $faqsData = [
            [
                'category' => 'General',
                'question' => 'How long does a custom home build typically take?',
                'answer' => 'Build timelines generally range from 7 to 12 months depending on the scale, architectural complexity, and site topography. During your pre-construction phase, we establish a comprehensive fixed-timeline schedule so you are informed of every milestone.',
                'order' => 1,
            ],
            [
                'category' => 'Pricing & Contracts',
                'question' => 'Do you provide fixed-price building contracts?',
                'answer' => 'Yes. At Arkle Homes we believe in total transparency. Following soil tests, site surveys, and finalised architectural specifications, we present a comprehensive Master Builders fixed-price contract with zero hidden surprises.',
                'order' => 2,
            ],
            [
                'category' => 'Design & Process',
                'question' => 'Can we bring our own architectural drawings or design concepts?',
                'answer' => 'Absolutely. Whether you already have finalised plans from an architect or are starting from a blank page with our in-house architectural design team, we guide you seamlessly through engineering, permits, and construction.',
                'order' => 3,
            ],
            [
                'category' => 'Warranty',
                'question' => 'What warranty and structural guarantees do Arkle Homes offer?',
                'answer' => 'All our projects are backed by mandatory Victorian Domestic Building Insurance, a comprehensive 7-year structural warranty, and our dedicated post-handover maintenance inspection at 3 and 12 months.',
                'order' => 4,
            ],
            [
                'category' => 'Approvals',
                'question' => 'How do you manage council permits and planning approvals in Victoria?',
                'answer' => 'We handle the entire planning process from start to finish, managing town planning applications, building surveyors, energy ratings, and council permits across the Greater Geelong, Melbourne, and Surf Coast regions.',
                'order' => 5,
            ],
        ];

        foreach ($faqsData as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }

        // 9. Navigation Menus
        $headerMenu = Menu::updateOrCreate(
            ['location' => 'header'],
            ['name' => 'Main Navigation']
        );

        $headerLinks = [
            ['label' => 'Home', 'url' => '/', 'order' => 1],
            ['label' => 'About', 'url' => '/about', 'order' => 2],
            ['label' => 'Design', 'url' => '/design', 'order' => 3],
            ['label' => 'Projects', 'url' => '/projects', 'order' => 4],
            ['label' => 'Testimonials', 'url' => '/testimonials', 'order' => 5],
            ['label' => 'Contact', 'url' => '/contact', 'order' => 6],
        ];

        foreach ($headerLinks as $link) {
            MenuItem::updateOrCreate(
                ['menu_id' => $headerMenu->id, 'label' => $link['label']],
                ['url' => $link['url'], 'order' => $link['order'], 'is_active' => true]
            );
        }

        $footerMenu = Menu::updateOrCreate(
            ['location' => 'footer_quick_links'],
            ['name' => 'Footer Quick Links']
        );

        $footerLinks = [
            ['label' => 'Home', 'url' => '/', 'order' => 1],
            ['label' => 'About Us', 'url' => '/about', 'order' => 2],
            ['label' => 'Design Philosophy', 'url' => '/design', 'order' => 3],
            ['label' => 'Projects', 'url' => '/projects', 'order' => 4],
            ['label' => 'Testimonials', 'url' => '/testimonials', 'order' => 5],
            ['label' => 'Contact', 'url' => '/contact', 'order' => 6],
        ];

        foreach ($footerLinks as $link) {
            MenuItem::updateOrCreate(
                ['menu_id' => $footerMenu->id, 'label' => $link['label']],
                ['url' => $link['url'], 'order' => $link['order'], 'is_active' => true]
            );
        }

        $legalMenu = Menu::updateOrCreate(
            ['location' => 'footer_legal'],
            ['name' => 'Legal Links']
        );

        $legalLinks = [
            ['label' => 'Privacy Policy', 'url' => '/privacy-policy', 'order' => 1],
            ['label' => 'Terms & Conditions', 'url' => '/terms-and-conditions', 'order' => 2],
        ];

        foreach ($legalLinks as $link) {
            MenuItem::updateOrCreate(
                ['menu_id' => $legalMenu->id, 'label' => $link['label']],
                ['url' => $link['url'], 'order' => $link['order'], 'is_active' => true]
            );
        }

        // 10. Pages
        $pagesData = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'subtitle' => 'Designed for Living. Built for Life.',
                'hero_badge' => 'CUSTOM HOMES | TOWNHOUSES | RENOVATIONS',
                'hero_image' => 'images/hero/hero-facade.jpg',
                'hero_video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'seo_title' => 'Arkle Homes | Luxury Australian Home Builder',
                'seo_description' => 'Arkle Homes crafts modern, functional and timeless architectural homes across Geelong, Lovely Banks and Melbourne.',
            ],
            [
                'title' => 'About Arkle Homes',
                'slug' => 'about',
                'subtitle' => 'Crafting architectural distinction with uncompromising integrity.',
                'hero_badge' => 'OUR HERITAGE & VISION',
                'hero_image' => 'images/about/about-kitchen.jpg',
                'content' => '<p>At Arkle Homes, we believe a home is more than an arrangement of rooms—it is the setting for your life’s most cherished memories. Founded on principles of architectural innovation, transparent client collaboration, and superior Australian craftsmanship, we deliver homes of enduring prestige.</p><p>From concept to handover, we manage every detail with dedication and care, ensuring a stress-free and rewarding building journey.</p>',
                'seo_title' => 'About Arkle Homes | Luxury Builders in Victoria',
                'seo_description' => 'Discover our story, craft, and commitment to creating exceptional residences tailored to your lifestyle.',
            ],
            [
                'title' => 'Design Philosophy',
                'slug' => 'design',
                'subtitle' => 'Form follows lifestyle. Every detail conceived with intention.',
                'hero_badge' => 'OUR ARCHITECTURAL PHILOSOPHY',
                'hero_image' => 'images/hero/hero-facade.jpg',
                'content' => '<p>Our architectural philosophy balances modern aesthetic luxury with functional, practical livability. We consider passive solar orientation, natural ventilation, material longevity, and seamless interior-exterior connection in every blueprint.</p>',
                'seo_title' => 'Design Philosophy | Arkle Homes Architecture',
                'seo_description' => 'Explore our architectural principles, sustainable practices, and bespoke design process.',
            ],
            [
                'title' => 'Projects Portfolio',
                'slug' => 'projects',
                'subtitle' => 'Explore our collection of completed homes and architectural projects.',
                'hero_badge' => 'PORTFOLIO OF EXCELLENCE',
                'hero_image' => 'images/hero/hero-facade.jpg',
                'seo_title' => 'Projects | Arkle Homes Portfolio',
                'seo_description' => 'Explore our portfolio of completed luxury custom homes, townhouses, and renovations.',
            ],
            [
                'title' => 'Client Testimonials',
                'slug' => 'testimonials',
                'subtitle' => 'What our homeowners say about their building experience.',
                'hero_badge' => 'VERIFIED CLIENT REVIEWS',
                'hero_image' => 'images/hero/hero-facade.jpg',
                'seo_title' => 'Client Reviews & Testimonials | Arkle Homes',
                'seo_description' => 'Read verified reviews from homeowners who partnered with Arkle Homes.',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'subtitle' => 'Ready to start your building journey? Speak with our principal builder today.',
                'hero_badge' => 'GET IN TOUCH',
                'hero_image' => 'images/hero/hero-facade.jpg',
                'seo_title' => 'Contact Arkle Homes | Start Your Custom Home Project',
                'seo_description' => 'Contact Sean and the Arkle Homes team at 240 Emmersons Road, Lovely Banks or call 0430 331 187.',
            ],
            [
                'title' => 'Frequently Asked Questions',
                'slug' => 'faq',
                'subtitle' => 'Common questions regarding the custom home building process in Australia.',
                'hero_badge' => 'BUILDING CLARITY',
                'hero_image' => 'images/hero/hero-facade.jpg',
                'seo_title' => 'Frequently Asked Questions | Arkle Homes',
                'seo_description' => 'Find answers to common questions about building timelines, contracts, permits, and design.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'subtitle' => 'Our commitment to protecting your privacy and personal information.',
                'hero_badge' => 'LEGAL & COMPLIANCE',
                'content' => '<h2>Privacy Policy</h2><p>Arkle Homes is committed to providing quality services to you and this policy outlines our ongoing obligations to you in respect of how we manage your Personal Information.</p><p>We have adopted the Australian Privacy Principles (APPs) contained in the Privacy Act 1988 (Cth). A copy of the Australian Privacy Principles may be obtained from the website of The Office of the Australian Information Commissioner at www.oaic.gov.au.</p><h3>What is Personal Information and why do we collect it?</h3><p>Personal Information is information or an opinion that identifies an individual. Examples of Personal Information we collect include: names, addresses, email addresses, and phone numbers. This information is obtained in many ways including through website enquiries, correspondence, telephone, and email.</p><h3>Security of Personal Information</h3><p>Your Personal Information is stored in a manner that reasonably protects it from misuse and loss and from unauthorized access, modification or disclosure.</p>',
                'seo_title' => 'Privacy Policy | Arkle Homes',
                'seo_description' => 'Arkle Homes Australian Privacy Policy.',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'subtitle' => 'Terms and conditions governing the use of this website.',
                'hero_badge' => 'TERMS OF USE',
                'content' => '<h2>Terms and Conditions of Use</h2><p>Welcome to the Arkle Homes website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use.</p><h3>Intellectual Property</h3><p>This website contains material which is owned by or licensed to us, including architectural photography, plan diagrams, graphics, and design layouts. Reproduction is strictly prohibited without written consent.</p><h3>Disclaimer</h3><p>The information contained in this website is for general information purposes only. While we endeavor to keep the information up to date and correct, we make no representations or warranties of any kind.</p>',
                'seo_title' => 'Terms & Conditions | Arkle Homes',
                'seo_description' => 'Terms of use for the Arkle Homes website.',
            ],
        ];

        foreach ($pagesData as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // 11. Global SEO Meta Defaults
        $seoDefaults = [
            [
                'route_name' => 'home',
                'url_path' => '/',
                'meta_title' => 'Arkle Homes | Designed for Living. Built for Life.',
                'meta_description' => 'Bespoke custom homes, modern townhouses, and luxury architectural renovations by Arkle Homes across Victoria.',
                'meta_keywords' => 'custom homes, builder geelong, modern home builders, luxury residences, townhouses melbourne, arkle homes',
            ],
            [
                'route_name' => 'projects.index',
                'url_path' => '/projects',
                'meta_title' => 'Completed Projects Portfolio | Arkle Homes',
                'meta_description' => 'Explore our completed residential builds, architectural townhouses, and bespoke interiors.',
                'meta_keywords' => 'arkle homes projects, geelong house builds, architectural homes portfolio',
            ],
            [
                'route_name' => 'contact',
                'url_path' => '/contact',
                'meta_title' => 'Get in Touch | Arkle Homes Lovely Banks',
                'meta_description' => 'Contact Arkle Homes today to discuss your new custom home or renovation. Phone 0430 331 187.',
                'meta_keywords' => 'contact arkle homes, builder quote, lovely banks builder',
            ],
        ];

        foreach ($seoDefaults as $meta) {
            SeoMeta::updateOrCreate(['url_path' => $meta['url_path']], $meta);
        }
    }
}
