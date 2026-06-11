<?php

use App\Models\Page;

test('uld profile page displays all institutional values', function () {
    Page::where('slug', 'profil-uld-dan-struktur')->update([
        'published_at' => now(),
    ]);

    $response = $this->get(route('pages.show', 'profil-uld-dan-struktur'))
        ->assertOk()
        ->assertSee('Nilai-Nilai Unit Layanan Disabilitas')
        ->assertSee('Inklusif')
        ->assertSee('Humanis')
        ->assertSee('Kolaboratif')
        ->assertSee('Profesional')
        ->assertSee('Berkemajuan')
        ->assertSee('Menghargai keberagaman dan kesetaraan.');

    expect(substr_count($response->getContent(), 'Nilai-Nilai Unit Layanan Disabilitas'))->toBe(1)
        ->and(substr_count($response->getContent(), 'class="uld-values"'))->toBe(1);
});
