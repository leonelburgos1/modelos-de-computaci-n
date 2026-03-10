<?php
$hostDB = '127.0.0.1';
$nameDB = 'udenar2_db';   
$userDB = 'usuario_juegos';
$pwDB = '12345';

try {
    $pdo = new PDO("mysql:host=$hostDB;dbname=$nameDB;charset=utf8", $userDB, $pwDB);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
