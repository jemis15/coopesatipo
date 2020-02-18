<?php
namespace App\Controllers;

use App\Models\{Valor};
use Respect\Validation\Validator as v;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class ValorController extends BaseController {

    public function postCreate($request) {

        $postData = $request->getParsedBody();

        $valor = new Valor();
        $valor->inspeccion_id = $postData['id'];
        $valor->clave = $postData['clave'];
        $valor->valor_1 = $postData['valor'];
        $valor->save();

        return new RedirectResponse('/inspecciones/' . $valor->inspeccion_id);
    }

    public function postUpdate($request) {

        $postData = $request->getParsedBody();

        $valor = Valor::find($request->getAttribute('idvalor'));
        $valor->valor_1 = $postData['valor'];
        $valor->save();

        return new RedirectResponse('/inspecciones/' . $valor->inspeccion_id);
    }

    public function postCreateEncuesta($request) {

        $postData = $request->getParsedBody();

        $valor = new Valor();
        $valor->inspeccion_id = $postData['id'];
        $valor->clave = $postData['clave'];
        $valor->valor_1 = $postData['no_aplica'];//no aplica
        $valor->valor_2 = $postData['si'];//si o no
        $valor->valor_3 = $postData['observacion'];//observacion
        $valor->save();

        return new RedirectResponse('/inspecciones/' . $valor->inspeccion_id);
    }

    public function postUpdateEncuesta($request) {

        $postData = $request->getParsedBody();

        $valor = Valor::find($request->getAttribute('idvalor'));
        $valor->valor_1 = $postData['no_aplica'];
        $valor->valor_2 = $postData['si'];
        $valor->valor_3 = $postData['observacion'];
        $valor->save();

        return new RedirectResponse('/inspecciones/' . $valor->inspeccion_id);
    }

}