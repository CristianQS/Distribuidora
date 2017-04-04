<?php
session_start();
$res = new stdClass();
$res->deleted=false; //Formato objeto con propiedad deleted (por defecto a false)
$res->message=''; //Mensaje en caso de error

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
    
    $res1=$db->prepare("SELECT * FROM lineaspedido WHERE idpedido=?");
    $res1->execute(array($_SESSION['idpedido']));
    $res1->setFetchMode(PDO::FETCH_NAMED);
    $array = $res1->fetchAll();
    if ( count($array) == 0 ){
        $sql = "DELETE FROM pedidos WHERE id=?"; //funciona
        $res=$db->prepare($sql);//funciona
        $res->execute(array($_SESSION['idpedido']));//funciona
        unset($_SESSION['idpedido']);
        unset($_SESSION['pedidoEnCreacion']);
        unset($_SESSION['dirección']);
        unset($_SESSION['población']);
        $_SESSION['error']="Se ha eliminado el pedido";
    }
    $res->deleted = true;
    $res->message = 'Elemento borrado';
}  catch (Exception $e){
    $res->message="Se ha producido una excepción en el servidor: ".$e->getMessage(); 
    $res->deleted = false;
}


header('Location: nuevoPedido.php');
echo json_encode($res);

