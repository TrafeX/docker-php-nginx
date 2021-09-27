<?php

use DI\ContainerBuilder;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require '../../vendor/autoload.php';

require '../models/Product.php';
require '../models/ProductModel.php';
require_once '../services/ProductService.php';

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set('upload_directory', __DIR__ . '/images');

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->get('/products', function (Request $request, Response $response, $args) {
  $response->getBody()->write(ProductService::getAll());
  return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/search/{term}', function (Request $request, Response $response, $args) {
	$productName = $args['term'];
	$response->getBody()->write(ProductService::getByName($productName));
	return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/products/{id:[0-9]+}', function (Request $request, Response $response, $args) {
  $id = $args['id'];
  $response->getBody()->write(ProductService::getById($id));
  return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/products', function (Request $request, Response $response, $args) {
  $body = $request->getParsedBody();
  $directory = $this->get('upload_directory');
  $uploadedFile = $request->getUploadedFiles()['imageUrl'];

  $response->getBody()->write(ProductService::insert($body, $directory, $uploadedFile));
  return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
