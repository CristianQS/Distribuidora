<?php
    include_once 'lib.php';
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    
    $usuario = $_GET['modifica'];
    $array = $db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $array->execute(array($usuario));
    
    $array->setFetchMode(PDO::FETCH_NAMED);        
    $res=$array->fetchAll();        
    $nomC = $res[0]['nombre'];          
    $type = $res[0]['tipo'];           
    $poblacion =$res[0]['poblacion'];           
    $direccion =$res[0]['direccion'];
    

echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
           <script src=\"scripts.js\"></script>
    </head>

    <body>
        <header id=\"cabezera\">
            <h1>Distribuidoras Refresh</h1>
            <img src=\"imagenes/truck.png\" alt=\"camión\"/>
        </header>
        <nav id=\"navegador\">
            <ul>
                <li><a href = 'PagAdmin.php'>Ver Usuarios</a></li>
                <li><a href=\"CrearUsuario.php\" > Crear usuario</a></li>
                <li><a href = 'modificarUsuario.php' class=\"active\" > Modificar Usuario</a></li>
                <li><a href = 'gestionStock.php'>Gestión de stock</a></li>
                <li><a href = 'verPedidos.php'>Ver pedidos</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <section>
        <h2>Modificar Usuario</h2>
        <form action=\"RealizaModificacion.php\" method = \"get\">
            <label>Usuario: $usuario</label><input type='hidden' name = 'nombreUser' value='$usuario' id = 'nombreUser' size = 20><br>
            <label>Nombre Completo:</label><input type='text' name = 'nombreCom' value='$nomC' id = 'nombreCom' size = 20><br>
            Elija un tipo:<br>";
            User::formu($type);
            echo" 
            <label>Población:</label><input type='text'  name = 'pobla' value='$poblacion' id = 'pobla' size = 20><br>
            <label>Dirección:</label><input type='text'  name = 'dir' value='$direccion' id = 'dir' size = 20><br>
            <input type='submit' value = 'Enviar' name = 'Enviar' id = 'Enviar'><br>
        </form>
        <form action=\"PagAdmin.php\">
            <input type='submit' value = 'Volver' name = 'volver' id = 'volver'><br>
        </form>" ;       
        ?>
        </section>
    </body>
</html>