<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcobat_poli extends Secure_area {
	public function __construct(){
		parent::__construct();

		$this->load->model('master/mmobat_poli','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('logistik_farmasi/Frmmpo','',TRUE);
	}

	public function index(){ 

		$data['title'] = 'Master Obat Poli';

		$data['obat']=$this->mmobat_poli->get_all_obat()->result();
		$data['pilih_obat']=$this->mmobat_poli->get_obat()->result();
		$data['pilih_poli']=$this->mmobat_poli->get_poli()->result();
		$this->load->view('master/mvobat_poli',$data);

	}

	public function insert_obat(){

		$data['id_obat']=$this->input->post('id_obat');
		$data['id_poli']=$this->input->post('id_poli');
		$data['deleted'] = 0;
		//  var_dump($data);
		//  die();

			$this->mmobat_poli->insert_obat($data);
			$msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Disimpan!
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			</div>';

			$this->session->set_flashdata('success_msg', $msg);

			redirect('master/Mcobat_poli',$msg);

	}

	public function get_data_edit_obat(){
		$id_obat_poli=$this->input->post('id_obat_poli');
		$datajson=$this->mmobat_poli->get_data_obat($id_obat_poli)->result();
	    echo json_encode($datajson);
	}

	public function edit_obat(){
		$id_obat=$this->input->post('edit_id_obat_poli_hidden');

		$data['id_obat']=$this->input->post('edit_id_obat');
		$data['id_poli']=$this->input->post('edit_id_poli');

		$this->mmobat_poli->edit_obat($id_obat, $data);

		redirect('master/Mcobat_poli');
	}

	public function delete_obat(){
		$id_obat=$this->input->post('delete_id');
		$this->mmobat_poli->soft_delete_obat($id_obat);
		redirect('master/Mcobat_poli');

	}

	public function active_obat($id_obat){
		$this->mmobat_poli->active_obat($id_obat);
		redirect('master/Mcobat_poli');

	}

    function cari_data_obat(){
	    $login_data = $this->load->get_var("user_info");
	    $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

	    $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
	    $i=1;
	    if(!empty($id_gudang)){
		    foreach ($id_gudang as $row) {
		    	$no_gudang[]=$row->id_gudang;
		    }
		}else{
			$no_gudang[]=2;
		}

	    $userid = $this->session->userid;
	    $group = $this->Frmmpo->getIdGudang($userid);
	    if(!empty($group)){
		    if($group->id_gudang == "8" || $group->id_gudang == "7"){
		    	$ids = "1";
		    }else{
				$ids = join("','",$no_gudang);
		    }
		}else{
				$ids = join("','",$no_gudang);
		    }

		$keyword = $this->uri->segment(4);
		$data = $this->db->select('o.`id_obat`, g.`id_inventory`, o.`nm_obat`, o.`hargabeli`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`, o.`jenis_obat`, o.`satuank')
				->from('gudang_inventory g')
				->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
				->where('g.id_gudang', $ids)
				->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
		$arr='';
	    if(!empty($data)){
			foreach($data as $row)
			{

                /** Hitung Selisih Expire Date dengan Tanggal Sekarang, pake DateTime ga Jalan */
                $now = date("Y-m-d");
                $pecah1 = explode("-", $now);
                $date1 = $pecah1[2];
                $month1 = $pecah1[1];
                $year1 = $pecah1[0];

                $pecah2 = explode("-", $row->expire_date);
                $date2 = $pecah2[2];
                $month2 = $pecah2[1];
                $year2 =  $pecah2[0];

                $jd1 = GregorianToJD($month1, $date1, $year1);
                $jd2 = GregorianToJD($month2, $date2, $year2);
                $selisih = $jd2 - $jd1;
                /** --------------------------------------------------------------------------- */
                if($selisih <= 90){ $bg = "Menuju Expired"; }elseif($selisih <= 30){ $bg = "Expired"; }else{ $bg = "$row->expire_date"; }

				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					// 'value'	=> $row->nm_obat." (BATCH-".$row->batch_no.", ED-".$bg.", QTY-".$row->qty.")",
					'value'	=> $row->nm_obat,
					'idobat' => $row->id_obat,
					'idinventory' => $row->id_inventory,
					'nama'	=>$row->nm_obat,
					'harga' => $row->hargajual,
					'hargabeli' => $row->hargabeli,
					'batch_no' => $row->batch_no,
					'expire_date' => $row->expire_date,
					'qty' => $row->qty,
					'jenis_obat' => $row->jenis_obat,
					'satuan' => $row->satuank
				);
			}
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	public function get_pilih_obat()
	{
		$json = [];

		$this->load->database();

			$query = $this->db->from('master_obat')
			->like('nm_obat',$this->input->get("q"))
			->select('id_obat, nm_obat')
			->where('deleted','0')
			->limit(50, 0)->get();
			$json = $query->result();




		echo json_encode($json);
	}

}