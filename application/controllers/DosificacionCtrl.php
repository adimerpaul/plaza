<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DosificacionCtrl extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Dosificaciones_model');
    }
    
    public function index()
    {
        if($this->session->userdata('login')==1){
            
            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
                $this->load->view('templates/header', $dato);
                $this->load->view('dosificacionreg');
                $dato['js']="<script></script>";    
                $this->load->view('templates/footer',$dato);
        }
        else redirect('');
    }

    public function store()
    {
        $this->Dosificaciones_model->store();
        $this->index();
    }

    public function dosificacionver()
    {
        if($this->session->userdata('login')==1){            
            $user = $this->session->userdata('idUs');
            $dato=$this->Usuarios_model->validaIngreso($user);
            $dosif['dosif'] = $this->Dosificaciones_model->listaDosificacion();
                $this->load->view('templates/header', $dato);
                $this->load->view('dosificacionver',$dosif);
                $dato2['js']="<script src='".base_url()."assets/js/dosificacion.js'></script>";    
                $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }

    public function update()
    {
        $this->Dosificaciones_model->update();
        $this->dosificacionver();  
    }

    public function datos(){
        $iddosificacion=$_POST['idDosif'];
        $query=$this->db->query("SELECT * FROM dosificacion WHERE idDosif=".$iddosificacion);
        $row=$query->row();
        
        $myObj=($query->result_array())[0];

        echo json_encode($myObj);
    }

    public function delete($idDosif)
    {

        $this->Dosificaciones_model->delete($idDosif);
        $this->dosificacionver();
    }

    public function ultimaDosificacion(){
        
        $query=$this->db->query("SELECT * FROM dosificacion WHERE activo=1 and tipo = 'BOLETERIA' and fechaHasta>=(select CURDATE()) ORDER BY idDosif DESC");
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }

    public function ultimaDosificacionCandy(){
        
        $query=$this->db->query("SELECT * FROM dosificacion WHERE activo=1 and tipo = 'CANDY' and fechaHasta>=(select CURDATE()) ORDER BY idDosif DESC");
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }



}