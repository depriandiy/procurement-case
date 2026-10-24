# Project Brief — Portal Penawaran Supplier PT KDI

## Latar belakang

PT KDI membutuhkan portal agar sales supplier dapat mengirim penawaran melalui tautan atau QR tanpa membuat akun. Tim procurement kemudian meninjau, menindaklanjuti, dan membandingkan penawaran tersebut dalam satu aplikasi.

Requirement asli tersedia pada [PDF penugasan](references/kdi-supplier-qr-assignment.pdf) dan [transkripsi teks](references/assignment-text.md). Dokumen ini merangkum scope implementasi tanpa menggantikan sumber tersebut.

## Kebutuhan utama

| ID | Kebutuhan | Bukti penerimaan |
|---|---|---|
| R1 | QR membuka form publik tanpa login | QR dan halaman penawaran dapat dibuka |
| R2 | Form memuat perusahaan, sales, dan produk | Submission tersimpan lengkap |
| R3 | Procurement dapat meninjau dan menindaklanjuti | Daftar, detail, status, dan catatan follow-up |
| R4 | Harga memiliki masa berlaku dan status PPN | Input serta perbandingan memperhitungkan keduanya |
| R5 | Sales memperoleh bukti penerimaan | Nomor referensi dan receipt |
| R6 | Ada katalog barang dan satuan internal | Master barang dan satuan tersedia |
| R7 | Nama dan satuan supplier dapat berbeda | Pemetaan serta konversi dapat ditinjau |
| R8 | Penawaran dapat dibandingkan secara setara | Harga ternormalisasi dan alasan eligibility terlihat |
| R9 | Supplier dapat kembali dengan sales atau produk berbeda | Histori tetap utuh tanpa menggandakan perusahaan |
| R10 | Laravel, MySQL, dan satu perintah startup | Verifikasi dari checkout bersih |
| R11 | Skema database disertakan | Migration, SQL schema, dan dokumentasi relasi |
| R12 | Riwayat Git mudah ditinjau | Commit atomik per perubahan logis |
| R13 | README menjelaskan cara menjalankan dan keputusan desain | Dokumentasi pengumpulan lengkap |
| R14 | Logika utama memiliki automated test | Unit dan feature test terkait |

Email boleh disimulasikan melalui log. Deployment publik tidak termasuk kewajiban penugasan.

## Batas MVP

- Aplikasi full-stack Laravel dengan Blade dan Tailwind CSS melalui Vite.
- PHP `8.4.27`, MySQL `8.4`, dan Docker Compose sebagai jalur runtime utama.
- Mata uang awal hanya IDR.
- Receipt berupa HTML yang ramah cetak; PDF tidak termasuk MVP.
- Lampiran, OCR, integrasi WhatsApp/ERP, multi-currency, dan purchase order tidak termasuk MVP.
- Laravel Boost tidak digunakan karena bukan dependency aplikasi atau requirement penugasan.

## Asumsi penting

- NPWP yang sama dan telah dinormalisasi merupakan sinyal identitas supplier yang kuat.
- Email, nomor telepon, nama perusahaan, atau kota saja tidak cukup untuk auto-merge supplier.
- Kedatangan supplier kembali selalu membuat submission baru; penawaran lama tidak ditimpa.
- Data identitas dan item disimpan sebagai snapshot pada submission agar receipt historis tidak berubah.
- Tarif pajak disimpan sesuai input dan tidak dianggap sebagai satu nilai global yang selalu benar.
- Harga yang belum dipetakan atau belum memiliki konversi satuan yang disetujui tidak ikut ranking.
- `valid_until` berlaku sampai akhir tanggal pada zona `Asia/Jakarta`.

## Ukuran keberhasilan

Project siap didemokan ketika checkout bersih dapat dijalankan dengan satu perintah, QR membuka form, submission menghasilkan receipt, procurement dapat melakukan review dan mapping, perbandingan harga dapat dijelaskan, supplier berulang tidak merusak histori, seluruh test hijau, dan artefak pengumpulan tersedia.
