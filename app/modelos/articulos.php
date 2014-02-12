<?php
namespace app\modelos;

class articulos extends \nucleo\Clase_base {
    
    private $id;
    private $nombre;
    private $categoria;
    private $precio;
    private $cantidad;
    
    function __construct($id=0, $nombre="", $categoria="", $precio=0, $cantidad=0) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
    
    public function __toString() {
        return $this->nombre;
    }
    
    public function obtenerPorId($id, $nombreTabla = "") {
        parent::obtenerPorId($id, $nombreTabla);
        $this->cambiarTipoPropiedadPorObjetos("categoria", "categorias", "nombre", $this->getCategoria());
    }
    
}