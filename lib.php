<?php
/**Si queremos añadir un logo tenemos que modificarlo aqui*/
class View{
    public static function  start($title){
        $html = "<!DOCTYPE html>
<html>
<head>
<meta charset=\"utf-8\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
<script src=\"scripts.js\"></script>
<title>$title</title>
</head>
<body>";
        User::session_start();
        echo $html;
    }
    public static function navigation(){
        echo '<nav>';
        echo '</nav>';
    }
    public static function end(){
        echo '</body>
</html>';
    }
    
    public static function showTable($table){
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
        $res=$db->prepare("SELECT * FROM '$table';");//prepare da un objeto.Llamamos a un metodo del objeto
        $res->execute(); //almacena la respuesta
        //Ejemplo de lectura de tabla
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            /**Vamos sacando fila a fila, contiene los campos de esa fila*/
            foreach($res as $game){ //Un array
                if($first){
                    echo "<table><tr>"; //Esto va a la pagina de html,
                    //Sacamos los campos
                    foreach($game as $field=>$value){ //Sacamos clave=> valor
                        echo "<th>$field</th>";
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                $pos = 0;
                foreach($game as $value){
                    echo "<th>$value</th>";
                }
                
                echo "</tr>";
            }
            echo '</table>';
        }
    }
    
    
    public static function alteraTabla($table){
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
        $res=$db->prepare("SELECT * FROM '$table';");//prepare da un objeto.Llamamos a un metodo del objeto
        $res->execute(); //almacena la respuesta
        //Ejemplo de lectura de tabla
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            /**Vamos sacando fila a fila, contiene los campos de esa fila*/
            foreach($res as $game){ //Un array
                if($first){
                    echo "<table><tr>"; //Esto va a la pagina de html,
                    //Sacamos los campos
                    foreach($game as $field=>$value){ //Sacamos clave=> valor
                        echo "<th>$field</th>";
                    }
                    echo "<th>Borrar</th>";
                    echo "<th>Modificar</th>";
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                $pos = 0;
                foreach($game as $value){
                    echo "<th>$value</th>";
                    if($pos == 1){
                        $aux = $value;
                    }
                    $pos+=1;
                }
                echo "<td><form action='deleteUser.php' method='get'><input type='submit' value = 'Borrar' name = 'borrar'><input type='hidden' name = 'escondido' value = '$aux'></form></td> ";
                echo "<td><form action='modificarUsuario.php' method='get'><input type='submit' value = 'Modificar' name = 'Modificar'><input type='hidden' name = 'modifica' value = '$aux'></form></td> ";
                echo "</tr>";
            }
            echo '</table>';
        }
    }
}
class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            self::$connection = $db = new PDO("sqlite:./datos.db");
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
    public static function execute_sql($sql,$parms=null){
        try {
            $db = $this->get();
            $ints= $db->prepare ( $sql );
            if ($ints->execute($parms)) {
                return $ints;
            }
        }
        catch (PDOException $e) {
            echo '<h1>Error en al DB: ' . $e->getMessage() . '</h1>';
        }
        return $false;
    }
}
class User{
    public static function formu ($type){
        switch ($type){
            case 1:
                echo "
            <input type='radio' checked =\"checked\" name = 'tipo' value ='1'id = 'tipo'>Administrador<br>
            <input type='radio' name = 'tipo' value ='2' id = 'tipo'>Cliente<br>
            <input type='radio' name = 'tipo' value ='3' id = 'tipo'>Repartidor<br>";
                break;
            case 2:
                echo " 
            <input type='radio' name = 'tipo' value ='1'id = 'tipo'>Administrador<br>
            <input type='radio' checked =\"checked\"name = 'tipo' value ='2' id = 'tipo'>Cliente<br>
            <input type='radio' name = 'tipo' value ='3' id = 'tipo'>Repartidor<br>";
                break;
            case 3:
                echo" 
            <input type='radio' name = 'tipo' value ='1'id = 'tipo'>Administrador<br>
            <input type='radio' name = 'tipo' value ='2' id = 'tipo'>Cliente<br>
            <input type='radio' checked =\"checked\" name = 'tipo' value ='3' id = 'tipo'>Repartidor<br>";
                break;
            
        }
    }

    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($usuario,$pass){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE usuario=? and clave=?');
        $inst->execute(array($usuario,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            $_SESSION['user']=$res[0]; //Almacena datos del usuario en la sesión
            return true;
        }
        return false;
    }
    
    public static function findUser($usuario){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE usuario=?');
        $inst->execute(array($usuario));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            //$_SESSION['user']=$res[0]; //Almacena datos del usuario en la sesión
            return true;
        }
        return false;
    }
    
    public static function userType(){
        $res = User::getLoggedUser();
        return $res['tipo'];
        
    }
    
    public static function choosePage($type){
        switch($type){
            case 1:
                header('Location: PagAdmin.php' );
                break;
            case 2:
                header('Location: PaginaCliente.php' );
                break;
            case 3:
                header('Location: PagRepartidor.php' );
                break;
        }
    }
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
    
}
class Pedido{
        public static  function estadoPedido($id){
        $array = self::detallesPedido($id);
        $horaCreacion = $array[0]['horacreacion'];
        $horaAsignacion = $array[0]['horaasignacion'];
        $horaReparto = $array[0]['horareparto'];
        $horaEntrega = $array[0]['horaentrega'];
        if($horaCreacion == 0){
            return "En proceso";
        }

        if($horaCreacion != 0 && $horaAsignacion ==0){
            return "No asignado";
        }
        if($horaAsignacion != 0 && $horaReparto == 0){
            return "Asignado";
        }
        if($horaReparto != 0 && $horaEntrega == 0){
            return "En Reparto";
        }
        if($horaEntrega != 0 ){
            return "Entregado";
        }
    }
    public static function detallesPedido($id){
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); 
        $sql = "SELECT * from pedidos WHERE id = ?; ";
        $inst=$db->prepare($sql);
        $inst->execute(array($id));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res= $inst->fetchAll();
        return $res;
    }
    public static function detallesPed($poblacion, $direccion){
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); 
        $consulta=$db-> prepare("SELECT * FROM pedidos WHERE poblacionentrega=? and direccionentrega=? ");
        $consulta->execute(array($poblacion, $direccion));
        $consulta->setFetchMode(PDO::FETCH_NAMED);
        $result=$consulta->fetchAll();
        return $result;
    }
    public static function existePedido($poblacion, $direccion){
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); 
        $consulta=$db-> prepare("SELECT * FROM pedidos WHERE poblacionentrega=? and direccionentrega=? ");
        $consulta->execute(array($poblacion, $direccion));
        $consulta->setFetchMode(PDO::FETCH_NAMED);
        $result=$consulta->fetchAll();
        if(count($result)==1){
            return true;
        }
        return false;
    }
}

class Bebida{
    
    public static function detallesBebida($marca){
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); 
        $sql = "SELECT * from bebidas WHERE marca = ?; ";
        $inst=$db->prepare($sql);
        $inst->execute(array($marca));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res= $inst->fetchAll();
        return $res;
    }
}