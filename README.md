# tugasBesarPemrogramanBasisWeb
Repository Sistem Transaksional untuk PT Garda Integra Solusindo untuk menyelesaikan mata kuliah Pemrograman Berbasis Web.

PT Garda Integra Solusindo — Sistem Informasi Manajemen Berbasis Web (Laravel)

Aplikasi Sistem Informasi Manajemen berbasis web yang dikembangkan untuk PT Garda Integra Solusindo menggunakan Laravel 12 sebagai framework utama. Sistem ini bertujuan untuk membantu perusahaan dalam mengelola data master dan transaksi secara terintegrasi, sehingga proses administrasi menjadi lebih efektif, efisien, dan terstruktur.

Aplikasi dibangun menggunakan arsitektur Model-View-Controller (MVC) dengan memanfaatkan Eloquent ORM, Blade Template Engine, Middleware, Form Request Validation, Migration, Seeder, Resource Controller, Authentication, serta Role Based Access Control (RBAC) untuk membedakan hak akses antara Super Admin dan Staff.

Anggota Kelompok
Deni Nugraha	- 1324075
Kevin Chandra Syahrial	- 1324077
Septiandito Rizky Melonia	- 1324084
Fahmi Irfan	- 1324085

Akun Login

Sistem menggunakan autentikasi bawaan Laravel (Session-Based Authentication) dengan pembagian hak akses berdasarkan Role Based Access Control (RBAC).

Username	Password	Role
admin	admin123	Super Admin
staff	staff123	Staff

# Perbaikan Sistem

Selama proses pengembangan, dilakukan beberapa penyempurnaan terhadap sistem sebagai berikut.

1. Perbaikan Modul Vendor

Memperbaiki kesalahan pada halaman Vendor yang sebelumnya menampilkan error

2. Constraint Parent–Child

Relasi antar tabel diubah agar menjaga integritas data.

Customer yang masih digunakan pada Project tidak dapat dihapus.
Vendor yang masih digunakan pada Produk tidak dapat dihapus.
Pegawai yang masih digunakan pada Purchase Order tidak dapat dihapus.
Project yang masih digunakan pada Purchase Order tidak dapat dihapus.
Produk yang sudah digunakan pada Detail Purchase Order tidak dapat dihapus.

Sistem akan menolak proses penghapusan apabila data masih memiliki relasi dengan tabel lain.

3. Penggabungan Invoice

Modul Invoice diintegrasikan ke dalam Purchase Order sehingga seluruh proses transaksi dilakukan dalam satu modul.

4. Perubahan Data Produk

Beberapa perubahan dilakukan pada master Produk, yaitu:

Kolom Harga diganti menjadi Vendor.
Produk yang berasal dari vendor berbeda tetap disimpan sebagai item yang berbeda meskipun memiliki nama produk yang sama.
Produk hasil produksi internal menggunakan vendor PT Garda Integra Solusindo.
5. Auto Increment Primary Key

Seluruh form tambah data (Customer, Vendor, Pegawai, Project, Produk, dan Purchase Order) tidak lagi meminta pengguna mengisi ID.

Primary Key dibuat menggunakan Auto Increment, sehingga nomor identitas dibuat secara otomatis oleh sistem.

6. Role Staff

Hak akses Staff diperluas sehingga dapat melakukan:

Create
Read
Update

pada modul:

Customer
Vendor
Project
Produk
Purchase Order

Namun Staff tetap tidak memiliki hak Delete.

