<?php
session_start();
include_once "lib.php";
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
#
$array=Bebida::detallesBebida($_GET['Marca']);
$stock = $array[0]['stock'];
if($_GET['cantidad'] > $stock){
    $_SESSION['error']="No disponemos de existencia disponibles";
    header('Location: nuevoPedido.php');
}

if($_GET['Población'] !=NULL && $_GET['Dirección']!=NULL && $_GET['cantidad']!=NULL ){
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
        
        
    //$consulta=Pedido::existePedido($_GET['Población'], $_GET['Dirección']);
    //if($consulta == false){
        
    //}   
  
    
    $sql = "INSERT INTO lineaspedido (idpedido, idbebida,unidades, PVP)"
                    ." VALUES (?,?, ?, ?)";
    $res=$db-> prepare($sql);
    $res->execute(array($_SESSION['idpedido'],$array[0]['id'],$_GET['cantidad'], $array[0]['PVP']));
    
    $aux = $stock-$_GET['cantidad'];
    
    $sql1 = "UPDATE bebidas SET stock= ? WHERE marca=?";
    $res1=$db-> prepare($sql1);
    $res1->execute(array($aux,$_GET['Marca'] ));
    
}
header('Location: nuevoPedido.php');