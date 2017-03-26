<?php
    session_start();
    include_once 'lib.php';
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    
    $sql = "DELETE FROM pedidos WHERE id=?"; 
    $res=$db->prepare($sql);
    $res->execute(array($_SESSION['idpedido']));
    unset($_SESSION['idpedido']);
    unset($_SESSION['pedidoEnCreacion']);
    unset($_SESSION['dirección']);
    unset($_SESSION['población']);
    $_SESSION['error']="Se ha eliminado el pedido";
    header('Location: nuevoPedido.php');