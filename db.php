<?php
$host = "localhost";
$db = "inventario";
$user = "root";
$pass = "";
$charset = "utf8mb4";
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try{
  $pdo = new PDO(dsn:$dsn, username:$user, password:$pass, options:$options);
}catch(\PDOException $e){
  http_response_code(response_code:500);
  echo json_encode(value:["succes" => false, "message" => "conexion fallida". $e -> getMessage()]);
  exit;
}
?>