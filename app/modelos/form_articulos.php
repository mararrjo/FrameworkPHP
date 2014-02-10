<?php

namespace app\modelos;

use nucleo\Formularios;

class form_articulos extends Formularios {

    public function configuracion() {
        $this->setCampos(array(
            "Nombre" => array("type" => "text", "maxLength" => 20, "required" => "required"),
//            "Categoria" => array("type" => "text", "label" => "Nombre de la Categoria"),
            "Categoria" => array("type" =>"seleccion", 
                "label"=>"Elige categoria", 
                "expandido"=>false,
                "multiple"=>false,
//                "opciones" => array("Fruta","Verdura","Legumbre")),
                "opciones" => "categorias"),
            "Precio" => "text",
            "Cantidad" => "number",
            "Aceptar" => "submit",
            "Vaciar" => array("type" => "button", "label" => "Vaciar campos")
        ));
    }

}
