<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rubros_model extends CI_Model {


    public function listaRubros()
    {
        $rubro = $this->db->get('rubro');
        return $rubro->result_array();
    }

    public function store()
    {

        if ($this->input->post('activo') == "on"  or null)
        $activo="on";
        else
        $activo="off";
        if ($this->input->post('rPadre')=='')
            $rpadre=null;
        else
            $rpadre=$this->input->post('rPadre');
        $rubro= [
            'nombreRubro'=>  strtoupper($this->input->post('nombre')),
            'descripcion'=>  strtoupper($this->input->post('desc')),
            'rubroPadre'=> $rpadre,
            'activo'=> $activo,
            'imagen'=>$this->input->post('icono'),
            'colorFondo'=>$this->input->post('coloricono')

        ];
        return $this->db->insert("rubro",$rubro);
    } 

    public function update()
    {
        $id=$this->input->post('idrubro');
        if ($this->input->post('activo2') == "on"  or null)
        $activo="on";
        else
        $activo="off";
        if ($this->input->post('rPadre2')=='')
            $rpadre=null;
        else
            $rpadre=$this->input->post('rPadre2');
        $rubro= [
            'nombreRubro'=>  strtoupper($this->input->post('nombre2')),
            'descripcion'=>  strtoupper($this->input->post('desc2')),
            'rubroPadre'=> $rpadre,
            'activo'=> $activo,
            'imagen'=>$this->input->post('icono2'),
            'colorFondo'=>$this->input->post('coloricono2')

        ];

        $this->db->where('idRubro',$id);
        return $this->db->update('rubro',$rubro);
    }
    
    public function delete($idrubro){
        return $this->db->delete('rubro', array('idRubro' => $idrubro));
    }
}
