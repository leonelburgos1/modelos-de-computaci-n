<?php
header("Content-Type: application/json");
require_once '../config/connectdb.php';

try {

    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents("php://input"), true);

    switch ($method) {

        case 'GET':

            if (isset($_GET['buscar'])) {

                $buscar = "%" . $_GET['buscar'] . "%";

                $stmt = $pdo->prepare("
                    SELECT 
                    j.id,
                    j.nombre,
                    j.tamaño,
                    j.categoria,
                    j.id_desarrollador,
                    d.nombre AS desarrollador
                    FROM juegos j
                    LEFT JOIN desarrolladores d
                    ON j.id_desarrollador = d.id_desarrollador
                    WHERE j.nombre LIKE :buscar
                    ORDER BY j.id DESC
                ");

                $stmt->execute([':buscar' => $buscar]);

                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

            } elseif (isset($_GET['id'])) {

                $stmt = $pdo->prepare("
                    SELECT 
                    j.*,
                    d.nombre AS desarrollador
                    FROM juegos j
                    LEFT JOIN desarrolladores d
                    ON j.id_desarrollador = d.id_desarrollador
                    WHERE j.id = :id
                ");

                $stmt->execute([':id' => $_GET['id']]);

                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));

            } else {

                $stmt = $pdo->query("
                    SELECT 
                    j.id,
                    j.nombre,
                    j.tamaño,
                    j.categoria,
                    j.id_desarrollador,
                    d.nombre AS desarrollador
                    FROM juegos j
                    LEFT JOIN desarrolladores d
                    ON j.id_desarrollador = d.id_desarrollador
                    ORDER BY j.id DESC
                ");

                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }

        break;

        case 'POST':

            $stmt = $pdo->prepare("
                INSERT INTO juegos (nombre, tamaño, categoria, id_desarrollador)
                VALUES (:nombre, :tamano_param, :categoria, :desarrollador)
            ");

            $stmt->execute([
                ':nombre' => $data['nombre'],
                ':tamano_param' => $data['tamaño'],
                ':categoria' => $data['categoria'],
                ':desarrollador' => $data['id_desarrollador']
            ]);

            http_response_code(201);
            echo json_encode(["message" => "Juego agregado correctamente"]);

        break;

        case 'PUT':

            $stmt = $pdo->prepare("
                UPDATE juegos SET
                nombre = :nombre,
                tamaño = :tamano_param,
                categoria = :categoria,
                id_desarrollador = :desarrollador
                WHERE id = :id
            ");

            $stmt->execute([
                ':id' => $data['id'],
                ':nombre' => $data['nombre'],
                ':tamano_param' => $data['tamaño'],
                ':categoria' => $data['categoria'],
                ':desarrollador' => $data['id_desarrollador']
            ]);

            echo json_encode(["message" => "Juego actualizado"]);

        break;

        case 'DELETE':

            $stmt = $pdo->prepare("DELETE FROM juegos WHERE id = :id");
            $stmt->execute([':id' => $data['id']]);

            echo json_encode(["message" => "Juego eliminado"]);

        break;

        default:

            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);

        break;
    }

} catch (Exception $e) {

    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);

}