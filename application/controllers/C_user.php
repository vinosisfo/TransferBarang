<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_user');
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
		$this->load->view('pages/admin/f_user');
		$this->load->view('template/menu_bar/control'); 
		//body end
		$this->load->view('template/menu_bar/footer');
	}

	function list_data_user()
    {
        $list = $this->M_user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $no;
            $row[] = $field->kode_user;
            $row[] = $field->username;
            $row[] = '******';
            $row[] = $field->level;
            $row[] = "<button type='button' onClick='edit_data_".$no."()' value=".$field->kode_user." id='edit_id_".$no."'
            		 class='btn btn-warning btn-xs'>EDIT</button>";
            if($this->session->userdata("level")==="ADMIN PPIC"){
                $row[] = "<button type='button' onClick='hapus_data_".$no."()' value=".$field->kode_user." id='hapus_id_".$no."' class='btn btn-danger btn-xs'>HAPUS</button>";
            }
            else
            {
                $row[]="";
            }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_user->count_all(),
                        "recordsFiltered" => $this->M_user->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

	function simpan_data()
	{
		$kode_user 	= $this->Generate_kode->kode_user();
		$username 	= $this->input->post("username");
		$password 	= md5($this->input->post("password"));
		$level 		= $this->input->post("level");
		$sql_cek =  $this->db->from("tb_user A")
							 ->where("A.password", $password)
							 ->get()->num_rows();
		if ((empty($username)) or (empty($password)) or (empty($level)) ) 
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
						</span></b>Password Sudah Terpakai, Silahkan Masukan Password Lain.
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
				"kode_user" 	=> $kode_user,
				"username"		=> $username,
				"password"		=> $password,
				"level"			=> $level,
			);
			$simpan_data = $this->db->insert("tb_user",$data_simpan);
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

	function edit_data($kode_user)
	{
		$sql = $this->db->from("tb_user A")
						->where("A.kode_user",$kode_user)
						->get();
		if($sql->num_rows() > 0)
		{
			foreach ($sql->result() as $data) {
				$kode_user 	= $data->kode_user;
				$username  	= $data->username;
				$level		= '<option value='.$data->level.'>'.$data->level.'</option>';
				if($this->session->userdata("level")==="ADMIN PPIC"){
				$level.= '<option value="">--PILIH--</option>
				          <option value="ADMIN PPIC">ADMIN PPIC</option>
				          <option value="PIMPINAN">PIMPINAN</option>
				          <option value="GUDANG">GUDANG</option>';
				}
			}
		}
		else
		{
			$kode_user 	= "";
			$username  	= "";
			$level		= "";
		}
		$data_res = array(
			"kode_user"		=> $kode_user,
			"username"		=> $username,
			"level"			=> $level,
		);

		echo json_encode($data_res);

	}

	function update_data()
	{
		$kode_user 	= $this->input->post("e_kd_user");
		$username 	= $this->input->post("e_username");
		$password 	= md5($this->input->post("e_password"));
		$level 		= $this->input->post("e_level");
		$sql_cek =  $this->db->from("tb_user A")
							 ->where("A.password", $password)
							 ->get()->num_rows();
		if ((empty($username)) or (empty($password)) or (empty($level)) ) 
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
						</span></b>Password Sudah Terpakai, Silahkan Masukan Password Lain.
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
				"kode_user" 	=> $kode_user,
				"username"		=> $username,
				"password"		=> $password,
				"level"			=> $level,
			);
			$update_data = $this->db->update("tb_user",$data_update,array("kode_user" => $kode_user));
			if($update_data)
			{
				$pesan 	= '<div class="alert alert-info" role="alert">
					     	<b><span class="glyphicon glyphicon-envelope">
							</span></b>Data Berhasil Diupdate.
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

	function hapus_data($kode_user)
	{
		$hapus_data = $this->db->delete("tb_user",array("kode_user" => $kode_user));
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