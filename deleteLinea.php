<?php
session_start();
include_once 'lib.php';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
       
//Borra
if($valor = $_GET['linea']){
    $sql = "SELECT * FROM lineaspedido WHERE id=?"; 
    $res=$db->prepare($sql);
    $res->execute(array($valor));
    $res->setFetchMode(PDO::FETCH_NAMED);
    $lineaPedido = $res->fetchAll();
    
    $sql = "DELETE FROM lineaspedido WHERE id=?"; 
    $res=$db->prepare($sql);
    $res->execute(array($valor));
    #Actualizar stock
    $arrayB=Bebida::detallesBebida($lineaPedido[0]['idbebida']);
    $stock = $arrayB[0]['stock'];
    
    $aux = $stock+ $lineaPedido[0]['unidades'];
    $sql1 = "UPDATE bebidas SET stock= ? WHERE marca=?";
    $res1=$db-> prepare($sql1);
    $res1->execute(array($aux,$arrayB[0]['marca']));
}
$res1=$db->prepare("SELECT * FROM lineaspedido WHERE idpedido=?");
$res1->execute(array($_SESSION['idpedido']));
$res1->setFetchMode(PDO::FETCH_NAMED);
$array = $res1->fetchAll();
if ( count($array) == 0 ){
    $sql = "DELETE FROM pedidos WHERE id=?"; //funciona
    $res=$db->prepare($sql);//funciona
    $res->execute(array($_SESSION['idpedido']));//funciona
    unset($_SESSION['idpedido']);
    unset($_SESSION['pedidoEnCreacion']);
    unset($_SESSION['dirección']);
    unset($_SESSION['población']);
    $_SESSION['error']="Se ha eliminado el pedido";
}
header('Location: nuevoPedido.php');

