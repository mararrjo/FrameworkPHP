<div class="seccion">
    <h1>Estas seguro de que quieres eliminar?</h1>
    <form action="<?php echo \nucleo\URL::ruta(array("fruteria", "eliminar_validar", $articulo->getId())) ?>" method="post">
        <?php echo \nucleo\Widgets::hidden("id", $articulo->getId()) ?>
        <?php echo \nucleo\Widgets::submit("Confirmar") ?>
        <?php echo \nucleo\Widgets::button("Cancelar", "", array("onclick" => \nucleo\URL::redireccionar(array("fruteria", "listado")))) ?>
    </form>
</div>