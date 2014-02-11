<?php

namespace nucleo;

class Clase_base {

    /**
     * Devuelve un array con las propiedades del objeto y sus valores, que tengan
     * su método get. Se le puede pasar un array con los campos que se quieren
     * obtener.
     * 
     * @param array $campos Es un array con los campos que se quieren obtener.
     * Debe ser de la forma array("campo1"=>"","campo2"=>""). Si no se aporta se
     * obtendras todos los campos del objeto.
     * @return array Array con las propiedades del objeto.
     */
    public function obtenerArrayCampos(array $campos = array()) {
        if ($campos == null) {
            $metodos = get_class_methods(get_class($this));
            $campos = array();
            foreach ($metodos as $metodo) {
                if (stristr($metodo, "get")) {
                    $campos[strtolower(str_replace("get", "", $metodo))] = $this->$metodo();
                }
            }
            return $campos;
        } else {
            $arrayDatos = array();
            foreach ($campos as $clave => $tipo) {
                $atributo = "get" . strtoupper(substr($clave, 0, 1)) . substr($clave, 1);
                if (method_exists($this, $atributo)) {
                    $arrayDatos[$clave] = $this->$atributo();
                }
            }
            $arrayDatos["id"] = $this->getId();
            return $arrayDatos;
        }
    }

    public function obtenerStringCampos() {
        $metodos = get_class_methods(get_class($this));
        $campos = "";
        foreach ($metodos as $indice => $metodo) {
            if (stristr($metodo, "get")) {
                $valor = $this->$metodo();
                if (is_array($valor)) {
//                    $valores = "";
//                    foreach ($valor as $indice => $v) {
//                        if ($indice < count($valor) - 1) {
//                            $valores .= $v . "|";
//                        } else {
//                            $valores .= $v;
//                        }
//                    }
//                    $valor = $valores;
                    $valor = serialize($valor);
                }
                if (!is_numeric($valor)) {
                    $valor = "'$valor'";
                }
                $campos .= strtolower(str_replace("get", "", $metodo)) . " = " . $valor . ", ";
            }
        }
        $campos = substr($campos, 0, count($campos) - 3);
        return $campos;
    }

    /**
     * Guarda los datos del array en el objeto en sus respectivos campos.
     * 
     * @param array $datos El array con los campos y sus valores. De la forma
     * array("campo1"=>"valor1","campo2"=>"valor2")
     */
    public function guardarDatosDeArray($datos) {
        foreach ($datos as $campo => $valor) {
            $campo = strtoupper(substr($campo, 0, 1)) . substr($campo, 1);
            $metodo = "get" . $campo;
            $es_array = $this->$metodo();
            if (is_array($es_array) and !is_array($valor)) {
//                $valor = str_getcsv($valor, "|");
                $valor = unserialize($valor);
            }
            $metodo = "set" . $campo;
            if (method_exists($this, $metodo)) {
                $this->$metodo($valor);
            }
        }
    }

    /**
     * 
     * @param string $campoObjeto Propiedad del objeto
     * @param string $tabla Nombre de la tabla de la que se quieren obtener los datos
     * @param string $campoTabla Propiedad de la tabla de la que se quiere obtener los datos
     * @param mixed $datos Valor o valores que se pasan para obtener los datos de la tabla
     */
    public function cambiarTipoPropiedadPorObjetos($campoObjeto, $tabla, $campoTabla, $datos) {

        $bd = new \nucleo\BD();
        $objetos = $bd->obtenerPorColumna($tabla, array($campoTabla => $datos));
        $metodo = "set" . strtoupper(substr($campoObjeto, 0, 1)) . substr($campoObjeto, 1);
        $this->$metodo($objetos);
    }

}
