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
                <li><a href = 'PaginaCliente.php' class="active">Ver Productos</a></li>
                <li><a href = 'nuevoPedido.php' > Nuevo pedido</a></li>
                <li><a href = 'listaPedidos.php'>Lista de Pedidos</a></li>
                <li><a href = 'cerrarSesion.php' >Cerrar Sesion</a></li>
            </ul>
        </nav>
        <section>
            <h1>Tabla Productos</h1>
            <?php
            include_once 'lib.php';
            $db = new PDO("sqlite:./datos.db");
            $db->exec('PRAGMA foreign_keys = ON;');
            View::showTable('bebidas');
            ?>
        </section>
    </body>
</html>