<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate_kode extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}

  function kode_user()
  {
    $this->db->select('RIGHT(tb_user.kode_user,6) as kode', FALSE);
    $this->db->order_by('kode_user','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_user');
    if($query->num_rows() <> 0){      
      //jika kode ternyata sudah ada.      
      $data = $query->row();      
      $kode = intval($data->kode) + 1;    
    }
    else 
    {      
         //jika kode belum ada      
      $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_res = "KUS".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_res;  
  }

  function kode_supplier()
  {
    $this->db->select('RIGHT(tb_supplier.kode_supplier,6) as kode', FALSE);
    $this->db->order_by('kode_supplier','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_supplier');
    if($query->num_rows() <> 0){      
      //jika kode ternyata sudah ada.      
      $data = $query->row();      
      $kode = intval($data->kode) + 1;    
    }
    else 
    {      
         //jika kode belum ada      
      $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_res = "KSP".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_res;  
  }

  function kode_barang()
  {
    $this->db->select('RIGHT(tb_barang.kode_barang,6) as kode', FALSE);
    $this->db->order_by('kode_barang','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_barang');
    if($query->num_rows() <> 0){      
      //jika kode ternyata sudah ada.      
      $data = $query->row();      
      $kode = intval($data->kode) + 1;    
    }
    else 
    {      
         //jika kode belum ada      
      $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_res = "KDB".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_res;  
  }

  function kode_subcont()
  {
    $this->db->select('RIGHT(tb_subcont.kode_subcont,6) as kode', FALSE);
    $this->db->order_by('kode_subcont','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_subcont');
    if($query->num_rows() <> 0){      
      //jika kode ternyata sudah ada.      
      $data = $query->row();      
      $kode = intval($data->kode) + 1;    
    }
    else 
    {      
         //jika kode belum ada      
      $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_res = "KSB".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_res;  
  }


  function kode_pengiriman()
  {
    $this->db->select('RIGHT(tb_pengiriman.kode_pengiriman,6) as kode', FALSE);
    $this->db->order_by('kode_pengiriman','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_pengiriman');
    if($query->num_rows() <> 0){      
      //jika kode ternyata sudah ada.      
      $data = $query->row();      
      $kode = intval($data->kode) + 1;    
    }
    else 
    {      
         //jika kode belum ada      
      $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_res = "KPG".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_res;  
  }

  function kode_retur()
  {
    $this->db->select('RIGHT(tb_retur.kode_retur,6) as kode', FALSE);
    $this->db->order_by('kode_retur','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_retur');
    if($query->num_rows() <> 0){      
      //jika kode ternyata sudah ada.      
      $data = $query->row();      
      $kode = intval($data->kode) + 1;    
    }
    else 
    {      
         //jika kode belum ada      
      $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_res = "KRT".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_res;  
  }

  function kode_penerimaan()
  {
    $this->db->select('RIGHT(tb_penerimaan.kode_penerimaan,6) as kode', FALSE);
    $this->db->order_by('kode_penerimaan','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_penerimaan');
    if($query->num_rows() <> 0){      
      //jika kode ternyata sudah ada.      
      $data = $query->row();      
      $kode = intval($data->kode) + 1;    
    }
    else 
    {      
         //jika kode belum ada      
      $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_res = "KPN".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_res;  
  }
   
}
