<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        if (Schema::hasTable('categories')) {
            foreach ([
                ['name' => 'Berita', 'slug' => 'berita', 'description' => 'Berita dan informasi resmi Unit Layanan Disabilitas.'],
                ['name' => 'Artikel', 'slug' => 'artikel', 'description' => 'Artikel dan wawasan tentang disabilitas serta pendidikan inklusif.'],
                ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'description' => 'Aktivitas, program, pelatihan, dan kegiatan Unit Layanan Disabilitas.'],
            ] as $category) {
                DB::table('categories')->updateOrInsert(
                    ['slug' => $category['slug']],
                    [...$category, 'updated_at' => $now, 'created_at' => $now]
                );
            }
        }

        if (Schema::hasTable('pages')) {
            DB::table('pages')->updateOrInsert(
                ['slug' => 'profil-uld-dan-struktur'],
                [
                    'title' => 'Profil Unit Layanan Disabilitas dan Struktur',
                    'content' => $this->profileContent(),
                    'meta_title' => 'Profil Unit Layanan Disabilitas dan Struktur',
                    'meta_description' => 'Profil, visi, misi, nilai, peran, dan struktur Unit Layanan Disabilitas Universitas Aisyiyah Yogyakarta.',
                    'status' => 'published',
                    'published_at' => $now,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        if (Schema::hasTable('menus') && Schema::hasTable('menu_items')) {
            $menu = DB::table('menus')->where('location', 'header')->first();
            $menuId = $menu?->id ?? DB::table('menus')->insertGetId([
                'name' => 'Menu Utama',
                'location' => 'header',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('menu_items')->where('menu_id', $menuId)->delete();

            DB::table('menu_items')->insert([
                ['menu_id' => $menuId, 'parent_id' => null, 'title' => 'Profil Unit Layanan Disabilitas dan Struktur', 'url' => '/profil-uld-dan-struktur', 'order_number' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['menu_id' => $menuId, 'parent_id' => null, 'title' => 'Berita dan Artikel', 'url' => '/berita', 'order_number' => 2, 'created_at' => $now, 'updated_at' => $now],
                ['menu_id' => $menuId, 'parent_id' => null, 'title' => 'Aktivitas/Kegiatan', 'url' => '/kegiatan', 'order_number' => 3, 'created_at' => $now, 'updated_at' => $now],
                ['menu_id' => $menuId, 'parent_id' => null, 'title' => 'Kontak', 'url' => '/kontak', 'order_number' => 4, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        if (Schema::hasTable('settings')) {
            foreach ([
                'website_name' => 'Unit Layanan Disabilitas',
                'website_description' => 'Mewujudkan kampus inklusif, setara, aksesibel, dan berkemajuan.',
                'contact_heading' => 'Kami siap membantu kebutuhan akses Anda.',
                'contact_description' => 'Sampaikan kebutuhan layanan, pertanyaan, atau gagasan kolaborasi kepada Unit Layanan Disabilitas.',
                'contact_hours' => 'Senin-Jumat, 08.00-16.00 WIB',
            ] as $key => $value) {
                DB::table('settings')->updateOrInsert(
                    ['setting_key' => $key],
                    ['setting_value' => $value, 'updated_at' => $now, 'created_at' => $now]
                );
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pages')) {
            DB::table('pages')->where('slug', 'profil-uld-dan-struktur')->delete();
        }

        if (Schema::hasTable('settings')) {
            DB::table('settings')->whereIn('setting_key', [
                'contact_heading',
                'contact_description',
                'contact_hours',
            ])->delete();
        }
    }

    private function profileContent(): string
    {
        return <<<'HTML'
<h2>Profil Unit Layanan Disabilitas</h2>
<p>Unit Layanan Disabilitas Universitas &lsquo;Aisyiyah Yogyakarta merupakan pusat layanan dan pengembangan inklusivitas kampus yang berkomitmen untuk memastikan setiap civitas akademika memperoleh hak, akses, kesempatan, dan partisipasi yang setara tanpa diskriminasi.</p>
<p>Unit Layanan Disabilitas hadir sebagai bentuk komitmen Universitas &lsquo;Aisyiyah Yogyakarta dalam mendukung pendidikan tinggi yang inklusif, humanis, berkeadilan, dan berperspektif keberagaman sesuai dengan nilai-nilai Islam berkemajuan serta prinsip Sustainable Development Goals (SDGs), khususnya pada aspek pendidikan berkualitas dan kesetaraan.</p>
<p>Unit Layanan Disabilitas berupaya menciptakan lingkungan akademik yang tidak hanya ramah disabilitas, tetapi juga menghargai keberagaman sebagai kekuatan dalam membangun peradaban yang unggul dan berkemajuan.</p>

<h2>Peran Strategis Unit Layanan Disabilitas</h2>
<ol>
<li>Memberikan layanan pendampingan bagi mahasiswa penyandang disabilitas.</li>
<li>Mengembangkan sistem pembelajaran yang aksesibel.</li>
<li>Memperkuat budaya kampus inklusif.</li>
<li>Meningkatkan kapasitas dosen dan tenaga kependidikan terkait pendidikan inklusif.</li>
<li>Membangun kolaborasi dengan berbagai institusi dan komunitas disabilitas.</li>
</ol>

<h2>Visi</h2>
<p>Menjadi pusat layanan disabilitas yang unggul, inklusif, dan berkemajuan dalam mendukung terwujudnya lingkungan pendidikan tinggi yang aksesibel, setara, dan berkeadilan.</p>

<h2>Misi</h2>
<ol>
<li>Menyediakan layanan pendampingan dan dukungan akademik maupun non-akademik bagi mahasiswa penyandang disabilitas.</li>
<li>Mengembangkan sistem pembelajaran, fasilitas, dan informasi yang aksesibel.</li>
<li>Meningkatkan kesadaran dan budaya inklusif di lingkungan universitas.</li>
<li>Mengembangkan kerja sama dengan berbagai pihak dalam penguatan pendidikan inklusif dan pemberdayaan disabilitas.</li>
<li>Mendukung penelitian, pengabdian masyarakat, dan inovasi terkait isu disabilitas dan inklusivitas.</li>
</ol>

<h2>Nilai-Nilai Unit Layanan Disabilitas</h2>
<ul class="uld-values">
<li><strong>Inklusif</strong><span>Menghargai keberagaman dan kesetaraan.</span></li>
<li><strong>Humanis</strong><span>Mengedepankan empati dan penghormatan terhadap martabat manusia.</span></li>
<li><strong>Kolaboratif</strong><span>Membangun sinergi lintas sektor dan komunitas.</span></li>
<li><strong>Profesional</strong><span>Memberikan layanan yang berkualitas dan berkelanjutan.</span></li>
<li><strong>Berkemajuan</strong><span>Adaptif terhadap perkembangan ilmu pengetahuan dan teknologi.</span></li>
</ul>

<h2>Struktur Unit Layanan Disabilitas</h2>
<p>Struktur Unit Layanan Disabilitas disusun untuk memastikan koordinasi layanan berjalan efektif melalui unsur pimpinan unit, administrasi, layanan akademik dan pendampingan, aksesibilitas, edukasi dan pelatihan, serta kemitraan dan pengembangan. Nama pengelola, jabatan, foto, dan rincian tugas dapat diperbarui melalui editor halaman ini pada panel admin.</p>
HTML;
    }
};
