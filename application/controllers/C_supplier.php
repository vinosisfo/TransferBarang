<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_supplier extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_supplier');
		$this->load->model('Generate_kode');
		$this->load->library('pdf');
		if (!isset($this->session->userdata['kode_user'])) {
			redirect(base_url("C_login"));
		}
	}

	public function index()
	{
		$this->load->view('template/js/js');
		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		//body
		$this->load->view('pages/supplier/f_supplier');
		$this->load->view('template/menu_bar/control'); 
		//body end
		$this->load->view('template/menu_bar/footer');
	}

	function list_data_supplier()
    {
        $list = $this->M_supplier->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $no;
            $row[] = $field->kode_supplier;
            $row[] = $field->nama_supplier;
            $row[] = $field->no_tlp;
            $row[] = $field->email;
            $row[] = $field->alamat;
            $row[] = $field->keterangan;
            $row[] = "<button type='button' onClick='edit_data_".$no."()' value=".$field->kode_supplier." id='edit_id_".$no."'
            		 class='btn btn-warning btn-xs'>EDIT</button>";
            if($this->session->userdata("level")==="ADMIN PPIC"){
                $row[] = "<button type='button' onClick='hapus_data_".$no."()' value=".$field->kode_supplier." id='hapus_id_".$no."' class='btn btn-danger btn-xs'>HAPUS</button>";
            }
            else
            {
                $row[]="";
            }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_supplier->count_all(),
                        "recordsFiltered" => $this->M_supplier->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

	function simpan_data()
	{
		$kode_supplier 	= $this->Generate_kode->kode_supplier();
		$nama_supplier 	= $this->input->post("nama_sp");
		$no_tlp_sp 		= $this->input->post("no_tlp_sp");
		$email_sp 		= $this->input->post("email_sp");
		$alamat_sp 		= $this->input->post("alamat_sp");
		$keterangan_sp 	= $this->input->post("keterangan_sp");

		$sql_cek =  $this->db->from("tb_supplier A")
							 ->where("A.nama_supplier", $nama_supplier)
							 ->get()->num_rows();
		if ((empty($nama_supplier)) or (empty($no_tlp_sp)) or (empty($email_sp)) or (empty($email_sp)) ) 
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Lengkapi Data.
				        </div>';
			$data_res 	= array(
				"pesan_valid" => $pesan,
				"pesan_simpan" => "",
				"pesan_gagal"  => "",
			);
			echo json_encode($data_res);
		}
		else if($sql_cek > 0)
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Supplier Sudah Ada.
				        </div>';
			$data_res 	= array(
				"pesan_valid" => $pesan,
				"pesan_simpan" => "",
				"pesan_gagal"  => "",
			);
			echo json_encode($data_res);
		}
		else
		{
			$data_simpan = array(
				"kode_supplier" => $kode_supplier,
				"nama_supplier"	=> $nama_supplier,
				"no_tlp"		=> $no_tlp_sp,
				"email"			=> $email_sp,
				"alamat"		=> $alamat_sp,
				"keterangan"    => $keterangan_sp,
			);
			$simpan_data = $this->db->insert("tb_supplier",$data_simpan);
			if($simpan_data)
			{
				$pesan 	= '<div class="alert alert-info" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>Data Berhasil DiSimpan.
					        </div>';
				$data_res 	= array(
					"pesan_valid" => "",
					"pesan_simpan" => $pesan,
					"pesan_gagal" => "",
				);
				echo json_encode($data_res);
			}
			else
			{
				$pesan 	= '<div class="alert alert-danger" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>GAGAL.
					        </div>';
				$data_res 	= array(
					"pesan_valid" => "",
					"pesan_simpan" => "",
					"pesan_gagal" => $pesan,
				);
				echo json_encode($data_res);	
			}
		}
	}

	function edit_data($kode_supplier)
	{
		$sql = $this->db->from("tb_supplier A")
						->where("A.kode_supplier",$kode_supplier)
						->get();
		if($sql->num_rows() > 0)
		{
			foreach ($sql->result() as $data) {
				$kode_supplier 	= $data->kode_supplier;
				$nama_supplier  = $data->nama_supplier;
				$no_tlp  	= $data->no_tlp;
				$email  	= $data->email;
				$alamat  	= $data->alamat;
				$keterangan = $data->keterangan;
			}
		}
		else
		{
			$kode_supplier 	= "";
			$nama_supplier  = "";
			$no_tlp  	= "";
			$email  	= "";
			$alamat  	= "";
			$keterangan = "";
		}
		$data_res = array(
			"kode_sp"		=> $kode_supplier,
			"nama_sp"		=> $nama_supplier,
			"no_tlp_sp"			=> $no_tlp,
			"email_sp"				=> $email,
			"alamat_sp"			=> $alamat,
			"keterangan_sp"		=> $keterangan,
		);

		echo json_encode($data_res);

	}

	function update_data()
	{
		$kode_supplier 	= $this->input->post("e_kode_sp");
		$nama_supplier 	= $this->input->post("e_nama_sp");
		$no_tlp_sp 		= $this->input->post("e_no_tlp_sp");
		$email_sp 		= $this->input->post("e_email_sp");
		$alamat_sp 		= $this->input->post("e_alamat_sp");
		$keterangan_sp 	= $this->input->post("e_keterangan_sp");

		$sql_cek =  $this->db->from("tb_supplier A")
							 ->where("A.nama_supplier", $nama_supplier)
							 ->get()->num_rows();
		if ((empty($nama_supplier)) or (empty($no_tlp_sp)) or (empty($email_sp)) or (empty($alamat_sp)) ) 
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Lengkapi Data.
				        </div>';
			$data_res 	= array(
				"pesan_valid" => $pesan,
				"pesan_simpan" => "",
				"pesan_gagal"  => "",
			);
			echo json_encode($data_res);
		}
		else if($sql_cek > 0)
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Supplier Sudah Ada.
				        </div>';
			$data_res 	= array(
				"pesan_valid" => $pesan,
				"pesan_simpan" => "",
				"pesan_gagal"  => "",
			);
			echo json_encode($data_res);
		}
		else
		{
			$data_update = array(
				"nama_supplier"	=> $nama_supplier,
				"no_tlp"		=> $no_tlp_sp,
				"email"			=> $email_sp,
				"alamat"		=> $alamat_sp,
				"keterangan"    => $keterangan_sp,
			);
			$update_data = $this->db->update("tb_supplier",$data_update,array("kode_supplier" => $kode_supplier));
			if($update_data)
			{
				$pesan 	= '<div class="alert alert-info" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>Data Berhasil DiSimpan.
					        </div>';
				$data_res 	= array(
					"pesan_valid" => "",
					"pesan_simpan" => $pesan,
					"pesan_gagal" => "",
				);
				echo json_encode($data_res);
			}
			else
			{
				$pesan 	= '<div class="alert alert-danger" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>GAGAL.
					        </div>';
				$data_res 	= array(
					"pesan_valid" => "",
					"pesan_simpan" => "",
					"pesan_gagal" => $pesan,
				);
				echo json_encode($data_res);	
			}
		}
	}

	function hapus_data($kode_supplier)
	{
		$hapus_data = $this->db->delete("tb_supplier",array("kode_supplier" => $kode_supplier));
		if($hapus_data)
			{
				$pesan 	= '<div class="alert alert-info" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>Data Berhasil DiSimpan.
					        </div>';
				$data_res 	= array(
					"pesan_valid" => $pesan,
				);
				echo json_encode($data_res);
			}
			else
			{
				$pesan 	= '<div class="alert alert-danger" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>GAGAL.
					        </div>';
				$data_res 	= array(
					"pesan_valid" => $pesan,
				);
				echo json_encode($data_res);	
			}

	}
}