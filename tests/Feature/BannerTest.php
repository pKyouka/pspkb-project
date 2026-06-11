<?php

use App\Models\Banner;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('admin can upload multiple homepage banners at once', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->post(route('admin.banners.store'), [
        'images' => [
            UploadedFile::fake()->image('banner-satu.jpg', 1920, 1080),
            UploadedFile::fake()->image('banner-dua.jpg', 1920, 1080),
        ],
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('admin.banners.index'));
    expect(Banner::count())->toBe(2)
        ->and(Banner::where('is_active', true)->count())->toBe(2);

    Banner::each(fn (Banner $banner) => Storage::disk('public')->assertExists($banner->image));
});

test('homepage only displays active banners in the carousel', function () {
    Banner::create([
        'title' => 'Banner Aktif',
        'image' => 'banners/active.jpg',
        'is_active' => true,
    ]);
    Banner::create([
        'title' => 'Banner Nonaktif',
        'image' => 'banners/inactive.jpg',
        'is_active' => false,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Unit Layanan Disabilitas')
        ->assertSee('Mewujudkan Kampus Inklusif, Setara, dan Berkemajuan')
        ->assertDontSee('Banner Aktif')
        ->assertDontSee('Banner Nonaktif');
});

test('replacing a banner image deletes the old file', function () {
    Storage::fake('public');
    Storage::disk('public')->put('banners/old.jpg', 'old image');
    $admin = User::factory()->create(['role' => 'admin']);
    $banner = Banner::create([
        'title' => 'Banner Lama',
        'image' => 'banners/old.jpg',
        'is_active' => true,
    ]);

    $this->actingAs($admin)->put(route('admin.banners.update', $banner), [
        'image' => UploadedFile::fake()->image('new.jpg', 1920, 1080),
        'is_active' => '1',
    ])->assertRedirect(route('admin.banners.index'));

    $banner->refresh();
    Storage::disk('public')->assertMissing('banners/old.jpg');
    Storage::disk('public')->assertExists($banner->image);
});

test('banner admin edit only contains image controls', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $banner = Banner::create([
        'title' => 'Internal filename',
        'image' => 'banners/example.jpg',
        'is_active' => true,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.banners.edit', $banner))
        ->assertOk()
        ->assertSee('Pilih Gambar Pengganti')
        ->assertDontSee('Judul *')
        ->assertDontSee('Deskripsi')
        ->assertDontSee('Teks Tombol')
        ->assertDontSee('URL Tombol');
});

test('profile section does not reuse a banner image', function () {
    Banner::create([
        'title' => 'Hero only',
        'image' => 'banners/hero-only.jpg',
        'is_active' => true,
    ]);

    $response = $this->get(route('home'))->assertOk();

    expect(substr_count($response->getContent(), 'banners/hero-only.jpg'))->toBe(1);
});
