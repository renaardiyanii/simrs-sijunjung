<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_user extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function exist($username){
		$this->db->from('hmis_users');
		$this->db->where('username',$username);	
		return $this->db->count_all_results();	
	}
	
	function check_pass_match($data){
		$this->db->from('hmis_users');
		$this->db->where('userid', $this->session->userdata('userid'));	
		$this->db->where('password', $data['currpass']);	
		return $this->db->count_all_results();	
	}
	
	function get_all(){
		return $this->db->query("select *
			from hmis_users
			where deleted = 0
			order by username asc");
	}
	
	function get_role_all($id){
		return $this->db->query("select b.id, COALESCE(a.roleid,0) as sts, b.role
			from dyn_role_user a
			RIGHT JOIN 
			dyn_role b
			on a.roleid = b.id
			and a.userid = $id");
	}
	function get_role_id(){
		$userid = $this->session->userdata('userid');
		return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
	}
	
	function get_role_gudang($id){
		return $this->db->query("select b.id_gudang, COALESCE(a.id_gudang,0) as sts, b.nama_gudang
			from dyn_gudang_user a
			RIGHT JOIN 
			master_gudang b
			on a.id_gudang = b.id_gudang
			and a.userid = $id");
	}

	function get_role_poli($id){
		return $this->db->query("select b.id_poli, COALESCE(a.id_poli,'') as sts, b.nm_poli
			from dyn_poli_user a
			RIGHT JOIN 
			poliklinik b
			on a.id_poli = b.id_poli
			and a.userid = $id");
	}

	function get_role_ruang($id){
		return $this->db->query("select b.idrg as id_ruang, COALESCE(a.id_ruang,'') as sts, b.nmruang as nm_ruang
			from dyn_ruang_user a
			RIGHT JOIN 
			ruang b
			on a.id_ruang = b.idrg
			and a.userid = $id");
	}

	function get_role_akses($id){
		return $this->db->query("select b.id, b.deskripsi, b.id as idkasir, a.idkasir as sts, b.kasir
			from dyn_kasir_user a
			RIGHT JOIN 
			dyn_kasir b
			on a.idkasir = b.id
			and a.userid = $id");
	}

	function get_role_aksesOne($id){
		return $this->db->query("select b.id, b.deskripsi, b.id as idkasir, COALESCE(a.idkasir,0) as sts, b.kasir
			from dyn_kasir_user a
			JOIN 
			dyn_kasir b
			on a.idkasir = b.id
			and a.userid = $id");
	}
	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($username, $password)
	{
		//$query = $this->db->get_where('hmis_users', array('username' => $username,'password'=>md5($password), 'deleted'=>0), 1);
		$query = $this->db->get_where('hmis_users', array('username' => $username,'password'=>$password, 'deleted'=>0), 1);
		if ($query->num_rows() ==1)
		{
			$row=$query->row();
			$this->session->set_userdata('userid', $row->userid);
			return true;
		}
		return false;
	}
	
	/*
	Logs out a user by destorying all session data and redirect to login
	*/
	function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
	
	/*
	Determins if a user is logged in
	*/
	function is_logged_in()
	{
		return $this->session->userdata('userid')!=false;
	}
	/*
	Gets information about a user loged in
	*/
	function get_logged_in_user_info()
	{
		$userid = $this->session->userdata('userid');
		if (($userid)){
			return $this->get_info($userid);
		}
	}
	/*
	Gets information about a particular user
	*/
	function get_info($userid)
	{
		// $this->db->from('hmis_users');	
		// $this->db->where('userid',$userid);
		// $query = $this->db->get();
		$query = $this->db->query("SELECT a.*,b.role FROM hmis_users as a left join dyn_role_user b on a.userid=b.userid where a.userid=$userid");
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$data_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('hmis_users');

			foreach ($fields as $field)
			{
				$data_obj->$field='';
			}

			return $data_obj;
		}
	}
	/*
	Determins whether the employee specified employee has access the specific module.
	*/
	function has_permission($url,$userid)
	{
		//if no module_id is null, allow access
		if($url==null or $url=='beranda' or $url=='logout')
		{
			return true;
		}else{
			if ($this->is_menu($url)){
				$query = $this->db->query("select count(*) as jml
					from dyn_role_user ru, dyn_role_menu rm, dyn_menu m
					where ru.userid = $userid
						and ru.roleid = rm.role_id
					  and rm.menu_id = m.page_id
					  and m.url = '$url'");
				return ($query->row()->jml > 0);
			}else{
				/**
				 * Rekomendasi BSSN broken access control
				 * @aldi 28/3/2023 10:17 AM
				 */
				// $fitur_daftarulang = explode('/', $url);
				// if(count($fitur_daftarulang)>3){
				// 	if($fitur_daftarulang[0] == 'irj' && $fitur_daftarulang[1] == 'rjcregistrasi' && ($fitur_daftarulang[2] == 'daftarulangnew' || $fitur_daftarulang[2] == 'daftarulang')){
				// 		return false;
				// 	}
				// }
				return true;
			}
		}
		return false;
	}
	
	function is_menu($url){
		$query = $this->db->query("select count(show_menu) as jml
					from dyn_menu
					where url = '$url' and show_menu = '1'");
		return ($query->row()->jml == 1);
	}
	
	function has_gudang_access($userid,$id_gudang)
	{
		$query = $this->db->query("select count(*) as jml
					from dyn_gudang_user
					where userid = $userid and id_gudang = $id_gudang");
		return $query->row()->jml;
	}

	function has_poli_access($userid,$id_poli)
	{
		$query = $this->db->query("select count(*) as jml
					from dyn_poli_user
					where userid = $userid and id_poli = $id_poli");
		return $query->row()->jml;
	}

	function has_ruang_access($userid,$id_ruang)
	{
		$query = $this->db->query("select count(*) as jml
					from dyn_ruang_user
					where userid = $userid and id_ruang = $id_ruang");
		return $query->row()->jml;
	}

	function get_max_userid_hmis_users()
	{
		return $this->db->query("SELECT max(userid) FROM hmis_users")->result();
	}
	
	function save(&$data,$foto)
	{	
		$maxid = $this->get_max_userid_hmis_users()[0]->max;
		$userid = intval($maxid)+1;
		// var_dump($maxid);die();
		$query = $this->db->query("INSERT INTO hmis_users (userid,username, password, name, deleted, foto,ttd) VALUES ($userid,'".$data["username"]."','".$data["password"]."','".$data["name"]."','0','$foto','".$data["ttd"]."')");
		if($query)
		{
			return true;
		}
		return false;
	}
	function update($data){	
		$this->db->set('password', $data["vpassword"]);
		$this->db->where('userid', $data["vuserid"]);
		return $this->db->update('hmis_users');
	}
	function update_user($data){	
		$this->db->set('name', $data["vnameuser"]);
		$this->db->set('username', $data["vusernameuser"]);
		$this->db->where('userid', $data["vuseriduser"]);
		return $this->db->update('hmis_users');
	}
	function delete($id)
	{
		$this->db->where('userid',$id);	
		if ($this->db->delete('hmis_users')){
			$response =  true;
		}else{			
			$response = false;
		}
		$check_user_dokter = $this->get_user_dokter($id);
		if($check_user_dokter->num_rows()){
			$this->delete_user_dokter($id);
		}

		return $response;
	}

	function get_max_id_dyn_role_user()
	{
		return $this->db->query("SELECT max(id) FROM dyn_role_user")->result();
	}
	function userRoleSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_role_user');
		$temp =count($data);
		$id = $this->get_max_id_dyn_role_user()[0]->max + 1;
		for($i=0; $i<$temp;$i++){
			// print_r($data[$i]['userid']);
			$this->db->set('id',$id);
			$this->db->set('userid',$data[$i]['userid']);
			$this->db->set('roleid',$data[$i]['roleid']);
			$this->db->set('role',$data[$i]['role']);
			$this->db->insert('dyn_role_user');
			// $this->db->insert('dyn_role_user',$data[$i]);
		}
		return true;
	}
	function userAksesSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_kasir_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_kasir_user',$data[$i]);
		}
		return true;
	}

	function userAksesSaveOne($id,$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_kasir_user');
		
		$this->db->insert('dyn_kasir_user',$data);
		
		return true;
	}

	function userGdgSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_gudang_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_gudang_user',$data[$i]);
		}
		return true;
	}
	function userGdgDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_gudang_user');		
		return true;
	}

	function getKasirAkses($id)
	{	
		$this->db->where('dyn_kasir_user.userid', $id);
		$this->db->select('dyn_kasir_user.userid,hmis_users.username,dyn_kasir_user.kasir');
		$this->db->from('dyn_kasir_user');
		$this->db->JOIN('hmis_users','hmis_users.userid=dyn_kasir_user.userid');

		return $this->db->get()->row();
	}

	function userPoliSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_poli_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_poli_user',$data[$i]);
		}
		return true;
	}
	function userPoliDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_poli_user');		
		return true;
	}
	function userRuangSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_ruang_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_ruang_user',$data[$i]);
		}
		return true;
	}
	function userRuangDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_ruang_user');		
		return true;
	}

	
	function update_photo($uid, $foto){
		return $this->db->query("update hmis_users set foto = '".$foto."' where username = '".$uid."'");
	}
	function update_name($data){
		return $this->db->query("update hmis_users set name = '".$data["uname"]."' where username = '".$data["uid"]."'");
	}
	function change_pass($data){
		return $this->db->query("update hmis_users set password = '".$data["newpass"]."' where userid = '".$this->session->userdata('userid')."'");
	}

	function get_ttd_from_hmis_users_by_userid($userid)
	{
		return $this->db->query("SELECT ttd FROM hmis_users WHERE userid=$userid")->result();
	}

	function update_ttd($data){
		$check_data = $this->get_ttd_from_hmis_users_by_userid($data['userid']);
		return $this->db->query("UPDATE hmis_users SET ttd='".$data['ttd']."' WHERE userid=".$data['userid']."");
	}

	// added ->> aldi
	function get_all_dokter()
	{
		return $this->db->query("SELECT * FROM data_dokter order by nm_dokter");
		// return $this->db->get('data_dokter');
	}

	function get_user_dokter($userid)
	{
		$this->db->where('userid',$userid);
		return $this->db->get('dyn_user_dokter');
	}

	function update_user_dokter($userid,$data)
	{
		$this->db->where('userid',$userid);
		$this->db->update('dyn_user_dokter',$data);
		return 200;
	}

	function insert_user_dokter($data)
	{
		$this->db->insert('dyn_user_dokter',$data);
		return 201;
	}

	function get_all_ppa()
	{
		return $this->db->get('ppa');
	}

	function get_all_qtx()
	{
		return $this->db->select('qtx')->get('obat_qtx');
	}

	function get_all_satuan()
	{
		return $this->db->select('nm_satuan')->get('obat_satuan');
	}

	// function get_user_ppa($userid)
	// {
	// 	$this->db->where('userid',$userid);
	// 	return $this->db->get('user_ppa');
	// }

	function get_all_icd()
	{
		return $this->db->query("SELECT concat(cast(icd1.id_icd as varchar),'-',icd1.nm_diagnosa) as name FROM icd1
		order by icd1.id_icd asc");
	}

	function get_all_icd9()
	{
		return $this->db->query("SELECT concat(cast(icd9cm.id_tind as varchar),'-',icd9cm.nm_tindakan) as name FROM icd9cm
		order by icd9cm.id_tind asc");
	}

	function get_all_user_ppa()
	{
		return $this->db->query("SELECT hmis_users.name as name FROM user_ppa
		LEFT JOIN hmis_users on hmis_users.userid = user_ppa.userid WHERE user_ppa.ppa=1
		order by hmis_users.name");
	}

	function get_all_user()
	{
		return $this->db->query("SELECT concat(hmis_users.name,'-',cast(hmis_users.userid as varchar)) as name FROM hmis_users order by hmis_users.name asc ");
	}
	
	function get_all_user_ppa_iri()
	{
		return $this->db->query("SELECT concat(hmis_users.name,'-',cast(hmis_users.userid as varchar)) as name FROM user_ppa
		RIGHT JOIN hmis_users on hmis_users.userid = user_ppa.userid WHERE user_ppa.ppa=1 and hmis_users.userid!=1
		order by hmis_users.name asc
	");
	}

	function update_user_ppa($userid,$data)
	{
		$this->db->where('userid',$userid);
		$this->db->update('user_ppa',$data);
		return 200;
	}

	function insert_user_ppa($data)
	{
		$this->db->insert('user_ppa',$data);
		return 201;
	}

	function delete_user_dokter($userid)
	{
		return $this->db->query("DELETE FROM dyn_user_dokter WHERE userid=$userid");
	}

	function get_all_dokter_name()
	{
		return $this->db->query("SELECT DISTINCT nm_dokter FROM data_dokter ORDER BY nm_dokter ASC");
	}

	function get_all_dokter_nameid_distinct()
	{
		return $this->db->query("SELECT concat(nm_dokter,'-',cast(id_dokter as varchar),'-',ket) FROM data_dokter
		order by nm_dokter asc");
	}

	function get_all_dokter_nameid()
	{
		return $this->db->query("SELECT concat(nm_dokter,'-',cast(id_dokter as varchar),'-',ket) FROM data_dokter
		order by nm_dokter asc");
	}

	function get_user_ppa($userid)
	{
		return $this->db->query("SELECT user_ppa.*,ppa.ppa as ppa_name  FROM user_ppa
		LEFT JOIN ppa on user_ppa.ppa = ppa.id
		WHERE user_ppa.userid=$userid");
	}

	
	function get_all_dokter_by_poli($kode_poli)
	{
		return $this->db->query("SELECT data_dokter.nm_dokter FROM data_dokter 
		LEFT JOIN dokter_poli on dokter_poli.id_dokter = data_dokter.id_dokter
		WHERE dokter_poli.id_poli = '$kode_poli'");
	}

	function get_user_perawat_ppa() {
		return $this->db->query("SELECT concat(hmis_users.name,'-',cast(hmis_users.userid as varchar)) as name FROM user_ppa
		LEFT JOIN hmis_users on hmis_users.userid = user_ppa.userid WHERE user_ppa.ppa=1
		order by hmis_users.name");
	}

	function get_user_ok()
	{
		return $this->db->query("SELECT concat(data_dokter.nm_dokter,'-',cast(dyn_user_dokter.userid as varchar)) as name 
		FROM data_dokter  LEFT JOIN dyn_user_dokter  on dyn_user_dokter.id_dokter = data_dokter.id_dokter 
		where data_dokter.ket = 'Dokter Anestesi' or data_dokter.ket = 'Kamar Operasi'");
	}

	function get_user_penolakan()
	{
		return $this->db->query("SELECT concat(data_dokter.nm_dokter,'-',cast(dyn_user_dokter.userid as varchar)) as name 
		FROM data_dokter  LEFT JOIN dyn_user_dokter  on dyn_user_dokter.id_dokter = data_dokter.id_dokter 
		");
	}

	function get_nm_poli()
	{
		return $this->db->query("SELECT concat(nm_poli,'-',id_poli) FROM poliklinik
		order by nm_poli asc");
	}

	function get_nm_obat()
	{
		return $this->db->query("SELECT concat(nm_obat,'@',id_obat) FROM master_obat 
		order by nm_obat asc");
	}

	function get_all_dokter_obat()
	{
		return $this->db->query("SELECT concat(b.nm_dokter,'-',cast(A.userid as varchar)) FROM
				dyn_user_dokter AS A,
				data_dokter AS b 
			WHERE
				A.id_dokter = b.id_dokter 
				AND b.deleted = 0");
	}

	function get_all_dokter_perawat_bidan_ranap()
	{
		return $this->db->query("
		SELECT concat(A.name,'-',cast(A.userid as varchar)),b.role FROM
				hmis_users AS A,
				dyn_role_user AS b 
			WHERE
				A.userid = b.userid
				AND A.deleted = 0 and (b.roleid='1023' or b.roleid = '1021')
		");
	}

	// 
	function get_all_farmakologis()
	{
		return $this->db->query("SELECT concat(A.name,'-',cast(A.userid as varchar)) FROM
		hmis_users AS A,
		dyn_role_user AS b 
	WHERE
		A.userid = b.userid
		AND A.deleted = 0 and b.roleid='1026'");
	}


	function get_all_dokter_pasien($no_ipd)
	{
		return $this->db->query("SELECT 
		concat(a.id_dokter,'-',(SELECT nm_dokter from data_dokter b where a.id_dokter = CAST( b.id_dokter AS TEXT) )) 
		from drtambahan_iri a where a.no_register = '$no_ipd'");
	}

	function get_all_signa()
	{
		return $this->db->query("SELECT signa from signa
			WHERE deleted = '0'");
	}

	function get_all_cara_pakai()
	{
		return $this->db->query("SELECT cara_pakai from obat_cara_pakai where deleted = '0'");
	}

	function get_all_perawat()
	{
		return $this->db->query("SELECT concat(b.nm_dokter,'-',cast(A.userid as varchar)) FROM
		dyn_user_dokter AS A,
		data_dokter AS b 
	WHERE
		A.id_dokter = b.id_dokter and b.klp_pelaksana = 'PERAWAT'
		AND b.deleted = 0");
	}

	function get_all_user_ppa_perawat_dokter() {
		return $this->db->query("SELECT
			concat ( hmis_users.NAME, '-', CAST ( hmis_users.userid AS VARCHAR ) ) AS NAME 
		FROM
			user_ppa
			RIGHT JOIN hmis_users ON hmis_users.userid = user_ppa.userid 
		WHERE
			user_ppa.ppa = 1 
			AND hmis_users.userid != 1 
		UNION 
		SELECT
			concat ( hmis_users.NAME, '-', CAST ( hmis_users.userid AS VARCHAR ) ) AS NAME 
		FROM
			dyn_user_dokter AS a
			INNER JOIN hmis_users ON hmis_users.userid = a.userid
		ORDER BY
			NAME ASC");
	}

	function get_nm_obat_bmhp()
	{
		return $this->db->query("SELECT concat(nm_obat,'@',id_obat) FROM master_obat where deleted = '0' and id_obat >=6000 and jenis_obat != 'OBAT'
		order by nm_obat asc");
	}

	function get_all_dokter_konsul()
	{
		return $this->db->query("SELECT concat(b.nm_dokter,'-',cast(A.id_dokter as varchar)) FROM
				dyn_user_dokter AS A,
				data_dokter AS b 
			WHERE
				A.id_dokter = b.id_dokter 
				AND b.deleted = 0");
	}
	function get_user()
	{
		return $this->db->query("SELECT concat(A.name,'-',cast(A.userid as varchar)) FROM
				hmis_users AS A
			");
	}
	
}
?>