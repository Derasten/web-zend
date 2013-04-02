<?php

class AlbumController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->initView();
        $this->view->title = "Albumes";
    }

    public function indexAction()
    {
        // action body
        //creo objeto que maneja la tabla album
        $table = new Application_Model_DbTable_Album(); 
        //obtengo listado de todas las filas de la tabla, y las
        //coloco en la variable datos de la pagina web (de la vista) 
        //que vamos a mostrar

        $this->view->datos = $table->listar();
    }

    public function addAction()
    {
        //titulo para la pagina
        $this->view->title = "Agregar album";
        //valor para <head><title>
        $this->view->headTitle($this->view->title);
        //creo el formulario
        $form = new Application_Form_Albumform ();
        //cambio el texto del boton submit
        $form->submit->setLabel('Agregar Album');
        //lo asigno oa la accion (la pag web que se mostrara)
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
                $artista_id = $form->getValue('artista_id');
                $nombre = $form->getValue('nombre');
                $fecha = $form->getValue('fecha');
                $descripcion = $form->getValue('descripcion');

                //como mi fecha viene en el formato dia-mes-año y Mysql
                //guarda fechas en la forma año-mes-dia, procedo a cambiar el formato
                //cambio formato de fecha para mysql
                $fecha = $this->fechaMysql($fecha);

                //creo objeto Album que controla la talba Album de la base de datos
                $albums = new Application_Model_DbTable_Album ();
                //llamo a la funcion agregar, con los datos que recibi del form
                $albums->agregar($artista_id, $nombre, $fecha, $descripcion);

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

    public function loquesea(){
        //me come la moral
    }
    public function updateAction()
    {
        //titulo de la pagina
        $this->view->title = "Modificar album";
        $this->view->headTitle($this->view->title);
        //creo el formulario
        $form = new Application_Form_Albumform ();
        //le pongo otro texto al boton submit
        $form->submit->setLabel('Modificar Album');
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
                $artista_id = $form->getValue('artista_id');
                $nombre = $form->getValue('nombre');
                $fecha = $form->getValue('fecha');
                $descripcion = $form->getValue('descripcion');
                //cambio formato de fecha para mysql
                $fecha = $this->fechaMysql($fecha);
                //creo objeto tabla Album()
                $albums = new Application_Model_DbTable_Album ();
                //LLAMO A FUNCION CAMBIAR, QUE HACE EL UPDATE
                $albums->cambiar($id, $artista_id, $nombre, $fecha, $descripcion);
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
                $albums = new Application_Model_DbTable_Album ();
                //extraigo de la talba el album id= $id
                $album= $albums->get($id);
                //populate() toma los datos de $album y los coloca en el formualrio.
                //PARA QUE ESTO FUNCIONE, EL NOMBRE DE LOS OBJETOS DEL FORM DEBE
                //SER IGUAL AL NOMBRE DE LOS CAMPOS EN LA TABLA!!
                $form->populate( $album);
            }
        }
    }

    public function deleteAction()
    {
        //debe venir un parametro, por GET o POST, llamado id, con el id del album a borrar
        $id = $this->_getParam('id', 0);
        //creo objeto tabla Album
        $tabla = new Application_Model_DbTable_Album ();
        //llamo a la funcion borrar
        $tabla->borrar($id);
        //redirijo a la accion index de este controlador, es decir,
        //al listado de albumes
        $this->_helper->redirector('index');
    }

    public function listadoajaxAction()
    {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $tabla = new Application_Model_DbTable_Album();
        $rows = $tabla->listar()->toArray();
        //funcion de zend framewrok que me codifica el listado para formato Json
        $json = Zend_Json::encode($rows);
        echo $json;
    }


}



