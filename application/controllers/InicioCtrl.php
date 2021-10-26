<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InicioCtrl extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Usuarios_model');


	}
    public function index()
    {
        if($this->session->userdata('login')==1){
            $user = $this->session->userdata('idUs');
            $dato=$this->Usuarios_model->validaIngreso($user);
            $this->load->view('templates/header',$dato);
            $this->load->view('inicio');
            $dato['js']="";
            $this->load->view('templates/footer',$dato);

        }
        else redirect('');
    }
}