<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        $page = DB::table('pages')
            ->where('slug', 'profil-uld-dan-struktur')
            ->first();

        if (! $page) {
            return;
        }

        $values = <<<'HTML'
<h2>Nilai-Nilai Unit Layanan Disabilitas</h2>
<ul class="uld-values">
<li><strong>Inklusif</strong><span>Menghargai keberagaman dan kesetaraan.</span></li>
<li><strong>Humanis</strong><span>Mengedepankan empati dan penghormatan terhadap martabat manusia.</span></li>
<li><strong>Kolaboratif</strong><span>Membangun sinergi lintas sektor dan komunitas.</span></li>
<li><strong>Profesional</strong><span>Memberikan layanan yang berkualitas dan berkelanjutan.</span></li>
<li><strong>Berkemajuan</strong><span>Adaptif terhadap perkembangan ilmu pengetahuan dan teknologi.</span></li>
</ul>
HTML;

        $content = preg_replace(
            '/(?:<h2>Nilai-Nilai (?:ULD|Unit Layanan Disabilitas)<\/h2>\s*<ul class="uld-values">.*?<\/ul>\s*)+(?=<h2>Struktur (?:ULD|Unit Layanan Disabilitas)<\/h2>)/s',
            $values."\n\n",
            $page->content
        );

        DB::table('pages')
            ->where('id', $page->id)
            ->update([
                'content' => $content,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Keep the corrected page content.
    }
};
