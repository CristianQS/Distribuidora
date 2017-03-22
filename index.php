
<?php //Etiqueta de inicio, se asume que no hay nada alfinal, no se recomienda poner '>'
//Noe es sensible a mayus y minus
//script son una mezcla de html y php

include_once 'lib.php';  //El interprete va a incluir el lib.php, hay que incluir lo que vamos a usar aunque esten en el mismo directorio
View::start('Distribuidora');  //Llamada al metodo de una clase. Los :: accedemos a un metodo estatico, el metodo genera el html principal
?>
        <header id="cabezera">
            <h1>Distribuidoras Refresh</h1>
            <img src="imagenes/truck.png" alt="camión"/>
        </header>
        <nav id="navegador">
            <ul>
                <li><a href="index.php" class="active" > Inicio</a></li>
                <li><a href="IniciaUsuario.php" > Iniciar Sesión</a></li>
            </ul>
        </nav>
<?

View::end();// Aqui acaba la pagina html pone fin al body y al html
