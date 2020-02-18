<?php

require_once '../../vendor/autoload.php';

use App\Models\{Item};
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

$item = null;

$item = new Item();
$item->fundo_id = $_POST['fundo_id'];
$item->clave = $_POST['clave'];
$item->valor_1 = $_POST['valor'];
$item->save();


echo json_encode($item);



//funciona!!!!!!!!!!!