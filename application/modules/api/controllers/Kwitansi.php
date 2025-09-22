<?php

require APPPATH . 'libraries/REST_Controller.php';
include('Rjcterbilang.php');

class Kwitansi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
	}

	function my_decrypt($data) {
		try {
			$passphrase = '5d49962e85757883347cdb22c1b1222787c24902525ae7670b2f3dc50c2ec2f1';
			$secret_key = hex2bin($passphrase);
			$json = json_decode(base64_decode($data));
			if (!$json) {
				throw new Exception('Invalid JSON data');
			}
			$iv = base64_decode($json->{'iv'});
			$encrypted_64 = $json->{'data'};
			if (!$iv || !$encrypted_64) {
				throw new Exception('Invalid input data');
			}
			$data_encrypted = base64_decode($encrypted_64);
			if (!$data_encrypted) {
				throw new Exception('Invalid base64-encoded data');
			}
			$decrypted = openssl_decrypt($data_encrypted, 'aes-256-cbc', $secret_key, OPENSSL_RAW_DATA, $iv);
			if ($decrypted === false) {
				throw new Exception('Decryption failed');
			}
			return $decrypted;
		} catch (Exception $e) {
			// Handle the exception (e.g., log the error, return an error message)
			return false; // You can customize this part based on your error-handling needs
		}
	}


     public function cetakkwitansi()
    {
		$noreg = $this->input->get('data');
		if($noreg!=''){
			$noreg = $this->my_decrypt($noreg);
			if(!$noreg){
				header('Content-Type: application/json; charset=utf-8');
				echo json_encode([
					'metadata'=>[
						'code'=>400,
						'message'=>'Masukan Data Dengan Benar!'
					]
				]);
				return;
			}

			// Proteksi supaya dapat 10 character dan tidak mengandung karakter khusus
			if (!preg_match('/^[A-Z0-9]{10}$/', $noreg)) {
				header('Content-Type: application/json; charset=utf-8');
				echo json_encode([
					'metadata'=>[
						'code'=>400,
						'message'=>'Tidak Boleh Ada Karakter Khusus atau masukan data dengan benar!'
					]
				]);
				return;
			}


            $nomor=$this->db->query("SELECT NULLIF(MAX(idno_kwitansi),000000) as no_kwitansi from no_kwitansi")->row();
            // end get nomor

			$data9['no_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
			$data9['idno_kwitansi']=$data9['no_kwitansi'];


			$data9['xuser']='APM';
			$data9['xcreate']=date('Y-m-d H:i:s');
			$data9['no_register']=$noreg;
			$data9['nama_poli']='ADM';

            $cek  = $this->db->insert('nomor_kwitansi', $data9);

            // $cek=$this->rjmkwitansi->insert_nomorkwitansi($data9);

			$data10['tunai']='0';$data10['no_kk']='0';$data10['nilai_kkd']='0';$data10['persen_kk']='0';$data10['diskon']='0';

			// $this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data10);

            $this->db->where('idno_kwitansi', $data9['no_kwitansi']);
			$this->db->update('nomor_kwitansi', $data10);

			$data['pasien_bayar']='1';

			// $data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();

            $data_pasien= $this->db->query("SELECT data_pasien.nama,data_pasien.alamat,*, (select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1) as nm_dokter
            FROM daftar_ulang_irj as a, data_pasien, poliklinik
                where data_pasien.no_medrec=a.no_medrec
                and poliklinik.id_poli=a.id_poli
                and a.no_register='$noreg'")->row();



			$data['vtot_bayar']=0;
			$datank['vtot_bayar']=0;

            $total = $this->db->query("SELECT vtot, vtot_ok, vtot_lab, vtot_rad, vtot_obat, vtot_pa, diskon FROM daftar_ulang_irj WHERE no_register='$noreg'")->row();
            // var_dump($total);die();
            $data['tunai']=$total->vtot;
            $data['vtot_bayar']=(int)$data['vtot_bayar']+(int)$data['tunai'];
            $datank['tunai']=$total->vtot;
            $data['diskon']='0';
            $datank['diskon']=0;

			$totakhir=$total->vtot;

			$update = $this->db->where('idno_kwitansi', $data9['no_kwitansi'])->update('nomor_kwitansi', $data);
			// $this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data);

			$datank['no_register']=$noreg;
			$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
			$datank['user_cetak']='APM';
			$datank['tgl_cetak']=date('Y-m-d H:i:s');
			$datank['jenis_kwitansi']= 'Rawat Jalan';
			$datank['dp']= 0;
			$datank['vtot_bayar']=(int)$data['vtot_bayar'];

            $tahun = date('Y');
			$depan = substr($tahun,2,2);
			$update2 = $this->db->set('no_kwitansi',"(select 'RJ".$depan."-' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_kwitansi),6) FROM no_kwitansi where jenis_kwitansi = 'Rawat Jalan' ), '000000') as int) +1 as varchar),6) as id)", FALSE)
                        ->insert('no_kwitansi', $datank);
			// $this->rjmkwitansi->insert_nokwitansi($datank);

			$data1['bayar']= NULL;
            $data1['tgl_cetak_kw']= date("Y-m-d H:i:s");


            $where = "no_register='$noreg'";
            $status_bayar = $this->db->where($where)->update('pelayanan_poli', $data1);
			// $status_bayar=$this->rjmkwitansi->update_bayar_mrpoli($no_register,$data1);

            $data_tindakan = $this->db->query("SELECT *,
			(select COUNT(bpjs) from pelayanan_poli where bpjs= '0' and no_register='$noreg') as noncover
			FROM pelayanan_poli
			where no_register='$noreg'
			and bayar=0
			order by xupdate desc")->result();

			// $data_tindakan=$this->rjmkwitansi->getdata_unpaid_finish_tindakan_pasien($no_register)->result();

			$noncover=0;
			foreach($data_tindakan as $row1){

				if(($row1->noncover)>0){
					$noncover=1;
				}
			}

            $dummy = (int)$datank['idno_kwitansi'];

            $no_trx = $this->db->query("SELECT no_kwitansi
			FROM no_kwitansi
			where idno_kwitansi='$dummy'")->row();
			// $no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();


			if (substr($noreg,0,2) == 'RJ') {
				if ($data_pasien->id_poli == 'BA00') {
					$component_id = '02';
					$additional1 = 'Rawat Darurat 1';
				}else{
					$component_id = '01';
					$additional1 = 'Rawat Jalan 1';
				}
			}else{
				$component_id = '03';
				$additional1 = '';
			}

			$datares['reg_date'] = date('Y-m-d');
			$datares['reg_no'] = $noreg;
			$datares['rm_no'] = $data_pasien->no_medrec;
			$datares['pasien_name'] = $data_pasien->nama;
			$datares['dob'] = $data_pasien->tgl_lahir;
			$datares['gender'] = $data_pasien->sex;
			$datares['gol_darah'] = $data_pasien->goldarah;
			$datares['jenis_pelayanan_id'] = 1;
			$datares['jenis_transaksi'] = 1;
			$datares['payment_tp'] = 2;
			$datares['component_id'] = $data_pasien->id_poli;
			$datares['nama_dokter'] = $data_pasien->nm_dokter;
			$datares['trx_no'] = $no_trx->no_kwitansi;
			$datares['paid_flag'] = 0;
			$datares['cancel_flag'] = 0;
			$datares['is_cancel'] = 0;
			$datares['payment_bill'] = (int)$data['vtot_bayar'];
			$datares['cancel_nominal'] = 0;
			$datares['retur_nominal'] = 0;
			$datares['retur_flag'] = 0;
			$datares['new_payment_bill'] = 0;
			$datares['additional1'] = $additional1;
			$datares['additional2'] = '0';
			$datares['additional3'] = '0';

			// $this->rjmkwitansi->insert_registrasi($datares);
            $this->db->insert('registrasi', $datares);
            // return $this->response(['code'=>'200',],REST_Controller::HTTP_OK);

        $data['bayar'] = 'TUNAI';
		$data['no_register'] = $noreg;
		$data['daftar_ulang']=$data_pasien;
		$data['data_pasien']=$data_pasien;
        $data['penyetor']=$data['data_pasien']->nama;

		// $data['data_no_kwitansi'] = $this->rjmkwitansi->getdata_no_kwitansi_by_no_register($noreg)->row();
        $data['data_no_kwitansi'] = $this->db->query("SELECT *
        FROM no_kwitansi
        where no_register='$noreg' and Jenis_kwitansi = 'Rawat Jalan'")->row();

		$data['no_kwitansi'] = $data['data_no_kwitansi']->no_kwitansi;

		// $login_data = $this->load->get_var("user_info");
		$data['user'] = 'APM';

		if($noreg!=''){
			$data['cterbilang']=new rjcterbilang();

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");
            $conf= $this->db->query("SELECT * FROM app_config where key= 'header_pdf' ")->result();
			$top_header=$this->db->query("SELECT * FROM app_config where key= 'top_pdf' ")->row()->value;
			$bottom_header=$this->db->query("SELECT * FROM app_config where key= 'bottom_pdf' ")->row()->value;
			$data['logo_header']=$this->db->query("SELECT * FROM app_config where key= 'logo_url' ")->row()->value;
			$data['logo_kesehatan_header']=$this->db->query("SELECT * FROM app_config where key= 'logo_url_kesehatan' ")->row()->value;
			$data['kota_header']=$this->db->query("SELECT * FROM app_config where key= 'kota' ")->row()->value;


			$data['nama_pasien'] = $data['data_pasien']->nama;
			$data['tgl_lahir'] = $data['data_pasien']->tgl_lahir;
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');

			if ($data['data_pasien']->sex == 'L') {
				$data['jenkel'] = 'Laki - Laki';
			}else{
				$data['jenkel'] = 'Perempuan';
			}

			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];

            $data['detail_daful'] = $this->db->query("SELECT *,(SELECT nm_poli from poliklinik where id_poli=daftar_ulang_irj.id_poli limit 1) as nm_poli,
			(SELECT nm_dokter from data_dokter where id_dokter=daftar_ulang_irj.id_dokter limit 1) as nm_dokter,
			(select nmkontraktor from kontraktor where daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor limit 1) as kontraktor,
			CASE WHEN extract('hour' from xupdate)>=7 and extract('hour' from xupdate)<=14 THEN 'Pagi' ELSE 'Sore' END as shift
			FROM daftar_ulang_irj where no_register='$noreg' order by xupdate desc")->row();

            // $data['detail_daful']=$this->rjmkwitansi->get_detail_daful($noreg)->row();




            if($data['detail_daful']->cara_bayar=='UMUM'){
				$data['pasien_bayar']='TUNAI';
			}else {$data['pasien_bayar']='KREDIT';}

			$data['txtkk']='';
			$data['txtdiskon']='';
			$data['txttunai']="";
			$data['txtperusahaan']='';
			$data['totalbayar']='';
			$data['totalbayar1']='';
			$data['totalbayar2']='';
			$data['detail_bayar']=$data['detail_daful']->cara_bayar;


			$data['diskon']=$data['detail_daful']->diskon;
			$data['persen']=$data['detail_daful']->persen_kk;
			$data['tunai']=$data['detail_daful']->tunai;
			$data['nilaikk']=$data['detail_daful']->nilai_kkkd;
			$data['nominal_kk']=$data['persen']/100*$data['nilaikk']+$data['nilaikk'];


            $data['vtot']=$this->db->query("SELECT vtot, vtot_ok, vtot_lab, vtot_rad, vtot_obat, vtot_pa, diskon FROM daftar_ulang_irj WHERE no_register='$noreg'")->row();
			$data['data_tindakan']=$this->db->query("SELECT * FROM pelayanan_poli where no_register='$noreg' and bayar IS NULL order by xupdate desc")->result();
			$vtottind=0;
			$jumlah_vtot=0;
			foreach($data['data_tindakan'] as $row1){

				 $vtottind = $vtottind + $row1->vtot;
			}
			$jumlah_vtot =  $vtottind - $data['diskon'];
			$data['vtot_terbilang']=$data['cterbilang']->terbilang($jumlah_vtot);
            // var_dump(base_url("assets/img/kementriankesehatan.png"));die();
        	// $returnHtml?$this->load->view('kwitansi/kwitansi_irj_apm',$data):$this->load->view('kwitansi/kwitansi_irj',$data);
            $html ='<!doctypehtml><style>#tablerincian tr td{font-size:10pt}#tablebiaya td,#tablebiaya th,#tablebiaya tr{border:1px solid #000}</style><body class=A4><div class="A4 padding-fix-10mm sheet"><table width=100%><tr><td width=13%><img alt=img height=40 src=http://ekamek.sidig.io/assets/img/kementriankesehatan.png style=padding-right:5px><td width=74% align=center><font style=font-size:6pt!important><b>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</b><br><b>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</b><br><b>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</b><br>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431<br>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</font><td width=13%><img alt=img height=40 src=http://ekamek.sidig.io/assets/img/logo.png style=padding-right:5px></table><div style="height:0;border:2px solid #000"></div><table width=100% border=0 id=tablerincian><tr><th colspan=6 style=font-size:8pt><p align=center size=12px><u><b>KWITANSI '.((substr($data['detail_daful']->nm_poli,0,3) == 'IGD')?'RAWAT DARURAT':'RAWAT JALAN').'</b></u><tr><td width=23%><b>Telah Terima Dari</b><td width=2%>:<td width=25%>'.str_replace('%20', ' ', $data['penyetor']).'<td width=23%><b>Nama Pasien</b><td width=2%>:<td width=25%>'.strtoupper($data['nama_pasien']).'<tr><td><b>No Register</b><td>:<td>'.$data['no_register'].'<td><b>Alamat</b><td>:<td>'.strtoupper($data['data_pasien']->alamat).'<tr><td><b>No RM</b><td>:<td>'.strtoupper($data['data_pasien']->no_cm).'<td><b>Kota</b><td>:<td>'.$data['data_pasien']->kotakabupaten.'<tr><td><b>Tgl Reg</b><td>:<td>'.$data['tgl'].'<td><b>Umur</b><td>:<td>'.strtoupper($data['umur']).'Tahun<tr><td><b>Pembayaran</b><td>:<td>'.strtoupper($data['data_pasien']->cara_bayar).'<td><b>Jenis Kelamin</b><td>:<td>'.strtoupper($data['jenkel']).'<tr><td><b>Dijamin Oleh</b><td>:<td>'.strtoupper($data['detail_daful']->kontraktor).'<td><b>No Kwitansi</b><td>:<td>'.strtoupper($data['no_kwitansi']).'<tr><td><b>Unit</b><td>:<td rowspan=3>'.strtoupper($data['detail_daful']->nm_poli).'<td><b>Dokter</b><td>:<td>'.strtoupper($data['detail_daful']->nm_dokter).'</table><br>';

                $no=1;

			    $html .= '<table id="tablebiaya" width="100%" style="border-collapse:collapse">
						<tr>
							<th width="5%" style="font-size:11px"><p align="center"><b>No</b></p></th>
							<th width="75%" style="font-size:11px"><p align="center"><b>Pemeriksaan</b></p></th>
							<th width="20%" style="font-size:11px"><p align="center"><b>Biaya</b></p></th>
						</tr>

                       ';

					   $jumlah_vtot = 0;
					   foreach($data['data_tindakan'] as $row1){
                        $html.= '
                        <tr>
                            <td><p align="center" style="font-size:11px">'.($no++).'</p></td>
                            <td style="font-size:11px"><p>'.ucwords(strtolower($row1->nmtindakan)).'</p></td>
                            <td><p align="right" style="font-size:11px">'.number_format( $row1->vtot, 2 , ',' , '.' ).'</p></td>
                        </tr>';

                $jumlah_vtot = $jumlah_vtot+$row1->vtot;


                        }

			        $jumlah_vtot_1 =  $jumlah_vtot - $data['diskon'];
                    $html.= '
						<tr>
							<th colspan="2"><p align="right" style="font-size:11px"><b>Sub Total   </b></p></th>
							<th><p align="right" style="font-size:11px">'.number_format( $jumlah_vtot, 2 , ',' , '.' ).'</p></th>
						</tr>
						<tr>
							<th colspan="2"><p align="right" style="font-size:11px"><b>Total   </b></p></th>
							<th><p align="right" style="font-size:11px">'.number_format( $jumlah_vtot_1, 2 , ',' , '.' ).'</p></th>
						</tr>
					</table>
					<table  >
					        <tr>
								<td width="17%" style="font-size:8pt"><b>Terbilang</b></td>
								<td width="3%" style="font-size:8pt"> : </td>
								<td width="65%" style="font-size:8pt"><i>'.strtoupper($data['vtot_terbilang']).'</i></td>
								<td  style="font-size:8pt">
									<p>
									an. Bendaharawan Rumah Sakit
									'.$data['kota_header'].',<br>'.' '.$data['tgl'].'
									<br>K a s i r
									</p>
								</td>
							</tr>
					</table>

                    <table style="width:100%;">
						<tr>
							<td width="65%" style="font-size:6pt">

							</td>

						</tr>
					</table>
        </div>
    </body>

</html>

            ';

            echo $html;
                    }
                }
            }
}
