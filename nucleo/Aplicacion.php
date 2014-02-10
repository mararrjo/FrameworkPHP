<?php
namespace nucleo;

class Aplicacion {
    
    public function __construct() {
        \nucleo\Distribuidor::mostrarVista();
//        \nucleo\Controlador::cargar();
//        include_once "app/vistas/".  \app\Configuracion::$vista_plantilla.".php";
    }
    
}
