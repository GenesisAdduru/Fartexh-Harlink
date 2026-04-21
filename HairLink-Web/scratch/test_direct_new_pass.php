<?php
try {
    $pdo = new PDO(
        'pgsql:host=db.vitvtysmorwrvyzjqbyr.supabase.co;port=5432;dbname=postgres',
        'postgres',
        'fartexhhairlink',
        [PDO::ATTR_TIMEOUT => 5]
    );
    echo "SUCCESS: Direct connection works with fartexhhairlink!\n";
} catch (Exception $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}
