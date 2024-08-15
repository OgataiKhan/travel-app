CREATE TABLE destinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    latitude DOUBLE,
    longitude DOUBLE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (day_id) REFERENCES days(id)
);