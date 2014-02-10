<div class="seccion">
    <h3>Articulos:</h3>
    <table id="tabla_listado">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articulos as $articulo): ?>
                <tr>
                    <td><a href="<?php echo nucleo\URL::ruta(array("fruteria", "mostrar", $articulo->getId())) ?>"><?php echo $articulo->getId(); ?></a></td>
                    <td><?php echo $articulo->getNombre(); ?></td>
                    <td><?php echo $articulo->getCategoria(); ?></td>
                    <td><?php echo $articulo->getPrecio(); ?></td>
                    <td><?php echo $articulo->getCantidad(); ?></td>
                    <td><a href="<?php echo nucleo\URL::ruta(array("fruteria", "ver", $articulo->getId())) ?>"><button>Ver</button></a>
                        <a href="<?php echo nucleo\URL::ruta(array("fruteria", "modificar", $articulo->getId())) ?>"><button>Modificar</button></a>
                        <a href="<?php echo nucleo\URL::ruta(array("fruteria", "eliminar", $articulo->getId())) ?>"><button>Eliminar</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="6">
                    <a href="<?php echo nucleo\URL::ruta(array("fruteria", "anadir")); ?>"><button>Añadir</button></a>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <h3>Categorias:</h3>
    <table id="tabla_listado">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?php echo $categoria->getId(); ?></td>
                    <td><?php echo $categoria->getNombre(); ?></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                <td colspan="6">
                    <a href="<?php echo nucleo\URL::ruta(array("fruteria", "anadirCategoria")); ?>"><button>Añadir</button></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>