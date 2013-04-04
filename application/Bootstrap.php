<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected  function _initRequest(){
        //Con esto acabamos de meter el rol actual en una variable global y por eso no necesitaremos la variable $auth
        if(Zend_Auth::getInstance()->hasIdentity()){
            Zend_Registry::set('role',  Zend_Auth::getInstance()->getStorage()->read()->role);
        }else{
            Zend_Registry::set('role', 'guest');
        }
        //Preparamos las variables para el plugin
        //Al estar fuera del entorno es indispensable.
        $acl=new Application_Model_AutorAcl;
        //No lo necesitamos por que ya esta en un variable global
        //$auth = Zend_Auth::getInstance();
        //Se prepara el plugin para que actue.
        $cargaplugin = Zend_Controller_Front::getInstance();
        $cargaplugin->registerPlugin(new Application_Plugin_AccessCheck($acl/*,$auth*/));
    }

}

