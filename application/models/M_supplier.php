<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_supplier extends CI_Model {	
  var $column_order = array(null, 'nama_supplier','no_tlp','email'); //field yang ada di table user
  var $column_search = array('nama_supplier','no_tlp','email'); //field yang diizin untuk pencarian 
  var $order = array('kode_supplier' => 'ASC'); // default order 

	public function __construct()
	{
		parent::__construct();
		
	}

  private function _get_datatables_query()
    {
         $kode_user = $this->session->userdata("kode_user");
        //add custom filter here
        if ($this->input->post('nama_sp_src'))
        {
            $nama_sp = $this->input->post('level_src');
            $this->db->where("nama_supplier like '%$nama_sp%'" );
        }

        $table_sql="(SELECT
                      *
                     FROM tb_supplier
                    WHERE 1=1) A1";
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
                      *
                     FROM tb_supplier
                    WHERE 1=1) A1";
        $this->db->from($table_sql);
        return $this->db->count_all_results();
    }
}