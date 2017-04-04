<?php
session_start();
$resJ = new stdClass();
$resJ->add=false; //Formato objeto con propiedad deleted (por defecto a false)
$resJ->message='';
$resJ->marca='';
$resJ->unidades='';
$resJ->PVP='';
$resJ->id='';
include_once "lib.php";
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');

$data = new stdClass();
#
try{
    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
    $datos = json_decode($datoscrudos);

    $arrayB=Bebida::detallesBebida($datos->Marca);
    
    $resJ->marca = $arrayB[0]['marca'];
  
    $resJ->PVP = $arrayB[0]['PVP'];

    
    $stock = $arrayB[0]['stock'];
    if($datos->cantidad > $stock){
        $resJ->message="No disponemos de existencia disponibles ";
        $resJ->add = false;
        header('Location: nuevoPedido.php');
    }else{

        $sql2 = "INSERT INTO lineaspedido (idpedido, idbebida,unidades, PVP)"
                    ." VALUES (?,?, ?, ?)";
        $res=$db-> prepare($sql2);
        $res->execute(array($_SESSION['idpedido'],$arrayB[0]['id'],$datos->cantidad, $arrayB[0]['PVP']));
        $aux = $stock-$datos->cantidad;
        
        $resJ->unidades = $datos->cantidad;
        
        
        $sql1 = "UPDATE bebidas SET stock= ? WHERE id=?";
        $res1=$db-> prepare($sql1);
        $res1->execute(array($aux,$datos->Marca ));
        $resJ->add = true;     
                
        $sql4 = "SELECT * FROM lineaspedido WHERE idpedido=? and idbebida=? and unidades=? and PVP=?"; 
        $resID=$db->prepare($sql4);
        $resID->execute(array($_SESSION['idpedido'],$arrayB[0]['id'],$datos->cantidad, $arrayB[0]['PVP']));
        $resID->setFetchMode(PDO::FETCH_NAMED);
        $idlinea = $resID->fetchAll();     
        $resJ->id=(int)$idlinea[0]['id'];
    
    }
} catch (Exception $e) {
    $resJ->message="Se ha producido una excepción en el servidor: "; 
    $resJ->add = false;
}


header('Content-type: application/json');
echo json_encode($resJ);