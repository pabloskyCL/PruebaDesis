<?php

namespace app\controllers;

use app\consts\EMessages;
use app\Dtos\CrearProductoDto;
use app\Http\Response;
use app\models\Bodega;
use app\models\Moneda;
use app\models\Producto;
use src\router\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $data = [];
        $bodegaModel = new Bodega();
        $monedaModel = new Moneda();

        $data['bodegas'] = $bodegaModel->getAll();
        $data['monedas'] = $monedaModel->getAll();

        $response = new Response(EMessages::CORRECT, data: $data);

        return $this->view('index', [
            'data' => $response->data,
            'code' => $response->code,
            'message' => $response->message,
        ]);
    }

    public function create(Request $request)
    {
        $chks = ['plastico' => $request->plastico ? true : false,
                    'madera' => $request->madera ? true : false,
                    'metal' =>  $request->metal ? true : false,
                    'vidrio' => $request->vidrio ? true : false,
                    'textil' => $request->textil ? true : false,
        ];

        $checked = array_filter($chks, function ($k) {
            return true == $k;
        });

        $crearProductoDto = new CrearProductoDto(
            $request->codigo,
            $request->nombre,
            $request->bodega,
            intval($request->sucursal),
            join(',', array_keys($checked)),
            intval($request->moneda),
            intval($request->precio),
            $request->descripcion,
        );

        $producto = new Producto();

        $result = $producto->nuevoProducto($crearProductoDto);
        header('Content-Type: application/json');
        if (isset($result['error'])) {
            $response = new Response(500, EMessages::ERROR);
            $response->setData($result);
            echo $response->json();

            return;
        }
        $response = new Response(201,EMessages::CORRECT);
        $response->setData($result);
        echo $response->json();
    }
}
