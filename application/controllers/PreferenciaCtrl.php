<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PreferenciaCtrl extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Preferencias_model');
    }

    public function index()
    {
        if($this->session->userdata('login')==1){
            $user = $this->session->userdata('idUs');
            $dato=$this->Usuarios_model->validaIngreso($user);
            $preferencia['preferencia']=$this->Preferencias_model->listaPreferencia();
            $this->load->view('templates/header', $dato);
            $this->load->view('preferenciaver',$preferencia);
            $dato2['js']="<script src='".base_url()."assets/js/preferencia.js'></script>";

            $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }

    public function preferenciareg()
    {
        if($this->session->userdata('login')==1){
            $user = $this->session->userdata('idUs');
            $dato=$this->Usuarios_model->validaIngreso($user);

            $this->load->view('templates/header', $dato);
            $this->load->view('preferenciareg');
            $dato2['js']="<script src=''></script>";


            $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }


    public function store()
    {
        $this->Preferencias_model->store();
        //$this->index();
        header('Location: '.base_url().'PreferenciaCtrl');
    }



    public function update(){
        $this->Preferencias_model->update();
        header("Location: ".base_url()."PreferenciaCtrl");
    }


    public function delete($idpreferencia)
    {

        $this->Preferencias_model->delete($idpreferencia);
        header("Location: ".base_url()."PreferenciaCtrl");
    }

    
    public function datos(){
        $idpreferencia=$_POST['idpreferencia'];
        $query=$this->db->query("SELECT * FROM preferencia WHERE idPreferencia='$idpreferencia'");
        $row=$query->row();
        
        $myObj=($query->result_array())[0];

        echo json_encode($myObj);
    }
}