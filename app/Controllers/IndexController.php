<?php

namespace App\Controllers;

use App\Models\Productor;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class IndexController extends BaseController 
{
    public function indexAction(ServerRequest $request) {

        $postData = null;
        $productores = null;
        $search = null;

        if ($request->getMethod() === 'POST') {
            $postData = $request->getParsedBody();

            $search = $postData['search'];
            $productores = Productor::where('dni','like', '%' . $search . '%' )->get();
        }else {
            $productores = Productor::all();
        }


        return $this->renderHTML('home.twig', [
            'productores' => $productores,
            'search' => $search
        ]);
    }

    public function getHome()
    {
        return new RedirectResponse('/home');
    }
}