<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_barang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_barang');
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
		$this->load->view('pages/barang/f_barang');
		$this->load->view('template/menu_bar/control'); 
		//body end
		$this->load->view('template/menu_bar/footer');
	}

	function list_data_barang()
    {
        $list = $this->M_barang->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $no;
            $row[] = $field->kode_barang;
            $row[] = $field->nama_barang;
            $row[] = $field->jenis_barang;
            $row[] = $field->kategori_barang;
            $row[] = $field->stok_barang;
            $row[] = "<button type='button' onClick='edit_data_".$no."()' value=".$field->kode_barang." id='edit_id_".$no."'
            		 class='btn btn-warning btn-xs'>EDIT</button>";
            if($this->session->userdata("level")==="ADMIN PPIC"){
                $row[] = "<button type='button' onClick='hapus_data_".$no."()' value=".$field->kode_barang." id='hapus_id_".$no."' class='btn btn-danger btn-xs'>HAPUS</button>";
            }
            else
            {
                $row[]="";
            }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_barang->count_all(),
                        "recordsFiltered" => $this->M_barang->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

	function simpan_data()
	{
		$kode_barang 	= $this->Generate_kode->kode_barang();
		$nama_barang 	= $this->input->post("barang_add");
		$jenis_barang 	= $this->input->post("jenis_add");
		$kategori_barang = $this->input->post("kategori_add");
		$sql_cek =  $this->db->from("tb_barang A")
							 ->where("A.nama_barang", $nama_barang)
							 ->where("A.jenis_barang", $jenis_barang)
							 ->where("A.kategori_barang", $kategori_barang)
							 ->get()->num_rows();
		if ((empty($nama_barang)) or (empty($jenis_barang)) or (empty($kategori_barang)) ) 
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
						</span></b>Barang Dengan Nama '.$nama_barang.' Sudah Ada.
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
				"kode_barang" 		=> $kode_barang,
				"nama_barang"		=> $nama_barang,
				"jenis_barang"		=> $jenis_barang,
				"kategori_barang"	=> $kategori_barang,
			);
			$simpan_data = $this->db->insert("tb_barang",$data_simpan);
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

	function edit_data($kode_barang)
	{
		$sql = $this->db->from("tb_barang A")
						->where("A.kode_barang",$kode_barang)
						->get();
		if($sql->num_rows() > 0)
		{
			foreach ($sql->result() as $data) {
				$kode_barang 	= $data->kode_barang;
				$nama_barang 	= $data->nama_barang;
				$jenis_barang 	= $data->jenis_barang;
				$kategori_barang = $data->kategori_barang;
				
			}
		}
		else
		{
			$kode_barang 	= "";
			$nama_barang 	= "";
			$jenis_barang 	= "";
			$kategori_barang = "";
		}
		$data_res = array(
			"kode_barang"		=> $kode_barang,
			"nama_barang"		=> $nama_barang,
			"jenis_barang"		=> $jenis_barang,
			"kategori_barang"	=> $kategori_barang,
		);

		echo json_encode($data_res);

	}

	function update_data()
	{
		$kode_barang 	= $this->input->post("kode_barang");
		$nama_barang 	= $this->input->post("barang_edit");
		$jenis_barang 	= $this->input->post("jenis_edit");
		$kategori_barang = $this->input->post("kategori_edit");
		$sql_cek =  $this->db->from("tb_barang A")
							 ->where("A.nama_barang", $nama_barang)
							 ->where("A.jenis_barang", $jenis_barang)
							 ->where("A.kategori_barang", $kategori_barang)
							 ->get()->num_rows();
		if ((empty($nama_barang)) or (empty($jenis_barang)) or (empty($kategori_barang)) ) 
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
						</span></b>Duplikat, Barang Sudah Ada
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
				"nama_barang"		=> $nama_barang,
				"jenis_barang"		=> $jenis_barang,
				"kategori_barang"	=> $kategori_barang,
			);
			$update_data = $this->db->update("tb_barang",$data_update,array("kode_barang" => $kode_barang));
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

	function hapus_data($kode_barang)
	{
		$hapus_data = $this->db->delete("tb_barang",array("kode_barang" => $kode_barang));
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