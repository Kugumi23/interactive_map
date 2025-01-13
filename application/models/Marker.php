<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marker extends CI_Model {
    
    //aiport_komplek_area
    public function getMarkers(){
        $this->db->order_by('warna_marker');
        $this->db->where('nama_area','komplek bandara');
        return $this->db->get('bangunan');
    }

    public function getMarkerByName($name){
        $this->db->like('nama_bangunan',$name);
        $this->db->order_by('warna_marker');
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

    //terminal_1st_floor
    public function getMarkers1(){
        $this->db->order_by('warna_marker');
        $this->db->where('nama_area','terminal lantai 1');
        return $this->db->get('bangunan');
    }

    public function getMarkersByName1($name){
        $this->db->like('nama_bangunan',$name);
        $this->db->order_by('warna_marker');
        $this->db->where('nama_area','terminal lantai 1');
        return $this->db->get('bangunan');
    }

    public function getMarkersByColorsFiltered1($name) {
        $this->db->select('warna_marker, COUNT(*) as jumlah_tanda');
        $this->db->like('nama_bangunan',$name);
        $this->db->group_by('warna_marker');
        $this->db->order_by('jumlah_tanda','DESC');
        $this->db->where('nama_area','terminal lantai 1');
        return $this->db->get('bangunan');
    }

    public function getMarkersByColors1(){
        $this->db->select('warna_marker, COUNT(*) as jumlah_tanda');
        $this->db->group_by('warna_marker');
        $this->db->order_by('jumlah_tanda','DESC');
        $this->db->where('nama_area','terminal lantai 1');
        return $this->db->get('bangunan');
    }
}