<?php
session_start();
include_once "lib.php";
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
#
$arrayB=Bebida::detallesBebida($_GET['Marca']);
$stock = $arrayB[0]['stock'];
if($_GET['cantidad'] > $stock){
    $_SESSION['error']="No disponemos de existencia disponibles";
    header('Location: nuevoPedido.php');
}

if($_GET['Población'] !=NULL && $_GET['Dirección']!=NULL && $_GET['cantidad']!=NULL && !isset($_SESSION['error']) ){
    if(!isset($_SESSION['pedidoEnCreacion'])){
        $_SESSION['pedidoEnCreacion'] = 1;
        $array = User::getLoggedUser();
        $us = $array['id'];   
        $horaCreada = 0;

        $sql = "INSERT INTO pedidos (idcliente, horacreacion,poblacionentrega, direccionentrega)"
                ." VALUES (?,?, ?, ?)";
        $res=$db-> prepare($sql);
        $res->execute(array($us,$horaCreada,$_GET['Población'], $_GET['Dirección'])); 
   
        
        $sql1 = "SELECT * FROM pedidos WHERE idcliente=? and horacreacion=? ";
        $ca =$db-> prepare($sql1);
        $ca->execute(array($us,$horaCreada));
        $ca->setFetchMode(PDO::FETCH_NAMED);
        $res1=$ca->fetchAll();
        $_SESSION['idpedido']=$res1[0]['id'];
        $_SESSION['direccion']=$_GET['Dirección'];
        $_SESSION['poblacion']=$_GET['Población'];       
    }

    $sql2 = "INSERT INTO lineaspedido (idpedido, idbebida,unidades, PVP)"
                    ." VALUES (?,?, ?, ?)";
    $res=$db-> prepare($sql2);
    $res->execute(array($_SESSION['idpedido'],$arrayB[0]['id'],$_GET['cantidad'], $arrayB[0]['PVP']));
    
    $aux = $stock-$_GET['cantidad'];
    
    $sql1 = "UPDATE bebidas SET stock= ? WHERE id=?";
    $res1=$db-> prepare($sql1);
    $res1->execute(array($aux,$_GET['Marca'] ));
}
header('Location: nuevoPedido.php');
