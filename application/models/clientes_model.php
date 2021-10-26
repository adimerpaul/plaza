<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

    public function listaClientes()
    {
        $cliente = $this->db->get('cliente');
        return $cliente->result_array();
    }

    public function store()
    {
        $cliente= [
            'cinit'=> $this->input->post('cinit'),
            'nombreCl'=> strtoupper($this->input->post('nombre')),
            'apellidoCl'=> strtoupper($this->input->post('apellido')),
            'email'=> $this->input->post('email'),
            'fechaNac'=> $this->input->post('fechanac'),
            'telefono'=> $this->input->post('telef'),
            'direccion'=> strtoupper($this->input->post('direccion')),
            'sexo'=> $this->input->post('sexo')
        ];
        return $this->db->insert("cliente",$cliente);
    }
    


    public function delete($idCliente){
        return $this->db->delete('cliente', array('idCliente' => $idCliente));
    }

    public function update()
    {

        $id=$this->input->post('idcliente');
        $cliente= [
            'cinit'=> $this->input->post('cinit'),
            'nombreCl'=> strtoupper($this->input->post('nombre')),
            'apellidoCl'=> strtoupper($this->input->post('apellido')),
            'email'=> $this->input->post('email'),
            'fechaNac'=> $this->input->post('fechanac'),
            'telefono'=> $this->input->post('telef'),
            'direccion'=> strtoupper($this->input->post('direccion')),
            'sexo'=> $this->input->post('sexo')
        ];
        $this->db->where('idCliente',$id);
        return $this->db->update('cliente',$cliente);
    }
}