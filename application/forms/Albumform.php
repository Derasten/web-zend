<?php

class Application_Form_Albumform extends Zend_Form
{

    public function init()
    {
       $this->setName('albums');

        //campo hidden para guardar id de album
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        //creamos <input text> para escribir nombre album
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setLabel('Nombre del album:')->setRequired(true)->
                addFilter('StripTags')->addFilter('StringTrim')->
                addValidator('NotEmpty');

        //creamos select para seleccionar artista
        $artista = new Zend_Form_Element_Select('artista_id');
        $artista->setLabel('Seleccione artista:')->setRequired(true);
        //cargo en un select los tipos de usuario
        $table = new Application_Model_DbTable_Artista();
        //obtengo listado de todos los artistas y los recorro en un
        //arreglo para agregarlos a la lista
        foreach ($table->listar() as $c)
        {
            $artista->addMultiOption($c->id, $c->nombre);
        }

        //descripcion album
        $descripcion = new Zend_Form_Element_Text('descripcion');
        $descripcion->setLabel('Descripcion:')->setRequired(false)->addFilter('StripTags')->addFilter('StringTrim');

        //fecha lanzamiento
        $fecha = new Zend_Form_Element_Text('fecha');
        $fecha->setLabel('Fecha lanzamiento:')->setRequired(true)->addFilter('StripTags')->
                addFilter('StringTrim')->addValidator('NotEmpty');
        //creo un validador de formato de fecha
        $valiDate = new Zend_Validate_Date();
        $valiDate->setFormat('dd-mm-YYYY');
        $fecha->addValidator($valiDate);
        $fecha->setValue(date("d-m-Y"));

        //boton para enviar formulario
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        //agregolos objetos creados al formulario
        $this->addElements(array($id, $nombre,
            $artista, $descripcion, $fecha, $submit));
    }

}