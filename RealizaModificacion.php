<?php

include_once 'lib.php';

$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');

$sql = "UPDATE usuarios SET tipo=?, nombre=?, poblacion=?,direccion=? WHERE usuario = ?"; 
$res=$db-> prepare($sql);
$res->execute(array($_GET['tipo'],$_GET['nombreCom'],$_GET['pobla'],$_GET['dir'],$_GET['nombreUser']));  
View::showTable("usuarios");
header('Location: PagAdmin.php' );
