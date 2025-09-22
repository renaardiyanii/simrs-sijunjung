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
                <form method="post" action="<?= base_url('irj/rjclaporan/lap_surveilands') ?>">

                    <div class="row">
                            <div style="margin-left:10px;margin-right:10px;margin-top:5px">Tanggal :</div>

                            <div class="form-group col-md-3">
                                <input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
                            </div>

                            <div class="form-group col-md-3">
                                <input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
                            </div>

                    </div>

                    <div class="row">
                            <div style="margin-left:10px;margin-right:10px;margin-top:5px">Ruang :</div>                
                            <div class="form-group col-md-3">
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
        <h4 align="center">PROFIL DATA SURVAILENDS</h4></div>
            <div align="left">&nbsp;&nbsp;&nbsp;Jumlah Pasien : <?= isset($lap_surveilands->jml_pasien)?$lap_surveilands->jml_pasien:'' ?>&nbsp;&nbsp;&nbsp;Orang</div>
            <div align="left">&nbsp;&nbsp;&nbsp;Ruangan : <?= isset($nama_rg->nmruang)?$nama_rg->nmruang:'' ?></div>
            <div align="left">&nbsp;&nbsp;&nbsp;Tanggal : <?= $tgl_awal.' '.'sampai'.' '.$tgl_akhir ?></div>
            <table class="display nowrap table table-hover table-bordered" id="example" cellspacing="0" width="100%" border=1>
                <tr>
                    <td  width="20%"><div align="center"></div></td>
                    <td colspan="2" width="60%"><div align="center">Jenis Operasi</div></td>
                    <td  width="20%"><div align="center">Jumlah Pasien</div></td>
                </tr>

                <tr>
                    <td rowspan="11"><div align="center">OPERASI</div></td>
                    <td rowspan="2">Tipe Operasi</td>
                    <td>Terbuka</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_op_terbuka)?$lap_surveilands->jml_op_terbuka:'' ?></div></td>
                </tr>

                <tr>
                    <td>Tertutup</div></td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_op_tertutup)?$lap_surveilands->jml_op_tertutup:'' ?></div></td>
                </tr>

                <tr>  
                    <td rowspan="4">Jenis Luka</td>
                    <td>Bersih</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_luka_bersih)?$lap_surveilands->jml_luka_bersih:'' ?></div></td>
                </tr>

                <tr>
                    <td>Bersih Kontaminasi</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_luka_kontaminasi)?$lap_surveilands->jml_luka_kontaminasi:'' ?></div></td>
                </tr>

                <tr>
                    <td>Kontaminasi</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_luka_konta)?$lap_surveilands->jml_luka_konta:'' ?></div></td>
                </tr>

                <tr>
                    <td>Kotor</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_luka_kotor)?$lap_surveilands->jml_luka_kotor:'' ?></div></td>
                </tr>

                <tr>
                    <td rowspan="3">Lama Operasi</td>
                    <td>0 - 1 Jam</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_op_satujam)?$lap_surveilands->jml_op_satujam:'' ?></div></td>
                </tr>
                <tr>
                    <td>> 1 jam < 5 jam</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_op_duajam)?$lap_surveilands->jml_op_duajam:'' ?></div></td>
                </tr>
                <tr>
                    <td>≥ 5 jam</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_op_limajam)?$lap_surveilands->jml_op_limajam:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">ASA Score</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_asa)?$lap_surveilands->jml_asa:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Risk Score</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_resiko)?$lap_surveilands->jml_resiko:'' ?></div></td>
                </tr>


                <tr>
                    <td rowspan="8"><div align="center">TINDAKAN</div></td>
                    <td rowspan="2">Catheter</td>
                    <td>Jumlah pasien terpasang cateter</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_pasien_kateter)?$lap_surveilands->jml_pasien_kateter:'' ?></div></td>
                </tr>

                <tr>
                    <td>Jumlah hari terpasang cateter</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_hari_kateter)?$lap_surveilands->jml_hari_kateter:'' ?></div></td>
                </tr>

                <tr>
                    <td rowspan="2">Infus</td>
                    <td>Jumlah pasien terpasang infus</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_pasien_infus)?$lap_surveilands->jml_pasien_infus:'' ?></div></td>
                </tr>

                <tr>
                    <td>Jumlah hari terpasang infus</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_hari_infus)?$lap_surveilands->jml_hari_infus:'' ?></div></td>
                </tr>

                <tr>
                    <td rowspan="2">CVL</td>
                    <td>Jumlah pasien terpasang CVL</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_pasien_cvl)?$lap_surveilands->jml_pasien_cvl:'' ?></div></td>
                </tr>

                <tr>
                    <td>Jumlah hari terpasang CVL</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_hari_cvl)?$lap_surveilands->jml_hari_cvl:'' ?></div></td>
                </tr>

                <tr>
                    <td rowspan="2">ETT</td>
                    <td>Jumlah pasien terpasang ETT</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_pasien_ett)?$lap_surveilands->jml_pasien_ett:'' ?></div></td>
                </tr>

                <tr>
                    <td>Jumlah hari terpasang ETT</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_hari_ett)?$lap_surveilands->jml_hari_ett:'' ?></div></td>
                </tr>

                <tr>
                    <td rowspan="2"><div align="center">Pemakaian antibiotik</div></td>
                    <td colspan="2">Profilaksis</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_profilaksis)?$lap_surveilands->jml_profilaksis:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Pengobatan</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_pengobatan)?$lap_surveilands->jml_pengobatan:'' ?></div></td>
                </tr>

                <tr>
                    <td rowspan="4"><div align="center">Pemeriksaan Kultur</div></td>
                    <td colspan="2">Darah</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_darah)?$lap_surveilands->jml_darah:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Urine</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_urine)?$lap_surveilands->jml_urine:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Sputum</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_sputum)?$lap_surveilands->jml_sputum:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Pus Luka</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_pus_luka)?$lap_surveilands->jml_pus_luka:'' ?></div></td>
                </tr>

                <tr>
                    <td><div align="center">Hasil Kultur</div></td>
                    <td colspan="2"></td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_hasil_kultur)?$lap_surveilands->jml_hasil_kultur:'' ?></div></td>
                </tr>

                <tr>
                    <td rowspan="7"><div align="center">HAIs</div></td>
                    <td colspan="2">Bakterimia</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_bakteremia)?$lap_surveilands->jml_bakteremia:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Sepsis</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_sepsis)?$lap_surveilands->jml_sepsis:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Pneumonia / VAP (Ventilator Associated Pneumonia ) / HAP</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_vap)?$lap_surveilands->jml_vap:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Infeksi Saluran Kemih</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_isk)?$lap_surveilands->jml_isk:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Infeksi Luka Operasi</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_luka_operasi)?$lap_surveilands->jml_luka_operasi:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Plebitis</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_plebitis)?$lap_surveilands->jml_plebitis:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Infeksi Lain</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_infeksi_lain)?$lap_surveilands->jml_infeksi_lain:'' ?></div></td>
                </tr>

                <tr>
                    <td rowspan="2"><div align="center">Dekubitus</div></td>
                    <td colspan="2">Jumlah pasien terjadi dekubitus</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_dekubitus)?$lap_surveilands->jml_dekubitus:'' ?></div></td>
                </tr>

                <tr>
                    <td colspan="2">Jumlah hari tirah baring</td>
                    <td><div align="center"><?= isset($lap_surveilands->jml_tirah_baring)?$lap_surveilands->jml_tirah_baring:'' ?></div></td>
                </tr>





            </table>
            <a href="<?php echo site_url('irj/Rjclaporan/download_lap_surveilands/'.$tgl_awal.'/'.$tgl_akhir.'/'.$idrg);?>">
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
