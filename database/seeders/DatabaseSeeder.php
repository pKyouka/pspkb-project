<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin User
        User::firstOrCreate(
            ['email' => 'admin@pspkb.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('unisayogya2026!'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Editor User
        User::firstOrCreate(
            ['email' => 'editor@pspkb.id'],
            [
                'name' => 'Editor',
                'password' => Hash::make('unisayogya2026!'),
                'role' => 'editor',
                'email_verified_at' => now(),
            ]
        );

        // Create Author User
        User::firstOrCreate(
            ['email' => 'author@pspkb.id'],
            [
                'name' => 'Author',
                'password' => Hash::make('unisayogya2026!'),
                'role' => 'author',
                'email_verified_at' => now(),
            ]
        );

        // Create Categories
        $categories = [
            'Berita' => 'Berita dan informasi resmi Unit Layanan Disabilitas.',
            'Artikel' => 'Artikel dan wawasan tentang disabilitas serta pendidikan inklusif.',
            'Kegiatan' => 'Aktivitas, program, pelatihan, dan kegiatan Unit Layanan Disabilitas.',
        ];
        foreach ($categories as $name => $desc) {
            Category::firstOrCreate(['name' => $name], ['description' => $desc]);
        }

        // Create Tags
        $tags = ['penting', 'terkini', 'umum', 'teknologi', 'pendidikan'];
        foreach ($tags as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }

        // Create Settings
        $settings = [
            'website_name' => 'Unit Layanan Disabilitas',
            'website_description' => 'Mewujudkan kampus inklusif, setara, aksesibel, dan berkemajuan.',
            'contact_email' => 'uld@unisayogya.ac.id',
            'contact_phone' => '',
            'contact_address' => 'Universitas Aisyiyah Yogyakarta',
            'contact_heading' => 'Kami siap membantu kebutuhan akses Anda.',
            'contact_description' => 'Sampaikan kebutuhan layanan, pertanyaan, atau gagasan kolaborasi kepada Unit Layanan Disabilitas.',
            'contact_hours' => 'Senin-Jumat, 08.00-16.00 WIB',
            'seo_meta_title' => 'Unit Layanan Disabilitas - Universitas Aisyiyah Yogyakarta',
            'seo_meta_description' => 'Website resmi Unit Layanan Disabilitas Universitas Aisyiyah Yogyakarta.',
            'seo_keywords' => 'uld, disabilitas, kampus inklusif, universitas aisyiyah yogyakarta',
        ];
        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['setting_key' => $key], ['setting_value' => $value]);
        }

        // Create Header Menu
        $headerMenu = Menu::firstOrCreate(
            ['location' => 'header'],
            ['name' => 'Menu Utama']
        );
        $headerMenu->allItems()->delete();
        MenuItem::create(['menu_id' => $headerMenu->id, 'title' => 'Profil Unit Layanan Disabilitas dan Struktur', 'url' => '/profil-uld-dan-struktur', 'order_number' => 1]);
        MenuItem::create(['menu_id' => $headerMenu->id, 'title' => 'Berita dan Artikel', 'url' => '/berita', 'order_number' => 2]);
        MenuItem::create(['menu_id' => $headerMenu->id, 'title' => 'Aktivitas/Kegiatan', 'url' => '/kegiatan', 'order_number' => 3]);
        MenuItem::create(['menu_id' => $headerMenu->id, 'title' => 'Kontak', 'url' => '/kontak', 'order_number' => 4]);

        // Create Footer Menu
        $footerMenu = Menu::firstOrCreate(
            ['location' => 'footer'],
            ['name' => 'Menu Footer']
        );
        $footerMenu->allItems()->delete();
        MenuItem::create(['menu_id' => $footerMenu->id, 'title' => 'Profil Unit Layanan Disabilitas dan Struktur', 'url' => '/profil-uld-dan-struktur', 'order_number' => 1]);
        MenuItem::create(['menu_id' => $footerMenu->id, 'title' => 'Berita dan Artikel', 'url' => '/berita', 'order_number' => 2]);
        MenuItem::create(['menu_id' => $footerMenu->id, 'title' => 'Aktivitas/Kegiatan', 'url' => '/kegiatan', 'order_number' => 3]);
        MenuItem::create(['menu_id' => $footerMenu->id, 'title' => 'Kontak', 'url' => '/kontak', 'order_number' => 4]);

        // Create a banner
        Banner::firstOrCreate(
            ['title' => 'Unit Layanan Disabilitas'],
            [
                'description' => 'Mewujudkan Kampus Inklusif, Setara, dan Berkemajuan',
                'button_text' => 'Selengkapnya',
                'button_url' => '/profil-uld-dan-struktur',
                'is_active' => true,
            ]
        );

        // Create sample pages
        Page::firstOrCreate(
            ['slug' => 'profil-uld-dan-struktur'],
            [
                'title' => 'Profil Unit Layanan Disabilitas dan Struktur',
                'content' => '<h2>Profil Unit Layanan Disabilitas</h2><p>Unit Layanan Disabilitas Universitas Aisyiyah Yogyakarta merupakan pusat layanan dan pengembangan inklusivitas kampus.</p><h2>Struktur Unit Layanan Disabilitas</h2><p>Struktur, nama pengelola, jabatan, foto, dan rincian tugas dapat diperbarui melalui editor halaman pada panel admin.</p>',
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        // Create sample post
        $admin = User::where('email', 'admin@pspkb.id')->first();
        if ($admin) {
            $category = Category::where('name', 'Berita')->first();
            Post::firstOrCreate(
                ['slug' => 'selamat-datang-di-website-uld'],
                [
                    'category_id' => $category?->id,
                    'title' => 'Selamat Datang di Website Unit Layanan Disabilitas',
                    'excerpt' => 'Website Unit Layanan Disabilitas hadir sebagai pusat informasi layanan, kegiatan, dan wawasan kampus inklusif.',
                    'content' => '<p>Website Unit Layanan Disabilitas hadir untuk memudahkan civitas akademika memperoleh informasi layanan, kegiatan, dan artikel seputar disabilitas serta pendidikan inklusif.</p>',
                    'status' => 'published',
                    'published_at' => now(),
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}
