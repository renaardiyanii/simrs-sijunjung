<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
class Mapfile extends Secure_area {
	public function __construct() {
			parent::__construct();
			$this->load->model('irj/rjmpencarian','',TRUE);
			$this->load->model('irj/rjmregistrasi','',TRUE);
			$this->load->model('irj/rjmpelayanan','',TRUE);
			$this->load->model('irj/rjmkwitansi','',TRUE);
			$this->load->model('irj/rjmtracer','',TRUE);
			$this->load->model('ird/ModelRegistrasi','',TRUE);
			$this->load->model('admin/M_user','',TRUE);
			$this->load->model('irj/M_update_sepbpjs','',TRUE);
			$this->load->model('bpjs/Mbpjs','',TRUE);
			$this->load->helper('pdf_helper');
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien

	public function index()
	{
		$data['title'] = 'Status Map Pasien';
		//$data['data_pasien']="";	
        if (empty($this->input->post('tgl_kunjungan'))) {
            $data['tgl'] = date('Y-m-d'); 
        }else{
            $data['tgl'] = $this->input->post('tgl_kunjungan');
        }
		$this->load->view('map/vmap',$data);
	}

	public function get_pasien()
    {
        $list = $this->rjmtracer->get_pasien1();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            if ( date("Y-m-d") == substr($result->tgl_daftar,0,10) ) 
            $jns_kunjungan="BARU";
            else $jns_kunjungan="LAMA";
            $row[] = $no;
            if($result->tiperawat!=''){
            	$tiperawat=$result->tiperawat;
            }
            else if(substr($result->no_register, 0,2)=='RJ'){
				$tiperawat='IRJ';
			}else if(substr($result->no_register, 0,2)=='RI'){
				$tiperawat='IRI';
			}
            $row[] = $result->no_register.'<br>'.$tiperawat.' | <b>'.$jns_kunjungan.'</b>';
            $row[] = $result->no_cm;
            $row[] = $result->nama;            
            $row[] = $result->nm_poli;
            $row[] = date('d-m-Y <br>H:i',strtotime($result->tgl_kunjungan));
            $row[] = $result->xcreate;
            
            $dis='';
            if($result->timeout!='' && $result->timeout!=null && $result->timeout!='0000-00-00 00:00:00'){
            	$row[] = '<center>'.date('H:i',strtotime($result->timeout)).'</center>';
            }else{
            	$row[] = '-';
            }

            if($result->timein!='' && $result->timein!=null && $result->timein!='0000-00-00 00:00:00'){
            	$row[] = '<center>'.date('H:i',strtotime($result->timein)).'</center>';
            	$dis='disabled';
            }else{
            	$row[] = '-';
            }

            if ($result->status_map==0 || $result->status_map==null) {
            	$row[] = 'MASUK';
            	$switchcek='';
            } else if($result->status_map==1){
            	$switchcek='checked';
            	$row[] = 'KELUAR';
            } else if($result->status_map==2){
            	$switchcek='';
            	$row[] = 'DIRUJUK';
            }

            
            $row[] = '<center>
            <label class="switch">
			  <input type="checkbox" value="1" onclick="saveTimeIn(\''.$result->no_register.'\',\''.$result->status.'\')" '.$switchcek.' '.$dis.'>
			  <span class="slider"></span>
			</label><br><button class="btn btn-info btn-sm" onclick="cetak_tracer(\''.$result->no_register.'\',\''.$jns_kunjungan.'\')" style="margin-bottom:5px;"><i class="fa fa-print"></i> Tracer</button>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->rjmtracer->count_all1(),
                        "recordsFiltered" => $this->rjmtracer->count_filtered1(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function get_pasien_irj()
    {
        $list = $this->rjmtracer->get_pasien_irj();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            // $row[] = $count->pendidikan;
            // $row[] = $count->tmpt_pendidikan;  
            // $row[] = $count->jurusan;
            // $row[] = '<center>'.$count->th_lulus.'</center>';		                        
            // $row[] = '<center><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit" onclick="edit_pendumum('.$count->id.')"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete" onclick="delete_pendumum('.$count->id.')"><i class="ti-trash"></i></a></center>';			
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->rjmtracer->get_pasien_irj_count(),
                        "recordsFiltered" => $this->rjmtracer->get_pasien_irj_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    function get_listpasien(){
        //print_r($this->input->post('tgl_kunjungan'));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if(sizeof($_POST)==0) {
            $line['data'] = $line2;
        }else{
            $hasil = $this->rjmtracer->get_list_pasien_map($this->input->post('tgl_kunjungan'))->result();
            /*$line['data'] = $hasil;*/
             $no=1;

	//		 print_r( $hasil);die();
            foreach ($hasil as $result) {
             

				if ( date("Y-m-d") == substr($result->tgl_daftar,0,10) ) 
	            $jns_kunjungan="BARU";
	            else $jns_kunjungan="LAMA";
	            $row['no'] = $no;
	            $row['idmap_pasien'] = $result->idmap_pasien;
	            
	            
	            $row['no_cm'] = $result->no_cm;
	            $row['nama'] = $result->nama;     
	            $poli_ke = '';
	            if (substr($result->no_register, 0,2) == 'RJ') {
	            	$poli_ke = '<br><b>Poli ke - '.$result->poli_ke.'</b>';
	            }

	               $row['nm_poli'] = $result->nm_poli.$poli_ke;
				   // Create a DateTime object from the database value and set the timezone to UTC
					$datetime = new DateTime($result->tgl_kunjungan, new DateTimeZone('UTC'));

					// Format the date without converting the timezone
					$row['tgl_kunjungan'] = $datetime->format('d-m-Y <br> H:i');

	            //    $row['tgl_kunjungan'] = date('d-m-Y H:i',strtotime($result->tgl_kunjungan.' UTC'));
	               $row['xcreate'] = $result->xcreate;
	            
	            $dis='';
	            if($result->timeout!='' && $result->timeout!=null && $result->timeout!='0000-00-00 00:00:00'){
	            	$row['timeout'] = '<center>'.date('H:i',strtotime($result->timeout)).'</center>';
	            }else{
	            	$row['timeout'] = '-';
	            }

	            if($result->timein!='' && $result->timein!=null && $result->timein!='0000-00-00 00:00:00'){
	            	$row['timein'] = '<center>'.date('H:i',strtotime($result->timein)).'</center>';
	            	$dis='disabled';
	            }else{
	            	$row['timein'] = '-';
	            }

	            if ($result->status_map==0 || $result->status_map==null) {
	            	$row['status'] = 'MASUK';
	            	$switchcek='';
	            } else if($result->status_map==1){
	            	$switchcek='checked';
	            	$row['status'] = 'KELUAR';
	            } else if($result->status_map==2){
	            	$switchcek='';
	            	$row['status'] = 'DIRUJUK';
	            }
	            $row['catatan'] = $result->catatan.'<br><b>'.$result->ket_pulang.'</b>';
	            if($result->tiperawat!=''){
	            	$tiperawat=$result->tiperawat;
	            	if($result->tiperawat=='IRJ'){
						$row['aksi'] = '<center>
			            <label class="switch">
						  <input type="checkbox" value="1" onclick="saveTimeIn(\''.$result->no_register.'\',\''.$result->status.'\',\''.$result->no_medrec.'\')" '.$switchcek.' '.$dis.'>
						  <span class="slider"></span>
						</label>
						<button class="btn btn-danger btn-sm btn-block" onclick="cetak_tracer(\''.$result->no_register.'\',\''.$jns_kunjungan.'\')" style="margin-bottom:5px;"><i class="fa fa-print"></i> Tracer</button>';
					}
					else if($result->tiperawat=='IRI'){
						$row['aksi'] = '<center>
			            <label class="switch">
						  <input type="checkbox" value="1" onclick="saveTimeIn(\''.$result->no_register.'\',\''.$result->status.'\',\''.$result->no_medrec.'\')" '.$switchcek.' '.$dis.'>
						  <span class="slider"></span>
						  </label>
						</label>';
					}
	            }
	            else if(substr($result->no_register, 0,2)=='RJ'){
					$tiperawat='IRJ';
					$row['aksi'] = '<center>
	            <label class="switch">
				  <input type="checkbox" value="1" onclick="saveTimeIn(\''.$result->no_register.'\',\''.$result->status.'\',\''.$result->no_medrec.'\')" '.$switchcek.' '.$dis.'>
				  <span class="slider"></span>
				</label>
				<button class="btn btn-danger btn-sm btn-block" onclick="cetak_tracer(\''.$result->no_register.'\',\''.$jns_kunjungan.'\')" style="margin-bottom:5px;"><i class="fa fa-print"></i> Tracer</button>';
				}else if(substr($result->no_register, 0,2)=='RI'){
					$tiperawat='IRI';
					$row['aksi'] = '<center>
	            <label class="switch">
				  <input type="checkbox" value="1" onclick="saveTimeIn(\''.$result->no_register.'\',\''.$result->status.'\',\''.$result->no_medrec.'\')" '.$switchcek.' '.$dis.'>
				  <span class="slider"></span>
				</label>';
				}

				$row['no_register'] = $result->no_register.'<br>'.$tiperawat.' | <b>'.$jns_kunjungan.'</b>';
	           
                $line2[] = $row;
                 $no++;
            }
            $line['data'] = $line2;

        }
        echo json_encode($line);
    }

 //    function save_catatan() {		
	// 	$no_register = $this->input->post('no_register');						
	// 	$data = array(				
	// 		'catatan' => $this->input->post('catatan')
	// 	);
	// 	$result = $this->rjmtracer->save_catatan($no_register,$data);						
	// 	echo json_encode($result);
	// }


    // function get_logpasien(){
    //     //print_r($this->input->post('tgl_kunjungan'));
    //     $line  = array();
    //     $line2 = array();
    //     $row2  = array();
    //     if(sizeof($_POST)==0) {
    //         $line['data'] = $line2;
    //     }else{
    //     	if(strlen($this->input->post('nocm'))<7 && $this->input->post('nocm')!=''){
    //     		$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('nocm'))->row();
    //     		$nocm=$data['data_pasien']->no_medrec;
    //     	}else{
    //     		$nocm=$this->input->post('nocm');
    //     	}

    //         $hasil = $this->rjmtracer->get_loglist_pasien_map($this->input->post('param'),$this->input->post('tgl_kunjungan'),$nocm)->result();
    //         /*$line['data'] = $hasil;*/
    //          $no=1;
    //         foreach ($hasil as $result) {
    //             /*$row2['idmap_pasien'] = $value->idmap_pasien;
    //             $row2['no_po'] = $value->no_po;
    //             $row2['tgl_po'] = $value->tgl_po;
    //             $row2['company_name'] = $value->company_name;
    //             //$row2['supplier'] = $value->company_name;
    //             $row2['sumber_dana'] = $value->sumber_dana;
    //             $row2['user'] = $value->user;

    //             //$row2['no_faktur'] = $value->no_faktur;
    //             if ($value->open > 0)
    //                 $row2['status'] = '<font color="red">Open</font>';
    //             else
    //                 $row2['status'] = '<font color="green">Closed</font>';
    //             $row2['aksi'] = '<center>
				// <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Detail</button> 
				// 			</center>';*/

				// if ( date("Y-m-d") == substr($result->tgl_daftar,0,10) ) 
	   //          $jns_kunjungan="BARU";
	   //          else $jns_kunjungan="LAMA";
	   //          $row['no'] = $no;
	   //          $row['idmap_pasien'] = $result->idmap_pasien;
	            
	            
	   //          $row['no_cm'] = $result->no_cm;
	   //          $row['nama'] = $result->nama;            
	   //          $row['nm_poli'] = $result->nm_poli;
	            
	   //          $dis='';
	   //          if($result->timeout!='' && $result->timeout!=null && $result->timeout!='0000-00-00 00:00:00'){
	   //          	$row['timeout'] = '<center>'.date('d-m-Y H:i',strtotime($result->timeout)).'</center>';
	   //          }else{
	   //          	$row['timeout'] = '-';
	   //          }

	   //          if($result->timein!='' && $result->timein!=null && $result->timein!='0000-00-00 00:00:00'){
	   //          	$row['timein'] = '<center>'.date('d-m-Y H:i',strtotime($result->timein)).'</center>';
	   //          	$dis='disabled';
	   //          }else{
	   //          	$row['timein'] = '-';
	   //          }

	   //          if ($result->status==0 || $result->status==null) {
	   //          	$row['status'] = 'MASUK';
	   //          	$switchcek='';
	   //          } else if($result->status==1){
	   //          	$switchcek='checked';
	   //          	$row['status'] = 'KELUAR';
	   //          } else if($result->status==2){
	   //          	$switchcek='';
	   //          	$row['status'] = 'DIRUJUK';
	   //          }

	   //          if($result->tiperawat!=''){
	   //          	$tiperawat=$result->tiperawat;
	   //          }
	   //          else if(substr($result->no_register, 0,2)=='RJ'){
				// 	$tiperawat='IRJ';
				// }else if(substr($result->no_register, 0,2)=='RI'){
				// 	$tiperawat='IRI';
				// }

				// $row['no_register'] = $result->no_register.'<br>'.$tiperawat.' | <b>'.$jns_kunjungan.'</b>';
	            
    //             $line2[] = $row;
    //              $no++;
    //         }
    //         $line['data'] = $line2;

    //     }
    //     echo json_encode($line);
    // }

    function get_logpasien(){
        //print_r($this->input->post('tgl_kunjungan'));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if(sizeof($_POST)==0) {
            $line['data'] = $line2;
        }else{
        	if(strlen($this->input->post('nocm'))<7 && $this->input->post('nocm')!=''){
        		$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('nocm'))->row();
        		$nocm=$data['data_pasien']->no_medrec;
        	}else{
        		$nocm=$this->input->post('nocm');
        	}

            $hasil = $this->rjmtracer->get_loglist_pasien_map($this->input->post('param'),$this->input->post('tgl_kunjungan'),$nocm)->result();
            /*$line['data'] = $hasil;*/
             $no=1;
            foreach ($hasil as $result) {
                /*$row2['idmap_pasien'] = $value->idmap_pasien;
                $row2['no_po'] = $value->no_po;
                $row2['tgl_po'] = $value->tgl_po;
                $row2['company_name'] = $value->company_name;
                //$row2['supplier'] = $value->company_name;
                $row2['sumber_dana'] = $value->sumber_dana;
                $row2['user'] = $value->user;

                //$row2['no_faktur'] = $value->no_faktur;
                if ($value->open > 0)
                    $row2['status'] = '<font color="red">Open</font>';
                else
                    $row2['status'] = '<font color="green">Closed</font>';
                $row2['aksi'] = '<center>
				<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Detail</button> 
							</center>';*/

				if ( date("Y-m-d") == substr($result->tgl_daftar,0,10) ) 
	            $jns_kunjungan="BARU";
	            else $jns_kunjungan="LAMA";
	            $row['no'] = $no;
	            $row['idmap_pasien'] = $result->idmap_pasien;
	            
	            
	            $row['no_cm'] = $result->no_cm;
	            $row['nama'] = $result->nama;            
	            $row['nm_poli'] = $result->nm_poli;
	            $row['petugas'] = $result->petugas;
	            $row['catatan']=$result->catatan;
	            
	            $dis='';
	            if($result->timeout!='' && $result->timeout!=null && $result->timeout!='0000-00-00 00:00:00'){
	            	$row['timeout'] = '<center>'.date('d-m-Y H:i',strtotime($result->timeout)).'</center>';
	            }else{
	            	$row['timeout'] = '-';
	            }

	            if($result->timein!='' && $result->timein!=null && $result->timein!='0000-00-00 00:00:00'){
	            	$row['timein'] = '<center>'.date('d-m-Y H:i',strtotime($result->timein)).'</center>';
	            	$dis='disabled';
	            }else{
	            	$row['timein'] = '-';
	            }

	            if ($result->status==0 || $result->status==null) {
	            	$row['status'] = 'MASUK';
	            	$switchcek='';
	            } else if($result->status==1){
	            	$switchcek='checked';
	            	$row['status'] = 'KELUAR';
	            } else if($result->status==2){
	            	$switchcek='';
	            	$row['status'] = 'DIRUJUK';
	            }

	            if($result->tiperawat!=''){
	            	$tiperawat=$result->tiperawat;
	            }
	            else if(substr($result->no_register, 0,2)=='RJ'){
					$tiperawat='IRJ';
				}else if(substr($result->no_register, 0,2)=='RI'){
					$tiperawat='IRI';
				}

				$row['no_register'] = $result->no_register.'<br><b>'.$jns_kunjungan.'</b>';
	            
                $line2[] = $row;
                 $no++;
            }
            $line['data'] = $line2;

        }
        echo json_encode($line);
    }



	public function mapkeluar(){

		$no_register=$this->input->post('no_register');
		$exist=$this->input->post('exist');	
        $login_data = $this->load->get_var("user_info");
        $user=$login_data->username;	
		$data['no_register']=$no_register;
		//$data['timeout']=date('Y-m-d H:i:s');
		$data['timeout']=date('Y-m-d H:i:s');
		if(substr($no_register, 0,2)=='RJ'){
			$data['tiperawat']='IRJ';
		}else if(substr($no_register, 0,2)=='RI'){
			$data['tiperawat']='IRI';
		}

		if($exist==''){
			$daful=$this->rjmpelayanan->getdata_daftar_ulang_pasien2($no_register)->row();
			$id_poli=$daful->id_poli;
			$data['no_medrec']=$daful->no_medrec;
			$data['id_poli']=$id_poli;
			$data['status']=1;
            $data['petugas']=$user;
			if(substr($no_register, 0,2)=='RJ'){
				$ruang=$this->rjmtracer->get_poli($no_register)->row();
				$data['catatan']=''.$ruang->nm_poli.', '.date('d-m-Y').''; 
            $id=$this->rjmtracer->insert_mappasien($data);

            $data1['status_map']=1;
            $id=$this->rjmregistrasi->update_pasien_irj($data1,$data['no_medrec']);
            }   
            elseif(substr($no_register, 0,2)=='RI'){
                    $ruang=$this->rjmtracer->get_ruang($no_register)->row();
                    $data['catatan']=''.$ruang->nmruang.', '.date('d-m-Y').'';
                    $data['status']=1;
                 
             print_r($data);die();
			$id=$this->rjmtracer->insert_mappasien($data);

			$data1['status_map']= 1;
			$id=$this->rjmregistrasi->update_pasien_irj($data1,$data['no_medrec']);
            }
                
		}else{
			//$id=$this->rjmtracer->delete_mappasien($no_register);			
			$data['timein']=NULL;
			$data['status']=1;
			$id=$this->rjmtracer->update_mappasien($no_register,$data);
		}

		echo json_encode($id);
	}

	public function mapkembali(){
		$no_register=$this->input->post('no_register');
        $login_data = $this->load->get_var("user_info");
        $user=$login_data->username;    
		$data['timein']=date('Y-m-d H:i:s');
		$data['status']=0;
        $data['petugas']=$user;
		$id=$this->rjmtracer->update_mappasien($no_register,$data);

		$data2['status_map']=0;
		$no_medrec=$this->input->post('no_medrec');
		$id=$this->rjmregistrasi->update_pasien_irj($data2,$no_medrec);
		echo json_encode($id);
	}


	public function excel_mappasien($tgl){
		//=$this->input->post('tgl_map');
		$title="Laporan status Map tanggal ".date('d-m-Y',strtotime($tgl));
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
		
		////////////////////////////////////////////////////////////EXCEL

		$this->load->library('Excel'); 			
		// Create new PHPExcel object  
		// PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$objPHPExcel = new PHPExcel();   

		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)->setLastModifiedBy($namars);  
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_status_pasien.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		$objPHPExcel->getActiveSheet()->setAutoFilter('B4:J4');
		$no = 1;

		$list = $this->rjmtracer->get_list_pasien_map($tgl)->result();
		$rowCount=5;
        foreach ($list as $row2) {
        	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$no);
        	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row2->no_register);
        	$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
        	if ( date("Y-m-d") == substr($row2->tgl_daftar,0,10) ) 
	            $jns_kunjungan="BARU";
	            else $jns_kunjungan="LAMA";
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $jns_kunjungan);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->nm_poli);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, date('d-m-Y H:i',strtotime($row2->tgl_kunjungan)));

			if($row2->timeout!='' && $row2->timeout!=null && $row2->timeout!='0000-00-00 00:00:00'){
            	$timeout = date('H:i',strtotime($row2->timeout));
            }else{
            	$timeout = '-';
            }

            if($row2->timein!='' && $row2->timein!=null && $row2->timein!='0000-00-00 00:00:00'){
            	$timein = date('H:i',strtotime($row2->timein));            	
            }else{
            	$timein = '-';
            }

			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $timeout);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $timein);
			if($row2->status=="1"){
				$status="KELUAR";
			}else
				$status="MASUK";
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $status);
        	$no++;
        	$rowCount++;
        }

        $rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $no)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $file_name="STATUS_".$tgl.".xlsx";

        // Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Kunjungan');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		$objPHPExcel->getActiveSheet()->setTitle($namars);
		//ob_end_flush();
		ob_end_clean();
		//this is the header given from PHPExcel examples.
		//but the output seems somewhat corrupted in some cases.
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	public function excel_maphistorylogpasien($search_all,$tgl_kunjungan='',$no_cm=''){
		$title="Laporan history status Map tanggal ".date('d-m-Y',strtotime($tgl_kunjungan));
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
		
		////////////////////////////////////////////////////////////EXCEL

		$this->load->library('Excel'); 			
		// Create new PHPExcel object  
		// PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$objPHPExcel = new PHPExcel();   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)->setLastModifiedBy($namars);  
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_history_status_pasien.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		$objPHPExcel->getActiveSheet()->setAutoFilter('B4:J4');
		$no = 1;

		if(strlen($no_cm)<7 && $no_cm!=''){
        		$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($no_cm)->row();
        		$no_cm=$data['data_pasien']->no_medrec;
        	}

		$list = $this->rjmtracer->get_loglist_pasien_map($search_all,$tgl_kunjungan,$no_cm)->result();
		$rowCount=5;
        foreach ($list as $row2) {
        	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$no);
        	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row2->no_register);
        	$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
        	if ( date("Y-m-d") == substr($row2->tgl_daftar,0,10) ) 
	            $jns_kunjungan="BARU";
	            else $jns_kunjungan="LAMA";
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $jns_kunjungan);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->nm_poli);
			if($row2->timeout!='' && $row2->timeout!=null && $row2->timeout!='0000-00-00 00:00:00'){
            	$timeout = date('d-m-Y H:i',strtotime($row2->timeout));
            }else{
            	$timeout = '-';
            }

            if($row2->timein!='' && $row2->timein!=null && $row2->timein!='0000-00-00 00:00:00'){
            	$timein = date('d-m-Y H:i',strtotime($row2->timein));            	
            }else{
            	$timein = '-';
            }

			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $timeout);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $timein);

			if($row2->status=="1"){
				$status="KELUAR";
			}else if($row2->status=="0"){
				$status="MASUK";
			}else if($row2->status=="2"){
				$status="DIRUJUK";
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $status);
        	$no++;
        	$rowCount++;
        }

        $rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $no-1)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $file_name="STATUS_".$tgl_kunjungan."".$no_cm.".xlsx";

        // Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Histori Map Pasien');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		$objPHPExcel->getActiveSheet()->setTitle($namars);
		//ob_end_flush();
		ob_end_clean();
		//this is the header given from PHPExcel examples.
		//but the output seems somewhat corrupted in some cases.
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	public function logmap(){
		$data['title'] = 'History Map Pasien';
		
		$this->load->view('map/vlogmap',$data);	
	}
}
?>