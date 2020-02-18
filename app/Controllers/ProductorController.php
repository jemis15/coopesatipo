<?php
namespace App\Controllers;

use App\Models\{Productor,Imagen,Fundo};
use Respect\Validation\Validator as v;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class ProductorController extends BaseController {

    public function postNuevo($request) {

        $postData = $request->getParsedBody();

        $productor = new Productor();
        $productor->nom_ape = $postData['nom_ape'];
        $productor->dni = $postData['documento'];
        $productor->departamento = $postData['departamento'];
        $productor->provincia = $postData['provincia'];
        $productor->distrito = $postData['distrito'];
        $productor->save();

        return new RedirectResponse('/home');
    }

    public function getPerfil(ServerRequest $request)
    {
        $productor = Productor::find($request->getAttribute('idproductor'));
        $fotos = Imagen::where('productor_id','=',$productor->productor_id)->get();
        $fundo = Fundo::where('productor_id','=',$productor->productor_id)->first();

        return $this->renderHTML('productor/perfil.twig',[
            'productor' => $productor,
            'fotos' => $fotos,
            'fundo' => $fundo
        ]);
    }





    // esto no deveria estar aqui
    public function subirFoto(ServerRequest $request)
    {
        try {
            $postData = $request->getParsedBody();

            $files = $request->getUploadedFiles();
            $logo = $files['foto'];

            if($logo->getError() == UPLOAD_ERR_OK) {
                $fileName = $logo->getClientFilename();
                $fullPath = "uploads/$fileName";

                $logo->moveTo($fullPath);
            }

            $foto = new Imagen();
            $foto->nombre = $fullPath;
            $foto->productor_id = $postData['productor'];
            $foto->save();

            return new RedirectResponse('/productores/' . $postData['productor']);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}