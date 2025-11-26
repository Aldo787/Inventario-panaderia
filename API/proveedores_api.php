<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once "db.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

try {
    if ($action === "list") {
        // Parámetros de búsqueda
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Obtener proveedores
        $sql = "SELECT * FROM provedores";
        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE (nombre LIKE ? OR contacto LIKE ? OR email LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }

        $sql .= " ORDER BY nombre";

        $stm = $pdo->prepare($sql);
        $stm->execute($params);
        $proveedores = $stm->fetchAll();

        echo json_encode([
            "success" => true,
            "data" => $proveedores
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === "create") {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            echo json_encode(["success" => false, "error" => "JSON inválido"]);
            exit;
        }

        $stm = $pdo->prepare("INSERT INTO provedores (nombre, contacto, telefono, email, direccion, estado) VALUES(?, ?, ?, ?, ?, ?)");

        $stm->execute([
            $input["nombre"],
            $input['contacto'],
            $input['telefono'],
            $input['email'],
            $input['direccion'],
            $input['estado']
        ]);

        echo json_encode(["success" => true]);
        exit;
    }

    if ($action === "update") {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || !isset($input['id'])) {
            echo json_encode(["success" => false, "error" => "Datos inválidos"]);
            exit;
        }

        $stm = $pdo->prepare("UPDATE provedores SET nombre = ?, contacto = ?, telefono = ?, email = ?, direccion = ?, estado = ? WHERE id = ?");

        $stm->execute([
            $input["nombre"],
            $input['contacto'],
            $input['telefono'],
            $input['email'],
            $input['direccion'],
            $input['estado'],
            $input['id']
        ]);

        echo json_encode(["success" => true]);
        exit;
    }
    if ($action === "delete") {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || !isset($input['id'])) {
            echo json_encode(["success" => false, "message" => "ID inválido"]);
            exit;
        }

        $stm = $pdo->prepare("DELETE FROM provedores WHERE id = ?");
        $stm->execute([$input['id']]);

        echo json_encode(["success" => true]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Acción no reconocida.']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
}
