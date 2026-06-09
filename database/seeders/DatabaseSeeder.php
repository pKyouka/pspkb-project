<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
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
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Editor User
        User::firstOrCreate(
            ['email' => 'editor@pspkb.id'],
            [
                'name' => 'Editor',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'email_verified_at' => now(),
            ]
        );

        // Create Author User
        User::firstOrCreate(
            ['email' => 'author@pspkb.id'],
            [
                'name' => 'Author',
                'password' => Hash::make('password'),
                'role' => 'author',
                'email_verified_at' => now(),
            ]
        );

        // Create Categories
        $categories = [
            'Pengumuman' => 'Pengumuman resmi',
            'Kegiatan' => 'Berita kegiatan',
            'Artikel' => 'Artikel dan tulisan',
            'Info Terkini' => 'Informasi terkini',
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
            'website_name' => 'PSPKB',
            'website_description' => 'Website Resmi PSPKB - Pusat Studi dan Pengembangan Keilmuan Berkelanjutan',
            'contact_email' => 'info@pspkb.id',
            'contact_phone' => '021-12345678',
            'contact_address' => 'Jl. Contoh No. 123, Jakarta, Indonesia',
            'seo_meta_title' => 'PSPKB - Pusat Studi dan Pengembangan Keilmuan Berkelanjutan',
            'seo_meta_description' => 'Website resmi PSPKB yang menyediakan informasi terkini seputar kegiatan, pengumuman, dan artikel.',
            'seo_keywords' => 'pspkb, pusat studi, pengembangan, keilmuan, berkelanjutan',
        ];
        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['setting_key' => $key], ['setting_value' => $value]);
        }

        // Create Header Menu
        $headerMenu = Menu::firstOrCreate(
            ['location' => 'header'],
            ['name' => 'Menu Utama']
        );
        MenuItem::firstOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Tentang Kami', 'url' => '/tentang'], ['order_number' => 1]);
        MenuItem::firstOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Visi & Misi', 'url' => '/visi-misi'], ['order_number' => 2]);
        MenuItem::firstOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Layanan', 'url' => '/layanan'], ['order_number' => 3]);

        // Create Footer Menu
        $footerMenu = Menu::firstOrCreate(
            ['location' => 'footer'],
            ['name' => 'Menu Footer']
        );
        MenuItem::firstOrCreate(['menu_id' => $footerMenu->id, 'title' => 'Beranda', 'url' => '/'], ['order_number' => 1]);
        MenuItem::firstOrCreate(['menu_id' => $footerMenu->id, 'title' => 'Berita', 'url' => '/berita'], ['order_number' => 2]);
        MenuItem::firstOrCreate(['menu_id' => $footerMenu->id, 'title' => 'Tentang Kami', 'url' => '/tentang'], ['order_number' => 3]);

        // Create a banner
        \App\Models\Banner::firstOrCreate(
            ['title' => 'Selamat Datang di PSPKB'],
            [
                'description' => 'Pusat Studi dan Pengembangan Keilmuan Berkelanjutan',
                'button_text' => 'Selengkapnya',
                'button_url' => '/tentang',
                'is_active' => true,
            ]
        );

        // Create sample pages
        \App\Models\Page::firstOrCreate(
            ['slug' => 'tentang'],
            [
                'title' => 'Tentang Kami',
                'content' => '<p>PSPKB adalah Pusat Studi dan Pengembangan Keilmuan Berkelanjutan yang berdedikasi untuk memajukan pendidikan dan penelitian di Indonesia.</p><p>Kami berkomitmen untuk menjadi pusat keunggulan dalam pengembangan keilmuan yang berkelanjutan dan bermanfaat bagi masyarakat.</p>',
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        // Create sample post
        $admin = User::where('email', 'admin@pspkb.id')->first();
        if ($admin) {
            $category = Category::where('name', 'Pengumuman')->first();
            \App\Models\Post::firstOrCreate(
                ['slug' => 'selamat-datang'],
                [
                    'category_id' => $category?->id,
                    'title' => 'Selamat Datang di Website Resmi PSPKB',
                    'excerpt' => 'Website resmi PSPKB telah diluncurkan untuk memberikan informasi terkini.',
                    'content' => '<p>Kami dengan bangga mengumumkan peluncuran website resmi PSPKB. Website ini akan menjadi sumber informasi utama mengenai kegiatan, pengumuman, dan artikel yang kami produksi.</p><p>Silakan menjelajahi website ini untuk menemukan informasi yang Anda butuhkan.</p>',
                    'status' => 'published',
                    'published_at' => now(),
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}
