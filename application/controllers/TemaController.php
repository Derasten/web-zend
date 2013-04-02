<?php

class TemaController extends Zend_Controller_Action {

    public function init()
    {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
    }

    public function indexAction()
    {
       // $table = new Application_Models_DbTable_Tema();
        $table = new Application_Model_DbTable_Temas();
        $this->view->datos = $table->listar();
    }

    public function addAction()
    {
        $this->view->title = "Agregar tema";
        $this->view->headTitle($this->view->title);
        $form = new Application_Form_Temaform ();
        $form->submit->setLabel('Add');
        $this->view->form = $form;

        if ($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData))
            {
                // $artista_id = $form->getValue('artista_id');
                $album = $form->getValue('album_id');
                $titulo = $form->getValue('titulo');
                $duracion = $form->getValue('duracion');

                $tema = new Application_Model_DbTable_Temas ();
                $tema->agregar($album, $titulo, $duracion);

                $this->_helper->redirector('index');
            } else
            {
                $form->populate($formData);
            }
        }
    }

    public function deleteAction()
    {
        $id = $this->_getParam('id', 0);
        $tabla = new Application_Model_DbTable_Temas ();
        $tabla->borrar($id);
        $this->_helper->redirector('index');
    }

    public function updateAction()
    {
        $this->view->title = "Modificar artista";
        $this->view->headTitle($this->view->title);

        $form = new Application_Form_Temaform ();
        $form->submit->setLabel('Save');
        $this->view->form = $form;

        if ($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData))
            {
                $id = $form->getValue('id');
                 // $artista_id = $form->getValue('artista_id');
                $album = $form->getValue('album_id');
                $titulo = $form->getValue('titulo');
                $duracion = $form->getValue('duracion');

                $tema = new Application_Model_DbTable_Temas ();
                $tema->cambiar($id, $album, $titulo, $duracion);

                $this->_helper->redirector('index');
            } else
            {
                $form->populate($formData);
            }
        } else
        {
            $id = $this->_getParam('id', 0);
            if ($id > 0)
            {
                $albums = new Application_Model_DbTable_Temas ();
                $form->populate($albums->get($id));
            }
        }
    }
}







