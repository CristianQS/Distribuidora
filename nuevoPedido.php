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
                <li><a href = 'nuevoPedido.php' class="active"> Nuevo pedido</a></li>
                <li><a href = 'listaPedidos.php'>Lista de Pedidos</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <h1>Crear un nuevo Pedido</h1>
        <form action = addCesta.php method="GET">
            <?php
            $poblacionText="";
            $direccionText="";
            if(isset($_SESSION['pedidoEnCreacion'])){
               $poblacionText = $_SESSION['poblacion']; 
               $direccionText = $_SESSION['direccion']; 
               echo " 
               <label>Población</label><input type = 'text' name= 'Población' id = 'Población' value='$poblacionText' readonly='readonly' size ='20'><br>
            <label>Dirección</label><input type = 'text' name= 'Dirección' id = 'Dirección' value='$direccionText' readonly='readonly' size ='20'><br>";
            } else {
            echo " 
            <label>Población</label><input type = 'text' name= 'Población' id = 'Población' value='$poblacionText' size ='20'><br>
            <label>Dirección</label><input type = 'text' name= 'Dirección' id = 'Dirección' value='$direccionText' size ='20'><br>";
            }
            ?>
            Marca
            <select name="Marca">
                <option value ="1" selected>Agua Artificial   PVP: 1,05€</option>
                <option value="2">Poca Cola   PVP: 1,85€</option>
                <option value="3">Falta Naranja   PVP: 1,75€</option>
                <option value="4">Six Up   PVP: 1.60€</option>
                <option value="5">Cerveza Subtropical   PVP: 1,90€</option>
                <option value="6">Vino Pinto   PVP: 5,35€</option>
                <option value="7">Vino Azul   PVP: 10,75€</option> 
            </select><br>
            <label>Unidades </label><input type = 'text' name= 'cantidad' id = 'cantidad' size ='20'> <br>
            <input type = 'submit' value = 'Añadir a Cesta' name= 'Boton' id = 'Boton'>
        </form>
        <form action="PaginaCliente.php">
            <input type='submit' value = 'Volver' name = 'volver' id = 'volver'><br>
        </form>
        <form action="realizarPedido.php">
            <input type='submit' value="Realizar Pedido" name ='Finalizar' id="Finalizar" ><br>
        </form>
        <form action="deletePedido.php">
            <input type='submit' value="Eliminar Pedido" name ='Eliminar' id="Eliminar" ><br>
        </form>
        <?php
        include_once './lib.php';
        if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); 
        $res=0;
        if(isset($_SESSION['idpedido'])){
            $idp=$_SESSION['idpedido'];
            $sql="SELECT lineaspedido.id, lineaspedido.idpedido, bebidas.marca,lineaspedido.unidades,lineaspedido.PVP FROM lineaspedido INNER JOIN bebidas
                    ON lineaspedido.idbebida=bebidas.id WHERE idpedido=? ;";
            $res=$db->prepare($sql);
            $res->execute(array($idp)); 
        }
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            
            foreach($res as $game){
                if($first){
                    echo "<table><tr>"; 
                    
                    $pos=0;
                    foreach($game as $field=>$value){ //Sacamos clave=> valor
                        if($pos != 0 ){
                         echo "<th>$field</th>";
                        }                        
                        $pos+=1;
                    }
                    $first = false;
                    echo '<th>Borrar</th>';
                    echo "</tr>";
                }
                echo "<tr>";
                $pos = 0;
                foreach($game as $value){
                    if($pos == 0){
                        $aux = $value;
                    }else {
                        echo "<td>$value</td>";
                    }
                    $pos+=1;
                }
                echo "<td><form action='deleteLinea.php' method='get'><input type='submit' value = 'Borrar' name = 'borrar'><input type='hidden' name = 'linea' value = '$aux'></form></td> ";
                echo "</tr>";
            }
            echo '</table>';
        }
        }
        ?>
    </body>
    
</html>