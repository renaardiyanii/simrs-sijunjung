<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmlaporanjual extends CI_Model {
		function __construct(){
			parent::__construct();
		}

        function get_data_penjualan($param1, $param2, $filter){

			if($filter!='0'){
				return $this->db->query("SELECT r.`item_obat`, r.`nama_obat`, SUM(r.`qty`) AS qty
                FROM resep_pasien r
                WHERE r.xambil='$filter'
                AND LEFT(r.xupdate, 10) BETWEEN '$param1' AND '$param2' AND r.ambil_resep = 1
                GROUP BY r.`item_obat`
                ORDER BY r.`item_obat` ASC");
			}else{
               return $this->db->query("SELECT r.`item_obat`, r.`nama_obat`, SUM(r.`qty`) AS qty
                FROM resep_pasien r
                WHERE LEFT(r.xupdate, 10) BETWEEN '$param1' AND '$param2' AND r.ambil_resep = 1 
                GROUP BY r.`item_obat`
                ORDER BY r.`item_obat` ASC");
			}
		}
	}
		
?>
