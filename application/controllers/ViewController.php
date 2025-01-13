<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ViewController extends CI_Controller {
    public function index(){
        $data['marker'] = $this->Marker->getMarkers()->result();
        $data['colors'] = $this->Marker->getMarkersByColors()->result();
        $this->load->view('denah',$data);
    }

    public function MarkersByName(){
        $name = $this->input->post('search');
        if ($name) {
            $data['marker'] = $this->Marker->getMarkerByName($name)->result();
            $data['colors'] = $this->Marker->getmarkersByColorsFiltered($name)->result();
            $this->load->view('denah',$data);
        } else {
            redirect('ViewController/index');
        }
    }

    public function terminalL1() {
        $data['marker'] = $this->Marker->getMarkers1()->result();
        $data['colors'] = $this->Marker->getMarkersByColors1()->result();
        $this->load->view('denah2',$data);
    }

    public function MarkersByName1(){
        $name = $this->input->post('search');
        if ($name) {
            $data['marker'] = $this->Marker->getMarkerByName1($name)->result();
            $data['colors'] = $this->Marker->getmarkersByColorsFiltered1($name)->result();
        } else {
            redirect('ViewController/terminalL1');
        }
    }

    public function terminalL2() {
        $this->load->view('denah3');
    }
    
    public function terminalL3() {
        $this->load->view('denah4');
    }   
}