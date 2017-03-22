<?php
    include_once 'lib.php';
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
       
    //Borra
    $valor=$_GET['escondido'];
    if(isset($_GET['escondido'])){
        $horaCreada = time();
        $sql = "UPDATE pedidos SET horareparto = ?  WHERE id = ?"; //funciona
        $res=$db->prepare($sql);
        $res->execute(array($horaCreada,$valor));//funciona
    }
    header('Location: VerAsignados.php');