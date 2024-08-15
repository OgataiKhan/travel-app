CREATE TABLE destination_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    destination_id INT NOT NULL,
    rating_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE CASCADE,
    FOREIGN KEY (rating_id) REFERENCES ratings(id) ON DELETE CASCADE
);
