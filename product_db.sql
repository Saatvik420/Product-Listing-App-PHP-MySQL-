CREATE DATABASE product_db;

USE product_db;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(255) NOT NULL,
    sale_status ENUM('on_sale', 'not_on_sale') NOT NULL,
    stock INT NOT NULL,
    platform VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

INSERT INTO products (name, price, category, sale_status, stock, platform, image_url) VALUES
('FIFA Soccer', 39.99, 'Sports', 'not_on_sale', 0, 'PS Vita', 'fifa.jpg'),
('The Wolf Among Us', 59.99, 'Adventure', 'not_on_sale', 0, 'PS Vita', 'wolf_among_us.jpg'),
('Farming Simulator 16', 29.99, 'Simulation', 'not_on_sale', 0, 'PS Vita', 'farming_simulator.jpg'),
('Cat Quest & Cat Quest II Pawsome Pack', 29.99, 'RPG', 'on_sale', 10, 'PS4', 'cat_quest.jpg'),
('Air Conflicts Double Pack', 49.99, 'Action', 'on_sale', 5, 'PS4', 'air_conflicts.jpg'),
('Coffee Talk 2 in 1 Double Pack', 39.99, 'Visual Novel', 'not_on_sale', 0, 'PS4', 'coffee_talk.jpg');
