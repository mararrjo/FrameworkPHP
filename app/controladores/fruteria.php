<?php

namespace app\controladores;

use nucleo\Controlador;
use app\modelos\form_articulos;

class fruteria extends Controlador {

    public function listado() {
        $articulos = $this->obtenerTodo("articulos", array("order by" => "nombre"));
        $categorias = $this->obtenerTodo("categorias");
        $this->renderizar(array("articulos" => $articulos, "categorias" => $categorias));
    }

    public function mostrar($request, $id = 0) {
        $articulo = new \app\modelos\articulos();
        $articulo = $this->obtenerPorId("articulos", $id);
        $articulo->cambiarTipoPropiedadPorObjetos("categoria", "categorias", "nombre", $articulo->getCategoria());
//        $this->renderizar(array("articulo" => $articulo));
        $this->renderizarPlantilla("plantilla", "fruteria", "mostrar", array("articulo" => $articulo));
    }

    public function ver($request, $id = 0) {
        $this->redireccionar("fruteria", "mostrar", array("id" => $id));
    }

    public function anadir() {
        $form = new form_articulos();
        $this->renderizar(array("form" => $form->renderizarFormulario()));
    }

    public function anadir_validar($request) {
        $articulo = new \app\modelos\articulos();
        $formulario = new form_articulos($articulo);
        $formulario->procesarFormulario($request, $articulo);
        if ($this->insert($articulo)) {
            \nucleo\Sesion::setFlash("Se ha añadido el articulo " . $articulo->getNombre());
            $this->redireccionar("fruteria", "listado");
        } else {
            $this->renderizarPlantilla("plantilla", "fruteria", "anadir", array("form" => $formulario->renderizarFormulario()));
        }
    }

    public function modificar($request, $id = 0) {
        $articulo = $this->obtenerPorId("articulos", $id);
        $form = new form_articulos($articulo);
//        var_dump($form);
        $this->renderizar(array("form" => $form->renderizarFormulario()));
    }

    public function modificar_validar($request) {
        $articulo = new \app\modelos\articulos();
        $formulario = new form_articulos($articulo);
        $formulario->procesarFormulario($request, $articulo);
        if ($this->update($articulo)) {
            \nucleo\Sesion::setFlash("Se ha modificado el articulo " . $articulo->getNombre());
            $this->redireccionar("fruteria", "listado");
        } else {
            $this->renderizarPlantilla("plantilla", "fruteria", "modificar", array("form" => $formulario->renderizarFormulario()));
        }
    }

    public function eliminar($request, $id = 0) {
        $articulo = new \app\modelos\articulos();
        $articulo = $this->obtenerPorId("articulos", $id);
        $this->renderizar(array("articulo" => $articulo));
//        $form = new form_articulos($articulo);
//        $this->renderizar(array("form"=>$form->renderizarFormulario()));
    }

    public function eliminar_validar($request) {
        if (isset($request["id"])) {
            $id = $request["id"];
            $articulo = $this->obtenerPorId("articulos", $id);
//        $articulo = new \app\modelos\articulos();
//        $formulario = new form_articulos($articulo);
//        $formulario->procesarFormulario($request, $articulo);
            $this->delete($articulo);
            \nucleo\Sesion::setFlash("Se ha eliminado el articulo " . $articulo->getNombre());
            $this->redireccionar("fruteria", "listado");
        } else {
            $this->redireccionar("fruteria", "listado");
        }
    }

    public function anadirCategoria() {
        $form = new \app\modelos\form_categorias();
        $this->renderizarPlantilla("plantilla", "fruteria", "anadirCategorias", array("form" => $form->renderizarFormulario()));
    }

    public function anadirCategoria_validar($request) {
        $categoria = new \app\modelos\categorias();
        $form = new \app\modelos\form_categorias($categoria);
        $form->procesarFormulario($request, $categoria);
        $this->insert($categoria);
        \nucleo\Sesion::setFlash("Se ha añadido la categoria " . $categoria->getNombre());
        $this->redireccionar("fruteria", "listado");
    }

}
