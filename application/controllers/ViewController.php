<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ViewController extends CI_Controller {
    public function index(){
        $data['marker'] = $this->Marker->getMarkers()->result();
        $this->load->view('denah',$data);
    }

    public function MarkersByName(){
        $name = $this->input->post('search');
        $data['marker'] = $this->Marker->getMarkerByName($name)->result();
        return $this->load->view('denah',$data);
    }

    public function terminalL1() {
        $this->load->view('denah2');
    }

    public function terminalL2() {
        $this->load->view('denah3');
    }
    
    public function terminalL3() {
        $this->load->view('denah4');
    }   
}