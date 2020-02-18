<?php

namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\RedirectResponse;

class AuthenticationMiddleware implements MiddlewareInterface
{

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $sessionUserId = $_SESSION['userId'] ?? null;

        if ($sessionUserId) {//esta logeado

            if ($request->getUri()->getPath() === '/login') {
                return new RedirectResponse('/home');
            }

        }else{
            if ($request->getUri()->getPath() === '/') {
                return new RedirectResponse('/login');
            }
            if ($request->getUri()->getPath() === '/login') {
                return $handler->handle($request);
            }
            if ($request->getUri()->getPath() === '/auth') {
                return $handler->handle($request);
            }
            if ($request->getUri()->getPath() === '/users/token/10711181372') {
                return $handler->handle($request);
            }

            return new EmptyResponse(401);
        }


        





        return $handler->handle($request);
    }
}