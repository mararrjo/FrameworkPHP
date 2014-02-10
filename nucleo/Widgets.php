<?php

namespace nucleo;

class Widgets {

    private static function crearInput($tipo, $campo, $value = "", array $parametros = NULL) {
        if ($parametros) {
            if (isset($parametros["label"])) {
                $label = $parametros["label"];
                unset($parametros["label"]);
            } else {
                $label = $campo;
            }
            $string_parametros = "";
            foreach ($parametros as $parametro => $valor) {
                $string_parametros .= $parametro . "='" . $valor . "' ";
            }
            return $label . ": <input " . $string_parametros . " name='$campo' id='$campo' class='input_" . \nucleo\Distribuidor::getControlador() . "' value='" . $value . "'><br>";
        } else {
            return $campo . ": <input type='$tipo' name='$campo' id='$campo' class='input_" . \nucleo\Distribuidor::getControlador() . "' value='" . $value . "'><br>";
        }
    }

    private static function crearBoton($tipo, $campo, $value = "", array $parametros = NULL) {
        if ($parametros) {
            if (isset($parametros["label"])) {
                $label = $parametros["label"];
                unset($parametros["label"]);
            } else {
                $label = $campo;
            }
            $string_parametros = "";
            foreach ($parametros as $parametro => $valor) {
                $string_parametros .= $parametro . "='" . $valor . "' ";
            }
            return "<input type='$tipo' name='b_$campo' id='b_$campo' class='input_" . \nucleo\Distribuidor::getControlador() . "' value='" . $label . "'><br>";
        } else {
            return "<input type='$tipo' name='b_$campo' id='b_$campo' class='input_" . \nucleo\Distribuidor::getControlador() . "' value='" . $value . "'><br>";
        }
    }

    public static function hidden($campo, $value = "", array $parametros = NULL) {
        return "<input type='hidden' name='$campo' id='$campo' value='$value' >";
    }

    public static function text($campo, $value = "", array $parametros = NULL) {
        return self::crearInput("text", $campo, $value, $parametros);
    }

    public static function number($campo, $value = "", array $parametros = NULL) {
        return self::crearInput("number", $campo, $value, $parametros);
    }

    public static function button($campo, $value = "", array $parametros = NULL) {
        return self::crearBoton("button", $campo, $campo, $parametros);
    }

    public static function submit($campo, $value = "", array $parametros = NULL) {
        return self::crearBoton("submit", $campo, $campo, $parametros);
    }

    public static function seleccion($campo, $value = "", array $parametros = null){
        if(!is_array($parametros["opciones"])){
            $opciones = array();
            $bd = new \nucleo\BD();
            $objetos = $bd->obtenerTodo($parametros["opciones"]);
            foreach($objetos as $objeto){
                array_push($opciones, $objeto);
            }
            $parametros["opciones"] = $opciones;
        }
        $expandido = isset($parametros["expandido"]) ? ($parametros["expandido"] ? "expandido" : "") : "";
        if($expandido){
            return self::radio($campo, $value, $parametros);
        }else{
            return self::select($campo, $value, $parametros);
        }
    }
    
    public static function select($campo, $value = "", array $parametros = null) {
        if (isset($parametros["label"])) {
            $label = $parametros["label"];
            unset($parametros["label"]);
        } else {
            $label = $campo;
        }
        $input = "";
        $input .= $label . ":<br>";
        $input .= isset($parametros["multiple"]) ? 
                ($parametros["multiple"] ? "<select name='".$campo."[]' multiple>" : "<select name='$campo'>") : "<select name='$campo'>";
        foreach ($parametros["opciones"] as $opcion) {
            if (strtolower($value) == strtolower($opcion))
                $input .= "<option value='$opcion' selected>$opcion</option>";
            else
                $input .= "<option value='$opcion'>$opcion</option>";
        }
        $input .= "</select>";
        return $input;
    }

    public static function radio($campo, $value = "", array $parametros = NULL) {
        if (isset($parametros["label"])) {
            $label = $parametros["label"];
            unset($parametros["label"]);
        } else {
            $label = $campo;
        }
        $multiple = isset($parametros["multiple"]) ? ($parametros["multiple"] ? "multiple" : "") : "";
        $input = "";
        $input .= $label . ":<br>";
        foreach ($parametros["opciones"] as $opcion) {
            if (!$multiple) {
                if (strtolower($value) == strtolower($opcion))
                    $input .= "<input type='radio' name='$campo' value='$opcion' checked>$opcion";
                else
                    $input .= "<input type='radio' name='$campo' value='$opcion'>$opcion";
            } else {
                if (strtolower($value) == strtolower($opcion))
                    $input .= "<input type='checkbox' name='$campo' value='$opcion' checked>$opcion";
                else
                    $input .= "<input type='checkbox' name='$campo' value='$opcion'>$opcion";
            }
        }
        return $input;
    }

}
