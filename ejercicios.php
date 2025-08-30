<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
//ejercicio3
// Mostrando mensajes en pantalla con echo
echo "Bienvenido al curso de PHP<br>";
echo "Este es un mensaje mostrado con comillas dobles.<br>";
echo 'También se puede usar comillas simples.<br>';
echo "Recuerda que cada instrucción termina con punto y coma.<br>";
echo "PHP es un lenguaje muy utilizado para desarrollo web.<br><br>";

//ejercicio 4
// Generar un número aleatorio entre 1 y 100
$num = rand(1, 100);

// Mostrar el número generado
echo "Número generado: " . $num . "<br>";

// Verificar si es menor o igual a 50 o mayor
if ($num <= 50) {
    echo "El número es menor o igual a 50<br><br>";
} else {
    echo "El número es mayor a 50<br><br>";
}

//ejercicio 5
// Definir variables de diferentes tipos
$entero = 25;            // integer
$decimal = 3.14;         // double (número con decimales)
$texto = "Hola PHP";     // string
$booleano = true;        // boolean

// Imprimir cada variable en una línea
echo "Valor entero: " . $entero . "<br>";
echo "Valor double: " . $decimal . "<br>";
echo "Valor string: " . $texto . "<br>";
echo "Valor booleano: " . ($booleano ? "true" : "false") . "<br><br>";

//ejercicio 6
// Definir tres variables enteras
$edad = 20;
$nota = 95;
$precio = 1500;

// Definir un string que use las variables
echo "La edad del estudiante es $edad, la nota obtenida es $nota y el precio del curso es $precio.<br><br>";

//ejercicio 7 estructura condicional
// Generar un número aleatorio entre 1 y 3
$valor = rand(1, 3);

// Mostrar el número generado
echo "Número generado: $valor <br>";

// Mostrar su equivalente en castellano
if ($valor == 1) {
    echo "uno<br>";
} elseif ($valor == 2) {
    echo "dos<br>";
} elseif ($valor == 3) {
    echo "tres<br>";
}
?>
</body>
</html>