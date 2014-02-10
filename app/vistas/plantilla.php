<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Fruteria</title>
        <?php echo \nucleo\Recursos::css("main"); ?>
        <?php echo \nucleo\Recursos::css("fruteria", "listado"); ?>
        <?php echo \nucleo\Recursos::js("jquery"); ?>
        <?php echo \nucleo\Recursos::js("jquery-ui"); ?>
        <?php echo \nucleo\Recursos::js("fruteria", "main"); ?>
    </head>
    <body>
        <div id="cabecera">
            <h1>Fruteria</h1>
            <?php echo \nucleo\Recursos::imagen("", "carrito.jpg", array("alt" => "imagen", "width" => "200")); ?>
        </div>
        <div id="cuerpo">
            <div id="menu">
                <a href="<?php echo \nucleo\URL::ruta(array("carrito","verCarrito")) ?>">Ver carrito |</a>
                <a href="<?php echo \nucleo\URL::ruta(array("fruteria","listado")) ?>">Ver articulos</a>
            </div>
            <div id="contenido">
                <?php
                echo $contenido;
                ?>
            </div>
        </div>
        <div id="pie"></div>
    </body>
</html>