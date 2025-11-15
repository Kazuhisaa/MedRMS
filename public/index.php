<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Siguraduhin mong nandito pa rin 'to
$app->setBasePath('/medrms/public');

// Enable error middleware for debugging
$app->addErrorMiddleware(true, true, true);

// Load routes
(require __DIR__ . '/../src/Routes/medicines.php')($app);

$app->run();