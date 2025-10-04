<!--
Desarrollado: Ashly camila ararat.
Programa De Formacion: Desarrllo Con PHP.
Evidencia: Taller Uso De Arreglos.
Programa PHP:Gestion Del Usuario Nos Muestra La Parte Mas Importante De La Logica Y La Sintaxis Aplicada Para El Programa.
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evidencia 2-Uso De Arreglos</title>
    <style>
        table{border-collapse: collapse; width: 80%; margin: 20px auto;}
        th,td {border: 1px solid #cb7acb; padding: 8px; text-algin: center:}
        th{background-color: #eaa1c9ff;}
    </style> 
</head>
<body>
    <h2 style="text-align:center;">listado de personas</h2>
    <?php
    $personas = array(
        array("nombre"=>"Ashly camila ararat","direccion"=>"cra.24 # 45 - 36 norte","telefono"=>"3456789","cumpleaños"=>"06/10/2004","color"=>"Lila"),
        array("nombre"=>"Jennifer lasso","direccion"=>"cll.15 # 12 - 19 sur","telefono"=>"3561245","cumpleaños"=>"09/07/1090","color"=>"Negro"),
        array("nombre"=>"Karol lopez","direccion"=>"Av.34 # 16 - 12","telefono"=>"213547925","cumpleaños"=>"05/08/2000","color"=>"Verde"),
        array("nombre"=>"danna medina","direccion"=>"cra.26 # 45 - 26","telefono"=>"31696659494","cumpleaños"=>"07/12/2003","color"=>"Blnco"),
    );
    $colores = array(
        "Lila" => "Riqueza y Alegria",
        "Azul" => "Tranquilidad y Armonia",
        "Blanco" => "Pureza y Inocencia",
        "Negro" => "Elegancia y Misterio",
        "Verde" => "no se encontro significado",
    );
    echo "<table>";
    echo "<tr>
    <th>Nombre</th>
    <th>Direccion</th>
    <th>Telefono</th>
    <th>Fecha Cumpleaños</th>
    <th>Color Favortio</th>
    <th>significado</th>    
    </tr>";

    foreach ($personas as $a) {
        echo "<tr>";
        echo "<td>",$a['nombre']."</td>";
        echo "<td>",$a['direccion']."</td>";
        echo "<td>",$a['telefono']."</td>";
        echo "<td>",$a['cumpleaños']."</td>";
        echo "<td>",$a['color']."</td>";

        if (array_key_exists($a['color'],$colores)){
            echo "<td>".$colores[$a['color']]."</td>";

        }else{
            echo "<td>no se encuentra el significado</td>";
        }
        echo "<tr>";
    }
    echo "</table>";
    ?>
</body>
</html>