<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>

<?php
function conectarBD() {
    $host = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "usuario_php";

    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);

    if ($conn->connect_error) {
        die("Error al conectar a la base de datos: " . $conn->connect_error);
    } else {
        echo "Conexión exitosa a la base de datos.";
    }

    return $conn;
}

function consultarBD() {
    $conn = conectarBD();
    $sql = "SELECT id, username, password, created_at, updated_at FROM login_user";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    return $result;
}

$result = consultarBD();
?>

<!-- Tabla donde se presentan los resultados -->
<table border="1" cellpadding="5" cellspacing="0" style="margin-top:30px; width:100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Contraseña</th>
            <th>Creado</th>
            <th>Actualizado</th>
        </tr>
    </thead>
    <tbody>

    <!-- Verifica que la variable $result tenga un valor válido -->
    <!-- y que la consulta devolvió al menos una fila -->
    <?php if ($result && $result->num_rows > 0): ?>
        <!-- Recorre todos los registros obtenidos -->
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td></td> <!-- Nunca mostrar contraseñas reales -->
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" style="text-align:center;">No hay usuarios registrados</td>
        </tr>
    <?php endif; ?>

    </tbody>
</table>

</body>
</html>
