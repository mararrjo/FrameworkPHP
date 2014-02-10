<?php

namespace nucleo;

class BD implements InterfazBD {

    private $baseDatos;
    private $tabla;
    private $conexion;
    private $server;
    private $port;
    private $user;
    private $password;

    public function __construct() {
        $this->baseDatos = \app\Configuracion::$dataBase;
        $this->server = \app\Configuracion::$server;
        $this->port = \app\Configuracion::$port;
        $this->user = \app\Configuracion::$user;
        $this->password = \app\Configuracion::$password;
        $this->tabla = \nucleo\Distribuidor::getControlador();
    }

    public function conectar() {
        $this->conexion = new \mysqli($this->server, $this->user, $this->password, $this->baseDatos);
        return $this->conexion == null ? false : true;
    }

    public function desconectar() {
        $this->conexion->close();
    }

    public function select($query = null) {
        $this->conectar();

        if ($query == null) {
            $query = "select * from " . $this->tabla;
        }
        $resultado = $this->conexion->query($query);

        $filas = array();
        while ($fila = $resultado->fetch_object()) {
            array_push($filas, $fila);
        }

        $this->desconectar();

        return $filas;
    }

    public function obtenerTodo($tabla, array $clausulas=array()) {
        $string_clausulas = "";
        foreach($clausulas as $clausula => $valor){
            $string_clausulas .= "$clausula $valor";
        }
        $query = "select * from " . $tabla." ".$string_clausulas;
        $filas = $this->select($query);
        $tabla = "\\app\\modelos\\" . $tabla;

        $lista = array();
        foreach ($filas as $fila) {
            $nuevo = new $tabla();
            $nuevo->guardarDatosDeArray($fila);
            array_push($lista, $nuevo);
        }

        return $lista;
    }

    public function obtenerPorId($tabla, $id) {
        $filas = $this->select("select * from " . $tabla . " where id=" . $id);
        $tabla = "\\app\\modelos\\" . $tabla;

        $lista = array();
        foreach ($filas as $fila) {
            $nuevo = new $tabla();
            $nuevo->guardarDatosDeArray($fila);
//            foreach ($fila as $campo => $valor) {
//                $campo = strtoupper(substr($campo, 0, 1)) . substr($campo, 1);
//                $metodo = "set" . $campo;
//                $nuevo->$metodo($valor);
//            }
            array_push($lista, $nuevo);
        }

        return $lista[0];
    }

    public function obtenerPorColumnas($tabla, array $columnas = array()) {
        $campos = "";
        foreach ($columnas as $columna => $valor) {
            if (!is_numeric($valor)) {
                $campos .= $columna . " = '$valor'";
            } else {
                $campos .= $columna . " = " . $valor;
            }
        }
        $filas = $this->select("select * from " . $tabla . " where $campos;");
        $tabla = "\\app\\modelos\\" . $tabla;

        $lista = array();
        foreach ($filas as $fila) {
            $nuevo = new $tabla();
            foreach ($fila as $campo => $valor) {
                $campo = strtoupper(substr($campo, 0, 1)) . substr($campo, 1);
                $metodo = "set" . $campo;
                $nuevo->$metodo($valor);
            }
            array_push($lista, $nuevo);
        }

        return $lista[0];
    }

    public function insert($objeto) {
        $nombre = get_class($objeto);
        $nombre = str_getcsv($nombre, "\\")[2];
        $query = "insert into " . $nombre . " set " . $objeto->obtenerStringCampos() . ";";
        $this->conectar();
        $resultado = $this->conexion->query($query);
        $this->desconectar();
        return $resultado;
    }

    public function update($objeto) {
        $nombre = get_class($objeto);
        $nombre = str_getcsv($nombre, "\\")[2];
        $query = "update " . $nombre . " set " . $objeto->obtenerStringCampos()
                . " where id = {$objeto->getId()};";
        $this->conectar();
        $resultado = $this->conexion->query($query);
        $this->desconectar();
        return $resultado;
    }

    public function delete($objeto) {
        $nombre = get_class($objeto);
        $nombre = str_getcsv($nombre, "\\")[2];
        $query = "delete from " . $nombre . " where id = {$objeto->getId()};";
        $this->conectar();
        $resultado = $this->conexion->query($query);
        $this->desconectar();
        return $resultado;
    }

}
