<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pages')) {
            $page = DB::table('pages')
                ->where('slug', 'profil-uld-dan-struktur')
                ->first();

            if ($page) {
                $content = str_replace(
                    [
                        'Unit Layanan Disabilitas (ULD)',
                        'ULD hadir',
                        'ULD berupaya',
                        'Nilai-Nilai ULD',
                        'Struktur ULD',
                    ],
                    [
                        'Unit Layanan Disabilitas',
                        'Unit Layanan Disabilitas hadir',
                        'Unit Layanan Disabilitas berupaya',
                        'Nilai-Nilai Unit Layanan Disabilitas',
                        'Struktur Unit Layanan Disabilitas',
                    ],
                    $page->content
                );

                DB::table('pages')
                    ->where('id', $page->id)
                    ->update([
                        'title' => 'Profil Unit Layanan Disabilitas dan Struktur',
                        'meta_title' => 'Profil Unit Layanan Disabilitas dan Struktur',
                        'content' => $content,
                        'updated_at' => now(),
                    ]);
            }
        }

        if (Schema::hasTable('menu_items')) {
            DB::table('menu_items')
                ->where('title', 'Profil ULD dan Struktur')
                ->update([
                    'title' => 'Profil Unit Layanan Disabilitas dan Struktur',
                    'updated_at' => now(),
                ]);
        }

        if (Schema::hasTable('posts')) {
            DB::table('posts')
                ->where('excerpt', 'like', '%Website ULD%')
                ->update([
                    'excerpt' => DB::raw("REPLACE(excerpt, 'Website ULD', 'Website Unit Layanan Disabilitas')"),
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        // Keep expanded public-facing names.
    }
};
