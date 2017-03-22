<?php
include_once 'lib.php';
$title = 'Ver los datos de un usuario';
View::start($title);
echo "<h1>$title</h1>\n";

if(!isset($_SESSION['justTyped'])){
    $form = <<<FIN_FORM

    <form action=creausuario.php method=POST>
        <h2>Datos de acceso</h2>
        <div>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario">
        </div>
        <div>
            <label for="pass">Contraseña:</label>
            <input type="password" name="pass" id="pass">
        </div>
        <div>
            <label for="re-pass">Repita la contraseña:</label>
            <input type="password" name="re-pass" id="re-pass">
        </div>
        <h2>Datos del usuario</h2>
        <div>
            <label for="nombreUsuario">Nombre:</label>
            <input type="text" name="nombreUsuario" id="nombreUsuario">
        </div>
        <div>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos">
        </div>
        <div>
            <label for="type">Tipo de usuario:</label>
            <input type="text" name="type" id="type">
        </div>
        <div>
            <label for="población">Población:</label>
            <input type="text" name="población" id="población">
        </div>
        <div>
            <label for="dirección">Dirección:</label>
            <input type="text" name="dirección" id="dirección">
        </div>
        
        <input type=submit value=Cancelar>
        <input type=submit value=Enviar>
        
    </form>
    
FIN_FORM;
echo $form;
$_SESSION['justCreated'] = 1;
View::end();

} else {
    Pepe::createUser($_POST['usuario'], $_POST['pass'], $_POST['nombreUsuario'], $_POST['type'], $_POST['población'], $_POST['dirección']);
    echo "En teoría has creao un usuario";
    echo "<form action='index.php'>
        <input type=submit value=Volver>
    </form>";
    unset($_SESSION['justCreated']);
    //Admin::showOptions();
}
        
class pepe{
    public static function createUser($iUsuario, $iClave, $iNombre, $iTipo, $iPoblacion, $iDireccion){
        $db=DB::get();
        $inst=$db->prepare('INSERT INTO usuarios ([usuario], [clave], [nombre], [tipo], [poblacion], [direccion]) VALUES (?, ?, ?, ?, ?, ?)');
        $inst->execute(array($iUsuario,md5($iClave), $iNombre, $iTipo, $iPoblacion, $iDireccion));
    }
}

