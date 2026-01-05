@extends('layouts.public')

@push('head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <style>
    .leaflet-container img { max-width: none !important; }
    .leaflet-container { font: inherit; }

    /* ==== Leaflet popup dark mode ==== */
    html.dark .leaflet-popup-content-wrapper,
    html.dark .leaflet-popup-tip {
      background: rgba(15, 23, 42, .92) !important; /* slate-900 */
      color: #e2e8f0 !important; /* slate-200 */
      border: 1px solid rgba(255,255,255,.10);
      backdrop-filter: blur(10px);
    }
    html.dark .leaflet-popup-content-wrapper a { color: #93c5fd !important; }
    html.dark .leaflet-popup-close-button { color: #e2e8f0 !important; }
  </style>
@endpush

@section('title', 'Public Map')

@php
  $total = $sites?->count() ?? (is_countable($sites) ? count($sites) : 0);

  $online = collect($sites)->filter(function ($s) {
      $v = $s->status ?? $s->online ?? $s->is_online ?? null;
      if (is_bool($v)) return $v === true;
      if (is_numeric($v)) return (int)$v === 1;
      if (is_string($v)) return in_array(strtolower($v), ['up','online','aktif','active','1','true'], true);
      return false;
  })->count();

  $offline = max($total - $online, 0);

  $sitesJson = collect($sites)->map(function ($s) {
    return [
      'id' => $s->id,
      'name' => $s->name,
      'ip' => $s->ip_address,
      'lat' => (float) $s->latitude,
      'lng' => (float) $s->longitude,
      'status' => (int) $s->status,
      'last' => optional($s->last_checked_at)->toDateTimeString(),
    ];
  })->values()->toJson(JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
@endphp

@section('content')

  {{-- Header section --}}
  <section class="mb-6">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
      <div>
        <h1 class="text-2xl md:text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">
          Public Network Map
        </h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">
          Status lokasi Winfree real-time. Hover untuk lihat nama, klik marker untuk Google Maps.
        </p>
      </div>

      {{-- Search --}}
      <div class="w-full md:w-[360px]">
        <div class="relative">
          <input id="siteSearch"
                 type="text"
                 placeholder="Cari lokasi (nama/alamat)…"
                 class="w-full rounded-2xl px-4 py-3 text-sm
                        bg-white border border-slate-200 text-slate-900 placeholder:text-slate-400
                        focus:outline-none focus:ring-2 focus:ring-blue-500/30
                        dark:bg-white/5 dark:border-white/10 dark:text-slate-100 dark:placeholder:text-slate-400">
          <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
            ⌘K
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Stat cards --}}
  <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="rounded-3xl p-5 shadow-sm
                bg-white border border-slate-200
                dark:bg-white/5 dark:border-white/10 dark:shadow-none">
      <div class="text-xs text-slate-500 dark:text-slate-400">Total lokasi</div>
      <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-white">{{ $total }}</div>
      <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">Jumlah site yang terdaftar.</div>
    </div>

    <div class="rounded-3xl p-5 shadow-sm
                bg-emerald-50 border border-emerald-200
                dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:shadow-none">
      <div class="text-xs text-emerald-700 dark:text-emerald-200">Online</div>
      <div class="mt-1 text-2xl font-semibold text-emerald-700 dark:text-emerald-200">{{ $online }}</div>
      <div class="mt-2 text-xs text-emerald-700/70 dark:text-emerald-200/80">Site terdeteksi aktif.</div>
    </div>

    <div class="rounded-3xl p-5 shadow-sm
                bg-rose-50 border border-rose-200
                dark:bg-rose-500/10 dark:border-rose-500/20 dark:shadow-none">
      <div class="text-xs text-rose-700 dark:text-rose-200">Offline</div>
      <div class="mt-1 text-2xl font-semibold text-rose-700 dark:text-rose-200">{{ $offline }}</div>
      <div class="mt-2 text-xs text-rose-700/70 dark:text-rose-200/80">Site terdeteksi gangguan.</div>
    </div>
  </section>

  {{-- Main grid --}}
  <section class="grid grid-cols-1 lg:grid-cols-5 gap-4">

    {{-- Map --}}
    <div class="lg:col-span-3 rounded-3xl overflow-hidden shadow-sm
                bg-white border border-slate-200
                dark:bg-white/5 dark:border-white/10 dark:shadow-none">
      <div class="p-4 border-b border-slate-200 flex items-center justify-between
                  dark:border-white/10">
        <div>
          <div class="text-sm font-semibold text-slate-900 dark:text-white">Peta Lokasi</div>
          <div class="text-xs text-slate-500 dark:text-slate-300">Klik marker → buka Google Maps</div>
        </div>

        <div class="flex items-center gap-2">
          <span class="inline-flex items-center gap-2 text-xs px-3 py-1.5 rounded-full border
                       bg-emerald-50 border-emerald-200 text-emerald-700
                       dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-200">
            <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Online
          </span>

          <span class="inline-flex items-center gap-2 text-xs px-3 py-1.5 rounded-full border
                       bg-rose-50 border-rose-200 text-rose-700
                       dark:bg-rose-500/10 dark:border-rose-500/20 dark:text-rose-200">
            <span class="h-2 w-2 rounded-full bg-rose-500"></span> Offline
          </span>

          <button id="btnFit"
            class="ml-2 inline-flex items-center rounded-xl border px-3 py-2 text-xs font-medium transition
                   bg-white border-slate-200 text-slate-700 hover:bg-slate-50
                   dark:bg-white/5 dark:border-white/10 dark:text-slate-100 dark:hover:bg-white/10">
            Fit semua titik
          </button>
        </div>
      </div>

      <div class="relative">
        <div id="map" class="h-[460px] w-full"></div>

        <div class="absolute left-4 bottom-4 rounded-2xl px-3 py-2 text-xs shadow-sm
                    bg-white/90 border border-slate-200 text-slate-600 backdrop-blur
                    dark:bg-slate-950/70 dark:border-white/10 dark:text-slate-200">
          Tips: klik marker = Google Maps, hover = lihat nama.
        </div>
      </div>
    </div>

    {{-- List --}}
    <div class="lg:col-span-2 rounded-3xl overflow-hidden shadow-sm
                bg-white border border-slate-200
                dark:bg-white/5 dark:border-white/10 dark:shadow-none">
      <div class="p-4 border-b border-slate-200 flex items-center justify-between
                  dark:border-white/10">
        <div>
          <div class="text-sm font-semibold text-slate-900 dark:text-white">Daftar Lokasi</div>
          <div class="text-xs text-slate-500 dark:text-slate-300">Klik item untuk zoom & buka popup</div>
        </div>
        <div class="text-xs text-slate-500 dark:text-slate-300">{{ $total }} item</div>
      </div>

      <div class="max-h-[540px] overflow-auto">
        <table class="w-full text-sm">
          <thead class="sticky top-0 border-b
                        bg-slate-50 border-slate-200
                        dark:bg-slate-950/60 dark:border-white/10">
            <tr class="text-left text-xs text-slate-600 dark:text-slate-300">
              <th class="px-4 py-3 font-medium">Lokasi</th>
              <th class="px-4 py-3 font-medium">Status</th>
            </tr>
          </thead>

          <tbody id="siteTable" class="text-slate-800 dark:text-slate-100">
            @forelse ($sites as $site)
              @php
                $name = $site->name ?? $site->nama ?? $site->site_name ?? 'Tanpa Nama';
                $addr = $site->address ?? $site->alamat ?? $site->location ?? null;

                $st = $site->status ?? $site->online ?? $site->is_online ?? null;
                $isOnline = false;
                if (is_bool($st)) $isOnline = $st === true;
                elseif (is_numeric($st)) $isOnline = (int)$st === 1;
                elseif (is_string($st)) $isOnline = in_array(strtolower($st), ['up','online','aktif','active','1','true'], true);

                $lat = (float) ($site->latitude ?? 0);
                $lng = (float) ($site->longitude ?? 0);
              @endphp

              <tr class="border-b border-slate-100 hover:bg-slate-50 transition cursor-pointer
                         dark:border-white/10 dark:hover:bg-white/5"
                  data-name="{{ strtolower($name) }}"
                  data-addr="{{ strtolower($addr ?? '') }}"
                  data-lat="{{ $lat }}"
                  data-lng="{{ $lng }}">
                <td class="px-4 py-3">
                  <div class="font-medium text-slate-900 dark:text-white">{{ $name }}</div>
                  @if($addr)
                    <div class="text-xs text-slate-500 dark:text-slate-300 mt-0.5">{{ $addr }}</div>
                  @endif
                </td>

                <td class="px-4 py-3">
                  <span class="inline-flex items-center gap-2 text-xs px-3 py-1.5 rounded-full border
                    {{ $isOnline
                      ? 'bg-emerald-50 border-emerald-200 text-emerald-700 dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-200'
                      : 'bg-rose-50 border-rose-200 text-rose-700 dark:bg-rose-500/10 dark:border-rose-500/20 dark:text-rose-200'
                    }}">
                    <span class="h-2 w-2 rounded-full {{ $isOnline ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                    {{ $isOnline ? 'Online' : 'Offline' }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="px-4 py-10 text-center text-slate-500 dark:text-slate-300">
                  Belum ada data site.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  // Search filter
  (function () {
    const input = document.getElementById('siteSearch');
    const rows = Array.from(document.querySelectorAll('#siteTable tr'));

    window.addEventListener('keydown', (e) => {
      const isK = (e.key || '').toLowerCase() === 'k';
      if ((e.ctrlKey || e.metaKey) && isK) {
        e.preventDefault();
        input?.focus();
      }
    });

    input?.addEventListener('input', () => {
      const q = (input.value || '').trim().toLowerCase();
      rows.forEach(tr => {
        const name = tr.getAttribute('data-name') || '';
        const addr = tr.getAttribute('data-addr') || '';
        tr.style.display = (!q || name.includes(q) || addr.includes(q)) ? '' : 'none';
      });
    });
  })();

  const map = L.map('map').setView([-6.9, 107.6], 12);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap',
  }).addTo(map);

  const sites = {!! $sitesJson !!};

  const iconOnline = L.divIcon({
    className: '',
    html: `<div style="width:14px;height:14px;border-radius:999px;background:#22c55e;border:2px solid #fff;box-shadow:0 0 0 2px rgba(34,197,94,.25)"></div>`,
    iconSize: [14, 14],
    iconAnchor: [7, 7],
  });

  const iconOffline = L.divIcon({
    className: '',
    html: `<div style="width:14px;height:14px;border-radius:999px;background:#ef4444;border:2px solid #fff;box-shadow:0 0 0 2px rgba(239,68,68,.25)"></div>`,
    iconSize: [14, 14],
    iconAnchor: [7, 7],
  });

  const markerByKey = new Map();
  const bounds = [];

  function gmapsLink(lat, lng, name) {
    const q = encodeURIComponent(`${lat},${lng} ${name||''}`.trim());
    return `https://www.google.com/maps/search/?api=1&query=${q}`;
  }

  sites.forEach(s => {
    if (!s.lat || !s.lng || (Number(s.lat) === 0 && Number(s.lng) === 0)) return;

    const icon = Number(s.status) === 1 ? iconOnline : iconOffline;
    const m = L.marker([s.lat, s.lng], { icon }).addTo(map);

    // tooltip nama saat hover
    m.bindTooltip(s.name ?? '-', { direction: 'top', offset: [0, -8], opacity: 0.95 });

    const link = gmapsLink(s.lat, s.lng, s.name);

    // popup + tombol google maps
    m.bindPopup(`
      <div style="min-width:230px">
        <div style="font-weight:700;margin-bottom:6px">${s.name ?? '-'}</div>
        <div style="font-size:12px;color:#94a3b8">IP: ${s.ip ?? '-'}</div>
        <div style="font-size:12px;margin-top:6px">
          Status: <b style="color:${Number(s.status)===1?'#22c55e':'#ef4444'}">${Number(s.status)===1?'Online':'Offline'}</b>
        </div>
        <div style="font-size:12px;color:#94a3b8;margin-top:4px">Last check: ${s.last ?? '-'}</div>
        <a href="${link}" target="_blank" rel="noopener"
           style="display:inline-block;margin-top:10px;padding:8px 10px;border-radius:12px;
                  background:#2563eb;color:#fff;font-size:12px;font-weight:600;text-decoration:none">
          Buka Google Maps
        </a>
      </div>
    `);

    // klik marker langsung ke google maps juga
    m.on('click', () => window.open(link, '_blank'));

    const key = `${Number(s.lat).toFixed(6)},${Number(s.lng).toFixed(6)}`;
    markerByKey.set(key, m);

    bounds.push([s.lat, s.lng]);
  });

  if (bounds.length) map.fitBounds(bounds, { padding: [30, 30] });
  setTimeout(() => map.invalidateSize(), 300);

  // klik list -> zoom + open popup
  document.querySelectorAll('#siteTable tr[data-lat]').forEach(tr => {
    tr.addEventListener('click', () => {
      const lat = Number(tr.getAttribute('data-lat'));
      const lng = Number(tr.getAttribute('data-lng'));
      if (!lat || !lng) return;

      const key = `${lat.toFixed(6)},${lng.toFixed(6)}`;
      const m = markerByKey.get(key);

      map.setView([lat, lng], 15, { animate: true });
      if (m) m.openPopup();
    });
  });

  // fit button
  document.getElementById('btnFit')?.addEventListener('click', () => {
    if (bounds.length) map.fitBounds(bounds, { padding: [30, 30] });
  });

});
</script>
@endpush
