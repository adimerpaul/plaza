<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TarifaCtrl extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Tarifas_model');


	}

    public function index()
    {
        if($this->session->userdata('login')==1){
            
            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
                $this->load->view('templates/header', $dato);
                $this->load->view('tarifareg');
                $dato['js']="<script></script>";    
                $this->load->view('templates/footer',$dato);
        }
        else redirect('');
    }
    
    public function store()
    {
        $this->Tarifas_model->store();
        $this->index();
    }
    public function update()
    {
        $this->Tarifas_model->update();
        $this->tarifaver();
    }

    public function tarifaver()
    {

        if($this->session->userdata('login')==1){
            
            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
           
            $tarifa['tarifa'] = $this->Tarifas_model->listaTarifa();
                $this->load->view('templates/header', $dato);
                $this->load->view('tarifaver',$tarifa);
                $dato2['js']="<script src='".base_url()."assets/js/tarifa.js'></script>";    
                $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }

    public function tarifaverinact()
    {

        if($this->session->userdata('login')==1){
            
            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
           
            $tarifa['tarifa'] = $this->Tarifas_model->listaTarifainact();
                $this->load->view('templates/header', $dato);
                $this->load->view('tarifaver',$tarifa);
                $dato2['js']="<script src='".base_url()."assets/js/tarifa.js'></script>";    
                $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }

    public function datos(){
        $idtarifa=$_POST['idtarifa'];
        $query=$this->db->query("SELECT * FROM tarifa WHERE idTarifa='$idtarifa'");
        $row=$query->row();
        
        $myObj=($query->result_array())[0];

        echo json_encode($myObj);
    }

    
    public function delete($idtarifa)
    {

        $this->Tarifas_model->delete($idtarifa);
        $this->tarifaver();
    }
}