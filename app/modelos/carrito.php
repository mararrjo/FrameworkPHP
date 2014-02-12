<?php
namespace app\modelos;

class carrito extends \nucleo\Clase_base {
    
    private $id;
    private $usuario;
    private $articulos = array();
    
    public function getId() {
        return $this->id;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getArticulos() {
        return $this->articulos;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setArticulos(array $articulos) {
        $this->articulos = $articulos;
    }

    public function obtenerArticulosString(){
        $articulos = "";
        foreach($this->articulos as $articulo){
            $articulos .= $articulo." ";
        }
        return $articulos;
    }
    
    public function __toString() {
        return $this->usuario;
    }
    
    public function obtenerPorId($id, $nombreTabla = "") {
        parent::obtenerPorId($id, $nombreTabla);
        $this->cambiarTipoPropiedadPorObjetos("articulos", "articulos", "nombre", $this->getArticulos());
    }
    
}
