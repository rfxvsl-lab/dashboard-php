-- Sample data untuk Supabase (sesuaikan schema jika diperlukan)

-- Insert admin user (sesuaikan id jika sudah ada)
INSERT INTO users (id, email, password, role, nama_user)
VALUES (1, 'admin@rfxvisual.dan', 'admin123com', 'Admin', 'Demo Admin');

-- Contoh produk
INSERT INTO products (id, nama_produk, harga, stok, status)
VALUES
  (1, 'Pembuatan Website Basic', 1500000, 10, 'Tersedia'),
  (2, 'Desain Logo Profesional', 500000, 20, 'Tersedia'),
  (3, 'Paket SEO Starter', 1000000, 5, 'Tersedia');

-- (Opsional) tambah beberapa cart/demo order
-- INSERT INTO carts (user_id, product_id, quantity) VALUES (1,1,1);
