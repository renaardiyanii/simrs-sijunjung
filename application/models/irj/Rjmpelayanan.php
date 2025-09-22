<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rjmpelayanan extends CI_Model{
		var $procedure_order = array(null,'procedure_text','klasifikasi_procedure','id_procedure');
        var $procedure_search = array('icd9cm_irj.id_procedure','icd9cm_irj.procedure_text','icd9cm_irj.klasifikasi_procedure','icd9cm_irj.nm_procedure'); 
        var $default_order_procedure = array('icd9cm_irj.klasifikasi_procedure' => 'desc','icd9cm_irj.id' => 'desc'); 

        var $diagnosa_order = array(null,'diagnosa_text','klasifikasi_diagnos','id_diagnosa');
        var $diagnosa_search = array('diagnosa_pasien.diagnosa_text','diagnosa_pasien.klasifikasi_diagnos','diagnosa_pasien.id_diagnosa','diagnosa_pasien.diagnosa'); 
        var $default_order_diagnosa = array('diagnosa_pasien.klasifikasi_diagnos' => 'desc','diagnosa_pasien.id' => 'desc'); 
		function __construct(){
			parent::__construct();
		}
		
		function get_tindakan($kelas, $pok_tindak){
				if($pok_tindak=='BK00' || $pok_tindak=='BK01' || $pok_tindak=='BQ01' || $pok_tindak=='BQ02'){
					return $this->db->query("SELECT * FROM (SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
							LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
							WHERE left(a.idtindakan,2)='1B' and kelas='III' 
							UNION
							SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
							LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
							WHERE idpok2='AA' and kelas='III' 
							UNION 
							SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
							LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
							WHERE left(b.id_tindakan,2)=left('$pok_tindak',2) and kelas='III'
							) AS C
							ORDER BY idtindakan ASC ");
				}else{
					return $this->db->query("SELECT * FROM (SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
							LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
							WHERE left(a.idtindakan,2)='1B' and kelas='III' 
							UNION
							SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
							LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
							WHERE idpok2='AA' and kelas='III' 
							UNION 
							SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
							LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
							WHERE left(b.id_tindakan,2)=left('$pok_tindak',2)  and kelas='III'
							) AS C
							ORDER BY idtindakan ASC ");					
				}			
				
		}
		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif, tarif_alkes FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}
		function get_dokter_poli($id_poli){

			if($id_poli!='BW00' &&  $id_poli!='BA00'){
				return $this->db->query("SELECT dd.* 
										FROM data_dokter AS dd
										LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter
										WHERE dp.id_poli='$id_poli'
										and dd.deleted='0'
										or dd.ket='Perawat'
										ORDER BY nm_dokter");
			}
			else{
				/*$this->db->select('*');
				$this->db->from('data_dokter');
				$where = '(ket="Dokter Jaga" or ket = "Dokter Umum")';
       				$this->db->where($where);
				$query = $this->db->get();
				return $query;*/

				return $this->db->query("SELECT * from ((SELECT 
					    dd.*
					FROM
					    data_dokter AS dd
					     JOIN
					    dokter_poli AS dp ON dd.id_dokter = dp.id_dokter
					WHERE
					    dp.id_poli = '$id_poli'
					        AND dd.deleted = '0'
					ORDER BY nm_dokter) 
					UNION ALL 
					(SELECT 
					    dd.*
					FROM
					    data_dokter AS dd
					WHERE
					    dd.ket LIKE '%Dokter Jaga%'
					        OR dd.ket LIKE '%Dokter Residen%'
					        AND dd.deleted = '0'
					ORDER BY nm_dokter)) as a group by a.id_dokter");
								}
								
							}
		function get_dokter_poli2($id_poli){

			if($id_poli!='BW00' &&  $id_poli!='BA00'){
				return $this->db->query("SELECT dd.* 
										FROM data_dokter AS dd
										LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter
										WHERE dp.id_poli='$id_poli'
										and dd.ket NOT LIKE '%Perawat%'
										AND dd.deleted = '0'
										ORDER BY nm_dokter");
			}
			else{
				/*$this->db->select('*');
				$this->db->from('data_dokter');
				$where = '(ket="Dokter Jaga" or ket = "Dokter Umum")';
       				$this->db->where($where);
				$query = $this->db->get();
				return $query;*/

				return $this->db->query("SELECT * from ((SELECT 
					    dd.*
					FROM
					    data_dokter AS dd
					     JOIN
					    dokter_poli AS dp ON dd.id_dokter = dp.id_dokter
					WHERE
					    dp.id_poli = '$id_poli'
					        AND dd.deleted = '0'
					ORDER BY nm_dokter) 
					UNION ALL 
					(SELECT 
					    dd.*
					FROM
					    data_dokter AS dd
					WHERE
					    dd.ket LIKE '%Dokter Jaga%'
					        OR dd.ket LIKE '%Dokter Residen%'
					        AND dd.deleted = '0'
					ORDER BY nm_dokter)) as a group by a.id_dokter");
								}
								
							}

		function get_dokter_poli_BQ00(){
			return $this->db->query("SELECT dd.* FROM data_dokter AS dd LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter WHERE id_poli='BQ00' or dd.ket='Dokter Jaga' or ket = 'Umum' and dd.deleted='0' or dd.ket='Perawat' group by dd.id_dokter ORDER BY nm_dokter");			
		}
		function get_dokter_poli_BA00(){
			return $this->db->query("SELECT a.nm_dokter, a.id_dokter from data_dokter as a INNER JOIN dokter_poli as b ON b.id_dokter=a.id_dokter WHERE b.id_poli='BA00' and a.deleted='0' ORDER BY a.nm_dokter");			
		}
		//POLI PENYAKIT DALAM (BQ00)
		////////////////////////////////////////////////////////////////////////////////////////////////////////////batal
		function batal_pelayanan_poli($no_register,$status){
			//$this->db->query("update daftar_ulang_irj set status='C' where no_register='$no_register'");
			if($status=='1'){
				$this->db->query("DELETE FROM daftar_ulang_irj WHERE no_register='$no_register'");
				$this->db->query("DELETE FROM pelayanan_poli WHERE no_register='$no_register'");
			}else
				$this->db->query("UPDATE daftar_ulang_irj SET status='1', ket_pulang='BATAL_PELAYANAN_POLI' WHERE no_register='$no_register'");
			//$this->db->query("DELETE FROM pelayanan_poli WHERE no_register='$no_register'");
			return true;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////data pasien u/ di transaksi pelayanan
// 		function getdata_daftar_ulang_pasien($no_register){
// 			return $this->db->query("SELECT *, 
// (SELECT nmkontraktor from kontraktor where id_kontraktor=daftar_ulang_irj.id_kontraktor) as nmkontraktor 
// FROM daftar_ulang_irj,data_pasien 
// where daftar_ulang_irj.no_medrec=data_pasien.no_medrec 
// and daftar_ulang_irj.no_register='$no_register'");
// 		}
			// Mufti, hilangin looping dalam looping.

		function getdata_daftar_ulang_pasien($no_register){
			return $this->db->query("SELECT
					a.*,b.*,e.*,f.*,g.*,h.*,i.*,c.nmkontraktor,d.nm_dokter as dokter
				FROM
					daftar_ulang_irj as a
				LEFT JOIN data_pasien as b ON a.no_medrec = b.no_medrec
				LEFT JOIN kontraktor as c ON a.id_kontraktor = c.id_kontraktor
				LEFT JOIN data_dokter as d ON a.id_dokter = d.id_dokter
				LEFT JOIN tni_kesatuan as e ON b.kst_id=e.kst_id
				LEFT JOIN tni_angkatan as f ON b.angkatan_id=f.tni_id
				LEFT JOIN tni_pangkat as g ON b.pkt_id=g.pangkat_id
				LEFT JOIN tni_kesatuan2 as h ON b.kst2_id=h.kst2_id
				LEFT JOIN tni_kesatuan3 as i ON b.kst3_id=i.kst3_id
				WHERE	
					a.no_register = '$no_register' ");
		}

		function getdata_daftar_ulang_pasien2($no_register){
			return $this->db->query("SELECT
					daftar_ulang_irj.no_register, daftar_ulang_irj.no_medrec, daftar_ulang_irj.id_poli
				FROM
					daftar_ulang_irj
				WHERE	
					daftar_ulang_irj.no_register = '$no_register'
				UNION SELECT pasien_iri.no_ipd, 
                             pasien_iri.no_cm as no_medrec,
                             pasien_iri.idrg as id_poli
                             from pasien_iri where pasien_iri.no_ipd='$no_register'");
		}

		function getdata_dokter_tindakan($no_register){
			return $this->db->query("SELECT id_dokter from pelayanan_poli where no_register='$no_register' and idtindakan like 'BD%' GROUP BY (no_register)");
		}

		function getdata_noteigd($no_register){
			return $this->db->query("SELECT
					*
				FROM note_igd a
				LEFT JOIN data_dokter as d ON a.id_dokter = d.id_dokter
				LEFT JOIN hmis_users as e ON a.id_perawat=e.username
				WHERE a.no_register = '$no_register'");
		}

		function update_waktu_masuk($no_register,$data_update){          
            $this->db->where('no_register',$no_register); 
            $this->db->update('daftar_ulang_irj', $data_update);
            return true;
        } 
        function set_utama_diagnosa($id_diagnosa_pasien,$no_register){          
            $this->db->trans_begin();		
			$this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='tambahan' WHERE klasifikasi_diagnos='utama' AND no_register = '$no_register'");
			$this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='utama' WHERE id_diagnosa_pasien = '$id_diagnosa_pasien' ");
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
			} else {
			    $this->db->trans_commit();
			} 
            return true;
        } 
        function set_utama_procedure($id){          
            $this->db->trans_begin();		
			$this->db->query("UPDATE icd9cm_irj SET klasifikasi_procedure='tambahan' WHERE klasifikasi_procedure = 'utama' WHERE no_register = '$no_register'");
			$this->db->query("UPDATE icd9cm_irj SET klasifikasi_procedure='utama' WHERE id = '$id' ");
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
			} else {
			    $this->db->trans_commit();
			} 
            return true;
        } 
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
		function getdata_tindakan_pasien($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='".$no_register."'  order by tgl_kunjungan desc");
		}

		function getdata_diagnosa_pasien($no_medrec){
			return $this->db->query("SELECT a.* FROM diagnosa_pasien as a LEFT JOIN daftar_ulang_irj as b ON a.no_register = b.no_register WHERE b.no_medrec = '".$no_medrec."'");
		}	

		function get_pasien_recorddiet($no_medrec){
			return $this->db->query("SELECT * FROM record_diet WHERE no_medrec =".$no_medrec." ORDER BY id DESC LIMIT 1");
		}

        function insert_procedure($data_insert){          
            $this->db->insert('icd9cm_irj', $data_insert);
            return true;
        }  

        function autocomplete_diagnosa($q){   
	        $query=$this->db->query("
	            SELECT * FROM icd1 WHERE id_icd LIKE '%$q%'
				UNION
				SELECT * FROM icd1 WHERE nm_diagnosa LIKE '%$q%' GROUP BY id_icd limit 50"
	        );
	        if($query->num_rows() > 0){
	          foreach ($query->result_array() as $row){
	            $new_row['label']=htmlentities(stripslashes($row['id_icd'].' - '.$row['nm_diagnosa']));
	            $new_row['value']=htmlentities(stripslashes($row['id_icd'].' - '.$row['nm_diagnosa']));
	            $new_row['id_icd']=htmlentities(stripslashes($row['id_icd']));
	            $new_row['nm_diagnosa']=htmlentities(stripslashes($row['nm_diagnosa']));	            
	            $row_set[] = $new_row; //build an array
	          }
	          echo json_encode($row_set); //format the array into json data
	        } else {        
	            echo json_encode([]);
	        }
	    }

	    function autocomplete_procedure($q){   
	        $query=$this->db->query("
	        		SELECT * FROM icd9cm WHERE id_tind LIKE '%$q%' 
	        		UNION 
	        		SELECT * FROM icd9cm WHERE nm_tindakan LIKE '%$q%' GROUP BY id_tind LIMIT 50"
	        );
	        if($query->num_rows() > 0){
	          foreach ($query->result_array() as $row){
	            $new_row['label']=htmlentities(stripslashes($row['id_tind'].' - '.$row['nm_tindakan']));
	            $new_row['value']=htmlentities(stripslashes($row['id_tind'].' - '.$row['nm_tindakan']));
	            $new_row['id_tind']=htmlentities(stripslashes($row['id_tind']));
	            $new_row['nm_tindakan']=htmlentities(stripslashes($row['nm_tindakan']));	            
	            $row_set[] = $new_row; //build an array
	          }
	          echo json_encode($row_set); //format the array into json data
	        } else {        
	            echo json_encode([]);
	        }
	    }

		private function diagnosa_query()  {
			$no_register = $this->input->post('no_register');
            $this->db->FROM('diagnosa_pasien');
            $this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'left');
            $this->db->where('diagnosa_pasien.no_register',$no_register);
            $this->db->select('diagnosa_pasien.diagnosa_text,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.id_diagnosa_pasien,diagnosa_pasien.id_diagnosa,diagnosa_pasien.diagnosa,daftar_ulang_irj.tgl_kunjungan');
        
            $i = 0;     
            foreach ($this->diagnosa_search as $item)
            {
                if($_POST['search']['value'])
                {
                     
                    if($i===0)
                    {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
     
                    if(count($this->diagnosa_search) - 1 == $i)
                        $this->db->group_end();
                }
		            $i++;
		        }
		         
		        if(isset($_POST['order'])) // here order processing
		        {
		            $this->db->order_by($this->diagnosa_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		        } 
		        else if(isset($this->default_order_diagnosa))
		        {
		            $order = $this->default_order_diagnosa;
		            $this->db->order_by(key($order), $order[key($order)]);
		        }
		  //  }
		} 

		private function _get_datatables_query()  {
			$no_register = $this->input->post('no_register');
            $this->db->FROM('icd9cm_irj');
            $this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'left');
            $this->db->where('icd9cm_irj.no_register',$no_register);
        
            $i = 0;     
            foreach ($this->procedure_search as $item)
            {
                if($_POST['search']['value'])
                {
                     
                    if($i===0)
                    {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
     
                    if(count($this->procedure_search) - 1 == $i)
                        $this->db->group_end();
                }
		            $i++;
		        }
		         
		        if(isset($_POST['order'])) // here order processing
		        {
		            $this->db->order_by($this->procedure_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		        } 
		        else if(isset($this->default_order_procedure))
		        {
		            $order = $this->default_order_procedure;
		            $this->db->order_by(key($order), $order[key($order)]);
		        }
		 //   }
		}    
 
        public function get_procedure_pasien()
        {
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
        
        public function get_diagnosa_pasien()
        {
            $this->diagnosa_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }  

        public function diagnosa_filtered()
        {
            $this->diagnosa_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function diagnosa_count_all()
        {
			$no_register = $this->input->post('no_register');
            $this->db->FROM('diagnosa_pasien');
            $this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'left');
            $this->db->where('diagnosa_pasien.no_register',$no_register);   
            return $this->db->count_all_results();
        }              
 
        public function procedure_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function procedure_count_all()
        {
			$no_register = $this->input->post('no_register');
            $this->db->FROM('icd9cm_irj');
            $this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'left');
            $this->db->where('icd9cm_irj.no_register',$no_register); 
            return $this->db->count_all_results();
        }	        
        
		public function count_utama_diagnosa($no_register)
        {        		
				$this->db->select('*');
				$this->db->from('diagnosa_pasien');
       			$this->db->where('klasifikasi_diagnos','utama');
       			$this->db->where('no_register',$no_register);
       			return $this->db->count_all_results();       			
		}
		public function count_utama_procedure($no_register)
        {        		
				$this->db->select('*');
				$this->db->from('icd9cm_irj');
       			$this->db->where('klasifikasi_procedure','utama');
       			$this->db->where('no_register',$no_register);
       			return $this->db->count_all_results();       			
		}
		/*function getdata_resep_pasien($no_register){
			$no_resep=$this->db->query("select max(no_resep) as no_resep from resep_header where no_resgister='$no_register'");
			
			if($no_resep->row()->no_resep!=''){
				$no_rsp=$no_resep->row()->no_resep;
				return $this->db->query("SELECT * FROM resep_pasien where no_register='$no_register' and no_resep='$no_rsp'");
			}else
				return $no_resep;			
		}*/
		////////////////////////////////////////////////////////////////////////////////////////////////////////////create update data pelayanan poli
		function get_rujukan_penunjang($no_register){
			return $this->db->query("SELECT lab, status_lab, jadwal_lab, pa, status_pa, rad, status_rad, obat, status_obat, ok, status_ok, fisio, status_fisio FROM daftar_ulang_irj WHERE no_register='$no_register'");
		}	
		function get_rujukan_penunjang_pending($no_register){
			return $this->db->query("SELECT rad, lab, pa, ok, fisio FROM pasien_luar WHERE no_register='$no_register'");
		}	

		function update_rujukan_penunjang($data4,$no_register){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data4);
			return true;
		}

		function update_rujukan_penunjang_poli($data4,$no_register,$jalan,$ugd){
			$this->db->where('no_register', $no_register);
			$kondisi='(idtindakan="'.$jalan.'" or idtindakan="'.$ugd.'")';
			$this->db->where($kondisi);	          
			$this->db->update('pelayanan_poli', $data4);
			return true;
							}
		function get_vtot($no_register){
			return $this->db->query("SELECT vtot FROM daftar_ulang_irj where no_register='".$no_register."'");
		}
		function update_vtot($data_vtot, $no_register){
			$this->db->where('no_register', $no_register);
			return $this->db->update('daftar_ulang_irj', $data_vtot);
		}
		function insert_tindakan($data){
			$this->db->insert('pelayanan_poli', $data);
			return $this->db->insert_id();
		}
		function update_tindakan($data,$id_pelayanan_poli){
			$this->db->where('id_pelayanan_poli', $id_pelayanan_poli);
			return $this->db->update('pelayanan_poli', $data);
		}

		function get_diag_pasien($no_register){
			$no_medrec=$this->db->query("SELECT no_medrec from daftar_ulang_irj where no_register='$no_register'");	
			print_r($no_medrec->row()->no_medrec);
			$no_cm=$no_medrec->row()->no_medrec;
			return $this->db->query("select a.no_register,a.no_medrec,b.id_diagnosa,a.tgl_kunjungan
from daftar_ulang_irj as a
left join diagnosa_pasien as b on a.no_register = b.no_register
where a.no_medrec='$no_cm'
group by b.id_diagnosa
order by a.no_register desc
limit 2");
		}
		function update_diag_daful($data,$no_register){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}
		function hapus_tindakan($id_pelayanan_poli){
			//$this->db->query("update daftar_ulang_irj set status='C' where no_register='$no_register'");
			$this->db->query("DELETE FROM pelayanan_poli WHERE id_pelayanan_poli='$id_pelayanan_poli'");
			return true;
		}
		function get_vtot_tindakan_sebelumnya($id_pelayanan_poli){
			return $this->db->query("SELECT vtot FROM pelayanan_poli where id_pelayanan_poli='".$id_pelayanan_poli."'");
		}
		function cek_diagnosa_utama($no_register){
			return $this->db->query("SELECT count(*) as jumlah FROM diagnosa_pasien WHERE klasifikasi_diagnos='utama' AND no_register='".$no_register."'");
		}
		function insert_diagnosa($data_insert){          
            $this->db->insert('diagnosa_pasien', $data_insert);
            return true;
        } 	        
		function update_diagnosa($id_diagnosa_pasien,$data){
			$this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
			$this->db->update('diagnosa_pasien', $data);
			return true;
		}
		function hapus_diagnosa($id_diagnosa_pasien){
			//$this->db->query("update daftar_ulang_irj set status='C' where no_register='$no_register'");
			$this->db->query("DELETE FROM diagnosa_pasien WHERE id_diagnosa_pasien='$id_diagnosa_pasien'");
			return true;
		}
		function hapus_procedure($id_procedure_pasien){
			$this->db->query("DELETE FROM icd9cm_irj WHERE id='$id_procedure_pasien'");
			return true;
		}

		//note IGD
		function insert_note_igd($data_insert){          
            $id=$this->db->insert('note_igd', $data_insert);
            //echo $this->db->last_query();
            return $id;
        } 		
        function update_note_igd($no_register,$data){
			$this->db->where('no_register', $no_register);
			$id=$this->db->update('note_igd', $data);
			//echo $this->db->last_query();
			return $id;
		}

		/*function insert_resep($data){
			$this->db->insert('resep_irj', $data);
			return $this->db->insert_id();
		}
		function update_resep($data,$id_resep_irj){
			$this->db->where('id_resep_irj', $id_resep_irj);
			$this->db->update('resep_irj', $data);
			return true;
		}*/
		////////////////////////////////////////////////////////////////////////////////////////////////////////////pulang / selesai pelayanan poli
		function update_pulang($data,$no_register){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}
		function getdata_daftar_sblm($no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj where no_register='$no_register'");
		}
		function get_status_sep($no_register){
			return $this->db->query("SELECT hapusSEP,cara_bayar,no_sep FROM daftar_ulang_irj where no_register='$no_register'")->row();
		}		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////data pasien u/ di webservice
		function getdata_pasien($no_medrec){
			return $this->db->query("SELECT * FROM data_pasien where no_medrec='$no_medrec'");
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////cek lab dan resep
		function cek_pa_lab_rad_resep($no_register){
			return $this->db->query("SELECT COALESCE(pa, 0) AS pa, COALESCE(status_pa, 0) AS status_pa, COALESCE(lab, 0) AS lab, COALESCE(status_lab, 0) AS status_lab, COALESCE(rad, 0) AS rad, COALESCE(status_rad, 0) AS status_rad, COALESCE(obat, 0) AS obat, COALESCE(status_obat, 0) AS status_obat,  COALESCE(ok, 0) AS ok, COALESCE(status_ok, 0) AS status_ok, COALESCE(fisio, 0) AS fisio, COALESCE(status_fisio, 0) AS status_fisio
										FROM 	daftar_ulang_irj 
										WHERE no_register='$no_register'");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////OBAT
		function get_no_resep($no_register){
			return $this->db->query("SELECT no_resep FROM resep_pasien WHERE no_register='$no_register' LIMIT 1");
		}
		function get_no_rad($no_register){
			return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi WHERE no_register='$no_register' LIMIT 1");
		}
		function get_no_lab($no_register){
			return $this->db->query("SELECT no_lab FROM pemeriksaan_laboratorium WHERE no_register='$no_register' LIMIT 1");
		}
		function get_no_pa($no_register){
			return $this->db->query("SELECT no_pa FROM pemeriksaan_patologianatomi WHERE no_register='$no_register' LIMIT 1");
		}
		function get_no_fisio($no_register){
			return $this->db->query("SELECT no_fisio FROM pemeriksaan_fisio WHERE no_register='$no_register' LIMIT 1");
		}
		function get_id_resep($no_resep){
			return $this->db->query("SELECT max(id_resep_pasien) AS id_resep_pasien FROM resep_pasien WHERE no_resep='$no_resep' LIMIT 1");
		}
		function get_data_permintaan($no_resep){
			return $this->db->query("SELECT id_resep_pasien, racikan, nama_obat,item_obat, biaya_obat, qty, cara_bayar, vtot FROM resep_pasien where no_resep='$no_resep'");
		}
		function get_detail_racikan($id_resep_pasien){
			return $this->db->query("SELECT * FROM obat_racikan LEFT JOIN master_obat ON item_obat=id_obat WHERE id_resep_pasien='$id_resep_pasien'");
		}
		function getdata_lab_pasien($no_medrec){
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
				WHERE a.no_medrec = '$no_medrec'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		// function getdata_lab_pasien($no_register){
		// 	return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
		// 		WHERE a.no_register = '$no_register'
		// 		AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
		// 		order by xupdate asc");
		// }
		
		// function getdata_ok_pasien($no_register){
		// 	return $this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak 
		// 		FROM pemeriksaan_operasi WHERE no_register='$no_register'");
		// }

		function getdata_ok_pasien($no_medrec){
			return $this->db->query("SELECT COALESCE( no_ok, 'On Progress' ) AS no_ok, po.id_pemeriksaan_ok, po.id_tindakan, po.jenis_tindakan, po.id_dokter, po.id_opr_anes, po.id_dok_anes, po.jns_anes, po.id_dok_anak, po.vtot, oh.tgl_jadwal_ok, ( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dokter ) AS nm_dokter, ( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_opr_anes ) AS nm_opr_anes, ( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anes ) AS nm_dok_anes, ( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anak ) AS nm_dok_anak FROM pemeriksaan_operasi po LEFT JOIN operasi_header oh ON oh.idoperasi_header = po.idoperasi_header WHERE no_medrec = '$no_medrec'");
		}

		// function getcetak_lab_pasien($no_register){
		// 	return $this->db->query("SELECT no_lab FROM pemeriksaan_laboratorium as a
		// 		WHERE a.no_register = '$no_register'
		// 		and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
		// 		and a.cetak_hasil='1'
		// 		group by no_lab
		// 		order by no_lab asc
		// 	");
		// }
		function getcetak_lab_pasien($no_medrec){
			return $this->db->query("SELECT no_lab FROM pemeriksaan_laboratorium as a
				WHERE a.no_medrec = '$no_medrec'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_lab
				order by no_lab asc
			");
		}

		// function getdata_fisio_pasien($no_register){
		// 	return $this->db->query("SELECT * FROM pemeriksaan_fisio as a
		// 		WHERE a.no_register = '$no_register'
		// 		AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
		// 		order by xupdate asc");
		// }

		function getdata_fisio_pasien($no_medrec){
			return $this->db->query("SELECT * FROM pemeriksaan_fisio as a
				WHERE a.no_medrec = '$no_medrec'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		
		// function getcetak_fisio_pasien($no_register){
		// 	return $this->db->query("SELECT no_fisio FROM pemeriksaan_fisio as a
		// 		WHERE a.no_register = '$no_register'
		// 		and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
		// 		and a.cetak_hasil='1'
		// 		group by no_fisio
		// 		order by no_fisio asc
		// 	");
		// }

		function getcetak_fisio_pasien($no_medrec){
			return $this->db->query("SELECT no_fisio FROM pemeriksaan_fisio as a
				WHERE a.no_medrec = '$no_medrec'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_fisio
				order by no_fisio asc
			");
		}

		// function getdata_pa_pasien($no_register){
		// 	return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi as a
		// 		WHERE a.no_register = '$no_register'
		// 		AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
		// 		order by xupdate asc");
		// }

		function getdata_pa_pasien($no_medrec){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi as a
				WHERE a.no_medrec = '$no_medrec'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		
		// function getcetak_pa_pasien($no_register){
		// 	return $this->db->query("SELECT no_pa FROM pemeriksaan_patologianatomi as a
		// 		WHERE a.no_register = '$no_register'
		// 		and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
		// 		and a.cetak_hasil='1'
		// 		group by no_pa
		// 		order by no_pa asc
		// 	");
		// }

		function getcetak_pa_pasien($no_medrec){
			return $this->db->query("SELECT no_pa FROM pemeriksaan_patologianatomi as a
				WHERE a.no_medrec = '$no_medrec'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_pa
				order by no_pa asc
			");
		}
		
		function get_medrec_pasienrad($no_register){
			return $this->db->query("SELECT no_medrec FROM daftar_ulang_irj WHERE no_register='$no_register'");
		}

		function getdata_rad_pasien($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
				WHERE a.no_register = '$no_register'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		function getdata_rad_pasienrj($no_medrecrad){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
				WHERE a.no_medrec = '$no_medrecrad'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		
		// function getcetak_rad_pasien($no_register){
		// 	return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi as a
		// 		WHERE a.no_register = '$no_register'
		// 		and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
		// 		and a.cetak_hasil='1'
		// 		group by no_rad
		// 		order by no_rad asc
		// 	");
		// }

		function getcetak_rad_pasien($no_medrec){
			return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi as a
				WHERE a.no_medrec = '$no_medrec'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_rad
				order by no_rad asc
			");
		}

		// function getdata_resep_pasien($no_register){
		// 	return $this->db->query("SELECT * FROM resep_pasien as a
		// 		WHERE a.no_register = '$no_register'
		// 		order by xupdate asc");
		// }

		function getdata_resep_pasien($no_medrec){
			return $this->db->query("SELECT * FROM resep_pasien as a
				WHERE a.no_medrec = '$no_medrec'
				order by xupdate asc");
		}
		//AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))

		// function getcetak_resep_pasien($no_register){
		// 	return $this->db->query("SELECT no_resep FROM resep_pasien as a
		// 		WHERE a.no_register = '$no_register'				
		// 		group by no_resep
		// 		order by no_resep asc

		// 	");
		// }
		function getcetak_resep_pasien($no_medrec){
			return $this->db->query("SELECT no_resep FROM resep_pasien as a
				WHERE a.no_medrec = '$no_medrec'				
				group by no_resep
				order by no_resep asc

			");
		}
		function getdata_tindakan_fisik($no_register){
			return $this->db->query("SELECT tb, td, bb, suhu, rr, nadi, catatan FROM pemeriksaan_fisik where no_register='".$no_register."'");
		}
		function insert_data_fisik($data){
			$this->db->insert('pemeriksaan_fisik', $data);
			return true;
		}
		function update_data_fisik($no_register, $data){
			$this->db->where('no_register', $no_register);
			$this->db->update('pemeriksaan_fisik', $data);
			return true;
		}

	function show_procedure($id_icd9cm) {
        $this->db->FROM('icd9cm_irj'); 
        $this->db->where('id', $id_icd9cm);
        $query = $this->db->get();
        return $query->row();
    } 
	function show_diagnosa($id_diagnosa_pasien) {
        $this->db->FROM('diagnosa_pasien'); 
        $this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
        $query = $this->db->get();
        return $query->row();
    }     	
	function update_procedure($id_icd9cm,$data_update){
		$this->db->where('id', $id_icd9cm);
		$this->db->update('icd9cm_irj', $data_update);
		return true;
	} 
	function diagnosa_baru($no_register,$diagnosa_baru){
		$this->db->where('no_register', $no_register);
		$this->db->update('daftar_ulang_irj', $diagnosa_baru);
		return true;
	} 

	}
?>
