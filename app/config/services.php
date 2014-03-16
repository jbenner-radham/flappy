<?php

namespace RadHam;

use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
#$di = new FactoryDefault();
$di = new \Phalcon\DI;

/**
 * Router
 *  -->> $di['router']->removeExtraSlashes(true); <<--
 *
 * Here's an adjustment for anyone that encounters the same problem to remove the trailing slash in the bootstrap .htaccess *
 *
 * ```
 * RewriteEngine On
 * RewriteRule ^(.*)/$ http://%{HTTP_HOST}/$1 [QSA,L]
 * RewriteCond %{REQUEST_FILENAME} !-d
 * RewriteCond %{REQUEST_FILENAME} !-f
 * RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
 * ```
 *
 *  @see http://forum.phalconphp.com/discussion/1302/namespace-routes-solved-
 */
$di->set('router', function () {
    return new \Phalcon\Mvc\Router;
});

/**
 * HTTP Response
 */
$di->set('response', function () {
    return new \Phalcon\Http\Response;
});

/**
 * HTTP Request
 */
$di->set('request', function () {
    #return new \Phalcon\HttpRequest;
    return new \Phalcon\Http\Request;
});

/**
 * Configure our dispatcher
 */
$di->set('dispatcher', function () use (&$loader) {
    $events_manager = new \Phalcon\Events\Manager;

    #//Camelize actions
    #$eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {
    #    $dispatcher->setActionName(Text::camelize($dispatcher->getActionName()));
    #});

    $events_manager->attach('dispatch:beforeDispatch', function ($event, $dispatcher) use (&$loader) {
        var_dump($event);
        var_dump($dispatcher);
        var_dump($loader);

        echo '1111';
        echo $dispatcher->getControllerClass();
        echo '1111';

        echo '---------------';
        var_dump($loader->getExtensions());
        var_dump($loader->getDirs());
        var_dump($loader->getNamespaces());
        var_dump($loader->getCheckedPath());
        var_dump($loader->getFoundPath());
        echo '----------------';
        echo $dispatcher->getControllerName(); // "index" for well index...
        echo $dispatcher->getControllerClass();

        //var_dump($loader->autoLoad('ControllerBase'));
        //var_dump($loader->autoLoad('IndexController'));
        exit;
    });


    $dispatcher = new \Phalcon\Mvc\Dispatcher;
    $dispatcher->setDefaultNamespace('RadHam');
    #$dispatcher->setEventsManager($events_manager);

    return $dispatcher;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    #$url = new UrlResolver();
    $url = new \Phalcon\Mvc\Url;
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new \Phalcon\Mvc\View;

    // Needed ???
    $view->setViewsDir($config->application->viewsDir);

    #$view->registerEngines([
    #    '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    #]);

    return $view;
});
/*
$di->set('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
}, true);
*/

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});
