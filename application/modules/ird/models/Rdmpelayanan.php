<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rdmpelayanan extends CI_Model{
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
				// if($pok_tindak=='BK00' || $pok_tindak=='BK01' || $pok_tindak=='BQ01' || $pok_tindak=='BQ02'){
				// 	return $this->db->query("SELECT * FROM (SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
				// 			LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
				// 			WHERE left(a.idtindakan,2)='1B' and kelas='III' 
				// 			UNION
				// 			SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
				// 			LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
				// 			WHERE idpok2='AA' and kelas='III' 
				// 			UNION 
				// 			SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
				// 			LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
				// 			WHERE left(b.id_tindakan,2)=left('$pok_tindak',2) and kelas='III'
				// 			) AS C
				// 			ORDER BY idtindakan ASC ");
				// }else{
					return $this->db->query(
						    // "SELECT * FROM (SELECT a.*, b.total_tarif FROM jenis_tindakan AS a 
							// LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
							// WHERE left(a.idtindakan,2)='1B' and kelas='$kelas'  
							// UNION 
							"SELECT a.*, b.total_tarif, b.tarif_iks FROM jenis_tindakan AS a 
							LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan 
							WHERE left(b.id_tindakan,4)=left('$pok_tindak',4)  and kelas='$kelas' and a.deleted != 1 
							ORDER BY idtindakan ASC ");					
				// }			
				
		}
		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif, tarif_alkes, tarif_iks, tarif_bpjs FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}
		function get_dokter_poli($id_poli){

			if($id_poli !=' BA00'){
				//return $this->db->query("SELECT dd.* FROM data_dokter AS dd
				//LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter
				//WHERE dp.id_poli='$id_poli'
				//and dd.deleted='0'
				//or dd.ket='Perawat'
				//ORDER BY nm_dokter;");
				return $this->db->query("SELECT a.* FROM data_dokter a, dokter_poli b where a.id_dokter = b.id_dokter and a.deleted = '0' and b.id_poli = '$id_poli'");
			}
			else{
				return $this->db->query("SELECT dd.*  
					FROM
					    data_dokter AS dd, dokter_poli as dp
					WHERE
					    dd.id_dokter =  dp.id_dokter
					    dp.id_poli = '$id_poli'
					        AND dd.deleted = '0'
					ORDER BY dd.nm_dokter) 
					UNION ALL 
					(SELECT 
					    dd.*
					FROM
					    data_dokter AS dd
					WHERE
					    dd.ket LIKE '%Dokter Jaga%'
					        OR dd.ket LIKE '%Dokter Residen%'
					        AND dd.deleted = '0'
					ORDER BY nm_dokter)) as a where deleted='0'");
								
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
					    data_dokter AS dd,
					    dokter_poli AS dp 
					WHERE  dd.id_dokter = dp.id_dokter
					  AND dp.id_poli = '$id_poli'
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
					ORDER BY nm_dokter)) as a");
								}	
							}

		function get_dokter_poli_BQ00(){
			return $this->db->query("SELECT dd.* FROM data_dokter AS dd LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter WHERE id_poli='BQ00' or dd.ket='Dokter Jaga' or ket = 'Umum' and dd.deleted='0' or dd.ket='Perawat' ORDER BY nm_dokter");			
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
			}else{
				$this->db->query("UPDATE daftar_ulang_irj SET status='1', ket_pulang='BATAL_PELAYANAN_POLI' WHERE no_register='$no_register'");
			}
			//$this->db->query("DELETE FROM pelayanan_poli WHERE no_register='$no_register'");
			return true;
		}
		//////////////////////////////////////getdata_daftar_ulang_pasien//////////////////////////////////////////////////////////////////////data pasien u/ di transaksi pelayanan
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
			a.*,b.*,c.nmkontraktor,d.nm_dokter as dokter,e.userid as iduser
		FROM
			daftar_ulang_irj as a
		LEFT JOIN data_pasien as b ON a.no_medrec = b.no_medrec
		LEFT JOIN kontraktor as c ON a.id_kontraktor = c.id_kontraktor
		LEFT JOIN data_dokter as d ON a.id_dokter = d.id_dokter
		LEFT JOIN poliklinik as poli ON poli.id_poli = a.id_poli
		LEFT JOIN dyn_user_dokter as e ON e.id_dokter = a.id_dokter
		WHERE	
			a.no_register = '$no_register' ");
		}

		function getdata_daftar_ulang_pasien_ird($no_register){
			return $this->db->query("SELECT
			a.*,b.*,c.nmkontraktor,d.nm_dokter as dokter,e.userid as iduser
		FROM
			daftar_ulang_irj as a
		LEFT JOIN data_pasien as b ON a.no_medrec = b.no_medrec
		LEFT JOIN kontraktor as c ON a.id_kontraktor = c.id_kontraktor
		LEFT JOIN data_dokter as d ON a.id_dokter = d.id_dokter
		LEFT JOIN poliklinik as poli ON poli.id_poli = a.id_poli
		LEFT JOIN dyn_user_dokter as e ON e.id_dokter = a.id_dokter
		WHERE	
			a.no_register = '$no_register' and a.id_poli = 'BA00'");
		}

		function getdata_daftar_ulang_pasien2($no_register){
			return $this->db->query("SELECT
					daftar_ulang_irj.no_register, daftar_ulang_irj.no_medrec, daftar_ulang_irj.id_poli
				FROM
					daftar_ulang_irj
				WHERE	
					daftar_ulang_irj.no_register = '$no_register'
				-- UNION SELECT pasien_iri.no_ipd, 
                            --  pasien_iri.no_cm as no_medrec,
                            --  pasien_iri.idrg as id_poli
                            --  from pasien_iri where pasien_iri.no_ipd='$no_register'
							");
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
			return $this->db->query("SELECT a.*,  
				b.id_poli AS poli
			FROM 
				pelayanan_poli AS a
				LEFT JOIN daftar_ulang_irj AS b ON a.no_register = b.no_register
			where 
				a.no_register='".$no_register."'  
			order by a.tgl_kunjungan desc");
		}

		function insert_data_fisik_live($data){
			$this->db->insert('pemeriksaan_fisik', $data);
			return true;
		}

		function update_data_fisik_live($no_register,$data){
			$this->db->where('no_register',$no_register);
			$this->db->update('pemeriksaan_fisik', $data);
			return true;
		}

		function cek_tindakan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_fisik WHERE no_register='".$no_register."'");
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
			$query=$this->db->query("SELECT 
				* 
			FROM 
				icd1 
			WHERE 
				upper(id_icd) LIKE upper('%$q%') AND deleted != 1 UNION
			SELECT 
				* 
			FROM 
				icd1 
			WHERE 
				nm_diagnosa ~* '$q' AND deleted != 1  LIMIT 50");

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
	        		SELECT * FROM icd9cm WHERE upper(id_tind) LIKE upper('%$q%')
	        		UNION 
	        		SELECT * FROM icd9cm WHERE upper(nm_tindakan) LIKE upper('%$q%') limit 10"
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
			return $this->db->query("SELECT lab, status_lab, jadwal_lab, pa, status_pa, rad, status_rad, obat, status_obat, ok, status_ok, fisio, status_fisio, em, status_em,utdrs,status_utdrs FROM daftar_ulang_irj WHERE no_register='$no_register'");
		}	
		function get_rujukan_penunjang_pending($no_register){
			return $this->db->query("SELECT rad, lab, pa, ok, fisio, em FROM pasien_luar WHERE no_register='$no_register'");
		}	

		function update_rujukan_penunjang($data4,$no_register){
			$this->db->where('no_register', $no_register);
			
			return $this->db->update('daftar_ulang_irj', $data4);
		}

		function update_rujukan_penunjang_new($no_register){
			return $this->db->query("update daftar_ulang_irj set obat = 1, waktu_resep_dokter = now() where no_register = '$no_register'");
		}

		function update_rujukan_penunjang_poli($data4,$no_register,$jalan,$ugd){
			$this->db->where('no_register', $no_register);
			// $kondisi='(idtindakan="'.$jalan.'" or idtindakan="'.$ugd.'")';
			$this->db->where('idtindakan',$jalan);
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

		function insert_tindakan1($data){
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
			return $this->db->query("SELECT \"hapusSEP\",cara_bayar,no_sep,poli_ke FROM daftar_ulang_irj where no_register='$no_register'")->row();
		}		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////data pasien u/ di webservice
		function getdata_pasien($no_medrec){
			return $this->db->query("SELECT * FROM data_pasien where no_medrec='$no_medrec'");
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////cek lab dan resep
		function cek_pa_lab_rad_resep($no_register){
			return $this->db->query("SELECT COALESCE(pa, 0) AS pa, COALESCE(status_pa, 0) AS status_pa, COALESCE(lab, 0) AS lab, COALESCE(status_lab, 0) AS status_lab, COALESCE(rad, 0) AS rad, COALESCE(status_rad, 0) AS status_rad, COALESCE(obat, 0) AS obat, COALESCE(status_obat, 0) AS status_obat,  COALESCE(ok, 0) AS ok, COALESCE(status_ok, 0) AS status_ok, COALESCE(fisio, 0) AS fisio, COALESCE(status_fisio, 0) AS status_fisio, COALESCE(em, 0) AS em, COALESCE(status_em, 0) AS status_em
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
		function get_no_em($no_register){
			return $this->db->query("SELECT no_em FROM pemeriksaan_elektromedik WHERE no_register='$no_register' LIMIT 1");
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
		function getdata_lab_pasien($no_register,$datenow){
			// return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
			// 	WHERE a.no_register = '$no_register'
			// 	AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
			// 	order by xupdate asc");
				// return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
				// WHERE a.no_register = '$no_register' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' 
				// ");
				return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
				WHERE a.no_register = '$no_register' 
				");
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

		function getdata_ok_pasien($no_register,$datenow){
			// return $this->db->query("SELECT po.no_ok, 
			// 	po.id_pemeriksaan_ok, po.id_tindakan, po.jenis_tindakan, po.id_dokter, po.id_opr_anes, 
			// 	po.id_dok_anes, po.jns_anes, po.id_dok_anak, po.vtot, oh.tgl_jadwal_ok, 
			// 	( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dokter ) AS nm_dokter, 
			// 	( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_opr_anes ) AS nm_opr_anes, 
			// 	( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anes ) AS nm_dok_anes, 
			// 	( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anak ) AS nm_dok_anak 
			// 	FROM pemeriksaan_operasi po LEFT JOIN operasi_header oh ON oh.idoperasi_header = po.idoperasi_header  
			// 	WHERE no_medrec = '$no_medrec'");

				// return $this->db->query("SELECT po.no_ok, 
				// po.id_pemeriksaan_ok, po.id_tindakan, po.jenis_tindakan, po.id_dokter, po.id_opr_anes, 
				// po.id_dok_anes, po.jns_anes, po.id_dok_anak, po.vtot, oh.tgl_jadwal_ok, 
				// ( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dokter ) AS nm_dokter, 
				// ( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_opr_anes ) AS nm_opr_anes, 
				// ( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anes ) AS nm_dok_anes, 
				// ( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anak ) AS nm_dok_anak 
				// FROM pemeriksaan_operasi po LEFT JOIN operasi_header oh ON oh.idoperasi_header = po.idoperasi_header  
				// WHERE no_medrec = '$no_medrec'");

				// fixed for  : more than one row returned by a subquery used as an expression
				return $this->db->query("SELECT po.no_ok, po.id_pemeriksaan_ok, po.id_tindakan, po.jenis_tindakan, po.id_dokter,
				po.id_opr_anes, po.id_dok_anes, po.jns_anes, po.id_dok_anak, po.vtot, oh.tgl_jadwal_ok, 
				( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dokter LIMIT 1) AS nm_dokter, 
				( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_opr_anes LIMIT 1) AS nm_opr_anes, 
				( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anes LIMIT 1) AS nm_dok_anes,
				( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anak  LIMIT 1) AS nm_dok_anak 
				FROM pemeriksaan_operasi po LEFT JOIN operasi_header oh ON oh.idoperasi_header = po.idoperasi_header 
				WHERE po.no_register = '$no_register' and to_char(po.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' ");
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
		function getcetak_lab_pasien($no_register){
			return $this->db->query("SELECT no_lab FROM pemeriksaan_laboratorium as a
				WHERE a.no_register = '$no_register'
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
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi is null AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		function getdata_rad_pasienrj($no_register,$datenow){
			// return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
			// 	WHERE a.no_register = '$no_register'
			// 	AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi is null AND a.cara_bayar<>'UMUM'))
			// 	order by xupdate asc");
				// return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
				// WHERE a.no_register = '$no_register' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' 
				// ");
				return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
				WHERE a.no_register = '$no_register' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
				");
		}

		function getdata_em_pasienrj($no_register,$datenow){
				return $this->db->query("SELECT * FROM pemeriksaan_elektromedik as a
				WHERE a.no_register = '$no_register' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
				");
				// return $this->db->query("SELECT * FROM pemeriksaan_elektromedik as a
				// WHERE a.no_register = '$no_register' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' 
				// ");
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

		function getcetak_rad_pasien($no_register){
			return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_rad
				order by no_rad asc
			");
		}

		function getcetak_em_pasien($no_register){
			return $this->db->query("SELECT no_em FROM pemeriksaan_elektromedik as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_em
				order by no_em asc
			");
		}

		// function getdata_resep_pasien($no_register){
		// 	return $this->db->query("SELECT * FROM resep_pasien as a
		// 		WHERE a.no_register = '$no_register'
		// 		order by xupdate asc");
		// }

		function getdata_resep_pasien($no_register,$datenow){
			return $this->db->query("SELECT * FROM resep_pasien as a
				WHERE a.no_register = '$no_register' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' 
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
		function getcetak_resep_pasien($no_register){
			return $this->db->query("SELECT no_resep FROM resep_pasien as a
				WHERE a.no_register = '$no_register'				
				group by no_resep
				order by no_resep asc

			");
		}
		function getdata_tindakan_igd($no_register)
	{
		return $this->db->query("SELECT *
		                         FROM assesment_medik_igd 
		                         where no_register='" . $no_register . "'");
	}
	function getdata_tindakan_fisik($no_register)
	{
		return $this->db->query("SELECT *
		                         FROM pemeriksaan_fisik
		                         where no_register='" . $no_register . "'");
	}
	function getdata_assesment($no_register)
	{
		return $this->db->query("SELECT *
		                         FROM asesment_masalah_keperawatan 
		                         where no_register='" . $no_register . "'");
	}

	function getdata_keperawatan($no_register)
	{
		return $this->db->query("SELECT *
		                         FROM asesment_masalah_keperawatan 
		                         where no_register='" . $no_register . "'");
	}

		function insert_assesment($data){
			return $this->db->insert('asesment_masalah_keperawatan',$data);
			// var_dump($data);
		}

		function update_assesment($no_register,$data){
			$this->db->where('no_register', $no_register);
			$this->db->update('asesment_masalah_keperawatan', $data);
			return true;
		}

		function getdata_tindakan_assesment($no_register){
			return $this->db->query("SELECT * FROM asesment_masalah_keperawatan WHERE no_register = '".$no_register."'");
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
		function insert_data_igd($data){
			$this->db->insert('assesment_medik_igd', $data);
			return true;
		}
		function update_data_igd($no_register, $data){
			$this->db->where('no_register', $no_register);
			$this->db->update('assesment_medik_igd', $data);
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

	function getJsonFormAssesment($no_register){
		$a = $this->db->query("SELECT formjson FROM pemeriksaan_fisik WHERE no_register='$no_register'")->result();
		$b = '';
		foreach($a as $val){
			$b = $val->formjson;
		}
		echo $b;
	}

	function get_v_data_kontrol($no_register= ''){
		if($no_register !=''){
			return $this->db->query("SELECT * FROM v_surat_kontrol
			WHERE no_register = '$no_register'")->result();
		}else{
			return $this->db->query("SELECT * FROM v_surat_kontrol")->result();
		}
	}

	public function get_data_asesmen_keperawatan($no_reg){
		return $this->db->query("SELECT 
				a.*,
				TO_CHAR( a.tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl,
				b.* 
			FROM
				daftar_ulang_irj
				AS a JOIN pemeriksaan_fisik AS b ON a.no_register = b.no_register 
			WHERE
				a.no_register = '$no_reg'");
	}

	public function get_data_asesmen_masalah_keperawatan($no_reg){
		return $this->db->query("SELECT 
				* 
			FROM
				asesment_masalah_keperawatan
			WHERE
				no_register = '$no_reg'");
	}
	

	function get_data_pasien_by_no_cm($no_cm){
		//return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm='$no_cm'");
		return $this->db->query("SELECT *, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_cm = '$no_cm'");
	}

	function getdata_record_pasien_by_no_reg($no_reg){
		return $this->db->query("SELECT a.*,
				a.no_register as noregister,
				TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
				a.id_dokter,
				b.nm_dokter AS dokter,
				c.nm_poli AS poli,
				d.diagnosa AS diagnosa 
			FROM
				daftar_ulang_irj
				AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
				LEFT JOIN diagnosa_pasien AS d ON a.no_register = d.no_register 
			WHERE
				a.no_register = '$no_reg'");
	}
	public function get_data_asesmen_keperawatan_ird($no_reg)
	{
		return $this->db->query(
			"SELECT 
			a.no_register,
			TO_CHAR( a.tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl,
			b.* 
		FROM
			daftar_ulang_irj
			AS a JOIN assesment_keperawatan_ird AS b ON a.no_register = b.no_register 
		WHERE
			a.no_register = '$no_reg'"
		);
	}

	function get_pemeriksaan_fisik($no_register = ''){
		if($no_register != ''){
			return $this->db->query("SELECT a.*,
			b.id_dokter,
			b.tgl_kontrol,
			c.nm_dokter AS dokter
			FROM pemeriksaan_fisik AS a
			LEFT JOIN daftar_ulang_irj AS b
			ON b.no_register = a.no_register
			LEFT JOIN data_dokter AS  c
			ON c.id_dokter = b.id_dokter
			WHERE a.no_register='$no_register'")->result();
		}
		return $this->db->query("SELECT * FROM pemeriksaan_fisik")->result();
	}

	// added insert konsul dokter

	function insert_konsul_dokter($data){
		return $this->db->insert('konsul_dokter',$data);
	}

	// added insert jawaban konsul

	function insert_jawaban_konsul($data){
		return $this->db->insert('jawaban_konsul',$data);
	}



	function get_data_daftar_ulang_by_no_reg($no_register){
		//return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm='$no_cm'");
		return $this->db->query("SELECT * FROM daftar_ulang_irj where no_register = '$no_register'");
	}

	function get_data_pasien_by_no_medrec($no_medrec){
		return $this->db->query("SELECT *, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_medrec = '$no_medrec'");
	}

	function get_data_konsul_by_noreg($no_register){		
		return $this->db->query("SELECT * FROM konsul_dokter where no_register = '$no_register'");
	}

	function get_data_dokter_by_konsul($id_dokter){		
		return $this->db->query("SELECT * FROM data_dokter where id_dokter = '$id_dokter'");
	}

	function get_data_poli_by_konsul($id_poli){		
		return $this->db->query("SELECT * FROM poliklinik where id_poli = '$id_poli'");
	}
	
	function get_data_jawab_konsul_by_noreg($no_register){		
		return $this->db->query("SELECT * FROM jawaban_konsul where no_register_lama = '$no_register'");
	}

	function insert_assesment_gigi($data)
	{
		return $this->db->insert('assesment_gigi',$data);
		// var_dump($data);
	}

	function update_assesment_gigi($data)
	{
		$this->db->where('no_register',$data['no_register']); 
		$this->db->update('assesment_gigi', $data);
		return true;
	}

	function load_data_assesment_gigi_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM assesment_gigi WHERE no_register='$no_reg'")->result();
	}

	function get_assesment_medik_igd_bynoreg($no_reg)
	{
		return $this->db->query("SELECT * FROM assesment_medik_igd WHERE no_register='$no_reg'")->result();
	}

	function insert_triase($data)
	{
		return $this->db->insert('triase_igd',$data);

	}

	function update_triase($data)
	{
		$this->db->where('no_register',$data['no_register']); 
		$this->db->update('triase_igd', $data);
		return true;
	}

	function get_triase_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM triase_igd where no_register='$no_reg'");
	}

	function get_assesment_keperawatan_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM assesment_keperawatan_ird where no_register='$no_reg'");
	}

	function update_assesment_keperawatan_ird($data,$noreg)
	{
		$this->db->where('no_register',$noreg);
		$this->db->update('assesment_keperawatan_ird',$data);
		return true;
	}

	function insert_assesment_keperawatan_ird($data)
	{
		return $this->db->insert('assesment_keperawatan_ird',$data);
	}
	function get_kode_document($kode_akses)
		{
			return $this->db->query("SELECT * FROM kode_document WHERE kode_akses='$kode_akses'");
		}

	function get_soappasienrj_bynoreg($noreg)
	{
		return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='$noreg'");
	}

	function insert_soap_pasien($data)
	{
		return $this->db->insert('soap_pasien_rj',$data);
	}

	function update_soap_pasien($data,$noreg)
	{
		$this->db->where('no_register',$noreg);
		$this->db->update('soap_pasien_rj',$data);
		return true;
	}

	function insert_tindakan_resep_pasien_ird($data)
	{
		return $this->db->insert('tindakan_resep_pasien_ird',$data);
	}

	function check_cppt_pasien($noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->get('soap_pasien_rj');
	}

	function update_cppt_igd($data,$noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->update('soap_pasien_rj',$data);
	}

	function update_cppt($data,$noreg)
	{
		$this->db->where('no_register',$noreg);
		$this->db->where('id',$data['id']);
		return $this->db->update('soap_pasien_rj',$data);
	}

	function insert_cppt($data)
	{
		return $this->db->insert('soap_pasien_rj',$data);
	}

	function check_transfer_ruangan($noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->get('transfer_ruangan');
	}

	function insert_transfer_ruangan($data)
	{
		return $this->db->insert('transfer_ruangan',$data);
	}
	function update_transfer_ruangan($data,$noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->update('transfer_ruangan',$data);
	}

	function get_diagnosa_pasien_noreg($noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->get('diagnosa_pasien');
	}

	function check_serah_terima_no_medrec($no_medrec)
	{
		$this->db->where('no_medrec',$no_medrec);
		return $this->db->get('serah_terima');
	}
	function check_serah_terima($noreg, $role)
	{
		$this->db->where('no_register', $noreg);
		$this->db->where('role', $role);
		return $this->db->get('serah_terima');
	}

	function insert_serah_terima($data)
	{
		return $this->db->insert('serah_terima', $data);
	}
	function update_serah_terima($data, $noreg, $role)
	{
		$this->db->where('no_register', $noreg);
		$this->db->where('role', $role);
		return $this->db->update('serah_terima', $data);
	}

	function check_penilaian_fungsional_status($noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->get('penilaian_fungsional_status');
	}

	function insert_penilaian_fungsional_status($data)
	{
		return $this->db->insert('penilaian_fungsional_status',$data);
	}
	function update_penilaian_fungsional_status($data,$noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->update('penilaian_fungsional_status',$data);
	}

	function check_skrining_covid($noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->get('skrining_covid_igd');
	}

	function insert_skrining_covid_igd($data)
	{
		return $this->db->insert('skrining_covid_igd',$data);
	}

	function update_skrining_covid_igd($data,$noreg)
	{
		$this->db->where('no_register',$noreg);
		return $this->db->update('skrining_covid_igd',$data);
	}

	function get_nama_pasien($medrec) {
		return $this->db->query("SELECT a.nama
		FROM data_pasien AS a
		INNER JOIN daftar_ulang_irj AS b ON a.no_medrec = b.no_medrec
		WHERE b.no_medrec = '$medrec'");
	}

	function get_data_pasien_igd($id) {
		return $this->db->query("SELECT 
			a.cara_bayar,
			a.no_register,
			A.id_kontraktor,
			(SELECT nmkontraktor FROM kontraktor WHERE a.id_kontraktor = id_kontraktor LIMIT 1) AS nmkontraktor 
		FROM
			daftar_ulang_irj AS A
		WHERE
			 a.no_register = '$id'");
	}

	public function get_kontraktor() {
		return $this->db->query("SELECT id_kontraktor, nmkontraktor FROM kontraktor WHERE bpjs != 'BPJS'");
	}

	public function get_kontraktor_bpjs() {
		return $this->db->query("SELECT id_kontraktor, nmkontraktor FROM kontraktor WHERE bpjs = 'BPJS'");
	}

	function update_cara_bayar($data, $no_register) {
		$this->db->where('no_register', $no_register);
		$this->db->update('daftar_ulang_irj', $data);
		return true;
	}

	function get_surveilans_irj($no_register) {
		return $this->db->query("SELECT * FROM surveilans_ri WHERE no_ipd = '$no_register'");
	}

	function get_laporan_anestesi_by_noreg($no_register) {
		return $this->db->query("SELECT * FROM laporan_anestesi WHERE no_ipd = '$no_register'");
	}

	function get_laporan_operasi_by_noreg($no_register) {
		return $this->db->query("SELECT * FROM laporan_operasi WHERE no_ipd = '$no_register'");
	}

	function get_checklist_persiapan_operasi_by_noreg($no_register) {
		return $this->db->query("SELECT * FROM checklist_persiapan_operasi WHERE no_ipd = '$no_register'");
	}

	function insert_pengkajian_medis_igd($data)
	{
		return $this->db->insert('pengkajian_medis_igd', $data);
	}

	function get_pengkajian_medis_igd($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_medis_igd where no_register='$noreg'");
	}

	function update_pengkajian_medis_igd($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('pengkajian_medis_igd', $data);
	}

	function get_lab_for_pengkajian_medis($noreg)
	{
		return $this->db->query("SELECT jenis_tindakan FROM pemeriksaan_laboratorium where no_register = '$noreg'");
	}

	function get_rad_for_pengkajian_medis($noreg)
	{
		return $this->db->query("SELECT jenis_tindakan FROM pemeriksaan_radiologi where no_register = '$noreg'");
	}

	function get_diag_for_pengkajian_medis($noreg)
	{
		return $this->db->query("SELECT id_diagnosa,diagnosa,klasifikasi_diagnos FROM diagnosa_pasien where no_register = '$noreg'");
	}

	function insert_triase_igd($data)
	{
		return $this->db->insert('triase_igd', $data);
	}

	function get_triase_igd($noreg)
	{
		return $this->db->query("SELECT * FROM triase_igd where no_register='$noreg'");
	}

	function update_triase_igd($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('triase_igd', $data);
	}

	function insert_ringkasan_pulang_igd($data)
	{
		return $this->db->insert('ringkasan_pulang_igd', $data);
	}

	function get_ringkasan_pulang_igd($noreg)
	{
		return $this->db->query("SELECT * FROM ringkasan_pulang_igd where no_register='$noreg'");
	}

	function update_ringkasan_pulang_igd($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('ringkasan_pulang_igd', $data);
	}

	function insert_formulir_skrining($data)
	{
		return $this->db->insert('formulir_skrining', $data);
	}

	function get_formulir_skrining($noreg)
	{
		return $this->db->query("SELECT * FROM formulir_skrining where no_register='$noreg'");
	}

	function update_formulir_skrining($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('formulir_skrining', $data);
	}

	function insert_pengantar_rawat_inap($data)
	{
		return $this->db->insert('pengantar_rawat_inap', $data);
	}

	function get_pengantar_rawat_inap($noreg)
	{
		return $this->db->query("SELECT * FROM pengantar_rawat_inap where no_register='$noreg'");
	}

	function update_pengantar_rawat_inap($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('pengantar_rawat_inap', $data);
	}

	function insert_surat_keterangan_kematian($data)
	{
		return $this->db->insert('surat_keterangan_kematian', $data);
	}

	function get_surat_keterangan_kematian($noreg)
	{
		return $this->db->query("SELECT * FROM surat_keterangan_kematian where no_register='$noreg'");
	}

	function update_surat_keterangan_kematian($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('surat_keterangan_kematian', $data);
	}

	function get_surat_rujukan($noreg)
	{
		return $this->db->query("SELECT * FROM surat_rujukan_pasien where no_register='$noreg'");
	}

	function get_penolakan_medik($noreg)
	{
		return $this->db->query("SELECT * FROM penolakan_tindakan_medik where no_register='$noreg'");
	}
	function get_persetujuan_medik($noreg)
	{
		return $this->db->query("SELECT * FROM persetujuan_tindakan_medik where no_register='$noreg'");
	}

	function get_resep_for_pengkajian_medis($noreg)
	{
		return $this->db->query("SELECT nm_obat,signa FROM resep_dokter where no_register = '$noreg'");
	}


	function getdata_jenis_tindakan_new($id_poli)
	{

		return $this->db->query("SELECT * FROM jenis_tindakan_new where id_poli = '$id_poli' or id_poli is null order by nmtindakan asc");
	}

	function getdata_jenis_tindakan_new_by_id($id)
	{

		return $this->db->query("SELECT * FROM jenis_tindakan_new where idtindakan = '$id'");
	}


	function insert_cuti_perawatan_new($data)
	{
		return $this->db->insert('cuti_perawatan_new', $data);
	}

	function get_cuti($noreg)
	{
		return $this->db->query("SELECT * FROM cuti_perawatan_new where no_register='$noreg'");
	}

	function update_cuti_perawatan_new($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('cuti_perawatan_new', $data);
	}

	function insert_penundaan_pelayanan($data)
	{
		return $this->db->insert('penundaan_pelayanan', $data);
	}

	function get_penundaan_pelayanan($noreg)
	{
		return $this->db->query("SELECT * FROM penundaan_pelayanan where no_register='$noreg'");
	}

	function update_penundaan_pelayanan($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('penundaan_pelayanan', $data);
	}
	
	function get_observasi($noreg)
	{
		return $this->db->query("SELECT * FROM observasi where no_register='$noreg'");
	}

	function insert_observasi($data)
	{
		return $this->db->insert('observasi', $data);
	}

	function update_observasi($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('observasi', $data);
	}

	//09-10-2024
	function get_keperawatan_ponek($noreg)
	{
		return $this->db->query("SELECT * FROM keperawatan_ponek where no_register='$noreg'");
	}

	function insert_keperawatan_ponek($data)
	{
		return $this->db->insert('keperawatan_ponek', $data);
	}

	function update_keperawatan_ponek($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('keperawatan_ponek', $data);
	}

	function get_edukasi_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM edukasi_pasien where no_register='$noreg'");
	}

	function insert_edukasi_pasien($data)
	{
		return $this->db->insert('edukasi_pasien', $data);
	}

	function update_edukasi_pasien($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('edukasi_pasien', $data);
	}

	function insert_permintaan_transfusi_darah($data)
	{
		return $this->db->insert('permintaan_transfusi_darah', $data);
	}

	function get_permintaan_transfusi_darah($noreg)
	{
		return $this->db->query("SELECT * FROM permintaan_transfusi_darah where no_register='$noreg'");
	}

	function update_permintaan_transfusi_darah($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('permintaan_transfusi_darah', $data);
	}
	function getdata_form_json($noreg)
	{
		return $this->db->query("SELECT
				formjson ->> 'rencana' AS rencana
			FROM
				pengkajian_medis_igd where no_register = '$noreg'
		");
	}

	function insert_triase_igd_ponek($data)
	{
		return $this->db->insert('triase_igd_ponek', $data);
	}

	function get_triase_igd_ponek($noreg)
	{
		return $this->db->query("SELECT * FROM triase_igd_ponek where no_register='$noreg'");
	}

	function update_triase_igd_ponek($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('triase_igd_ponek', $data);
	}

	function insert_pengkajian_keperawatan_ponek($data)
	{
		return $this->db->insert('pengkajian_kep_ponek', $data);
	}

	function get_pengkajian_keperawatan_ponek($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_kep_ponek where no_register='$noreg'");
	}

	function update_pengkajian_keperawatan_ponek($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('pengkajian_kep_ponek', $data);
	}

	function insert_medis_igd_ponek($data)
	{
		return $this->db->insert('medis_igd_ponek', $data);
	}

	function get_medis_igd_ponek($noreg)
	{
		return $this->db->query("SELECT * FROM medis_igd_ponek where no_register='$noreg'");
	}

	function update_medis_igd_ponek($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('medis_igd_ponek', $data);
	}
	function insert_resiko_jatuh_ponek($data)
	{
		return $this->db->insert('resiko_jatuh_ponek', $data);
	}

	function get_resiko_jatuh_ponek($noreg)
	{
		return $this->db->query("SELECT * FROM resiko_jatuh_ponek where no_register='$noreg'");
	}

	function update_resiko_jatuh_ponek($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('resiko_jatuh_ponek', $data);
	}
	function get_upload_penunjang($no_ipd)
	{
		return $this->db->query("SELECT * FROM upload_pemeriksaan_penunjang where no_register='$no_ipd'");
	}

    function insert_upload_penunjang($data)
	{
		return $this->db->insert('upload_pemeriksaan_penunjang', $data);
	}

    function update_upload_penunjang($no_ipd, $data)
	{ 
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('upload_pemeriksaan_penunjang', $data);
	}

	function getdata_utd_pasien_rj($no_ipd, $datenow)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_unitdarah as a
			WHERE a.no_register = '$no_ipd' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
			");
	}

	function get_tindakan_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$noreg'");
	}
	function get_resep_dokter($noreg)
	{
		return $this->db->query("SELECT
										tgl_kunjungan, nm_obat, qty , signa
									FROM
										resep_dokter as a
									WHERE
										a.no_register = '$noreg'");
	}

	
}

	
?>
