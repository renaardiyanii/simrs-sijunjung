<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mckategori extends Secure_area {
    public function __construct(){
		parent::__construct();

		$this->load->model('master/mmkategori','',TRUE);
	}

    public function index() {
        $data['title'] = 'Master Kategori Tindakan';
        $data['kategori'] = $this->mmkategori->get_all_kategori()->result();
        $this->load->view('master/mvkategori_tindakan', $data);
    }

    public function delete_kategori() {
        $id = $this->input->post('delete_id');
		$this->mmkategori->delete_kategori($id);
		
		// redirect('master/Mckategori');
    }

    public function get_data_edit_kategori() {
        $id = $this->input->post('id');
        $datajson = $this->mmkategori->get_data_edit_kategori($id)->row();
	    echo json_encode($datajson);
    }

    public function update_kategori() {
        $id = $this->input->post('edit_id_kategori_hidden');

		$data['kategori'] = $this->input->post('edit_nama_kategori');

		$this->mmkategori->update_kategori($id, $data);

		// redirect('master/mckategori');
    }

    public function insert_kategori() {
        $data['kategori'] = $this->input->post('nama_kategori');
        $this->mmkategori->insert_kategori($data);
    }
}