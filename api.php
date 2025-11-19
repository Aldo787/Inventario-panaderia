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

try{
    if ($action === "list" ){
        $stm = $pdo -> query("SELECT * FROM productos ORDER BY id DESC LIMIT 15");
        $productos = $stm -> fetchAll();
        echo json_encode(["success" => true , "data" => $productos], JSON_UNESCAPED_UNICODE);
        exit;
    }
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Acción no reconocida.']);

}catch(Exception $e){
     http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
}
