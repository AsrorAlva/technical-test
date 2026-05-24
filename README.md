# School Ticketing System

## 1. Project Overview

School Ticketing System adalah aplikasi ticketing sederhana untuk kebutuhan sekolah. Aplikasi ini digunakan oleh guru untuk mengirim ticket atau laporan kendala, dan digunakan oleh admin untuk melihat semua ticket yang masuk serta mengubah status pengerjaannya.

Fitur utama aplikasi:

- Login dan logout.
- Role user: `teacher` dan `admin`.
- Teacher dapat membuat ticket baru.
- Teacher hanya dapat melihat data ticket miliknya sendiri.
- Admin dapat melihat semua ticket dari semua teacher.
- Admin dapat mengubah status ticket menjadi `submitted`, `ongoing`, atau `done`.
- Dashboard menampilkan overview jumlah ticket berdasarkan status.

Default akun yang tersedia setelah seeding:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@test.com` | `password` |
| Teacher | `teacher@test.com` | `password` |
| Teacher | `teacher2@test.com` | `password` |

## 2. Tech Stack

Aplikasi ini dibuat menggunakan:

- Laravel 12 sebagai backend framework.
- PHP 8.2 sebagai bahasa utama backend.
- Blade sebagai template engine untuk tampilan.
- Tailwind CSS untuk styling UI.
- Vite untuk build frontend assets.
- MySQL 8 sebagai database utama ketika dijalankan menggunakan Docker.
- Docker dan Docker Compose untuk menjalankan aplikasi dan database secara konsisten.

## 3. Setup Interaction

Copy file environment:

```bash
cp .env.example .env
```

Jalankan aplikasi dengan Docker:

```bash
docker compose up --build
```

Docker akan menjalankan aplikasi Laravel, database MySQL, migration, dan seeder secara otomatis.

Untuk membuka aplikasi, akses:

```txt
http://localhost:8000
```

Jika ingin mengecek database menggunakan DBeaver atau database client lain, gunakan konfigurasi berikut:

```txt
Host: localhost
Port: 3306
Database: technical_test
Username: root
Password: root
```

Pastikan konfigurasi database di `.env` menggunakan MySQL ketika menjalankan Docker:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=technical_test
DB_USERNAME=root
DB_PASSWORD=root
```

## 4. Assumptions

Beberapa asumsi dan penyederhanaan yang dibuat:

- User registration tidak dibuat karena technical test hanya membutuhkan contoh user untuk login.
- User dibuat melalui database seeder.
- Role hanya terdiri dari `teacher` dan `admin`.
- Teacher hanya dapat submit ticket dan melihat overview ticket miliknya sendiri.
- Admin tidak membuat ticket, tetapi fokus untuk melihat semua ticket dan mengubah status ticket.
- Status ticket dibuat sederhana: `submitted`, `ongoing`, dan `done`.
- Dashboard digunakan sebagai halaman overview, sedangkan halaman Tickets digunakan untuk input ticket oleh teacher dan manajemen status oleh admin.
- UI dibuat sederhana dan responsif menggunakan Blade dan Tailwind CSS tanpa library chart tambahan.

## 5. Improvements

Jika diberikan waktu lebih, saya akan melakukan beberapa hal yang bisa ditingkatkan:

- Menambahkan audit log untuk setiap perubahan status ticket.
- Menambahkan fitur komentar atau notes ketika admin sedang memperoses tiket.
- Menambahkan notifikasi ketika status tiket berubah.
- Menambahkan chart yang lebih interaktif.
- Menambahkan pagination untuk table ticket agar lebih nyaman ketika data sudah banyak.  

