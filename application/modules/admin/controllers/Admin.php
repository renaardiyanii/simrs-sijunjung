<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_user', '', TRUE);
		$this->load->model('M_menu', '', TRUE);
		$this->load->model('M_role', '', TRUE);
		$this->load->model('Appconfig', '', TRUE);
		$this->load->model('bpjs/Mbpjs', '', TRUE);
	}

	// function decryptData($data)
	// {
	// 	$privateKey     = '@RSOMH12903123BUKITTINGGI2023)!^%@!*$('; // user define key
	// 	$secretKey      = '1b2532b238123b129'; // user define secret key
	// 	$encryptMethod  = "AES-256-CBC";
	// 	$stringEncrypt  = $data; // user encrypt value
	// 	$key    = hash('sha256',
	// 		$privateKey
	// 	);
	// 	$ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
	// 	$output = openssl_decrypt(base64_decode($stringEncrypt), $encryptMethod, $key, 0, $ivalue);
	// 	echo $output;
	// 	// output is a decripted value
	// }

	public function index()
	{
	}

	/*=================================== USER ============================================*/
	public function user()
	{
		$data["title"] = "Data User";
		$data['dokter'] = $this->M_user->get_all_dokter()->result();
		$data['ppa'] = $this->M_user->get_all_ppa()->result();
		$this->load->view('admin/user', $data);
	}

	public function userExist()
	{
		$username = $this->input->post('id');
		$exist = $this->M_user->exist($username);
		if ($exist > 0) {
			echo json_encode(array('exist' => true));
		} else {
			echo json_encode(array('exist' => false));
		}
	}

	public function userInfo()
	{
		$userid = $this->input->post('id');
		$data = $this->M_user->get_info($userid);
		echo json_encode($data);
	}

	public function userList()
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_all()->result();
		// var_dump($hasil);
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->userid;
			$row2['username'] = $value->username;
			$row2['name'] = $value->name;
			$row2['role'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Set Roles" data-toggle="modal" data-target="#myModal" onclick="setUserRole(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-user-secret fa-fw"></i></button></center>';
			$row2['ppa'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Set PPA" data-toggle="modal" data-target="#myModalPpa" onclick="setUserPpa(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-user-secret fa-fw"></i></button></center>';
			$row2['dokter'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Set Dokter" data-toggle="modal" data-target="#myModalDokter" onclick="setUserDokter(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-user-secret fa-fw"></i></button></center>';
			$row2['plus'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Gudang" data-toggle="modal" data-target="#myModalGdg" onclick="setUserGudang(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['poli'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Poli" data-toggle="modal" data-target="#myModalPoli" onclick="setUserPoli(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['ruang'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Ruang" data-toggle="modal" data-target="#myModalRuang" onclick="setUserRuang(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['hakakses'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Hak Akses Kasir" data-toggle="modal" data-target="#myModalAkses" onclick="setUserAkses(' . $value->userid . ',\'' . $value->username . '\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['aksi'] = '<center>
			<button type="button" class="btn btn-primary btn-xs" title="Reset Nama" data-toggle="modal" data-target="#editModaluser" data-id="' . $value->userid . '" data-username="' . $value->username . '" data-name="' . $value->name . '"><i class="fa fa-edit fa-fw"></i></button>&nbsp;
			<button type="button" class="btn btn-success btn-xs" title="Reset Password" data-toggle="modal" data-target="#editModal" data-id="' . $value->userid . '" data-username="' . $value->username . '" data-name="' . $value->name . '"><i class="fa fa-edit fa-fw"></i></button>&nbsp;
			<button type="button" class="btn btn-success btn-xs" title="Edit Tanda Tangan" data-toggle="modal" data-target="#ttdModal" data-ttd="' . $value->ttd . '" data-id="' . $value->userid . '" data-username="' . $value->username . '"><i class="fa fa-address-card fa-fw"></i></button>&nbsp;
			<a href="' . base_url() . 'admin/dropUser/' . $value->userid . '" class="btn btn-danger btn-xs delete_user" title="Delete"><i class="fa fa-trash fa-fw"></i></a></center>';

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function userRoleList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_all($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['sts'] = $value->sts;
			$row2['role'] = $value->role;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function userRoleSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userRoleSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}
	public function userAksesSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userAksesSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}
	public function userGdgList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_gudang($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id_gudang;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nama_gudang;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}
	public function userPoliList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_poli($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id_poli;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nm_poli;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}
	public function userRuangList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_ruang($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id_ruang;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nm_ruang;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function userAksesList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_user->get_role_akses($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['sts'] = $value->sts;
			$row2['kasir'] = $value->kasir;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function userGdgDelete()
	{
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userGdgDelete($id);
		echo json_encode(array('success' => true));
	}

	public function userGdgSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userGdgSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function userPoliDelete()
	{
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userPoliDelete($id);
		echo json_encode(array('success' => true));
	}

	public function userPoliSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userPoliSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function userRuangDelete()
	{
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userRuangDelete($id);
		echo json_encode(array('success' => true));
	}

	public function userRuangSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if ($this->M_user->userRuangSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	private function isSecurePassword($password)
	{
		// Define the regular expressions to check for each character type
		$regex_letter = '/[a-zA-Z]/';
		$regex_number = '/\d/';
		$regex_symbol = '/[!@#$%^&*()_+\-=\[\]{};:\'",.<>\/?\\|]/';

		// Check if the password is at least 8 characters long
		if (strlen($password) < 8) {
			return false;
		}

		// Check if the password contains at least one letter, one number, and one symbol
		if (
			!preg_match($regex_letter, $password) ||
			!preg_match($regex_number, $password) ||
			!preg_match($regex_symbol, $password)
		) {
			return false;
		}

		// If the password meets all criteria, it is considered secure
		return true;
	}

	function user_insert()
	{
		$newfilename = $this->input->post('username');
		//upload logo
		$config['upload_path'] = './upload/user/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$config['file_name'] = $newfilename;
		$this->upload->initialize($config);


		if (isset($_FILES['userfile']['name'])) {
			$userfile = $_FILES['userfile']['name'];
		}

		$data = $this->input->post();
		// if (!$this->isSecurePassword($data['password'])) {
		// 	echo json_encode(array('success' => false, 'msg' => 'Password kurang dari 8 karakter,harus memiliki simbol dan angka.'));
		// 	return;
		// }

		/**
		 * Penambahan user hash password 
		 * Rekomendasi BSSN
		 * @aldi 28/3/2023 3.15 PM
		 */
		// hash password 
		$newPass = $this->hashData($data['password']);
		$data['password'] = $newPass;
		// end hash

		if (isset($userfile)) {
			$ext = pathinfo($userfile, PATHINFO_EXTENSION);
			$file = $config['upload_path'] . $config['file_name'] . '.' . $ext;
			if (is_file($file))
				unlink($file);

			if (!$this->upload->do_upload()) {
				//$data['foto']=$old_logo;
				$error = $this->upload->display_errors();
				echo $error;
			} else {
				$upload = $this->upload->data();
				$foto = $upload['file_name'];
				//echo "success";
				//$this->userSave($data, $foto);
				if ($this->M_user->save($data, $foto)) {
					echo json_encode(array('success' => true));
				} else {
					echo json_encode(array('success' => false));
				}
			}
		} else {
			$foto = "";
			//$this->userSave($data, $foto);
			if ($this->M_user->save($data, $foto)) {
				echo json_encode(array('success' => true));
			} else {
				echo json_encode(array('success' => false));
			}
		}
	}
	public function reset_password()
	{
		// if (!$this->isSecurePassword($this->input->post('vpassword'))) {
		// 	echo json_encode(array('success' => false, 'msg' => 'Password kurang dari 8 karakter,harus memiliki simbol dan angka.'));
		// 	return;
		// }

		/**
		 * Rekomendasi BSSN - HASH PASSWORD
		 * @aldi 28/03/2023 03.17 PM
		 */
		$datas = $this->input->post();
		$newPass = $this->hashData($datas['vpassword']);
		$datas['vpassword'] = $newPass;

		if ($this->M_user->update($datas)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}
	public function edit_user()
	{
		// var_dump($this->input->post());
		// die();
		if ($this->M_user->update_user($this->input->post())) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}
	public function userSave($data, $foto)
	{
		if ($this->M_user->save($data, $foto)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function dropUser($userid)
	{
		if ($this->M_user->delete($userid)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	function update_photo()
	{
		$uid = $this->input->post('uid');
		//upload logo
		$config['upload_path'] = './upload/user/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$config['file_name'] = $uid;
		$this->upload->initialize($config);

		$userfile = $_FILES['userfile']['name'];
		$data = $this->input->post();

		if ($userfile) {
			$ext = pathinfo($userfile, PATHINFO_EXTENSION);
			$file = $config['upload_path'] . $config['file_name'] . '.' . $ext;
			if (is_file($file))
				unlink($file);

			if (!$this->upload->do_upload()) {
				$error = $this->upload->display_errors();
				echo $error;
			} else {
				$upload = $this->upload->data();
				$foto = $upload['file_name'];

				if ($this->M_user->update_photo($uid, $foto)) {
					echo json_encode(array('success' => true, 'photo' => $foto));
				} else {
					echo json_encode(array('success' => true, 'photo' => 'unknown.png'));
				}
			}
		}
	}
	function update_name()
	{
		$name = $this->input->post('uname');
		if ($this->M_user->update_name($this->input->post())) {
			echo json_encode(array('success' => true, 'name' => $name));
		}
	}
	/*======================================== MENU =================================================*/
	public function menu()
	{
		$data["title"] = "Data Menu";
		$data['parents'] = $this->M_menu->get_all_menu();
		$data['sortMenu'] = sortMenu();
		$this->load->view('admin/menu', $data);
	}

	public function menuInfo()
	{
		$page_id = $this->input->post('id');
		$data = $this->M_menu->get_info($page_id);
		echo json_encode($data);
	}

	public function hasChildMenu()
	{
		$page_id = $this->input->post('id');
		$child = $this->M_menu->has_child($page_id);
		if ($child > 0) {
			echo json_encode(array('hasChild' => true));
		} else {
			echo json_encode(array('hasChild' => false));
		}
	}

	public function menuSave()
	{
		if ($this->input->post('id') == '') {
			$data = array(
				'title' => $this->input->post('title'),
				'url' => $this->input->post('url'),
				'parent_id' => $this->input->post('parent_id')
			);
		} else {
			$data = array(
				'page_id' => $this->input->post('id'),
				'title' => $this->input->post('title'),
				'url' => $this->input->post('url'),
				'parent_id' => $this->input->post('parent_id')
			);
		}

		if ($this->M_menu->save($data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function dropMenu()
	{
		$page_id = $this->input->post('id');
		if ($this->M_menu->delete($page_id)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function updateOrderMenu()
	{
		$arr = $this->input->post('data');
		echo $this->M_menu->updatePosition($arr);
	}
	/*================================== ROLE ========================================*/

	public function role()
	{
		$data["title"] = "Data Role";
		$this->load->view('admin/role', $data);
	}

	public function roleExist()
	{
		$role = $this->input->post('id');
		$exist = $this->M_role->exist($role);
		if ($exist > 0) {
			echo json_encode(array('exist' => true));
		} else {
			echo json_encode(array('exist' => false));
		}
	}

	public function roleList()
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_role->get_all()->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['role'] = $value->role;
			$row2['deskripsi'] = $value->deskripsi;
			$row2['access'] = '<center><a href="#" title="Set Access Menu" data-toggle="modal" data-target="#myModal" onclick="setAccessRole(' . $value->id . ',\'' . $value->role . '\')" ><i class="fa fa-user-secret fa-fw"></i></a></center>';
			$row2['edit'] = '<center><a href="#" title="Set Inactive" data-toggle="modal" data-target="#editModal" onclick="edit_role(' . $value->id . ')"><i class="fa fa-edit fa-fw"></i></a></center>';
			$row2['drop'] = '<center><a href="#" title="Delete" id="delete" data-toggle="modal" data-target="#deleteModal" onclick="delete_role(' . $value->id . ')"><i class="fa fa-trash fa-fw"></i></a></center>';
			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function roleSave()
	{
		$data = array(
			'id' => $this->input->post('id'),
			'role' => $this->input->post('role'),
			'deskripsi' => $this->input->post('deskripsi')
		);
		/*echo json_encode($data);*/

		if ($this->M_role->save($data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function roleMenuList($id)
	{

		$line  = array();
		$line2 = array();
		$row2  = array();

		$hasil = $this->M_role->get_menu_all($id)->result();
		/*echo json_encode($hasil);*/

		foreach ($hasil as $value) {
			$row2['id'] = $value->page_id;
			$row2['urutan'] = $value->urutan;
			$row2['sts'] = $value->sts;
			$row2['menu'] = $value->title;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function roleMenuSave()
	{
		$data = $this->input->post('vdata');
		$id = $data[0]['role_id'];
		/**/
		if ($this->M_role->roleMenuSave($id, $data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function roleMenuDelete()
	{
		$id = $this->input->post('delete_id');

		if ($this->M_role->roleMenuDelete($id)) {
			return redirect('admin/role');
		} else {
			return redirect('admin/role');
		}
	}

	public function get_data_edit_role($id)
	{
		$id = $this->input->post('id');
		$datajson = $this->M_role->get_data_edit_role($id)->result();
		echo json_encode($datajson);
	}

	public function roleMenuEdit()
	{
		$id = $this->input->post('edit_id');
		$data['role'] = $this->input->post('edit_role');
		$data['deskripsi'] = $this->input->post('edit_deskripsi');
		$data['is_active'] = $this->input->post('edit_active');
		/*echo json_encode($data);*/

		if ($this->M_role->roleMenuEdit($id, $data)) {
			return redirect('admin/role');
		} else {
			return redirect('admin/role');
		}
	}

	/*======================================== Konfigurasi BPJS =================================================*/

	function konfigurasi_bpjs()
	{
		$data['title'] = 'Konfigurasi BPJS';
		$data['data'] = $this->Mbpjs->get_data_bpjs();
		$this->load->view("admin/bpjs", $data);
	}

	public function show_bpjs()
	{
		$result = $this->Mbpjs->get_data_bpjs();
		echo json_encode($result);
	}

	public function show_hide_secid()
	{
		$user = $this->input->post('user');
		$password = $this->input->post('password');
		$result = $this->Mbpjs->show_hide_secid($user, $password);
		echo json_encode($result);
	}

	public function update_bpjs()
	{
		$poli_eksekutif = 0;
		$cob_irj = 0;
		$cob_iri = 0;
		if ($this->input->post('poli_eksekutif') == 1) {
			$poli_eksekutif = 1;
		}
		if ($this->input->post('cob_irj') == 1) {
			$cob_irj = 1;
		}
		if ($this->input->post('cob_iri') == 1) {
			$cob_iri = 1;
		}
		$data_bpjs = array(
			'service_url' => $this->input->post('service_url'),
			'consid' => $this->input->post('consid'),
			'secid' => $this->input->post('secid'),
			'rsid' => $this->input->post('rsid'),
			'poli_eksekutif' => $poli_eksekutif,
			'cob_irj' => $cob_irj,
			'cob_iri' => $cob_iri
		);
		$update = $this->Mbpjs->update_bpjs($data_bpjs);
		echo json_encode($update);
	}

	/*======================================== KASTEM =================================================*/
	function config()
	{
		$data["title"] = "Kastemisasi Aplikasi";
		$this->load->view('admin/config', $data);
	}

	function configSave()
	{
		$data = array(
			'web_title' => $this->input->post('web_title'),
			'header_title' => $this->input->post('header_title'),
			'logo_url' => $this->input->post('userfile'),
			'background' => $this->input->post('userfile1'),
			'skin' => $this->input->post('skin'),
			'namars' => $this->input->post('namars'),
			'namasingkat' => $this->input->post('namasingkat'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $this->input->post('telp'),
			'kota' => $this->input->post('kota')
		);

		//upload logo
		$config['upload_path'] = './asset/images/logos';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$this->upload->initialize($config);

		$old_logo = $this->config->item('logo_url');

		if (!$this->upload->do_upload()) {
			$data['logo_url'] = $old_logo;
			//$error = $this->upload->display_errors();
			//echo $error;
		} else {
			$upload = $this->upload->data();
			$data['logo_url'] = $upload['file_name'];
		}

		//upload background
		$config['upload_path'] = './asset/images';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '4000000';
		$config['max_width'] = '5000';
		$config['max_height'] = '5000';
		$this->upload->initialize($config);

		$old_background = $this->config->item('background');

		if (!$this->upload->do_upload()) {
			$data['background'] = $old_background;
			//$error = $this->upload->display_errors();
			//echo $error;
		} else {
			$upload = $this->upload->data();
			$data['background'] = $upload['file_name'];
		}

		if ($this->Appconfig->batch_save($data)) {
			//delete old logo
			if ($data['logo_url'] != $old_logo && $old_logo != "logo.png") {
				$file = './asset/images/logos/' . $old_logo;
				if (is_file($file))
					unlink($file);
			}
			if ($data['background'] != $old_background && $old_background != "background.png") {
				$file = './asset/images/' . $old_background;
				if (is_file($file))
					unlink($file);
			}
			redirect(site_url("admin/config"), 'refresh');
		}
	}

	public function update_ttd()
	{
		$data = $this->input->post();
		if ($this->M_user->update_ttd($data)) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}


	public function userSaveDokter()
	{
		$data  = $this->input->post();
		$userid = $this->input->post('userid');
		$check_available_data = $this->M_user->get_user_dokter($data['userid']);
		$result = ($check_available_data->num_rows() ? $this->M_user->update_user_dokter($userid, $data) : $this->M_user->insert_user_dokter($data));
		echo json_encode(array('kode' => $result));
	}

	public function cek_dokter()
	{

		$userid = $this->input->post('userid');
		$check_available_data = $this->M_user->get_user_dokter($userid);
		$result = ($check_available_data->num_rows() ? $check_available_data->row() : array("id_dokter" => "0"));

		echo json_encode(array('kode' => $result));
	}

	public function cek_ppa()
	{
		$userid = $this->input->post('userid');
		$check_available_data = $this->M_user->get_user_ppa($userid);
		$result = $check_available_data->num_rows() ? $check_available_data->row() : array('id' => '0');

		echo json_encode(['kode' => $result]);
	}

	public function userSavePpa()
	{
		$data  = $this->input->post();
		$userid = $this->input->post('userid');
		$check_available_data = $this->M_user->get_user_ppa($data['userid']);
		$result = ($check_available_data->num_rows() ? $this->M_user->update_user_ppa($userid, $data) : $this->M_user->insert_user_ppa($data));
		echo json_encode(array('kode' => $result));
	}

	public function rest_userppa()
	{
		echo json_encode($this->M_user->get_all_user_ppa()->result_array());
	}

	public function rest_user_perawat_ppa()
	{
		echo json_encode($this->M_user->get_user_perawat_ppa()->result_array());
	}

	public function rest_user_ok()
	{
		echo json_encode($this->M_user->get_user_ok()->result_array());
	}

	public function rest_userppa_iri()
	{
		echo json_encode($this->M_user->get_all_user_ppa_iri()->result_array());
	}

	public function rest_userppa_perawat_dokter()
	{
		echo json_encode($this->M_user->get_all_user_ppa_perawat_dokter()->result_array());
	}

	public function get_all_icd()
	{
		echo json_encode($this->M_user->get_all_icd()->result_array());
	}

	public function get_all_icd9()
	{
		echo json_encode($this->M_user->get_all_icd9()->result_array());
	}

	public function rest_all_user()
	{
		echo json_encode($this->M_user->get_all_user()->result_array());
	}


	public function rest_perawat_spesialis()
	{
		echo json_encode($this->M_user->get_all_dokter_name()->result_array());
	}

	public function rest_dokter_ppa_iri_distinct()
	{
		echo json_encode($this->M_user->get_all_dokter_nameid_distinct()->result_array());
	}

	public function rest_dokter_ppa_iri()
	{
		echo json_encode($this->M_user->get_all_dokter_nameid()->result_array());
	}

	public function rest_dokter_by_poli($kode_poli)
	{
		echo json_encode($this->M_user->get_all_dokter_by_poli($kode_poli)->result_array());
	}

	public function get_dok_ok()
	{
		echo json_encode($this->M_user->get_user_ok()->result_array());
	}

	public function get_dok_penolakan()
	{
		echo json_encode($this->M_user->get_user_penolakan()->result_array());
	}

	public function nm_poli()
	{
		echo json_encode($this->M_user->get_nm_poli()->result_array());
	}

	public function master_obat()
	{
		echo json_encode($this->M_user->get_nm_obat()->result_array());
	}

	public function dokter()
	{
		echo json_encode($this->M_user->get_all_dokter_obat()->result_array());
	}

	public function farmakologis()
	{
		echo json_encode($this->M_user->get_all_farmakologis()->result_array());
	}

	public function perawat_ranap_bidan()
	{
		echo json_encode($this->M_user->get_all_dokter_perawat_bidan_ranap()->result_array());
	}

	public function dokter_pasien($no_ipd)
	{
		echo json_encode($this->M_user->get_all_dokter_pasien($no_ipd)->result_array());
	}

	public function signa()
	{
		echo json_encode($this->M_user->get_all_signa()->result_array());
	}
	public function qtx()
	{
		echo json_encode($this->M_user->get_all_qtx()->result_array());
	}

	public function satuan()
	{
		echo json_encode($this->M_user->get_all_satuan()->result_array());
	}


	public function cara_pakai()
	{
		echo json_encode($this->M_user->get_all_cara_pakai()->result_array());
	}

	public function perawat()
	{
		echo json_encode($this->M_user->get_all_perawat()->result_array());
	}


	private function ambil_id_obat($nama_obat, $satuan)
	{
		$this->load->database();
		$obat = $this->db->query("SELECT id_obat from master_obat where nm_obat = '$nama_obat' and id_obat > 7000 order by id_obat desc limit 1")->row();
		if ($obat) {
			return $obat->id_obat;
		}
		// return '';
		$this->db->insert(
			'master_obat',
			[
				'nm_obat' => $nama_obat,
				'satuank' => $satuan,
				'satuanb' => $satuan,
				'faktorsatuan' => '1',
				'jenis_obat' => 'OBAT',
				'deleted' => '0',
			]
		);
		$obat = $this->db->query("SELECT id_obat from master_obat where nm_obat = '$nama_obat' and id_obat > 7000 order by id_obat desc limit 1")->row();
		return $obat->id_obat;
		// $no_medrec = $this->db->insert_id();
	}

	private function insert_gudang_inventory($data)
	{
		$this->load->database();
		$result = $this->db->insert('gudang_inventory', $data);
		// try {
		// 	return true;
		// } catch (Exception $e) {
		//     // You can rethrow the exception if needed or handle it accordingly
		//     return false;
		// }
		if ($result === true) {
			return true; // Data inserted successfully
		} else {
			return false; // There was an error
		}
	}

	private function convertTimestamp($val)
	{
		if (is_numeric($val) && $val != '') {
			$phpDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp(intval($val));
			$res = date('Y-m-d', $phpDate);
			return $res;
		} else {
			$explode = explode('/', $val);
			if (count($explode) == 2) {
				return "20$explode[1]-$explode[0]-01";
			}
			if (count($explode) == 3) {
				return "$explode[2]-$explode[1]-$explode[0]";
			} else {
				return '2024-01-01';
			}
			// echo 'masuk sini<br>';
			// echo $val;
			// return $val;
		}
		// return $val;
	}

	/**
	 * Bot Baca Excel SO Gudang Farmasi 
	 * -> ambil id obat dari master_obat
	 * -> ada ? insert , gaada ? tandain di sheet baru untuk diinsert manual.
	 * -> hasilnya ? sheet baru data mana aja dan id berapa yang berhasil ke isi termasuk id_inventory nya.
	 */
	public function load_data_obat()
	{
		$this->load->database();
		$this->db->update('gudang_inventory', ['deleted' => '1']);

		$inputFileType = 'Xlsx';
		//    $inputFileType = 'Xlsx';
		//    $inputFileType = 'Xml';
		//    $inputFileType = 'Ods';
		//    $inputFileType = 'Slk';
		//    $inputFileType = 'Gnumeric';
		//    $inputFileType = 'Csv';
		// $inputFileName = './sampleData/example1.xls';
		$inputFileName = FCPATH . 'stok_depo.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$worksheet = $spreadsheet->createSheet();
		$worksheet->setTitle('Tidak ada ID OBAT');
		$worksheet = $spreadsheet->createSheet();
		$worksheet->setTitle('Ada ID OBAT');

		$sheet = $spreadsheet->getSheet(0);
		$cellValue = $spreadsheet->getActiveSheet()->getCell('C11')->getValue();
		$nb = 0;
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		// echo $cellValue;
		$depo_irna_a = [];
		$depo_neurologi = [];
		$depo_irna_b = [];
		$depo_irna_c = [];
		$depo_rawat_jalan = [];
		$produksi_farmasi = [];
		$countNull = 2;
		$countOk = 2;
		$resultBerhasil = 0;
		$resultGagal = 0;
		$metadata = [
			'code' => 200,
			'result' => []
		];

		for ($i = 11; $i <= $highestRow; $i++) {
			// for($i = 1;$i<=20;$i+=1){
			// echo 'Halaman '. $i.'<br>';
			$satuan = $spreadsheet->getActiveSheet()->getCell("G$i")->getValue();
			$satuan_ppn = $spreadsheet->getActiveSheet()->getCell("H$i")->getValue();
			$filter_depo_irna_a = $spreadsheet->getActiveSheet()->getCell("L$i")->getValue();
			$filter_depo_irna_a_stok = $spreadsheet->getActiveSheet()->getCell("I$i")->getCalculatedValue();
			$filter_depo_irna_a_harga = $spreadsheet->getActiveSheet()->getCell("H$i")->getCalculatedValue();
			$filter_depo_irna_a_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("K$i")->getValue());
			$filter_depo_neurologi = $spreadsheet->getActiveSheet()->getCell("Q$i")->getValue();
			$filter_depo_neurologi_stok = $spreadsheet->getActiveSheet()->getCell("N$i")->getCalculatedValue();
			$filter_depo_neurologi_harga = $spreadsheet->getActiveSheet()->getCell("H$i")->getCalculatedValue();
			$filter_depo_neurologi_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("P$i")->getValue());
			$filter_depo_irna_b = $spreadsheet->getActiveSheet()->getCell("V$i")->getValue();
			$filter_depo_irna_b_stok = $spreadsheet->getActiveSheet()->getCell("S$i")->getCalculatedValue();
			$filter_depo_irna_b_harga = $spreadsheet->getActiveSheet()->getCell("H$i")->getCalculatedValue();
			$filter_depo_irna_b_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("U$i")->getValue());
			$filter_depo_irna_c = $spreadsheet->getActiveSheet()->getCell("AA$i")->getValue();
			$filter_depo_irna_c_stok = $spreadsheet->getActiveSheet()->getCell("X$i")->getCalculatedValue();
			$filter_depo_irna_c_harga = $spreadsheet->getActiveSheet()->getCell("H$i")->getCalculatedValue();
			$filter_depo_irna_c_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("Z$i")->getValue());
			$filter_depo_rawat_jalan = $spreadsheet->getActiveSheet()->getCell("AF$i")->getValue();
			$filter_depo_rawat_jalan_stok = $spreadsheet->getActiveSheet()->getCell("AC$i")->getCalculatedValue();
			$filter_depo_rawat_jalan_harga = $spreadsheet->getActiveSheet()->getCell("H$i")->getCalculatedValue();
			$filter_depo_rawat_jalan_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("AE$i")->getValue());
			$filter_produksi_farmasi = $spreadsheet->getActiveSheet()->getCell("AK$i")->getValue();
			$filter_produksi_farmasi_stok = $spreadsheet->getActiveSheet()->getCell("AH$i")->getCalculatedValue();
			$filter_produksi_farmasi_harga = $spreadsheet->getActiveSheet()->getCell("H$i")->getCalculatedValue();
			$filter_produksi_farmasi_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("AJ$i")->getValue());
			$id_obat = $this->ambil_id_obat(trim($spreadsheet->getActiveSheet()->getCell("C$i")->getValue()), $satuan,);
			$nm_obat = $spreadsheet->getActiveSheet()->getCell("C$i")->getValue();
			// echo "$i ".$nm_obat.'<br>';

			$kolom = $spreadsheet->getActiveSheet()->getCell("A$i")->getValue();
			if ($id_obat == '') {
				$sheet = $spreadsheet->getSheet(1);
				$sheet->setCellValue('A1', 'No.');
				$sheet->setCellValue('B1', 'Nama Obat');
				$sheet->setCellValue('A' . $countNull, $kolom);
				$sheet->setCellValue('B' . $countNull, $nm_obat);
				$countNull++;
			} else {
				$sheet = $spreadsheet->getSheet(2);
				$sheet->setCellValue('A1', 'id_obat');
				$sheet->setCellValue('B1', 'id_gudang');
				$sheet->setCellValue('C1', 'qty');
				$sheet->setCellValue('D1', 'expire_date');
				$sheet->setCellValue('E1', 'batch_no');
				$sheet->setCellValue('F1', 'harga_jual');
				$sheet->setCellValue('G1', 'harga_beli');
				$sheet->setCellValue('H1', 'satuan');
				$sheet->setCellValue('I1', 'deleted');
				$sheet->setCellValue('J1', 'tgl_so');
				$sheet->setCellValue('K1', 'Nama Obat');


				//  depo irna a : 114
				// - depo neurologi : 4
				// - depo irna b :8
				// - depo irna c : 5
				// - depo rawat jalan : 2
				// - produksi farmasi : 7
				if ($filter_depo_irna_a != '') {

					// echo '<br>Irna a : '.$id_obat.' '.$filter_depo_irna_a;
					$sheet->setCellValue('A' . $countOk, $id_obat);
					$sheet->setCellValue('B' . $countOk, 114);
					$sheet->setCellValue('C' . $countOk, $filter_depo_irna_a_stok);
					$sheet->setCellValue('D' . $countOk, $filter_depo_irna_a_expired);
					$sheet->setCellValue('E' . $countOk, $filter_depo_irna_a);
					$sheet->setCellValue('F' . $countOk, $filter_depo_irna_a_harga);
					$sheet->setCellValue('G' . $countOk, '0');
					$sheet->setCellValue('H' . $countOk, $satuan);
					$sheet->setCellValue('I' . $countOk, '0');
					$sheet->setCellValue('J' . $countOk, date('Y-m-d'));
					$sheet->setCellValue('K' . $countOk, $nm_obat);
					$vs = [
						'id_obat' => $id_obat,
						'id_gudang' => 114,
						'qty' => $filter_depo_irna_a_stok,
						'expire_date' => $filter_depo_irna_a_expired,
						'batch_no' => "$filter_depo_irna_a",
						'hargajual' => $filter_depo_irna_a_harga,
						'hargabeli' => '0',
						'satuan' => $satuan,
						'deleted' => '0',
						'tgl_so' => date('Y-m-d')

					];
					$resultdb = $this->insert_gudang_inventory($vs);
					if ($resultdb) {
						$metadata['result'][$i] = 'OK';
					} else {
						$metadata['result'][$i] = json_encode($vs);
					}
					$countOk++;
				}
				if ($filter_depo_neurologi != '') {
					// echo '<br>Irna Neuro : '.$id_obat.' '.$filter_depo_neurologi;

					$sheet->setCellValue('A' . $countOk, $id_obat);
					$sheet->setCellValue('B' . $countOk, 4);
					$sheet->setCellValue('C' . $countOk, $filter_depo_neurologi_stok);
					$sheet->setCellValue('D' . $countOk, $filter_depo_neurologi_expired);
					$sheet->setCellValue('E' . $countOk, $filter_depo_neurologi);
					$sheet->setCellValue('F' . $countOk, $filter_depo_neurologi_harga);
					$sheet->setCellValue('G' . $countOk, '0');
					$sheet->setCellValue('H' . $countOk, $satuan);
					$sheet->setCellValue('I' . $countOk, '0');
					$sheet->setCellValue('J' . $countOk, date('Y-m-d'));
					$sheet->setCellValue('K' . $countOk, $nm_obat);
					$vs = [
						'id_obat' => $id_obat,
						'id_gudang' => 4,
						'qty' => $filter_depo_neurologi_stok,
						'expire_date' => $filter_depo_neurologi_expired,
						'batch_no' => "$filter_depo_neurologi",
						'hargajual' => $filter_depo_neurologi_harga,
						'hargabeli' => '0',
						'satuan' => $satuan,
						'deleted' => '0',
						'tgl_so' => date('Y-m-d')

					];
					$resultdb = $this->insert_gudang_inventory($vs);
					if ($resultdb) {
						$metadata['result'][$i] = 'OK';
					} else {
						$metadata['result'][$i] = json_encode($vs);
					}
					$countOk++;
				}
				if ($filter_depo_irna_b != '') {
					// echo '<br>Irna B : '.$id_obat.' '.$filter_depo_irna_b;
					$sheet->setCellValue('A' . $countOk, $id_obat);
					$sheet->setCellValue('B' . $countOk, 8);
					$sheet->setCellValue('C' . $countOk, $filter_depo_irna_b_stok);
					$sheet->setCellValue('D' . $countOk, $filter_depo_irna_b_expired);
					$sheet->setCellValue('E' . $countOk, $filter_depo_irna_b);
					$sheet->setCellValue('F' . $countOk, $filter_depo_irna_b_harga);
					$sheet->setCellValue('G' . $countOk, '0');
					$sheet->setCellValue('H' . $countOk, $satuan);
					$sheet->setCellValue('I' . $countOk, '0');
					$sheet->setCellValue('J' . $countOk, date('Y-m-d'));
					$sheet->setCellValue('K' . $countOk, $nm_obat);
					$vs = [
						'id_obat' => $id_obat,
						'id_gudang' => 8,
						'qty' => $filter_depo_irna_b_stok,
						'expire_date' => $filter_depo_irna_b_expired,
						'batch_no' => "$filter_depo_irna_b",
						'hargajual' => $filter_depo_irna_b_harga,
						'hargabeli' => '0',
						'satuan' => $satuan,
						'deleted' => '0',
						'tgl_so' => date('Y-m-d')

					];
					$resultdb = $this->insert_gudang_inventory($vs);
					if ($resultdb) {
						$metadata['result'][$i] = 'OK';
					} else {
						$metadata['result'][$i] = json_encode($vs);
					}
					$countOk++;
				}

				if ($filter_depo_irna_c != '') {
					// echo '<br>Irna C : '.$id_obat.' '.$filter_depo_irna_c;
					// echo "$i ".count(explode('/',$filter_depo_irna_c_expired)).'<br>';
					// echo "$i ".$filter_depo_irna_c_expired.'<br>';

					$sheet->setCellValue('A' . $countOk, $id_obat);
					$sheet->setCellValue('B' . $countOk, 5);
					$sheet->setCellValue('C' . $countOk, $filter_depo_irna_c_stok);
					$sheet->setCellValue('D' . $countOk, $filter_depo_irna_c_expired);
					$sheet->setCellValue('E' . $countOk, $filter_depo_irna_c);
					$sheet->setCellValue('F' . $countOk, $filter_depo_irna_c_harga);
					$sheet->setCellValue('G' . $countOk, '0');
					$sheet->setCellValue('H' . $countOk, $satuan);
					$sheet->setCellValue('I' . $countOk, '0');
					$sheet->setCellValue('J' . $countOk, date('Y-m-d'));
					$sheet->setCellValue('K' . $countOk, $nm_obat);
					$vs = [
						'id_obat' => $id_obat,
						'id_gudang' => 5,
						'qty' => $filter_depo_irna_c_stok,
						'expire_date' => $filter_depo_irna_c_expired,
						'batch_no' => "$filter_depo_irna_c",
						'hargajual' => $filter_depo_irna_c_harga,
						'hargabeli' => '0',
						'satuan' => $satuan,
						'deleted' => '0',
						'tgl_so' => date('Y-m-d')

					];
					$resultdb = $this->insert_gudang_inventory($vs);
					if ($resultdb) {
						$metadata['result'][$i] = 'OK';
					} else {
						$metadata['result'][$i] = json_encode($vs);
					}
					$countOk++;
				}
				if ($filter_depo_rawat_jalan != '') {
					// echo '<br>Irna Rajal : '.$id_obat.' '.$filter_depo_rawat_jalan;
					$sheet->setCellValue('A' . $countOk, $id_obat);
					$sheet->setCellValue('B' . $countOk, 2);
					$sheet->setCellValue('C' . $countOk, $filter_depo_rawat_jalan_stok);
					$sheet->setCellValue('D' . $countOk, $filter_depo_rawat_jalan_expired);
					$sheet->setCellValue('E' . $countOk, $filter_depo_rawat_jalan);
					$sheet->setCellValue('F' . $countOk, $filter_depo_rawat_jalan_harga);
					$sheet->setCellValue('G' . $countOk, '0');
					$sheet->setCellValue('H' . $countOk, $satuan);
					$sheet->setCellValue('I' . $countOk, '0');
					$sheet->setCellValue('J' . $countOk, date('Y-m-d'));
					$sheet->setCellValue('K' . $countOk, $nm_obat);
					$vs = [
						'id_obat' => $id_obat,
						'id_gudang' => 2,
						'qty' => $filter_depo_rawat_jalan_stok,
						'expire_date' => $filter_depo_rawat_jalan_expired,
						'batch_no' => "$filter_depo_rawat_jalan",
						'hargajual' => $filter_depo_rawat_jalan_harga,
						'hargabeli' => '0',
						'satuan' => $satuan,
						'deleted' => '0',
						'tgl_so' => date('Y-m-d')

					];
					$resultdb = $this->insert_gudang_inventory($vs);
					if ($resultdb) {
						$metadata['result'][$i] = 'OK';
					} else {
						$metadata['result'][$i] = json_encode($vs);
					}
					$countOk++;
				}
				if ($filter_produksi_farmasi != '') {
					// echo '<br>Irna Farmas : '.$id_obat.' '.$filter_produksi_farmasi;
					$sheet->setCellValue('A' . $countOk, $id_obat);
					$sheet->setCellValue('B' . $countOk, 7);
					$sheet->setCellValue('C' . $countOk, $filter_produksi_farmasi_stok);
					$sheet->setCellValue('D' . $countOk, $filter_produksi_farmasi_expired);
					$sheet->setCellValue('E' . $countOk, $filter_produksi_farmasi);
					$sheet->setCellValue('F' . $countOk, $filter_produksi_farmasi_harga);
					$sheet->setCellValue('G' . $countOk, '0');
					$sheet->setCellValue('H' . $countOk, $satuan);
					$sheet->setCellValue('I' . $countOk, '0');
					$sheet->setCellValue('J' . $countOk, date('Y-m-d'));
					$sheet->setCellValue('K' . $countOk, $nm_obat);
					$vs = [
						'id_obat' => $id_obat,
						'id_gudang' => 7,
						'qty' => $filter_produksi_farmasi_stok,
						'expire_date' => $filter_produksi_farmasi_expired,
						'batch_no' => "$filter_produksi_farmasi",
						'hargajual' => $filter_produksi_farmasi_harga,
						'hargabeli' => '0',
						'satuan' => $satuan,
						'deleted' => '0',
						'tgl_so' => date('Y-m-d')

					];
					$resultdb = $this->insert_gudang_inventory($vs);
					if ($resultdb) {
						$metadata['result'][$i] = 'OK';
					} else {
						$metadata['result'][$i] = json_encode($vs);
					}
					$countOk++;
				}
			}
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($metadata);
		// die();
		// $writer = new Xlsx($spreadsheet);
		// $writer->save(FCPATH.'hasil.xlsx');
		// die();
	}

	public function load_data_farmasi()
	{
		$this->load->database();
		// $this->db->update('gudang_inventory',['deleted'=>'1']);

		$inputFileType = 'Xlsx';
		//    $inputFileType = 'Xlsx';
		//    $inputFileType = 'Xml';
		//    $inputFileType = 'Ods';
		//    $inputFileType = 'Slk';
		//    $inputFileType = 'Gnumeric';
		//    $inputFileType = 'Csv';
		// $inputFileName = './sampleData/example1.xls';
		$inputFileName = FCPATH . 'stock_gudang.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);

		$sheet = $spreadsheet->getSheet(0);
		// $cellValue = $spreadsheet->getActiveSheet()->getCell('C11')->getValue();
		$nb = 0;
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		// echo $cellValue;
		$depo_irna_a = [];
		$depo_neurologi = [];
		$depo_irna_b = [];
		$depo_irna_c = [];
		$depo_rawat_jalan = [];
		$produksi_farmasi = [];
		$countNull = 2;
		$countOk = 2;
		$resultBerhasil = 0;
		$resultGagal = 0;
		$metadata = [
			'code' => 200,
			'result' => []
		];

		for ($i = 11; $i <= $highestRow; $i++) {
			// for($i = 1;$i<=20;$i+=1){
			// echo 'Halaman '. $i.'<br>';
			$satuan = $spreadsheet->getActiveSheet()->getCell("I$i")->getValue();
			$satuan_ppn = $spreadsheet->getActiveSheet()->getCell("J$i")->getValue();
			$filter_gudang = $spreadsheet->getActiveSheet()->getCell("S$i")->getValue();
			$filter_gudang_stok = $spreadsheet->getActiveSheet()->getCell("T$i")->getCalculatedValue();
			$filter_gudang_harga = $spreadsheet->getActiveSheet()->getCell("J$i")->getCalculatedValue();
			$filter_gudang_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("R$i")->getValue());

			$id_obat = $this->ambil_id_obat(trim($spreadsheet->getActiveSheet()->getCell("E$i")->getValue()), $satuan);
			$nm_obat = $spreadsheet->getActiveSheet()->getCell("E$i")->getValue();

			$kolom = $spreadsheet->getActiveSheet()->getCell("A$i")->getValue();
			if ($filter_gudang == '') {
				// $sheet = $spreadsheet->getSheet(1);
				// $sheet->setCellValue('A1','No.');
				// $sheet->setCellValue('B1','Nama Obat');
				// $sheet->setCellValue('A'.$countNull,$kolom);
				// $sheet->setCellValue('B'.$countNull,$nm_obat);
				// $countNull++;
			} else {
				// $sheet = $spreadsheet->getSheet(2);
				// $sheet->setCellValue('A1','id_obat');
				// $sheet->setCellValue('B1','id_gudang');
				// $sheet->setCellValue('C1','qty');
				// $sheet->setCellValue('D1','expire_date');
				// $sheet->setCellValue('E1','batch_no');
				// $sheet->setCellValue('F1','harga_jual');
				// $sheet->setCellValue('G1','harga_beli');
				// $sheet->setCellValue('H1','satuan');
				// $sheet->setCellValue('I1','deleted');
				// $sheet->setCellValue('J1','tgl_so');
				// $sheet->setCellValue('K1','Nama Obat');


				//  depo irna a : 114
				// - depo neurologi : 4
				// - depo irna b :8
				// - depo irna c : 5
				// - depo rawat jalan : 2
				// - produksi farmasi : 7

				// echo '<br>Irna a : '.$id_obat.' '.$filter_depo_irna_a;
				// $sheet->setCellValue('A'.$countOk,$id_obat);
				// $sheet->setCellValue('B'.$countOk,114);
				// $sheet->setCellValue('C'.$countOk,$filter_depo_irna_a_stok);
				// $sheet->setCellValue('D'.$countOk,$filter_depo_irna_a_expired);
				// $sheet->setCellValue('E'.$countOk,$filter_depo_irna_a);
				// $sheet->setCellValue('F'.$countOk,$filter_depo_irna_a_harga);
				// $sheet->setCellValue('G'.$countOk,'0');
				// $sheet->setCellValue('H'.$countOk,$satuan);
				// $sheet->setCellValue('I'.$countOk,'0');
				// $sheet->setCellValue('J'.$countOk,date('Y-m-d'));
				// $sheet->setCellValue('K'.$countOk,$nm_obat);
				$vs = [
					'id_obat' => $id_obat,
					'id_gudang' => 1,
					'qty' => $filter_gudang_stok,
					'expire_date' => $filter_gudang_expired,
					'batch_no' => "$filter_gudang",
					'hargajual' => $filter_gudang_harga,
					'hargabeli' => '0',
					'satuan' => $satuan,
					'deleted' => '0',
					'tgl_so' => date('Y-m-d')

				];
				// var_dump($vs);
				$resultdb = $this->insert_gudang_inventory($vs);
				if ($resultdb) {
					$metadata['result'][$i] = 'OK';
				} else {
					$metadata['result'][$i] = json_encode($vs);
				}
				$countOk++;
			}
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($metadata);
		// die();
		// $writer = new Xlsx($spreadsheet);
		// $writer->save(FCPATH.'hasil.xlsx');
		// die();
	}

	public function load_data_farmasi_2()
	{
		$this->load->database();
		// $this->db->update('gudang_inventory',['deleted'=>'1']);

		$inputFileType = 'Xlsx';
		//    $inputFileType = 'Xlsx';
		//    $inputFileType = 'Xml';
		//    $inputFileType = 'Ods';
		//    $inputFileType = 'Slk';
		//    $inputFileType = 'Gnumeric';
		//    $inputFileType = 'Csv';
		// $inputFileName = './sampleData/example1.xls';
		$inputFileName = FCPATH . 'stock_gudang_far.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$reader->setLoadSheetsOnly('KIT');
		$spreadsheet = $reader->load($inputFileName);

		// $cellValue = $spreadsheet->getActiveSheet()->getCell('C11')->getValue();
		$nb = 0;
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		// echo $cellValue;
		$depo_irna_a = [];
		$depo_neurologi = [];
		$depo_irna_b = [];
		$depo_irna_c = [];
		$depo_rawat_jalan = [];
		$produksi_farmasi = [];
		$countNull = 2;
		$countOk = 2;
		$resultBerhasil = 0;
		$resultGagal = 0;
		$metadata = [
			'code' => 200,
			'result' => []
		];

		for ($i = 7; $i <= $highestRow; $i++) {
			// for($i = 1;$i<=20;$i+=1){
			// echo 'Halaman '. $i.'<br>';
			$satuan = $spreadsheet->getActiveSheet()->getCell("D$i")->getValue();
			$satuan_ppn = $spreadsheet->getActiveSheet()->getCell("H$i")->getValue();
			$filter_gudang = $spreadsheet->getActiveSheet()->getCell("U$i")->getValue() == '' ? '0' : $spreadsheet->getActiveSheet()->getCell("U$i")->getValue();
			$filter_gudang_stok = $spreadsheet->getActiveSheet()->getCell("Q$i")->getCalculatedValue();
			$filter_gudang_harga = $spreadsheet->getActiveSheet()->getCell("H$i")->getCalculatedValue();
			$filter_gudang_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("T$i")->getValue());

			$id_obat = $this->ambil_id_obat(trim(str_replace("'", '', $spreadsheet->getActiveSheet()->getCell("C$i")->getValue())), $satuan);
			$nm_obat = $spreadsheet->getActiveSheet()->getCell("C$i")->getValue();

			$kolom = $spreadsheet->getActiveSheet()->getCell("A$i")->getValue();
			// var_dump($satuan);
			// var_dump($satuan_ppn);
			// var_dump($filter_gudang);
			// var_dump($filter_gudang_stok);
			// var_dump($filter_gudang_harga);
			// var_dump($filter_gudang_expired);
			// var_dump($id_obat);
			// var_dump($satuan);
			// die();
			if ($id_obat == '8510' || $filter_gudang_stok == '' || $filter_gudang_stok == NULL || $filter_gudang_stok == '-' || $filter_gudang_stok == ' ') {
				// $sheet = $spreadsheet->getSheet(1);
				// $sheet->setCellValue('A1','No.');
				// $sheet->setCellValue('B1','Nama Obat');
				// $sheet->setCellValue('A'.$countNull,$kolom);
				// $sheet->setCellValue('B'.$countNull,$nm_obat);
				// $countNull++;
			} else {
				// $sheet = $spreadsheet->getSheet(2);
				// $sheet->setCellValue('A1','id_obat');
				// $sheet->setCellValue('B1','id_gudang');
				// $sheet->setCellValue('C1','qty');
				// $sheet->setCellValue('D1','expire_date');
				// $sheet->setCellValue('E1','batch_no');
				// $sheet->setCellValue('F1','harga_jual');
				// $sheet->setCellValue('G1','harga_beli');
				// $sheet->setCellValue('H1','satuan');
				// $sheet->setCellValue('I1','deleted');
				// $sheet->setCellValue('J1','tgl_so');
				// $sheet->setCellValue('K1','Nama Obat');


				//  depo irna a : 114
				// - depo neurologi : 4
				// - depo irna b :8
				// - depo irna c : 5
				// - depo rawat jalan : 2
				// - produksi farmasi : 7

				// echo '<br>Irna a : '.$id_obat.' '.$filter_depo_irna_a;
				// $sheet->setCellValue('A'.$countOk,$id_obat);
				// $sheet->setCellValue('B'.$countOk,114);
				// $sheet->setCellValue('C'.$countOk,$filter_depo_irna_a_stok);
				// $sheet->setCellValue('D'.$countOk,$filter_depo_irna_a_expired);
				// $sheet->setCellValue('E'.$countOk,$filter_depo_irna_a);
				// $sheet->setCellValue('F'.$countOk,$filter_depo_irna_a_harga);
				// $sheet->setCellValue('G'.$countOk,'0');
				// $sheet->setCellValue('H'.$countOk,$satuan);
				// $sheet->setCellValue('I'.$countOk,'0');
				// $sheet->setCellValue('J'.$countOk,date('Y-m-d'));
				// $sheet->setCellValue('K'.$countOk,$nm_obat);
				$vs = [
					'id_obat' => $id_obat,
					'id_gudang' => 1,
					'qty' => $filter_gudang_stok,
					'expire_date' => $filter_gudang_expired == '',
					'batch_no' => "$filter_gudang",
					'hargajual' => $filter_gudang_harga,
					'hargabeli' => '0',
					'satuan' => $satuan,
					'deleted' => '0',
					'tgl_so' => date('Y-m-d')

				];

				$resultdb = $this->insert_gudang_inventory($vs);
				if ($resultdb) {
					$metadata['result'][$i] = 'OK';
				} else {
					$metadata['result'][$i] = json_encode($vs);
				}
				$countOk++;

				// var_dump($vs);




			}
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($metadata);
		// die();
		// $writer = new Xlsx($spreadsheet);
		// $writer->save(FCPATH.'hasil.xlsx');
		// die();
	}

	public function load_data_farmasi_3()
	{
		$this->load->database();
		// $this->db->update('gudang_inventory',['deleted'=>'1']);

		$inputFileType = 'Xlsx';
		//    $inputFileType = 'Xlsx';
		//    $inputFileType = 'Xml';
		//    $inputFileType = 'Ods';
		//    $inputFileType = 'Slk';
		//    $inputFileType = 'Gnumeric';
		//    $inputFileType = 'Csv';
		// $inputFileName = './sampleData/example1.xls';
		$inputFileName = FCPATH . 'stock_gudang_far.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$reader->setLoadSheetsOnly('ALK');
		$spreadsheet = $reader->load($inputFileName);

		// $spreadsheet->getSheet(1);
		// $cellValue = $spreadsheet->getActiveSheet()->getCell('C11')->getValue();
		$nb = 0;
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		// echo $cellValue;
		$depo_irna_a = [];
		$depo_neurologi = [];
		$depo_irna_b = [];
		$depo_irna_c = [];
		$depo_rawat_jalan = [];
		$produksi_farmasi = [];
		$countNull = 2;
		$countOk = 2;
		$resultBerhasil = 0;
		$resultGagal = 0;
		$metadata = [
			'code' => 200,
			'result' => []
		];

		for ($i = 7; $i <= $highestRow; $i++) {
			// for($i = 1;$i<=20;$i+=1){
			// echo 'Halaman '. $i.'<br>';
			$satuan = $spreadsheet->getActiveSheet()->getCell("D$i")->getValue();
			$satuan_ppn = $spreadsheet->getActiveSheet()->getCell("H$i")->getValue();
			$filter_gudang = $spreadsheet->getActiveSheet()->getCell("U$i")->getValue() == '' ? '0' : $spreadsheet->getActiveSheet()->getCell("U$i")->getValue();
			$filter_gudang_stok = $spreadsheet->getActiveSheet()->getCell("Q$i")->getCalculatedValue();
			$filter_gudang_harga = $spreadsheet->getActiveSheet()->getCell("H$i")->getCalculatedValue();
			$filter_gudang_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("T$i")->getValue());

			$id_obat = $this->ambil_id_obat(trim(str_replace("'", '', $spreadsheet->getActiveSheet()->getCell("C$i")->getValue())), $satuan);
			$nm_obat = $spreadsheet->getActiveSheet()->getCell("C$i")->getValue();

			$kolom = $spreadsheet->getActiveSheet()->getCell("A$i")->getValue();
			// var_dump($satuan);
			// var_dump($satuan_ppn);
			// var_dump($filter_gudang);
			// var_dump($filter_gudang_stok);
			// var_dump($filter_gudang_harga);
			// var_dump($filter_gudang_expired);
			// var_dump($id_obat);
			// var_dump($nm_obat);
			// die();
			if ($filter_gudang_stok == '' || $filter_gudang_stok == NULL || $filter_gudang_stok == '-' || $filter_gudang_stok == ' ') {
				// $sheet = $spreadsheet->getSheet(1);
				// $sheet->setCellValue('A1','No.');
				// $sheet->setCellValue('B1','Nama Obat');
				// $sheet->setCellValue('A'.$countNull,$kolom);
				// $sheet->setCellValue('B'.$countNull,$nm_obat);
				// $countNull++;
			} else {
				// $sheet = $spreadsheet->getSheet(2);
				// $sheet->setCellValue('A1','id_obat');
				// $sheet->setCellValue('B1','id_gudang');
				// $sheet->setCellValue('C1','qty');
				// $sheet->setCellValue('D1','expire_date');
				// $sheet->setCellValue('E1','batch_no');
				// $sheet->setCellValue('F1','harga_jual');
				// $sheet->setCellValue('G1','harga_beli');
				// $sheet->setCellValue('H1','satuan');
				// $sheet->setCellValue('I1','deleted');
				// $sheet->setCellValue('J1','tgl_so');
				// $sheet->setCellValue('K1','Nama Obat');


				//  depo irna a : 114
				// - depo neurologi : 4
				// - depo irna b :8
				// - depo irna c : 5
				// - depo rawat jalan : 2
				// - produksi farmasi : 7

				// echo '<br>Irna a : '.$id_obat.' '.$filter_depo_irna_a;
				// $sheet->setCellValue('A'.$countOk,$id_obat);
				// $sheet->setCellValue('B'.$countOk,114);
				// $sheet->setCellValue('C'.$countOk,$filter_depo_irna_a_stok);
				// $sheet->setCellValue('D'.$countOk,$filter_depo_irna_a_expired);
				// $sheet->setCellValue('E'.$countOk,$filter_depo_irna_a);
				// $sheet->setCellValue('F'.$countOk,$filter_depo_irna_a_harga);
				// $sheet->setCellValue('G'.$countOk,'0');
				// $sheet->setCellValue('H'.$countOk,$satuan);
				// $sheet->setCellValue('I'.$countOk,'0');
				// $sheet->setCellValue('J'.$countOk,date('Y-m-d'));
				// $sheet->setCellValue('K'.$countOk,$nm_obat);
				$vs = [
					'id_obat' => $id_obat,
					'id_gudang' => 1,
					'qty' => $filter_gudang_stok,
					'expire_date' => $filter_gudang_expired == '',
					'batch_no' => "$filter_gudang",
					'hargajual' => $filter_gudang_harga,
					'hargabeli' => '0',
					'satuan' => $satuan,
					'deleted' => '0',
					'tgl_so' => date('Y-m-d')

				];

				$resultdb = $this->insert_gudang_inventory($vs);
				if ($resultdb) {
					$metadata['result'][$i] = 'OK';
				} else {
					$metadata['result'][$i] = json_encode($vs);
				}
				$countOk++;

				// var_dump($vs);




			}
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($metadata);
		// die();
		// $writer = new Xlsx($spreadsheet);
		// $writer->save(FCPATH.'hasil.xlsx');
		// die();
	}

	public function load_data_farmasi_4()
	{
		$this->load->database();
		// $this->db->update('gudang_inventory',['deleted'=>'1']);

		$inputFileType = 'Xlsx';
		//    $inputFileType = 'Xlsx';
		//    $inputFileType = 'Xml';
		//    $inputFileType = 'Ods';
		//    $inputFileType = 'Slk';
		//    $inputFileType = 'Gnumeric';
		//    $inputFileType = 'Csv';
		// $inputFileName = './sampleData/example1.xls';
		$inputFileName = FCPATH . 'stock_gudang_far.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$reader->setLoadSheetsOnly('OBAT');
		$spreadsheet = $reader->load($inputFileName);

		// $spreadsheet->getSheet(1);
		// $cellValue = $spreadsheet->getActiveSheet()->getCell('C11')->getValue();
		$nb = 0;
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		// echo $cellValue;
		$depo_irna_a = [];
		$depo_neurologi = [];
		$depo_irna_b = [];
		$depo_irna_c = [];
		$depo_rawat_jalan = [];
		$produksi_farmasi = [];
		$countNull = 2;
		$countOk = 2;
		$resultBerhasil = 0;
		$resultGagal = 0;
		$metadata = [
			'code' => 200,
			'result' => []
		];

		for ($i = 7; $i <= $highestRow; $i++) {
			// for($i = 1;$i<=20;$i+=1){
			// echo 'Halaman '. $i.'<br>';
			$satuan = $spreadsheet->getActiveSheet()->getCell("C$i")->getValue();
			$satuan_ppn = $spreadsheet->getActiveSheet()->getCell("G$i")->getValue();
			$filter_gudang = $spreadsheet->getActiveSheet()->getCell("T$i")->getValue() == '' ? '0' : $spreadsheet->getActiveSheet()->getCell("T$i")->getValue();
			$filter_gudang_stok = $spreadsheet->getActiveSheet()->getCell("P$i")->getCalculatedValue();
			$filter_gudang_harga = $spreadsheet->getActiveSheet()->getCell("G$i")->getCalculatedValue();
			$filter_gudang_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("S$i")->getValue());

			$id_obat = $this->ambil_id_obat(trim(str_replace("'", '', $spreadsheet->getActiveSheet()->getCell("B$i")->getValue())), $satuan);
			$nm_obat = $spreadsheet->getActiveSheet()->getCell("B$i")->getValue();

			$kolom = $spreadsheet->getActiveSheet()->getCell("A$i")->getValue();
			// var_dump($satuan);
			// var_dump($satuan_ppn);
			// var_dump($filter_gudang);
			// var_dump($filter_gudang_stok);
			// var_dump($filter_gudang_harga);
			// var_dump($filter_gudang_expired);
			// var_dump($id_obat);
			// var_dump($nm_obat);
			// die();
			if ($filter_gudang_stok == '' || $filter_gudang_stok == NULL || $filter_gudang_stok == '-' || $filter_gudang_stok == ' ') {
				// $sheet = $spreadsheet->getSheet(1);
				// $sheet->setCellValue('A1','No.');
				// $sheet->setCellValue('B1','Nama Obat');
				// $sheet->setCellValue('A'.$countNull,$kolom);
				// $sheet->setCellValue('B'.$countNull,$nm_obat);
				// $countNull++;
			} else {
				// $sheet = $spreadsheet->getSheet(2);
				// $sheet->setCellValue('A1','id_obat');
				// $sheet->setCellValue('B1','id_gudang');
				// $sheet->setCellValue('C1','qty');
				// $sheet->setCellValue('D1','expire_date');
				// $sheet->setCellValue('E1','batch_no');
				// $sheet->setCellValue('F1','harga_jual');
				// $sheet->setCellValue('G1','harga_beli');
				// $sheet->setCellValue('H1','satuan');
				// $sheet->setCellValue('I1','deleted');
				// $sheet->setCellValue('J1','tgl_so');
				// $sheet->setCellValue('K1','Nama Obat');


				//  depo irna a : 114
				// - depo neurologi : 4
				// - depo irna b :8
				// - depo irna c : 5
				// - depo rawat jalan : 2
				// - produksi farmasi : 7

				// echo '<br>Irna a : '.$id_obat.' '.$filter_depo_irna_a;
				// $sheet->setCellValue('A'.$countOk,$id_obat);
				// $sheet->setCellValue('B'.$countOk,114);
				// $sheet->setCellValue('C'.$countOk,$filter_depo_irna_a_stok);
				// $sheet->setCellValue('D'.$countOk,$filter_depo_irna_a_expired);
				// $sheet->setCellValue('E'.$countOk,$filter_depo_irna_a);
				// $sheet->setCellValue('F'.$countOk,$filter_depo_irna_a_harga);
				// $sheet->setCellValue('G'.$countOk,'0');
				// $sheet->setCellValue('H'.$countOk,$satuan);
				// $sheet->setCellValue('I'.$countOk,'0');
				// $sheet->setCellValue('J'.$countOk,date('Y-m-d'));
				// $sheet->setCellValue('K'.$countOk,$nm_obat);
				$vs = [
					'id_obat' => $id_obat,
					'id_gudang' => 1,
					'qty' => $filter_gudang_stok,
					'expire_date' => $filter_gudang_expired == '',
					'batch_no' => "$filter_gudang",
					'hargajual' => $filter_gudang_harga,
					'hargabeli' => '0',
					'satuan' => $satuan,
					'deleted' => '0',
					'tgl_so' => date('Y-m-d')

				];

				$resultdb = $this->insert_gudang_inventory($vs);
				if ($resultdb) {
					$metadata['result'][$i] = 'OK';
				} else {
					$metadata['result'][$i] = json_encode($vs);
				}
				$countOk++;

				// var_dump($vs);




			}
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($metadata);
		// die();
		// $writer = new Xlsx($spreadsheet);
		// $writer->save(FCPATH.'hasil.xlsx');
		// die();
	}

	public function load_data_farmasi_5()
	{
		$this->load->database();
		// $this->db->update('gudang_inventory',['deleted'=>'1']);

		$inputFileType = 'Xlsx';
		//    $inputFileType = 'Xlsx';
		//    $inputFileType = 'Xml';
		//    $inputFileType = 'Ods';
		//    $inputFileType = 'Slk';
		//    $inputFileType = 'Gnumeric';
		//    $inputFileType = 'Csv';
		// $inputFileName = './sampleData/example1.xls';
		$inputFileName = FCPATH . 'stock_gudang_far.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$reader->setLoadSheetsOnly('ALMED');
		$spreadsheet = $reader->load($inputFileName);

		// $spreadsheet->getSheet(1);
		// $cellValue = $spreadsheet->getActiveSheet()->getCell('C11')->getValue();
		$nb = 0;
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		// echo $cellValue;
		$depo_irna_a = [];
		$depo_neurologi = [];
		$depo_irna_b = [];
		$depo_irna_c = [];
		$depo_rawat_jalan = [];
		$produksi_farmasi = [];
		$countNull = 2;
		$countOk = 2;
		$resultBerhasil = 0;
		$resultGagal = 0;
		$metadata = [
			'code' => 200,
			'result' => []
		];

		for ($i = 7; $i <= $highestRow; $i++) {
			// for($i = 1;$i<=20;$i+=1){
			// echo 'Halaman '. $i.'<br>';
			$satuan = $spreadsheet->getActiveSheet()->getCell("C$i")->getValue();
			$satuan_ppn = $spreadsheet->getActiveSheet()->getCell("G$i")->getValue();
			$filter_gudang = $spreadsheet->getActiveSheet()->getCell("Q$i")->getValue() == '' ? '0' : $spreadsheet->getActiveSheet()->getCell("Q$i")->getValue();
			$filter_gudang_stok = $spreadsheet->getActiveSheet()->getCell("M$i")->getCalculatedValue();
			$filter_gudang_harga = $spreadsheet->getActiveSheet()->getCell("G$i")->getCalculatedValue();
			// $filter_gudang_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("S$i")->getValue());

			$id_obat = $this->ambil_id_obat(trim(str_replace("'", '', $spreadsheet->getActiveSheet()->getCell("B$i")->getValue())), $satuan);
			$nm_obat = $spreadsheet->getActiveSheet()->getCell("B$i")->getValue();

			$kolom = $spreadsheet->getActiveSheet()->getCell("A$i")->getValue();
			// var_dump($satuan);
			// var_dump($satuan_ppn);
			// var_dump($filter_gudang);
			// var_dump($filter_gudang_stok);
			// var_dump($filter_gudang_harga);
			// // var_dump($filter_gudang_expired);
			// var_dump($id_obat);
			// var_dump($nm_obat);
			// die();
			if ($filter_gudang_stok == '' || $filter_gudang_stok == NULL || $filter_gudang_stok == '-' || $filter_gudang_stok == ' ') {
				// $sheet = $spreadsheet->getSheet(1);
				// $sheet->setCellValue('A1','No.');
				// $sheet->setCellValue('B1','Nama Obat');
				// $sheet->setCellValue('A'.$countNull,$kolom);
				// $sheet->setCellValue('B'.$countNull,$nm_obat);
				// $countNull++;
			} else {
				// $sheet = $spreadsheet->getSheet(2);
				// $sheet->setCellValue('A1','id_obat');
				// $sheet->setCellValue('B1','id_gudang');
				// $sheet->setCellValue('C1','qty');
				// $sheet->setCellValue('D1','expire_date');
				// $sheet->setCellValue('E1','batch_no');
				// $sheet->setCellValue('F1','harga_jual');
				// $sheet->setCellValue('G1','harga_beli');
				// $sheet->setCellValue('H1','satuan');
				// $sheet->setCellValue('I1','deleted');
				// $sheet->setCellValue('J1','tgl_so');
				// $sheet->setCellValue('K1','Nama Obat');


				//  depo irna a : 114
				// - depo neurologi : 4
				// - depo irna b :8
				// - depo irna c : 5
				// - depo rawat jalan : 2
				// - produksi farmasi : 7

				// echo '<br>Irna a : '.$id_obat.' '.$filter_depo_irna_a;
				// $sheet->setCellValue('A'.$countOk,$id_obat);
				// $sheet->setCellValue('B'.$countOk,114);
				// $sheet->setCellValue('C'.$countOk,$filter_depo_irna_a_stok);
				// $sheet->setCellValue('D'.$countOk,$filter_depo_irna_a_expired);
				// $sheet->setCellValue('E'.$countOk,$filter_depo_irna_a);
				// $sheet->setCellValue('F'.$countOk,$filter_depo_irna_a_harga);
				// $sheet->setCellValue('G'.$countOk,'0');
				// $sheet->setCellValue('H'.$countOk,$satuan);
				// $sheet->setCellValue('I'.$countOk,'0');
				// $sheet->setCellValue('J'.$countOk,date('Y-m-d'));
				// $sheet->setCellValue('K'.$countOk,$nm_obat);
				$vs = [
					'id_obat' => $id_obat,
					'id_gudang' => 1,
					'qty' => $filter_gudang_stok,
					// 'expire_date'=>$filter_gudang_expired == '',
					'batch_no' => "$filter_gudang",
					'hargajual' => $filter_gudang_harga,
					'hargabeli' => '0',
					'satuan' => $satuan,
					'deleted' => '0',
					'tgl_so' => date('Y-m-d')

				];

				$resultdb = $this->insert_gudang_inventory($vs);
				if ($resultdb) {
					$metadata['result'][$i] = 'OK';
				} else {
					$metadata['result'][$i] = json_encode($vs);
				}
				$countOk++;

				// var_dump($vs);




			}
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($metadata);
		// die();
		// $writer = new Xlsx($spreadsheet);
		// $writer->save(FCPATH.'hasil.xlsx');
		// die();
	}

	public function load_data_farmasi_6()
	{
		$this->load->database();
		// $this->db->update('gudang_inventory',['deleted'=>'1']);

		$inputFileType = 'Xlsx';
		//    $inputFileType = 'Xlsx';
		//    $inputFileType = 'Xml';
		//    $inputFileType = 'Ods';
		//    $inputFileType = 'Slk';
		//    $inputFileType = 'Gnumeric';
		//    $inputFileType = 'Csv';
		// $inputFileName = './sampleData/example1.xls';
		$inputFileName = FCPATH . 'stock_gudang_far.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$reader->setLoadSheetsOnly('KED');
		$spreadsheet = $reader->load($inputFileName);

		// $spreadsheet->getSheet(1);
		// $cellValue = $spreadsheet->getActiveSheet()->getCell('C11')->getValue();
		$nb = 0;
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		// echo $cellValue;
		$depo_irna_a = [];
		$depo_neurologi = [];
		$depo_irna_b = [];
		$depo_irna_c = [];
		$depo_rawat_jalan = [];
		$produksi_farmasi = [];
		$countNull = 2;
		$countOk = 2;
		$resultBerhasil = 0;
		$resultGagal = 0;
		$metadata = [
			'code' => 200,
			'result' => []
		];

		for ($i = 7; $i <= $highestRow; $i++) {
			// for($i = 1;$i<=20;$i+=1){
			// echo 'Halaman '. $i.'<br>';
			$satuan = $spreadsheet->getActiveSheet()->getCell("C$i")->getValue();
			$satuan_ppn = $spreadsheet->getActiveSheet()->getCell("G$i")->getValue();
			$filter_gudang = $spreadsheet->getActiveSheet()->getCell("Q$i")->getValue() == '' ? '0' : $spreadsheet->getActiveSheet()->getCell("Q$i")->getValue();
			$filter_gudang_stok = $spreadsheet->getActiveSheet()->getCell("M$i")->getCalculatedValue();
			$filter_gudang_harga = $spreadsheet->getActiveSheet()->getCell("G$i")->getCalculatedValue();
			// $filter_gudang_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("S$i")->getValue());

			$id_obat = $this->ambil_id_obat(trim(str_replace("'", '', $spreadsheet->getActiveSheet()->getCell("B$i")->getValue())), $satuan);
			$nm_obat = $spreadsheet->getActiveSheet()->getCell("B$i")->getValue();

			$kolom = $spreadsheet->getActiveSheet()->getCell("A$i")->getValue();
			// var_dump($satuan);
			// var_dump($satuan_ppn);
			// var_dump($filter_gudang);
			// var_dump($filter_gudang_stok);
			// var_dump($filter_gudang_harga);
			// // var_dump($filter_gudang_expired);
			// var_dump($id_obat);
			// var_dump($nm_obat);
			// die();
			if ($filter_gudang_stok == '' || $filter_gudang_stok == NULL || $filter_gudang_stok == '-' || $filter_gudang_stok == ' ') {
				// $sheet = $spreadsheet->getSheet(1);
				// $sheet->setCellValue('A1','No.');
				// $sheet->setCellValue('B1','Nama Obat');
				// $sheet->setCellValue('A'.$countNull,$kolom);
				// $sheet->setCellValue('B'.$countNull,$nm_obat);
				// $countNull++;
			} else {
				// $sheet = $spreadsheet->getSheet(2);
				// $sheet->setCellValue('A1','id_obat');
				// $sheet->setCellValue('B1','id_gudang');
				// $sheet->setCellValue('C1','qty');
				// $sheet->setCellValue('D1','expire_date');
				// $sheet->setCellValue('E1','batch_no');
				// $sheet->setCellValue('F1','harga_jual');
				// $sheet->setCellValue('G1','harga_beli');
				// $sheet->setCellValue('H1','satuan');
				// $sheet->setCellValue('I1','deleted');
				// $sheet->setCellValue('J1','tgl_so');
				// $sheet->setCellValue('K1','Nama Obat');


				//  depo irna a : 114
				// - depo neurologi : 4
				// - depo irna b :8
				// - depo irna c : 5
				// - depo rawat jalan : 2
				// - produksi farmasi : 7

				// echo '<br>Irna a : '.$id_obat.' '.$filter_depo_irna_a;
				// $sheet->setCellValue('A'.$countOk,$id_obat);
				// $sheet->setCellValue('B'.$countOk,114);
				// $sheet->setCellValue('C'.$countOk,$filter_depo_irna_a_stok);
				// $sheet->setCellValue('D'.$countOk,$filter_depo_irna_a_expired);
				// $sheet->setCellValue('E'.$countOk,$filter_depo_irna_a);
				// $sheet->setCellValue('F'.$countOk,$filter_depo_irna_a_harga);
				// $sheet->setCellValue('G'.$countOk,'0');
				// $sheet->setCellValue('H'.$countOk,$satuan);
				// $sheet->setCellValue('I'.$countOk,'0');
				// $sheet->setCellValue('J'.$countOk,date('Y-m-d'));
				// $sheet->setCellValue('K'.$countOk,$nm_obat);
				$vs = [
					'id_obat' => $id_obat,
					'id_gudang' => 1,
					'qty' => $filter_gudang_stok,
					// 'expire_date'=>$filter_gudang_expired == '',
					'batch_no' => "$filter_gudang",
					'hargajual' => $filter_gudang_harga,
					'hargabeli' => '0',
					'satuan' => $satuan,
					'deleted' => '0',
					'tgl_so' => date('Y-m-d')

				];

				$resultdb = $this->insert_gudang_inventory($vs);
				if ($resultdb) {
					$metadata['result'][$i] = 'OK';
				} else {
					$metadata['result'][$i] = json_encode($vs);
				}
				$countOk++;

				// var_dump($vs);




			}
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($metadata);
		// die();
		// $writer = new Xlsx($spreadsheet);
		// $writer->save(FCPATH.'hasil.xlsx');
		// die();
	}

	public function load_data_farmasi_7()
	{
		$this->load->database();
		// $this->db->update('gudang_inventory',['deleted'=>'1']);

		$inputFileType = 'Xlsx';
		//    $inputFileType = 'Xlsx';
		//    $inputFileType = 'Xml';
		//    $inputFileType = 'Ods';
		//    $inputFileType = 'Slk';
		//    $inputFileType = 'Gnumeric';
		//    $inputFileType = 'Csv';
		// $inputFileName = './sampleData/example1.xls';
		$inputFileName = FCPATH . 'stock_gudang_far.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$reader->setLoadSheetsOnly('HIBAH');
		$spreadsheet = $reader->load($inputFileName);

		// $spreadsheet->getSheet(1);
		// $cellValue = $spreadsheet->getActiveSheet()->getCell('C11')->getValue();
		$nb = 0;
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		// echo $cellValue;
		$depo_irna_a = [];
		$depo_neurologi = [];
		$depo_irna_b = [];
		$depo_irna_c = [];
		$depo_rawat_jalan = [];
		$produksi_farmasi = [];
		$countNull = 2;
		$countOk = 2;
		$resultBerhasil = 0;
		$resultGagal = 0;
		$metadata = [
			'code' => 200,
			'result' => []
		];

		for ($i = 7; $i <= 33; $i++) {
			// for($i = 1;$i<=20;$i+=1){
			// echo 'Halaman '. $i.'<br>';
			$satuan = $spreadsheet->getActiveSheet()->getCell("C$i")->getValue();
			$satuan_ppn = $spreadsheet->getActiveSheet()->getCell("Y$i")->getValue() == '' ? '0' : $spreadsheet->getActiveSheet()->getCell("Y$i")->getValue();
			$filter_gudang = $spreadsheet->getActiveSheet()->getCell("Z$i")->getValue() == '' ? '0' : $spreadsheet->getActiveSheet()->getCell("Z$i")->getValue();
			$filter_gudang_stok = $spreadsheet->getActiveSheet()->getCell("V$i")->getCalculatedValue();
			$filter_gudang_harga = $spreadsheet->getActiveSheet()->getCell("Y$i")->getValue() == '' ? '0' : $spreadsheet->getActiveSheet()->getCell("Y$i")->getValue();
			// $filter_gudang_expired = $this->convertTimestamp($spreadsheet->getActiveSheet()->getCell("S$i")->getValue());

			$id_obat = $this->ambil_id_obat(trim(str_replace("'", '', $spreadsheet->getActiveSheet()->getCell("B$i")->getValue())), $satuan);
			$nm_obat = $spreadsheet->getActiveSheet()->getCell("B$i")->getValue();

			$kolom = $spreadsheet->getActiveSheet()->getCell("A$i")->getValue();
			// var_dump($satuan);
			// var_dump($satuan_ppn);
			// var_dump($filter_gudang);
			// var_dump($filter_gudang_stok);
			// var_dump($filter_gudang_harga);
			// // var_dump($filter_gudang_expired);
			// var_dump($id_obat);
			// var_dump($nm_obat);
			// die();
			if ($filter_gudang_stok == '' || $filter_gudang_stok == NULL || $filter_gudang_stok == '-' || $filter_gudang_stok == ' ') {
				// $sheet = $spreadsheet->getSheet(1);
				// $sheet->setCellValue('A1','No.');
				// $sheet->setCellValue('B1','Nama Obat');
				// $sheet->setCellValue('A'.$countNull,$kolom);
				// $sheet->setCellValue('B'.$countNull,$nm_obat);
				// $countNull++;
			} else {
				// $sheet = $spreadsheet->getSheet(2);
				// $sheet->setCellValue('A1','id_obat');
				// $sheet->setCellValue('B1','id_gudang');
				// $sheet->setCellValue('C1','qty');
				// $sheet->setCellValue('D1','expire_date');
				// $sheet->setCellValue('E1','batch_no');
				// $sheet->setCellValue('F1','harga_jual');
				// $sheet->setCellValue('G1','harga_beli');
				// $sheet->setCellValue('H1','satuan');
				// $sheet->setCellValue('I1','deleted');
				// $sheet->setCellValue('J1','tgl_so');
				// $sheet->setCellValue('K1','Nama Obat');


				//  depo irna a : 114
				// - depo neurologi : 4
				// - depo irna b :8
				// - depo irna c : 5
				// - depo rawat jalan : 2
				// - produksi farmasi : 7

				// echo '<br>Irna a : '.$id_obat.' '.$filter_depo_irna_a;
				// $sheet->setCellValue('A'.$countOk,$id_obat);
				// $sheet->setCellValue('B'.$countOk,114);
				// $sheet->setCellValue('C'.$countOk,$filter_depo_irna_a_stok);
				// $sheet->setCellValue('D'.$countOk,$filter_depo_irna_a_expired);
				// $sheet->setCellValue('E'.$countOk,$filter_depo_irna_a);
				// $sheet->setCellValue('F'.$countOk,$filter_depo_irna_a_harga);
				// $sheet->setCellValue('G'.$countOk,'0');
				// $sheet->setCellValue('H'.$countOk,$satuan);
				// $sheet->setCellValue('I'.$countOk,'0');
				// $sheet->setCellValue('J'.$countOk,date('Y-m-d'));
				// $sheet->setCellValue('K'.$countOk,$nm_obat);
				$vs = [
					'id_obat' => $id_obat,
					'id_gudang' => 1,
					'qty' => $filter_gudang_stok,
					// 'expire_date'=>$filter_gudang_expired == '',
					'batch_no' => "$filter_gudang",
					'hargajual' => $filter_gudang_harga,
					'hargabeli' => '0',
					'satuan' => $satuan,
					'deleted' => '0',
					'tgl_so' => date('Y-m-d')

				];

				// echo '<pre>';
				// 	var_dump($vs);
				// echo '</pre>';

				$resultdb = $this->insert_gudang_inventory($vs);
				if ($resultdb) {
					$metadata['result'][$i] = 'OK';
				} else {
					$metadata['result'][$i] = json_encode($vs);
				}
				$countOk++;

				// var_dump($vs);




			}
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($metadata);
		// die();
		// $writer = new Xlsx($spreadsheet);
		// $writer->save(FCPATH.'hasil.xlsx');
		// die();
	}

	public function master_obat_bmhp()
	{
		echo json_encode($this->M_user->get_nm_obat_bmhp()->result_array());
	}

	// function decryptData($data)
	// {
	// 	$privateKey     = '@RSOMH12903123BUKITTINGGI2023)!^%@!*$('; // user define key
	// 	$secretKey      = '1b2532b238123b129'; // user define secret key
	// 	$encryptMethod  = "AES-256-CBC";
	// 	$stringEncrypt  = $data; // user encrypt value
	// 	$key    = hash('sha256',
	// 		$privateKey
	// 	);
	// 	$ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
	// 	$output = openssl_decrypt(base64_decode($stringEncrypt), $encryptMethod, $key, 0, $ivalue);
	// 	echo $output;
	// 	// output is a decripted value
	// }

	public function dokter_konsul()
	{
		echo json_encode($this->M_user->get_all_dokter_konsul()->result_array());
	}
	public function users()
	{
		echo json_encode($this->M_user->get_user()->result_array());
	}
}
