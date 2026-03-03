<?php
require_once 'connectdb.php';

$juegos = $pdo->query("SELECT * FROM juegos")->fetchAll();

// GUARDAR JUEGO
if (isset($_POST['guardar'])) {
    $sql = "INSERT INTO juegos (nombre, tamaño, categoria, creador)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nombre'],
        $_POST['tamano'],
        $_POST['categoria'],
        $_POST['creador']
    ]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Juegos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
</head>

<body class="d-flex align-items-center justify-content-center">

<div class="container">
    <div class="card-custom">

        <h2 class="text-center titulo mb-4">Registro de Juegos</h2>

        <!-- Formulario -->
        <form method="POST" class="row mb-4">
            <div class="col-md-3">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre del juego" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="tamano" class="form-control" placeholder="Tamaño" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="categoria" class="form-control" placeholder="Categoría" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="creador" class="form-control" placeholder="Creador" required>
            </div>
            <div class="col-md-1">
                <button type="submit" name="guardar" class="btn btn-azul text-white w-100">
                    +
                </button>
            </div>
        </form>

        <!-- Tabla -->
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tamaño</th>
                    <th>Categoría</th>
                    <th>Creador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($juegos as $j): ?>
                <tr>
                    <td><?= $j['nombre'] ?></td>
                    <td><?= $j['tamaño'] ?></td>
                    <td><?= $j['categoria'] ?></td>
                    <td><?= $j['creador'] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" disabled>✏️</button>
                        <button class="btn btn-danger btn-sm" disabled>🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
