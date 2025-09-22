<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cuploadtindakan extends Secure_area {
    public function __construct(){
		parent::__construct();
		
		$this->load->model("tarif/muploadtindakan");
		
		// $this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}

    public function index(){
		$data['title'] = 'Laporan Txt BPJS';
    
    }

    public function upload_tarif_tindakan() {
		$data['title'] = 'Upload Tarif Tindakan';
		// $date1 = $this->input->post('date_picker_months1');
		// $date2 = $this->input->post('date_picker_months2');

		// // if($date1 == '' || $date2 == '') {
		// // 	$tgl1 = date("Y-m-d");
		// // 	$tgl2 = date("Y-m-d");
		// // 	$data['list_umbal'] = $this->muploadtindakan->get_pasien_input_realisasi_tindakan($tgl1, $tgl2)->result();
		// // } else {
		// 	$data['list_umbal'] = $this->muploadtindakan->get_pasien_input_realisasi_tindakan($date1, $date2)->result();
		// //}
		$this->load->view('tarif/view_upload_tindakan', $data);
	}

	public function upload_jenis_tindakan() {
		$data['title'] = 'Upload Jenis Tindakan';
		// $date1 = $this->input->post('date_picker_months1');
		// $date2 = $this->input->post('date_picker_months2');

		// // if($date1 == '' || $date2 == '') {
		// // 	$tgl1 = date("Y-m-d");
		// // 	$tgl2 = date("Y-m-d");
		// // 	$data['list_umbal'] = $this->muploadtindakan->get_pasien_input_realisasi_tindakan($tgl1, $tgl2)->result();
		// // } else {
		// 	$data['list_umbal'] = $this->muploadtindakan->get_pasien_input_realisasi_tindakan($date1, $date2)->result();
		// //}
		$this->load->view('tarif/view_upload_jenis_tindakan', $data);
	}

	public function upload_tarif_tindakan_excel_file(){
		// $this->load->helper('file');
		// $files = $_FILES;
		// printf(isset($_FILES['file']['name']));
		// print_r($_FILES["file"]);
		// exit();
        /* Allowed MIME(s) File */
        $file_mimes = array(
            'application/octet-stream', 
            'application/vnd.ms-excel', 
            'application/x-csv', 
            'text/x-csv', 
            'text/csv', 
            'application/csv', 
            'application/excel', 
            'application/vnd.msexcel', 
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        // print_r($_FILES['jenisTindakanFile']['name']);
        // exit();
        // if(isset($_FILES['jenisTindakanFile']['name']) && in_array($_FILES['jenisTindakanFile']['type'], $file_mimes)) {
        //     $array_file = explode('.', $_FILES['jenisTindakanFile']['name']);
        //     $extension  = end($array_file);

        //     if('csv' == $extension) {
        //         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        //     } else {
        //         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        //     }

        //     $spreadsheet = $reader->load($_FILES['jenisTindakanFile']['tmp_name']);
        //     $sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
        //     $array_data  = [];
		// 	$array_data_jenis_tindakan = [];
        //     // print_r($sheet_data);
        //     // exit();
        //     for($i = 1; $i < count($sheet_data); $i++) {
        //         $jenisTindakan["idtindakan"] = $sheet_data[$i]["1"];
        //         $jenisTindakan["nmtindakan"] = $sheet_data[$i]["2"];
        //         $jenisTindakan["kel_tindakan"] = $sheet_data[$i]["4"];
        //         $jenisTindakan["kategori"] = $sheet_data[$i]["6"];
        //         $jenisTindakan["sub_kelompok"] = $sheet_data[$i]["5"];
        //         // $jenisTindakan["satuan"] = $sheet_data[$i]["7"];
        //         $array_data[] = $jenisTindakan;
        //     }

        //     if ($array_data != []) {
        //         $this->muploadtindakan->remove_jenis_tindakan_upload();
        //         if($this->muploadtindakan->insert_jenis_tindakan_upload($array_data) > 0){
		// 			$successJenisTindakan = 	'<div class="alert alert-success">
        //                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //                     <h4 class="text"><i class="fa fa-check-circle"></i> Jenis tindakan baru berhasil di simpan!</h4>
        //                 </div>';
		// 			$this->session->set_flashdata('success_msg_jenistindakan', $successJenisTindakan);
		// 		}
        //     }

        // }
        if(isset($_FILES['tarifTindakanFile']['name']) && in_array($_FILES['tarifTindakanFile']['type'], $file_mimes)) {
			// printf("a");
			// printf($_FILES['file']['name']);
			// echo "'".$_FILES['file']['name']"'";
            $array_file = explode('.', $_FILES['tarifTindakanFile']['name']);
            $extension  = end($array_file);

            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['tarifTindakanFile']['tmp_name']);
            $sheet_data  = $spreadsheet->getSheet(0)->toArray();
			$sheet_data_tarif  = $spreadsheet->getSheet(1)->toArray();
            $array_data  = [];
			$array_data_jenis_tindakan = [];
			// print_r($sheet_data_tarif);
			// exit();
            for($i = 1; $i < count($sheet_data); $i++) {
				$jenisTindakan["id"] = $sheet_data[$i]['0'];
				$jenisTindakan["idtindakan"] = $sheet_data[$i]['1'];
				$jenisTindakan["nmtindakan"] = $sheet_data[$i]['2'];
				$jenisTindakan["idpok1"] = $sheet_data[$i]['3'];
				$jenisTindakan["idpok2"] = $sheet_data[$i]['4'];
				$jenisTindakan["idkel_tind"] = $sheet_data[$i]['5'];
				$jenisTindakan["idkel_inacbg"] = $sheet_data[$i]['6'];
				$jenisTindakan["lis"] = $sheet_data[$i]['7'];
				$jenisTindakan["prosedur"] = $sheet_data[$i]['8'];
				$jenisTindakan["deleted"] = $sheet_data[$i]['9'];
				$jenisTindakan["kategori"] = $sheet_data[$i]['10'];
				$jenisTindakan["kel_tindakan"] = $sheet_data[$i]['11'];
				$jenisTindakan["sub_kelompok"] = $sheet_data[$i]['12'];
				$jenisTindakan["modality"] = $sheet_data[$i]['13'];
				$jenisTindakan["satuan"] = $sheet_data[$i]['14'];
				$jenisTindakan["id_kategori"] = $sheet_data[$i]['15'];
				$jenisTindakan["id_sub_kelompok"] = $sheet_data[$i]['16'];
				$jenisTindakan["id_satuan"] = $sheet_data[$i]['17'];
				$jenisTindakan["id_kel"] = $sheet_data[$i]['18'];
				// $jenisTindakan["jasa_rs"] = (int)str_replace(",","",$sheet_data[$i]['4']);
				// $jenisTindakan["tarif_iks"] = (int)str_replace(",","",$sheet_data[$i]['5']);
				// $jenisTindakan["tarif_bpjs"] = (int)str_replace(",","",$sheet_data[$i]['6']);
                $array_data_jenis_tindakan[] = $jenisTindakan;
            }

			for($i = 1; $i < count($sheet_data_tarif); $i++) {
				// $tarifTindakan["id_tarif_tindakan"] = $sheet_data_tarif[$i]['0'];
				$tarifTindakan["id_tindakan"] = $sheet_data_tarif[$i]['1'];
				$tarifTindakan["kelas"] = $sheet_data_tarif[$i]['2'];
				$tarifTindakan["jasa_rs"] = (int) $sheet_data_tarif[$i]['3'];
				$tarifTindakan["total_tarif"] = (int) $sheet_data_tarif[$i]['4'];
				$tarifTindakan["idrg"] = $sheet_data_tarif[$i]['5'];
				$tarifTindakan["tarif_iks"] = (int) $sheet_data_tarif[$i]['6'];
				$tarifTindakan["tarif_bpjs"] = (int) $sheet_data_tarif[$i]['7'];

				$array_data[] = $tarifTindakan;
			}
            if($array_data != '' && $array_data_jenis_tindakan != '') {
				$this->muploadtindakan->remove_tarif_tindakan_upload();
                if($this->muploadtindakan->insert_tarif_tindakan_upload($array_data) > 0){
					$success = 	'<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text"><i class="fa fa-check-circle"></i> Tarif tindakan baru berhasil di simpan!</h4>
                        </div>';
					$this->session->set_flashdata('success_msg', $success);
				}
				$this->muploadtindakan->remove_jenis_tindakan_upload();
                if($this->muploadtindakan->insert_jenis_tindakan_upload($array_data_jenis_tindakan) > 0){
					$success = 	'<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text"><i class="fa fa-check-circle"></i> Jenis tindakan baru berhasil di simpan!</h4>
                        </div>';
					$this->session->set_flashdata('success_msg_jenis', $success);
				}
				
            }
            // $this->modal_feedback('success', 'Success', 'Data Imported', 'OK');
        }
		else{
			print_r("Tarif Tindakan kosong");
		}

		// if(isset($_FILES['jenisTindakanFile']['name']) && in_array($_FILES['jenisTindakanFile']['type'], $file_mimes)) {
		// 	$array_file = explode('.', $_FILES['tarifTindakanFile']['name']);
        //     $extension  = end($array_file);

        //     if('csv' == $extension) {
        //         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        //     } else {
        //         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        //     }

        //     $spreadsheet = $reader->load($_FILES['tarifTindakanFile']['tmp_name']);
        //     $sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
        //     $array_data  = [];

        //     for($i = 1; $i < count($sheet_data); $i++) {
        //         // $data = array(
        //         //     'id_tindakan' => $sheet_data[$i]['1'],
        //         //     'kelas' => $sheet_data[$i]['8'],
        //         //     'jasa_rs' => $sheet_data[$i]['9'],
		// 		// 	'total_tarif' => $sheet_data[$i]['9'],
		// 		// 	'tarif_iks' => $sheet_data[$i]['11'],
		// 		// 	'tarif_bpjs' => $sheet_data[$i]['10'],
        //         // );
		// 		$tarifTindakan["id_tindakan"] = $sheet_data[$i]['1'];
		// 		$tarifTindakan["kelas"] = $sheet_data[$i]['8'];
		// 		$tarifTindakan["jasa_rs"] = (int)str_replace(",","",$sheet_data[$i]['9']);
		// 		$tarifTindakan["total_tarif"] = (int)str_replace(",","",$sheet_data[$i]['9']);
		// 		$tarifTindakan["tarif_iks"] = (int)str_replace(",","",$sheet_data[$i]['11']);
		// 		$tarifTindakan["tarif_bpjs"] = (int)str_replace(",","",$sheet_data[$i]['10']);
        //         $array_data[] = $tarifTindakan;
        //     }

		// 	if($array_data != '') {
		// 		$this->muploadtindakan->remove_jenis_tindakan_upload();
        //         $this->muploadtindakan->insert_jenis_tindakan_upload($array_data);
        //     }
		// }
		// else {
		// 	print_r("Jenis TIndakan kosong");
        //     // $this->modal_feedback('error', 'Error', 'Import failed', 'Try again');
        // }
		// exit();
        // redirect('tarif/cuploadtindakan/upload_tarif_tindakan');
		redirect('master/Mctindakan');
	}
}
?>