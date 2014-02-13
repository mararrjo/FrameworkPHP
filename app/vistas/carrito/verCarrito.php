<div class="seccion">
    <h1>Lista de articulos:</h1>
    <h3><?php echo $carrito->getUsuario(); ?></h3>
    <table id="tabla_listado">
        <thead>
            <tr>
                <td>Articulo</td>
                <td>Id</td>
                <td>Nombre</td>
                <td>Categoria</td>
                <td>Precio</td>
                <td>Cantidad</td>
                <td>Opcion</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carrito->getArticulos() as $indice => $articulo): ?>
                <tr>
                    <td><?php echo $indice+1 ?></td>
                    <td><?php echo $articulo->getId(); ?></td>
                    <td><?php echo $articulo->getNombre(); ?></td>
                    <td><?php echo $articulo->getCategoria(); ?></td>
                    <td><?php echo $articulo->getPrecio(); ?></td>
                    <td><?php echo $articulo->getCantidad(); ?></td>
                    <td>
                        <a href="<?php echo \nucleo\URL::ruta(array("carrito","quitarArticulo",$carrito->getId(),$articulo->getId())) ?>">
                            <button class="boton">Quitar</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?php echo nucleo\URL::ruta(array("carrito","listaCarritos")) ?>"><button class="boton">Volver</button></a>
</div>