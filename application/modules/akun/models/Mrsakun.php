<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mrsakun extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

		//master rekening
		function get_all_data_rekening(){
			return $this->db->query("SELECT kode, perkiraan, tl, IF(tipe='' or tipe is null,'-',tipe) as tipe, IF(nb='K','KREDIT',IF(nb='D','DEBET','-')) as nb, 
IF(nrl='R','RUGI LABA',IF(nrl='N','NERACA','-')) as nrl, upkode, 
IF(statusflag='1','Aktif','Nonaktif') as status  FROM koderekening ORDER BY kode");
		}

		function get_all_data_mataanggaran(){
			return $this->db->query("SELECT kode_manggaran, nm_manggaran, IF(upkode is not null,(SELECT c.nm_manggaran from mata_anggaran as c where c.kode_manggaran=mata_anggaran.upkode),'') as upkode_nm, upkode, 
IF(status='1','Aktif','Nonaktif') as status  FROM mata_anggaran ORDER BY kode_manggaran");
		}

		function get_all_data_mataanggaran_parent(){
			return $this->db->query("SELECT kode_manggaran, nm_manggaran, upkode, 
IF(status='1','Aktif','Nonaktif') as status  FROM mata_anggaran  where upkode is NULL ORDER BY kode_manggaran");
		}

		function get_all_valid_voucher(){
			return $this->db->query("SELECT * FROM voucher where (nilaikredit-nilaidebet)=0");
		}

		function get_all_data_jurnal_rekening(){
			return $this->db->query("SELECT kode, perkiraan, tl, tipe, IF(nb='K','KREDIT','DEBET') as nb, IF(nrl='R','RUGI LABA','NERACA') as nrl, upkode, IF(statusflag='1','Aktif','Nonaktif') as status  FROM koderekening where tipe='JURNAL' ORDER BY kode");
		}

		function get_all_data_bt(){
			return $this->db->query("SELECT *  FROM kodebtambahan ORDER BY mataanggaran");
		}

		function get_all_data_bukas_detail($tglawal,$tglakhir){
			return $this->db->query("SELECT b.*, SUM(b.debit) as sumdebit, SUM(b.kredit) as sumkredit FROM bukas_header a 
				LEFT JOIN bukas_detail b ON a.idbukas_header=b.idbukas_header
				WHERE LEFT(a.tgl_transaksi,10)>='$tglawal' 
				AND LEFT(a.tgl_transaksi,10)<='$tglakhir' 
				AND a.deleted=0
				GROUP BY b.id_norek");
		}

		function get_all_data_norek(){
			return $this->db->query("SELECT *  FROM master_rekening ORDER BY jns_bank");
		}

		function get_active_data_norek(){
			return $this->db->query("SELECT *  FROM master_rekening where deleted=0 ORDER BY jns_bank");
		}

		function get_data_rekening($kode){
			return $this->db->query("SELECT * FROM koderekening WHERE kode='$kode'");
		}

		function get_data_bukasheader($kode){
			return $this->db->query("SELECT * FROM bukas_header WHERE idbukas_header=$kode");
		}

		function get_data_bukasdetail($kode){
			return $this->db->query("SELECT * FROM bukas_detail WHERE idbukas_detail=$kode");
		}

		function getdata_daftar_bukas($tglawal,$tglakhir){
					return $this->db->query("SELECT *, a.idbukas_header as kode_trans, SUM(IFNULL(b.debit,0)) as total_debit, SUM(IFNULL(b.kredit,0)) as total_kredit FROM bukas_header a 
				LEFT JOIN bukas_detail b ON a.idbukas_header=b.idbukas_header
				WHERE LEFT(a.tgl_transaksi,10)>='$tglawal' 
				AND LEFT(a.tgl_transaksi,10)<='$tglakhir' 
				AND a.deleted=0
				GROUP BY a.idbukas_header");
		}

		function get_data_bukasdetail_id($kode){
			return $this->db->query("SELECT * FROM bukas_header a JOIN bukas_detail b ON a.idbukas_header=b.idbukas_header 
				LEFT JOIN master_rekening c ON b.id_norek=c.id_norek WHERE a.idbukas_header=$kode");
		}

		function get_data_norek($kode){
			return $this->db->query("SELECT * FROM master_rekening WHERE id_norek=$kode");
		}

		function get_data_mataanggaran($kode){
			return $this->db->query("SELECT * FROM mata_anggaran WHERE kode_manggaran='$kode'");
		}

		function delete_rekening($kode){
			$this->db-> where('kode', $kode);
			$this->db-> delete('koderekening');
			return true;
		}

		function insert_bukasheader($data){
			$this->db->insert('bukas_header', $data);
			return $this->db->insert_id();
		}

		function edit_bukasheader($data,$kode){
			$this->db->where('idbukas_header', $kode);
			return $this->db->update('bukas_header', $data);
		}

		function insert_bukasdetail($data){
			$this->db->insert('bukas_detail', $data);
			return $this->db->insert_id();
		}

		function edit_bukasdetail($data,$kode){
			$this->db->where('idbukas_detail', $kode);
			return $this->db->update('bukas_detail', $data);
		}

		function insert_rekening($data){
			$this->db->insert('koderekening', $data);
			return true;
		}

		function insert_norek($data){
			$this->db->insert('master_rekening', $data);
			return true;
		}

		function insert_mataanggaran($data){
			return $this->db->insert('mata_anggaran', $data);
		}

		function edit_mataanggaran($kode, $data){
			$this->db->where('kode_manggaran', $kode);
			return $this->db->update('mata_anggaran', $data);
		}

		function edit_rekening($kode, $data){
			$this->db->where('kode', $kode);
			$this->db->update('koderekening', $data);
			return true;
		}

		function edit_norek($kode, $data){
			$this->db->where('id_norek', $kode);
			return $this->db->update('master_rekening', $data);
		}

		//master rekening
		function get_all_data_voucher($date0,$date1){
			return $this->db->query("SELECT *, 'Status' as status FROM voucher where left(tgltransaksi,10)>='$date0' and left(tgltransaksi,10)<='$date1'");
		}

		function get_data_voucher($kode){
			return $this->db->query("SELECT * FROM voucher WHERE novoucher='$kode'");
		}

		function delete_transaksi($kode){
			$this->db->where('id', $kode);
			$this->db->delete('gltransaksi');
			return true;
		}

		function delete_bukasheader($kode){
			$this->db->where('idbukas_header', $kode);
			return $this->db->delete('bukas_header');
		}

		function delete_bukasdetail($kode){
			$this->db->where('idbukas_detail', $kode);
			return $this->db->delete('bukas_detail');
		}

		function insert_voucher($data){
			$this->db->insert('voucher', $data);
			return true;
		}

		function edit_voucher($kode, $data){
			$this->db->where('novoucher', $kode);
			$this->db->update('voucher', $data); 
			return true;
		}

		function insert_transaksi($data){
			$this->db->insert('gltransaksi', $data);
			return true;
		}

	var $table = 'data_transaksi_voucher';
	var $column_order = array(null,'id','novoucher','tgltransaksi','rekening','tipe','bt','Nilai','ket',null); //set column field database for datatable orderable
	var $column_search = array('novoucher','tgltransaksi','rekening','tipe','bt','Nilai','ket','id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 	

	private function _get_datatables_query($novoucher)
	{
		$this->db-> where('novoucher', $novoucher);
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
			}
		
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}

		function get_datatables($novoucher)
		{
			$this->_get_datatables_query($novoucher);
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();			
			return $query->result();
		}

		function count_filtered($novoucher)
		{
			$this->_get_datatables_query($novoucher);
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function count_all($novoucher)
		{
			$this->db-> where('novoucher', $novoucher);
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}

	var $table1 = 'voucher';
	var $column_order1 = array(null,'id','novoucher','tgltransaksi','tglentry','tutupvoucher','tglvalidasi',null); //set column field database for datatable orderable
	var $column_search1 = array('id','novoucher','tgltransaksi','tglentry','tutupvoucher','tglvalidasi'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order1 = array('novoucher' => 'desc'); // default order 	

	private function _get_datatables_query1()
	{
		//$this->db-> where('novoucher', $novoucher);
		$this->db->from($this->table1);

		$i = 0;
	
		foreach ($this->column_search1 as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search1) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
			}
		
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order1))
			{
				$order = $this->order1;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}

		function get_datatables1()
		{
			$this->_get_datatables_query1();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();				
			return $query->result();
		}

		function count_filtered1()
		{
			$this->_get_datatables_query1();
			$query = $this->db->get();
			return $query->num_rows();

		}

		public function count_all1()
		{
			$this->db->from($this->table1);
			return $this->db->count_all_results();
		}

		function getRencanaPenggunaan(){
			return $this->db->get('rencana_penggunaan');
		}

		function getMataAnggaran(){
			return $this->db->query("SELECT * FROM mata_anggaran WHERE upkode IS NULL AND status = 1 ORDER BY kode_manggaran");
		}

        function getMataAnggaranChild($upkode){
            return $this->db->query("SELECT * FROM mata_anggaran WHERE upkode = '".$upkode."' AND status = 1 ORDER BY kode_manggaran");
        }

        function insertData($table, $data){
        	return $this->db->insert($table, $data);
		}
		
		function getDataPenggunaan(){
            return $this->db->query("SELECT mata_anggaran, ma_child, nm_manggaran, detail FROM data_keuangan GROUP BY ma_child");
        }
		
		function getDataPenggunaanPaguyms($ma_child){
            return $this->db->query("SELECT nominal FROM data_keuangan WHERE jenis_penggunaan='pagu' AND sumber_dana='yms' AND ma_child='$ma_child'");
        }
		
		function getDataPenggunaanPagubpjs($ma_child){
            return $this->db->query("SELECT nominal FROM data_keuangan WHERE jenis_penggunaan='pagu' AND sumber_dana='bpjs' AND ma_child='$ma_child'");
        }
		
		function getDataPenggunaanPenggunaanyms($ma_child){
            return $this->db->query("SELECT nominal FROM data_keuangan WHERE jenis_penggunaan='penggunaan' AND sumber_dana='yms' AND ma_child='$ma_child'");
        }
		
		function getDataPenggunaanPenggunaanbpjs($ma_child){
            return $this->db->query("SELECT nominal FROM data_keuangan WHERE jenis_penggunaan='penggunaan' AND sumber_dana='bpjs' AND ma_child='$ma_child'");
        }

	}
?>
