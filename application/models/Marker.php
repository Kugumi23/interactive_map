<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marker extends CI_Model {
    
    public function getMarkers(){
        $this->db->where('nama_area','komplek bandara');
        return $this->db->get('bangunan');
    }

    public function getMarkerByName($name){
        $this->db->like('nama_bangunan',$name);
        $this->db->where('nama_area','komplek bandara');
        return $this->db->get('bangunan');
    }

    public function getMarkersByColorsFiltered($name) {
        $this->db->select('warna_marker, COUNT(*) as jumlah_tanda');
        $this->db->like('nama_bangunan',$name);
        $this->db->group_by('warna_marker');
        $this->db->order_by('jumlah_tanda','DESC');
        $this->db->where('nama_area','komplek bandara');
        return $this->db->get('bangunan');
    }

    public function getMarkersByColors(){
        $this->db->select('warna_marker, COUNT(*) as jumlah_tanda');
        $this->db->group_by('warna_marker');
        $this->db->order_by('jumlah_tanda','DESC');
        $this->db->where('nama_area','komplek bandara');
        return $this->db->get('bangunan');
    }
}