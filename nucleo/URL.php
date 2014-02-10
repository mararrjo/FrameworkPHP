<?php

namespace nucleo;

class URL {

    public static function ruta(array $parametros = array()) {

        $ruta = "";

        foreach ($parametros as $index => $parametro) {
            if ($index < count($parametros) - 1)
                $ruta .= $parametro . "/";
            else
                $ruta .= $parametro;
        }
        return URL . $ruta;
    }
    
}
