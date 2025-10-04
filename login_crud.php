<?php 
date_default_timezone_set('America/Bogota');

// =================== INICIAR SESIÓN ===================
session_start();

// =================== GENERAR Y PROTEGER TOKEN CSRF ===================
// Genera un token de seguridad para proteger los formularios (CSRF Token)
if (empty($_SESSION['csrf_token'])) {
    // Genera un token aleatorio de 32 bytes (64 caracteres hex)
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

/**
 * Conexión a la base de datos
 */
function conectarBD()
{
    $host = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "usuario_php";
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

// =================== PROCESAR LOGIN ===================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // 1. VERIFICAR EL TOKEN CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // El token no coincide. Esto es un posible ataque CSRF.
        die("Error de seguridad: Token CSRF inválido.");
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Por favor ingrese usuario y contraseña";
    } else {
        $conn = conectarBD();

        // Validar usuario
        $sql = "SELECT id, username, password FROM login_user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if ($password === $user['password']) {
                // Guardar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['loggedin'] = true;

                // =================== INSERTAR EN LOG ===================
                $session_id = session_id(); 
                $nombre_usuario = $user['username'];
                $fecha_inicio = date('Y-m-d H:i:s'); 

                $sql_log = "INSERT INTO log_sistema (sesion_id, nombre_usuario, fecha_hora_inicio) 
                            VALUES (?, ?, ?)";
                $stmt_log = $conn->prepare($sql_log);
                $stmt_log->bind_param("sss", $session_id, $nombre_usuario, $fecha_inicio);
                $stmt_log->execute();

                // Guardamos el id_log insertado
                $_SESSION['log_id'] = $stmt_log->insert_id;

                $stmt_log->close();
                // =======================================================

                // Redirigir al panel principal
                header("Location: conexionBD_leer_registrar_eliminar_editar_css_sesion.php");
                exit;
            } else {
                $error = "Contraseña incorrecta";
            }
        } else {
            $error = "Usuario no encontrado";
        }
        $stmt->close();
        $conn->close();
    }
}

// =================== CERRAR SESIÓN ===================
if (isset($_GET['logout'])) {
    if (isset($_SESSION['log_id'])) {
        $conn = conectarBD(); 
        $fecha_cierre = date('Y-m-d H:i:s');
        $log_id = $_SESSION['log_id'];

        // CORRECCIÓN: Usamos 'id' en lugar de 'id_log'
        $sql_update_log = "UPDATE log_sistema SET fecha_hora_cierre = ? WHERE id = ?";
        $stmt_update_log = $conn->prepare($sql_update_log);
        $stmt_update_log->bind_param("si", $fecha_cierre, $log_id);
        $stmt_update_log->execute();
        $stmt_update_log->close();
        $conn->close();
    }

    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="estilo_login.css">
</head>
<body>
    <h2>Iniciar Sesión</h2>

    <?php if (isset($error)): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="login.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="login" value="Iniciar Sesión">
    </form>
</body>
</html>