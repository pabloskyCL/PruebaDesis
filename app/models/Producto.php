<?php

namespace app\models;

use app\Dtos\CrearProductoDto;
use app\Excepciones\CheckDatabaseError;

class Producto
{
    private $db;

    public function __construct()
    {
        $this->db = new \Database();
    }

    public function nuevoProducto(CrearProductoDto $data)
    {
        $this->db->initTransaction();
        try {
            $this->db->query('INSERT INTO producto (codigo,nombre,moneda_id,precio,descripcion,materiales)
                 VALUES (:codigo, :nombre,:moneda_id,:precio,:descripcion,:materiales)');
            $this->db->bind(':codigo', $data->codigo);
            $this->db->bind(':nombre', $data->nombre);
            $this->db->bind(':moneda_id', $data->moneda);
            $this->db->bind(':precio', $data->precio);
            $this->db->bind(':descripcion', $data->descripcion);
            '' === $this->db->bind(':materiales', $data->materiales) ? null : $data->materiales;
            $this->db->execute();

            $this->db->query('INSERT INTO producto_sucursal (producto_id,sucursal_id)
                 VALUES (:producto_id, :sucursal_id)');
            $this->db->bind(':producto_id', $data->codigo);
            $this->db->bind(':sucursal_id', $data->sucursal);
        } catch (\PDOException $th) {
            $this->db->cancelTransaction();

            return CheckDatabaseError::checkCreateProductException($th);
        }

        $this->db->execute();
        $this->db->endTransaction();

        return ['success' => 'Producto insertado correctamente'];
    }
}
