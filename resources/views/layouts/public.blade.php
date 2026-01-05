<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Winfree')</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    .leaflet-container img { max-width: none !important; }
    .leaflet-container { font: inherit; }
    @keyframes popIn { from { opacity:0; transform: translateY(10px) scale(.98);} to {opacity:1; transform:none;} }
    .page-pop { animation: popIn .35s ease-out both; }
  </style>

  @stack('head')
</head>

<body class="min-h-screen bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">
  <header class="sticky top-0 z-[9999] pointer-events-auto border-b bg-white/80 backdrop-blur
                 dark:border-white/10 dark:bg-slate-950/70">
    <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between gap-4 relative">
      <a href="{{ route('public.home') }}" class="flex items-center gap-3">
        <div class="h-10 w-10 rounded-2xl bg-white/5 border border-slate-200 dark:border-white/10 grid place-items-center overflow-hidden">
          <img src="{{ asset('assets/winfree.png') }}" alt="Winfree" class="h-7 w-7 object-contain">
        </div>
        <div class="leading-tight">
          <div class="font-semibold tracking-tight">Winfree</div>
          <div class="text-xs text-slate-500 dark:text-slate-400">Public WiFi</div>
        </div>
      </a>

      <nav class="hidden md:flex items-center gap-6 text-sm text-slate-600 dark:text-slate-300">
        <a href="{{ route('public.home') }}" class="hover:text-slate-900 dark:hover:text-white">Beranda</a>
        <a href="#paket" class="hover:text-slate-900 dark:hover:text-white">Internet Rumahan</a>
        <a href="#cara" class="hover:text-slate-900 dark:hover:text-white">Cara Pakai</a>
        <a href="{{ route('public.map') }}" class="hover:text-slate-900 dark:hover:text-white">Peta Lokasi</a>
      </nav>

      <div class="flex items-center gap-2">
        <button type="button" id="themeToggle"
          class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-sm
                 bg-white text-slate-700 hover:bg-slate-100 border-slate-200
                 dark:bg-white/10 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/20">
          <span id="themeIcon">🌙</span>
          <span id="themeText">Dark</span>
        </button>

        <a href="{{ route('public.map') }}"
           class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
          Cek Lokasi
        </a>
      </div>
    </div>
  </header>

  <main class="page-pop relative">
    @yield('content')
  </main>

  <footer class="border-t bg-slate-50 dark:border-white/10 dark:bg-slate-950">
    <div class="mx-auto max-w-6xl px-4 py-10 grid gap-6 md:grid-cols-3">
      <div>
        <div class="font-semibold">Winfree</div>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
          Akses WiFi publik untuk area strategis. Informasi lokasi & status dibuat simpel untuk publik.
        </p>
      </div>
      <div class="text-sm text-slate-600 dark:text-slate-300">
        <div class="font-medium text-slate-900 dark:text-white">Menu</div>
        <div class="mt-2 grid gap-2">
          <a href="{{ route('public.map') }}" class="hover:text-slate-900 dark:hover:text-white">Peta Lokasi</a>
        </div>
      </div>
      <div class="text-sm text-slate-600 dark:text-slate-300">
        <div class="font-medium text-slate-900 dark:text-white">Kontak</div>
        <div class="mt-2 grid gap-2">
          <span>Support: (isi nanti)</span>
          <span>© 2026 Winfree</span>
        </div>
      </div>
    </div>
  </footer>

  @stack('scripts')
</body>
</html>
