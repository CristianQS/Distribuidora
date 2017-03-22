<?php
include_once 'lib.php';
$title = 'Borrar un usuario existente';
View::start($title);
echo "<h1>$title</h1>\n";

if(!isset($_SESSION['justDeleted'])){
    
    
    
    $form = <<<FIN_FORM
    <form action="borrarusuario.php" method="POST">
        <div>
            <label for="usuarioToDelete">Introduzca el nombre del usuario a borrar:</label>
            <input type="text" name="usuarioToDelete" id="usuarioToDelete">
            <input type=submit value="Borrar usuario">
        </div>
    </form>

    
FIN_FORM;
echo $form;
$_SESSION['justDeleted'] = 1;
View::end();

} else {
    Pepe::deleteUser($_POST['usuarioToDelete']);
    echo "En teoría has borrao un usuario";
    echo "<form action='index.php'>
        <input type=submit value=Volver>
    </form>";
    unset($_SESSION['justDeleted']);
}
        
class pepe{
    public static function deleteUser($iUsuario){
        $db=DB::get();
        $inst=$db->prepare('DELETE FROM usuarios where [usuario] = ?');
        $inst->execute(array($iUsuario));
        
    }
}

