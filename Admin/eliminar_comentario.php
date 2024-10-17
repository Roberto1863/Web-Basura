<?php
// Conexión a la base de datos MySQL
$conn = new mysqli('localhost', 'root', '', 'comentarios');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $eliminar = "DELETE FROM comments WHERE id = $id";

    if (mysqli_query($conn, $eliminar)) {
        header('Location: Index.php');
    } else {
        echo "Error al eliminar el registro: " . mysqli_error($conn);
    }
} else {
    echo "ID no válido.";
}

mysqli_close($conn);

if (mysqli_query($conn, $eliminar)) {
    header('Location: Index.php');
} else {
    die(mysqli_error($conn)); // Mostrará el error específico si la eliminación falla
}

?>