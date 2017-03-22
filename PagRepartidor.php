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
        <nav id="navegador">
            <ul>
                <li><a href = 'PagRepartidor.php' class="active">Pedidos no asignados</a></li>
                <li><a href = 'VerAsignados.php' >Pedidos Asignados</a></li>
                <li><a href = 'VerRepartidos.php'>Pedidos en reparto</a></li>
                <li><a href = 'VerEntregados.php'>Pedidos entregados</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <h1>Pedidos no asignados</h1>
        <?php
        include_once 'lib.php';
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;');
        $array = User::getLoggedUser();
        $us = $array['id'];
        $res=$db->prepare("SELECT * FROM pedidos WHERE idrepartidor IS NULL ;");
        $res->execute(); //almacena la respuesta
        //Ejemplo de lectura de tabla
        if($res){
            echo '<h2>Lista de Bebidas</h2>';
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
                    
                    echo "<th>Asignarse Pedido</th>";
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                $pos = 0;
                foreach($game as $value){
                    echo "<th>$value</th>";
                    if($pos == 0){
                        $aux = $value;
                    }
                    $pos+=1;
                }
                echo "<td><form action='AsignarPedido.php' method='get'><input type='submit' value = 'Asignar' name = 'Asignar'><input type='hidden' name = 'escondido' value = '$aux'></form></td> ";
                echo "</tr>";
            }
            echo '</table>';
        }
        ?>
    </body>
</html>