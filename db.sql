CREATE DATABASE IF NOT EXISTS second_hand_cars;

USE second_hand_cars;

CREATE TABLE IF NOT EXISTS categories (
                                          id INT AUTO_INCREMENT PRIMARY KEY,
                                          name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS cars (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    category_id INT,
                                    model VARCHAR(100) NOT NULL,
                                    engine_power INT NOT NULL,
                                    fuel VARCHAR(50) NOT NULL,
                                    price DECIMAL(10, 2) NOT NULL,
                                    color VARCHAR(50) NOT NULL,
                                    age INT NOT NULL,
                                    history TEXT,
                                    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

INSERT INTO categories (name) VALUES ('Sedan'), ('SUV'), ('Hatchback'), ('Electric');

INSERT INTO cars (category_id, model, engine_power, fuel, price, color, age, history) VALUES
                                                                                          (1, 'BMW Seria 3', 184, 'Diesel', 12500.00, 'Negru', 8, 'Fără accidente în istoric. Revizii efectuate doar în reprezentanță.'),
                                                                                          (2, 'Audi Q5', 190, 'Diesel', 21000.00, 'Gri', 5, 'Unic proprietar în România. Stare estetică și mecanică impecabilă.');