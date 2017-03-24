<?php
session_start();
include_once 'lib.php';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
       
//Borra
if($valor = $_GET['linea']){
    $sql = "DELETE FROM lineaspedido WHERE id=?"; //funciona
    $res=$db->prepare($sql);//funciona
    $res->execute(array($valor));//funciona
}
$res1=$db->prepare("SELECT * FROM lineaspedido WHERE idpedido=?");
$res1->execute(array($_SESSION['idpedido']));
$res1->setFetchMode(PDO::FETCH_NAMED);
$array = $res1->fetchAll();
if ( count($array) == 0 ){
    $sql = "DELETE FROM pedidos WHERE id=?"; //funciona
    $res=$db->prepare($sql);//funciona
    $res->execute(array($_SESSION['idpedido']));//funciona
}
header('Location: nuevoPedido.php');

