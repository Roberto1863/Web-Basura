<?php
// Conexión a la base de datos MySQL
$conn = new mysqli('localhost', 'root', '', 'comentarios');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener comentarios
$sql = "SELECT * FROM comments";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$comments = array();
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Fashion House</title>
    <link rel="stylesheet" href="../css/jquery.mobile-1.3.0.min.css">
    <link rel="stylesheet" href="../css/SinEstilo.css">
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.mobile-1.3.0.js"></script>
    <script src="../js/jquery.mobile-1.3.0.min.js"></script>
</head>
<body>
<div data-role="page" id="admin">
        <div data-role="header">
            <h1>The Fashion House</h1>
            <h1><img src="../images/Logo.png" alt="images" height="120" width="120"></h1>
        </div>
        <h2 class="product-name">Modo Administrador</h2>
        <div data-role="content">
                    <div data-role="collapsible-set" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">
                        <div data-role="collapsible" data-collapsed="false">
                            <h2 class="product-name">Gestión de Comentarios</h2>
                            <?php
                            echo '<table>';
                            echo '<thead>';
                            echo '<th>Usuario</th><th>Fecha</th><th>Comentario</th>';
                            echo '</thead><tbody>';
                            foreach ($comments as $fila) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($fila['author']) . '</td>';
                                echo '<td>' . htmlspecialchars($fila['date']) . '</td>';
                                echo '<td>' . htmlspecialchars($fila['text']) . '</td>';
                                echo '<td><a href="eliminar_comentario.php?id=' . urlencode($fila['id']) . '" data-role="button" data-icon="delete" data-inline="true" data-iconpos="notext" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este comentario?\');"></a></td>';
                                echo '</tr>';
                            }
                            echo '</tbody></table>';
                            ?>
                        </div>
                    </div>
                </div>
</div>
</body>
</html>