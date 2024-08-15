<?php
// Include the database connection
include 'db.php';

try {
    // Migration file names
    $migrations = [
        '001_create_trips_table.sql',
        '002_create_days_table.sql',
        '003_create_destinations_table.sql',
        '004_create_ratings_table.sql',
        '005_create_destination_ratings_table.sql'
    ];

    // Execute migrations
    foreach ($migrations as $migration) {
        $sql = file_get_contents(__DIR__ . "/../../database/migrations/$migration");
        $pdo->exec($sql);
        echo "Executed $migration successfully.\n";
    }

    echo "All migrations executed successfully.\n";

} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
    exit(1);
}
