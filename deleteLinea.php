<?php
session_start();
$resK = new stdClass();
$resK->deleted=false; //Formato objeto con propiedad deleted (por defecto a false)
$resK->message=''; //Mensaje en caso de error
$resK->id=''; //Mensaje en caso de error

include_once 'lib.php';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
       
//Borra

try{
    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
    $datos = json_decode($datoscrudos);
    
    $sql = "SELECT * FROM lineaspedido WHERE id=?"; 
    $res=$db->prepare($sql);
    $res->execute(array($datos->id));
    $res->setFetchMode(PDO::FETCH_NAMED);
    $lineaPedido = $res->fetchAll();
    
    $sql = "DELETE FROM lineaspedido WHERE id=?"; 
    $res=$db->prepare($sql);
    $res->execute(array($datos->id));
    #Actualizar stock
    $arrayB=Bebida::detallesBebida($lineaPedido[0]['idbebida']);
    $stock = $arrayB[0]['stock'];
    
    $aux = $stock+ $lineaPedido[0]['unidades'];
    $sql1 = "UPDATE bebidas SET stock= ? WHERE marca=?";
    $res1=$db-> prepare($sql1);
    $res1->execute(array($aux,$arrayB[0]['marca']));
    
    $resK->deleted = true;
    $resK->message = 'Elemento borrado';
}  catch (Exception $e){
    $resK->message="Se ha producido una excepción en el servidor: ".$e->getMessage(); 
    $resK->deleted = false;
}


header('Content-type: application/json');
echo json_encode($resK);

