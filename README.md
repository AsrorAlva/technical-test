# School Ticketing System

## 1. Project Overview

Aplikasi sistem manajemen tiket/permintaan internal sederhana yang dirancang khusus untuk lingkungan sekolah. Sistem ini memisahkan peran antara Guru (untuk mengirim dan melacak permintaan) dan Admin (untuk mengelola dan memperbarui status permintaan).

Default akun yang tersedia setelah seeding:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@test.com` | `password` |
| Teacher | `teacher@test.com` | `password` |
| Teacher | `teacher2@test.com` | `password` |

## 2. Tech Stack

**Laravel 12**, saya memilih tech stack ini karena laravel sudah menyediakan fitur yang dibutuhkan untuk sebuah project ini, seperti routing, controller, validation, auth, migration, seeder untuk hardcode users, dan integrasi database.


## 3. Setup Interaction

Clone project:

```bash
git clone https://github.com/AsrorAlva/technical-test.git
```

pindah file:

```bash
cd technical-test
```

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

Pastikan konfigurasi database di `.env` menggunakan MySQL ketika menjalankan Docker (optional check):

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

- User dibuat melalui database seeder.
- Role terdiri dari `teacher` dan `admin`.
- Role Teacher hanya bisa melakukan submit tiket dan melihat tiket milik sendiri.
- Admin tidak bisa membuat tiket, admin hanya bisa melihat semua pengajuan tiket dan mengubah status tiket (`submitted`, `ongoing`, dan `done`).
- Menu Dashboard digunakan untuk melihat data keseleruhan, dan menu tickets digunakan untuk pengajuan dari role teacher dan manajemen status dari admin.


## 5. Improvements

Jika saya diberikan waktu, saya akan melakukan beberapa hal yang bisa ditingkatkan:

- Manage user agar ketika admin ingin menambahkan user baru, admin tidak perlu menambahkan lewat seeder.
- Menambahkan AI feature agar mempermudah teacher mengisi deskripsi tiket.
- Menambahkan notifikasi email ketika status ticket teacher berubah.
- Menambahkan pagination untuk table ticket agar lebih nyaman ketika data sudah banyak.  
