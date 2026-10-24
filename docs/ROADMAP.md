# Roadmap Implementasi

Roadmap ini membagi pekerjaan berdasarkan kemampuan yang dapat diuji dan direview. Setiap perubahan perilaku disertai test terkait, sedangkan satu commit mencakup satu perubahan logis.

## Phase 0 — Acuan dan keputusan teknis

**Tujuan:** menyimpan requirement, batas MVP, arsitektur, dan urutan delivery.

Artefak: project brief, arsitektur, roadmap, PDF penugasan, dan transkripsi teks.

## Phase 1 — Fondasi aplikasi

**Tujuan:** aplikasi memiliki identitas, UI dasar Blade/Tailwind, dan dapat dijalankan secara deterministik dengan Docker.

Urutan commit:

1. Konfigurasi nama aplikasi, locale, dan zona waktu.
2. Layout Blade, komponen UI, landing page, dan asset Vite.
3. Docker multi-stage build, entrypoint, healthcheck, serta seeder idempotent.

Kriteria selesai:

- `docker compose up --build` menghasilkan aplikasi sehat.
- Asset Vite tersedia tanpa menjalankan Node secara manual.
- Restart container tidak mengganti application key atau menggandakan seed.
- Test konfigurasi, shell aplikasi, dan seeder lulus.

## Phase 2 — Domain data

**Tujuan:** menyediakan schema katalog, supplier, kontak, submission, dan data pendukung procurement.

- Satuan, kategori, dan katalog barang.
- Supplier dengan beberapa sales contact.
- Submission dan item dengan snapshot historis.
- History status, follow-up, dan audit mapping.
- Factory, seeder katalog, MySQL `schema.sql`, dan dokumentasi relasi.

## Phase 3 — Penawaran publik dan receipt

**Tujuan:** menyelesaikan alur QR sampai bukti penerimaan.

- Landing dan form multi-item yang mobile-first.
- Form Request untuk validasi input.
- Service transaksi submission dan nomor referensi.
- Perlindungan double submit, honeypot, dan rate limit.
- Receipt bertoken acak serta email simulasi melalui log.

Landing supplier dipisahkan dari Form Request dan service. Perubahan copy, susunan section, dan styling tidak boleh mengubah proses penyimpanan penawaran.

## Phase 4 — Procurement dan repeat supplier

**Tujuan:** procurement dapat meninjau penawaran serta menangani supplier yang kembali.

- Login/logout dan pembatasan akses procurement.
- Daftar, filter, detail, status, serta follow-up.
- Pencocokan kandidat supplier tanpa auto-merge berdasarkan sinyal lemah.
- Beberapa sales contact per supplier.
- Mapping item supplier ke katalog dan satuan internal.

## Phase 5 — Normalisasi dan perbandingan harga

**Tujuan:** membandingkan penawaran yang setara dan masih valid.

- Normalisasi harga PPN included/excluded.
- Konversi kemasan supplier ke satuan dasar.
- Eligibility berdasarkan mapping, status, dan masa berlaku.
- Ranking berdasarkan harga ternormalisasi dengan MOQ serta lead time sebagai konteks.

## Phase 6 — Hardening dan pengumpulan

**Tujuan:** memastikan aplikasi aman secara proporsional, terdokumentasi, dan siap didemokan.

- Security headers, rate limit, audit, dan pengujian akses.
- QR final dan data demo representatif.
- README, dokumentasi keamanan, dan schema final.
- Full test suite, formatting, dependency audit, dan clean-start smoke test.

## Backlog opsional

- Cek status melalui referensi dan kontak.
- PDF receipt atau share receipt.
- Riwayat harga supplier per barang.
- Duplicate supplier merge UI.
- SLA reminder dan analytics sumber QR.

Backlog tidak boleh menunda alur utama penugasan.
