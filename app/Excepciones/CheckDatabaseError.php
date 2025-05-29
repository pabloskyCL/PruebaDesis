<?php

namespace app\Excepciones;

use PDOException;

class CheckDatabaseError
{
    public static function checkCreateProductException(PDOException $error)
    {
        $column = null;

        // si el codigo es 23502, es por que hay un campo obligatorio que no ha sido enviado"
        if ('23502' == $error->getCode()) {
            // se obtiene la columna asociada al error
            preg_match('/columna «([a-zA-Z0-9_]+)»/', $error->getMessage(), $matches);
            if (isset($matches[1])) {
                $column = $matches[1];
            }

            return [
            'error' => 'El campo '.$column.' es obligatorio',
            'code' => $error->getCode(),
            'column' => $column,
            ];
        }

        if ('23505' == $error->getCode()) {
            return [
                'error' => 'El código del producto ya está registrado.',
                'code' => $error->getCode(),
            ];
        }

        if ('23514' == $error->getCode()) {
            preg_match('/restricción «check» «([a-zA-Z0-9_]+)»/', $error->getMessage(), $matches);
            $constraint = isset($matches[1]) ? $matches[1] : null;
            switch ($constraint) {
                case 'check_largo_codigo':
                    return [
                        'error' => 'El codigo debe tener una longitud minima de 5 caracteres y maxima de 15',
                        'code' => $error->getCode(),
                    ];
                case 'check_largo_nombre':
                    return [
                        'error' => 'El nombre debe tener una longitud minima de 2 caracteres y maxima de 50',
                        'code' => $error->getCode(),
                    ];
                case 'check_largo_descripcion':
                    return [
                        'error' => 'La descripcion debe tener una longitud minima de 10 caracteres y maxima de 1000',
                        'code' => $error->getCode(),
                    ];
                case 'check_largo_materiales':
                    return [
                        'error' => 'Debe seleccionar al menos 2 materiales',
                        'code' => $error->getCode(),
                    ];
                case 'check_precio_negativo':
                    return [
                        'error' => 'El precio debe ser mayor a 0',
                        'code' => $error->getCode(),
                    ];
            }
        }
    }
}
