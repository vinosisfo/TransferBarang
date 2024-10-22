<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_subcont extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_subcont');
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
		$this->load->view('pages/subcont/f_subcont');
		$this->load->view('template/menu_bar/control'); 
		//body end
		$this->load->view('template/menu_bar/footer');
	}

	function list_data_subcont()
    {
        $list = $this->M_subcont->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $no;
            $row[] = $field->kode_subcont;
            $row[] = $field->nama_subcont;
            $row[] = $field->alamat_subcont;
            $row[] = $field->no_tlp;
            $row[] = $field->email;
            $row[] = "<button type='button' onClick='edit_data_".$no."()' value=".$field->kode_subcont." id='edit_id_".$no."'
            		 class='btn btn-warning btn-xs'>EDIT</button>";
            if($this->session->userdata("level")==="ADMIN PPIC"){
                $row[] = "<button type='button' onClick='hapus_data_".$no."()' value=".$field->kode_subcont." id='hapus_id_".$no."' class='btn btn-danger btn-xs'>HAPUS</button>";
            }
            else
            {
                $row[]="";
            }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_subcont->count_all(),
                        "recordsFiltered" => $this->M_subcont->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

	function simpan_data()
	{
		$kode_subcont 	= $this->Generate_kode->kode_subcont();
		$nama_subcont 	= $this->input->post("subcont_add");
		$alamat 		= $this->input->post("alamat_add");
		$tlp 			= $this->input->post("tlp_add");
		$email 			= $this->input->post("email_add");

		$sql_cek =  $this->db->from("tb_subcont A")
							 ->where("A.nama_subcont", $nama_subcont)
							 ->where("A.no_tlp", $tlp)
							 ->get()->num_rows();
		if ((empty($nama_subcont)) or (empty($alamat)) or (empty($tlp)) or(empty($email)) ) 
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Lengkapi Data.
				        </div>';
			$data_res 	= array(
				"pesan_validasi" => $pesan,
				"pesan_gagal" => "",
				"pesan_sukses"  => "",
			);
			echo json_encode($data_res);
		}
		else if($sql_cek > 0)
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Subcont Dengan Nama '.$nama_subcont.' Sudah Ada.
				        </div>';
			$data_res 	= array(
				"pesan_validasi" => $pesan,
				"pesan_gagal" => "",
				"pesan_sukses"  => "",
			);
			echo json_encode($data_res);
		}
		else
		{
			$data_simpan = array(
				"kode_subcont" 	=> $kode_subcont,
				"nama_subcont"	=> $nama_subcont,
				"alamat_subcont"=> $alamat,
				"no_tlp"		=> $tlp,
				"email" 		=> $email
			);
			$simpan_data = $this->db->insert("tb_subcont",$data_simpan);
			if($simpan_data)
			{
				$pesan 	= '<div class="alert alert-info" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>Data Berhasil DiSimpan.
					        </div>';
				$data_res 	= array(
					"pesan_validasi" => "",
					"pesan_gagal" => "",
					"pesan_sukses"  => $pesan,
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
					"pesan_validasi" => "",
					"pesan_gagal" => $pesan,
					"pesan_sukses"  => "",
				);
				echo json_encode($data_res);	
			}
		}
	}

	function edit_data($kode_subcont)
	{
		$sql = $this->db->from("tb_subcont A")
						->where("A.kode_subcont",$kode_subcont)
						->get();
		if($sql->num_rows() > 0)
		{
			foreach ($sql->result() as $data) {
				$kode_subcont 	= $data->kode_subcont;
				$nama_subcont 	= $data->nama_subcont;
				$alamat 		= $data->alamat_subcont;
				$no_tlp 		= $data->no_tlp;
				$email 			= $data->email;
				
			}
		}
		else
		{
			$kode_subcont 	= "";
			$nama_subcont 	= "";
			$alamat 		= "";
			$no_tlp 		= "";
			$email 			= "";
		}
		$data_res = array(
			"kode_subcont"	=> $kode_subcont,
			"nama_subcont"	=> $nama_subcont,
			"alamat_subcont"=> $alamat,
			"no_tlp"		=> $no_tlp,
			"email"			=> $email,
		);

		echo json_encode($data_res);

	}

	function update_data()
	{
		$kode_subcont 	= $this->input->post("kode_subcont");
		$nama_subcont 	= $this->input->post("subcont_edit");
		$alamat 		= $this->input->post("alamat_edit");
		$tlp 			= $this->input->post("tlp_edit");
		$email 			= $this->input->post("email_edit");

		$sql_cek =  $this->db->from("tb_subcont A")
							 ->where("A.nama_subcont", $nama_subcont)
							 ->where("A.no_tlp", $tlp)
							 ->where("A.email", $email)
							 ->get()->num_rows();
		if ((empty($nama_subcont)) or (empty($alamat)) or (empty($tlp)) or (empty($email)) ) 
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Lengkapi Data.
				        </div>';
			$data_res 	= array(
				"pesan_validasi" => $pesan,
				"pesan_gagal" => "",
				"pesan_sukses"  => "",
			);
			echo json_encode($data_res);
		}
		else if($sql_cek > 0)
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Duplikat, Subcont Sudah Ada
				        </div>';
			$data_res 	= array(
				"pesan_validasi" => $pesan,
				"pesan_gagal" => "",
				"pesan_sukses"  => "",
			);
			echo json_encode($data_res);
		}
		else
		{
			$data_update = array(
				"nama_subcont"	=> $nama_subcont,
				"alamat_subcont"=> $alamat,
				"no_tlp"		=> $tlp,
				"email" 		=> $email
			);
			$update_data = $this->db->update("tb_subcont",$data_update,array("kode_subcont" => $kode_subcont));
			if($update_data)
			{
				$pesan 	= '<div class="alert alert-info" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>Data Berhasil Diupdate.
					        </div>';
				$data_res 	= array(
					"pesan_validasi" => "",
					"pesan_gagal" => "",
					"pesan_sukses"  =>  $pesan,
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
					"pesan_validasi" => "",
					"pesan_gagal" => $pesan,
					"pesan_sukses"  =>  "",
				);
				echo json_encode($data_res);	
			}
		}
	}

	function hapus_data($kode_subcont)
	{
		$hapus_data = $this->db->delete("tb_subcont",array("kode_subcont" => $kode_subcont));
		if($hapus_data)
			{
				$pesan 	= '<div class="alert alert-info" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>Data Berhasil DiHapus.
					        </div>';
				$data_res 	= array(
					"pesan_hapus" => $pesan,
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
					"pesan_hapus" => $pesan,
				);
				echo json_encode($data_res);	
			}

	}
}