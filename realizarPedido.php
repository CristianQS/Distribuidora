<?php
include_once 'lib.php';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
        
if(isset($_GET['Marca']) ){
    $array = User::getLoggedUser();
    $us = $array['id'];
    echo "$us<br>";
    $horaCreada = time();
        
    $sql = "SELECT * FROM bebidas WHERE marca = ?";
    $ca =$db-> prepare($sql);
    $ca->execute(array($_GET['Marca']));
    $ca->setFetchMode(PDO::FETCH_NAMED);
    $c=$ca->fetchAll();
        
    $pvp = $c[0]['PVP'];
    $stock = $c[0]['stock'];
    $unidades = $_GET['cantidad'];
    if($unidades > $stock) $unidades = $stock;
    $pvc = $unidades * $pvp;
    $sql = "INSERT INTO pedidos (idcliente, horacreacion,poblacionentrega, direccionentrega, PVP)"
                    ." VALUES (?,?, ?, ?, ?)";
    $res=$db-> prepare($sql);
    $res->execute(array($us,$horaCreada,$_GET['Población'], $_GET['Dirección'], $pvc));
    header('Location: PaginaCliente.php');
}
