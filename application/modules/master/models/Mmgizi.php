<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmgizi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master kel gizi
		function get_all_keldiet(){
			return $this->db->query("SELECT * FROM kelompok_diet ORDER BY idpokdiet");
		}

		function get_data_keldiet($idpokdiet){
			return $this->db->query("SELECT * FROM kelompok_diet WHERE idpokdiet='$idpokdiet'");
		}		

		function delete_keldiet($idpokdiet){
			return $this->db->query("DELETE FROM kelompok_diet WHERE idpokdiet='$idpokdiet'");
		}

		function insert_keldiet($data){
			$this->db->insert('kelompok_diet', $data);
			return true;
		}

		function edit_keldiet($idpokdiet, $data){
			$this->db->where('idpokdiet', $idpokdiet);
			$this->db->update('kelompok_diet', $data); 
			return true;
		}

		function get_all_tipemakanan(){
			return $this->db->query("SELECT distinct(tipe_makanan) as tipe_makanan FROM menu_diet ORDER BY tipe_makanan");
		}
		function get_all_grupreport(){
			return $this->db->query("SELECT distinct(grupreport) as grupreport FROM diet ORDER BY grupreport");
		}

		//menu diet
		function get_all_menudiet(){
			return $this->db->query("SELECT * FROM diet INNER JOIN kelompok_diet ON diet.idkel_diet=kelompok_diet.idpokdiet JOIN menu_diet ON menu_diet.idmenu_diet=diet.idmenu_diet ORDER BY iddiet");
		}

		function get_all_menu(){
			return $this->db->query("SELECT * FROM menu_diet ORDER BY idmenu_diet");
		}

		function get_data_menudiet($iddiet){
			return $this->db->query("SELECT * FROM diet JOIN menu_diet ON diet.idmenu_diet=menu_diet.idmenu_diet WHERE iddiet='$iddiet'");
		}

		function get_data_menu($idmenu_diet){
			return $this->db->query("SELECT * FROM menu_diet WHERE idmenu_diet='$idmenu_diet'");
		}		

		function delete_menudiet($iddiet){
			return $this->db->query("DELETE FROM diet WHERE iddiet='$iddiet'");
		}

		function delete_menu($idmenu_diet){
			return $this->db->query("DELETE FROM menu_diet WHERE idmenu_diet='$idmenu_diet'");
		}

		function insert_menudiet($data){
			
			return $this->db->insert('diet', $data);
		}

		function insert_menu($data){
			$this->db->set('idmenu_diet' , '');
			// return $this->db->insert('menu_diet', $data);
			$menu = $data['nama_menu'];
			$tipe_makanan = $data['tipe_makanan'];
			$komposisi = $data['komposisi'];
			return $this->db->query("INSERT INTO menu_diet (nama_menu,tipe_makanan,komposisi) VALUES('$menu','$tipe_makanan','$komposisi')");
		}

		function edit_menudiet($iddiet, $data){
			
			print_r($data);
			// $this->db->where('iddiet', $iddiet); 
			// return $this->db->update('diet', $data);
		}

		function edit_menu($idmenu_diet, $data){
			// $this->db->where('idmenu_diet', $idmenu_diet);
			// return $this->db->update('diet', $data);
			// return $idmenu_diet.$data;
			var_dump($idmenu_diet,$data);
		}
	}
?>
