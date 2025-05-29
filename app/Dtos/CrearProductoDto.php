<?php

namespace app\Dtos;

class CrearProductoDto
{
    public function __construct(
        public string $codigo,
        public string $nombre,
        public int $bodega,
        public int $sucursal,
        public string $materiales,
        public int $moneda,
        public float $precio,
        public string $descripcion,
    ) {
        

    }

    
}
