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
        // Parámetros de paginación - siempre 25 por página
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = 25; // Fijo en 25 productos por página
        $offset = ($page - 1) * $perPage;

        // Obtener total de productos
        $stmTotal = $pdo->query("SELECT COUNT(*) as total FROM productos");
        $totalData = $stmTotal->fetch();
        $total = $totalData['total'];
        $totalPages = ceil($total / $perPage);

        // Obtener productos paginados
        $stm = $pdo->prepare("SELECT * FROM productos ORDER BY id LIMIT :limit OFFSET :offset");
        $stm->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stm->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stm->execute();
        $productos = $stm->fetchAll();

        echo json_encode([
            "success" => true,
            "data" => $productos,
            "pagination" => [
                "total" => $total,
                "total_pages" => $totalPages
            ]
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === "stats") {
        // Consulta para obtener todas las estadísticas globales
        $stm = $pdo->query("SELECT * FROM productos");
        $todosProductos = $stm->fetchAll();

        // Calcular estadísticas globales
        $totalProductos = count($todosProductos);

        $stockBajo = array_filter($todosProductos, function ($producto) {
            return $producto['stock'] <= $producto['limite'];
        });

        $valorTotal = array_reduce($todosProductos, function ($acumulador, $producto) {
            return $acumulador + ($producto['stock'] * $producto['precio']);
        }, 0);

        echo json_encode([
            "success" => true,
            "stats" => [
                "total_productos" => $totalProductos,
                "stock_bajo" => count($stockBajo),
                "valor_total" => $valorTotal,
                "productos_stock_bajo" => array_values($stockBajo)
            ]
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action == "create") {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            echo json_encode(["success" => false, "error" => "JSON inválido"]);
            exit;
        }

        $stm = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria, img, limite,fecha_movimiento) VALUES(?, ?, ?, ?, ?, ?, ?,?)");

        $stm->execute([
            $input["nombre"],
            $input['descripcion'],
            $input['precio'],
            $input['stock'],
            $input['categoria'],
            $input['img'],
            $input['limite'],
            "S/F"
        ]);

        echo json_encode(["success" => true]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Acción no reconocida.']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
}
