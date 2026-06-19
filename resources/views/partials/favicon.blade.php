@php
    $configuredFavicon = $settings['favicon'] ?? null;

    if ($configuredFavicon === null) {
        $configuredFavicon = \App\Models\Setting::getValue('favicon', '');
    }

    $configuredFavicon = trim((string) $configuredFavicon);
    $fallbackPath = public_path('favicon.png');
    $fallbackUrl = asset('favicon.png');

    if ($configuredFavicon !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($configuredFavicon)) {
        $faviconUrl = asset('storage/' . $configuredFavicon);
        $faviconVersion = \Illuminate\Support\Facades\Storage::disk('public')->lastModified($configuredFavicon);
    } else {
        $faviconUrl = $fallbackUrl;
        $faviconVersion = file_exists($fallbackPath) ? filemtime($fallbackPath) : time();
    }

    $faviconExtension = strtolower(pathinfo(parse_url($faviconUrl, PHP_URL_PATH), PATHINFO_EXTENSION));
    $faviconType = match ($faviconExtension) {
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'jpg', 'jpeg' => 'image/jpeg',
        default => 'image/png',
    };
@endphp

<link rel="icon" href="{{ $faviconUrl }}?v={{ $faviconVersion }}" type="{{ $faviconType }}">
<link rel="shortcut icon" href="{{ $faviconUrl }}?v={{ $faviconVersion }}" type="{{ $faviconType }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}?v={{ $faviconVersion }}">
