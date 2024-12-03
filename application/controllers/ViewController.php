<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ViewController extends CI_Controller {
    public function index(){
        $data['marker'] = $this->Marker->getMarkers()->result();
        $this->load->view('denah',$data);
    }

    public function MarkersByName(){
        $name = $this->input->post('nama_bangunan');
        $data['marker'] = $this->Marker->getMarkerByName($name)->result();
        return $this->load->view('denah',$data);
    }
}