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
                <li><a href = 'PaginaCliente.php'>Ver Productos</a></li>
                <li><a href = 'nuevoPedido.php' class="active"> Nuevo pedido</a></li>
                <li><a href = 'listaPedidos.php'>Lista de Pedidos</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <h1>Crear un nuevo Pedido</h1>
        <form action = addCesta.php method="GET">
            <?php
            session_start();
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
                <option value ="Agua artificial" selected>Agua Artificial   PVP: 1,05€</option>
                <option value="Poca Cola">Poca Cola   PVP: 1,85€</option>
                <option value="Falta Naranja">Falta Naranja   PVP: 1,75€</option>
                <option value="Six Up">Six Up   PVP: 1.60€</option>
                <option value="Cerveza Subtropical">Cerveza Subtropical   PVP: 1,90€</option>
                <option value="Vino Pinto">Vino Pinto   PVP: 5,35€</option>
                <option value="Vino Azul">Vino Azul   PVP: 10,75€</option> 
            </select><br>
            <label>Unidades </label><input type = 'text' name= 'cantidad' id = 'cantidad' size ='20'> <br>
            <input type = 'submit' value = 'Añadir a Cesta' name= 'Boton' id = 'Boton'>
        </form>
        <form action="PagAdmin.php">
            <input type='submit' value = 'Volver' name = 'volver' id = 'volver'><br>
        </form>
        <form action="realizarPedido.php">
            <input type='submit' value="Realizar Pedido" name ='Finalizar' id="Finalizar" ><br>
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
        $res=$db->prepare("SELECT * FROM lineaspedido WHERE idpedido=? ;");
        $res->execute(array($idp)); 
        }
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            
            foreach($res as $game){
                if($first){
                    echo "<table><tr>"; 
                    
                    foreach($game as $field=>$value){ 
                        echo "<th>$field</th>";
                    }
                    $first = false;
                    echo '<th>Borrar</th>';
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
                echo "<td><form action='deletePedido.php' method='get'><input type='submit' value = 'Borrar' name = 'borrar'><input type='hidden' name = 'linea' value = '$aux'></form></td> ";
                echo "</tr>";
            }
            echo '</table>';
        }
        ?>
    </body>
    
</html>