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
        if($user != 3){
            echo "Permiso Denegado";
            User::securityUser($user);
        } else{
        ?>
        <nav id="navegador">
            <ul>
                <li><a href = 'PagRepartidor.php'>Pedidos no asignados</a></li>
                <li><a href = 'VerAsignados.php' class="active" >Pedidos Asignados</a></li>
                <li><a href = 'VerRepartidos.php'>Pedidos en reparto</a></li>
                <li><a href = 'VerEntregados.php'>Pedidos entregados</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <h1>Ver Pedidos Asignados</h1>
        <?php
        include_once 'lib.php';
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;');
        $array = User::getLoggedUser();
        $us = $array['id'];
        $sql="SELECT pedidos.id, usuarios.nombre,pedidos.poblacionentrega,pedidos.direccionentrega,
            pedidos.horacreacion, pedidos.idrepartidor, pedidos.horaasignacion, pedidos.horareparto, pedidos.horaentrega,
            pedidos.PVP FROM pedidos INNER JOIN usuarios
              ON pedidos.idcliente=usuarios.id WHERE horareparto = 0 and idrepartidor IS NOT NULL ;";
        $res=$db->prepare($sql);
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
                    $pos=0;
                    foreach($game as $field=>$value){ //Sacamos clave=> valor
                        if($pos != 0 && $pos != 5 ){
                         echo "<th>$field</th>";
                        }                        
                        $pos+=1;
                    }
                    echo "<th>Repartir Pedido</th>";
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                $pos = 0;
                foreach($game as $value){
                    if($pos == 0){
                        $aux = $value;
                    }
                    if($pos == 4 || $pos == 6 || $pos == 7 || $pos == 8){
                        if($value==0){
                            echo"<td></td>";
                        }else{
                            date_default_timezone_set("Europe/London");
                            $fecha=date("d-m-Y h:i:sa", $value);
                            echo "<td>$fecha</td>";
                        }
                    }else{
                        if($pos != 0 && $pos != 5){
                            echo "<td>$value</td>";
                        }
                    }
                    $pos+=1;
                }
                echo "<td><form action='RepartirPedido.php' method='get'><input type='submit' value = 'Repartir' name = 'Repartir'><input type='hidden' name = 'escondido' value = '$aux'></form></td> ";
                echo "</tr>";
            }
            echo '</table>';
        }
        }
        ?>
    </body>
</html>