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
        } else{
        ?>
        <nav id="navegador">
            <ul>
                <li><a href = 'PagAdmin.php'>Ver Usuarios</a></li>
                <li><a href="CrearUsuario.php" > Crear usuario</a></li>
                <li><a href = 'gestionStock.php' class="active">Gestión de stock</a></li>
                <li><a href = 'verPedidos.php'>Ver pedidos</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <section>
            <?php
            include_once './lib.php';
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
        $res=$db->prepare("SELECT * FROM 'bebidas';");//prepare da un objeto.Llamamos a un metodo del objeto
        $res->execute(); //almacena la respuesta
        //Ejemplo de lectura de tabla
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            echo "<form action=\"actualizarStock.php\" method=\"POST\">";
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
                    if($pos == 1){$nameMarca=$value;}
                    if ($pos == 2){
                        echo "<td><input type='text'  name = \"cantidad[]\" value='$value' id = 'cantidad' ></td>";
                        echo "<input type='hidden'  name = \"nameMarca[]\" value='$nameMarca' id = 'nameMarca' >";
                    }else{
                        echo "<td>$value</td>";
                    }
                    $pos+=1;
                }
                
                echo "</tr>";
            }
            echo '</table>';
            echo "<input type='submit' value = 'Enviar' name = 'Enviar' id = 'Enviar'><br>";
            echo "</form>";
            

        }
        if(isset($_SESSION['updated'])){
               echo "Se ha actualizado la información" ;
               unset($_SESSION['updated']);
            }
        }
        ?>
          
        </section>
    </body>
</html>