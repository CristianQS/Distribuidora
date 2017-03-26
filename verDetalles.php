<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="estilos.css">
        <script src="scripts.js"></script>
    </head>
    <body>
        <header id="cabezera">
            <h1>Distribuidoras Refresh</h1>
            <img src="imagenes/truck.png" alt="camión"/>
        </header>
        <nav id="navegador">
            <ul>
                <li><a href = 'PaginaCliente.php'>Ver Productos</a></li>
                <li><a href = 'nuevoPedido.php' > Nuevo pedido</a></li>
                <li><a href = 'listaPedidos.php'>Lista de Pedidos</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <h2>Detalles del Pedido</h2>
<?php
session_start();
include_once 'lib.php';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$res=$db->prepare("SELECT bebidas.marca,lineaspedido.unidades,lineaspedido.PVP FROM lineaspedido INNER JOIN bebidas
ON lineaspedido.idbebida=bebidas.id WHERE idpedido=? ;");
$res->execute(array($_GET['detalles'])); 

if($res){
    $res->setFetchMode(PDO::FETCH_NAMED);         
    $first=true;         
    foreach($res as $game){    
        if($first){         
            echo "<table><tr>";        
           
            foreach($game as $field=>$value){          
                echo "<th>$field</th>";  
            }
            $first = false;
            echo "</tr>";               
        }
        echo "<tr>";
        foreach($game as $value){
            echo "<td>$value</td>";
        }
        echo "</tr>";
   }
   echo '</table>';
}
