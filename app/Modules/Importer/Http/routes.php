<?php

$NS = MODULES_NS.'Importer\Http\Controllers\\';

$router->name('importer.')->group(function () use ($router, $NS) {
    $router->get('importer/import', $NS.'ImporterController@import');
});

$router->resource('importers', $NS.'ImporterController');

