<?php

class Application_Model_DbTable_Autor extends Zend_Db_Table_Abstract
{

    protected $_name = 'der-autor';

    /**
     * devuelve un arreglo con los datos del artista con id=$id
     * @param  $id id del artista
     * @return  arreglo asociativo
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
        $fecha = $row->fecha_ingreso;
        $fecha = date("d-m-Y", strtotime($fecha));
//        die($fecha);
        $row->fecha_ingreso = $fecha;
        return $row->toArray();
    }

    /**
     *  agrega un nuevo artista a la base de datos
     */
    public function agregar($id, $nombre,  $descripcion, $email, $fecha)
    {
        $data = array('id' => $id,
            'nombre' => $nombre,
            'descripcion' => $descripcion, 'email' => $email,
             'fecha'=>$fecha );
        //$this->insert inserta nuevo artista
        $this->insert($data);
    }

    /**
     * modifica los datos del artista id= $id
     */
    public function cambiar($id,$nombre,  $descripcion, $email, $fecha)
    {
         $data = array('nombre' => $nombre,
            'descripcion' => $descripcion, 'email' => $email,
             'fecha'=>$fecha );
        //$this->update cambia datos de artista con id= $id
        $this->update($data, 'id = ' . (int) $id);
    }

    /**
     * borra el artista con id= $id
     * @param  $id
     */
    public function borrar($id)
    {
        //$this->delete borrar artista donde id=$id
        $this->delete('id =' . (int) $id);
    }
     public function listar()
    {
         //devuelve todos los registros de la tabla
         return $this->fetchAll();
    }
}

