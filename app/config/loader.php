<?php

namespace RadHam;

$loader = new \Phalcon\Loader;

/**
 * We're a registering a set of directories taken from the configuration file
 */
$dirs = [
    $config->application->controllersDir,
    $config->application->modelsDir
];

$namespaces = [
    'RadHam' => $config->application->controllersDir,
    'RadHam\Models'      => $config->application->modelsDir
];

//$loader->registerDirs($dirs);
$loader->registerNamespaces($namespaces);

$loader->register();

#echo $loader->getCheckedPath();
