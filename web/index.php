<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/views/',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'pruebas',
        'user'      => 'root',
        'password'  => 'root',
        'charset'   => 'utf8',
    ),
));


$app->get('/users', function() use ($app) {

	$sql = 'SELECT u.id, u.usuario, u.clave, u.activo, r.descripcion AS rol FROM usuarios AS u INNER JOIN roles AS r ON r.id = u.rol';

	$users = $app['db']->fetchAll($sql);

	return $app['twig']->render('index.twig', array(
		'users' => $users
	));

});

$app->get('/users/edit/{id}', function($id) use ($app){
	$sql = 'SELECT * FROM usuarios WHERE id = ?';
	$user = $app['db']->fetchAssoc($sql, array((int)$id));

	return $app['twig']->render('users/edit.twig', array(
		'user' => $user
	));
});

$app->run();