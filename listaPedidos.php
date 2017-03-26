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
        if($user != 2){
            echo "Permiso Denegado";
            User::securityUser($user);
        } else{
        ?>
        <nav id="navegador">
            <ul>
                <li><a href = 'PaginaCliente.php'>Ver Productos</a></li>
                <li><a href = 'nuevoPedido.php' > Nuevo pedido</a></li>
                <li><a href = 'listaPedidos.php' class="active">Lista de Pedidos</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <h1>Lista de Pedidos</h1>
        <?php
        include_once 'lib.php';
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;');
        $array = User::getLoggedUser();
        $us = $array['id'];
        $res=$db->prepare("SELECT * FROM pedidos WHERE idcliente = ? ;");
        $res->execute(array($us)); //almacena la respuesta
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
                        if($pos != 1 && $pos != 5){
                         echo "<th>$field</th>";
                        }                        
                        $pos+=1;
                    }
                    echo"<th>Detalles del Pedido</th>";
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
                        if($pos != 1 && $pos != 5 ){
                            echo "<td>$value</td>";
                        }
                    }
                    $pos+=1;
                }
                echo "<td><form action='verDetalles.php' method='get'><input type='submit' value = 'Ver Detalles' name = 'ver'><input type='hidden' name = 'detalles' value = '$aux'></form></td> ";
                echo "</tr>";
            }
            echo '</table>';
        }
        }
        ?>
    </body>
</html>