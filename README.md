# ARKLE HOMES - Premium Modern Architectural Website & Admin CMS

A complete, modern, and fully dynamic Laravel website and administrative CMS for **ARKLE HOMES**, crafted for luxury Australian home building, architectural townhouses, and bespoke living spaces.

---

## 🌟 Key Features

### 1. Dynamic Public Frontend
- **Homepage**: Architectural hero section with video modal, floating credentials card, two-column about story, 4 circular feature service cards, dynamic featured project showcase, dark cinematic commitment section with live stats, 5-star client testimonials, and dark luxury footer.
- **Projects Portfolio (`/projects`)**: 3-column responsive grid with AJAX category filtering (`All`, `Custom Homes`, `Townhouses`, `Renovations`, `Interiors`, `Residential`) and sorting (`Latest First`, `Oldest First`, `A-Z`) with zero page reloads.
- **Project Detail (`/projects/{slug}`)**: Full architectural specifications sheet (Bedrooms, Bathrooms, Garage, Land & House size, Year, Status), interactive photo gallery with responsive lightbox, feature highlights, and related project recommendations.
- **External Project Redirection**: Supports linking any project card directly to external listing URLs (e.g. Realestate.com.au) with `target="_blank" rel="noopener noreferrer"`.
- **About Page (`/about`)**: Company heritage, architectural vision, core values, craftsmanship standards, and step-by-step building process.
- **Design Philosophy (`/design`)**: Passive solar design, sustainability standards, and bespoke material curation.
- **Testimonials (`/testimonials`)**: Filterable reviews from verified Australian homeowners.
- **Contact Page (`/contact`)**: Interactive Google Maps embed, direct builder phone & office address, and contact form with AJAX submission, honeypot protection, database recording, and email notifications.
- **FAQ Page (`/faq`)**: Expandable accordion covering building permits, fixed-price contracts, warranties, and construction timelines.
- **Legal Compliance**: CMS-managed Privacy Policy and Terms & Conditions adhering to Australian Privacy Principles.
- **SEO & Search Engines**: Dynamic `sitemap.xml`, `robots.txt`, and per-page meta tag management.

---

### 2. Administrative CMS (`/admin`)
- **Authentication**: Secure role-based login (`Super Admin`, `Admin`, `Editor`) with session remember-me.
- **Dashboard Overview**: Live KPI metrics (Total Projects, Published, Drafts, Testimonials, Enquiries, Unread Leads).
- **Projects Management**: Complete CRUD, image uploads, specifications repeater, key features builder, external redirect URL toggle, one-click duplicate project, and publish toggles.
- **Project Categories**: Category creation, editing, and ordering.
- **Modular Page Builder**: Add, edit, reorder, and hide/show dynamic sections on any page.
- **Testimonials Manager**: Customer reviews, star ratings, and publication toggles.
- **Feature Services**: Manage the 4 core service cards with custom icons and copy.
- **Commitment Statistics**: Edit live counters (e.g. `50+ Homes Built`, `100+ Happy Clients`, `10+ Years Experience`).
- **Contact Enquiries Inbox**: Read/unread status manager, client details, staff notes, and CSV export.
- **Navigation Menus**: Header and footer link manager with target and ordering.
- **Header & Footer CMS**: Logo uploads, contact info, social links, and copyright text.
- **Media Library**: Multi-file uploader, image preview grid, and quick-copy public URLs.
- **SEO CMS**: Meta title, description, keywords, canonical URLs, and Open Graph share images.
- **Site Settings**: Centralized management of business name, phone, email, address, and Google Maps embed.

---

## 🛠️ Tech Stack & Architecture

- **Backend**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL / MariaDB (`arkle_homes`)
- **Architecture**: MVC with Eloquent ORM, Reusable Blade Components, Form Requests, and View Composers
- **Security**: CSRF protection, rate limiting (`throttle:10,1`), input sanitization, SQL injection immunity
- **Styling**: Luxury architectural theme featuring *Playfair Display* & *Plus Jakarta Sans*, `#FAF7F2` cream background, `#0D1C24` deep navy typography, and `#E5A93C` warm gold accents.

---

## 🚀 Installation & Local Setup

### 1. Prerequisites
- PHP >= 8.2 with `pdo_mysql`, `gd`, `mbstring`, `curl`, `fileinfo` extensions enabled
- Composer
- MySQL / MariaDB (e.g., via XAMPP)

### 2. Clone Repository
```bash
git clone https://github.com/manish09101996/arklehomes.git
cd arklehomes
```

### 3. Install Dependencies
```bash
composer install
```

### 4. Configure Environment
Copy `.env.example` to `.env` and configure your database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arkle_homes
DB_USERNAME=root
DB_PASSWORD=
FILESYSTEM_DISK=public
```

### 5. Link Storage Disk
```bash
php artisan storage:link
```

### 6. Run Migrations & Comprehensive Seeders
```bash
php artisan migrate:fresh --seed
```

### 7. Start Local Development Server
```bash
php artisan serve
```
Visit `http://localhost:8000` to view the public website.

---

## 🔐 Administrator Credentials

| Role | Email | Password |
|---|---|---|
| **Super Admin** | `admin@arklehomes.com.au` | `password123` |
| **Editor** | `editor@arklehomes.com.au` | `password123` |

Access dashboard at: **`/admin`** or **`http://localhost:8000/admin`**

---

## 📄 License
Proprietary software for Arkle Homes. All rights reserved.
