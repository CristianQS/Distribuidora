<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="estilos.css">
        <script src="scripts.js"></script>      
    </head>
    

    <body>
        <header id="cabezera">
            <h1>Distribuidoras Refresh</h1>
            <img src="imagenes/truck.png" alt="camión"/>
        </header>
        <?php
        session_start();
        include_once './lib.php';
        $user=User::userType();
        if($user != 1){
            echo "Permiso Denegado";
            User::securityUser($user);
        }else{
        ?>
        <nav id="navegador">
            <ul>
                <li><a href = 'PagAdmin.php'>Ver Usuarios</a></li>
                <li><a href="CrearUsuario.php" class="active" > Crear usuario</a></li>
                <li><a href = 'gestionStock.php'>Gestión de stock</a></li>
                <li><a href = 'verPedidos.php'>Ver pedidos</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <section>
            <h2>Crear Usuario</h2><br>
            <form onsubmit="return compruebaUsuario()">
            <label>Nombre de Usuario:</label><input type='text' name = 'nombreUser' id = 'nombreUser' size = 20><br>
            <label>Nombre Completo:</label><input type='text' name = 'nombreCom' id = 'nombreCom' size = 20><br>
            <label>Contraseña:</label><input type='password' name = 'password' id = 'password' size = 20><br>
            Elija un tipo:<br>
            <input type='radio' name = 'tipo' value ='Administrador'id = 'tipo'>Administrador<br>
            <input type='radio' name = 'tipo' value ='Cliente' id = 'tipo'>Cliente<br>
            <input type='radio' name = 'tipo' value ='Repartidor' id = 'tipo'>Repartidor<br>
            <label>Población:</label><input type='text' name = 'poblacion' id = 'poblacion' size = 20><br>
            <label>Dirección:</label><input type='text' name = 'direccion' id = 'direccion' size = 20><br>
            <input type='submit' value = 'Enviar' name = 'enviar' id = 'enviar'><br>
        </form>
        <form action="PagAdmin.php">
            <input type='submit' value = 'Volver' name = 'volver' id = 'volver'><br>
        </form>
        <?php
            include_once 'lib.php';
            $db = new PDO("sqlite:./datos.db");
            $db->exec('PRAGMA foreign_keys = ON;');
            
            if(isset($_GET['nombreUser'])){
                $com = User::findUser($_GET['nombreUser']);
                if($com == false ){
                    if($_GET['tipo'] != null){
                        if($_GET['tipo'] == 'Administrador') $tipo = 1;
                        if($_GET['tipo'] == 'Cliente') $tipo = 2;
                        if($_GET['tipo'] == 'Repartidor') $tipo = 3;
                        $sql = "INSERT INTO usuarios (usuario, clave, nombre, tipo,poblacion,direccion)"
                        ." VALUES (?, ?, ?, ?,?,?)";
                        $res=$db-> prepare($sql);
                        $res->execute(array($_GET['nombreUser'],md5($_GET['password']),$_GET['nombreCom'],$tipo, $_GET['poblacion'], $_GET['direccion']));
                    }
                   header('Location: PagAdmin.php');
                }else{
                    echo "Este usuario ya existe";
                }            
            }
        }   
        ?>
        </section>
    </body>
</html>