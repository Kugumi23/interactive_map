<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marker extends CI_Model {
    
    public function getMarkers(){
        return $this->db->get('bangunan');
    }

    public function getMarkerByName($name){
        $this->db->like('nama_bangunan',$name);
        return $this->db->get('bangunan');
    }

    public function route($loc1, $loc2) {
        $this->db->like('nama_bangunan', $loc1);
        $this->db->like('nama_bangunan', $loc2);
        return $this->db->get('bangunan');
    }
}