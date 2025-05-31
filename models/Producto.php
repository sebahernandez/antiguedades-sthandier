<?php
class Producto {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $categoria;
    public $estado_reserva;

    public function __construct($id, $nombre, $descripcion, $precio, $categoria, $estado_reserva) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->categoria = $categoria;
        $this->estado_reserva = $estado_reserva;
    }
}
