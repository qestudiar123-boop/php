<?php
// ================= CONEXIÓN ===================
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "productos_php";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$upload_dir_rel = "imagenes_productos/";                    
$upload_dir_abs = __DIR__ . DIRECTORY_SEPARATOR . $upload_dir_rel;

if (!is_dir($upload_dir_abs)) {
    die("Error: La carpeta de imágenes no existe en: " . $upload_dir_abs);
}

// ================= CRUD ===================
if (isset($_POST['crear'])) {
    $nombre      = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio      = $_POST['precio'] ?? 0;
    $cantidad    = $_POST['cantidad'] ?? 0;

    $imagen_rel = null;
    if (!empty($_FILES['imagen']['name'])) {
        $basename = time() . "_" . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES["imagen"]["name"]));
        $archivo_abs = $upload_dir_abs . $basename;
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivo_abs)) {
            $imagen_rel = $upload_dir_rel . $basename;
        }
    }

    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, imagen, precio, cantidad, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("sssdi", $nombre, $descripcion, $imagen_rel, $precio, $cantidad);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);

    $res = $conn->prepare("SELECT imagen FROM productos WHERE id=?");
    $res->bind_param("i", $id);
    $res->execute();
    $res->bind_result($img_to_delete);
    if ($res->fetch()) {
        if ($img_to_delete && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $img_to_delete)) {
            @unlink(__DIR__ . DIRECTORY_SEPARATOR . $img_to_delete);
        }
    }
    $res->close();

    $stmt = $conn->prepare("DELETE FROM productos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$result = $conn->query("SELECT * FROM productos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>CRUD Productos - ADSO30</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root{
            --lila:#a855f7;
            --lila-oscuro:#7e22ce;
            --lila-claro:#f3e8ff;
            --bg:#f9f9fb;
            --card:#fff;
            --muted:#555;
            --radius:12px;
        }

        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family: "Segoe UI", Tahoma, sans-serif;
            background:var(--bg);
            color:#222;
            display:flex;
            height:100vh;
        }

        header{
            position:fixed;
            top:0; left:0;
            width:100%;
            height:60px;
            background:var(--lila);
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:20px;
            font-weight:600;
            box-shadow:0 2px 6px rgba(0,0,0,0.15);
            z-index:100;
        }

        .sidebar{
            width:280px;
            background:#fff;
            padding:80px 20px 20px;
            border-right:1px solid #eee;
            overflow-y:auto;
        }

        .content{
            flex:1;
            padding:80px 30px 30px;
            overflow:auto;
        }

        h3{margin-bottom:14px;color:var(--lila);}

        label{display:block;margin:10px 0 6px;font-size:13px;color:var(--muted)}
        input, textarea{
            width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;font-size:14px;margin-bottom:10px;
        }
        textarea{min-height:70px; resize:vertical;}

        .btn{
            background:var(--lila);color:#fff;
            padding:10px 14px;border:none;border-radius:8px;
            cursor:pointer;font-weight:600;
            text-decoration:none;display:inline-block;text-align:center;
            transition:0.2s;
        }
        .btn:hover{background:var(--lila-oscuro)}
        .btn.delete{background:var(--lila-oscuro);}
        .btn.delete:hover{background:var(--lila);}

        table{
            width:100%;border-collapse:collapse;background:#fff;
            border-radius:var(--radius);overflow:hidden;
            box-shadow:0 2px 6px rgba(0,0,0,0.05);
        }
        th, td{padding:12px;font-size:14px;text-align:center;border-bottom:1px solid #f3f3f3}
        thead th{background:var(--lila-claro);color:#333;font-weight:600}
        tbody tr:hover{background:#faf5ff}

        img.thumb{width:64px;height:64px;object-fit:cover;border-radius:8px}
    </style>
</head>
<body>
    <header>
        Gestión de Productos de maquillaje
    </header>

    <aside class="sidebar">
        <h3>Agregar Producto de maquillaje</h3>
        <form method="POST" enctype="multipart/form-data">
            <label>Nombre</label>
            <input type="text" name="nombre" required>
            <label>Descripción</label>
            <textarea name="descripcion" required></textarea>
            <label>Imagen</label>
            <input type="file" name="imagen" accept="image/*" required>
            <label>Precio</label>
            <input type="number" step="0.01" name="precio" required>
            <label>Cantidad</label>
            <input type="number" name="cantidad" required>
            <button class="btn" type="submit" name="crear" style="width:100%;margin-top:10px">Guardar</button>
        </form>
    </aside>

    <main class="content">
        <h3>Lista de Productos de maquillaje</h3>
        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td>
                            <?php if (!empty($row['imagen'])): ?>
                                <img class="thumb" src="<?= htmlspecialchars($row['imagen']) ?>" alt="Producto">
                            <?php else: ?>
                                <span style="color:#999">sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['descripcion']) ?></td>
                        <td><?= htmlspecialchars($row['precio']) ?></td>
                        <td><?= htmlspecialchars($row['cantidad']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_creacion']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_actualizacion']) ?></td>
                        <td>
                            <a class="btn" href="editar.php?id=<?php echo intval($row['id']); ?>">Editar</a>
                            <a class="btn delete" href="?eliminar=<?= intval($row['id']) ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color:#777">No hay productos aún.</p>
        <?php endif; ?>
    </main>
</body>
</html>



