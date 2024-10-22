<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_retur extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_retur');
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
		$data["data_pengiriman"] = $this->db->from("tb_pengiriman A")
										->where("A.status_pengiriman","BARU")
										 ->get()
										 ->result();
		$data["barang_data"] = $this->db->from("tb_barang A")
									    ->get()
									    ->result();
		$this->load->view('pages/retur/f_retur', $data);
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
						->where("A.id_dtpengiriman", $id_kirim)
						->get()
						->row();
		$jumlah_kirim = $sql->jumlah_barang_kirim;
		$data_res = array(
			"jumlah_kirim" => $jumlah_kirim,
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
	function list_data_retur()
    {
        $list = $this->M_retur->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $no;
            $row[] = $field->kode_retur;
            $row[] = $field->tanggal_retur;
            $row[] = $field->nama_subcont;
            $row[] = $field->nama_barang;
            $row[] = $field->jumlah_barang_kirim;
            $row[] = $field->jumlah_retur;
            $row[] = '<a href="'.base_url('C_retur/print_retur/'.$field->kode_retur).'" class="btn btn-primary btn-xs">Print</a>';

            // $row[] = "<button type='button' onClick='edit_data_".$no."()' value=".$field->kode_retur." id='edit_id_".$no."'
            // 		 class='btn btn-warning btn-xs'>EDIT</button>";
            if($this->session->userdata("level")==="ADMIN PPIC"){
                $row[] = "<button type='button' onClick='hapus_data_".$no."()' value=".$field->kode_retur." id='hapus_id_".$no."' class='btn btn-danger btn-xs'>HAPUS</button>";
            }
            else
            {
                $row[]="";
            }
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_retur->count_all(),
                        "recordsFiltered" => $this->M_retur->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

	function simpan_data()
	{
		$kode_user 	= $this->session->userdata("kode_user");
		$kode_retur = $this->Generate_kode->kode_retur();
		$tanggal 	= date("Y-m-d");
		$kode_pengiriman = $this->input->post("pengiriman_add");

		$id_kirim 	= $this->input->post("barang_add");
		$jumlah_retur 	= $this->input->post("jumlah_retur");
		$keterangan = $this->input->post("Keterangan");

		$duplicates=0;
		    foreach($id_kirim as $k => $i){
		        // if(!isset($value_{$i})){
		        //     $value_{$i}=TRUE;
		        // }
		        // else{
		        //     $duplicates|=TRUE;
		        // }
		        $jumlah_cek 	= trim($jumlah_retur[$k]);
		        $keterangan_cek = trim($keterangan[$k]);
		        if ((empty($jumlah_cek)) or (empty($keterangan_cek)))
		        {
		        	$field = "kosong";
		        }
		        else
		        {
		        	$field = "ok";
		        }

    	}

    	// var_dump($id_kirim);
    	// var_dump($jumlah_retur);
    	// var_dump($keterangan);die();

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
			$data_simpan = array(
				"kode_retur" 		=> $kode_retur,
				"tanggal_retur"		=> $tanggal,
				"diterima_oleh"		=> $kode_user,
			);
			$simpan_data = $this->db->insert("tb_retur",$data_simpan);

			$data_detail = array();
			foreach ($id_kirim as $key => $value) {
				$data_value = array(
					"id_dtpengiriman" 	=> $value,
					"kode_retur" 		=> $kode_retur,
					"jumlah_retur" 		=> $jumlah_retur[$key],
					"keterangan_retur"	=> $keterangan[$key],
				);
				array_push($data_detail,$data_value);
			}
			$simpan_detail = $this->db->insert_batch("tb_detail_retur", $data_detail);
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

	function print_retur($kode_retur)
	{
		$this->load->library('fpdf_general');
		$pdf = new fpdf_general('P','cm',array(21,30));
		$pdf->AddPage();
        $pdf->AliasNbPages();

        $data= $this->db->from("tb_retur A")
			            ->join("tb_detail_retur B","B.kode_retur=A.kode_retur")
			            ->join("tb_detail_pengiriman C","C.id_dtpengiriman=B.id_dtpengiriman")
			            ->join("tb_barang D","D.kode_barang=C.kode_barang")
			            ->join("tb_pengiriman E","E.kode_pengiriman=C.kode_pengiriman")
			            ->join("tb_subcont F","F.kode_subcont=E.kode_subcont")
			            ->where("A.kode_retur",$kode_retur)
			            ->get();

        // header
		$head = $data->row();
		$pdf->cell(0,0.5,"Retur Barang",0,1,"C");
		$pdf->cell(3,0.5,"kode retur",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->kode_retur,0,1,"L");

		$pdf->cell(3,0.5,"kode pengiriman",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->kode_pengiriman,0,1,"L");

		$pdf->cell(3,0.5,"Nama Subcont",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->nama_subcont,0,1,"L");

		$pdf->cell(3,0.5,"Alamat",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(0,0.5,$head->alamat_subcont.' '.$head->no_tlp.' '.$head->email,0,1,"L");

		// $pdf->cell(3,0.5,"Tanggal retur",0,0,"L");
		// $pdf->cell(0.2,0.5,":",0,0,"L");
		// $pdf->cell(10,0.5,$head->tanggal_retur,0,1,"L");

        $pdf->ln(0.2);

        $pdf->cell(1,0.5,"NO",1,0,"L");
        $pdf->cell(5,0.5,"Nama Barang",1,0,"L");
        $pdf->cell(3,0.5,"tanggal Retur",1,0,"L");
        $pdf->cell(2,0.5,"jml Kirim",1,0,"L");
        $pdf->cell(2,0.5,"jml Retur",1,0,"L");
        $pdf->cell(5,0.5,"keterangan",1,1,"L");

        $no=0;
        foreach ($data->result() as $item){
        @$total_kirim += $item->jumlah_barang_kirim;
        @$total_retur += $item->jumlah_retur;
        $no++;
        $pdf->SetWidths(array(1,5,3,2,2,5));
        $pdf->Row(
            array(
            $no,
            $item->nama_barang,
            $item->tanggal_retur,
            $item->jumlah_barang_kirim,
            $item->jumlah_retur,
            $item->keterangan_retur,
          ));
    	}
    	$pdf->cell(9,0.6,'TOTAL',1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_kirim,2),1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_retur,2),1,0,'L');
    	$pdf->cell(5,0.6,'',1,1,'L');
        $pdf->Output();
	}














    // not use
	function edit_data($kode_pengiriman)
	{
		$sql = $this->db->from("tb_pengiriman A")
						->join("tb_detail_pengiriman B","B.kode_pengiriman=A.kode_pengiriman")
						->join("tb_subcont C","C.kode_subcont=A.kode_subcont")
						->join("tb_barang D","D.kode_barang=B.kode_barang")
						->where("A.kode_pengiriman",$kode_pengiriman)
						->get();

		$subcont = $this->db->from("tb_subcont A")
										 ->get()
										 ->result();
		$barang = $this->db->from("tb_barang A")
						   ->get()
						   ->result();

		$tabel_detail = ' <table class="table table-striped table-bordered" id="customFields_edit">
					         <tr>
					           <td>No</td>
					           <td>Barang / Subcont</td>
					           <td>Jumlah Kirim</td>
					           <td></td>
					         </tr>';

		$pilih[] = '<option value="">--PILIH--</option>';
		foreach ($subcont as $sbc) {
			$data_subcont[] = '<option value="'.$sbc->kode_subcont.'">'.$sbc->nama_subcont.'</option>';
		}

		if($sql->num_rows() > 0)
		{
			$no=0;
			$data_sbc = $sql->row();
			$subcont[] = '<option value="'.$data_sbc->kode_subcont.'">'.$data_sbc->nama_subcont.'</option>';
			foreach ($sql->result() as $data) {
				$no++;
				$kode_pengiriman = $data->kode_pengiriman;
				$tanggal_kirim = $data->tanggal_kirim;
				$perkiraan_tanggal_tiba = $data->perkiraan_tanggal_tiba;

				$tabel_detail.='<tr>
									<td>'.$no.'<input type="hidden" name="id_dtpengiriman[]" value="'.$data->id_dtpengiriman.'"</td>
									<td><select name="barang_edit[]" class="form-control select2_class" id="barang_'.$no.'" style="width: 100%;" required>
										<option value="'.$data->kode_barang.'">'.$data->nama_barang.'</option>
        								<option value="">--PILIH--</option>';
        								foreach ($barang as $brg) {
        								$tabel_detail.='<option value="'.$brg->kode_barang.'">'.$brg->nama_barang.'</option>';
        								}
        								$tabel_detail.='</select>
        							</td>
        							<td>
        								<input type="text" name="jumlah_kirim_edit[]" id="jumlah_kirim_'.$no.'" class="form-control" required autocomplete="off" style="width:90px;" onkeypress="return hanyaAngka(event)" value="'.$data->jumlah_barang_kirim.'">
        							</td>
								</tr>';

			}
			$tabel_detail.='</tbody></table>';
		}
		else
		{
			$kode_pengiriman ='';
			 $subcont_fix='';
			 $tanggal_kirim='';
			 $perkiraan_tanggal_tiba='';
			 $tabel_detail='';
		}

		$subcont_fix =array_merge($subcont,$pilih,$data_subcont);
		$data_res = array(
			"kode_pengiriman" => $kode_pengiriman,
			"kode_subcont"	=> $subcont_fix,
			"tanggal_kirim"	=> $tanggal_kirim,
			"tanggal_tiba"  => $perkiraan_tanggal_tiba,
			"tabel_data"	=> $tabel_detail,
		);

		echo json_encode($data_res);

	}

	function update_data()
	{
		$kode_pengiriman 	= $this->input->post("kode_pengiriman");
		$kode_subcont_edit 	= $this->input->post("kode_subcont_edit");
		$tanggal_kirim_edit = $this->input->post("tanggal_kirim_edit");
		$tanggal_tiba_edit 	= $this->input->post("tanggal_tiba_edit");


		$id_dtpengiriman 	= $this->input->post("id_dtpengiriman");
		$barang_edit 		= $this->input->post("barang_edit");
		$jum_kirim_edit 	= $this->input->post("jumlah_kirim_edit");

		$duplicates=0;
        foreach($id_dtpengiriman as $k => $i){
        	// $barang = $barang_edit[$k];
            // if(!isset($value_{$barang})){
            //     $value_{$barang}=TRUE;
            // }
            // else{
            //     $duplicates|=TRUE;
            // }
            $barang_cek = trim($barang_edit[$k]);
            $jumlah_cek = trim($jum_kirim_edit[$k]);
            if ((empty($barang_cek)) or (empty($jumlah_cek)))
            {
              $field = "kosong";
            }
            else
            {
              $field = "ok";
            }

      	}

	    if ((empty($kode_subcont_edit)) or (empty($tanggal_kirim_edit)) or (empty($tanggal_tiba_edit)))
	    {
	      $pesan  = '<div class="alert alert-danger" role="alert">
	              <b><span class="glyphicon glyphicon-envelope">
	            </span></b>Lengkapi Data.
	                </div>';
	      $data_res   = array(
	        "pesan_validasi" => $pesan,
	        "pesan_gagal" => "",
	        "pesan_sukses"  => "",
	      );
	      echo json_encode($data_res);
	    }


	    else if (($duplicates==1) or ($field==="kosong"))
	    {
	      $pesan  = '<div class="alert alert-danger" role="alert">
	              		<b><span class="glyphicon glyphicon-envelope">
	            		</span></b>Duplikat Data Atau Data Tidak  Lengkap.
	                </div>';
	      $data_res   = array(
	        "pesan_validasi" => $pesan,
	        "pesan_gagal" => "",
	        "pesan_sukses"  => "",
	      );
	      echo json_encode($data_res);
	    }
	    else
	    {
	      $data_update = array(
	        "kode_subcont"      	=> $kode_subcont_edit,
	        "tanggal_kirim"      	=> $tanggal_kirim_edit,
	        "perkiraan_tanggal_tiba"=> $tanggal_tiba_edit,
	      );
	      $update_data = $this->db->update("tb_pengiriman",$data_update,array("kode_pengiriman" => $kode_pengiriman));

	      $data_detail = array();
	      foreach ($id_dtpengiriman as $key => $value) {
	        $data_value = array(
	          "id_dtpengiriman" => $value,
	          "kode_pengiriman" => $kode_pengiriman,
	          "kode_barang"     => $barang_edit[$key],
	          "jumlah_barang_kirim" => $jum_kirim_edit[$key],
	        );
	        array_push($data_detail,$data_value);
	      }
	      $update_detail = $this->db->update_batch("tb_detail_pengiriman", $data_detail,"id_dtpengiriman");
	      if (($update_data) )
	      {
	        $pesan  = '<div class="alert alert-info" role="alert">
	                	<b><span class="glyphicon glyphicon-envelope">
	              		</span></b>Data Berhasil DiSimpan.
	                  </div>';
	        $data_res   = array(
	          "pesan_validasi" => "",
	          "pesan_gagal" => "",
	          "pesan_sukses"  => $pesan,
	        );
	        echo json_encode($data_res);
	      }
	      else
	      {
	        $pesan  = '<div class="alert alert-danger" role="alert">
	                	<b><span class="glyphicon glyphicon-envelope">
	              		</span></b>GAGAL.
	                  </div>';
	        $data_res   = array(
	          "pesan_validasi" => "",
	          "pesan_gagal" => $pesan,
	          "pesan_sukses"  => "",
	        );
	        echo json_encode($data_res);
	      }
	    }
	}

	function hapus_data($kode_retur)
	{
		$hapus_data 	= $this->db->delete("tb_retur",array("kode_retur" => $kode_retur));
		$hapus_detail 	= $this->db->delete("tb_detail_retur",array("kode_retur" => $kode_retur));
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

	function print_pengiriman($kode_pengiriman)
	{
		$this->load->library('fpdf_general');
		$pdf = new fpdf_general('P','cm',array(21,30));
		$pdf->AddPage();
        $pdf->AliasNbPages();

        $data= $this->db->from("tb_pengiriman A")
			            ->join("tb_detail_pengiriman B","B.kode_pengiriman=A.kode_pengiriman")
			            ->join("tb_subcont C","C.kode_subcont=A.kode_subcont")
			            ->join("tb_barang D","D.kode_barang=B.kode_barang")
			            ->join("tb_user E","E.kode_user=A.created_by")
			            ->where("A.kode_pengiriman",$kode_pengiriman)
			            ->get();

        // header
		$head = $data->row();
		$pdf->cell(3,0.5,"kode pengiriman",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->kode_pengiriman,0,1,"L");

		$pdf->cell(3,0.5,"Nama Subcont",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->nama_subcont,0,1,"L");

		$pdf->cell(3,0.5,"Alamat",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(0,0.5,$head->alamat_subcont.' '.$head->no_tlp.' '.$head->email,0,1,"L");

		$pdf->cell(3,0.5,"Tanggal Kirim",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->tanggal_kirim,0,1,"L");

		$pdf->cell(3,0.5,"Perkiraan tiba",0,0,"L");
		$pdf->cell(0.2,0.5,":",0,0,"L");
		$pdf->cell(10,0.5,$head->perkiraan_tanggal_tiba,0,1,"L");

        $pdf->ln(0.2);

        $pdf->cell(1,0.5,"NO",1,0,"L");
        $pdf->cell(5,0.5,"Nama Barang",1,0,"L");
        $pdf->cell(2,0.5,"jml Kirim",1,1,"L");

        $no=0;
        foreach ($data->result() as $item){
        @$total_kirim += $item->jumlah_barang_kirim;
        $no++;
        $pdf->SetWidths(array(1,5,2));
        $pdf->Row(
            array(
            $no,
            $item->nama_barang,
            $item->jumlah_barang_kirim
          ));
    	}
    	$pdf->cell(6,0.6,'TOTAL',1,0,'L');
    	$pdf->cell(2,0.6,$total_kirim,1,1,'L');
        $pdf->Output();
	}
}