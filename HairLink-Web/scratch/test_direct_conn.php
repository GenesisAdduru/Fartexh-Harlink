<?php
try {
    $pdo = new PDO(
        'pgsql:host=db.vitvtysmorwrvyzjqbyr.supabase.co;port=5432;dbname=postgres',
        'postgres',
        'xnvit2LKSkZhvdH2',
        [PDO::ATTR_TIMEOUT => 5]
    );
    echo "SUCCESS: Direct connection works!\n";
} catch (Exception $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}
