<?php
namespace nucleo;

interface InterfazBD {
    public function conectar();
    public function select($query=null);
    public function desconectar($c);
}