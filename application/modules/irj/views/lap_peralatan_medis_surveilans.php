<?php
    $this->load->view("layout/header_left");

?>
<style>
hr {
	border-color:#7DBE64 !important;
}

/* thead {
	/* background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important; */
/* }  */
</style>	

<script type='text/javascript'>
	$(document).ready(function () {
        var dataTable = $('#dataTables-example').DataTable( {
			
		});
        $('.datatable').DataTable({});
        //$('.datatables').DataTable();	
		$('#tgl').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment('<?= $tgl_awal ?>'),
          	endDate: moment('<?= $tgl_akhir ?>'),
		});
    });
	function download(){
		swal({
		  title: "Download?",
		  text: "Download !",
		  type: "warning",
		  showCancelButton: true,
	  	  showLoaderOnConfirm: false,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Ya!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('logistik_farmasi/frmclaporan/download_peneriamaan_obat/'.$supplier.'/'.$jenis.'/'.$jenis_obat.'/'.$tgl_awal.'/'.$tgl_akhir)?>");
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
	}	

    function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="post" action="<?= base_url('irj/rjclaporan/lap_peralatan_medis_surveilans') ?>">

                    <div class="row">
                            <div style="margin-left:10px;margin-right:10px;margin-top:5px">Tanggal :</div>

                            <div class="form-group col-md-2">
                                <input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
                            </div>

                            <div class="form-group col-md-2">
                                <input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
                            </div>

                            <div class="form-group col-md-2">
                                <select name="idrg" id="filter" class="form-control">
                                    <option value="semua" selected="">---- Pilih Semua ----</option>
                                    <?php foreach ($ruang as $val): ?>
                                    <option value="<?= $val->idrg ?>"><?= $val->nmruang ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                       
                                <span class="input-group-btn">
                                    <button class="btn btn-primary pull-right" type="submit">Lihat</button>
                                </span>
                            </div>  
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
        <div class="card-header">
            <div class="row">
              <div class="col-xs-9" id="alertMsg">  
                    <?php echo $this->session->flashdata('alert_msg'); ?>
              </div>
            </div>
        </div>
        <div class="card-block">
        <h4 align="center">Laporan Data Pemakaian Peralatan Medis</h4></div>
            <div class="table-responsive col-sm-12">
                <table class=" datatable table  table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Tanggal</th>
                            <th rowspan="2">No Medrec</th>
                            <th rowspan="2">Nama</th>
                            <th colspan="4" style="text-align:center">Pemakaian Alat</th>
                            <th rowspan="2">Tirah Baring</th>
                            <th colspan="4" style="text-align:center">Infeksi yang Terjadi</th>
                            <th rowspan="2">Dekubitus</th>
                            <th rowspan="2">Kultur</th>
                            <th rowspan="2">Antibiotika</th>
                          
                        </tr>
                        <tr>
                           
                            <th>ETT</th>
                            <th>Central Vena Line</th>
                            <th>Infus</th>
                            <th>Kateter</th>
                            <th>VAP</th>
                            <th>Bakteremia</th>
                            <th>Plebitis</th>
                            <th>ISK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index=1; foreach ($lap_peralatan_medis_surveilans as $val):?>
                        <tr>
                            <td style="text-align:center"><?= $index ?></td>
                            <td style="text-align:center"><?= $val->tgl_kunjungan ?></td>
                            <td style="text-align:center"><?= $val->no_medrec ?></td>
                            <td style="text-align:center"><?= $val->nama ?></td>
                            <?php 
                            $data_json = json_decode($val->formjson);
                            // var_dump($data_json->pemasangan[0]->antibiotik);die();
                            ?>
                            
                               <!-- ETT -->
                               <?php 
                            $ett_pasang = isset($data_json->pemasangan[0]->intra4_pasang)?new DateTime($data_json->pemasangan[0]->intra4_pasang):'';
                            $ett_lepas = isset($data_json->pemasangan[0]->intra4_lepas)?new DateTime($data_json->pemasangan[0]->intra4_lepas):'';
                            if($ett_lepas != '' && $ett_pasang != ''){
                                $hasil_ett =  $ett_lepas->diff($ett_pasang)->d;
                                if($hasil_ett == 0){
                                    $ett = 1;
                                }else{
                                    $ett = $hasil_ett ;
                                }
                            }else{
                                $ett = 0; 
                            }
                            ?>
                            
                            <th style="text-align:center"><?= $ett ?></th>
                            <!-- end ETT -->

                            <!-- CVL -->
                            <?php 
                            $cvl_pasang = isset($data_json->pemasangan[0]->intra2_pasang)?new DateTime($data_json->pemasangan[0]->intra2_pasang):'';
                            $cvl_lepas = isset($data_json->pemasangan[0]->intra2_lepas)?new DateTime($data_json->pemasangan[0]->intra2_lepas):'';
                            if($cvl_lepas != '' && $cvl_pasang != ''){
                                $hasil_cvl =  $cvl_lepas->diff($cvl_pasang)->d;
                                if($hasil_cvl == 0){
                                    $cvl = 1;
                                }else{
                                    $cvl = $hasil_cvl ;
                                }
                            }else{
                                $cvl = 0; 
                            }
                            ?>
                            <td style="text-align:center"><?= $cvl ?></td>

                            <!-- end CVL -->

                            <!-- infus -->
                            <?php 
                            $infus_pasang = isset($data_json->pemasangan[0]->intra_pasang)?new DateTime($data_json->pemasangan[0]->intra_pasang):'';
                            $infus_lepas = isset($data_json->pemasangan[0]->intra_lepas)?new DateTime($data_json->pemasangan[0]->intra_lepas):'';

                            if($infus_pasang != '' && $infus_lepas != ''){
                                $hasil_infus =  $infus_lepas->diff($infus_pasang)->d;
                                if($hasil_infus == 0){
                                    $infus = 1;
                                }else{
                                    $infus = $hasil_infus ;
                                }
                            }else{
                                $infus = 0; 
                            }
                            
                            ?>
                            <td style="text-align:center"><?= $infus ?></td>
                            <!-- end infus -->

                            <!-- keteter -->
                            <?php 
                            $kateter_pasang = isset($data_json->pemasangan[0]->intra3_pasang)?new DateTime($data_json->pemasangan[0]->intra3_pasang):'';
                            $kateter_lepas = isset($data_json->pemasangan[0]->intra3_lepas)?new DateTime($data_json->pemasangan[0]->intra3_lepas):'';

                            if($kateter_pasang != '' && $kateter_lepas != ''){
                                $hasil_keteter =  $kateter_lepas->diff($kateter_pasang)->d;
                                if($hasil_keteter == 0){
                                    $kateter = 1;
                                }else{
                                    $kateter = $hasil_keteter ;
                                }
                            }else{
                                $kateter = 0; 
                            }

                            ?>
                            <td style="text-align:center"><?= $kateter ?></td>
                            <td style="text-align:center"><?= isset($data_json->question4[0]->tirah_baring)?$data_json->question4[0]->tirah_baring == "y" ? "Ya":'Tidak':'X' ?></td>
                            <td style="text-align:center"><?= isset($data_json->question4[0]->vap)?$data_json->question4[0]->vap == "y" ? "Ya":'Tidak':'X' ?></td>
                            <td style="text-align:center"><?=  isset($data_json->question4[0]->baktere)?$data_json->question4[0]->baktere == "y" ? "Ya":'Tidak':'X'  ?></td>
                            <td style="text-align:center"><?=  isset($data_json->question4[0]->plebitis)?$data_json->question4[0]->plebitis == "y" ? "Ya":'Tidak':'X'  ?></td>
                            <td style="text-align:center"><?=  isset($data_json->question4[0]->infeksi)?$data_json->question4[0]->infeksi == "y" ? "Ya":'Tidak':'X'  ?></td>
                            <td style="text-align:center"><?=  isset($data_json->question4[0]->dekubitus)?$data_json->question4[0]->dekubitus == "y" ? "Ya":'Tidak':'X'  ?></td>
                            <td style="text-align:center"><?= isset($data_json->question3[0]->pemeriksaan)?$data_json->question3[0]->pemeriksaan:'X' ?></td>
                            <td style="text-align:center"><?= isset($data_json->pemasangan[0]->antibiotik)?$data_json->pemasangan[0]->antibiotik:'X' ?></td>
                        <?php $index++; endforeach; ?>
                    </tbody>
                </table>   
            </div>     
            <a href="<?php echo site_url('irj/Rjclaporan/download_lap_peralatan_medis_surveilans/'.$tgl_awal.'/'.$tgl_akhir.'/'.$idrg);?>">
                <input type="button" class="btn" style="background-color: lime;color:white;margin:5px" value="EXCEL"></a>
        </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
    $('.datatable').DataTable({});
	});
</script>
<?php

    $this->load->view("layout/footer_left");

?>
