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
                <li><a href = 'PagAdmin.php' class="active">Ver Usuarios</a></li>  
                <li><a href="CrearUsuario.php" > Crear usuario</a></li>
                <li><a href = 'gestionStock.php'>Gestión de stock</a></li>
                <li><a href = 'verPedidos.php' class="active">Ver pedidos</a></li>
                <li><a href = 'cerrarSesion.php'>Cerrar Sesion</a></li>
            </ul>
        </nav>
        <section>
            <?php
            include_once 'lib.php';
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); 
        $res=$db->prepare("SELECT * FROM pedidos;");
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
                    echo "<th>Estado</th>";
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                $pos = 0;
                foreach($game as $value){
                    if ($pos == 0){$id=$value;}

                    if($pos == 4 || $pos == 6 || $pos == 7 || $pos == 8){
                        if($value==0){
                            echo"<td></td>";
                        }else{
                            date_default_timezone_set("Europe/London");
                            $fecha=date("d-m-Y h:i:sa", $value);
                            echo "<td>$fecha</td>";
                        }
                    }else{
                        echo "<td>$value</td>";
                    }
                    $pos+=1;
                }
                $status = Pedido::estadoPedido($id);
                echo "<th>$status</th>";
                echo "</tr>";
            }
            echo '</table>';
        }
        ?>
        </section>
        
        
    </body>
</html>