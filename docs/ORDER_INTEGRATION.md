# Integrasi Order & Migrasi SQL

Panduan singkat untuk menjalankan migrasi tabel pemesanan dan sample data di Supabase (Postgres).

1) Jalankan SQL migrasi untuk membuat tabel:

 - Buka Supabase -> SQL Editor -> jalankan file `sql/create_orders_tables.sql`.

2) Tambahkan sample data (opsional):

 - Jalankan `sql/sample_data.sql` di SQL Editor untuk membuat user demo dan beberapa produk.

3) Pastikan environment variables terpasang:

 - SUPABASE_URL
 - SUPABASE_KEY (anon/public key)

4) Endpoint yang sudah tersedia di project ini:

 - `add_to_cart.php` — menambah item ke `carts` (mendukung AJAX XHR)
 - `cart.php` — lihat isi keranjang
 - `update_cart.php` — ubah qty (XHR)
 - `remove_from_cart.php` — hapus item (XHR)
 - `checkout.php` — buat `orders` + `order_items`, hapus cart
 - `order_success.php` — konfirmasi pesanan
 - `orders.php` — daftar pesanan user
 - `order_detail.php` — detail pesanan user
 - `admin_orders.php` — daftar pesanan (Admin) + ubah status
 - `admin_order_detail.php` — detail pesanan (Admin)

5) Kredensial demo untuk login admin (di sampel SQL):

 - Email: `admin@rfxvisual.dan`
 - Password: `admin123com`

6) Testing cepat lokal:

 - Pastikan `SUPABASE_URL` dan `SUPABASE_KEY` terisi di environment (atau `.env`).
 - Buka `store.php`, tambahkan beberapa produk ke keranjang.
 - Lanjutkan ke `cart.php` -> `Checkout` untuk membuat order.
 - Lihat di `orders.php` (user) dan `admin_orders.php` (admin).

Catatan: Password di sample disimpan sebagai plain-text untuk demo. Di production gunakan `password_hash()` dan autentikasi yang aman.
