<?php
session_start();
include_once "lib.php";
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
#
try{
    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
    $datos = json_decode($datoscrudos);
    
    $arrayB=Bebida::detallesBebida($datos->Marca);
    $stock = $arrayB[0]['stock'];
    if($datos->cantidad > $stock){
        $_SESSION['error']="No disponemos de existencia disponibles";
        header('Location: nuevoPedido.php');
    }else{

        $sql2 = "INSERT INTO lineaspedido (idpedido, idbebida,unidades, PVP)"
                    ." VALUES (?,?, ?, ?)";
        $res=$db-> prepare($sql2);
        $res->execute(array($_SESSION['idpedido'],$arrayB[0]['id'],$datos->cantidad, $arrayB[0]['PVP']));
    
        $aux = $stock-$datos->cantidad;
    
        $sql1 = "UPDATE bebidas SET stock= ? WHERE id=?";
        $res1=$db-> prepare($sql1);
        $res1->execute(array($aux,$datos->Marca ));
    }
} catch (Exception $ex) {
    $res->message="Se ha producido una excepción en el servidor: ".$e->getMessage(); 
    $res->deleted = false;
}


header('Location: nuevoPedido.php');
