<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class Frmcadjustment extends Secure_area
{
  public function __construct(){
  parent::__construct();
  $this->load->model('logistik_farmasi/Frmmadjustment','',TRUE);
  $this->load->model('master/Mmobat','',TRUE);
  $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
  $this->load->helper('pdf_helper');
  }

  function index()
  {
    $data['title'] = 'Adjustment Barang';
    $data['select_gudang'] = $this->Frmmadjustment->get_data_gudang()->result();
    $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
    $data['data_obat']=$this->Mmobat->get_obat_by_gudang_for_adjust($id_gudang)->result();
    // $data['data_obat']=$this->Mmobat->get_all_obat()->result();
    
    $this->load->view('logistik_farmasi/Frmvadjustment',$data);
  }
  
    public function get_data_detail_retur(){
       $id_inventory=$this->input->post('id_inventory');
       $datajson=$this->Frmmadjustment->data_gudang($id_inventory)->result();
         echo json_encode($datajson);
    }

     public function get_data_detail_gudang(){
       $nm_gudang=$this->input->post('nm_gudang');
       $datajson=$this->Frmmdistribusi->getdata_gudang_inventory($nm_gudang)->result();
         echo json_encode($datajson);
    }
	
	public function list_data() {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		$hasil = $this->Frmmadjustment->getdata_gudang_inventory($this->input->post());
    // var_dump($this->input->post());die();
		//foreach ($hasil as $value) {
			$btn = '';
			$row2['id_inventory'] = $hasil->id_inventory;
			$row2['nama_gudang'] = $hasil->nama_gudang;
			$row2['batch_no'] = $hasil->batch_no;
			$row2['nm_obat'] = $hasil->nm_obat;
			$row2['qty'] = $hasil->qty;
			$row2['expire_date'] = $hasil->expire_date;
			$btn .= '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lihatdetail" onclick="distribusi(\''.$hasil->id_inventory.'\')"><i class="icon fa fa-adjust"></i> Adjust</button>';
			if ($hasil->expired == 1)
				$btn .= '&nbsp;&nbsp;<button class="btn btn-warning btn-sm" data-toggle="modal" onclick="hapus(\''.$hasil->id_inventory.'\')"><i class="icon fa fa-trash"></i> Hapus</button>';
			$row2['aksi'] = $btn;
			
			$line2[] = $row2;
		//}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

    public function insert_adjustment(){
	
      $id_inventory=$this->input->post('id_inventory');
      $id_obat=$this->input->post('edit_id_obat');
      $expire_date=$this->input->post('edit_expire');
      $qty=$this->input->post('edit_qty');
      // $qty_dis=$this->input->post('edit_qty_dis');
      $qty_mutasi=$this->input->post('edit_mutasi');
      $batch_no=$this->input->post('edit_batch_no');
      $id_gudang_tujuan=$this->input->post('id_gudang');
      $id_gudang_awal=$this->input->post('id_gudang_awal');
      $qty_real=$this->input->post('qty_real');
      $ket=$this->input->post('ket_adjustment');
      $qty_adjustment=$this->input->post('qty_adjustment');
      if ($qty_real > $qty) {
         $qty_hasil= $qty_real - $qty_adjustment;
       } elseif ($qty_real < $qty) {
         $qty_hasil= $qty_real + $qty_adjustment;
       }
    

      //Update/Insert Gudang Mutasi
      $data1['id_obat']=$id_obat;
      $data1['qty']=$qty;
      $data1['qty_hasil']=$qty_hasil;
      //$data1['expire_date']=$expire_date;
      $data1['batch_no']=$batch_no;
      $data1['id_gudang']=$id_gudang_awal;
      //$data1['id_gudang_tujuan']=$id_gudang_tujuan;
      $data1['qty_real']=$qty_real;
      $data1['qty_adjustment']=$qty_adjustment;
      $data1['id_inventory']=$id_inventory;
      $data1['ket']=$ket;
      
      $login_data = $this->load->get_var("user_info");
      $data1['username'] = $login_data->name;
      //$cek_obat_gudang=$this->Frmmdistribusi->cek_obat_gudang($id_obat, $expire_date, $id_gudang)->row()->id_inventory;
     
     
      //echo $cek_obat_gudang;
      //if(!($cek_obat_gudang)==1){
      //  $this->Frmmdistribusi->insert_selesai_distribusi($data1);
     // } //else {
        //$this->Frmmdistribusi->update_selesai_distribusi($cek_obat_gudang, $data1['qty']);
     //}
      
		if( $this->Frmmadjustment->insert_selesai_adjustment($data1)){
			//$this->Frmmadjustment->update_selesai_adjustment($qty_hasil, $id_inventory);
			$this->Frmmadjustment->update_selesai_adjustment($qty_real, $id_inventory);
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}

	  
      //redirect('logistik_farmasi/Frmcadjustment/index');
      //print_r();
	
    }
    function hapus_obat(){				
		$id = $this->input->post('id');
		if($this->Frmmadjustment->delete($id)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
}
?>
