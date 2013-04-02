<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->initView();
        $this->view->title ="Derasten";// Titulo de la página principal
        $this->view->baseUrl = $this->_request->getBaseUrl();
    }

    public function indexAction()
    {
        // action body
    }

    public function pruebaAction()
    {
        // action body
    }

    public function saludoAction()
    {
        // action body
    }
    
    public function saludoajax2Action()
{
    //esta accion no usara layout.phtml
    $this->_helper->layout->disableLayout();
    //esta accion no renderizara su contenido en saludoajax2.phtml
    $this->_helper->viewRenderer->setNoRender();
    
    //esta es la respuesta a la llamada ajax 
    echo "    saludos desde el servidor";
}

}





