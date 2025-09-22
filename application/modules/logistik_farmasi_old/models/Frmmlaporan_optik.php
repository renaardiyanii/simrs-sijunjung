<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmlaporan_optik extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_data_pengadaan($param1, $param2, $filter){
			if($filter!=''){
				return $this->db->query("SELECT a.no_faktur, a.tgl_kontra_bon, a.jatuh_tempo, s.company_name, b.description, b.quantity_purchased, b.item_unit_price as harga, b.discount_percent
					FROM receivings_optik a
					LEFT JOIN receivings_items_optik b ON b.receiving_id=a.receiving_id
					INNER JOIN suppliers s ON s.`person_id` = a.`supplier_id`
					WHERE LEFT(a.tgl_kontra_bon , 10) >= '".$param1."' AND LEFT(a.tgl_kontra_bon , 10) <= '".$param2."' 
					AND a.supplier_id='".$filter."'
					ORDER BY a.tgl_kontra_bon ASC");
			}else{
				return $this->db->query("SELECT a.no_faktur, a.tgl_kontra_bon, a.jatuh_tempo, s.company_name, b.description, b.quantity_purchased, b.item_unit_price as harga, b.discount_percent
					FROM receivings_optik a
					LEFT JOIN receivings_items_optik b ON b.receiving_id=a.receiving_id
					INNER JOIN suppliers s ON s.`person_id` = a.`supplier_id`
					WHERE LEFT(a.tgl_kontra_bon , 10) >= '".$param1."' AND LEFT(a.tgl_kontra_bon , 10) <= '".$param2."' 
					ORDER BY a.tgl_kontra_bon ASC");
			}
			
		}
	}
?>
