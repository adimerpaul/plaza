<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProveedorCtrl extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Proveedores_model');
    }
    
    public function index()
    {
        if($this->session->userdata('login')==1){
            
            $user = $this->session->userdata('idUs');

            $proveedor['proveedor'] = $this->Proveedores_model->listaProveedor();
            $dato=$this->Usuarios_model->validaIngreso($user);
                $this->load->view('templates/header', $dato);
                $this->load->view('proveedorver',$proveedor);
                $dato['js']="<script></script>";    
                $this->load->view('templates/footer',$dato);
        }
        else redirect('');
    }

    public function store()
    {
        $this->Proveedores_model->store();
        header("Location: ".base_url()."ProveedorCtrl");
    }

    public function proveedorver()
    {

        if($this->session->userdata('login')==1){
            
            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
           
            $proveedor['proveedor'] = $this->Proveedores_model->listaProveedor();
                $this->load->view('templates/header', $dato);
                $this->load->view('proveedorver',$proveedor);
                $dato2['js']="<script src='".base_url()."assets/js/proveedor.js'></script>";    
                $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }
    
    public function datos(){
        $idproveedor=$_POST['idproveedor'];
        $query=$this->db->query("SELECT * FROM proveedor WHERE idProveedor='$idproveedor'");
        $row=$query->row();
        
        $myObj=($query->result_array())[0];

        echo json_encode($myObj);
    }

    public function update()
    {
        $this->Proveedores_model->update();
        header("Location: ".base_url()."ProveedorCtrl/proveedorver");
    }

    public function delete($idproveedor)
    {

        $this->Proveedores_model->delete($idproveedor);
        header("Location: ".base_url()."ProveedorCtrl/proveedorver");
    }

}