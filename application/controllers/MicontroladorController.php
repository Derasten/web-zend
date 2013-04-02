<?php

class MicontroladorController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
    }

    public function indexAction()
    {
        // action body
        $this->view->saludo = "hola a todos!!";
    }


}

