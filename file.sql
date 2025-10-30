CREATE DATABASE spaflow;
USE spaflow;

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category ENUM('facial', 'massage', 'body-treatment', 'hair-spa', 'nail-care') DEFAULT 'massage',
    duration INT NOT NULL, -- dalam menit
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Data dummy
INSERT INTO services (name, description, category, duration, price) VALUES
('Aromatherapy Massage', 'Pijat relaksasi dengan minyak esensial murni', 'massage', 60, 450000),
('Hydrating Facial', 'Perawatan wajah untuk kulit kering & glowing', 'facial', 75, 550000),
('Balinese Scrub', 'Lulur tradisional Bali + pijat ringan', 'body-treatment', 90, 650000),
('Keratin Hair Spa', 'Perawatan rambut rusak & kusut', 'hair-spa', 80, 700000),
('Spa Manicure', 'Perawatan kuku lengkap + kutek OPI', 'nail-care', 45, 250000);