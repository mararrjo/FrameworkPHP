<?php
namespace nucleo;

class Aplicacion {
    
    public function __construct() {
        
        $sesion = new \nucleo\Sesion();
        
        \nucleo\Distribuidor::mostrarVista();
    
        
    }
    
}
