<?php

namespace nucleo;

class BD implements InterfazBD {

    public function conectar() {
        return mysqli_connect(\app\Configuracion::$server, \app\Configuracion::$user, \app\Configuracion::$password, \app\Configuracion::$dataBase);
    }

    public function desconectar($c) {
        return mysqli_close($c);
    }

    public function consulta($query) {
        if ($conexion = $this->conectar()) {
            $resultado = mysqli_query($conexion, $query);
            $this->desconectar($conexion);
//            echo "Consulta: ".$query."<br>";
            return $resultado;
        } else {
            throw new \Exception("Error al conectar con la base de datos");
        }
    }

    public function select($query = null) {
        if ($c = $this->conectar()) {
            $namespace_tabla = get_class($this);
            $t = str_getcsv($namespace_tabla, "\\");
            $tabla = $t[count($t) - 1];
            if ($query == null) {
                $query = "select * from " . $tabla;
            }
            $resultado = mysqli_query($c, $query);
            $filas = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                array_push($filas, $fila);
            }

            $this->desconectar($c);
//            echo "Select: ".$query."<br>";
            return $filas;
        } else {
            throw new \Exception("Error al conectar con la base de datos");
        }
    }

    public function obtenerTodo(array $clausulas = array(), $nombreTabla = "") {
        if (!$nombreTabla) {
            $namespace_tabla = get_class($this);
            $tabla = str_getcsv($namespace_tabla, "\\")[2];
        } else {
            $tabla = $nombreTabla;
        }
        $string_clausulas = "";
        foreach ($clausulas as $clausula => $valor) {
            $string_clausulas .= "$clausula $valor";
        }
        $query = "select * from " . $tabla . " " . $string_clausulas;
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

    public function obtenerPorId($id, $nombreTabla = "") {
        if (!$nombreTabla) {
            $namespace_tabla = get_class($this);
            $tabla = str_getcsv($namespace_tabla, "\\")[2];
        } else {
            $tabla = $nombreTabla;
        }
        $filas = $this->select("select * from " . $tabla . " where id=" . $id);
        foreach ($filas as $fila) {
            $this->guardarDatosDeArray($fila);
        }
        if($nombreTabla){
            return $this;
        }
        if (count($filas) > 0)
            return true;
        else
            return false;
    }

    /**
     * Obtiene un objeto pasando como parametro un array con la columna
     * 
     * @param string $tabla La tabla que sera consultada
     * @param array $columnas Array con el nombre de la columna y su valor.
     * @return array Con las filas obtenidas.
     */
    public function obtenerPorColumna($tabla, array $columna) {
        $campos = "";
        $nombreColumna = key($columna);
        $valor = $columna[$nombreColumna];
        if (is_array($valor)) {
            $lista = array();
            $conexion = $this->conectar();
            foreach ($valor as $v) {
                $resultado = $conexion->query("select * from " . $tabla . " where $nombreColumna = '$v'");
                $obj = mysqli_fetch_object($resultado);
                $t = "\\app\\modelos\\" . $tabla;
                $nuevo = new $t();
                $nuevo->guardarDatosDeArray($obj);
                $lista[$nuevo->getId()] = $nuevo;
//                array_push($lista,$nuevo);
            }
            $this->desconectar($conexion);
//            echo "Por columnas: select * from " . $tabla . " where $nombreColumna = '$v'<br>";
            return $lista;
        } elseif (!is_numeric($valor)) {
            $campos .= $nombreColumna . " = '$valor'";
        } else {
            $campos .= $nombreColumna . " = " . $valor;
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

    public function insert($objeto = null) {
        if ($objeto) {
            $nombre = get_class($objeto);
            $nombre = str_getcsv($nombre, "\\")[2];
        } else {
            $nombre = get_class($this);
            $nombre = str_getcsv($nombre, "\\")[2];
            $objeto = $this;
        }
        $query = "insert into " . $nombre . " set " . $objeto->obtenerStringCampos() . ";";
        return $this->consulta($query);
    }

    public function update($objeto = null) {
        if ($objeto) {
            $nombre = get_class($objeto);
            $nombre = str_getcsv($nombre, "\\")[2];
        } else {
            $nombre = get_class($this);
            $nombre = str_getcsv($nombre, "\\")[2];
            $objeto = $this;
        }
        $query = "update " . $nombre . " set " . $objeto->obtenerStringCampos()
                . " where id = {$objeto->getId()};";
        return $this->consulta($query);
    }

    public function delete($objeto = null) {
        if ($objeto) {
            $nombre = get_class($objeto);
            $nombre = str_getcsv($nombre, "\\")[2];
        } else {
            $nombre = get_class($this);
            $nombre = str_getcsv($nombre, "\\")[2];
            $objeto = $this;
        }
        $query = "delete from " . $nombre . " where id = {$objeto->getId()};";
        return $this->consulta($query);
    }

    public function existe() {
        $namespace_tabla = get_class($this);
        $tabla = str_getcsv($namespace_tabla, "\\")[2];
        $filas = $this->select("select id from $tabla where id = ".$this->getId());
        return count($filas) ? true : false;
    }

    public function persistir() {
        if ($this->existe()) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

}
