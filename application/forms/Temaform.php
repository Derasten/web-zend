<?php

class Application_Form_Temaform extends Zend_Form {

    public function init()
    {
        $this->setName('tema');

        //campo hidden para guardar id de album
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        //creamos <input text> para escribir nombre album
        $nombre = new Zend_Form_Element_Text('titulo');
        $nombre->setLabel('Titulo:')->setRequired(true)->
                addFilter('StripTags')->addFilter('StringTrim')->
                addValidator('NotEmpty');

        //creamos select para seleccionar artista
        $album = new Zend_Form_Element_Select('album_id');
        $album->setLabel('Pertenece a  Album:')->setRequired(true);
        //cargo en un select los tipos de usuario
        $table = new Application_Model_DbTable_Album();
        //obtengo listado de todos los artistas y los recorro en un
        //arreglo para agregarlos a la lista
        foreach ($table->listar() as $c)
        {
            $album->addMultiOption($c->id, $c->nombre);
        }


        //fecha lanzamiento
        $duracion = new Zend_Form_Element_Text('duracion');
        $duracion->setLabel('Duracion (mm:ss):')->setRequired(true)->addFilter('StripTags')->
                addFilter('StringTrim')->addValidator('NotEmpty');
        //creo un validador de formato de fecha
        $valiDate = new Zend_Validate_Date();
        $valiDate->setFormat('mm:ss');
        $duracion->addValidator($valiDate);
        $duracion->setValue('00:00');

        //boton para enviar formulario
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        //agregolos objetos creados al formulario
        $this->addElements(array($id, $nombre,
            $album, $duracion, $submit));
    }

}