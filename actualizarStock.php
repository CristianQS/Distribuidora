<?php
include_once 'lib.php';

$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');

$sql = "UPDATE bebidas SET stock=? WHERE marca = ?"; 
$res=$db-> prepare($sql);
$res->execute(array($_POST[$nameMarca]));  
View::showTable("usuarios");
header('Location: PagAdmin.php' );

