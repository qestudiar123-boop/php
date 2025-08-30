<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Formulario de Login</h2>
    <form action="login.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Enviar</button>

        <?php
// Clase para manejar usuarios
class Usuario {
    private $usuario;
    private $password;

    // Constructor: se ejecuta al crear el objeto
    public function __construct($usuario, $password) {
        $this->usuario = $usuario;
        $this->password = $password;
    }

    // Método para mostrar los datos
    public function mostrarDatos() {
        echo "Usuario ingresado: " . $this->usuario . "<br>";
        echo "Contraseña ingresada: " . $this->password . "<br>";
    }
}
//segundo formulario
    <h2>Formulario de Login</h2>
      <form action="login.php" method="post">
        <label for="nombre">nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Enviar</button>

        <?php
// Clase para manejar usuarios
class Usuario {
    private $usuario;
    private $password;

    // Constructor: se ejecuta al crear el objeto
    public function __construct($usuario, $password) {
        $this->usuario = $usuario;
        $this->password = $password;
    }

    // Método para mostrar los datos
    public function mostrarDatos() {
        echo "Usuario ingresado: " . $this->usuario . "<br>";
        echo "Contraseña ingresada: " . $this->password . "<br>";
    }
}
?>

    </form>
</body>
</html>
