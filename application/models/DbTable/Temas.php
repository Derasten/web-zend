<?php

class Application_Model_DbTable_Temas extends Zend_Db_Table_Abstract {

    protected $_name = 'temas';

    /**
     * devuelve un arreglo con los datos del tema con id=$id
     * @param  $id id del tema
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
        return $row->toArray();
    }

    /**
     *  agrega un nuevo tema a la base de datos
     */
    public function agregar($album_id, $titulo, $duracion)
    {
        $data = array('album_id' => $album_id,
            'titulo' => $titulo, 'duracion' => $duracion);
        //$this->insert inserta nuevo tema
        $this->insert($data);
    }

    /**
     * modifica los datos del tema id= $id
     */
    public function cambiar($id, $album_id, $titulo, $duracion)
    {
        $data = array('album_id' => $album_id,
            'titulo' => $titulo, 'duracion' => $duracion);
        //$this->update cambia datos de tema con id= $id
        $this->update($data, 'id = ' . (int) $id);
    }

    /**
     * borra el tema con id= $id
     * @param  $id
     */
    public function borrar($id)
    {
        //$this->delete borrar tema donde id=$id
        $this->delete('id =' . (int) $id);
    }

    public function listar()
    {
        //devuelve todos los registros de la tabla
        return $this->fetchAll();
    }

}

