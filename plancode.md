# CMS WEBSITE PLAN

## Laravel 13 + PHP 8.3 + MySQL

---

# PROJECT OVERVIEW

Membangun Content Management System (CMS) modern berbasis Laravel yang memiliki konsep seperti WordPress namun lebih ringan, modular, dan mudah dikembangkan.

Seluruh konten website dapat dikelola melalui panel admin, termasuk:

* Halaman
* Berita
* Menu
* Banner
* Media
* Pengaturan Website
* SEO
* Pengguna

Konten awal menggunakan template sehingga mudah di-maintenance dan dikembangkan pada fase berikutnya.

---

# TECHNOLOGY STACK

## Backend

* Laravel 13
* PHP 8.3
* MySQL 8.x
* Laravel Queue
* Laravel Cache
* Laravel Scheduler
* Laravel Policies
* Laravel Form Request Validation

---

## Frontend

* Blade Template Engine
* Tailwind CSS 4
* Alpine.js
* Vite

---

## Database

* MySQL 8.x

Character Set:

utf8mb4

Collation:

utf8mb4_unicode_ci

---

## Infrastructure

* Ubuntu Server 24.04 LTS
* Nginx
* PHP-FPM 8.3
* Redis (Cache & Queue)
* Supervisor
* SSL/TLS

---

# SYSTEM ARCHITECTURE

Presentation Layer
↓
Controller Layer
↓
Service Layer
↓
Repository Layer
↓
Database Layer

---

# MODULE STRUCTURE

app/

Modules/

* Dashboard
* Page
* Post
* Category
* Tag
* Media
* Menu
* Setting
* User
* Contact
* SEO

Setiap module memiliki:

* Controller
* Service
* Repository
* Request
* Policy
* Model
* Views

Sehingga mudah di-maintenance.

---

# FRONTEND FEATURES

## Homepage

Komponen:

* Hero Section
* Website Introduction
* Featured News
* Featured Pages
* Statistics
* CTA Section
* Footer

Semua data berasal dari database.

---

## Dynamic Pages

Contoh:

/tentang
/visi-misi
/layanan
/profil

Field:

* Title
* Slug
* Content
* Featured Image
* Meta Title
* Meta Description
* Status
* Published At

---

## News / Articles

URL:

/berita

/berita/{slug}

Field:

* Title
* Slug
* Excerpt
* Content
* Thumbnail
* Category
* Tags
* Author
* Publish Date
* SEO Metadata

---

## Search Engine

Pencarian:

* Halaman
* Berita

Fitur:

* Keyword Search
* Pagination

---

## Contact Page

Form:

* Nama
* Email
* Nomor Telepon
* Subjek
* Pesan

Tersimpan ke database.

---

# ADMIN PANEL

## Dashboard

Statistik:

* Total Berita
* Total Halaman
* Total Pengguna
* Total Pesan
* Total Media

---

## Page Management

CRUD:

* Create
* Read
* Update
* Delete
* Publish
* Draft

---

## News Management

CRUD:

* Create
* Read
* Update
* Delete
* Publish
* Draft

---

## Category Management

CRUD kategori berita.

---

## Tag Management

CRUD tag berita.

---

## Media Manager

Upload:

* JPG
* PNG
* WEBP
* SVG
* PDF

Fitur:

* Upload
* Delete
* Preview
* Copy URL

---

## Menu Builder

Lokasi:

* Header Menu
* Footer Menu

Fitur:

* Drag & Drop
* Nested Menu

---

## Banner Manager

Fitur:

* Hero Banner
* Promotional Banner
* CTA Banner

Field:

* Title
* Description
* Image
* Button Text
* Button URL

---

## Settings Manager

### General

* Website Name
* Website Description
* Logo
* Favicon

### Contact

* Email
* Phone
* Address

### Social Media

* Facebook
* Instagram
* LinkedIn
* YouTube
* TikTok

### SEO

* Default Meta Title
* Default Meta Description
* Keywords

---

## User Management

Role:

### Super Admin

Full Access

### Admin

Content Management

### Editor

News & Pages

### Author

Own Content Only

---

# DATABASE DESIGN

## users

* id
* name
* email
* password
* role
* email_verified_at
* remember_token
* timestamps

---

## pages

* id
* title
* slug
* content
* featured_image
* meta_title
* meta_description
* status
* published_at
* created_by
* timestamps

---

## posts

* id
* category_id
* title
* slug
* excerpt
* content
* thumbnail
* meta_title
* meta_description
* status
* published_at
* created_by
* timestamps

---

## categories

* id
* name
* slug
* description
* timestamps

---

## tags

* id
* name
* slug
* timestamps

---

## post_tag

* post_id
* tag_id

---

## media

* id
* filename
* path
* mime_type
* file_size
* uploaded_by
* timestamps

---

## banners

* id
* title
* description
* image
* button_text
* button_url
* is_active
* timestamps

---

## menus

* id
* name
* location
* timestamps

---

## menu_items

* id
* menu_id
* parent_id
* title
* url
* order_number

---

## settings

* id
* setting_key
* setting_value

---

## contact_messages

* id
* name
* email
* phone
* subject
* message
* timestamps

---

# URL STRUCTURE

Frontend

/
/berita
/berita/{slug}
/{page_slug}
/kontak
/search

Admin

/admin
/admin/pages
/admin/posts
/admin/categories
/admin/tags
/admin/media
/admin/banners
/admin/menus
/admin/settings
/admin/users

---

# TEMPLATE SYSTEM

resources/views/

layouts/

* frontend.blade.php
* admin.blade.php

frontend/

* home.blade.php
* page.blade.php
* post.blade.php
* search.blade.php
* contact.blade.php

admin/

* dashboard/
* pages/
* posts/
* categories/
* tags/
* media/
* banners/
* menus/
* settings/
* users/

---

# SEO FEATURES

* Dynamic Meta Title
* Dynamic Meta Description
* Canonical URL
* Open Graph
* Twitter Card
* robots.txt
* sitemap.xml
* Structured Data JSON-LD

---

# SECURITY

* CSRF Protection
* XSS Protection
* SQL Injection Protection
* Rate Limiting
* Login Throttling
* Authorization Policy
* File Upload Validation
* Secure Headers

---

# PERFORMANCE

* Redis Cache
* Query Optimization
* Eager Loading
* Image Optimization
* Lazy Loading
* Full Page Cache Ready

---

# FUTURE PHASE 2

* Gallery Module
* Event Module
* FAQ Module
* Download Center
* Announcement Module
* Newsletter Module
* Visitor Statistics
* Activity Log
* Audit Trail

---

# FUTURE PHASE 3

* REST API
* Mobile Application Integration
* Headless CMS
* Multi Language
* SSO Integration
* LDAP Integration
* AI Content Assistant

---

# DEVELOPMENT PRINCIPLE

* SOLID Principles
* Repository Pattern
* Service Pattern
* Clean Architecture
* Modular Structure
* PSR-12 Standard
* Production Ready Code
* Easy Maintenance
* Easy Scalability
