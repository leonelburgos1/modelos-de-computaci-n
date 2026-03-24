<?php
$hostDB = 'db';
$nameDB = 'udenar';   
$userDB = 'usuario';
$pwDB = 'clave123';

try {
    $pdo = new PDO("mysql:host=$hostDB;dbname=$nameDB;charset=utf8", $userDB, $pwDB);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
