<?php

require_once '../../vendor/autoload.php';

use App\Models\{Valor};
use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

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


/** operaciones */

$valor = null;

if (empty($_POST['id'])) {
    echo "el id esta vacio";
    die();
}

$valor = Valor::find($_POST['id']);
$valor->delete();


echo 'El registro ' . $valor->valor_id . ' a sido eliminado';

//funciona!!!!!!!!!!!