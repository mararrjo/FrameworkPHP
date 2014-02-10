<?php
namespace app\controladores;

use nucleo\Controlador;
use app\modelos\form_carrito;
class carrito extends Controlador {
    
    public function verCarrito(){
        $carritos = $this->obtenerTodo("carrito");
        $this->renderizar(array("carritos"=>$carritos));
    }
    
    public function anadirCarrito(){
        $formulario = new form_carrito();
        $this->renderizar(array("form"=>$formulario->renderizarFormulario()));
    }
    
    public function anadirCarrito_validar($request){
        $carrito = new \app\modelos\carrito();
        $formulario = new form_carrito($carrito);
        $formulario->procesarFormulario($request, $carrito);
//        print_r($_POST);
//        var_dump($formulario);
//        var_dump($carrito);
//        echo $carrito->obtenerStringCampos();
        $this->insert($carrito);
        $this->redireccionar("carrito", "verCarrito");
//        $this->renderizarPlantilla("plantilla","carrito","anadirCarrito",array("form"=>$formulario->renderizarFormulario()));
    }
    
}