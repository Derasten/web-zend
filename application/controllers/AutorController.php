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
        //creo objeto de formulario
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
                $artista_id = $form->getValue('id');
                $nombre = $form->getValue('nombre');
                $descripcion = $form->getValue('descripcion');
                $email = $form->getValue('email');
                $fecha = $form->getValue('fecha');

                //como mi fecha viene en el formato dia-mes-año y Mysql
                //guarda fechas en la forma año-mes-dia, procedo a cambiar el formato
                //cambio formato de fecha para mysql
                $fecha = $this->fechaMysql($fecha);

                //creo objeto Album que controla la talba Album de la base de datos
                $albums = new Application_Model_DbTable_Autor();
                //llamo a la funcion agregar, con los datos que recibi del form
                $albums->agregar($id, $nombre, $descripcion, $email, $fecha);

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
     */
    public  function fechaMysql($fecha)
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


}



