<?php

namespace app\controladores;

use nucleo\Controlador;
use app\modelos\form_carrito;

class carrito extends Controlador {

    public function listaCarritos() {
        $carrito = new \app\modelos\carrito();
        $carritos = $carrito->obtenerTodo();
        $this->renderizar(array("carritos" => $carritos));
    }

    public function verCarrito($request, $id) {
        $carrito = new \app\modelos\carrito();
        $carrito->obtenerPorId($id);
        $this->renderizar(array("carrito" => $carrito));
    }

    public function anadirCarrito() {
        $formulario = new form_carrito();
        $this->renderizar(array("form" => $formulario->renderizarFormulario()));
    }

    public function anadirCarrito_validar($request) {
        $carrito = new \app\modelos\carrito();
        $formulario = new form_carrito($carrito);
        $formulario->procesarFormulario($request, $carrito);
        if ($formulario->esValido()) {
            $carrito->persistir();
            $this->redireccionar("carrito", "listaCarritos");
        } else {
            $this->renderizarPlantilla("plantilla", "carrito", "anadirCarrito", array("form" => $formulario->renderizarFormulario()));
        }
    }

    public function modificarCarrito($request, $id) {
        $carrito = new \app\modelos\carrito();
        $carrito->obtenerPorId($id);
        $formulario = new form_carrito($carrito);
        $this->renderizar(array("form" => $formulario->renderizarFormulario()));
    }

    public function modificarCarrito_validar($request) {
        $carrito = new \app\modelos\carrito();
        $formulario = new form_carrito();
        $formulario->procesarFormulario($request, $carrito);
        if ($formulario->esValido()) {
            $carrito->persistir();
            $this->redireccionar("carrito", "listaCarritos");
        } else {
            $this->renderizarPlantilla("plantilla", "carrito", "modificarCarrito", array("form" => $formulario->renderizarFormulario()));
        }
    }

    public function quitarArticulo($request, $idCarrito, $idArticulo = 0) {
        $carrito = new \app\modelos\carrito();
        $carrito->obtenerPorId($idCarrito);
        $articulos = $carrito->getArticulos();
        unset($articulos[$idArticulo]);
        $carrito->setArticulos($articulos);
//        var_dump($carrito);
//        echo $carrito->existe();
        $carrito->persistir();
        $this->redireccionar("carrito", "verCarrito", array("id"=>$carrito->getId()));
    }

}
