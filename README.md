📌 Taskify — Kanban Project Management Web App

Taskify adalah aplikasi manajemen tugas berbasis web dengan konsep kanban board, dirancang untuk memudahkan pengguna mengelola workflow secara visual.
Pengguna dapat membuat board, kolom, dan task, serta memindahkan task antar kolom menggunakan drag & drop yang responsif.

Dibangun menggunakan Laravel + Livewire 3, Taskify memberikan pengalaman interaktif tanpa perlu memuat ulang halaman.

🚀 Fitur Utama
✅ Manajemen Board

Membuat board baru

Menampilkan daftar board

Mengedit & menghapus board

✅ Manajemen Kolom

Menambah kolom (To Do, Doing, Done, dll.)

Pemesanan kolom

Edit & delete kolom

✅ Manajemen Task

Tambah, edit, hapus task

Mendukung deskripsi, prioritas, dan posisi

✅ Drag & Drop Interaktif

Memindahkan task antar kolom menggunakan SortableJS

Posisi task langsung tersimpan di database

✅ Livewire 3 SPA Experience

Event-driven

Modal dinamis

Re-render hanya bagian yang diperlukan

🎨 UI Modern

TailwindCSS + komponen custom

Dark mode full

Smooth animation

🛠️ Tech Stack
Layer	Teknologi
Backend	Laravel 10 / 11
Frontend	Blade + TailwindCSS
Interactivity	Livewire 3
Database	MySQL/MariaDB
Javascript	SortableJS
Package Manager	Composer & NPM
Server Dev	Laravel / Laragon
📥 Instalasi & Setup

Ikuti langkah berikut untuk menjalankan Taskify secara lokal.

1️⃣ Clone Repository
git clone https://github.com/AlfayadhAnvaris/Taskify.git
cd Taskify

2️⃣ Install Dependencies
Composer
composer install

NPM (opsional jika ingin build assets)
npm install
npm run dev

3️⃣ Copy File Environment
cp .env.example .env

4️⃣ Generate App Key
php artisan key:generate

5️⃣ Setup Database

Buat database baru (misalnya: taskify_db).

Kemudian sesuaikan .env:

DB_DATABASE=taskify_db
DB_USERNAME=root
DB_PASSWORD=

6️⃣ Migrasi Database
php artisan migrate


Jika ada seeder:

php artisan db:seed

7️⃣ Jalankan Server
php artisan serve


Aplikasi berjalan di:

🔗 http://127.0.0.1:8000

🧪 Fitur Drag & Drop (SortableJS)

Taskify menggunakan SortableJS yang dipasang lewat CDN, sehingga tidak perlu instalasi tambahan.
