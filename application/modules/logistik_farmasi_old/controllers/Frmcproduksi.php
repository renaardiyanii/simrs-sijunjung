<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
//include('Frmcterbilang.php');
class Frmcproduksi extends Secure_area
{
  public function __construct(){
	parent::__construct();
	$this->load->model('logistik_farmasi/Frmmproduksi','',TRUE);
    $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
    $this->load->model('master/Mmobat','',TRUE);
	}

    function index()
	{
		    $data['title'] = 'Master Obat Produksi';
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $data['data_obat']=$this->Frmmproduksi->get_obat_all()->result();
        $data['data_obat_bahan']=$this->Frmmproduksi->get_obat_all_by_id_gudang($id_gudang)->result();
		$this->load->view('logistik_farmasi/Frmvproduksi',$data);
	}

    function insert_header_produksi(){
        $login_data = $this->load->get_var("user_info");
        $obat = $this->input->post('id_obat');
        $data['id_obat'] = Explode('-', $obat)[0];
        $data['nm_obat'] = Explode('-', $obat)[1];
        $data['user'] = $login_data->name;
        $data['tgl_produksi'] = date("Y-m-d");
        $data['batch_no'] = $this->input->post('batch_no');
        $data['exp_date'] = $this->input->post('exp_date');
        $data['qty'] = $this->input->post('qty');
        $id_produksi= $this->Frmmproduksi->insert_header_produksi($data);
     
        redirect('logistik_farmasi/Frmcproduksi/form_detail_produksi/'.$id_produksi);       
      }

      function form_detail_produksi($id_produksi='')
      {
          $data['title'] = 'Master Obat Produksi';
          $data['id_produksi'] = $id_produksi;
          $data['data_header'] = $this->Frmmproduksi->get_data_header_produksi($id_produksi)->row();
          $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
          $data['data_obat_bahan']=$this->Frmmproduksi->get_obat_all_by_id_gudang($id_gudang)->result();
          $data['data_obat_produksi']=$this->Frmmproduksi->get_data_obat_produksi($id_produksi)->result();
          $this->load->view('logistik_farmasi/Frmvdetailproduksi',$data);
      }

      
    function insert_detail_produksi($id_produksi=''){
        
        $login_data = $this->load->get_var("user_info");
        $obat = $this->input->post('idobat');
        $data['id_obat'] = Explode('-', $obat)[0];
        $data['id_inventory'] = Explode('-', $obat)[1];
        $data['id_gudang'] = Explode('-', $obat)[2];
        $data['batch_no'] = Explode('-', $obat)[3];
        // var_dump($data['id_gudang']);die();
        $data['user'] = $login_data->name;
        $data['qty'] = $this->input->post('qty');
        $data['id_produksi'] = $this->input->post('id_produksi');
       $this->Frmmproduksi->insert_detail_produksi($data);
     
        redirect('logistik_farmasi/Frmcproduksi/form_detail_produksi/'.$id_produksi);       
      }

      function hapus_detail_produksi($id_detail_produksi='',$id_produksi=''){
        //  var_dump($id_detail_produksi);die();
        // $data['id_detail_produksi'] = $id_detail_produksi;
        $this->Frmmproduksi->hapus_detail_produksi($id_detail_produksi);
     
        redirect('logistik_farmasi/Frmcproduksi/form_detail_produksi/'.$id_produksi);       
      }

      function hapus_detail_produksi_formula($id_detail_produksi='',$id_produksi='',$id_obat){
        //  var_dump($id_detail_produksi);die();
        // $data['id_detail_produksi'] = $id_detail_produksi;
        $this->Frmmproduksi->hapus_detail_produksi($id_detail_produksi);
     
        redirect('logistik_farmasi/Frmcproduksi/detail_formula/'.$id_obat.'/'.$id_produksi);       
      }

      function insert_selesai_produksi($id_produksi=''){
        // var_dump($id_produksi);die();
        $data['id_gudang'] = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $data['data_header'] = $this->Frmmproduksi->get_data_header_produksi($id_produksi)->row();
        $data['data_obat_produksi']=$this->Frmmproduksi->get_data_obat_produksi($id_produksi)->result();
        // var_dump($data['data_header']->nm_obat);die();
        $this->Frmmproduksi->insert_selesai_produksi($data);
       
        redirect('logistik_farmasi/Frmcproduksi');       
      }

      function produksi_formula(){
        $data['title'] = 'Master Obat Produksi ( Formula )';
        // $data['id_master'] = $this->Frmmproduksi->get_data_master_produksi_all()->result();
        $data['data_obat_produksi'] = $this->Frmmproduksi->get_data_master_produksi_all()->result();
       
        $this->load->view('logistik_farmasi/Frmvdetailproduksiformula',$data);      
      }

      function insert_header_formula(){
        // var_dump($this->input->post());die();
        
        $obat = $this->input->post('id_obat');
        $login_data = $this->load->get_var("user_info");
        $data['id_obat'] = Explode('@', $obat)[0];
        $data['nm_obat'] = Explode('@', $obat)[1];
        $data['user'] = $login_data->name;
        $data['tgl_produksi'] = date("Y-m-d");
        $data['batch_no'] = $this->input->post('batch_no');
        $data['exp_date'] = $this->input->post('exp_date');
        $data['qty'] = $this->input->post('qty');
        $id_produksi= $this->Frmmproduksi->insert_header_produksi($data);
        $data['title'] = 'Master Obat Produksi ( Formula )';
        redirect('logistik_farmasi/Frmcproduksi/detail_formula/'.$data['id_obat'].'/'.$id_produksi);    
      }

      function detail_formula($id,$idpro){
        // var_dump($this->input->post());die();
        $data['title'] = 'Master Obat Produksi ( Formula )';
        $data['data_header'] = $this->Frmmproduksi->get_data_header_produksi($idpro)->row();
        $data['id_produksi'] = $idpro;
        $data['id_obat'] = $id;
        $data['data_obat_detail_produksi'] = $this->Frmmproduksi->get_data_detail_produksi_all($id)->result();
        $data['data_bahan_produksi'] = $this->Frmmproduksi->get_data_obat_produksi($idpro)->result();
        $this->load->view('logistik_farmasi/Frmvdetailproduksiformula2',$data);      
      }

      function master_produksi(){
        $data['title'] = 'Master Obat Produksi';
        $data['data_obat']=$this->Frmmproduksi->get_obat_all()->result();
        $this->load->view('logistik_farmasi/Frmvmasterproduksi',$data);      
      }

      function insert_master_produksi(){
        $login_data = $this->load->get_var("user_info");
        $obat = $this->input->post('id_obat');
        $data['id_obat'] = Explode('-', $obat)[0];
        $data['nm_obat'] = Explode('-', $obat)[1];
        $id_produksi= $this->Frmmproduksi->insert_master_produksi($data);
     
        redirect('logistik_farmasi/Frmcproduksi/form_detail_master_produksi/'.$id_produksi);       
      }

      function form_detail_master_produksi($id='')
      {
          $data['title'] = 'Master Obat Produksi';
          $data['id_produksi'] = $id;
          $data['data_obat_produksi'] = $this->Frmmproduksi->get_data_master_produksi($id)->row();
          $data['data_obat']=$this->Frmmproduksi->get_obat_all()->result();
          $data['data_bahan']=$this->Frmmproduksi->get_data_detail_master_produksi($id)->result();
          $this->load->view('logistik_farmasi/Frmvdetailmasterproduksi',$data);
      }

      function insert_detail_master_produksi($id){
        
      // var_dump($this->input->post());die();
        $obat = $this->input->post('idobat');
        $data['id_obat'] = Explode('@', $obat)[0];
        $data['nm_obat'] = Explode('@', $obat)[1];
        $data['id_obat_utama'] = $this->input->post('id_obat_utama');
        $data['dosis'] = $this->input->post('dosis');
        $data['id_master'] = $id;
        $this->Frmmproduksi->insert_detail_master_produksi($data);
     
        redirect('logistik_farmasi/Frmcproduksi/form_detail_master_produksi/'.$id);       
      }

      function hapus_detail_master_produksi($id,$id_master){
        //  var_dump($id_detail_produksi);die();
        // $data['id_detail_produksi'] = $id_detail_produksi;
        $this->Frmmproduksi->hapus_detail_master_produksi($id);
     
        redirect('logistik_farmasi/Frmcproduksi/form_detail_master_produksi/'.$id_master);        
      }

      public function get_data_edit_obat(){
        $id_obat=$this->input->post('id_obat');
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $datajson=$this->Frmmproduksi->get_data_detail_bahan($id_obat,$id_gudang)->result();
          echo json_encode($datajson);
      }

      public function insert_detail_formula(){
        $login_data = $this->load->get_var("user_info");
        $data['id_inventory'] = $this->input->post('cari_obat_sub');
        $data_bahan = $this->Frmmproduksi->get_data_inventory($data['id_inventory'])->row();
        $data['qty'] = $this->input->post('qty');
        $data['id_obat'] = $data_bahan->id_obat;
        $data['id_gudang'] = $data_bahan->id_gudang;
        $data['batch_no'] = $data_bahan->batch_no;
        $data['user'] = $login_data->name;
        $data['qty'] = $this->input->post('qty');
        $data['id_produksi'] = $this->input->post('id_produksi');
        $obat = $this->input->post('obat_utama');
        // var_dump($data);die();
        $this->Frmmproduksi->insert_detail_produksi($data);

        redirect('logistik_farmasi/Frmcproduksi/detail_formula/'.$obat.'/'.$data['id_produksi']);
       
      }


}

?>