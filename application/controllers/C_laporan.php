<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan extends CI_Controller {

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

	public function laporan_pengiriman()
	{
		$this->load->view('template/js/js');
		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		
		$data["subcont"] = $this->db->from("tb_subcont A")
									->order_by("A.nama_subcont ASC")
									->get()
									->result();
		$data["barang"] = $this->db->from("tb_barang A")
								   ->order_by("A.nama_barang ASC")
								   ->get()
								   ->result();
		$this->load->view('pages/laporan/f_laporan_pengiriman',$data);
		$this->load->view('template/menu_bar/control'); 
		//body end
		$this->load->view('template/menu_bar/footer');
	}


	function laporan_pengiriman_view()
	{
		$date1 		= $this->input->post("date1");
		$date2 		= $this->input->post("date2");
		$subcont 	= $this->input->post("subcont");
		$barang 	= $this->input->post("barang");
		$this->load->library('fpdf_general');
		$pdf = new fpdf_general('P','cm',array(21,30)); 
		$pdf->AddPage();
        $pdf->AliasNbPages();

        $data= $this->db->from("tb_pengiriman A")
        				->join("tb_detail_pengiriman B", "B.kode_pengiriman=A.kode_pengiriman")
        				->join("tb_subcont C","C.kode_subcont=A.kode_subcont")
        				->join("tb_barang D","D.kode_barang=B.kode_barang")
        				->where("A.tanggal_kirim >= '$date1'")
        				->where("A.tanggal_kirim <= '$date2'")
        				->where("C.kode_subcont like '%$subcont%'")
        				->where("D.kode_barang like '%$barang%'")
        				->get();

        // header
		$head = $data->row();
		$pdf->cell(0,0.5,"Laporan Data Pengiriman Periode ".$date1." s/d ".$date2 ,0,1,"C");
        $pdf->ln(0.2);

        $pdf->cell(1,0.5,"NO",1,0,"L");
        $pdf->cell(5,0.5,"Nama subcont",1,0,"L");
        $pdf->cell(3,0.5,"Tgl Kirim",1,0,"L");
        $pdf->cell(3,0.5,"tgl Tiba",1,0,"L");
        $pdf->cell(5,0.5,"Nama Barang",1,0,"L");
        $pdf->cell(2,0.5,"Jml Kirim",1,1,"L");
        
        
        $no=0;
        foreach ($data->result() as $item){
        @$total_kirim += $item->jumlah_barang_kirim;
        $no++;
        $pdf->SetWidths(array(1,5,3,3,5,2));
        $pdf->Row(
            array(
            $no,
            $item->nama_subcont,
            $item->tanggal_kirim,
            $item->perkiraan_tanggal_tiba,
            $item->nama_barang,
            $item->jumlah_barang_kirim,
          ));
    	}
    	$pdf->cell(17,0.6,'TOTAL',1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_kirim,2),1,0,'L');
        $pdf->Output();
	}

	public function laporan_retur()
	{
		$this->load->view('template/js/js');
		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		
		$data["subcont"] = $this->db->from("tb_subcont A")
									->order_by("A.nama_subcont ASC")
									->get()
									->result();
		$data["barang"] = $this->db->from("tb_barang A")
								   ->order_by("A.nama_barang ASC")
								   ->get()
								   ->result();
		$this->load->view('pages/laporan/f_laporan_retur',$data);
		$this->load->view('template/menu_bar/control'); 
		//body end
		$this->load->view('template/menu_bar/footer');
	}


	function laporan_retur_view()
	{
		$date1 		= $this->input->post("date1");
		$date2 		= $this->input->post("date2");
		$subcont 	= $this->input->post("subcont");
		$this->load->library('fpdf_general');
		$pdf = new fpdf_general('P','cm',array(21,30)); 
		$pdf->AddPage();
        $pdf->AliasNbPages();

        $data= $this->db->from("tb_pengiriman A")
        				->join("tb_detail_pengiriman B", "B.kode_pengiriman=A.kode_pengiriman")
        				->join("tb_subcont C","C.kode_subcont=A.kode_subcont")
        				->join("tb_barang D","D.kode_barang=B.kode_barang")
        				->join("tb_detail_retur E","E.id_dtpengiriman=B.id_dtpengiriman")
        				->join("tb_retur F","F.kode_retur=E.kode_retur")
        				->where("A.tanggal_kirim >= '$date1'")
        				->where("A.tanggal_kirim <= '$date2'")
        				->where("C.kode_subcont like '%$subcont%'")
        				->get();

        // header
		$head = $data->row();
		$pdf->cell(0,0.5,"Laporan Data Retur Periode ".$date1." s/d ".$date2 ,0,1,"C");
        $pdf->ln(0.2);

        $pdf->cell(1,0.5,"NO",1,0,"L");
        $pdf->cell(5,0.5,"Nama subcont",1,0,"L");
        $pdf->cell(2.2,0.5,"Tgl Kirim",1,0,"L");
        $pdf->cell(2.2,0.5,"Tgl retur",1,0,"L");
        $pdf->cell(5,0.5,"Nama Barang",1,0,"L");
        $pdf->cell(2,0.5,"Jml Kirim",1,0,"L");
        $pdf->cell(2,0.5,"Jml Retur",1,1,"L");
        
        
        $no=0;
        $total_kirim=0;
        $total_retur=0;
        foreach ($data->result() as $item){
        @$total_kirim += $item->jumlah_barang_kirim;
        @$total_retur += $item->jumlah_retur;
        $no++;
        $pdf->SetWidths(array(1,5,2.2,2.2,5,2,2));
        $pdf->Row(
            array(
            $no,
            $item->nama_subcont,
            $item->tanggal_kirim,
            $item->tanggal_retur,
            $item->nama_barang,
            $item->jumlah_barang_kirim,
            $item->jumlah_retur,
          ));
    	}
    	$pdf->cell(15.4,0.6,'TOTAL',1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_kirim,2),1,0,'L');
    	$pdf->cell(2,0.6,number_format($total_retur,2),1,0,'L');
        $pdf->Output();
	}

	public function laporan_penerimaan()
	{
		$this->load->view('template/js/js');
		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		
		$data["subcont"] = $this->db->from("tb_subcont A")
									->order_by("A.nama_subcont ASC")
									->get()
									->result();
		$data["barang"] = $this->db->from("tb_barang A")
								   ->order_by("A.nama_barang ASC")
								   ->get()
								   ->result();
		$this->load->view('pages/laporan/f_laporan_penerimaan',$data);
		$this->load->view('template/menu_bar/control'); 
		//body end
		$this->load->view('template/menu_bar/footer');
	}

	function laporan_penerimaan_view()
	{
		$date1 		= $this->input->post("date1");
		$date2 		= $this->input->post("date2");
		$subcont 	= $this->input->post("subcont");
		$status 	= $this->input->post("status");
		$this->load->library('fpdf_general');
		$pdf = new fpdf_general('P','cm',array(21,30)); 
		$pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetLeftMargin(0.5);

        $data= $this->db->from("tb_pengiriman A")
        				->join("tb_detail_pengiriman B", "B.kode_pengiriman=A.kode_pengiriman")
        				->join("tb_subcont C","C.kode_subcont=A.kode_subcont")
        				->join("tb_barang D","D.kode_barang=B.kode_barang")
        				->join("tb_detail_retur E","E.id_dtpengiriman=B.id_dtpengiriman","LEFT")
        				->join("tb_retur F","F.kode_retur=E.kode_retur","LEFT")
        				->join("tb_detail_penerimaan G","G.id_dtpengiriman=B.id_dtpengiriman")
        				->join("tb_penerimaan H","H.kode_penerimaan=G.kode_penerimaan")
        				->where("A.tanggal_kirim >= '$date1'")
        				->where("A.tanggal_kirim <= '$date2'")
        				->where("C.kode_subcont like '%$subcont%'")
        				->where("A.status_pengiriman like '%$status%'" )
        				->get();

        // header
		$head = $data->row();
		$pdf->cell(0,0.5,"Laporan Data Retur Periode ".$date1." s/d ".$date2 ,0,1,"C");
        $pdf->ln(0.2);

        $pdf->cell(1,0.5,"NO",1,0,"L");
        $pdf->cell(4,0.5,"Nama subcont",1,0,"L");
        $pdf->cell(2.2,0.5,"Tgl terima",1,0,"L");
        $pdf->cell(4,0.5,"Nama Barang",1,0,"L");
        $pdf->cell(1.4,0.5,"Kirim",1,0,"L");
        $pdf->cell(1.4,0.5,"Retur",1,0,"L");
        $pdf->cell(1.2,0.5,"NG",1,0,"L");
        $pdf->cell(1.5,0.5,"Terima",1,0,"L");
        $pdf->cell(1.4,0.5,"Sisa",1,0,"L");
        $pdf->cell(1.7,0.5,"Status",1,1,"L");
        
        
        $no=0;
        $total_kirim=0;
        $total_retur=0;
        $total_ng=0;
        $total_terima=0;
        $total_sisa=0;

        foreach ($data->result() as $item){
        @$total_kirim += $item->jumlah_barang_kirim;
        @$total_retur += $item->jumlah_retur;
        @$total_ng += $item->jumlah_NG;
        @$total_terima += $item->jumlah_terima;
        @$total_sisa += $item->jumlah_sisa;

        $no++;
        $pdf->SetWidths(array(1,4,2.2,4,1.4,1.4,1.2,1.5,1.4,1.7));
        $pdf->Row(
            array(
            $no,
            $item->nama_subcont,
            $item->tanggal_terima,
            $item->nama_barang,
            $item->jumlah_barang_kirim,
            $item->jumlah_retur,
            $item->jumlah_NG,
            $item->jumlah_terima,
            $item->jumlah_sisa,
            $item->status_pengiriman,
          ));
    	}
    	$pdf->cell(11.2,0.6,'TOTAL',1,0,'L');
    	$pdf->cell(1.4,0.6,number_format($total_kirim,2),1,0,'L');
    	$pdf->cell(1.4,0.6,number_format($total_retur,2),1,0,'L');
    	$pdf->cell(1.2,0.6,number_format($total_ng,2),1,0,'L');
    	$pdf->cell(1.5,0.6,number_format($total_terima,2),1,0,'L');
    	$pdf->cell(1.4,0.6,number_format($total_sisa,2),1,0,'L');
        $pdf->Output();
	}

    public function laporan_stok()
    {
        $this->load->view('template/js/js');
        $this->load->view('template/css/css');
        $this->load->view('template/menu_bar/top_bar');
        $this->load->view('template/menu_bar/sidebar');
    
        $this->load->view('pages/laporan/f_laporan_stok');
        $this->load->view('template/menu_bar/control'); 
        //body end
        $this->load->view('template/menu_bar/footer');
    }

    function laporan_stok_view()
    {
        $date1      = $this->input->post("date1");
        $date2      = $this->input->post("date2");
        $subcont    = $this->input->post("subcont");
        $status     = $this->input->post("status");
        $this->load->library('fpdf_general');
        $pdf = new fpdf_general('P','cm',array(21,30)); 
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetLeftMargin(0.5);

        $data= $this->db->from("tb_penerimaan A")
                        ->join("tb_detail_penerimaan B","B.kode_penerimaan=A.kode_penerimaan")
                        ->join("tb_detail_pengiriman C","C.id_dtpengiriman=B.id_dtpengiriman")
                        ->join("tb_barang D","D.kode_barang=C.kode_barang")
                        ->where("A.tanggal_terima >= '$date1'")
                        ->where("A.tanggal_terima <= '$date2'")
                        ->get();

        // header
        $head = $data->row();
        $pdf->cell(0,0.5,"Laporan Data Retur Periode ".$date1." s/d ".$date2 ,0,1,"C");
        $pdf->ln(0.2);

        $pdf->cell(1,0.5,"NO",1,0,"L");
        $pdf->cell(3,0.5,"Kode Barang",1,0,"L");
        $pdf->cell(5,0.5,"Nama Barang",1,0,"L");
        $pdf->cell(4,0.5,"Jenis Barang",1,0,"L");
        $pdf->cell(4,0.5,"Kategori Barang",1,0,"L");
        $pdf->cell(2,0.5,"Stok",1,1,"L");
        
        
        $no=0;
        $stok=0;

        foreach ($data->result() as $item){
        @$total_stok += $item->stok_barang;

        $no++;
        $pdf->SetWidths(array(1,3,5,4,4,2,));
        $pdf->Row(
            array(
            $no,
            $item->kode_barang,
            $item->nama_barang,
            $item->jenis_barang,
            $item->kategori_barang,
            $item->stok_barang,
          ));
        }
        $pdf->cell(17,0.6,'TOTAL',1,0,'L');
        $pdf->cell(2,0.6,number_format($total_stok,2),1,0,'L');
        $pdf->Output();
    }

}