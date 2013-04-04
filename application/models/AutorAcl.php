<?php

class Application_Model_AutorAcl extends Zend_Acl
{
    public function __construct() {
        
        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('error'));
        
        $this->add(new Zend_Acl_Resource('identificacion'));
        $this->add(new Zend_Acl_Resource('login'),'identificacion');
        $this->add(new Zend_Acl_Resource('logout'),'identificacion');
        
        $this->add(new Zend_Acl_Resource('autor'));
        $this->add(new Zend_Acl_Resource('update'), 'autor');
        $this->add(new Zend_Acl_Resource('add'),'autor');
        
        $this->add(new Zend_Acl_Resource('autores'));
        $this->add(new Zend_Acl_Resource('list'),'autores');
        //De arriba a abajo, cuanto más arriba menos privilegios
        $this->addRole(new Zend_Acl_Role('guest'));
        $this->addRole(new Zend_Acl_Role('user'),'guest');
        $this->addRole(new Zend_Acl_Role('admin'),'user');
        
        $this->allow('guest','index');
        $this->allow('guest', array('identificacion','login','logout'));
        $this->allow('user','autores', 'list');
        $this->allow('user','autor','index');
        $this->allow('admin', 'autor', 'add');
        $this->allow('admin', 'autor', 'update');
        
    }

}

