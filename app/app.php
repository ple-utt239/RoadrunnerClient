<?php

use Roadrunner\Controller\DeliveryController;
use Symfony\Component\BrowserKit\Response;

use Roadrunner\Controller\ItemController;
use Roadrunner\Controller\LogController;
use Roadrunner\Controller\UserController;

/**
 * Root controller
 */
$app->get('/', array(new ItemController($app), 'executeIndex'));

/**
 * Item controller
 */
$app->get('/item/add', array(new ItemController($app), 'executeAdd'));
$app->get('/item/view/{id}', array(new ItemController($app), 'executeView'));
$app->get('/item/list', array(new ItemController($app), 'executeList'));
$app->post('/item/create', array(new ItemController($app), 'executeCreate'));

/**
 * Log controller
 */
$app->get('/log/list/{itemId}', array(new LogController($app), 'executeList'));

/**
 * Delivery controller 
 */
$app->get('/delivery/list', array(new DeliveryController($app), 'executeList'));
$app->get('/delivery/view/{id}', array(new DeliveryController($app), 'executeView'));
$app->get('/delivery/add', array(new DeliveryController($app), 'executeAdd'));
$app->post('/delivery/create', array(new DeliveryController($app), 'executeCreate'));

/*
 * User controller
 */
$app->get('/user/list', array(new UserController($app), 'executeList'));
$app->get('/user/add', array(new UserController($app), 'executeAdd'));
$app->get('/user/create', array(new UserController($app), 'executeCreate'));

/**
 * Error controller
 */
$app->error(function(Exception $e) use ($app) {
	if ($e instanceof NotFoundHttpException) {
		return new Response('What you are looking for does not exist', 404);
	}
	
	if (ENV != 'DEV') {
		$app['log']->addError(json_encode(array(
			'class'   => get_class($e),
			'message' => $e->getMessage(),
			'code'    => $e->getCode(),
			)));
	} else {
		echo '<pre>';
		print $e->getMessage() . "\n";
		debug_print_backtrace();
	}
	
	return new Response('Something bad happend.', 500);
});

/**
 * After controller
 */ 
$app->after(function() {	
});

$app->run();