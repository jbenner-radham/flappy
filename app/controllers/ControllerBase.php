<?php

namespace Flappy\Controllers;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        $this->view->disable();
    }

    public function afterExecuteRoute($dispatcher)
    {
        $response = &$this->response;

        /**
         * @see http://tools.ietf.org/html/rfc4627.html
         */
        $response->setContentType('application/json; charset=utf-8')
                 ->setJsonContent($dispatcher->getReturnedValue());

        /**
         * Was...
         *
         * ```
         * $response->setContentType('application/json; charset=utf-8')
         *          ->setJsonContent($response->getContent());
         * ```
         *
         * But that required the child controller to perform `$response->setContent()`
         * instead of simply returning the value.
         */

        return $response->send();
    }
}
