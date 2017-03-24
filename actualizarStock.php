<?php
include_once 'lib.php';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$stock = $_POST['cantidad'];
$marca = $_POST['nameMarca'];
$sql = "UPDATE bebidas SET stock=? WHERE marca = ?"; 
$res=$db-> prepare($sql);
for ($i=0;$i<count($stock);$i++){
    $res->execute(array($stock[$i],$marca[$i]));  
    
}
header('Location: gestionStock.php' );

