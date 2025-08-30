<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formularios</title>
</head>
<body>
    <h2>Formulario de Login</h2>
    <form method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="btnLogin">Enviar</button>
    </form>

    <hr>

    <h2>Formulario de Registro de Persona</h2>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="fecha">Fecha de Nacimiento:</label>
        <input type="date" id="fecha" name="fecha" required><br><br>

        <label>Sexo:</label>
        <input type="radio" name="sexo" value="F"> F
        <input type="radio" name="sexo" value="M"> M
        <input type="radio" name="sexo" value="O"> O
        <br><br>

        <button type="submit" name="btnRegistro">Enviar</button>
    </form>

    <hr>

    <?php
    // ----- CLASES -----
    class Usuario {
        private $usuario;
        private $password;

        public function __construct($usuario, $password) {
            $this->usuario = $usuario;
            $this->password = $password;
        }

        public function mostrarDatos() {
            echo "<h3>Datos de Login</h3>";
            echo "Usuario: " . $this->usuario . "<br>";
            echo "Contraseña: " . $this->password . "<br>";
        }
    }

    class Persona {
        private $nombre;
        private $apellido;
        private $fecha;
        private $sexo;

        public function __construct($nombre, $apellido, $fecha, $sexo) {
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->fecha = $fecha;
            $this->sexo = $sexo;
        }

        public function mostrarDatos() {
            echo "<h3>Datos de Registro</h3>";
            echo "Nombre: " . $this->nombre . "<br>";
            echo "Apellido: " . $this->apellido . "<br>";
            echo "Fecha de Nacimiento: " . $this->fecha . "<br>";
            echo "Sexo: " . $this->sexo . "<br>";
        }
    }


    ?>
</body>
</html>

    <title>Document</title>
</head>
<body>
    
</body>
</html>