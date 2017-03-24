<?php
session_start();
include_once 'lib.php';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
echo $_SESSION['idpedido'] ;
$consulta=Pedido::estadoPedido($_SESSION['idpedido'] )  ; 
if($consulta =="En proceso" ){  
    $sql = "SELECT * FROM lineaspedido WHERE idpedido = ?";
    $ca =$db-> prepare($sql);
    $ca->execute(array($_SESSION['idpedido']));
    $ca->setFetchMode(PDO::FETCH_NAMED);
    $res=$ca->fetchAll();
    $total=0;
    for($i=0;$i<count($res);$i++){
       $total+=$res[$i]['unidades']*$res[$i]['PVP'];
    }
    echo $total;
    $horaCreada = time();
    $sql1 = "UPDATE pedidos SET horacreacion= ?,PVP=? WHERE id=?";
    $res1=$db-> prepare($sql1);
    $res1->execute(array($horaCreada,$total,$_SESSION['idpedido'] ));
}



    #$pvp = $c[0]['PVP'];
    #$stock = $c[0]['stock'];
    #$unidades = $_GET['cantidad'];
    #if($unidades > $stock) $unidades = $stock;
   # $pvc = $unidades * $pvp;
    #$sql = "INSERT INTO pedidos (idcliente, horacreacion,poblacionentrega, direccionentrega, PVP)"
   #                ." VALUES (?,?, ?, ?, ?)";
    #$res=$db-> prepare($sql);
    #$res->execute(array($us,$horaCreada,$_GET['Población'], $_GET['Dirección'], $pvc));
#header('Location: PaginaCliente.php');