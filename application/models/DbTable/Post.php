<?php

class Application_Model_DbTable_Post extends Zend_Db_Table_Abstract
{

    protected $_name = 'der-post';

    /**
     * devuelve un arreglo con los datos del album con id=$id
     * @param  $id id del album
     * @return  arreblo asociativo
     */
    public function get($id)
    {
        $id = (int) $id;
        //$this->fetchRow devuelve fila donde id = $id
        $row = $this->fetchRow('id = ' . $id);
        if (!$row)
        {
            throw new Exception("Could not find row $id");
        }
        //formateo fecha a dia-mes-año para que se vea mejor
        $fecha = $row->fecha;
        $fecha = date("d-m-Y", strtotime($fecha));
//        die($fecha);
        $row->fecha = $fecha;
        return $row->toArray();
    }

    /**
     *  agrega un nuevo album a la base de datos
     * @param  $artista_id
     * @param  $nombre
     * @param  $fecha fehca de registro de este album en la base de datos
     * @param  $descripcion
     */
    public function agregar($autor, $categoria, $fecha, $titulo, $texto, $resumen, $estado)
    {
        $data = array('autor'     => $autor,
                      'categoria' => $categoria,
                      'fecha'     => $fecha,
                      'titulo'    => $titulo,
                      'texto'     => $texto,
                      'resumen'   => $resumen,
                      'estado'    => $estado);
        //$this->insert inserta nuevo album
        $this->insert($data);
    }

    /**
     * modifica los datos del album id= $id
     * @param  $id
     * @param  $artista_id
     * @param  $nombre
     * @param  $descripcion
     */
    public function cambiar($id, $autor, $categoria, $fecha, $titulo, $texto, $resumen, $estado)
    {
        $data = array('autor'     => $autor,
                      'categoria' => $categoria,
                      'fecha'     => $fecha,
                      'titulo'    => $titulo,
                      'texto'     => $texto,
                      'resumen'   => $resumen,
                      'estado'    => $estado);
        //$this->update cambia datos de album con id= $id
        $this->update($data, 'id = ' . (int) $id);
    }

    /**
     * borra el album con id= $id
     * @param  $id
     */
    public function borrar($id)
    {
        //$this->delete borrar album donde id=$id
        $this->delete('id =' . (int) $id);
    }

    public function listar()
    {
        //devuelve todos los registros de la tabla
        return $this->fetchAll();
    }
}

