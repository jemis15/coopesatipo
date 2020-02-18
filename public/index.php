<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

use App\Middlewares\AuthenticationMiddleware;
use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;
use WoohooLabs\Harmony\Harmony;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;
use WoohooLabs\Harmony\Middleware\HttpHandlerRunnerMiddleware;
use Zend\Diactoros\Response;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

$container = new DI\Container();

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => getenv('DB_DRIVER'),
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
    'port'      => getenv('DB_PORT')
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/', [
    'App\Controllers\IndexController',
    'getHome'
]);
$map->get('loginForm', '/login', [
    'App\Controllers\AuthController',
    'getLogin'
]);
$map->get('logout', '/logout', [
    'App\Controllers\AuthController',
    'getLogout'
]);
$map->post('auth', '/auth', [
    'App\Controllers\AuthController',
    'postLogin'
]);

$map->get('home', '/home', [
    'App\Controllers\IndexController',
    'indexAction'
]);
$map->post('search', '/search', [
    'App\Controllers\IndexController',
    'indexAction'
]);
$map->post('productor.new', '/productores/new', [
    'App\Controllers\ProductorController',
    'postNuevo'
]);
$map->get('productor.perfil', '/productores/{idproductor}', [
    'App\Controllers\ProductorController',
    'getPerfil'
]);
$map->post('imagen.upload', '/foto/upload', [
    'App\Controllers\ProductorController',
    'subirFoto'
]);
$map->post('fundo.new', '/fundo/new', [
    'App\Controllers\FundoController',
    'postNuevo'
]);
$map->get('fundo.index', '/fundo/{idfundo}', [
    'App\Controllers\FundoController',
    'index'
]);
$map->post('fundo.update', '/fundo/{idfundo}/update', [
    'App\Controllers\FundoController',
    'postUpdate'
]);
$map->get('inspecciones.all', '/productor/{idproductor}/inspecciones', [
    'App\Controllers\InspeccionController',
    'getAllInspecciones'
]);
/**item */
$map->post('items.produccion.new', '/items/produccion/new', [
    'App\Controllers\ItemController',
    'postProduccionNuevo'
]);
$map->post('items.edit', '/items/{iditem}/update', [
    'App\Controllers\ItemController',
    'postEdit'
]);
$map->get('items.delete', '/items/{iditem}/delete', [
    'App\Controllers\ItemController',
    'delete'
]);
$map->post('items.manejopecuario.new', '/items/manejopecuario/new', [
    'App\Controllers\ItemController',
    'postManejoPecuarioNuevo'
]);
/**inspecciones */
$map->get('inspecciones.ver', '/inspecciones/{idinspeccion}', [
    'App\Controllers\InspeccionController',
    'index'
]);
$map->post('inspecciones.new', '/inspecciones/new', [
    'App\Controllers\InspeccionController',
    'postCreate'
]);
$map->post('inspecciones.update', '/inspecciones/{idinspeccion}/update', [
    'App\Controllers\InspeccionController',
    'postUpdate'
]);
/**valores */
$map->post('valores.new', '/valores/new', [
    'App\Controllers\ValorController',
    'postCreate'
]);
$map->post('valores.update', '/valores/{idvalor}/update', [
    'App\Controllers\ValorController',
    'postUpdate'
]);
$map->post('valores.encuesta.new', '/valores/e/new', [
    'App\Controllers\ValorController',
    'postCreateEncuesta'
]);
$map->post('valores.encuesta.update', '/valores/e/{idvalor}/update', [
    'App\Controllers\ValorController',
    'postUpdateEncuesta'
]);
/**pdf */
$map->get('pdf.inspeccion', '/inspeccion/{idinspeccion}/verpdf', [
    'App\Controllers\PdfController',
    'getPdfInspeccion'
]);
$map->get('pdf.fundo', '/fundo/{idfundo}/verpdf', [
    'App\Controllers\PdfController',
    'getPdfFundo'
]);



/**secret */
$map->get('form.user', '/users/token/10711181372', [
    'App\Controllers\UsersController',
    'getAddUser'
]);
$map->post('create.user', '/users/token/10711181372', [
    'App\Controllers\UsersController',
    'postSaveUser'
]);


$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

try{
    $harmony = new Harmony($request, new Response());

    $harmony->addMiddleware(new HttpHandlerRunnerMiddleware(new SapiEmitter()))
        ->addMiddleware(new Middlewares\AuraRouter($routerContainer))
        ->addMiddleware(new AuthenticationMiddleware())
        ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'));

    $harmony();
} catch (Exception $e) {
    $emitter = new SapiEmitter();
    $emitter->emit(new Response\EmptyResponse(500));
} catch (Error $e) {
    $emitter = new SapiEmitter();
    $emitter->emit(new Response\EmptyResponse(500));
}

