<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DistribuidorCtrl extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Distribuidores_model');


    }

    public function index()
    {
        if($this->session->userdata('login')==1){
            
            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
                $this->load->view('templates/header', $dato);
                $this->load->view('distribuidorreg');
                $dato['js']="<script></script>";    
                $this->load->view('templates/footer',$dato);
        }
        else redirect('');
    }

    public function distribuidorver()
    {

        if($this->session->userdata('login')==1){
            
            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
            $distrib['distribuidor'] = $this->Distribuidores_model->listaDistribuidor();
                $this->load->view('templates/header', $dato);
                $this->load->view('distribuidorver',$distrib);
                $dato['js']="<script src='".base_url()."assets/js/distribuidor.js'></script>";    
                $this->load->view('templates/footer',$dato);
        }
        else redirect('');
    }

    public function store()
    {
        $this->Distribuidores_model->store();
        header("Location: ".base_url()."DistribuidorCtrl");
    }
    public function update()
    {
        $this->Distribuidores_model->update();
        header("Location: ".base_url()."DistribuidorCtrl/distribuidorver");
    }
 
    

    public function datos(){
        $iddistrib=$_POST['iddistrib'];
        $query=$this->db->query("SELECT * FROM distribuidor WHERE idDistrib='$iddistrib'");
        $row=$query->row();
        
        $myObj=($query->result_array())[0];

        echo json_encode($myObj);
    }

    public function delete($idDistrib)
    {

        $this->Distribuidores_model->delete($idDistrib);
        $this->distribuidorver();
    }

}
