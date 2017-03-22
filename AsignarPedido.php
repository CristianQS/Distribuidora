<?php
    include_once 'lib.php';
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
       
    //Borra
    $valor=$_GET['escondido'];
    if(isset($_GET['escondido'])){
        $horaCreada = time();
        $array = User::getLoggedUser();
        $us = $array['id'];
        echo $us;
        $sql = "UPDATE pedidos SET horaasignacion = ?, idrepartidor = ? WHERE id = ?"; //funciona
        $res=$db->prepare($sql);
        $res->execute(array($horaCreada,$us,$valor));//funciona
    }
    header('Location: PagRepartidor.php');
