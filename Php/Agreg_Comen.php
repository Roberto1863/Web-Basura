<?php
header("Access-Control-Allow-Origin: https://roberto1863.github.io/Web-Basura/");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'comentarios');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibieron los datos necesarios
if (isset($_POST['productId']) && isset($_POST['text'])) {
    $productId = $_POST['productId'];
    $commentText = $_POST['text'];

    // Establecer un valor predeterminado para el autor y la fecha
    $author = "Anónimo";
    $date = date("2099-12-12");

    // Preparar la consulta SQL para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO comments (product_id, author, date, text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $productId, $author, $date, $commentText);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Datos no recibidos correctamente"]);
}

$conn->close();
?>
