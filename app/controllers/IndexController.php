<?php

namespace RadHam;

// Yes, it bugs me typing the "\" so I import the object...
use \ArrayObject;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        return $this->response->setContent(
            new ArrayObject([
                'hello',
                'world'
            ])
        );

        /**
         * # This code:
         *
         * $this->response->setContent(
         *     (object) [
         *         'hello',
         *         'world'
         *     ]
         * );
         *
         * # and this code:
         *
         * $this->response->setContent(
         *     new \ArrayObject([
         *         'hello',
         *         'world'
         *     ])
         * );
         *
         * # both return...
         *
         * {"0":"hello","1":"world"}
         */

    }
}
