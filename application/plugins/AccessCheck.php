<?php

class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract{
    
    private $_acl  = null;
    //Ya no es necesaria por que lo tenemos en un registro globla de Zend_Registry
    //private $_auth = null;
    public function __construct(Zend_Acl $acl/*, Zend_Auth $auth*/) {
        $this -> _acl  = $acl;
       // $this -> _auth = $auth;
    }
    //Hay que poner dentro de preDispatch \Zend Controller.... porque sino arroja error.
    public function preDispatch(\Zend_Controller_Request_Abstract $request) {
        //Cogemos el nombre del controlador y de la accion
        $resource = $request -> getControllerName();
        $action   = $request -> getActionName();
       //No necesitamos leer porque ya tenemos el rol actual en Zend_REgistry
       /* 
        //Ahora leemos quien está registrado y que privilegios tiene.
        $identidad = $this->_auth->getStorage()->read();
        $role = $identidad->role;*/
        if(!$this->_acl->isAllowed(/*$role*/Zend_Registry::get('role'),$resource, $action)){
            $request->setControllerName('identificacion')
                    ->setActionName('login');
        }
        //Venía predefinido al crearlo---Seguramente no valga para nada aquí.
        //parent::preDispatch($request);
    }
}
