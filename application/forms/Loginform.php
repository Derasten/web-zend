<?php

class Application_Form_Loginform extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('Login');

        //creamos <input text> para escribir nombre album
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setLabel('Nombre del usuario:')->setRequired(true)->
                addFilter('StripTags')->addFilter('StringTrim')->
                addValidator('NotEmpty');
        $contra = new Zend_Form_Element_Password('contra');
        $contra->setLabel('Contraseña')
               ->setRequired(true);
        $login = new Zend_Form_Element_Submit('login');
        $login-> setLabel('Identificar');
        
        $this->addElements(array($nombre, $contra, $login));
    }


}

