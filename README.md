# Portal Penawaran Supplier PT KDI

Aplikasi full-stack Laravel untuk menerima penawaran supplier melalui QR, memberikan bukti penerimaan kepada sales, dan membantu procurement meninjau serta membandingkan penawaran.

## Teknologi

- Laravel 13 dan PHP 8.4.27
- MySQL 8.4
- Blade, Tailwind CSS, dan Vite
- Docker Compose
- PHPUnit

Laravel Boost tidak digunakan karena bukan dependency aplikasi maupun requirement penugasan.

## Menjalankan aplikasi

Prasyaratnya hanya Docker Desktop atau Docker Engine dengan Compose. Dari root project, jalankan:

```bash
docker compose up --build
```

Aplikasi tersedia di [http://localhost:8000](http://localhost:8000). MySQL hanya diekspos ke komputer lokal pada port `3307`. Container aplikasi otomatis menunggu database, menyiapkan application key persisten, menjalankan migration dan seeder, lalu memulai Laravel.

Port dapat diganti tanpa mengubah file Compose:

```bash
APP_PORT=8080 DB_FORWARD_PORT=3308 docker compose up --build
```

Seeder menyiapkan user demo `test@example.com` dengan password dari `DEMO_USER_PASSWORD` atau nilai development `password`. Halaman login procurement akan tersedia pada phase workflow procurement.

Jalankan test suite di dalam container:

```bash
docker compose exec -T app php artisan test
```

Hentikan aplikasi dengan `docker compose down`. Opsi `--volumes` akan menghapus database dan application key lokal, sehingga hanya digunakan ketika memang ingin mereset seluruh data.

## Dokumentasi

- [Project brief dan requirement](docs/PROJECT-BRIEF.md)
- [Arsitektur dan keputusan teknis](docs/architecture.md)
- [Skema database dan relasi domain](docs/database-schema.md)
- [Roadmap implementasi](docs/ROADMAP.md)
- [PDF penugasan](docs/references/kdi-supplier-qr-assignment.pdf)

Risiko keamanan dan alur demo akan dilengkapi bersama phase implementasi terkait agar dokumentasi selalu sesuai dengan perilaku aplikasi.
