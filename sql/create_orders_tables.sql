-- SQL migration untuk membuat tabel pemesanan di Postgres (Supabase)
-- Jalankan di Supabase SQL editor atau psql

CREATE TABLE IF NOT EXISTS carts (
    id serial PRIMARY KEY,
    user_id integer NOT NULL,
    product_id integer NOT NULL,
    quantity integer NOT NULL DEFAULT 1,
    created_at timestamptz DEFAULT now()
);

CREATE TABLE IF NOT EXISTS orders (
    id serial PRIMARY KEY,
    user_id integer NOT NULL,
    total numeric(12,2) NOT NULL DEFAULT 0,
    status text NOT NULL DEFAULT 'pending',
    shipping_address text,
    created_at timestamptz DEFAULT now()
);

CREATE TABLE IF NOT EXISTS order_items (
    id serial PRIMARY KEY,
    order_id integer NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    product_id integer NOT NULL,
    quantity integer NOT NULL DEFAULT 1,
    price numeric(12,2) NOT NULL DEFAULT 0
);

-- Indexes untuk performa
CREATE INDEX IF NOT EXISTS idx_carts_user ON carts(user_id);
CREATE INDEX IF NOT EXISTS idx_orders_user ON orders(user_id);
CREATE INDEX IF NOT EXISTS idx_order_items_order ON order_items(order_id);
