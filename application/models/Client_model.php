<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_model extends CI_Model
{
    

    public function getClient()
    {
        $query = "SELECT *
                    FROM klien
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getDataClient()
    {
        $query = "SELECT id, nama_klien FROM klien";

        return $this->db->query($query)->result_array();
    }


    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('klien');
    }

    function updateKlien($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('klien', $data);
    }

      // GENERATE KODE OTOMATIS
      public function getkodeticket()
      {
          $query = $this->db->query("select max(no_tiket) as max_code FROM pelaporan");
  
          $row = $query->row_array();

          $max_id = $row['max_code'];
          $max_fix = (int) substr($max_id, 9, 4);
  
          $max_nik = $max_fix + 1;
  
          // $tanggal = $time = date("d");
          $bulan = $time = date("m");
          $tahun = $time = date("Y");
          
  
          $nik = "TIC".$tahun.$bulan.sprintf("%04s", $max_nik);
          return $nik;
      }
      

    // public function buat_tiket(){
    //     $this->db->select('RIGHT(tiket_temp.no_tiket) as tiket', FALSE);
    //     $this->db->order_by('no_tiket','DESC');
    //     $this->db->limit(1);
    //     $query = $this->db->get('tiket_temp');
    //     if($query->num_rows() <> 0){
    //         $data = $query->row();
    //         $kode = intval($data->tiket) + 1;

    //     }else{
    //         $kode = 1;

    //     }

    //     $kodemax = str_pad($kode, 3, "0",STR_PAD_LEFT);
    //     $kodejadi = "TIC".$kodemax;
    //     return $kodejadi;

    // }

  
    

}