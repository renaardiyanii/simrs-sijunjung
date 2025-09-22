<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcobat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmobat','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('logistik_farmasi/Frmmpo','',TRUE);
	}

	public function index(){
		
		$data['title'] = 'Master Obat';

		$data['obat']=$this->mmobat->get_all_obat_master()->result();
		$data['satuan']=$this->mmobat->get_data_satuan_obat()->result();
		$data['kemasan']=$this->mmobat->get_data_kemasan_obat()->result();
		$data['kelompok']=$this->mmobat->get_data_kelompok_obat()->result();
		$data['jenis']=$this->mmobat->get_data_jenis()->result();
		$data['golongan']=$this->mmobat->get_data_golongan()->result();
		$data['kategori']=$this->mmobat->get_all_kategori()->result();
		// $data['kategori_satu']=$this->mmobat->get_data_kategori_satu()->result();
		// $data['kategori_dua']=$this->mmobat->get_data_kategori_dua()->result();
		// $data['kategori_tiga']=$this->mmobat->get_data_kategori_tiga()->result();
		// $data['kategori_empat']=$this->mmobat->get_data_kategori_empat()->result();
		// $data['kategori_lima']=$this->mmobat->get_data_kategori_lima()->result();
		// $data['generik']=$this->mmobat->get_data_generik_obat()->result();
		$this->load->view('master/mvobat',$data);
		
	}

	public function insert_obat(){
		// var_dump($this->input->post());die();
		$data['nm_obat']=$this->input->post('nm_obat');
		$nama_generik=$this->input->post('generik');
		if($nama_generik != ''){
			$data['nama_generik']= isset($nama_generik)?Explode('@',$nama_generik)[1]:null;
			$data['id_generik'] = isset($nama_generik)?Explode('@',$nama_generik)[0]:null;
		}else{
			$data['nama_generik']= '-';
			$data['id_generik'] = null;
		}
		
		
		$data['satuank']=$this->input->post('satuank');
		$data['kategori_obat']=$this->input->post('kategori');
		$data['kemasan']=$this->input->post('kemasan');
		$data['jenis_obat']=$this->input->post('jenis_obat');
		$data['golongan_obat']=$this->input->post('golongan_obat');
		$data['kelompok']=$this->input->post('kel');
		$data['subkelompok']=$this->input->post('subkel');
		$data['kategori1']=$this->input->post('kat1');
		$data['kategori2']=$this->input->post('kat2');
		$data['kategori3']=$this->input->post('kat3');
		$data['kategori4']=$this->input->post('kat4');
		$data['kategori5']=$this->input->post('kat5');
		$data['kategori6']=$this->input->post('kat6');
		$data['formularium']=$this->input->post('formularium');
		$data['min_stock'] = 0;
		$data['deleted'] = 0;

		$id_obat = $this->mmobat->insert_obat($data);

		// $get_all_gudang = $this->mmobat->get_all_gudang()->result();
		// foreach ($get_all_gudang as $row) {
		// 	$id_gudang[] = $row->id_gudang;
		// 	$datag['id_obat'] = $id_obat;
		// 	$datag['id_gudang'] = $row->id_gudang;
		// 	$datag['qty'] = 0;
		// 	$datag['batch_no'] = 0;
		// 	$this->mmobat->insert_obat_to_gudang($datag);
		// }

		$msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Disimpan!
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		</div>';
		
		$this->session->set_flashdata('success_msg', $msg);

		redirect('master/Mcobat',$msg);
		
	}

	public function get_data_edit_obat(){
		$id_obat=$this->input->post('id_obat');
		$datajson=$this->mmobat->get_data_obat($id_obat)->result();
	    echo json_encode($datajson);
	}

	public function edit_obat(){
		// var_dump($this->input->post());die();
		$id_obat=$this->input->post('edit_id_obat_hidden');
		$nama_generik=$this->input->post('edit_generik');
		if($nama_generik != ''){
			$data['nama_generik']= isset($nama_generik)?Explode('@',$nama_generik)[1]:null;
			$data['id_generik'] = isset($nama_generik)?Explode('@',$nama_generik)[0]:null;
		}else{
			$data['nama_generik']= '-';
			$data['id_generik'] = null;
		}
		$data['nm_obat']=$this->input->post('edit_nm_obat');
		$data['satuank']=$this->input->post('edit_satuank');
		$data['kategori_obat']=$this->input->post('edit_kategori');

		$this->mmobat->edit_obat($id_obat, $data);
		
		redirect('master/Mcobat');
		//print_r($data);
	}

	public function delete_obat(){
		$id_obat=$this->input->post('delete_id');
		$this->mmobat->soft_delete_obat($id_obat);
		redirect('master/Mcobat');
		
		// $data['nm_obat']=$this->input->post('edit_nm_obat');
		// $data['satuank']=$this->input->post('edit_satuank');
		// $data['satuanb']=$this->input->post('edit_satuanb');
		// $data['faktorsatuan']=$this->input->post('edit_faktorsatuan');
		// // $data['hargabeli']=$this->input->post('edit_hargabeli');
		// $data['hargajual']=$this->input->post('edit_hargajual');
		// $data['kel']=$this->input->post('edit_kel');
		// $data['jenis_obat']=$this->input->post('edit_jenis_obat');
		// $data['min_stock'] = $this->input->post('edit_minstok');

		
		// redirect('master/Mcobat');
		//print_r($data);
	}

	public function active_obat($id_obat){
		$this->mmobat->active_obat($id_obat);
		redirect('master/Mcobat');
	
	}

	//kebijakan obat
	public function kebijakan(){
		$data['title'] = 'Kebijakan Obat';
		$data['kebijakan']=$this->mmobat->get_all_kebijakan()->result();
		$this->load->view('master/mvobatkebijakan',$data);
		//print_r($data);
	}

	public function insert_kebijakan(){
		$data['id_kebijakan']=$this->input->post('id_kebijakan');
		$data['keterangan']=$this->input->post('keterangan');
		$data['nilai']=$this->input->post('nilai');
		//$data['xupdate']=$this->input->post('xupdate');

		$this->mmobat->insert_kebijakan($data);
		
		redirect('master/Mcobat/kebijakan');
		//print_r($data);
	}

	public function delete_kebijakan(){
		$id_kebijakan=$this->input->post('delete_id');
		$this->mmobat->soft_delete_kebijakan($id_kebijakan);
		redirect('master/Mcobat/kebijakan');

	}

	public function edit_kebijakan(){
		$id_kebijakan=$this->input->post('edit_id_kebijakan_hidden');
		$data['keterangan']=$this->input->post('edit_keterangan');
		$data['nilai']=$this->input->post('edit_nilai');

		$this->mmobat->edit_kebijakan($id_kebijakan, $data);
		
		redirect('master/Mcobat/kebijakan');
		//print_r($data);
	}

	public function get_data_edit_kebijakan(){
		$id_kebijakan=$this->input->post('id_kebijakan');
		$datajson=$this->mmobat->get_data_kebijakan($id_kebijakan)->result();
	    echo json_encode($datajson);
	}

	function paket_obat(){
	    $data = array(
	        'title' => 'Master Paket Obat',
            'obat' => $this->mmobat->get_paket_obat()->result()
        );

        $this->load->view('master/mvpaketobat', $data);
    }

    public function pengaturan_paket($id_paket){
        $master = $this->mmobat->get_paket_obat_by_id($id_paket)->row();

	    $data = array(
	        'title' => 'Pengaturan Paket Obat - '.$master->nama_paket,
            'id_paket' => $id_paket,
            'obat' => $this->mmobat->get_paket_obat_detail($id_paket)->result()
        );

	    $this->load->view('master/mvpaketobat_detail', $data);
    }

    function save_paket(){
	    $data = array(
	        'nama_paket' => $this->input->post('nama_paket'),
	        'id_dokter' => 1
        );
        $this->mmobat->insert_table('paket_obat', $data);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Disimpan!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msg', $msg);
	    redirect('master/mcobat/paket_obat');
    }

    function hapus_paket(){
        $where = array(
            'id_paket' => $this->input->post('id_paket')
        );

        $save = $this->mmobat->delete_table('paket_obat', $where);

        if($save >= 1){
            $data = array('status' => 'success');
        }else{
            $data = array('status' => 'failed');
        }

        echo json_encode($data);
    }

    function save_paket_obat(){
        $id_paket = $this->input->post('id_paket');
        $data = array(
            'id_paket' => $id_paket,
            'id_obat' => $this->input->post('id_obat'),
            'qty' => $this->input->post('qty'),
			'nama_obat' => $this->input->post('nama_obat')
        );

        $this->mmobat->insert_table('paket_obat_detail', $data);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Disimpan!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msg', $msg);
        redirect('master/mcobat/pengaturan_paket/'.$id_paket);
    }

    function hapus_paket_obat(){
        $where = array(
            'id' => $this->input->post('id')
        );

        $save = $this->mmobat->delete_table('paket_obat_detail', $where);

        if($save >= 1){
            $data = array('status' => 'success');
        }else{
            $data = array('status' => 'failed');
        }

        echo json_encode($data);
    }

    function get_data_paket(){
        $id_obat = $this->input->post('id_paket');
        $datajson = $this->mmobat->get_data_paket($id_obat)->result();
        echo json_encode($datajson);
    }


    function edit_paket(){
        $where = array( 'id_paket' => $this->input->post('edit_id_paket') );
        $data = array( 'nama_paket' => $this->input->post('edit_nama_paket') );
        $this->mmobat->update_table('paket_obat', $data, $where);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Diubah!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msg', $msg);
        redirect('master/mcobat/paket_obat');
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


	public function search_obat()
	{
			$data['kelompok']=$this->mmobat->get_data_kelompok_obat()->result();
			$data['subkelompok']=$this->mmobat->get_data_subkelompok_obat()->result();
			$data['jenis']=$this->mmobat->get_data_jenis()->result();
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$data['title']="Master Obat";
			
			$data['kel'] = $this->input->post('kel');
			$data['sub'] = $this->input->post('subkel');
			$data['jns'] = $this->input->post('jenis_obat');
			
			if ($data['kel'] != null && $data['sub'] == null && $data['jns'] == null) {
				$data['obat']=$this->mmobat->get_all_obat_by_kelompok($data['kel'])->result();
			
			}else if($data['sub'] != null && $data['kel'] == null && $data['jns'] == null) {
				$data['obat']=$this->mmobat->get_all_obat_by_subkelompok($data['sub'])->result();
				
			}else if($data['sub'] == null && $data['kel'] == null && $data['jns'] != null) {
				$data['obat']=$this->mmobat->get_all_obat_by_jenis($data['jns'])->result();

			}else if($data['sub'] != null && $data['kel'] != null && $data['jns'] == null){
				$data['obat']=$this->mmobat->get_all_obat_by_subkelompok_kel($data['sub'],$data['kel'])->result();
				
			}else if($data['sub'] == null && $data['kel'] != null && $data['jns'] != null){
				$data['obat']=$this->mmobat->get_all_obat_by_jns_kel($data['jns'],$data['kel'])->result();
				
			}else if($data['sub'] != null && $data['kel'] == null && $data['jns'] != null){
				$data['obat']=$this->mmobat->get_all_obat_by_jns_sub($data['jns'],$data['sub'])->result();
				
			}else if($data['sub'] != null && $data['kel'] != null && $data['jns'] != null){
				$data['obat']=$this->mmobat->get_all_obat_by_jns_sub_kel($data['jns'],$data['sub'],$data['kel'])->result();
				
			}
			$this->load->view('master/mvobat',$data);
		}
	}

	function get_tabel_resep($id_paket){
        $line  = array();
        $line2 = array();
		$row2  = array();

		$obat = $this->mmobat->get_paket_obat_detail($id_paket)->result();
		$obat2= $this->mmobat->get_paket_obat_detail2($id_paket)->result();
		$racik= $this->mmobat->getdata_resep_racik($id_paket)->result();	
	
        $no = 1; $total = 0;
        foreach ($obat as $value) {
            $row2['no'] = $no++;
			if($value->racikan == 1){
				$row2['nama_obat'] = $value->nama_obat;
			}else{
				$row2['nama_obat'] = $value->nm_obat;
			}
			
			$row2['id_obat'] = $value->id_obat;
            if($value->racikan == 1){
                foreach($racik as $row1){
                    if($value->id == $row1->id_paket_detail){
                        $row2['nama_obat'] .= '<br>- '.$row1->nm_obat. ' ('.$row1->qty.')';
                    }
                }
            }
           
            $row2['qty'] = $value->qty;
          

            if($value->racikan=='1'){
                $row2['aksi'] = "<button onclick=\"hapus_data_racikan_list('".$value->id_paket."', '".$value->id."')\" class=\"btn btn-danger btn-xs\">Hapus</button>";
            }else{
                $row2['aksi'] = "<button onclick=\"hapus_data_obat('".$value->id."')\" class=\"btn btn-danger btn-xs\">Hapus</button>";

            }

            $line2[] = $row2;
        }
        $line['total'] = $total;
        $line['data'] = $line2;

        echo json_encode($line);
	}

	function get_tabel_racik($id_paket){
        $line = array();
        $line2 = array();
        $row2 = array();

        $hasil = $this->Frmmdaftar->getdata_resep_racikan2($id_paket)->result();
        $no = 1; $ttotal = 0; $total = 0;
        foreach ($hasil as $value) {
            $total = $value->hargajual * $value->qty;
            $ttotal += $total;

            $row2['no'] = $no++;
            $row2['nama_obat'] = $value->nm_obat;
            // $row2['harga'] = $value->hargajual;
            $row2['qty'] = $value->qty;
            // $row2['total'] = "Rp <div class=\"pull-right\">".number_format( $total, 2 , ',' , '.' )."</div>";
            $row2['aksi'] = "<button onclick=\"hapus_data_racikan('".$value->id_paket."', '".$value->id_obat_racikan."')\" class=\"btn btn-danger btn-xs\">Hapus</button>";

            $line2[] = $row2;
        }
        $line['total'] = $ttotal;
        $line['data'] = $line2;

        echo json_encode($line);
	}

	public function insert_racikan()
    {
	//   var_dump($this->input->post());die();
		$data['id_paket']=$this->input->post('id_paket2');
		$ket=$this->input->post('jenis_obat');

        if($ket==2){
            $data['item_obat']=$this->input->post('item_obat');
            $data['nama_obat']=$this->input->post('cari_obat2'). "(Konsinyasi)";
        
       } else{
		// $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->result();
            // foreach($data_tindakan as $row){
                $data['item_obat']=$this->input->post('idracikan');
                $data['nama_obat']=$this->input->post('cari_obat2');
               
            // }
        }
        if($ket==2){
            $data['qty']=$this->input->post('qty_racikan');
          
            $data['item_obat']=$this->input->post('cari_obat2'). "(Konsinyasi)";
            $save = $this->Frmmdaftar->insert_racikan2($data['item_obat'],$data['qty'],$data['id_paket']);
        }else{
            $data['qty']=$this->input->post('qty_racikan');
			$save = $this->Frmmdaftar->insert_racikan2($data['item_obat'],$data['qty'],$data['id_paket']);
            // $this->Frmmdaftar->insert_racikan($data['item_obat'],$data['qty'],$data['no_resep']);
        }

        if($save > 0) {
            $result = "sukses";
        }else{
            $result = "Gagal";
        }
        echo $result;
	}

	public function hapus_data_obat_new(){
		// var_dump($this->input->post('id'));die();

        $id = $this->input->post('id');
        $hapus = $this->mmobat->hapus_data_obat($id);

        $result = array();
        if($hapus > 0) {
            $result['hasil'] = "sukses";
        }else{
            $result['hasil'] = "Gagal";
        }

        echo json_encode($result);
    }

	public function insert_racikan_selesai()
    {
        $data['id_paket']=$this->input->post('id_paket2');
        $data['qty']=$this->input->post('qty1');
        $data['nama_obat']=$this->input->post('nama_racik');
        $data['racikan']='1';
		// $get = $this->mmobat->get_id($this->input->post('nama_racik'))->row();
		$data['id_obat'] = null;

        $save = $this->mmobat->insert_permintaan($data);

		
			
		$this->Frmmdaftar->update_racikan2($data['id_paket'], $save);
        if($save > 0) {

            $result = "sukses";
        }else{
            $result = "Gagal";
        }

        echo $result;

        //print_r($data);
    }

	public function hapus_data_obat_racik_new(){

		// var_dump($this->input->post('id'));die();
        $id_detail = $this->input->post('id');
        $id=$this->Frmmdaftar->hapus_data_obat2($id_detail);
        $id2=$this->Frmmdaftar->hapus_data_obat_racik2($id_detail);

        /*
        if($hapus > 0) {
            $result['hasil'] = "sukses";
        }else{
            $result['hasil'] = "Gagal";
        }*/
        $result = array();
        $result['hasil'] = "sukses";
        echo json_encode($result);
    }
}