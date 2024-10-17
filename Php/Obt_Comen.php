<?php
header("Access-Control-Allow-Origin: https://roberto1863.github.io/Web-Basura/");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
// Conexión a la base de datos MySQL
$conn = new mysqli('localhost', 'root', '', 'comentarios');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el productId de la petición
if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
} else {
    // Manejo de errores si no se pasa el productId
    echo 'Error: productId no se ha recibido';
    exit();
}

// Consulta SQL para obtener comentarios del producto
$sql = "SELECT * FROM comments WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

$comments = array();
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

// Devolver los comentarios en formato JSON
echo json_encode($comments);

$stmt->close();
$conn->close();
?>
