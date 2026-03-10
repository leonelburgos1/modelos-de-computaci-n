<?php
header("Content-Type: application/json");
include "../config/connectdb.php";

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

try {

    switch ($method) {

        // LISTAR
case 'GET':

    if (isset($_GET['buscar'])) {

        $buscar = "%" . $_GET['buscar'] . "%";

        $stmt = $pdo->prepare("
            SELECT * FROM desarrolladores
            WHERE nombre LIKE :buscar
            ORDER BY id_desarrollador DESC
        ");

        $stmt->execute([':buscar' => $buscar]);

        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    } elseif (isset($_GET['id'])) {

        $stmt = $pdo->prepare("
            SELECT * FROM desarrolladores
            WHERE id_desarrollador = :id
        ");

        $stmt->execute([':id' => $_GET['id']]);

        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));

    } else {

        $stmt = $pdo->query("
            SELECT * FROM desarrolladores
            ORDER BY id_desarrollador DESC
        ");

        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

break;


        // INSERTAR
        case "POST":

            $stmt = $pdo->prepare("
            INSERT INTO desarrolladores (nombre,pais,anio_fundacion)
            VALUES (:nombre,:pais,:anio)
            ");

            $stmt->execute([
                ":nombre" => $data["nombre"],
                ":pais" => $data["pais"],
                ":anio" => $data["anio"]
            ]);

            echo json_encode(["message" => "Desarrollador agregado"]);

            break;


        // ACTUALIZAR
        case "PUT":

            $stmt = $pdo->prepare("
            UPDATE desarrolladores
            SET nombre=:nombre,
            pais=:pais,
            anio_fundacion=:anio
            WHERE id_desarrollador=:id
            ");

            $stmt->execute([
                ":id" => $data["id"],
                ":nombre" => $data["nombre"],
                ":pais" => $data["pais"],
                ":anio" => $data["anio"]
            ]);

            echo json_encode(["message" => "Actualizado"]);

            break;


        // ELIMINAR
        case "DELETE":

            $stmt = $pdo->prepare("
            DELETE FROM desarrolladores
            WHERE id_desarrollador=:id
            ");

            $stmt->execute([
                ":id" => $data["id"]
            ]);

            echo json_encode(["message" => "Eliminado"]);

            break;

    }

} catch (Exception $e) {

    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);

}