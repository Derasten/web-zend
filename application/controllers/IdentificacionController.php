<?php

class IdentificacionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        //creo objeto de formulario de Autor
        $form = new Application_Form_Loginform();
        //le cambio el texto al boton submit del formulario
        //$form->submit->setLabel('Identificarse');
        //aisigno el formulario a la vista (la pag web que mostraremos)
        $this->view->form = $form;
        
        //los formularios envian sus datos a traves de POST
        //si vienen datos de post, es que el usuario ha enviado el formulario
        if ($this->getRequest()->isPost())
        {
            //extrae un arreglo con los datos recibidos por POST
            //es decir, los datos clave=>valor del formulario
            $formData = $this->getRequest()->getPost();

            //isValid() revisa todos los validadores y filtros que le
            //aplicamos a los objetos del formulario: se asegura de que los
            //campos requeridos se hallan llenado, que el formato de la fecha
            //sea el correcto, etc
            if ($form->isValid($formData))
            {
                $usuario = $form->getValue('nombre');
                $contra = $form->getValue('contra');
                //aca ya estamos seguros de que los datos son validos
                //ahora los extraemos como se ve abajo
            /*    $autor_id  = $form->getValue('id');
                $nombre      = $form->getValue('nombre');
                $descripcion = $form->getValue('descripcion');
                $email       = $form->getValue('email');
                $fecha       = $form->getValue('fecha');

                //como mi fecha viene en el formato dia-mes-año y Mysql
                //guarda fechas en la forma año-mes-dia, procedo a cambiar el formato
                //cambio formato de fecha para mysql
                $fecha = $this->fechaMysql($fecha);

                //creo objeto Album que controla la tabla Autor de la base de datos
                $autor = new Application_Model_DbTable_Autor();
                //llamo a la funcion agregar, con los datos que recibi del form
                $autor->agregar($autor_id, $nombre, $descripcion, $email, $fecha);

                //indico que despues de haber agregado el album,
                //me redirija a la accion index de AlbumController, es decir,
                //a la pagina que me muestra el listado de albumes
                $this->_helper->redirector('index');*/
            }
            //si los datos del formulario no son validos, es decir, falta ingresar
            //algunos o el formato es incorrecto...
            else
            {
                //esta funcion vuelve a cargar el formulario con los datos que se
                //enviaron, Y ADEMAS CON LOS MENSAJES DE ERROR, los que se le mostrarán
                //al usuario
               // $form->populate($formData);
            }
        }
        
        
        
    /***************************************************************************************************************************************/
      if (Zend_Auth::getInstance()->hasIdentity()) {
        echo "already logged in as: ". Zend_Auth::getInstance()->getIdentity()->nombre;
    }else{
        $adaptadorAuth = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $adaptadorAuth ->setTableName('der-autor')
                       ->setIdentityColumn('nombre')
                       ->setCredentialColumn('password');
        
        //$usuario = 'Eisa';
        //$contra = 'elisa';
        $adaptadorAuth->setIdentity($usuario)
                      ->setCredential($contra);
        
        $auth = Zend_Auth::getInstance();
        $resultado = $auth->authenticate($adaptadorAuth);
  
        if($resultado->isValid()){
            //Guardamos la identidad, para utilizarla por toda la página
            $identidad = $adaptadorAuth->getResultRowObject();
            $almacenamiento = $auth->getStorage();
            $almacenamiento->write($identidad);
            $this->_redirect('index');
        }else{
            echo "NO es valido";
        }
    }
    }

    public function logoutAction()
    {
        // action body
    }


}





