CREATE TABLE days (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_id INT NOT NULL,
    date DATE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (trip_id) REFERENCES trips(id)
);