# Karakteristik Role User di Aplikasi Management Hotel Dieng

Dokumen ini menjelaskan karakteristik masing-masing role user yang ada di aplikasi Laravel-based untuk management hotel. Sistem menggunakan paket `spatie/laravel-permission` untuk manajemen role dan permission, dengan 4 role utama yang didefinisikan secara eksplisit.

## Overview Sistem Role

- **Framework Permission**: Menggunakan Spatie Permission dengan cache 24 jam untuk performa optimal.
- **Role Utama**: Developer, Admin, Partner, Collab.
- **Keamanan**: Middleware role-based di route memastikan akses terkontrol.
- **Kustomisasi**: Collab memiliki layer permission tambahan via tabel `collab_permission` untuk kontrol granular per produk.

## 1. Developer

### Karakteristik Utama
Role tertinggi dengan akses paling luas, kemungkinan untuk pengembang sistem atau super-admin.

### Akses dan Fungsi
- Dapat mengakses semua route yang dilindungi middleware `role:admin|developer|partner|collab` di `routes/web.php`
- Termasuk akses ke:
  - Dashboard
  - Produk (Product)
  - Admin management
  - Partner management
  - Collab management
  - Reservasi (Reservation)
  - Kalender (Calendar)
- Tidak ada batasan khusus; dapat melakukan semua operasi CRUD pada resource utama

### Implementasi Kode
- Didefinisikan sebagai konstanta `DEVELOPER` di `app/Models/User.php`
- Method pengecekan: `isDeveloper()`
- Dibuat via `database/seeders/RoleSeeder.php`

### Konteks Bisnis
Digunakan oleh tim pengembang untuk maintenance sistem atau akses penuh selama development/testing.

## 2. Admin

### Karakteristik Utama
Role administrator sistem dengan akses luas ke panel admin.

### Akses dan Fungsi
- Akses eksklusif ke `/admin/dashboard` via `routes/admin.php` dengan middleware `role:admin`
- Dapat mengakses semua resource di `routes/web.php` seperti developer
- Tidak ada filter data khusus; dapat melihat semua data di sistem
- Kemampuan mengelola user lain (admin, partner, collab)

### Implementasi Kode
- Didefinisikan sebagai konstanta `ADMIN` di `app/Models/User.php`
- Method pengecekan: `isAdmin()`
- Dibuat via `database/seeders/RoleSeeder.php`

### Konteks Bisnis
Digunakan oleh administrator hotel atau manajer sistem untuk mengelola operasi harian.

## 3. Partner

### Karakteristik Utama
Role untuk pemilik atau mitra bisnis (kemungkinan pemilik hotel atau vendor).

### Akses dan Fungsi
- Akses ke semua resource di `routes/web.php` (produk, reservasi, kalender, dll.)
- Data difilter berdasarkan ownership menggunakan fungsi `filterByOwner()` di `app/Helpers/Users.php`
- Hanya dapat melihat/mengelola data yang dimiliki oleh mereka sendiri (berdasarkan email sebagai `produk_owner`)

### Implementasi Kode
- Didefinisikan sebagai konstanta `PARTNER` di `app/Models/User.php`
- Method pengecekan: `isPartner()`
- Dibuat via `database/seeders/RoleSeeder.php`
- Filter logic: `filterByOwner()` memeriksa `$owner->isPartner()` dan filter berdasarkan email

### Konteks Bisnis
Cocok untuk pemilik hotel yang ingin mengelola properti mereka sendiri tanpa akses ke data partner lain.

## 4. Collab (Kolaborator)

### Karakteristik Utama
Role untuk kolaborator atau staf dengan akses terbatas berdasarkan permission spesifik per produk.

### Akses dan Fungsi
- Akses ke semua resource di `routes/web.php`, tetapi dengan batasan ketat
- Permission granular melalui tabel `collab_permission` (model `app/Models/CollabPermission.php`)
- Tabel menghubungkan `user_id` dengan `product_id` yang diizinkan
- Fungsi helper:
  - `getPermissionProducts()`: Mendapatkan array product_id yang diizinkan
  - `filterCollabPermission()`: Filter data berdasarkan permission collab
- Hanya dapat mengakses produk tertentu yang diberikan permission oleh admin atau partner

### Implementasi Kode
- Didefinisikan sebagai konstanta `COLLAB` di `app/Models/User.php`
- Method pengecekan: `isCollab()`
- Dibuat via `database/seeders/RoleSeeder.php`
- Model tambahan: `CollabPermission` untuk permission per produk

### Konteks Bisnis
Digunakan untuk staf hotel, resepsionis, atau kolaborator eksternal yang hanya perlu akses ke produk/hotel tertentu (misalnya, staf di cabang A tidak bisa akses data cabang B).

## Hierarki Akses

```
Developer ≈ Admin > Partner > Collab (dengan filter)
```

- **Developer/Admin**: Akses penuh tanpa batas
- **Partner**: Akses penuh dengan filter ownership
- **Collab**: Akses terbatas berdasarkan permission per produk

## File Terkait

- `app/Models/User.php`: Definisi model dan method role checking
- `app/Helpers/Users.php`: Helper functions untuk filtering berdasarkan role
- `config/permission.php`: Konfigurasi Spatie Permission
- `routes/web.php`: Route dengan middleware role
- `routes/admin.php`: Route admin khusus
- `database/seeders/RoleSeeder.php`: Seeder untuk membuat role
- `app/Models/CollabPermission.php`: Model untuk permission collab per produk

## Catatan Teknis

- Tidak ada wildcard permission diaktifkan (`enable_wildcard_permission: false`)
- Cache permission diaktifkan dengan expiration 24 jam
- Events untuk role/permission tidak diaktifkan (`events_enabled: false`)
- Teams feature tidak digunakan (`teams: false`)