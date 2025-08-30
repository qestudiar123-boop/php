<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
class persona {

    private $nombre;
    public function inicializar($nom) //metodo constructor
    {
        $this->nombre=>$nom;
    }
    public function imprimir()
    {
        echo $this->nombre; //que acceda al contenido de la variable
        echo '<br'; espacio
    }
}

$per1=new persona(); // incocar la clase y replica de la clase

$per1->inicializar('<h1>juan</h1>'); //instacion de la clase
$per1 ->imprimir();//inyectar carac teristicas a html

$per2=new persona();

$per2->inicializar('<h1>ana</h1>');
$per2->imprimir();

?>
</body>
</html>