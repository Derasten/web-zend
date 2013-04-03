<?php

class AutorController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        //creo objeto que maneja la tabla autores
        $table = new Application_Model_DbTable_Autor();
        //obtengo listado de todas las filas de la tabla, y las
        //coloco en la variable datos de la pagina web (de la vista) 
        //que vamos a mostrar

        $this->view->datos = $table->listar();
    }

    public function addAction()
    {
        // action body
        //creo objeto de formulario de Autor
        $form = new Application_Form_Autorform();
        //le cambio el texto al boton submit del formulario
        $form->submit->setLabel('Añadir autor');
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
                //aca ya estamos seguros de que los datos son validos
                //ahora los extraemos como se ve abajo
                $autor_id  = $form->getValue('id');
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
                $this->_helper->redirector('index');
            }
            //si los datos del formulario no son validos, es decir, falta ingresar
            //algunos o el formato es incorrecto...
            else
            {
                //esta funcion vuelve a cargar el formulario con los datos que se
                //enviaron, Y ADEMAS CON LOS MENSAJES DE ERROR, los que se le mostrarán
                //al usuario
                $form->populate($formData);
            }
        }
    }

    /**
     * cambia una fecha de formato dd-mm-yyyy
     * a formato
     * yyyy-mm-dd
     * @param <type> $fecha
     * @return <type>
     *
     */
    public function fechaMysql($fecha)
    {
        $arr = split("-", $fecha);
        if (count($arr) != 3)
        {
            return $fecha;
        } else
        {
            return "$arr[2]-$arr[1]-$arr[0]";
        }
    }

    public function updateAction()
    {
        // action body
         //titulo de la pagina
        $this->view->title = "Modificar album";
        $this->view->headTitle($this->view->title);
        //creo el formulario
        $form = new Application_Form_Autorform();
        //le pongo otro texto al boton submit
        $form->submit->setLabel('Modificar Autor');
        $this->view->form = $form;

        //si el usuario envia datos del form
        if ($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            //veo si son validos
            if ($form->isValid($formData))
            {
                //extraigo sus datos
                $id = $form->getValue('id');
                $nombre = $form->getValue('nombre');
                $descripcion = $form->getValue('descripcion');
                $email = $form->getValue('email');
                $fecha = $form->getValue('fecha');
                //cambio formato de fecha para mysql
                $fecha = $this->fechaMysql($fecha);
                //creo objeto tabla Album()
                $albums = new Application_Model_DbTable_Autor();
                //LLAMO A FUNCION CAMBIAR, QUE HACE EL UPDATE
                $albums->cambiar($id, $nombre, $descripcion, $email, $fecha);
                //redirijo a accion index
                $this->_helper->redirector('index');
            } 
            //si los daot sno son validos, vuelvo a mostrar el form, con 
            //los mensajes de error
            else
            {
                $form->populate($formData);
            }
        }
        //SI LOS DATOS NO VIENEN POR POST, ENTONCES ESTAMOS LLAMANDO A ESTA FUNCION
        //PARA QUE MUESTRE LOS DATOS DE UN ALBUM
        else
        {
            //YO HE DECIDIDO QUE DEBE VENIR UN PARAMETRO LLAMADO ID, con el 
            //id del album que deseo editar
            //si vienbe un parametro llamado id le asigno su valor a $id; 
            //si no viene, le asigno cero
            //esto es como llamar a $_REQUEST
            $id = $this->_getParam('id', 0);
            //si viene algun id
            if ($id > 0)
            {
               //CREO FORM
                $albums = new Application_Model_DbTable_Autor();
                //extraigo de la talba el album id= $id
                $album= $albums->get($id);
                //populate() toma los datos de $album y los coloca en el formualrio.
                //PARA QUE ESTO FUNCIONE, EL NOMBRE DE LOS OBJETOS DEL FORM DEBE
                //SER IGUAL AL NOMBRE DE LOS CAMPOS EN LA TABLA!!
                $form->populate( $album);
            }
        }
    }


}





