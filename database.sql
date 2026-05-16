CREATE DATABASE IF NOT EXISTS event_ticketing_db;
USE event_ticketing_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    event_date DATE NOT NULL,
    location VARCHAR(150) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    quota INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_events_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(12,2) NOT NULL,
    payment_proof VARCHAR(255) NULL,
    payment_status ENUM('pending', 'uploaded', 'paid', 'rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_orders_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO users (name, email, password, role)
VALUES ('Admin', 'admin@event.local', '$2y$10$2wRz2S5hJvPwEWHfTO5rP.BRTYh5mXbr9zjbY3lUw2J0vJj2f9Y7m', 'admin')
ON DUPLICATE KEY UPDATE email = email;

INSERT INTO categories (name) VALUES ('Konser'), ('Seminar'), ('Workshop')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO events (category_id, title, description, event_date, location, price, quota)
SELECT c.id, 'Konser Akustik Malam Minggu', 'Event musik akustik intimate.', '2026-08-20', 'Jakarta', 150000, 250
FROM categories c WHERE c.name = 'Konser'
AND NOT EXISTS (SELECT 1 FROM events WHERE title = 'Konser Akustik Malam Minggu');
