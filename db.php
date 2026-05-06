<?php
try {
    
    $db = new PDO("mysql:host=192.168.1.21;dbname=door_dev;charset=utf8mb4", 'root', 'Superce11ular!'); // MAKE SURE TO USE PROD IN PRODUCTION.
    //echo "Database connection established.";
    //echo  __DIR__ . '/dev.db';
    //$db->exec("PRAGMA foreign_keys = ON;");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
