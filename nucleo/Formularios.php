<?php

namespace nucleo;

class Formularios {

    /**
     *
     * @var array $campos Contiene los campos que se mostraran en el formulario
     * con su tipo y parametros.
     */
    protected $campos = array();

    /**
     *
     * @var array $datos Contiene los datos de los campos del formulario con 
     * sus valores 
     */
    protected $datos = array();
    protected $nombre_clase;

    public function __construct($objeto = null) {

        $this->configuracion();
        if ($objeto) {
            $this->datos = $objeto->obtenerArrayCampos($this->campos);
        }
        $this->nombre_clase = str_getcsv(get_class($this), "_")[1];
    }

    /**
     * Metodo que sirve para configurar los campos que van a tener los formularios.
     * 
     */
    public function configuracion() {
        
    }

    public function setCampos(array $campos) {
        $this->campos = $campos;
    }

    public function obtenerCampos() {
        return $this->campos;
    }

    public function obtenerDatos() {
        return $this->datos;
    }

    public function procesarFormulario(array $request, &$clase) {
        $arrayDatos = array();
        foreach ($this->campos as $clave => $tipo) {
            if (isset($request[$clave])) {
                $arrayDatos[$clave] = $request[$clave];
            }
        }
        if (isset($request["id"])) {
            $arrayDatos["id"] = $request["id"];
        }
        $this->datos = $arrayDatos;

        //Hacer validacion aqui

        $clase->guardarDatosDeArray($this->datos);
    }

    public function renderizarFormulario($action = "") {
        $id = isset($this->datos["id"]) ? $this->datos["id"] : "";
        if ($action) {
            $accion = $action;
        } else {
            $accion = \nucleo\URL::ruta(array(\nucleo\Distribuidor::getControlador(), \nucleo\Distribuidor::getMetodo() . "_validar", $id));
        }
        $form = "<form action='" . $accion . "'  class='formulario' name='form_" . $this->nombre_clase . "_" . \nucleo\Distribuidor::getMetodo() . "' method='post'>";
        
        if (isset($this->datos["id"])) {
            $form .= \nucleo\Widgets::hidden("id", $id);
        }
        foreach ($this->campos as $campo => $parametros) {
            $value = isset($this->datos[$campo]) ? $this->datos[$campo] : "";
            $form .= "<div class='campo_" . $this->nombre_clase . "'>";
            if (!is_array($parametros)) {
                $tipo = $parametros;
                $form .= \nucleo\Widgets::$tipo($campo, $value);
            } else {
                $tipo = $parametros["type"];
                $form .= \nucleo\Widgets::$tipo($campo, $value, $parametros);
            }
            $form .= "</div>";
        }

        $form .= "</form>";
        return $form;
    }

}
