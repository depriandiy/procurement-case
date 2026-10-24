# Arsitektur Portal Penawaran Supplier

## Stack dan prinsip

- Laravel 13 sebagai aplikasi full stack.
- PHP `8.4.27` dan MySQL `8.4` melalui Docker Compose.
- Blade untuk server-rendered UI dan Tailwind CSS melalui Vite.
- Migration Laravel sebagai sumber evolusi schema; `database/schema.sql` disediakan untuk artefak pengumpulan.
- Controller tipis, validasi melalui Form Request, dan transaksi bisnis melalui service.
- Perhitungan harga dilakukan kembali di server dengan tipe decimal.

```text
Route -> Middleware -> Form Request -> Controller -> Service -> Model
                                      -> View / Redirect
```

## Pemisahan landing supplier

Landing supplier merupakan lapisan presentasi. Route `GET` hanya merender Blade dengan data tampilan sederhana. Route `POST` memakai Form Request dan application service untuk memvalidasi serta menyimpan penawaran.

Blade tidak menjalankan query, mencocokkan supplier, menghitung harga, atau menyimpan data. Copy, susunan section, CTA, warna, dan spacing berada pada view/partial serta token Tailwind. Dengan batas ini, UI landing dapat diubah tanpa memengaruhi aturan submission, model, atau schema.

## Alur utama

```text
QR -> form publik -> validasi -> transaksi submission
   -> nomor referensi + receipt -> email log
   -> review procurement -> mapping katalog -> perbandingan
```

Email dijalankan melalui log untuk demo sehingga tidak memerlukan layanan eksternal atau queue worker.

## Model data konseptual

- `users`: akun internal procurement.
- `suppliers`: identitas perusahaan saat ini dan identifier publik.
- `supplier_contacts`: beberapa sales contact untuk satu supplier.
- `units`, `categories`, `catalog_items`: master barang serta satuan dasar internal.
- `item_aliases`: mapping nama atau kemasan supplier yang sudah disetujui.
- `submissions`: satu kejadian penawaran, masa berlaku, status, dan snapshot identitas.
- `submission_items`: snapshot item, harga, status pajak, kemasan, MOQ, lead time, mapping, dan hasil normalisasi.
- `submission_status_histories`: histori perubahan status.
- `follow_ups`: catatan tindak lanjut procurement.

Submission baru tidak menimpa submission lama. Snapshot menjaga bukti historis ketika profil supplier, kontak, katalog, atau mapping berubah.

## Identitas supplier

NPWP ternormalisasi yang sama dapat menjadi identitas kuat. Email, telepon, nama, dan kota hanya menjadi sinyal kandidat karena sales dapat berpindah perusahaan atau menggunakan data yang sama. Sinyal lemah memerlukan review procurement dan tidak melakukan merge otomatis.

Supplier yang kembali dapat memiliki sales contact dan produk baru. Revisi atau supersede hanya terjadi melalui tindakan eksplisit; kedatangan baru tidak otomatis membatalkan penawaran sebelumnya.

## Normalisasi harga

Nilai mentah dari supplier dipertahankan. Setelah procurement menyetujui mapping serta conversion factor, harga pembanding dihitung di server:

```text
price_excl_tax = price_includes_tax
    ? offered_price / (1 + tax_rate / 100)
    : offered_price

normalized_price = price_excl_tax / base_units_per_offered_unit
```

Penawaran hanya ikut ranking ketika item telah dipetakan, conversion factor disetujui, supplier dan item aktif, masa berlaku belum habis, serta statusnya eligible. MOQ dan lead time ditampilkan sebagai konteks dan tidak digabungkan dalam skor arbitrer.

## Keamanan

- CSRF untuk semua form yang mengubah data.
- Blade escaping untuk seluruh input supplier.
- Form Request dan allowlist field untuk validasi server.
- Rate limit terpisah untuk login, submit publik, dan receipt.
- Idempotency token untuk mencegah submission ganda.
- Session regeneration saat login dan invalidation saat logout.
- Authorization untuk seluruh area procurement.
- Token receipt acak dan tidak memakai ID database berurutan.
- Batas jumlah item, ukuran request, dan pagination.

Mitigasi yang belum dibuat harus dicatat secara jujur pada dokumentasi akhir.

## Docker dan pengujian

Docker membangun dependency Composer dan asset Vite, menunggu MySQL, menyiapkan application key persisten, menjalankan migration/seeder yang idempotent, lalu memulai Laravel. Clean-start smoke test menggunakan Compose project dan volume terisolasi agar data development tidak dihapus.

Pengujian mencakup unit test untuk aturan bisnis, feature test untuk alur aplikasi, verifikasi constraint pada MySQL, dan Docker smoke test untuk startup satu perintah.
