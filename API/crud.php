<?php
header("Content-Type: application/json");
require_once '../connectdb.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents("php://input"), true);

    switch ($method) {

        case 'GET':
            if (isset($_GET['id'])) {
                $stmt = $pdo->prepare("SELECT * FROM juegos WHERE id = :id");
                $stmt->execute([':id' => $_GET['id']]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT * FROM juegos ORDER BY id DESC");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
        break;

        case 'POST':

            $stmt = $pdo->prepare("
                INSERT INTO juegos (nombre, tamaño, categoria, creador)
                VALUES (:nombre, :tamano_param, :categoria, :creador)
            ");

            $stmt->execute([
                ':nombre' => $data['nombre'],
                ':tamano_param' => $data['tamaño'], // aquí recibimos del JSON
                ':categoria' => $data['categoria'],
                ':creador' => $data['creador']
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
                creador = :creador
                WHERE id = :id
            ");

            $stmt->execute([
                ':id' => $data['id'],
                ':nombre' => $data['nombre'],
                ':tamano_param' => $data['tamaño'], // 👈 aquí usamos el JSON
                ':categoria' => $data['categoria'],
                ':creador' => $data['creador']
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