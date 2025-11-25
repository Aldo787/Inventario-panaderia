<?php
require 'db.php';

// Obtener el ID del producto
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        // Eliminar el producto
        $statement = $pdo->prepare('DELETE FROM productos WHERE id = :id');
        $resultado = $statement->execute(array(':id' => $id));
        
        if ($resultado) {
            // Redirigir de vuelta al inventario con mensaje de éxito
            header('Location: index.php');
        } else {
            header('Location: index.php');
        }
        
    } catch (PDOException $e) {
        header('Location: index.php');
    }
} else {
    echo "<script>console.log('$id');</script>";
    header("Location: index.php");
}
exit;
?>