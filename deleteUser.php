<?php
    include_once 'lib.php';
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
       
    //Borra
    if($valor = $_GET['escondido']){
        $sql = "DELETE FROM usuarios WHERE usuario=?"; //funciona
        $res=$db->prepare($sql);//funciona
        $res->execute(array($valor));//funciona
    }
    header('Location: PagAdmin.php');