<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penerimaan extends CI_Model {	
  var $column_order = array(null, 'kode_penerimaan','tanggal_terima'); //field yang ada di table user
  var $column_search = array('kode_penerimaan','tanggal_terima'); //field yang diizin untuk pencarian 
  var $order = array('tanggal_terima' => 'DESC'); // default order 

	public function __construct()
	{
		parent::__construct();
		
	}

  private function _get_datatables_query()
    {
         $kode_user = $this->session->userdata("kode_user");
        //add custom filter here
        if ($this->input->post('pengiriman'))
        {
            $this->db->where("kode_pengiriman like '%".$this->input->post('pengiriman')."%'");
        }

        if(($this->input->post("date1")) AND ($this->input->post("date2")))
        {
          $this->db->where("tanggal_terima >=", $date1);
          $this->db->where("tanggal_terima <=" , $date2);
        }

        $table_sql="(SELECT
                        B.id_dtpenerimaan,
                        A.kode_penerimaan,
                        A.kode_pengiriman,
                        A.tanggal_terima,
                        F.username,
                        D.jumlah_barang_kirim,
                        E.jumlah_retur,
                        B.jumlah_NG,
                        B.jumlah_terima,
                        B.jumlah_sisa
                    FROM tb_penerimaan A
                    INNER JOIN tb_detail_penerimaan B
                        ON B.kode_penerimaan = A.kode_penerimaan
                    INNER JOIN tb_pengiriman C
                        ON C.kode_pengiriman = A.kode_pengiriman
                    INNER JOIN tb_detail_pengiriman D
                        ON D.id_dtpengiriman = B.id_dtpengiriman
                    LEFT JOIN tb_detail_retur E
                        ON E.id_dtpengiriman = D.id_dtpengiriman
                    INNER JOIN tb_user F
                        ON F.kode_user = A.diterima_oleh) A1";
        $this->db->from($table_sql);
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
       $table_sql="(SELECT
                        B.id_dtpenerimaan,
                        A.kode_penerimaan,
                        A.kode_pengiriman,
                        A.tanggal_terima,
                        F.username,
                        D.jumlah_barang_kirim,
                        E.jumlah_retur,
                        B.jumlah_NG,
                        B.jumlah_terima,
                        B.jumlah_sisa
                    FROM tb_penerimaan A
                    INNER JOIN tb_detail_penerimaan B
                        ON B.kode_penerimaan = A.kode_penerimaan
                    INNER JOIN tb_pengiriman C
                        ON C.kode_pengiriman = A.kode_pengiriman
                    INNER JOIN tb_detail_pengiriman D
                        ON D.id_dtpengiriman = B.id_dtpengiriman
                    LEFT JOIN tb_detail_retur E
                        ON E.id_dtpengiriman = D.id_dtpengiriman
                    INNER JOIN tb_user F
                        ON F.kode_user = A.diterima_oleh ) A1";
        $this->db->from($table_sql);
        return $this->db->count_all_results();
    }
}
