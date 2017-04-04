<?php
session_start();
include_once "lib.php";
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
if($_GET['Población'] !=NULL && $_GET['Dirección']!=NULL && !isset($_SESSION['error']) ){
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
}
header('Location: nuevoPedido.php');
