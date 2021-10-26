<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peliculas_model extends CI_Model {

    public function listaDistribuidores()
    {
        $distri = $this->db->get('distribuidor');
        return $distri->result_array();
    }

    public function listaPeliculas()
    {
        $this->db->join('distribuidor','distribuidor.idDistrib = pelicula.idDistrib');
        $pelicula = $this->db->get('pelicula');
        return $pelicula->result_array();
    }

    public function store()
    {

        if ($this->input->post('cartelera') == "on"  or null)
        $cartelara=1;
        else
        $cartelara=0;
        if ($this->input->post('formato') == "on"  or null)
        $formato=1;
        else
        $formato=0;
        $pelicula= [
            'nombre'=> strtoupper($this->input->post('nom')),
            'duracion'=> $this->input->post('duracion'),
            'paisOrigen'=> strtoupper($this->input->post('origen')),
            'genero'=> $this->input->post('genero'),            
            'clasificacion'=> $this->input->post('clasificacion'),            
            'cartelera'=> $cartelara,
            'formato'=> $formato,
            'sipnosis'=>$this->input->post('sipnosis'),
            'urlTrailer'=> $this->input->post('url'),
            'idDistrib'=> $this->input->post('distribuidor')

        ];
        return $this->db->insert("pelicula",$pelicula);
    } 

    public function update()
    {
        $id=$this->input->post('idpelicula');

        if(($this->input->post('cartelera'))=="on")
        $cartelara=1;
        else
        $cartelara=0;
        if(($this->input->post('formato'))=="on")
        $formato=1;
        else
        $formato=0;
        $pelicula= [
            'nombre'=> strtoupper($this->input->post('nom')),
            'duracion'=> $this->input->post('duracion'),
            'paisOrigen'=> strtoupper($this->input->post('origen')),
            'genero'=> $this->input->post('genero'),            
            'clasificacion'=> $this->input->post('clasificacion'),            
            'cartelera'=> $cartelara,
            'formato'=> $formato,
            'sipnosis'=>$this->input->post('sipnosis'),
            'urlTrailer'=> $this->input->post('url'),
            'idDistrib'=> $this->input->post('distribuidor')

        ];
        $this->db->where('idPelicula',$id);
        return $this->db->update('pelicula',$pelicula);
    }
    
    public function delete($idpelicula){
        return $this->db->delete('pelicula', array('idPelicula' => $idpelicula));
    }
}
