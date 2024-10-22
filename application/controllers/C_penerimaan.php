<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_penerimaan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_penerimaan');
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
		$status_kirim = array("BARU","SISA");
		$data["data_pengiriman"] = $this->db->from("tb_pengiriman A")
										 ->where_in("A.status_pengiriman",$status_kirim)
										 ->group_by("A.kode_pengiriman")
										 ->get()
										 ->result();
		$data["barang_data"] = $this->db->from("tb_barang A")
									    ->get()
									    ->result();
		$this->load->view('pages/penerimaan/f_penerimaan', $data);
		$this->load->view('template/menu_bar/control');
		//body end
		$this->load->view('template/menu_bar/footer');
	}

	function data_barang($kode_kirim)
	{
		$sql = $this->db->from("tb_detail_pengiriman A")
						->join("tb_barang B","B.kode_barang=A.kode_barang")
						->where('A.kode_pengiriman',$kode_kirim)
						->get();
			$pilih[] = '<option value="">--PILIH--</option>';
		foreach ($sql->result() as $data) {
			$kode_barang[]= '<option value="'.$data->id_dtpengiriman.'">'.$data->nama_barang.'</option>';
		}
		$data_fix = array_merge($pilih, $kode_barang);

		$data_res = array(
			"data_barang" => $data_fix,
		);

		echo json_encode($data_res);
	}

	function data_kirim()
	{
		$id_kirim = $this->input->post("id_kirim");
		$sql = $this->db->from("tb_detail_pengiriman A")
						->join("tb_detail_retur B","B.id_dtpengiriman=A.id_dtpengiriman","LEFT OUTER")
						->where("A.id_dtpengiriman", $id_kirim)
						->get()
						->row();
		$jumlah_kirim = number_format($sql->jumlah_barang_kirim);
		$jumlah_retur = $sql->jumlah_retur;
		if($jumlah_retur>0)
		{
			$retur = number_format($jumlah_retur);
		}
		else
		{
			$retur=0;
		}
		$data_res = array(
			"id_kirim" => $sql->kode_barang,
			"jumlah_kirim" => $jumlah_kirim,
			"jumlah_retur" => $retur,
		);
		echo json_encode($data_res);

	}

	function cek_validasi()
	{
		$jumlah_kirim =  $this->input->post("jumlah_kirim");
		$jumlah_retur =  $this->input->post("jumlah_retur");
		$jumlah_ng =  $this->input->post("jumlah_ng");
		$jumlah_terima =  $this->input->post("jumlah_terima");

		if(empty($jumlah_ng))
		{
			$jumlah_ng=0;
		}
		else
		{
			$jumlah_ng=$jumlah_ng;
		}
		$ng = $jumlah_kirim-$jumlah_retur;
		$terima = $jumlah_kirim-($jumlah_retur+$jumlah_ng);
		$total_ng = $jumlah_kirim-($jumlah_retur+$jumlah_terima);
		$total_terima = $jumlah_kirim-($jumlah_retur+$jumlah_ng);

		if($jumlah_ng > $ng)
		{
			$nilai_terima = "0";
			$nilai_ng = "0";
			$pesan_ng = "tidak valid";
			$pesan_terima = "";
		}
		else if($jumlah_terima > $terima)
		{
			$nilai_terima = "0";
			$nilai_ng = "0";
			$pesan_terima = "tidak valid";
			$pesan_ng = "";
		}
		else
		{
			$pesan_terima = "";
			$pesan_ng = "";
			$nilai_ng = $total_ng;
			$nilai_terima = $total_terima;
		}

		$data_res = array(
			"pesan_ng" => $pesan_ng,
			"pesan_terima" => $pesan_terima,
			"nilai_ng" => $nilai_ng,
			"nilai_terima" => $nilai_terima,
		);

		echo json_encode($data_res);
	}

	function pengiriman()
	{
		$kode_kirim = $this->input->post("kode_kirim");
		$sql = $this->db->from("tb_pengiriman A")
						->join("tb_subcont B","B.kode_subcont=A.kode_subcont")
						->where('A.kode_pengiriman', $kode_kirim)
						->get()
						->row();
		$nama_subcont = $sql->nama_subcont;
		$tanggal_kirim = $sql->tanggal_kirim;
		$tanggal_tiba = $sql->perkiraan_tanggal_tiba;
		$data_res = array(
			"nama_subcont" => $nama_subcont,
			"tanggal_kirim" => $tanggal_kirim,
			"tgl_tiba" => $tanggal_tiba,
		);
		echo json_encode($data_res);

	}
	function list_data_penerimaan()
    {
        $list = $this->M_penerimaan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $no;
            $row[] = $field->kode_penerimaan;
            $row[] = $field->kode_pengiriman;
            $row[] = $field->tanggal_terima;
            $row[] = $field->username;
            $row[] = $field->jumlah_barang_kirim;
            $row[] = $field->jumlah_retur;
            $row[] = $field->jumlah_NG;
            $row[] = $field->jumlah_terima;
            if($field->jumlah_sisa > 0 )
            {
            	$row[] = "<button type='button' onClick='sisa_".$no."(this)' value=".$field->id_dtpenerimaan." id='sisa_".$no."'
            		 class='btn btn-warning btn-xs'>".$field->jumlah_sisa."</button>";
            }
            else
            {
            	$row[] = $field->jumlah_sisa;
        	}
            $row[] = '<a href="'.base_url('C_penerimaan/print_penerimaan/'.$field->kode_penerimaan).'" class="btn btn-primary btn-xs">Print</a>';

            // $row[] = "<button type='button' onClick='edit_data_".$no."()' value=".$field->kode_penerimaan." id='edit_id_".$no."'
            // 		 class='btn btn-warning btn-xs'>EDIT</button>";
            if($this->session->userdata("level")==="ADMIN PPIC"){
                $row[] = "<button type='button' onClick='hapus_data_".$no."()' value=".$field->kode_penerimaan." id='hapus_id_".$no."' class='btn btn-danger btn-xs'>HAPUS</button>";
            }
            else
            {
                $row[]="";
            }
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_penerimaan->count_all(),
                        "recordsFiltered" => $this->M_penerimaan->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

	function simpan_data()
	{
		$kode_user 	= $this->session->userdata("kode_user");
		$kode_penerimaan = $this->Generate_kode->kode_penerimaan();
		$tanggal 	= date("Y-m-d");
		$kode_pengiriman = $this->input->post("pengiriman_add");


		$id_kirim 		= $this->input->post("barang_add");
		$jumlah_kirim 	= $this->input->post("jumlah_kirim");
		$jumlah_retur 	= $this->input->post("jumlah_retur");
		$jumlah_ng 		= $this->input->post("jumlah_ng");
		$jumlah_terima 	= $this->input->post("jumlah_terima");
		$kode_barang 	= $this->input->post("id_dtkirim");

		$duplicates=0;
		    foreach($id_kirim as $k => $i){
		    	$kd_brg[] = $kode_barang;
		        // if(!isset($value_{$i})){
		        //     $value_{$i}=TRUE;
		        // }
		        // else{
		        //     $duplicates|=TRUE;
		        // }
		        $ng_cek[] 	= trim($jumlah_ng[$k]);
		        $terima_cek[] = trim($jumlah_terima[$k]);
		        if ((empty($ng_cek)) or (empty($terima_cek)))
		        {
		        	$field = "kosong";
		        }
		        else
		        {
		        	$field = "ok";
		        }

		        $sisa[] = $jumlah_kirim[$k]-($jumlah_retur[$k]+$jumlah_ng[$k]+$jumlah_terima[$k]);
		        $jumlah_sisa = array_sum($sisa);
		        if($jumlah_sisa > 0)
		        {
		        	$status = "SISA";
		        }
		        else
		        {
		        	$status = "SELESAI";
		        }

    	}

    	// var_dump($duplicates);
    	// var_dump($jumlah_sisa);
    	// var_dump($status);die();

		if (empty($kode_pengiriman))
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

		else if (($duplicates==1) or ($field==="kosong"))
		{
			$pesan 	= '<div class="alert alert-danger" role="alert">
				     	<b><span class="glyphicon glyphicon-envelope">
						</span></b>Duplikat Data Atau Data Tidak  Lengkap.
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
		$sql = $this->db->select("A.stok_barang")
			                ->from("tb_barang A")
							->where_in('A.kode_barang',$kode_barang)
							->get();
		foreach ($sql->result() as $stb) {
			$stok[] = $stb->stok_barang;
		}

		$update_status = $this->db->query("UPDATE tb_pengiriman SET status_pengiriman='$status' where kode_pengiriman='$kode_pengiriman'");

			$data_simpan = array(
				"kode_penerimaan" 		=> $kode_penerimaan,
				"kode_pengiriman"		=> $kode_pengiriman,
				"tanggal_terima"		=> $tanggal,
				"diterima_oleh"			=> $kode_user,
				"status_terima"			=> $status,
			);
			$simpan_data = $this->db->insert("tb_penerimaan",$data_simpan);
			$data_detail = array();
			foreach ($id_kirim as $key => $value) {
				$jumlah_sisa = $jumlah_kirim[$key]-($jumlah_retur[$key]+$jumlah_ng[$key]+$jumlah_terima[$key]);
				$data_value = array(
					"id_dtpengiriman" 		=> $value,
					"kode_penerimaan" 		=> $kode_penerimaan,
					"jumlah_terima" 		=> $jumlah_terima[$key],
					"jumlah_ng"				=> $jumlah_ng[$key],
					"jumlah_sisa"			=> $jumlah_sisa,
				);
				array_push($data_detail,$data_value);
			}
			$simpan_detail = $this->db->insert_batch("tb_detail_penerimaan", $data_detail);
			$barang = array();
			foreach ($id_kirim as $bg => $brg) {
			$update_stok = array(
					"kode_barang" => $kode_barang[$bg],
					"stok_barang" => $stok[$bg]+$jumlah_terima[$bg],
				);
			array_push($barang, $update_stok);
			}
			$update_stok = $this->db->update_batch("tb_barang", $barang,"kode_barang");

			if (($simpan_data) and ($simpan_detail))
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

	function terima_sisa($id_dtterima)
	{
		// $kode_penerimaan = $this->input->post("kode_penerimaan");
		// $id_dtterima = $this->input->post("id_dtterima");

		$sql = $this->db->from("tb_detail_penerimaan A")
						->join("tb_detail_pengiriman B","B.id_dtpengiriman=A.id_dtpengiriman")
						->join("tb_detail_retur C","C.id_dtpengiriman=B.id_dtpengiriman","LEFT")
						->join("tb_barang D","D.kode_barang=B.kode_barang")
						->where("A.id_dtpenerimaan",$id_dtterima)
						->get();
		$table = '<table class="table table-bordered table-striped" style="width:100%; table-layout:auto;">
				  <tr>
				   <td style="width: 300px;">Nama Barang</td>
				   <td style="width: 50px;">jml Kirim</td>
				   <td style="width: 50px;">jml retur</td>
				   <td style="width: 50px;">jml NG</td>
				   <td style="width: 50px;">jml Terima</td>
				   <td style="width: 50px;">jml sisa</td>
				  </tr>';

		foreach ($sql->result() as $data) {
		$table.='<tr>
					<td>
						<input type="hidden" name="id_dtterima" value="'.$data->id_dtpenerimaan.'">
						<input type="hidden" name="kode_barang" value="'.$data->kode_barang.'">
						<input type="hidden" name="kode_penerimaan" value="'.$data->kode_penerimaan.'">
						<input type="hidden" name="kode_pengiriman" value="'.$data->kode_pengiriman.'">
						'.$data->nama_barang.'
					</td>
					<td>
						'.$data->jumlah_barang_kirim.'
					</td>
					<td>
						'.$data->jumlah_retur.'
					</td>
					<td>
						'.$data->jumlah_NG.'
					</td>
					<td>
						'.$data->jumlah_terima.'
					</td>
					<td>
						<input type="hidden" name="sisa" id="sisa" value="'.$data->jumlah_sisa.'">
						<input type="text" name="jumlah_sisa" id="jumlah_sisa" class="form-control" required autocomplete="off" style="width:90px;" value="'.$data->jumlah_sisa.'" onkeypress="return hanyaAngka(event)" onkeyup="valid_sisa(this)"><span id="pesan_sisa"></span>
					</td>
				 </tr>';
		}
	$table.='</table>';

	$data_res = array(
		"data_sisa" => $table,
	);
	echo json_encode($data_res);
	}

	function cek_sisa($sisa, $jml_sisa='')
	{
		if($jml_sisa != $sisa)
		{
			$data_res = array(
				"sisa" => "okkk",
			);
		}
		else
		{
			$data_res = array(
				"sisa" => "",
			);
		}

		echo json_encode($data_res);
	}

	function update_sisa()
	{
		$kode_barang = $this->input->post("kode_barang");
		$id_dtterima = $this->input->post("id_dtterima");
		$jumlah_sisa = $this->input->post("jumlah_sisa");
		$kode_penerimaan = $this->input->post("kode_penerimaan");
		$kode_pengiriman = $this->input->post("kode_pengiriman");

		$cek_stok = $this->db->select("A.stok_barang")
							 ->from("tb_barang A")
							 ->where("A.kode_barang",$kode_barang)
							 ->get()->row();
		$cek_sisa = $this->db->from("tb_detail_penerimaan A")
						     ->where("A.id_dtpenerimaan",$id_dtterima)
						     ->get()->row();

		$cek_status =  $this->db->from("tb_penerimaan A")
								->join("tb_detail_penerimaan B","B.kode_penerimaan=A.kode_penerimaan")
								->where("A.kode_penerimaan",$kode_penerimaan)
								->where("jumlah_sisa > 0")
								->get();
		$status = $cek_status->num_rows();

		if($status===1)
		{
			// var_dump($status);die();
			$update_status = array(
				"status_terima" => "SELESAI",
			);

			$update_pengiriman = array(
				"status_pengiriman" => "SELESAI",
			);

			$sisa_update = $this->db->update("tb_penerimaan", $update_status,array("kode_penerimaan" => $kode_penerimaan));
			$sisa_pengiriman = $this->db->update("tb_pengiriman", $update_pengiriman,array("kode_pengiriman" => $kode_pengiriman));
		}

		$update_stok = array(
			"stok_barang" => $cek_stok->stok_barang+$jumlah_sisa,
		);
		$update = $this->db->update("tb_barang",$update_stok,array("kode_barang"=> $kode_barang));
		$update_sisa = array(
			"jumlah_terima" => $cek_sisa->jumlah_terima+$jumlah_sisa,
			"jumlah_sisa" => "0",
		);
		$update_sisa = $this->db->update("tb_detail_penerimaan",$update_sisa,array("id_dtpenerimaan" => $id_dtterima));

		$data_res = array(
			"pesan_validasi" => "",
			"pesan_gagal" => "",
			"pesan_sukses"  => "okkkk",
		);
		echo json_encode($data_res);


	}

	function print_penerimaan($kode_penerimaan)
	{
		$this->load->library('fpdf_general');
		$pdf = new fpdf_general('P','cm',array(21,30));
		$pdf->AddPage();
        $pdf->AliasNbPages();

        $data= $this->db->from("tb_penerimaan A")
						->join("tb_detail_penerimaan B","B.kode_penerimaan=A.kode_penerimaan")
						->join("tb_detail_pengiriman C","C.id_dtpengiriman=B.id_dtpengiriman")
						->join("tb_pengiriman D","D.kode_pengiriman=C.kode_pengiriman")
						->join("tb_subcont E","E.kode_subcont=D.kode_subcont")
						->join("tb_barang F","C.kode_barang=F.kode_barang")
						->join("tb_detail_retur G","G.id_dtpengiriman=C.id_dtpengiriman","LEFT OUTER")
						->where("A.kode_penerimaan",$kode_penerimaan)
						->get();

        // header
		$head = $data->row();
		$pdf->cell(0,0.5,"Pernerimaan Barang",0,1,"C");
		$pdf->cell(3,0.5,"kode Penerimaan",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->kode_penerimaan,0,1,"L");

		$pdf->cell(3,0.5,"Tanggal",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->tanggal_terima,0,1,"L");

		$pdf->cell(3,0.5,"Status Terima",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->status_terima,0,1,"L");

		$pdf->cell(3,0.5,"Subcont",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(0,0.5,$head->nama_subcont,0,1,"L");

		$pdf->cell(3,0.5,"Alamat",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(0,0.5,$head->alamat_subcont.' '.$head->no_tlp.' '.$head->email,0,1,"L");

		// $pdf->cell(3,0.5,"Tanggal retur",0,0,"L");
		// $pdf->cell(0.2,0.5,":",0,0,"L");
		// $pdf->cell(10,0.5,$head->tanggal_retur,0,1,"L");

        $pdf->ln(0.2);

        $pdf->cell(1,0.5,"NO",1,0,"L");
        $pdf->cell(5,0.5,"Nama Barang",1,0,"L");
        $pdf->cell(3,0.5,"tanggal Terima",1,0,"L");
        $pdf->cell(2,0.5,"jml Kirim",1,0,"L");
        $pdf->cell(2,0.5,"jml Retur",1,0,"L");
        $pdf->cell(2,0.5,"jml NG",1,0,"L");
        $pdf->cell(2,0.5,"jml Terima",1,0,"L");
        $pdf->cell(2,0.5,"jml Sisa",1,1,"L");

        $no = 0;
        foreach ($data->result() as $item){
        @$total_kirim  += $item->jumlah_barang_kirim;
        @$total_retur  += $item->jumlah_retur;
        @$total_NG     += $item->jumlah_NG;
        @$total_terima += $item->jumlah_terima;
        @$total_sisa   += $item->jumlah_sisa;
        $no++;
        $pdf->SetWidths(array(1,5,3,2,2,2,2,2,));
        $pdf->Row(
            array(
            $no,
            $item->nama_barang,
            $item->tanggal_terima,
            $item->jumlah_barang_kirim,
            $item->jumlah_retur,
            $item->jumlah_NG,
            $item->jumlah_terima,
            $item->jumlah_sisa,
			));
    	}
    	$pdf->cell(9,0.6,'TOTAL',1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_kirim,2),1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_retur,2),1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_NG,2),1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_terima,2),1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_sisa,2),1,0,'L');
        $pdf->Output();
	}

	function hapus_data($kode_penerimaan)
	{
		$hapus_data 	= $this->db->delete("tb_penerimaan",array("kode_penerimaan" => $kode_penerimaan));
		$hapus_detail 	= $this->db->delete("tb_detail_penerimaan",array("kode_penerimaan" => $kode_penerimaan));
		if($hapus_data)
			{
				$pesan 	= '<div class="alert alert-danger" role="alert">
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
