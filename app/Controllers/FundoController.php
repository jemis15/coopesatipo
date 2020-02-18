<?php
namespace App\Controllers;

use App\Models\{Fundo,Productor,Item};
use Respect\Validation\Validator as v;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class FundoController extends BaseController {

    public function index(ServerRequest $request)
    {
        $fundo = Fundo::find($request->getAttribute('idfundo'));
        $productor = Productor::find($fundo->productor_id);
        $items = Item::where('fundo_id','=',$fundo->fundo_id)->get();

        return $this->renderHTML('/fundo/index.twig',[
            'fundo' => $fundo,
            'productor' => $productor,
            'items' => $items
        ]);
    }

    public function postNuevo(ServerRequest $request) {

        $postData = $request->getParsedBody();

        $fundo = new Fundo();
        $fundo->productor_id = $postData['productor'];
        $fundo->nombre = $postData['nombre'];
        $fundo->save();

        return new RedirectResponse('/fundo/' . $fundo->fundo_id);
    }

    public function postUpdate(ServerRequest $request)
    {
        $postData = $request->getParsedBody();
        // print_r($postData);die();
        $fundo = Fundo::find($request->getAttribute('idfundo'));
        $fundo->nombre = $postData['nombre'];
        $fundo->ubicacion = $postData['ubicacion'];
        $fundo->distancia = $postData['distancia'];
        $fundo->altitud = $postData['altitud'];
        $fundo->precipitacion = $postData['precipitacion'];
        $fundo->temperatura = $postData['temperatura'];
        $fundo->norte = $postData['norte'];
        $fundo->este = $postData['este'];
        $fundo->save();

        return new RedirectResponse('/fundo/' . $fundo->fundo_id);
    }
}