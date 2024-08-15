CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    value INT NOT NULL CHECK (value >= 1 AND value <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO ratings (value) VALUES (1), (2), (3), (4), (5);