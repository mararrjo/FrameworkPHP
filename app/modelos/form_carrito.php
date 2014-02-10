<?php
namespace app\modelos;

class form_carrito extends \nucleo\Formularios {
    
    public function configuracion() {
    
        $this->setCampos(array(
            "usuario"=>"text",
            "articulos"=>array(
                "type"=>"seleccion",
                "multiple"=>true,
                "opciones"=>"articulos",),
            "Aceptar"=>"submit"
        ));
        
    }
    
}