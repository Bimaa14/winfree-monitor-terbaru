@extends('layouts.public')

@section('title', 'Winfree - WiFi Publik')

@section('content')

<section class="relative overflow-hidden">
  <div class="absolute inset-0 pointer-events-none bg-gradient-to-b from-blue-50 via-white to-white
              dark:from-slate-950 dark:via-slate-950 dark:to-slate-950"></div>

  <div class="relative mx-auto max-w-6xl px-4 py-14 md:py-20 grid gap-10 md:grid-cols-2 items-center">

    {{-- LEFT --}}
    <div>
      <div class="inline-flex items-center gap-2 rounded-full border bg-white px-3 py-1 text-xs text-slate-600
                  dark:bg-white/5 dark:border-white/10 dark:text-slate-300">
        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
        Status jaringan diperbarui realtime
      </div>

      <h1 class="mt-4 text-4xl md:text-5xl font-semibold tracking-tight
                 text-slate-900 dark:text-white">
        WiFi Publik yang gampang dicari,<br>
        gampang dipakai.
      </h1>

      <p class="mt-4 text-slate-600 dark:text-slate-300 leading-relaxed">
        Lihat peta lokasi, cek status online/offline, dan temukan titik Winfree terdekat.
        Tampilan dibuat khusus untuk publik—rapi, jelas, dan ringan.
      </p>

      <div class="mt-8 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('public.map') }}"
           class="inline-flex justify-center items-center rounded-2xl
                  bg-blue-600 px-5 py-3 text-sm font-medium text-white
                  hover:bg-blue-700 transition">
          Lihat Peta Lokasi
        </a>

        <a href="#paket"
           class="inline-flex justify-center items-center rounded-2xl border
                  px-5 py-3 text-sm font-medium text-slate-700
                  hover:bg-slate-50 transition
                  dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/5">
          Lihat Paket
        </a>
      </div>

      {{-- STATS --}}
      <div class="mt-8 grid grid-cols-3 gap-3">
        <div class="rounded-2xl border bg-white p-4
                    dark:bg-white/5 dark:border-white/10">
          <div class="text-xs text-slate-500 dark:text-slate-400">Lokasi</div>
          <div class="mt-1 text-lg font-semibold">10+</div>
        </div>

        <div class="rounded-2xl border bg-white p-4
                    dark:bg-white/5 dark:border-white/10">
          <div class="text-xs text-slate-500 dark:text-slate-400">Online</div>
          <div class="mt-1 text-lg font-semibold text-emerald-500">—</div>
        </div>

        <div class="rounded-2xl border bg-white p-4
                    dark:bg-white/5 dark:border-white/10">
          <div class="text-xs text-slate-500 dark:text-slate-400">Offline</div>
          <div class="mt-1 text-lg font-semibold text-rose-500">—</div>
        </div>
      </div>
    </div>

    {{-- RIGHT --}}
    <div class="md:justify-self-end w-full">
      <div class="rounded-3xl border bg-white shadow-sm p-6
                  dark:bg-white/5 dark:border-white/10 dark:shadow-none">
        <div class="text-sm font-medium text-slate-900 dark:text-white">
          Akses cepat
        </div>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
          Cek lokasi & status.
        </p>

        <div class="mt-5">
          <a href="{{ route('public.map') }}"
             class="block rounded-2xl bg-slate-900 px-4 py-3 text-sm font-medium
                    text-white hover:bg-slate-800 text-center transition
                    dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
            Buka Peta Lokasi
          </a>
        </div>

        <div class="mt-6 rounded-2xl bg-blue-50 p-4 text-sm text-slate-700
                    dark:bg-white/5 dark:text-slate-200 dark:border dark:border-white/10">
          <div class="font-medium">Tips</div>
          <ul class="mt-2 list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-300">
            <li>Pakai fitur search di halaman peta.</li>
            <li>Klik marker untuk detail lokasi.</li>
            <li>Status offline = kemungkinan ada gangguan.</li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- ===================== PAKET ===================== --}}
<section id="paket" class="bg-slate-50 border-y
                           dark:bg-slate-950 dark:border-white/10">
  <div class="mx-auto max-w-6xl px-4 py-14">

    <h2 class="text-2xl md:text-3xl font-semibold tracking-tight
               text-slate-900 dark:text-white">
    <img src="{{ asset('assets/simaya.png') }}"
     alt="SIMAYA"
     class="h-10 w-auto opacity-90 dark:opacity-100 dark:brightness-110">

      Paket Internet Rumahan SIMAYA
    </h2>

    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 max-w-2xl">
      Paket internet rumah. Klik WhatsApp untuk daftar / cek coverage.
    </p>

    <div class="mt-10 grid gap-4 md:grid-cols-3">

      {{-- CARD --}}
      @foreach([
        ['Basic','20 Mbps','Rp 150.000/bulan','Cocok untuk browsing & sosmed.'],
        ['Family','50 Mbps','Rp 250.000/bulan','Streaming & kebutuhan keluarga.'],
        ['Pro','100 Mbps','Rp 350.000/bulan','WFH, gaming, banyak device.'],
      ] as $p)
      <div class="rounded-3xl border bg-white p-6
                  dark:bg-white/5 dark:border-white/10">

        <div class="flex items-start justify-between">
          <div>
            <div class="text-xs text-slate-500 dark:text-slate-400">Paket</div>
            <div class="mt-1 text-lg font-semibold">{{ $p[0] }}</div>
          </div>

          <span class="rounded-2xl bg-blue-50 text-blue-700 px-3 py-1 text-xs border
                       dark:bg-blue-500/10 dark:text-blue-200 dark:border-blue-500/20">
            {{ $p[1] }}
          </span>
        </div>

        <div class="mt-4 text-3xl font-semibold tracking-tight">{{ $p[2] }}</div>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $p[3] }}</p>

        <div class="mt-6">
          <a href="https://wa.me/62812XXXXXXX"
             target="_blank"
             class="inline-flex w-full items-center justify-center gap-2
                    rounded-2xl bg-green-600 px-4 py-3 text-sm font-medium text-white
                    hover:bg-green-700 transition">
            Chat WhatsApp
          </a>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-8 rounded-3xl border bg-white p-5 text-sm text-slate-700
                dark:bg-white/5 dark:border-white/10 dark:text-slate-200">
      <strong>Catatan:</strong>
      Paket SIMAYA berbeda dengan Winfree.
    </div>
  </div>
</section>

@endsection
