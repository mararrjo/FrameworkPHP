<?php

namespace app\modelos;

class carrito extends \nucleo\Clase_base {

    private $id = 0;
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

    public function obtenerArticulosString() {
        $articulos = "";
        foreach ($this->articulos as $articulo) {
            $articulos .= $articulo . " ";
        }
        return $articulos;
    }

    public function __toString() {
        return $this->usuario;
    }

    public function obtenerPorId($id, $nombreTabla = "") {
        $existe = parent::obtenerPorId($id, $nombreTabla);
        $this->cambiarTipoPropiedadPorObjetos("articulos", "articulos", "id", $this->getArticulos());
        return $existe;
    }

    public function obtenerTodo(array $clausulas = array(), $nombreTabla = "") {
        $cosas = parent::obtenerTodo($clausulas, $nombreTabla);
        $lista = array();
        foreach ($cosas as $cosa) {
            $cosa->cambiarTipoPropiedadPorObjetos("articulos", "articulos", "id", $cosa->getArticulos());
            array_push($lista, $cosa);
        }
        return $lista;
    }

//    public function obtenerTodo(array $clausulas=array(),$nombreTabla = "") {
//        $existe = parent::obtenerTodo();
//        var_dump($this);
//        $this->cambiarTipoPropiedadPorObjetos("articulos", "articulos", "id", $this->getArticulos());
//        return $existe;
//    }
}
