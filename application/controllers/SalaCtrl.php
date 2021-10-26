<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalaCtrl extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Sala_model');


    }

    public function index()
    {
        if($this->session->userdata('login')==1){

            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
            $this->load->view('templates/header', $dato);
            $this->load->view('salareg');
            $dato['js']="<script src='".base_url()."assets/js/salareg.js'></script>";
            $this->load->view('templates/footer',$dato);
        }
        else redirect('');
    }

    public function salaver()
    {

        if($this->session->userdata('login')==1){

            $user = $this->session->userdata('idUs');

            $dato=$this->Usuarios_model->validaIngreso($user);
            $distrib['sala'] = $this->Sala_model->listaSala();
            $this->load->view('templates/header', $dato);
            $this->load->view('salaver',$distrib);
            $dato['js']="<script src='".base_url()."assets/js/sala.js'></script>";
            $this->load->view('templates/footer',$dato);
        }
        else redirect('');
    }

    public function store()
    {
        $this->Sala_model->store();
        header("Location: ".base_url()."SalaCtrl");
       // echo $_POST['B1'];
    }

    public function datos(){
        $tabla=$_POST['tabla'];
        $where=$_POST['where'];
        $dato=$_POST['dato'];
        $query=$this->db->query("SELECT * FROM $tabla WHERE $where='$dato'");
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }
    public function datos2(){
        $tabla=$_POST['tabla'];
        $where=$_POST['where'];
        $dato=$_POST['dato'];
        $query=$this->db->query("SELECT * FROM $tabla WHERE $where='$dato' ORDER BY fila,columna DESC ");
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }
    public function update()
    {

        $this->Sala_model->update();
        header("Location: ".base_url()."SalaCtrl/Salaver");
    }
    public function manual()
    {

        $this->Sala_model->manual();
        header("Location: ".base_url()."SalaCtrl/Salaver");
    }

    public function delete($idSala)
    {

        $this->Sala_model->delete($idSala);

        header("Location: ".base_url()."SalaCtrl/Salaver");
    }

}
