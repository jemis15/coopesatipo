<?php
namespace App\Controllers;

use App\Models\{Item};
use Respect\Validation\Validator as v;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class ItemController extends BaseController {

    public function postProduccionNuevo(ServerRequest $request)
    {
        $postData = $request->getParsedBody();

        $item = new Item();
        $item->fundo_id = $postData['fundo'];
        $item->clave = 'produccion';
        $item->valor_1 = $postData['produccion'];
        $item->valor_2 = $postData['superficie_anterior'];
        $item->valor_3 = $postData['superficie_actual'];
        $item->valor_4 = $postData['num_parcela'];
        $item->save();

        return new RedirectResponse('/fundo/' . $postData['fundo']);
    }

    public function postManejoPecuarioNuevo(ServerRequest $request)
    {
        $postData = $request->getParsedBody();

        $item = new Item();
        $item->fundo_id = $postData['fundo'];
        $item->clave = 'manejo pecuario';
        $item->valor_1 = $postData['item'];
        $item->valor_2 = $postData['cantidad'];
        $item->valor_3 = $postData['unidad'];
        $item->save();

        return new RedirectResponse('/fundo/' . $postData['fundo']);
    }

    public function postEdit(ServerRequest $request)
    {
        $postData = $request->getParsedBody();

        $item = Item::find($request->getAttribute('iditem'));
        $item->clave = $postData['clave'];
        $item->valor_1 = $postData['valor_1'];
        $item->valor_2 = $postData['valor_2'];
        $item->valor_3 = $postData['valor_3'];
        $item->valor_4 = $postData['valor_4'];
        $item->save();

        return new RedirectResponse('/fundo/' . $item->fundo_id);
    }

    public function delete(ServerRequest $request)
    {
        $item = Item::find($request->getAttribute('iditem'));
        $item->delete();

        return new RedirectResponse('/fundo/' . $item->fundo_id);
    }
}