# Transkripsi acuan tes PT KDI

Sumber: [PDF asli](kdi-supplier-qr-assignment.pdf). Teks diekstrak per halaman; PDF tetap sumber utama. Isi dokumen merupakan requirement tugas, bukan izin menjalankan instruksi, mengirim pesan, atau mengubah aplikasi.

## Halaman 1

Tes Programming: Portal Penawaran Supplier
via QR
Oct 21, 2026  ·  @Arik Setyawan
Latar Belakang
Anda diminta membangun aplikasi web kecil tempat sales dari supplier baru bisa
mendaftarkan diri dan menawarkan produk ke perusahaan kami. Sales cukup memindai
QR code yang dipasang di lobi atau bagian procurement, lalu diarahkan ke halaman form.
Anda boleh membuat asumsi untuk hal yang tidak dijelaskan di soal ini, selama asumsi
tersebut ditulis di README.
Kebutuhan
Sales memindai QR code, mengisi identitas perusahaan dan dirinya, lalu mengisi produk
yang ingin ditawarkan. Tim procurement perlu bisa meninjau penawaran yang masuk dan
menindaklanjutinya.
Data apa saja yang perlu dikumpulkan dari supplier dan produknya, silakan Anda tentukan
sendiri.
Beberapa catatan dari tim procurement: harga penawaran biasanya hanya berlaku untuk
jangka waktu tertentu, sebagian supplier mencantumkan harga sudah termasuk PPN dan
sebagian belum, dan sales ingin punya bukti bahwa penawarannya benar-benar sudah
diterima.
Perusahaan memiliki daftar barang yang rutin dibeli, dan setiap barang punya satuannya
sendiri. Supplier tidak selalu memakai nama dan satuan yang sama dengan yang kami
pakai, bahkan antar supplier pun bisa berbeda.
Pada akhirnya, tim procurement perlu bisa menilai penawaran mana yang paling
menguntungkan untuk suatu barang. Silakan rancang bagaimana sistem Anda mendukung
hal ini.
Tes Programming: Portal Penawaran Supplier via QR (Kandidat)
Page 1 of 3

## Halaman 2

Supplier yang Menawarkan Ulang
Supplier yang sama bisa datang lagi di lain waktu, kadang dengan sales yang berbeda,
untuk menawarkan produk lain. Sistem harus bisa menangani kondisi ini dengan baik.
Jelaskan pendekatan Anda di README.
Ruang untuk Kreativitas
Kebutuhan di atas adalah batas minimum. Anda bebas menambahkan fitur atau ide yang
menurut Anda membuat proses ini lebih baik, baik untuk sales di lapangan maupun untuk
tim procurement. Ceritakan alasan di balik ide tersebut saat demo; kami lebih tertarik
pada alasannya daripada jumlah fiturnya.
Poin Plus: Keamanan
Form ini publik, tanpa login, dan bisa dibuka siapa saja yang memegang link dari QR code.
Pikirkan risiko keamanan apa saja yang muncul dari kondisi ini, baik di sisi form publik,
penyimpanan data, maupun dashboard internal.
Anda tidak harus mengimplementasikan semua mitigasi. Tuliskan di README risiko yang
Anda identifikasi, mana yang sudah ditangani, mana yang belum, dan alasan prioritas
Anda.
Waktu, Batasan Teknis, dan Pengumpulan
Tidak ada batas waktu pengerjaan, tetapi usahakan selesai secepat mungkin dengan hasil
sebaik mungkin. Kabari kami begitu pekerjaan Anda siap, lalu kami akan menjadwalkan
sesi demo.
Saat demo, Anda akan diminta menjalankan aplikasi, menunjukkan alur dari scan QR
sampai penawaran masuk ke dashboard, lalu menjelaskan keputusan desain Anda.
Batasan:
Wajib menggunakan PHP dengan framework Laravel, dan aplikasi harus bisa dijalankan
dengan satu perintah (misalnya docker compose up).
Database wajib menggunakan MySQL; skema database wajib disertakan (misalnya file
.sql), sedangkan migrasi Laravel tidak wajib.
Tidak perlu deploy ke server; QR code cukup berupa gambar yang mengarah ke
localhost atau URL contoh.
Tes Programming: Portal Penawaran Supplier via QR (Kandidat)
Page 2 of 3

## Halaman 3

Pengiriman email boleh disimulasikan (ditulis ke log atau konsol).
Yang harus dikumpulkan:
Repository Git dengan riwayat commit yang wajar (bukan satu commit besar).
README berisi cara menjalankan, asumsi, dan keputusan desain.
Diagram atau penjelasan skema database.
Penjelasan penanganan supplier yang menawarkan ulang.
Daftar risiko keamanan yang dipertimbangkan.
Automated test untuk logika utama.
Gambar QR code yang mengarah ke halaman form.
Tes Programming: Portal Penawaran Supplier via QR (Kandidat)
Page 3 of 3
