<?php
date_default_timezone_set('America/Bogota');

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

function conectarBD() {
    $host = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "usuario_php";
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        // Mejorar la salida de error en la página
        die("<h6 style='color:red;'>Error al conectar a la base de datos: " . $conn->connect_error . "</h6>");
    } 
    return $conn;
}

$conn = conectarBD();

// LÍNEA 24: CORREGIDA la columna 'id_log' a 'id'
$sql = "SELECT id, sesion_id, nombre_usuario, fecha_hora_inicio, fecha_hora_cierre 
        FROM log_sistema 
        ORDER BY fecha_hora_inicio DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Logs de Sesiones del Sistema</title>
    <link rel="stylesheet" href="estilo_nuevo.css">
</head>
<body>

<div class="form-container">
    <h2 class="form-title">Auditoría de Sesiones de Usuarios</h2>
    
    <div style="text-align: right; margin: 10px 5%;">
        Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?> | 
        <a href="conexionBD_leer_registrar_eliminar_editar_css_sesion.php">Gestionar Usuarios</a> |
        <a href="login.php?logout">Cerrar sesión</a>
    </div>

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top:30px; width:100%;">
        <thead>
            <tr>
                <th>ID Log</th>
                <th>ID de Sesión</th>
                <th>Usuario</th>
                <th>Inicio de Sesión</th>
                <th>Cierre de Sesión</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['sesion_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_hora_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_hora_cierre'] ?? '>> Sesión Activa <<'); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center;">No hay registros de auditoría.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php
$conn->close();
?>