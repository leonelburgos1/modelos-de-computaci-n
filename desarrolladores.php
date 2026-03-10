<?php
require_once 'config/connectdb.php';

$desarrolladores = $pdo->query("SELECT * FROM desarrolladores")->fetchAll();
?>

<div class="container">
    <div class="card-custom">

        <h2 class="text-center titulo mb-4">Registro de Desarrolladores</h2>
        <div class="row mb-3">
            <div class="col-md-2">
                <input 
                    type="text" 
                    id="buscarInput" 
                    class="form-control form-control-sm" 
                    placeholder="Buscar desarrollador..."
                >
            </div>
        </div>
        <!-- FORMULARIO -->
        <form id="formDesarrollador" onsubmit="guardarDesarrollador(event)" class="row mb-4">

        <div class="col-md-4">
        <input type="text" id="nombre" class="form-control" placeholder="Nombre del desarrollador" required>
        </div>

        <div class="col-md-3">
        <input type="text" id="pais" class="form-control" placeholder="País" required>
        </div>

        <div class="col-md-3">
        <input type="number" id="anio" class="form-control" placeholder="Año fundación" required>
        </div>

        <div class="col-md-2">
        <button type="submit" id="btnGuardar" class="btn btn-azul text-white w-100">
        +
        </button>
        </div>

        </form>


        <!-- TABLA -->
        <table class="table table-bordered table-hover text-center">

            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>País</th>
                    <th>Año Fundación</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody id="tableBodyDesarrolladores">

            <?php foreach ($desarrolladores as $d): ?>

            <tr>
                <td><?= $d['nombre'] ?></td>
                <td><?= $d['pais'] ?></td>
                <td><?= $d['anio_fundacion'] ?></td>

                <td class="acciones">

                    <button class="btn btn-warning btn-sm">Editar</button>

                    <button class="btn btn-danger btn-sm">Eliminar</button>

                </td>
            </tr>

            <?php endforeach; ?>

            </tbody>

        </table>
        

    </div>
</div>
<script src="assets/js/desarrolladores.js"></script>