@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <section class="relative isolate overflow-hidden border-b border-slate-200 bg-white">
        <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-80 bg-gradient-to-b from-brand-50 to-white" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-28 top-10 -z-10 size-80 rounded-full bg-brand-100/70 blur-3xl" aria-hidden="true"></div>

        <div class="mx-auto grid w-full max-w-7xl gap-12 px-5 py-16 sm:px-8 sm:py-20 lg:grid-cols-[1.08fr_0.92fr] lg:items-center lg:px-10 lg:py-24">
            <div>
                <x-ui.badge variant="neutral" class="mb-5 border border-slate-200 bg-white/80">
                    Portal resmi pengajuan supplier
                </x-ui.badge>

                <h1 class="max-w-3xl text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl lg:leading-[1.08]">
                    Penawaran supplier yang lebih mudah ditinjau
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">
                    Sales dapat mengirimkan profil perusahaan dan detail produk melalui satu alur. Tim procurement menerima data yang rapi untuk ditinjau dan dibandingkan.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <x-ui.button disabled aria-describedby="offer-status">
                        Kirim Penawaran
                        <span aria-hidden="true">→</span>
                    </x-ui.button>
                    <x-ui.button variant="secondary" disabled aria-describedby="procurement-status">
                        Masuk Procurement
                    </x-ui.button>
                </div>

                <div class="mt-4 space-y-1 text-sm text-slate-500">
                    <p id="offer-status">Form penawaran tersedia pada tahap berikutnya.</p>
                    <p id="procurement-status">Akses procurement sedang disiapkan.</p>
                </div>
            </div>

            <div class="relative">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-xl shadow-slate-900/5 sm:p-7">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-700">Alur penawaran</p>
                            <p class="mt-1 text-sm text-slate-500">Ringkas, transparan, dan terlacak</p>
                        </div>
                        <span class="grid size-10 place-items-center rounded-full bg-brand-50 text-brand-700" aria-hidden="true">
                            ✓
                        </span>
                    </div>

                    <ol class="mt-6 space-y-5">
                        @foreach ([
                            ['01', 'Pindai QR', 'Buka halaman penawaran tanpa membuat akun.'],
                            ['02', 'Lengkapi data', 'Isi identitas perusahaan, sales, dan detail produk.'],
                            ['03', 'Terima bukti', 'Dapatkan nomor referensi setelah penawaran diterima.'],
                            ['04', 'Ditinjau procurement', 'Penawaran dipetakan dan dibandingkan secara konsisten.'],
                        ] as [$number, $title, $description])
                            <li class="flex gap-4">
                                <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-slate-950 text-xs font-bold text-white">{{ $number }}</span>
                                <div>
                                    <h2 class="text-sm font-semibold text-slate-900">{{ $title }}</h2>
                                    <p class="mt-1 text-sm leading-6 text-slate-500">{{ $description }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto w-full max-w-7xl px-5 py-12 sm:px-8 lg:px-10 lg:py-16" aria-labelledby="portal-benefits">
        <div class="mb-8 max-w-2xl">
            <p class="text-sm font-semibold text-brand-700">Satu sumber data</p>
            <h2 id="portal-benefits" class="mt-2 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Dibangun untuk kedua sisi proses pengadaan</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            @foreach ([
                ['Sales supplier', 'Pengisian mobile-friendly dan bukti penerimaan yang dapat disimpan.'],
                ['Tim procurement', 'Data masuk dalam format konsisten untuk review dan tindak lanjut.'],
                ['Keputusan pembelian', 'Harga, PPN, satuan, dan masa berlaku dapat dibandingkan dengan jelas.'],
            ] as [$title, $description])
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="mb-5 block h-1.5 w-10 rounded-full bg-brand-600" aria-hidden="true"></span>
                    <h3 class="font-semibold text-slate-950">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
