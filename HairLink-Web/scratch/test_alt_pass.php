<?php
$hosts = ['3.111.225.200'];
foreach ($hosts as $host) {
    try {
        $pdo = new PDO(
            "pgsql:host={$host};port=6543;dbname=postgres",
            "postgres.vitvtysmorwrvyzjqbyr",
            "password123",
            [PDO::ATTR_TIMEOUT => 3]
        );
        echo "SUCCESS with password123 on {$host}!\n";
        exit;
    } catch (Exception $e) {
        echo "FAILED on {$host} with password123: " . $e->getMessage() . "\n";
    }
}
