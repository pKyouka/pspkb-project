@extends('layouts.frontend')

@section('title', __('frontend.site_name').' | '.__('frontend.university'))
@section('description', __('frontend.footer.description'))

@section('content')
@php
    $heroBanner = $banners->first();

    $strategicRoles = [
        'Memberikan layanan pendampingan bagi mahasiswa penyandang disabilitas.',
        'Mengembangkan sistem pembelajaran yang aksesibel.',
        'Memperkuat budaya kampus inklusif.',
        'Meningkatkan kapasitas dosen dan tenaga kependidikan terkait pendidikan inklusif.',
        'Membangun kolaborasi dengan berbagai institusi dan komunitas disabilitas.',
    ];

    $missions = [
        'Menyediakan layanan pendampingan dan dukungan akademik maupun non-akademik bagi mahasiswa penyandang disabilitas.',
        'Mengembangkan sistem pembelajaran, fasilitas, dan informasi yang aksesibel.',
        'Meningkatkan kesadaran dan budaya inklusif di lingkungan universitas.',
        'Mengembangkan kerja sama dengan berbagai pihak dalam penguatan pendidikan inklusif dan pemberdayaan disabilitas.',
        'Mendukung penelitian, pengabdian masyarakat, dan inovasi terkait isu disabilitas dan inklusivitas.',
    ];

    $values = [
        ['name' => 'Inklusif', 'description' => 'Menghargai keberagaman dan kesetaraan.'],
        ['name' => 'Humanis', 'description' => 'Mengedepankan empati dan penghormatan terhadap martabat manusia.'],
        ['name' => 'Kolaboratif', 'description' => 'Membangun sinergi lintas sektor dan komunitas.'],
        ['name' => 'Profesional', 'description' => 'Memberikan layanan yang berkualitas dan berkelanjutan.'],
        ['name' => 'Berkemajuan', 'description' => 'Adaptif terhadap perkembangan ilmu pengetahuan dan teknologi.'],
    ];

    $services = [
        [
            'title' => 'Layanan Akademik',
            'items' => ['Pendampingan pembelajaran', 'Aksesibilitas materi kuliah', 'Penyesuaian layanan akademik', 'Konsultasi kebutuhan pembelajaran'],
        ],
        [
            'title' => 'Layanan Pendampingan',
            'items' => ['Konseling dan dukungan psikososial', 'Peer support dan volunteer', 'Advokasi kebutuhan mahasiswa disabilitas'],
        ],
        [
            'title' => 'Layanan Aksesibilitas',
            'items' => ['Pemetaan kebutuhan aksesibilitas', 'Pengembangan fasilitas ramah disabilitas', 'Dukungan teknologi asistif'],
        ],
        [
            'title' => 'Edukasi dan Pelatihan',
            'items' => ['Pelatihan pendidikan inklusif', 'Seminar dan kampanye kesadaran disabilitas', 'Capacity building bagi dosen dan tenaga kependidikan'],
        ],
        [
            'title' => 'Kemitraan dan Pengembangan',
            'items' => ['Kerja sama dengan komunitas dan lembaga disabilitas', 'Pengembangan riset dan inovasi inklusivitas', 'Program pengabdian masyarakat berbasis inklusi'],
        ],
    ];
@endphp

<section class="pspkb-hero relative flex min-h-[calc(100svh-1rem)] overflow-hidden bg-[#f1f2ef]">
    <div class="pspkb-hero-glow" aria-hidden="true"></div>
    <div class="pspkb-ribbons" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="pspkb-grain" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto flex w-full max-w-[1440px] flex-col justify-end px-5 pb-14 pt-36 sm:px-8 sm:pb-16 lg:px-12 lg:pb-20">
        <div class="max-w-5xl">
            <p class="mb-6 flex items-center gap-3 text-[13px] font-medium tracking-wide text-slate-800 sm:mb-8">
                <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                {{ __('frontend.university') }}
            </p>

            <h1 class="max-w-[1100px] text-[clamp(2.65rem,7.2vw,5.7rem)] font-medium leading-[0.98] tracking-[-0.055em] text-slate-950">
                {{ __('frontend.site_name') }}
            </h1>

            <p class="mt-6 max-w-3xl text-lg font-medium leading-7 text-slate-800 sm:mt-8 sm:text-2xl">
                Mewujudkan Kampus Inklusif, Setara, dan Berkemajuan
            </p>

            <div class="mt-8 flex flex-col items-start gap-4 sm:mt-10 sm:flex-row sm:items-center">
                <a href="#layanan" class="group inline-flex items-center gap-4 rounded-full bg-emerald-700 py-2 pl-6 pr-2 text-[13px] font-semibold text-white transition duration-500 hover:bg-emerald-800">
                    Jelajahi layanan
                    <span class="grid h-8 w-8 place-items-center rounded-full bg-white text-emerald-800">
                        <svg class="h-4 w-4 -rotate-45 transition-transform duration-500 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </span>
                </a>

                <a href="{{ route('contact') }}" class="group inline-flex items-center gap-3 rounded-full bg-white/90 px-4 py-3 text-[13px] font-semibold text-slate-900 shadow-[0_2px_12px_rgba(15,23,42,.08)] transition hover:shadow-[0_8px_25px_rgba(15,23,42,.14)]">
                    <span class="grid h-6 w-6 place-items-center rounded-full bg-emerald-50 text-emerald-700">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16l-4 3v-3a8 8 0 1 1 4 0Z"/></svg>
                    </span>
                    {{ __('frontend.common.contact_uld') }}
                    <span class="rounded bg-slate-950 px-2 py-1 text-[10px] text-white">{{ __('frontend.nav.contact') }}</span>
                </a>
            </div>
        </div>

        <div class="mt-12 flex items-center gap-3 text-xs font-medium text-slate-500 sm:absolute sm:bottom-8 sm:right-8 sm:mt-0 lg:right-12">
            <span class="grid h-8 w-8 place-items-center rounded-full border border-slate-300 bg-white/60">
                <svg class="h-4 w-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="m6 9 6 6 6-6"/></svg>
            </span>
            Kenali ULD lebih dekat
        </div>
    </div>
</section>

<section id="profil" class="overflow-hidden bg-white py-16 sm:py-20 lg:py-32">
    <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="flex items-center gap-3">
            <span class="grid h-7 w-7 place-items-center rounded-full bg-slate-950 text-xs font-semibold text-white">1</span>
            <span class="rounded-full border border-slate-200 px-4 py-1.5 text-xs font-medium text-slate-700">Profil ULD</span>
        </div>

        <h2 class="mt-7 max-w-6xl text-[clamp(2rem,4.8vw,4rem)] font-medium leading-[1.05] tracking-[-0.04em] text-slate-950">
            Pusat layanan dan pengembangan inklusivitas kampus untuk setiap civitas akademika.
        </h2>

        <div class="mt-14 grid gap-8 lg:mt-20 lg:grid-cols-[42%_1fr] lg:gap-20">
            <div class="group relative min-h-[420px] overflow-hidden rounded-2xl bg-emerald-950">
                @if($heroBanner?->image)
                    <img src="{{ asset('storage/' . $heroBanner->image) }}" alt="Unit Layanan Disabilitas" class="absolute inset-0 h-full w-full object-cover opacity-75 transition duration-700 group-hover:scale-105">
                @else
                    <div class="pspkb-photo-placeholder absolute inset-0"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/10 to-transparent"></div>
                <div class="absolute inset-x-7 bottom-7 text-white sm:inset-x-9 sm:bottom-9">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-200">Komitmen Kami</p>
                    <p class="mt-3 text-2xl font-medium leading-tight tracking-tight sm:text-3xl">Hak, akses, kesempatan, dan partisipasi yang setara tanpa diskriminasi.</p>
                </div>
            </div>

            <div class="flex flex-col justify-center">
                <p class="text-base leading-8 text-slate-700">
                    Unit Layanan Disabilitas (ULD) Universitas &lsquo;Aisyiyah Yogyakarta merupakan pusat layanan dan pengembangan inklusivitas kampus yang berkomitmen untuk memastikan setiap civitas akademika memperoleh hak, akses, kesempatan, dan partisipasi yang setara tanpa diskriminasi.
                </p>
                <p class="mt-6 text-base leading-8 text-slate-700">
                    ULD hadir sebagai bentuk komitmen universitas dalam mendukung pendidikan tinggi yang inklusif, humanis, berkeadilan, dan berperspektif keberagaman sesuai nilai-nilai Islam berkemajuan serta prinsip Sustainable Development Goals (SDGs), khususnya pendidikan berkualitas dan kesetaraan.
                </p>
                <p class="mt-6 text-base font-medium leading-8 text-slate-950">
                    Kami berupaya menciptakan lingkungan akademik yang tidak hanya ramah disabilitas, tetapi juga menghargai keberagaman sebagai kekuatan dalam membangun peradaban yang unggul dan berkemajuan.
                </p>
            </div>
        </div>

        <div class="mt-16 border-t border-slate-200 pt-10 lg:mt-24">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Peran strategis ULD</p>
            <div class="mt-7 grid md:grid-cols-2 lg:grid-cols-5">
                @foreach($strategicRoles as $index => $role)
                    <div class="border-b border-slate-200 py-7 md:px-5 lg:border-b-0 lg:border-r lg:first:pl-0 lg:last:border-r-0">
                        <span class="text-xs font-medium text-slate-400">0{{ $index + 1 }}</span>
                        <p class="mt-8 text-sm font-medium leading-6 text-slate-800">{{ $role }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="visi-misi" class="bg-[#f1f2ef] py-16 sm:py-20 lg:py-28">
    <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="flex items-center gap-3">
            <span class="grid h-7 w-7 place-items-center rounded-full bg-slate-950 text-xs font-semibold text-white">2</span>
            <span class="rounded-full border border-slate-300 px-4 py-1.5 text-xs font-medium text-slate-700">Visi dan Misi</span>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-[42%_1fr] lg:gap-8">
            <article class="flex min-h-[430px] flex-col justify-between rounded-2xl bg-emerald-800 p-7 text-white sm:p-10">
                <span class="grid h-12 w-12 place-items-center rounded-full bg-white/10 ring-1 ring-white/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5" stroke-width="1.6"/></svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-200">Visi</p>
                    <h2 class="mt-4 text-3xl font-medium leading-tight tracking-[-0.035em] sm:text-4xl">
                        Menjadi pusat layanan disabilitas yang unggul, inklusif, dan berkemajuan.
                    </h2>
                    <p class="mt-5 leading-7 text-emerald-50">Dalam mendukung terwujudnya lingkungan pendidikan tinggi yang aksesibel, setara, dan berkeadilan.</p>
                </div>
            </article>

            <article class="rounded-2xl bg-white p-7 sm:p-10">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Misi</p>
                <div class="mt-7 divide-y divide-slate-200">
                    @foreach($missions as $index => $mission)
                        <div class="grid grid-cols-[36px_1fr] gap-4 py-5 first:pt-0 last:pb-0">
                            <span class="text-xs font-medium text-slate-400">0{{ $index + 1 }}</span>
                            <p class="text-[15px] font-medium leading-7 text-slate-800">{{ $mission }}</p>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>
    </div>
</section>

<section class="bg-white py-16 sm:py-20 lg:py-28">
    <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="flex items-center gap-3">
            <span class="grid h-7 w-7 place-items-center rounded-full bg-slate-950 text-xs font-semibold text-white">3</span>
            <span class="rounded-full border border-slate-200 px-4 py-1.5 text-xs font-medium text-slate-700">Nilai-nilai ULD</span>
        </div>

        <h2 class="mt-7 max-w-5xl text-[clamp(2rem,4.8vw,4rem)] font-medium leading-[1.05] tracking-[-0.04em] text-slate-950">
            Prinsip yang membentuk cara kami melayani dan bertumbuh.
        </h2>

        <div class="mt-12 grid gap-px overflow-hidden rounded-2xl bg-slate-200 sm:grid-cols-2 lg:mt-16 lg:grid-cols-5">
            @foreach($values as $index => $value)
                <article class="group min-h-64 bg-[#f7f8f5] p-7 transition duration-500 hover:bg-emerald-800 hover:text-white">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-400 transition group-hover:text-emerald-200">0{{ $index + 1 }}</span>
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-600 transition group-hover:bg-white"></span>
                    </div>
                    <h3 class="mt-20 text-2xl font-medium tracking-tight">{{ $value['name'] }}</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-500 transition group-hover:text-emerald-50">{{ $value['description'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="layanan" class="bg-slate-950 py-16 text-white sm:py-20 lg:py-28">
    <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="flex items-center gap-3">
            <span class="grid h-7 w-7 place-items-center rounded-full bg-white text-xs font-semibold text-slate-950">4</span>
            <span class="rounded-full border border-white/20 px-4 py-1.5 text-xs font-medium text-slate-200">Layanan ULD</span>
        </div>

        <div class="mt-7 flex flex-col justify-between gap-7 md:flex-row md:items-end">
            <h2 class="max-w-4xl text-[clamp(2.65rem,7vw,5.7rem)] font-medium leading-none tracking-[-0.055em]">
                Akses untuk semua.
            </h2>
            <p class="max-w-sm text-sm leading-6 text-slate-400">Layanan terintegrasi untuk mendukung pengalaman belajar dan kehidupan kampus yang setara.</p>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 lg:mt-16">
            @foreach($services as $index => $service)
                <article class="{{ $index === 4 ? 'md:col-span-2' : '' }} group rounded-2xl border border-white/10 bg-white/[0.04] p-7 transition duration-500 hover:border-emerald-500/40 hover:bg-emerald-900/30 sm:p-9">
                    <div class="flex items-start justify-between gap-5">
                        <span class="text-xs font-medium text-slate-500">0{{ $index + 1 }}</span>
                        <span class="grid h-10 w-10 place-items-center rounded-full border border-white/10 text-emerald-300 transition group-hover:bg-emerald-600 group-hover:text-white">
                            <svg class="h-4 w-4 -rotate-45 transition-transform duration-500 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </span>
                    </div>
                    <h3 class="mt-10 text-2xl font-medium tracking-tight">{{ $service['title'] }}</h3>
                    <ul class="mt-6 grid gap-3 {{ $index === 4 ? 'sm:grid-cols-3' : '' }}">
                        @foreach($service['items'] as $item)
                            <li class="flex items-start gap-3 text-sm leading-6 text-slate-300">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-400"></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#f1f2ef] py-16 sm:py-20 lg:py-28">
    <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="flex items-center gap-3">
            <span class="grid h-7 w-7 place-items-center rounded-full bg-slate-950 text-xs font-semibold text-white">5</span>
            <span class="rounded-full border border-slate-300 px-4 py-1.5 text-xs font-medium text-slate-700">Informasi terkini</span>
        </div>

        <div class="mt-7 flex flex-col justify-between gap-7 md:flex-row md:items-end">
            <h2 class="text-[clamp(2.65rem,7vw,5.7rem)] font-medium leading-none tracking-[-0.055em] text-slate-950">{{ __('frontend.nav.news') }}</h2>
            <a href="{{ route('posts.index') }}" class="group inline-flex w-fit items-center gap-3 text-sm font-semibold text-slate-900">
                Lihat semua berita
                <span class="grid h-8 w-8 place-items-center rounded-full border border-slate-300 transition group-hover:bg-slate-950 group-hover:text-white">
                    <svg class="h-4 w-4 -rotate-45 transition-transform duration-300 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </span>
            </a>
        </div>

        @if($featuredPosts->count())
            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 lg:mt-16 lg:grid-cols-3">
                @foreach($featuredPosts->take(3) as $index => $post)
                    <a href="{{ route('posts.show', $post->slug) }}" class="group block">
                        <div class="relative {{ $index === 1 ? 'aspect-square' : 'aspect-[4/3]' }} overflow-hidden rounded-2xl bg-slate-200">
                            @if($post->thumbnail)
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                            @else
                                <div class="pspkb-news-placeholder h-full w-full"></div>
                            @endif
                            <span class="absolute bottom-4 left-4 flex h-10 w-10 items-center overflow-hidden rounded-full bg-white text-slate-950 shadow-lg transition-all duration-300 group-hover:w-36">
                                <span class="whitespace-nowrap pl-4 text-xs font-semibold opacity-0 transition delay-75 group-hover:opacity-100">Baca berita</span>
                                <svg class="absolute right-3 h-4 w-4 -rotate-45 transition-transform duration-300 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </span>
                        </div>
                        <p class="mt-4 text-xs leading-5 text-slate-500">{{ $post->category?->name ?? 'Berita ULD' }} · {{ $post->published_at?->format('d M Y') }}</p>
                        <h3 class="mt-1 text-lg font-semibold leading-snug tracking-tight text-slate-950 transition group-hover:text-emerald-700">{{ $post->title }}</h3>
                    </a>
                @endforeach
            </div>
        @else
            <div class="mt-12 rounded-2xl border border-slate-300 bg-white/50 p-8 text-sm text-slate-600">Belum ada berita ULD yang diterbitkan.</div>
        @endif
    </div>
</section>

<section class="bg-emerald-800 px-5 py-8 text-white sm:px-8 lg:px-12">
    <div class="mx-auto flex max-w-[1440px] flex-col items-start justify-between gap-8 py-10 md:flex-row md:items-center">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-200">{{ __('frontend.common.inclusive_campus') }}</p>
            <h2 class="mt-3 max-w-3xl text-3xl font-medium leading-tight tracking-[-0.035em] sm:text-5xl">Equal Access, Equal Opportunity.</h2>
        </div>
        <a href="{{ route('contact') }}" class="group inline-flex shrink-0 items-center gap-4 rounded-full bg-white py-2 pl-6 pr-2 text-sm font-semibold text-emerald-900">
            {{ __('frontend.common.contact_uld') }}
            <span class="grid h-9 w-9 place-items-center rounded-full bg-emerald-100">
                <svg class="h-4 w-4 -rotate-45 transition-transform duration-500 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </span>
        </a>
    </div>
</section>
@endsection
