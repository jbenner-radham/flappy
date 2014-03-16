<?php

$loader = new \Phalcon\Loader;

/**
 * We're a registering a set of directories taken from the configuration file
 */
$dirs = [
    $config->application->controllersDir,
    $config->application->modelsDir
];

$namespaces = [
    'Flappy\Controllers' => $config->application->controllersDir,
    'Flappy\Models'      => $config->application->modelsDir
];

#$loader->registerDirs($dirs);
$loader->registerNamespaces($namespaces);

$loader->register();

#echo $loader->getCheckedPath();
