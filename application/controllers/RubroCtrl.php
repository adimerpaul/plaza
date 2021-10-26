<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RubroCtrl extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Rubros_model');
    }

    public function index()
    {
        if($this->session->userdata('login')==1){
            $user = $this->session->userdata('idUs');
            $dato=$this->Usuarios_model->validaIngreso($user);
            $rubro['rubro']=$this->Rubros_model->listaRubros();
            $this->load->view('templates/header', $dato);
            $this->load->view('rubrover',$rubro);
            $dato2['js']="<script src='".base_url()."assets/js/rubro.js'></script>";
            $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }

    public function rubroreg()
    {
        if($this->session->userdata('login')==1){
            $user = $this->session->userdata('idUs');
            $dato=$this->Usuarios_model->validaIngreso($user);

            $this->load->view('templates/header', $dato);

            $this->load->view('rubroreg');

            $dato2['js']="<script src='".base_url()."assets/js/rubro.js'></script>";


            $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }


    public function store()
    {
        $this->Rubros_model->store();
        header('Location: '.base_url().'RubroCtrl');
    }



    public function update()
    {
        $this->Rubros_model->update();
        header('Location: '.base_url().'RubroCtrl');
    }


    public function delete($idrubro)
    {

        $this->Rubros_model->delete($idrubro);
        header("Location: ".base_url()."RubroCtrl");
    }
    public function datos(){
        $idrubro=$_POST['idrubro'];
        $query=$this->db->query("SELECT * FROM rubro where idRubro=$idrubro");
        $row=$query->row();
        
        $myObj=($query->result_array())[0];

        echo json_encode($myObj);
   

    }



}