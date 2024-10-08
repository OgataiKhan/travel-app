CREATE TABLE day_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (day_id) REFERENCES days(id) ON DELETE CASCADE
);