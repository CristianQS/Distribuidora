<?php
    session_start();
    include_once 'lib.php';
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    
    $sql = "SELECT * FROM lineaspedido WHERE idpedido=?"; 
    $res=$db->prepare($sql);
    $res->execute(array($_SESSION['idpedido']));
    $res->setFetchMode(PDO::FETCH_NAMED);
    
    $lineaPedido = $res->fetchAll();
    echo count($lineaPedido);
    for ($i=0;$i<count($lineaPedido);$i++){
        $arrayB=Bebida::detallesBebida($lineaPedido[$i]['idbebida']);
        $stock = $arrayB[0]['stock'];
        $aux = $stock+ $lineaPedido[$i]['unidades'];
        $sql1 = "UPDATE bebidas SET stock= ? WHERE marca=?";
        $res1=$db-> prepare($sql1);
        $res1->execute(array($aux,$arrayB[0]['marca']));
    }
    
    $sql = "DELETE FROM pedidos WHERE id=?"; 
    $res=$db->prepare($sql);
    $res->execute(array($_SESSION['idpedido']));
    unset($_SESSION['idpedido']);
    unset($_SESSION['pedidoEnCreacion']);
    unset($_SESSION['dirección']);
    unset($_SESSION['población']);
    $_SESSION['error']="Se ha eliminado el pedido";
    header('Location: nuevoPedido.php');