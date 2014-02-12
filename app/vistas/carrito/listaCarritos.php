<div class="seccion">
    <h1>Lista de articulos:</h1>
    <table id="tabla_listado">
        <thead>
            <tr>
                <th>Id</th>
                <th>Usuario</th>
                <th>Articulos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carritos as $carrito): ?>
                <tr>
                    <td><?php echo $carrito->getId(); ?></a></td>
                    <td><?php echo $carrito->getUsuario(); ?></td>
                    <td><?php echo $carrito->obtenerArticulosString(); ?></td>
                    <td><a href="<?php echo nucleo\URL::ruta(array("carrito", "verCarrito", $carrito->getId())) ?>"><button class="boton">Ver</button></a>
                        <a href="<?php echo nucleo\URL::ruta(array("carrito", "modificarCarrito", $carrito->getId())) ?>"><button class="boton">Modificar</button></a>
                        <a href="<?php // echo nucleo\URL::ruta(array("fruteria", "eliminar", $articulo->getId())) ?>"><button class="boton">Eliminar</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="6">
                    <a href="<?php echo nucleo\URL::ruta(array("carrito", "anadirCarrito")); ?>"><button class="boton">Añadir</button></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>