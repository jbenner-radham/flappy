<?php

namespace RadHam;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        $this->view->disable();
    }

    public function afterExecuteRoute($dispatcher)
    {
        $dispatcher->getReturnedValue();

        $response = &$this->response;
#var_dump($dispatcher);
#exit;
        /**
         * @see http://tools.ietf.org/html/rfc4627.html
         */
        $response->setContentType('application/json; charset=utf-8')
                 ->setJsonContent($response->getContent());

        return $response->send();
    }
}
