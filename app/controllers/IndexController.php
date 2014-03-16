<?php

namespace Flappy\Controllers;

// Yes, it bugs me typing the "\" so I import the object...
use \ArrayObject;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        return new ArrayObject([
            'hello',
            'world'
        ]);
    }
}
