<?php
session_start();
include_once "lib.php";
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
#
if($_GET['Población'] !=NULL && $_GET['Dirección']!=NULL ){
    $consulta=Pedido::existePedido($_GET['Población'], $_GET['Dirección']);
    if($consulta == false){
        $array = User::getLoggedUser();
        $us = $array['id'];   
        $horaCreada = 0;

        $sql = "INSERT INTO pedidos (idcliente, horacreacion,poblacionentrega, direccionentrega)"
                ." VALUES (?,?, ?, ?)";
        $res=$db-> prepare($sql);
        $res->execute(array($us,$horaCreada,$_GET['Población'], $_GET['Dirección']));  
    }   
    $array=Bebida::detallesBebida($_GET['Marca']);
    $arrayP=  Pedido::detallesPed($_GET['Población'], $_GET['Dirección']);
    $_SESSION['idpedido'] = $arrayP[0]['id'];
    
    $sql = "INSERT INTO lineaspedido (idpedido, idbebida,unidades, PVP)"
                    ." VALUES (?,?, ?, ?)";
    $res=$db-> prepare($sql);
    $res->execute(array($_SESSION['idpedido'],$array[0]['id'],$_GET['cantidad'], $array[0]['PVP']));
    
}
header('Location: nuevoPedido.php');