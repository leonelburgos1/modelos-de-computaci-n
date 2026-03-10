<!DOCTYPE html>
<html>

<head>
    <title>Registro de Juegos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="container">
        <div class="card-custom">

            <h2 class="text-center titulo mb-4">Registro de Juegos</h2>
            <div class="row mb-3">
                <div class="col-md-2">
                    <input type="text" id="buscarInput" class="form-control form-control-sm"
                        placeholder="Buscar juego...">
                </div>
            </div>
            <!-- Formulario -->
            <form id="formJuego" onsubmit="agregarJuego(event)" class="row mb-4">
                <div class="col-md-3">
                    <input type="text" id="nombre" class="form-control" placeholder="Nombre del juego" required>
                </div>
                <div class="col-md-2">
                    <input type="text" id="tamaño" class="form-control" placeholder="Tamaño" required>
                </div>
                <div class="col-md-3">
                    <input type="text" id="categoria" class="form-control" placeholder="Categoría" required>
                </div>
                <div class="col-md-3">
                    <select id="desarrollador" class="form-control" required>
                        <option value="">Seleccione desarrollador</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" id="btnGuardar" class="btn btn-azul text-white w-100">
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
                <tbody id="tableBody">
                    <!-- Aquí JS cargará los datos -->
                </tbody>
            </table>

        </div>
    </div>

    <script src="assets/js/juegos.js"></script>

</body>

</html>