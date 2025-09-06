-- SQLite version of the database
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(150),
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) DEFAULT 'buyer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_deleted INTEGER DEFAULT 0
);

CREATE TABLE artworks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'available',
    starting_price DECIMAL(10,2) NOT NULL,
    current_bid DECIMAL(10,2),
    auction_start_time DATETIME NOT NULL,
    auction_end_time DATETIME NOT NULL,
    buyer_id INTEGER,
    final_sale_price DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (artist_id) REFERENCES users(id),
    FOREIGN KEY (buyer_id) REFERENCES users(id)
);

CREATE TABLE bids (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    artwork_id INTEGER NOT NULL,
    bidder_id INTEGER NOT NULL,
    bid_amount DECIMAL(10,2) NOT NULL,
    bid_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (artwork_id) REFERENCES artworks(id) ON DELETE CASCADE,
    FOREIGN KEY (bidder_id) REFERENCES users(id)
);

-- Insert test users (passwords are hashed for 'password123')
INSERT INTO users (name, email, password, role) VALUES 
('Test Artist', 'artist@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'artist'),
('Test Buyer', 'buyer@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer'),
('John Smith', 'john@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer');

-- Insert test artworks
INSERT INTO artworks (artist_id, title, description, image_url, status, starting_price, current_bid, auction_start_time, auction_end_time, buyer_id, final_sale_price, updated_at) VALUES 
(1, 'Sunset Painting', 'Beautiful sunset over mountains', 'uploads/sunset.jpg', 'sold', 500.00, 750.00, '2024-01-01 10:00:00', '2024-01-08 10:00:00', 2, 750.00, '2024-01-08 11:00:00'),
(1, 'Abstract Art', 'Modern abstract composition', 'uploads/abstract.jpg', 'sold', 300.00, NULL, '2024-01-15 10:00:00', '2024-01-22 10:00:00', 2, 300.00, '2024-01-16 09:00:00'),
(1, 'City Lights', 'Night cityscape with lights', 'uploads/city.jpg', 'sold', 400.00, 600.00, '2024-02-01 10:00:00', '2024-02-08 10:00:00', 3, 600.00, '2024-02-08 11:30:00');

-- Insert test bids for auction wins
INSERT INTO bids (artwork_id, bidder_id, bid_amount, bid_time) VALUES 
(1, 2, 500.00, '2024-01-01 12:00:00'),
(1, 3, 600.00, '2024-01-02 14:00:00'),
(1, 2, 750.00, '2024-01-03 16:00:00'),
(3, 2, 400.00, '2024-02-01 11:00:00'),
(3, 3, 500.00, '2024-02-02 12:00:00'),
(3, 2, 550.00, '2024-02-03 13:00:00'),
(3, 3, 600.00, '2024-02-04 14:00:00');