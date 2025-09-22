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
        // var dataTable = $('#dataTables-example').DataTable( {
			
		// });
        // $('.datatable').DataTable({});
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
                <form method="post" action="<?= base_url('irj/rjclaporan/bor_los_toi_new') ?>">
                    <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" type="month" name="bulan" id="bulan" placeholder="YYYY-MM">
                                </div>
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
                <h4 align="center" style="font-weight:bold">PELAYANAN RAWAT INAP</h4></div>
                    <div class="table-responsive col-sm-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2">Ruangan</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Pasien Akhir</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    <th colspan ="5"  style="text-align:center">Jumlah TT</th>
                                    <th colspan ="4"  style="text-align:center">BOR Kelas</th>
                                    <th rowspan="2">BOR</th>
                                </tr>
                                <tr>
                                    <th>Di pindahkan</th>
                                    <th>Hidup</th>
                                    <th>Mati</th>
                                    <th>Total</th>
                                    <th>< 48 Jam</th>
                                    <th>≥ 48 Jam</th>
                                    <th>VIP</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>III</th>
                                    <th>VIP</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>III</th>
                                    <th>Jml</th>
                                    <th>VIP</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>III</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                                <?php
                                //  var_dump($datanya);die();
                                if($datanya != null){ ?>
                                    <tr>
                                        <td>LIMPAPEH L2</td>
                                        <td><?= $pasien_awal->limpapeh_l2 ?></td>
                                        <td><?= $pasien_masuk->limpapeh_l2 ?></td>
                                        <td><?= $pasien_masuk_pindah->limpapeh_l2 ?></td>
                                        <?php 
                                        $pasien_dirawat_limpapeh_l2 = $pasien_awal->limpapeh_l2 + $pasien_masuk->limpapeh_l2 + $pasien_masuk_pindah->limpapeh_l2 
                                        ?>
                                        <td><?= $pasien_dirawat_limpapeh_l2 ?></td>
                                        <td><?= $pasien_keluar_pindah->limpapeh_l2 ?></td>
                                        <td><?= $pasien_keluar_hidup->limpapeh_l2 ?></td>
                                        <td><?= $pasien_keluar_mati->limpapeh_l2 ?></td>
                                        <?php 
                                        $total_keluar_limpapeh_l2 = $pasien_keluar_pindah->limpapeh_l2 + $pasien_keluar_hidup->limpapeh_l2 + $pasien_keluar_mati->limpapeh_l2;
                                        ?>
                                        <td><?= $total_keluar_limpapeh_l2 ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->limpapeh_l2 ?></td>
                                        <td><?= $pasien_mati_kurang48->limpapeh_l2 ?></td>
                                        <td><?= $pasien_mati_lebih48->limpapeh_l2 ?></td>
                                        <td><?= $lama_rawat->limpapeh_l2 ?></td>
                                        <?php 
                                        $pasien_akhir_limpapeh_l2 = $pasien_dirawat_limpapeh_l2 - $total_keluar_limpapeh_l2;
                                        ?>
                                        <td><?= $pasien_akhir_limpapeh_l2 ?></td>
                                        <td><?php if($hari_perawatan->limpapeh_l2 != null){echo $hari_perawatan->limpapeh_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->limpapeh_l2 != null){echo $hari_perawatan_vip->limpapeh_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->limpapeh_l2 != null){echo $hari_perawatan_satu->limpapeh_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->limpapeh_l2 != null){echo $hari_perawatan_dua->limpapeh_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->limpapeh_l2 != null){echo $hari_perawatan_tiga->limpapeh_l2;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->limpapeh_l2 ?></td>
                                        <td><?= $tt_satu->limpapeh_l2 ?></td>
                                        <td><?= $tt_dua->limpapeh_l2 ?></td>
                                        <td><?= $tt_tiga->limpapeh_l2 ?></td>
                                        <?php 
                                            $total_tt_limpapeh_l2 = $tt_vip->limpapeh_l2 + $tt_satu->limpapeh_l2 + $tt_dua->limpapeh_l2 + $tt_tiga->limpapeh_l2;
                                        ?>
                                        <td><?=  $total_tt_limpapeh_l2 ?></td>
                                        <td><?= '0%' ?></td>
                                        <td></td>
                                        <?php 
                                        $bulannow_limpapeh_l2 = date("d");
                                        $bor1_limpapeh_l2_dua = $tt_dua->limpapeh_l2 * $bulannow_limpapeh_l2;
                                        $bor2_limpapeh_l2_dua = $hari_perawatan_dua->limpapeh_l2 /  $bor1_limpapeh_l2_dua;
                                        $bor3_limpapeh_l2_dua = $bor2_limpapeh_l2_dua * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l2_dua,2).'%' ?></td>
                                        <?php 
                                        $bulannow_limpapeh_l2 = date("d");
                                        $bor1_limpapeh_l2_tiga = $tt_tiga->limpapeh_l2 * $bulannow_limpapeh_l2;
                                        $bor2_limpapeh_l2_tiga = $hari_perawatan_tiga->limpapeh_l2 /  $bor1_limpapeh_l2_tiga;
                                        $bor3_limpapeh_l2_tiga = $bor2_limpapeh_l2_tiga * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l2_tiga,2).'%' ?></td>
                                        <?php 
                                        $bor1_limpapeh_l2_all = $total_tt_limpapeh_l2 * $bulannow_limpapeh_l2;
                                        $bor2_limpapeh_l2_all = $hari_perawatan->limpapeh_l2 /  $bor1_limpapeh_l2_all;
                                        $bor3_limpapeh_l2_all = $bor2_limpapeh_l2_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l2_all,2).'%' ?></td>
                                        
                                    </tr>

                                    <tr>
                                        <td>LIMPAPEH L3</td>
                                        <td><?= $pasien_awal->limpapeh_l3 ?></td>
                                        <td><?= $pasien_masuk->limpapeh_l3 ?></td>
                                        <td><?= $pasien_masuk_pindah->limpapeh_l3 ?></td>
                                        <?php 
                                        $pasien_dirawat_limpapeh_l3 = $pasien_awal->limpapeh_l3 + $pasien_masuk->limpapeh_l3 + $pasien_masuk_pindah->limpapeh_l3 
                                        ?>
                                        <td><?= $pasien_dirawat_limpapeh_l3 ?></td>
                                        <td><?= $pasien_keluar_pindah->limpapeh_l3 ?></td>
                                        <td><?= $pasien_keluar_hidup->limpapeh_l3 ?></td>
                                        <td><?= $pasien_keluar_mati->limpapeh_l3 ?></td>
                                        <?php 
                                        $total_keluar_limpapeh_l3 = $pasien_keluar_pindah->limpapeh_l3 + $pasien_keluar_hidup->limpapeh_l3 + $pasien_keluar_mati->limpapeh_l3;
                                        ?>
                                        <td><?= $total_keluar_limpapeh_l3 ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->limpapeh_l3 ?></td>
                                        <td><?= $pasien_mati_kurang48->limpapeh_l3 ?></td>
                                        <td><?= $pasien_mati_lebih48->limpapeh_l3 ?></td>
                                        <td><?= $lama_rawat->limpapeh_l3 ?></td>
                                        <?php 
                                        $pasien_akhir_limpapeh_l3 = $pasien_dirawat_limpapeh_l3 - $total_keluar_limpapeh_l3;
                                        ?>
                                        <td><?= $pasien_akhir_limpapeh_l3 ?></td>
                                        <td><?php if($hari_perawatan->limpapeh_l3 != null){echo $hari_perawatan->limpapeh_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->limpapeh_l3 != null){echo $hari_perawatan_vip->limpapeh_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->limpapeh_l3 != null){echo $hari_perawatan_satu->limpapeh_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->limpapeh_l3 != null){echo $hari_perawatan_dua->limpapeh_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->limpapeh_l3 != null){echo $hari_perawatan_tiga->limpapeh_l3;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->limpapeh_l3 ?></td>
                                        <td><?= $tt_satu->limpapeh_l3 ?></td>
                                        <td><?= $tt_dua->limpapeh_l3 ?></td>
                                        <td><?= $tt_tiga->limpapeh_l3 ?></td>
                                        <?php 
                                            $total_tt_limpapeh_l3 = $tt_vip->limpapeh_l3 + $tt_satu->limpapeh_l3 + $tt_dua->limpapeh_l3 + $tt_tiga->limpapeh_l3;
                                        ?>
                                        <td><?=  $total_tt_limpapeh_l3 ?></td>
                                        <?php 
                                        $bulannow_limpapeh_l3 = date("d");
                                        
                                        ?>
                                        <td></td>
                                        <?php 
                                        $bor1_limpapeh_l3_satu = $tt_satu->limpapeh_l3 * $bulannow_limpapeh_l3;
                                        $bor2_limpapeh_l3_satu = $hari_perawatan_satu->limpapeh_l3 /  $bor1_limpapeh_l3_satu;
                                        $bor3_limpapeh_l3_satu = $bor2_limpapeh_l3_satu * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l3_satu,2).'%' ?></td>
                                        <?php 
                                        $bulannow_limpapeh_l3 = date("d");
                                        $bor1_limpapeh_l3_dua = $tt_dua->limpapeh_l3 * $bulannow_limpapeh_l3;
                                        $bor2_limpapeh_l3_dua = $hari_perawatan_dua->limpapeh_l3 /  $bor1_limpapeh_l3_dua;
                                        $bor3_limpapeh_l3_dua = $bor2_limpapeh_l3_dua * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l3_dua,2).'%' ?></td>
                                        <td></td>
                                        <?php 
                                        $bor1_limpapeh_l3_all = $total_tt_limpapeh_l3 * $bulannow_limpapeh_l3;
                                        $bor2_limpapeh_l3_all = $hari_perawatan->limpapeh_l3 /  $bor1_limpapeh_l3_all;
                                        $bor3_limpapeh_l3_all = $bor2_limpapeh_l3_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l3_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>LIMPAPEH L4</td>
                                        <td><?= $pasien_awal->limpapeh_l4 ?></td>
                                        <td><?= $pasien_masuk->limpapeh_l4 ?></td>
                                        <td><?= $pasien_masuk_pindah->limpapeh_l4 ?></td>
                                        <?php 
                                        $pasien_dirawat_limpapeh_l4 = $pasien_awal->limpapeh_l4 + $pasien_masuk->limpapeh_l4 + $pasien_masuk_pindah->limpapeh_l4 
                                        ?>
                                        <td><?= $pasien_dirawat_limpapeh_l4 ?></td>
                                        <td><?= $pasien_keluar_pindah->limpapeh_l4 ?></td>
                                        <td><?= $pasien_keluar_hidup->limpapeh_l4 ?></td>
                                        <td><?= $pasien_keluar_mati->limpapeh_l4 ?></td>
                                        <?php 
                                        $total_keluar_limpapeh_l4 = $pasien_keluar_pindah->limpapeh_l4 + $pasien_keluar_hidup->limpapeh_l4 + $pasien_keluar_mati->limpapeh_l4;
                                        ?>
                                        <td><?= $total_keluar_limpapeh_l4 ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->limpapeh_l4 ?></td>
                                        <td><?= $pasien_mati_kurang48->limpapeh_l4 ?></td>
                                        <td><?= $pasien_mati_lebih48->limpapeh_l4 ?></td>
                                        <td><?= $lama_rawat->limpapeh_l4 ?></td>
                                        <?php 
                                        $pasien_akhir_limpapeh_l4 = $pasien_dirawat_limpapeh_l4 - $total_keluar_limpapeh_l4;
                                        ?>
                                        <td><?= $pasien_akhir_limpapeh_l4 ?></td>
                                        <td><?php if($hari_perawatan->limpapeh_l4 != null){echo $hari_perawatan->limpapeh_l4;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->limpapeh_l4 != null){echo $hari_perawatan_vip->limpapeh_l4;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->limpapeh_l4 != null){echo $hari_perawatan_satu->limpapeh_l4;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->limpapeh_l4 != null){echo $hari_perawatan_dua->limpapeh_l4;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->limpapeh_l4 != null){echo $hari_perawatan_tiga->limpapeh_l4;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->limpapeh_l4 ?></td>
                                        <td><?= $tt_satu->limpapeh_l4 ?></td>
                                        <td><?= $tt_dua->limpapeh_l4 ?></td>
                                        <td><?= $tt_tiga->limpapeh_l4 ?></td>
                                        <?php 
                                            $total_tt_limpapeh_l4 = $tt_vip->limpapeh_l4 + $tt_satu->limpapeh_l4 + $tt_dua->limpapeh_l4 + $tt_tiga->limpapeh_l4;
                                        ?>
                                        <td><?=  $total_tt_limpapeh_l4 ?></td>
                                        <?php 
                                        $bulannow_limpapeh_l4 = date("d");
                                        $bor1_limpapeh_l4 = $total_tt_limpapeh_l4 * $bulannow_limpapeh_l4;
                                        $bor2_limpapeh_l4 = $hari_perawatan_vip->limpapeh_l4 /  $bor1_limpapeh_l4;
                                        $bor3_limpapeh_l4 = $bor2_limpapeh_l4 * 100;
                                        ?>
                                        <td><?= $bor3_limpapeh_l4.'%' ?></td>
                                        <?php 
                                        $bor1_limpapeh_l4_satu = $tt_satu->limpapeh_l4 * $bulannow_limpapeh_l4;
                                        $bor2_limpapeh_l4_satu = $hari_perawatan_satu->limpapeh_l4 /  $bor1_limpapeh_l4_satu;
                                        $bor3_limpapeh_l4_satu = $bor2_limpapeh_l4_satu * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l4_satu,2).'%' ?></td>
                                        <?php 
                                        $bulannow_limpapeh_l4 = date("d");
                                        $bor1_limpapeh_l4_dua = $tt_dua->limpapeh_l4 * $bulannow_limpapeh_l4;
                                        $bor2_limpapeh_l4_dua = $hari_perawatan_dua->limpapeh_l4 /  $bor1_limpapeh_l4_dua;
                                        $bor3_limpapeh_l4_dua = $bor2_limpapeh_l4_dua * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l4_dua,2).'%' ?></td>
                                        <td></td>
                                        <?php 
                                        $bor1_limpapeh_l4_all = $total_tt_limpapeh_l4 * $bulannow_limpapeh_l4;
                                        $bor2_limpapeh_l4_all = $hari_perawatan->limpapeh_l4 /  $bor1_limpapeh_l4_all;
                                        $bor3_limpapeh_l4_all = $bor2_limpapeh_l4_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_limpapeh_l4_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>SINGGALANG L1 & L2</td>
                                        <td><?= $pasien_awal->singgalang_l1_l2 ?></td>
                                        <td><?= $pasien_masuk->singgalang_l1_l2 ?></td>
                                        <td><?= $pasien_masuk_pindah->singgalang_l1_l2 ?></td>
                                        <?php 
                                        $pasien_dirawat_singgalang_l1_l2 = $pasien_awal->singgalang_l1_l2 + $pasien_masuk->singgalang_l1_l2 + $pasien_masuk_pindah->singgalang_l1_l2 
                                        ?>
                                        <td><?= $pasien_dirawat_singgalang_l1_l2 ?></td>
                                        <td><?= $pasien_keluar_pindah->singgalang_l1_l2 ?></td>
                                        <td><?= $pasien_keluar_hidup->singgalang_l1_l2 ?></td>
                                        <td><?= $pasien_keluar_mati->singgalang_l1_l2 ?></td>
                                        <?php 
                                        $total_keluar_singgalang_l1_l2 = $pasien_keluar_pindah->singgalang_l1_l2 + $pasien_keluar_hidup->singgalang_l1_l2 + $pasien_keluar_mati->singgalang_l1_l2;
                                        ?>
                                        <td><?= $total_keluar_singgalang_l1_l2 ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->singgalang_l1_l2 ?></td>
                                        <td><?= $pasien_mati_kurang48->singgalang_l1_l2 ?></td>
                                        <td><?= $pasien_mati_lebih48->singgalang_l1_l2 ?></td>
                                        <td><?= $lama_rawat->singgalang_l1_l2 ?></td>
                                        <?php 
                                        $pasien_akhir_singgalang_l1_l2 = $pasien_dirawat_singgalang_l1_l2 - $total_keluar_singgalang_l1_l2;
                                        ?>
                                        <td><?= $pasien_akhir_singgalang_l1_l2 ?></td>
                                        <td><?php if($hari_perawatan->singgalang_l1_l2 != null){echo $hari_perawatan->singgalang_l1_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->singgalang_l1_l2 != null){echo $hari_perawatan_vip->singgalang_l1_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->singgalang_l1_l2 != null){echo $hari_perawatan_satu->singgalang_l1_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->singgalang_l1_l2 != null){echo $hari_perawatan_dua->singgalang_l1_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->singgalang_l1_l2 != null){echo $hari_perawatan_tiga->singgalang_l1_l2;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->singgalang_l1_l2 ?></td>
                                        <td><?= $tt_satu->singgalang_l1_l2 ?></td>
                                        <td><?= $tt_dua->singgalang_l1_l2 ?></td>
                                        <td><?= $tt_tiga->singgalang_l1_l2 ?></td>
                                        <?php 
                                            $total_tt_singgalang_l1_l2 = $tt_vip->singgalang_l1_l2 + $tt_satu->singgalang_l1_l2 + $tt_dua->singgalang_l1_l2 + $tt_tiga->singgalang_l1_l2;
                                        ?>
                                        <td><?=  $total_tt_singgalang_l1_l2 ?></td>
                                        <?php 
                                        $bulannow_singgalang_l1_l2 = date("d");
                                        $bor1_singgalang_l1_l2 = $total_tt_singgalang_l1_l2 * $bulannow_singgalang_l1_l2;
                                        $bor2_singgalang_l1_l2 = $hari_perawatan_vip->singgalang_l1_l2 /  $bor1_singgalang_l1_l2;
                                        $bor3_singgalang_l1_l2 = $bor2_singgalang_l1_l2 * 100;
                                        ?>
                                        <td><?= number_format($bor3_singgalang_l1_l2,2).'%' ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <?php 
                                        $bor1_singgalang_l1_l2_all = $total_tt_singgalang_l1_l2 * $bulannow_singgalang_l1_l2;
                                        $bor2_singgalang_l1_l2_all = $hari_perawatan->singgalang_l1_l2 /  $bor1_singgalang_l1_l2_all;
                                        $bor3_singgalang_l1_l2_all = $bor2_singgalang_l1_l2_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_singgalang_l1_l2_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>SINGGALANG L3</td>
                                        <td><?= $pasien_awal->singgalang_l3 ?></td>
                                        <td><?= $pasien_masuk->singgalang_l3 ?></td>
                                        <td><?= $pasien_masuk_pindah->singgalang_l3 ?></td>
                                        <?php 
                                        $pasien_dirawat_singgalang_l3 = $pasien_awal->singgalang_l3 + $pasien_masuk->singgalang_l3 + $pasien_masuk_pindah->singgalang_l3 
                                        ?>
                                        <td><?= $pasien_dirawat_singgalang_l3 ?></td>
                                        <td><?= $pasien_keluar_pindah->singgalang_l3 ?></td>
                                        <td><?= $pasien_keluar_hidup->singgalang_l3 ?></td>
                                        <td><?= $pasien_keluar_mati->singgalang_l3 ?></td>
                                        <?php 
                                        $total_keluar_singgalang_l3 = $pasien_keluar_pindah->singgalang_l3 + $pasien_keluar_hidup->singgalang_l3 + $pasien_keluar_mati->singgalang_l3;
                                        ?>
                                        <td><?= $total_keluar_singgalang_l3 ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->singgalang_l3 ?></td>
                                        <td><?= $pasien_mati_kurang48->singgalang_l3 ?></td>
                                        <td><?= $pasien_mati_lebih48->singgalang_l3 ?></td>
                                        <td><?= $lama_rawat->singgalang_l3 ?></td>
                                        <?php 
                                        $pasien_akhir_singgalang_l3 = $pasien_dirawat_singgalang_l3 - $total_keluar_singgalang_l3;
                                        ?>
                                        <td><?= $pasien_akhir_singgalang_l3 ?></td>
                                        <td><?php if($hari_perawatan->singgalang_l3 != null){echo $hari_perawatan->singgalang_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->singgalang_l3 != null){echo $hari_perawatan_vip->singgalang_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->singgalang_l3 != null){echo $hari_perawatan_satu->singgalang_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->singgalang_l3 != null){echo $hari_perawatan_dua->singgalang_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->singgalang_l3 != null){echo $hari_perawatan_tiga->singgalang_l3;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->singgalang_l3 ?></td>
                                        <td><?= $tt_satu->singgalang_l3 ?></td>
                                        <td><?= $tt_dua->singgalang_l3 ?></td>
                                        <td><?= $tt_tiga->singgalang_l3 ?></td>
                                        <?php 
                                            $total_tt_singgalang_l3 = $tt_vip->singgalang_l3 + $tt_satu->singgalang_l3 + $tt_dua->singgalang_l3 + $tt_tiga->singgalang_l3;
                                        ?>
                                        <td><?=  $total_tt_singgalang_l3 ?></td>
                                        <?php 
                                        $bulannow_singgalang_l3 = date("d");
                                        $bor1_singgalang_l3 = $total_tt_singgalang_l3 * $bulannow_singgalang_l3;
                                        $bor2_singgalang_l3 = $hari_perawatan_vip->singgalang_l3 /  $bor1_singgalang_l3;
                                        $bor3_singgalang_l3 = $bor2_singgalang_l3 * 100;
                                        ?>
                                        <td><?= $bor3_singgalang_l3.'%' ?></td>
                                        <?php 
                                        $bor1_singgalang_l3_satu = $tt_satu->singgalang_l3 * $bulannow_singgalang_l3;
                                        $bor2_singgalang_l3_satu = $hari_perawatan_satu->singgalang_l3 /  $bor1_singgalang_l3_satu;
                                        $bor3_singgalang_l3_satu = $bor2_singgalang_l3_satu * 100;
                                        ?>
                                        <td><?= number_format($bor3_singgalang_l3_satu,2).'%' ?></td>
                                        <td></td>
                                        <td></td>
                                        <?php 
                                        $bor1_singgalang_l3_all = $total_tt_singgalang_l3 * $bulannow_singgalang_l3;
                                        $bor2_singgalang_l3_all = $hari_perawatan->singgalang_l3 /  $bor1_singgalang_l3_all;
                                        $bor3_singgalang_l3_all = $bor2_singgalang_l3_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_singgalang_l3_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>MERAPI L1</td>
                                        <td><?= $pasien_awal->merapi_l1 ?></td>
                                        <td><?= $pasien_masuk->merapi_l1 ?></td>
                                        <td><?= $pasien_masuk_pindah->merapi_l1 ?></td>
                                        <?php 
                                        $pasien_dirawat_merapi_l1 = $pasien_awal->merapi_l1 + $pasien_masuk->merapi_l1 + $pasien_masuk_pindah->merapi_l1 
                                        ?>
                                        <td><?= $pasien_dirawat_merapi_l1 ?></td>
                                        <td><?= $pasien_keluar_pindah->merapi_l1 ?></td>
                                        <td><?= $pasien_keluar_hidup->merapi_l1 ?></td>
                                        <td><?= $pasien_keluar_mati->merapi_l1 ?></td>
                                        <?php 
                                        $total_keluar_merapi_l1 = $pasien_keluar_pindah->merapi_l1 + $pasien_keluar_hidup->merapi_l1 + $pasien_keluar_mati->merapi_l1;
                                        ?>
                                        <td><?= $total_keluar_merapi_l1 ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->merapi_l1 ?></td>
                                        <td><?= $pasien_mati_kurang48->merapi_l1 ?></td>
                                        <td><?= $pasien_mati_lebih48->merapi_l1 ?></td>
                                        <td><?= $lama_rawat->merapi_l1 ?></td>
                                        <?php 
                                        $pasien_akhir_merapi_l1 = $pasien_dirawat_merapi_l1 - $total_keluar_merapi_l1;
                                        ?>
                                        <td><?= $pasien_akhir_merapi_l1 ?></td>
                                        <td><?php if($hari_perawatan->merapi_l1 != null){echo $hari_perawatan->merapi_l1;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->merapi_l1 != null){echo $hari_perawatan_vip->merapi_l1;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->merapi_l1 != null){echo $hari_perawatan_satu->merapi_l1;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->merapi_l1 != null){echo $hari_perawatan_dua->merapi_l1;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->merapi_l1 != null){echo $hari_perawatan_tiga->merapi_l1;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->merapi_l1 ?></td>
                                        <td><?= $tt_satu->merapi_l1 ?></td>
                                        <td><?= $tt_dua->merapi_l1 ?></td>
                                        <td><?= $tt_tiga->merapi_l1 ?></td>
                                        <?php 
                                            $total_tt_merapi_l1 = $tt_vip->merapi_l1 + $tt_satu->merapi_l1 + $tt_dua->merapi_l1 + $tt_tiga->merapi_l1;
                                        ?>
                                        <td><?=  $total_tt_merapi_l1 ?></td>
                                        <?php 
                                        $bulannow_merapi_l1 = date("d");
                                        $bor1_merapi_l1 = $total_tt_merapi_l1 * $bulannow_merapi_l1;
                                        $bor2_merapi_l1 = $hari_perawatan_vip->merapi_l1 /  $bor1_merapi_l1;
                                        $bor3_merapi_l1 = $bor2_merapi_l1 * 100;
                                        ?>
                                        <td><?= $bor3_merapi_l1.'%' ?></td>
                                        <td></td>
                                        <td></td>
                                        <?php 
                                        $bulannow_merapi_l1 = date("d");
                                        $bor1_merapi_l1_tiga = $tt_tiga->merapi_l1 * $bulannow_merapi_l1;
                                        $bor2_merapi_l1_tiga = $hari_perawatan_tiga->merapi_l1 /  $bor1_merapi_l1_tiga;
                                        $bor3_merapi_l1_tiga = $bor2_merapi_l1_tiga * 100;
                                        ?>
                                        <td><?= number_format($bor3_merapi_l1_tiga,2).'%' ?></td>
                                        <?php 
                                      
                                        $bor1_merapi_l1_all = $total_tt_merapi_l1 * $bulannow_merapi_l1;
                                        $bor2_merapi_l1_all = $hari_perawatan->merapi_l1 /  $bor1_merapi_l1_all;
                                        $bor3_merapi_l1_all = $bor2_merapi_l1_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_merapi_l1_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>MERAPI L2</td>
                                        <td><?= $pasien_awal->merapi_l2 ?></td>
                                        <td><?= $pasien_masuk->merapi_l2 ?></td>
                                        <td><?= $pasien_masuk_pindah->merapi_l2 ?></td>
                                        <?php 
                                        $pasien_dirawat_merapi_l2 = $pasien_awal->merapi_l2 + $pasien_masuk->merapi_l2 + $pasien_masuk_pindah->merapi_l2 
                                        ?>
                                        <td><?= $pasien_dirawat_merapi_l2 ?></td>
                                        <td><?= $pasien_keluar_pindah->merapi_l2 ?></td>
                                        <td><?= $pasien_keluar_hidup->merapi_l2 ?></td>
                                        <td><?= $pasien_keluar_mati->merapi_l2 ?></td>
                                        <?php 
                                        $total_keluar_merapi_l2 = $pasien_keluar_pindah->merapi_l2 + $pasien_keluar_hidup->merapi_l2 + $pasien_keluar_mati->merapi_l2;
                                        ?>
                                        <td><?= $total_keluar_merapi_l2 ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->merapi_l2 ?></td>
                                        <td><?= $pasien_mati_kurang48->merapi_l2 ?></td>
                                        <td><?= $pasien_mati_lebih48->merapi_l2 ?></td>
                                        <td><?= $lama_rawat->merapi_l2 ?></td>
                                        <?php 
                                        $pasien_akhir_merapi_l2 = $pasien_dirawat_merapi_l2 - $total_keluar_merapi_l2;
                                        ?>
                                        <td><?= $pasien_akhir_merapi_l2 ?></td>
                                        <td><?php if($hari_perawatan->merapi_l2 != null){echo $hari_perawatan->merapi_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->merapi_l2 != null){echo $hari_perawatan_vip->merapi_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->merapi_l2 != null){echo $hari_perawatan_satu->merapi_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->merapi_l2 != null){echo $hari_perawatan_dua->merapi_l2;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->merapi_l2 != null){echo $hari_perawatan_tiga->merapi_l2;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->merapi_l2 ?></td>
                                        <td><?= $tt_satu->merapi_l2 ?></td>
                                        <td><?= $tt_dua->merapi_l2 ?></td>
                                        <td><?= $tt_tiga->merapi_l2 ?></td>
                                        <?php 
                                            $total_tt_merapi_l2 = $tt_vip->merapi_l2 + $tt_satu->merapi_l2 + $tt_dua->merapi_l2 + $tt_tiga->merapi_l2;
                                        ?>
                                        <td><?=  $total_tt_merapi_l2 ?></td>
                                        <?php 
                                        $bulannow_merapi_l2 = date("d");
                                        $bor1_merapi_l2 = $total_tt_merapi_l2 * $bulannow_merapi_l2;
                                        $bor2_merapi_l2 = $hari_perawatan_vip->merapi_l2 /  $bor1_merapi_l2;
                                        $bor3_merapi_l2 = $bor2_merapi_l2 * 100;
                                        ?>
                                        <td><?= $bor3_merapi_l2.'%' ?></td>
                                        <td></td>
                                        <?php 
                                        $bulannow_merapi_l2 = date("d");
                                        $bor1_merapi_l2_dua = $tt_dua->merapi_l2 * $bulannow_merapi_l2;
                                        $bor2_merapi_l2_dua = $hari_perawatan_dua->merapi_l2 /  $bor1_merapi_l2_dua;
                                        $bor3_merapi_l2_dua = $bor2_merapi_l2_dua * 100;
                                        ?>
                                        <td><?= number_format($bor3_merapi_l2_dua,2).'%' ?></td>
                                        <?php 
                                      
                                        $bor1_merapi_l2_tiga = $tt_tiga->merapi_l2 * $bulannow_merapi_l2;
                                        $bor2_merapi_l2_tiga = $hari_perawatan_tiga->merapi_l2 /  $bor1_merapi_l2_tiga;
                                        $bor3_merapi_l2_tiga = $bor2_merapi_l2_tiga * 100;
                                        ?>
                                        <td><?= number_format($bor3_merapi_l2_tiga,2).'%' ?></td>
                                        <?php 
                                      
                                        $bor1_merapi_l2_all = $total_tt_merapi_l2 * $bulannow_merapi_l2;
                                        $bor2_merapi_l2_all = $hari_perawatan->merapi_l2 /  $bor1_merapi_l2_all;
                                        $bor3_merapi_l2_all = $bor2_merapi_l2_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_merapi_l2_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>MERAPI L3</td>
                                        <td><?= $pasien_awal->merapi_l3 ?></td>
                                        <td><?= $pasien_masuk->merapi_l3 ?></td>
                                        <td><?= $pasien_masuk_pindah->merapi_l3 ?></td>
                                        <?php 
                                        $pasien_dirawat_merapi_l3 = $pasien_awal->merapi_l3 + $pasien_masuk->merapi_l3 + $pasien_masuk_pindah->merapi_l3 
                                        ?>
                                        <td><?= $pasien_dirawat_merapi_l3 ?></td>
                                        <td><?= $pasien_keluar_pindah->merapi_l3 ?></td>
                                        <td><?= $pasien_keluar_hidup->merapi_l3 ?></td>
                                        <td><?= $pasien_keluar_mati->merapi_l3 ?></td>
                                        <?php 
                                        $total_keluar_merapi_l3 = $pasien_keluar_pindah->merapi_l3 + $pasien_keluar_hidup->merapi_l3 + $pasien_keluar_mati->merapi_l3;
                                        ?>
                                        <td><?= $total_keluar_merapi_l3 ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->merapi_l3 ?></td>
                                        <td><?= $pasien_mati_kurang48->merapi_l3 ?></td>
                                        <td><?= $pasien_mati_lebih48->merapi_l3 ?></td>
                                        <td><?= $lama_rawat->merapi_l3 ?></td>
                                        <?php 
                                        $pasien_akhir_merapi_l3 = $pasien_dirawat_merapi_l3 - $total_keluar_merapi_l3;
                                        ?>
                                        <td><?= $pasien_akhir_merapi_l3 ?></td>
                                        <td><?php if($hari_perawatan->merapi_l3 != null){echo $hari_perawatan->merapi_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->merapi_l3 != null){echo $hari_perawatan_vip->merapi_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->merapi_l3 != null){echo $hari_perawatan_satu->merapi_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->merapi_l3 != null){echo $hari_perawatan_dua->merapi_l3;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->merapi_l3 != null){echo $hari_perawatan_tiga->merapi_l3;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->merapi_l3 ?></td>
                                        <td><?= $tt_satu->merapi_l3 ?></td>
                                        <td><?= $tt_dua->merapi_l3 ?></td>
                                        <td><?= $tt_tiga->merapi_l3 ?></td>
                                        <?php 
                                            $total_tt_merapi_l3 = $tt_vip->merapi_l3 + $tt_satu->merapi_l3 + $tt_dua->merapi_l3 + $tt_tiga->merapi_l3;
                                        ?>
                                        <td><?=  $total_tt_merapi_l3 ?></td>
                                        <?php 
                                        $bulannow_merapi_l3 = date("d");
                                        $bor1_merapi_l3 = $total_tt_merapi_l3 * $bulannow_merapi_l3;
                                        $bor2_merapi_l3 = $hari_perawatan_vip->merapi_l3 /  $bor1_merapi_l3;
                                        $bor3_merapi_l3 = $bor2_merapi_l3 * 100;
                                        ?>
                                        <td><?= $bor3_merapi_l3.'%' ?></td>
                                        <td></td>
                                        <?php 
                                        $bulannow_merapi_l3 = date("d");
                                        $bor1_merapi_l3_dua = $tt_dua->merapi_l3 * $bulannow_merapi_l3;
                                        $bor2_merapi_l3_dua = $hari_perawatan_dua->merapi_l3 /  $bor1_merapi_l3_dua;
                                        $bor3_merapi_l3_dua = $bor2_merapi_l3_dua * 100;
                                        ?>
                                        <td><?= number_format($bor3_merapi_l3_dua,2).'%' ?></td>
                                        <?php 
                                      
                                      $bor1_merapi_l3_tiga = $tt_tiga->merapi_l3 * $bulannow_merapi_l3;
                                      $bor2_merapi_l3_tiga = $hari_perawatan_tiga->merapi_l3 /  $bor1_merapi_l3_tiga;
                                      $bor3_merapi_l3_tiga = $bor2_merapi_l3_tiga * 100;
                                      ?>
                                      <td><?= number_format($bor3_merapi_l3_tiga,2).'%' ?></td>
                                      <?php 
                                    
                                      $bor1_merapi_l3_all = $total_tt_merapi_l3 * $bulannow_merapi_l3;
                                      $bor2_merapi_l3_all = $hari_perawatan->merapi_l3 /  $bor1_merapi_l3_all;
                                      $bor3_merapi_l3_all = $bor2_merapi_l3_all * 100;
                                      ?>
                                      <td><?= number_format($bor3_merapi_l3_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>ANAK</td>
                                        <td><?= $pasien_awal->anak ?></td>
                                        <td><?= $pasien_masuk->anak ?></td>
                                        <td><?= $pasien_masuk_pindah->anak ?></td>
                                        <?php 
                                        $pasien_dirawat_anak = $pasien_awal->anak + $pasien_masuk->anak + $pasien_masuk_pindah->anak 
                                        ?>
                                        <td><?= $pasien_dirawat_anak ?></td>
                                        <td><?= $pasien_keluar_pindah->anak ?></td>
                                        <td><?= $pasien_keluar_hidup->anak ?></td>
                                        <td><?= $pasien_keluar_mati->anak ?></td>
                                        <?php 
                                        $total_keluar_anak = $pasien_keluar_pindah->anak + $pasien_keluar_hidup->anak + $pasien_keluar_mati->anak;
                                        ?>
                                        <td><?= $total_keluar_anak ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->anak ?></td>
                                        <td><?= $pasien_mati_kurang48->anak ?></td>
                                        <td><?= $pasien_mati_lebih48->anak ?></td>
                                        <td><?= $lama_rawat->anak ?></td>
                                        <?php 
                                        $pasien_akhir_anak = $pasien_dirawat_anak - $total_keluar_anak;
                                        ?>
                                        <td><?= $pasien_akhir_anak ?></td>
                                        <td><?php if($hari_perawatan->anak != null){echo $hari_perawatan->anak;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->anak != null){echo $hari_perawatan_vip->anak;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->anak != null){echo $hari_perawatan_satu->anak;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->anak != null){echo $hari_perawatan_dua->anak;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->anak != null){echo $hari_perawatan_tiga->anak;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->anak ?></td>
                                        <td><?= $tt_satu->anak ?></td>
                                        <td><?= $tt_dua->anak ?></td>
                                        <td><?= $tt_tiga->anak ?></td>
                                        <?php 
                                            $total_tt_anak = $tt_vip->anak + $tt_satu->anak + $tt_dua->anak + $tt_tiga->anak;
                                        ?>
                                        <td><?=  $total_tt_anak ?></td>
                                        <?php 
                                        $bulannow_anak = date("d");
                                        $bor1_anak = $total_tt_anak * $bulannow_anak;
                                        $bor2_anak = $hari_perawatan_vip->anak /  $bor1_anak;
                                        $bor3_anak = $bor2_anak * 100;
                                        ?>
                                        <td><?= $bor3_anak.'%' ?></td>
                                        <?php 
                                        $bor1_anak_satu = $tt_satu->anak * $bulannow_anak;
                                        $bor2_anak_satu = $hari_perawatan_satu->anak /  $bor1_anak_satu;
                                        $bor3_anak_satu = $bor2_anak_satu * 100;
                                        ?>
                                        <td><?= number_format($bor3_anak_satu,2).'%' ?></td>
                                        <td></td>
                                        <?php 
                                      
                                        $bor1_anak_tiga = $tt_tiga->anak * $bulannow_anak;
                                        $bor2_anak_tiga = $hari_perawatan_tiga->anak /  $bor1_anak_tiga;
                                        $bor3_anak_tiga = $bor2_anak_tiga * 100;
                                        ?>
                                        <td><?= number_format($bor3_anak_tiga,2).'%' ?></td>
                                        <?php 
                                        
                                        $bor1_anak_all = $total_tt_anak * $bulannow_anak;
                                        $bor2_anak_all = $hari_perawatan->anak /  $bor1_anak_all;
                                        $bor3_anak_all = $bor2_anak_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_anak_all,2).'%' ?></td>
                                        
                                    </tr>

                                    <tr>
                                        <td>BEDAH</td>
                                        <td><?= $pasien_awal->bedah ?></td>
                                        <td><?= $pasien_masuk->bedah ?></td>
                                        <td><?= $pasien_masuk_pindah->bedah ?></td>
                                        <?php 
                                        $pasien_dirawat_bedah = $pasien_awal->bedah + $pasien_masuk->bedah + $pasien_masuk_pindah->bedah 
                                        ?>
                                        <td><?= $pasien_dirawat_bedah ?></td>
                                        <td><?= $pasien_keluar_pindah->bedah ?></td>
                                        <td><?= $pasien_keluar_hidup->bedah ?></td>
                                        <td><?= $pasien_keluar_mati->bedah ?></td>
                                        <?php 
                                        $total_keluar_bedah = $pasien_keluar_pindah->bedah + $pasien_keluar_hidup->bedah + $pasien_keluar_mati->bedah;
                                        ?>
                                        <td><?= $total_keluar_bedah ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->bedah ?></td>
                                        <td><?= $pasien_mati_kurang48->bedah ?></td>
                                        <td><?= $pasien_mati_lebih48->bedah ?></td>
                                        <td><?= $lama_rawat->bedah ?></td>
                                        <?php 
                                        $pasien_akhir_bedah = $pasien_dirawat_bedah - $total_keluar_bedah;
                                        ?>
                                        <td><?= $pasien_akhir_bedah ?></td>
                                        <td><?php if($hari_perawatan->bedah != null){echo $hari_perawatan->bedah;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->bedah != null){echo $hari_perawatan_vip->bedah;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->bedah != null){echo $hari_perawatan_satu->bedah;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->bedah != null){echo $hari_perawatan_dua->bedah;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->bedah != null){echo $hari_perawatan_tiga->bedah;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->bedah ?></td>
                                        <td><?= $tt_satu->bedah ?></td>
                                        <td><?= $tt_dua->bedah ?></td>
                                        <td><?= $tt_tiga->bedah ?></td>
                                        <?php 
                                            $total_tt_bedah = $tt_vip->bedah + $tt_satu->bedah + $tt_dua->bedah + $tt_tiga->bedah;
                                        ?>
                                        <td><?=  $total_tt_bedah ?></td>
                                        <?php 
                                        $bulannow_bedah = date("d");
                                        $bor1_bedah = $total_tt_bedah * $bulannow_bedah;
                                        $bor2_bedah = $hari_perawatan_vip->bedah /  $bor1_bedah;
                                        $bor3_bedah = $bor2_bedah * 100;
                                        ?>
                                        <td><?= $bor3_bedah.'%' ?></td>
                                        <?php 
                                        $bor1_bedah_satu = $tt_satu->bedah * $bulannow_bedah;
                                        $bor2_bedah_satu = $hari_perawatan_satu->bedah /  $bor1_bedah_satu;
                                        $bor3_bedah_satu = $bor2_bedah_satu * 100;
                                        ?>
                                        <td><?= number_format($bor3_bedah_satu,2).'%' ?></td>
                                     
                                        
                                        <td></td>
                                        <?php 
                                      
                                        $bor1_bedah_tiga = $tt_tiga->bedah * $bulannow_bedah;
                                        $bor2_bedah_tiga = $hari_perawatan_tiga->bedah /  $bor1_bedah_tiga;
                                        $bor3_bedah_tiga = $bor2_bedah_tiga * 100;
                                        ?>
                                        <td><?= number_format($bor3_bedah_tiga,2).'%' ?></td>
                                        <?php 
                                        
                                        $bor1_bedah_all = $total_tt_bedah * $bulannow_bedah;
                                        $bor2_bedah_all = $hari_perawatan->bedah /  $bor1_bedah_all;
                                        $bor3_bedah_all = $bor2_bedah_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_bedah_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>KEBIDANAN</td>
                                        <td><?= $pasien_awal->kebidanan ?></td>
                                        <td><?= $pasien_masuk->kebidanan ?></td>
                                        <td><?= $pasien_masuk_pindah->kebidanan ?></td>
                                        <?php 
                                        $pasien_dirawat_kebidanan = $pasien_awal->kebidanan + $pasien_masuk->kebidanan + $pasien_masuk_pindah->kebidanan 
                                        ?>
                                        <td><?= $pasien_dirawat_kebidanan ?></td>
                                        <td><?= $pasien_keluar_pindah->kebidanan ?></td>
                                        <td><?= $pasien_keluar_hidup->kebidanan ?></td>
                                        <td><?= $pasien_keluar_mati->kebidanan ?></td>
                                        <?php 
                                        $total_keluar_kebidanan = $pasien_keluar_pindah->kebidanan + $pasien_keluar_hidup->kebidanan + $pasien_keluar_mati->kebidanan;
                                        ?>
                                        <td><?= $total_keluar_kebidanan ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->kebidanan ?></td>
                                        <td><?= $pasien_mati_kurang48->kebidanan ?></td>
                                        <td><?= $pasien_mati_lebih48->kebidanan ?></td>
                                        <td><?= $lama_rawat->kebidanan ?></td>
                                        <?php 
                                        $pasien_akhir_kebidanan = $pasien_dirawat_kebidanan - $total_keluar_kebidanan;
                                        ?>
                                        <td><?= $pasien_akhir_kebidanan ?></td>
                                        <td><?php if($hari_perawatan->kebidanan != null){echo $hari_perawatan->kebidanan;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->kebidanan != null){echo $hari_perawatan_vip->kebidanan;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->kebidanan != null){echo $hari_perawatan_satu->kebidanan;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->kebidanan != null){echo $hari_perawatan_dua->kebidanan;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->kebidanan != null){echo $hari_perawatan_tiga->kebidanan;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->kebidanan ?></td>
                                        <td><?= $tt_satu->kebidanan ?></td>
                                        <td><?= $tt_dua->kebidanan ?></td>
                                        <td><?= $tt_tiga->kebidanan ?></td>
                                        <?php 
                                            $total_tt_kebidanan = $tt_vip->kebidanan + $tt_satu->kebidanan + $tt_dua->kebidanan + $tt_tiga->kebidanan;
                                        ?>
                                        <td><?=  $total_tt_kebidanan ?></td>
                                        <?php 
                                        $bulannow_kebidanan = date("d");
                                        $bor1_kebidanan = $total_tt_kebidanan * $bulannow_kebidanan;
                                        $bor2_kebidanan = $hari_perawatan_vip->kebidanan /  $bor1_kebidanan;
                                        $bor3_kebidanan = $bor2_kebidanan * 100;
                                        ?>
                                        <td><?= $bor3_kebidanan.'%' ?></td>
                                        <?php 
                                        $bor1_kebidanan_satu = $tt_satu->kebidanan * $bulannow_kebidanan;
                                        $bor2_kebidanan_satu = $hari_perawatan_satu->kebidanan /  $bor1_kebidanan_satu;
                                        $bor3_kebidanan_satu = $bor2_kebidanan_satu * 100;
                                        ?>
                                        <td><?= number_format($bor3_kebidanan_satu,2).'%' ?></td>
                                        <?php 
                                        $bulannow_kebidanan = date("d");
                                        $bor1_kebidanan_dua = $tt_dua->kebidanan * $bulannow_kebidanan;
                                        $bor2_kebidanan_dua = $hari_perawatan_dua->kebidanan /  $bor1_kebidanan_dua;
                                        $bor3_kebidanan_dua = $bor2_kebidanan_dua * 100;
                                        ?>
                                        <td><?= number_format($bor3_kebidanan_dua,2).'%' ?></td>
                                        <?php 
                                      
                                        $bor1_kebidanan_tiga = $tt_tiga->kebidanan * $bulannow_kebidanan;
                                        $bor2_kebidanan_tiga = $hari_perawatan_tiga->kebidanan /  $bor1_kebidanan_tiga;
                                        $bor3_kebidanan_tiga = $bor2_kebidanan_tiga * 100;
                                        ?>
                                        <td><?= number_format($bor3_kebidanan_tiga,2).'%' ?></td>
                                        <?php 
                                        
                                        $bor1_kebidanan_all = $total_tt_kebidanan * $bulannow_kebidanan;
                                        $bor2_kebidanan_all = $hari_perawatan->kebidanan /  $bor1_kebidanan_all;
                                        $bor3_kebidanan_all = $bor2_kebidanan_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_kebidanan_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>ICU</td>
                                        <td><?= $pasien_awal->icu ?></td>
                                        <td><?= $pasien_masuk->icu ?></td>
                                        <td><?= $pasien_masuk_pindah->icu ?></td>
                                        <?php 
                                        $pasien_dirawat_icu = $pasien_awal->icu + $pasien_masuk->icu + $pasien_masuk_pindah->icu 
                                        ?>
                                        <td><?= $pasien_dirawat_icu ?></td>
                                        <td><?= $pasien_keluar_pindah->icu ?></td>
                                        <td><?= $pasien_keluar_hidup->icu ?></td>
                                        <td><?= $pasien_keluar_mati->icu ?></td>
                                        <?php 
                                        $total_keluar_icu = $pasien_keluar_pindah->icu + $pasien_keluar_hidup->icu + $pasien_keluar_mati->icu;
                                        ?>
                                        <td><?= $total_keluar_icu ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->icu ?></td>
                                        <td><?= $pasien_mati_kurang48->icu ?></td>
                                        <td><?= $pasien_mati_lebih48->icu ?></td>
                                        <td><?= $lama_rawat->icu ?></td>
                                        <?php 
                                        $pasien_akhir_icu = $pasien_dirawat_icu - $total_keluar_icu;
                                        ?>
                                        <td><?= $pasien_akhir_icu ?></td>
                                        <td><?php if($hari_perawatan->icu != null){echo $hari_perawatan->icu;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->icu != null){echo $hari_perawatan_vip->icu;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->icu != null){echo $hari_perawatan_satu->icu;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->icu != null){echo $hari_perawatan_dua->icu;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->icu != null){echo $hari_perawatan_tiga->icu;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->icu ?></td>
                                        <td><?= $tt_satu->icu ?></td>
                                        <td><?= $tt_dua->icu ?></td>
                                        <td><?= $tt_tiga->icu ?></td>
                                        <?php 
                                            $total_tt_icu = $tt_vip->icu + $tt_satu->icu + $tt_dua->icu + $tt_tiga->icu;
                                        ?>
                                        <td><?=  $total_tt_icu ?></td>
                                        <?php 
                                        $bulannow_icu = date("d");
                                        $bor1_icu = $total_tt_icu * $bulannow_icu;
                                        $bor2_icu = $hari_perawatan_vip->icu /  $bor1_icu;
                                        $bor3_icu = $bor2_icu * 100;
                                        ?>
                                        <td><?= $bor3_icu.'%' ?></td>
                                        <?php 
                                        $bor1_icu_satu = $tt_satu->icu * $bulannow_icu;
                                        $bor2_icu_satu = $hari_perawatan_satu->icu /  $bor1_icu_satu;
                                        $bor3_icu_satu = $bor2_icu_satu * 100;
                                        ?>
                                        <td><?= number_format($bor3_icu_satu,2).'%' ?></td>
                                        <td></td>
                                        <td></td>
                                        <?php 
                                        
                                        $bor1_icu_all = $total_tt_icu * $bulannow_icu;
                                        $bor2_icu_all = $hari_perawatan->icu /  $bor1_icu_all;
                                        $bor3_icu_all = $bor2_icu_all * 100;
                                        ?>
                                        <td><?= number_format($bor3_icu_all,2).'%' ?></td>
                                    </tr>

                                    <tr>
                                        <td>NICU</td>
                                        <td><?= $pasien_awal->nicu ?></td>
                                        <td><?= $pasien_masuk->nicu ?></td>
                                        <td><?= $pasien_masuk_pindah->nicu ?></td>
                                        <?php 
                                        $pasien_dirawat_nicu = $pasien_awal->nicu + $pasien_masuk->nicu + $pasien_masuk_pindah->nicu 
                                        ?>
                                        <td><?= $pasien_dirawat_nicu ?></td>
                                        <td><?= $pasien_keluar_pindah->nicu ?></td>
                                        <td><?= $pasien_keluar_hidup->nicu ?></td>
                                        <td><?= $pasien_keluar_mati->nicu ?></td>
                                        <?php 
                                        $total_keluar_nicu = $pasien_keluar_pindah->nicu + $pasien_keluar_hidup->nicu + $pasien_keluar_mati->nicu;
                                        ?>
                                        <td><?= $total_keluar_nicu ?></td>
                                        <td><?= $pasien_keluar_hidup_mati->nicu ?></td>
                                        <td><?= $pasien_mati_kurang48->nicu ?></td>
                                        <td><?= $pasien_mati_lebih48->nicu ?></td>
                                        <td><?= $lama_rawat->nicu ?></td>
                                        <?php 
                                        $pasien_akhir_nicu = $pasien_dirawat_nicu - $total_keluar_nicu;
                                        ?>
                                        <td><?= $pasien_akhir_nicu ?></td>
                                        <td><?php if($hari_perawatan->nicu != null){echo $hari_perawatan->nicu;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_vip->nicu != null){echo $hari_perawatan_vip->nicu;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_satu->nicu != null){echo $hari_perawatan_satu->nicu;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_dua->nicu != null){echo $hari_perawatan_dua->nicu;}else{echo '0';} ?></td>
                                        <td><?php if($hari_perawatan_tiga->nicu != null){echo $hari_perawatan_tiga->nicu;}else{echo '0';} ?></td>
                                        <td><?= $tt_vip->nicu ?></td>
                                        <td><?= $tt_satu->nicu ?></td>
                                        <td><?= $tt_dua->nicu ?></td>
                                        <td><?= $tt_tiga->nicu ?></td>
                                        <?php 
                                            $total_tt_nicu = $tt_vip->nicu + $tt_satu->nicu + $tt_dua->nicu + $tt_tiga->nicu;
                                        ?>
                                        <td><?=  $total_tt_nicu ?></td>
                                        <?php 
                                        $bulannow_nicu = date("d");
                                        $bor1_nicu = $total_tt_nicu * $bulannow_nicu;
                                        $bor2_nicu = $hari_perawatan_vip->nicu /  $bor1_nicu;
                                        $bor3_nicu = $bor2_nicu * 100;
                                        ?>
                                        <td><?= $bor3_nicu.'%' ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>TOTAL</td>
                                        <?php
                                        $total_pasien_awal = $pasien_awal->limpapeh_l2 + $pasien_awal->limpapeh_l3 + $pasien_awal->limpapeh_l4 + 
                                        $pasien_awal->singgalang_l1_l2 + $pasien_awal->singgalang_l3 + $pasien_awal->merapi_l1 + $pasien_awal->merapi_l2 +
                                        $pasien_awal->merapi_l3 + $pasien_awal->anak + $pasien_awal->bedah + $pasien_awal->kebidanan + $pasien_awal->icu + $pasien_awal->nicu;
                                        ?>
                                        <td><?= $total_pasien_awal ?></td>

                                        <?php
                                        $total_pasien_masuk = $pasien_masuk->limpapeh_l2 + $pasien_masuk->limpapeh_l3 + $pasien_masuk->limpapeh_l4 + 
                                        $pasien_masuk->singgalang_l1_l2 + $pasien_masuk->singgalang_l3 + $pasien_masuk->merapi_l1 + $pasien_masuk->merapi_l2 +
                                        $pasien_masuk->merapi_l3 + $pasien_masuk->anak + $pasien_masuk->bedah + $pasien_masuk->kebidanan + $pasien_masuk->icu + $pasien_masuk->nicu;
                                        ?>
                                        <td><?= $total_pasien_masuk ?></td>

                                        <?php
                                        $total_pasien_masuk_pindah = $pasien_masuk_pindah->limpapeh_l2 + $pasien_masuk_pindah->limpapeh_l3 + $pasien_masuk_pindah->limpapeh_l4 + 
                                        $pasien_masuk_pindah->singgalang_l1_l2 + $pasien_masuk_pindah->singgalang_l3 + $pasien_masuk_pindah->merapi_l1 + $pasien_masuk_pindah->merapi_l2 +
                                        $pasien_masuk_pindah->merapi_l3 + $pasien_masuk_pindah->anak + $pasien_masuk_pindah->bedah + $pasien_masuk_pindah->kebidanan + $pasien_masuk_pindah->icu + $pasien_masuk_pindah->nicu;
                                        ?>
                                        <td><?=  $total_pasien_masuk_pindah ?></td>

                                        <?php
                                        $total_pasien_dirawat_all = $pasien_dirawat_limpapeh_l2 + $pasien_dirawat_limpapeh_l3 +  $pasien_dirawat_limpapeh_l4 + 
                                        $pasien_dirawat_singgalang_l1_l2 + $pasien_dirawat_singgalang_l3 + $pasien_dirawat_merapi_l1 + $pasien_dirawat_merapi_l2 +
                                        $pasien_dirawat_merapi_l3 + $pasien_dirawat_anak + $pasien_dirawat_bedah +  $pasien_dirawat_kebidanan + $pasien_dirawat_icu + $pasien_dirawat_nicu;
                                        ?>
                                        <td><?= $total_pasien_dirawat_all ?></td>

                                        <?php
                                        $total_pasien_keluar_pindah = $pasien_keluar_pindah->limpapeh_l2 + $pasien_keluar_pindah->limpapeh_l3 + $pasien_keluar_pindah->limpapeh_l4 + 
                                        $pasien_keluar_pindah->singgalang_l1_l2 + $pasien_keluar_pindah->singgalang_l3 + $pasien_keluar_pindah->merapi_l1 + $pasien_keluar_pindah->merapi_l2 +
                                        $pasien_keluar_pindah->merapi_l3 + $pasien_keluar_pindah->anak + $pasien_keluar_pindah->bedah + $pasien_keluar_pindah->kebidanan + $pasien_keluar_pindah->icu + $pasien_keluar_pindah->nicu;
                                        ?>
                                        <td><?= $total_pasien_keluar_pindah ?></td>

                                        <?php
                                        $total_pasien_keluar_hidup = $pasien_keluar_hidup->limpapeh_l2 + $pasien_keluar_hidup->limpapeh_l3 + $pasien_keluar_hidup->limpapeh_l4 + 
                                        $pasien_keluar_hidup->singgalang_l1_l2 + $pasien_keluar_hidup->singgalang_l3 + $pasien_keluar_hidup->merapi_l1 + $pasien_keluar_hidup->merapi_l2 +
                                        $pasien_keluar_hidup->merapi_l3 + $pasien_keluar_hidup->anak + $pasien_keluar_hidup->bedah + $pasien_keluar_hidup->kebidanan + $pasien_keluar_hidup->icu + $pasien_keluar_hidup->nicu;
                                        ?>
                                        <td><?= $total_pasien_keluar_hidup ?></td>

                                        <?php
                                        $total_pasien_keluar_mati = $pasien_keluar_mati->limpapeh_l2 + $pasien_keluar_mati->limpapeh_l3 + $pasien_keluar_mati->limpapeh_l4 + 
                                        $pasien_keluar_mati->singgalang_l1_l2 + $pasien_keluar_mati->singgalang_l3 + $pasien_keluar_mati->merapi_l1 + $pasien_keluar_mati->merapi_l2 +
                                        $pasien_keluar_mati->merapi_l3 + $pasien_keluar_mati->anak + $pasien_keluar_mati->bedah + $pasien_keluar_mati->kebidanan + $pasien_keluar_mati->icu + $pasien_keluar_mati->nicu;
                                        ?>
                                        <td><?= $total_pasien_keluar_mati ?></td>

                                        <?php 
                                        $jml_total_keluar= $total_keluar_limpapeh_l2 + $total_keluar_limpapeh_l3 + $total_keluar_limpapeh_l4 + $total_keluar_singgalang_l1_l2 +
                                        $total_keluar_singgalang_l3 + $total_keluar_merapi_l1 + $total_keluar_merapi_l2 + $total_keluar_merapi_l3 + $total_keluar_anak + $total_keluar_bedah + $total_keluar_kebidanan + $total_keluar_icu +  $total_keluar_nicu;
                                        ?>
                                        <td><?= $jml_total_keluar ?></td>

                                        <?php
                                        $total_pasien_keluar_hidup_mati = $pasien_keluar_hidup_mati->limpapeh_l2 + $pasien_keluar_hidup_mati->limpapeh_l3 + $pasien_keluar_hidup_mati->limpapeh_l4 + 
                                        $pasien_keluar_hidup_mati->singgalang_l1_l2 + $pasien_keluar_hidup_mati->singgalang_l3 + $pasien_keluar_hidup_mati->merapi_l1 + $pasien_keluar_hidup_mati->merapi_l2 +
                                        $pasien_keluar_hidup_mati->merapi_l3 + $pasien_keluar_hidup_mati->anak + $pasien_keluar_hidup_mati->bedah + $pasien_keluar_hidup_mati->kebidanan + $pasien_keluar_hidup_mati->icu + $pasien_keluar_hidup_mati->nicu;
                                        ?>
                                        <td><?= $total_pasien_keluar_hidup_mati ?></td>

                                        <?php
                                        $total_pasien_mati_kurang48 = $pasien_mati_kurang48->limpapeh_l2 + $pasien_mati_kurang48->limpapeh_l3 + $pasien_mati_kurang48->limpapeh_l4 + 
                                        $pasien_mati_kurang48->singgalang_l1_l2 + $pasien_mati_kurang48->singgalang_l3 + $pasien_mati_kurang48->merapi_l1 + $pasien_mati_kurang48->merapi_l2 +
                                        $pasien_mati_kurang48->merapi_l3 + $pasien_mati_kurang48->anak + $pasien_mati_kurang48->bedah + $pasien_mati_kurang48->kebidanan + $pasien_mati_kurang48->icu + $pasien_mati_kurang48->nicu;
                                        ?>
                                        <td><?= $total_pasien_mati_kurang48 ?></td>

                                        <?php
                                        $total_pasien_mati_lebih48 = $pasien_mati_lebih48->limpapeh_l2 + $pasien_mati_lebih48->limpapeh_l3 + $pasien_mati_lebih48->limpapeh_l4 + 
                                        $pasien_mati_lebih48->singgalang_l1_l2 + $pasien_mati_lebih48->singgalang_l3 + $pasien_mati_lebih48->merapi_l1 + $pasien_mati_lebih48->merapi_l2 +
                                        $pasien_mati_lebih48->merapi_l3 + $pasien_mati_lebih48->anak + $pasien_mati_lebih48->bedah + $pasien_mati_lebih48->kebidanan + $pasien_mati_lebih48->icu + $pasien_mati_lebih48->nicu;
                                        ?>
                                        <td><?=  $total_pasien_mati_lebih48 ?></td>

                                        <?php
                                        $total_lama_rawat = $lama_rawat->limpapeh_l2 + $lama_rawat->limpapeh_l3 + $lama_rawat->limpapeh_l4 + 
                                        $lama_rawat->singgalang_l1_l2 + $lama_rawat->singgalang_l3 + $lama_rawat->merapi_l1 + $lama_rawat->merapi_l2 +
                                        $lama_rawat->merapi_l3 + $lama_rawat->anak + $lama_rawat->bedah + $lama_rawat->kebidanan + $lama_rawat->icu + $lama_rawat->nicu;
                                        ?>
                                        <td><?= $total_lama_rawat ?></td>


                                        <?php
                                        $total_pasien_akhir_all = $pasien_akhir_limpapeh_l2 + $pasien_akhir_limpapeh_l3 +  $pasien_akhir_limpapeh_l4 + 
                                        $pasien_akhir_singgalang_l1_l2 + $pasien_akhir_singgalang_l3 + $pasien_akhir_merapi_l1 + $pasien_akhir_merapi_l2 +
                                        $pasien_akhir_merapi_l3 + $pasien_akhir_anak + $pasien_akhir_bedah +  $pasien_akhir_kebidanan + $pasien_akhir_icu + $pasien_akhir_nicu;
                                        ?>
                                        <td><?= $total_pasien_akhir_all ?></td>

                                        <?php
                                        $total_hari_rawat = $hari_perawatan->limpapeh_l2 + $hari_perawatan->limpapeh_l3 + $hari_perawatan->limpapeh_l4 + 
                                        $hari_perawatan->singgalang_l1_l2 + $hari_perawatan->singgalang_l3 + $hari_perawatan->merapi_l1 + $hari_perawatan->merapi_l2 +
                                        $hari_perawatan->merapi_l3 + $hari_perawatan->anak + $hari_perawatan->bedah + $hari_perawatan->kebidanan + $hari_perawatan->icu + $hari_perawatan->nicu;
                                        ?>
                                        <td><?= $total_hari_rawat ?></td>

                                        <?php
                                        $total_hari_rawat_vip = $hari_perawatan_vip->limpapeh_l2 + $hari_perawatan_vip->limpapeh_l3 + $hari_perawatan_vip->limpapeh_l4 + 
                                        $hari_perawatan_vip->singgalang_l1_l2 + $hari_perawatan_vip->singgalang_l3 + $hari_perawatan_vip->merapi_l1 + $hari_perawatan_vip->merapi_l2 +
                                        $hari_perawatan_vip->merapi_l3 + $hari_perawatan_vip->anak + $hari_perawatan_vip->bedah + $hari_perawatan_vip->kebidanan + $hari_perawatan_vip->icu + $hari_perawatan_vip->nicu;
                                        ?>
                                        <td><?= $total_hari_rawat_vip ?></td>

                                        <?php
                                        $total_hari_rawat_satu = $hari_perawatan_satu->limpapeh_l2 + $hari_perawatan_satu->limpapeh_l3 + $hari_perawatan_satu->limpapeh_l4 + 
                                        $hari_perawatan_satu->singgalang_l1_l2 + $hari_perawatan_satu->singgalang_l3 + $hari_perawatan_satu->merapi_l1 + $hari_perawatan_satu->merapi_l2 +
                                        $hari_perawatan_satu->merapi_l3 + $hari_perawatan_satu->anak + $hari_perawatan_satu->bedah + $hari_perawatan_satu->kebidanan + $hari_perawatan_satu->icu + $hari_perawatan_satu->nicu;
                                        ?>
                                        <td><?=  $total_hari_rawat_satu ?></td>

                                        <?php
                                        $total_hari_rawat_dua = $hari_perawatan_dua->limpapeh_l2 + $hari_perawatan_dua->limpapeh_l3 + $hari_perawatan_dua->limpapeh_l4 + 
                                        $hari_perawatan_dua->singgalang_l1_l2 + $hari_perawatan_dua->singgalang_l3 + $hari_perawatan_dua->merapi_l1 + $hari_perawatan_dua->merapi_l2 +
                                        $hari_perawatan_dua->merapi_l3 + $hari_perawatan_dua->anak + $hari_perawatan_dua->bedah + $hari_perawatan_dua->kebidanan + $hari_perawatan_dua->icu + $hari_perawatan_dua->nicu;
                                        ?>
                                        <td><?= $total_hari_rawat_dua ?></td>

                                        <?php
                                        $total_hari_rawat_tiga = $hari_perawatan_tiga->limpapeh_l2 + $hari_perawatan_tiga->limpapeh_l3 + $hari_perawatan_tiga->limpapeh_l4 + 
                                        $hari_perawatan_tiga->singgalang_l1_l2 + $hari_perawatan_tiga->singgalang_l3 + $hari_perawatan_tiga->merapi_l1 + $hari_perawatan_tiga->merapi_l2 +
                                        $hari_perawatan_tiga->merapi_l3 + $hari_perawatan_tiga->anak + $hari_perawatan_tiga->bedah + $hari_perawatan_tiga->kebidanan + $hari_perawatan_tiga->icu + $hari_perawatan_tiga->nicu;
                                        ?>
                                        <td><?= $total_hari_rawat_tiga ?></td>

                                        <?php
                                        $total_tt_vip = $tt_vip->limpapeh_l2 + $tt_vip->limpapeh_l3 + $tt_vip->limpapeh_l4 + 
                                        $tt_vip->singgalang_l1_l2 + $tt_vip->singgalang_l3 + $tt_vip->merapi_l1 + $tt_vip->merapi_l2 +
                                        $tt_vip->merapi_l3 + $tt_vip->anak + $tt_vip->bedah + $tt_vip->kebidanan + $tt_vip->icu + $tt_vip->nicu;
                                        ?>
                                        <td><?= $total_tt_vip ?></td>

                                        <?php
                                        $total_tt_satu = $tt_satu->limpapeh_l2 + $tt_satu->limpapeh_l3 + $tt_satu->limpapeh_l4 + 
                                        $tt_satu->singgalang_l1_l2 + $tt_satu->singgalang_l3 + $tt_satu->merapi_l1 + $tt_satu->merapi_l2 +
                                        $tt_satu->merapi_l3 + $tt_satu->anak + $tt_satu->bedah + $tt_satu->kebidanan + $tt_satu->icu + $tt_satu->nicu;
                                        ?>
                                        <td><?=  $total_tt_satu ?></td>

                                        <?php
                                        $total_tt_dua = $tt_dua->limpapeh_l2 + $tt_dua->limpapeh_l3 + $tt_dua->limpapeh_l4 + 
                                        $tt_dua->singgalang_l1_l2 + $tt_dua->singgalang_l3 + $tt_dua->merapi_l1 + $tt_dua->merapi_l2 +
                                        $tt_dua->merapi_l3 + $tt_dua->anak + $tt_dua->bedah + $tt_dua->kebidanan + $tt_dua->icu + $tt_dua->nicu;
                                        ?>
                                        <td><?= $total_tt_dua ?></td>

                                        <?php
                                        $total_tt_tiga = $tt_tiga->limpapeh_l2 + $tt_tiga->limpapeh_l3 + $tt_tiga->limpapeh_l4 + 
                                        $tt_tiga->singgalang_l1_l2 + $tt_tiga->singgalang_l3 + $tt_tiga->merapi_l1 + $tt_tiga->merapi_l2 +
                                        $tt_tiga->merapi_l3 + $tt_tiga->anak + $tt_tiga->bedah + $tt_tiga->kebidanan + $tt_tiga->icu + $tt_tiga->nicu;
                                        ?>
                                        <td><?= $total_tt_tiga ?></td>


                                        <?php 
                                            $total_tt_nicu = $tt_vip->nicu + $tt_satu->nicu + $tt_dua->nicu + $tt_tiga->nicu;
                                        ?>
                                        <?php 
                                        $jml_total_tt= $total_tt_limpapeh_l2 + $total_tt_limpapeh_l3 + $total_tt_limpapeh_l4 + $total_tt_singgalang_l1_l2 +
                                        $total_tt_singgalang_l3 + $total_tt_merapi_l1 + $total_tt_merapi_l2 + $total_tt_merapi_l3 + $total_tt_anak + $total_tt_bedah + $total_tt_kebidanan + $total_tt_icu +  $total_tt_nicu;
                                        ?>
                                        <td><?= $jml_total_tt ?></td>
                                        <?php 
                                        $bulannow_total= date("d");
                                        $bor1_vip_total = $total_tt_vip * $bulannow_total;
                                        $bor2_vip_total = $total_hari_rawat_vip /  $bor1_vip_total;
                                        $bor3_vip_total = $bor2_vip_total * 100;
                                        ?>
                                        <td><?= number_format($bor3_vip_total,2).'%' ?></td>
                                        <?php 
                                        $bor1_satu_total = $total_tt_satu * $bulannow_total;
                                        $bor2_satu_total = $total_hari_rawat_satu /  $bor1_satu_total;
                                        $bor3_satu_total = $bor2_satu_total * 100;
                                        ?>
                                        <td><?= number_format($bor3_satu_total,2).'%' ?></td>
                                        <?php 
                                        $bor1_dua_total = $total_tt_dua * $bulannow_total;
                                        $bor2_dua_total = $total_hari_rawat_dua /  $bor1_dua_total;
                                        $bor3_dua_total = $bor2_dua_total * 100;
                                        ?>
                                        <td><?= number_format($bor3_dua_total,2).'%' ?></td>
                                        <?php 
                                        $bor1_tiga_total = $total_tt_tiga * $bulannow_total;
                                        $bor2_tiga_total = $total_hari_rawat_tiga /  $bor1_tiga_total;
                                        $bor3_tiga_total = $bor2_tiga_total * 100;
                                        ?>
                                         <td><?= number_format($bor3_tiga_total,2).'%' ?></td>
                                        <?php 
                                        $bor1_akhir_total = $jml_total_tt * $bulannow_total;
                                        $bor2_akhir_total = $total_hari_rawat /  $bor1_akhir_total;
                                        $bor3_akhir_total = $bor2_akhir_total * 100;
                                        ?>
                                        <td><?= number_format($bor3_akhir_total,2).'%' ?></td>
                                    </tr>

                            

                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>
                                <?php       
                                }
                            ?>
                            </tbody>
                        </table>   
                        <div style="margin-right:1000px">
                <?php
                        if($datanya != null){
                        $avlos = $total_lama_rawat / $total_pasien_keluar_hidup_mati;
                        $bto = $total_pasien_keluar_hidup_mati / $jml_total_tt;
                        $gdr = $total_pasien_keluar_mati / $total_pasien_keluar_hidup_mati * 1000;
                        $ndr = $total_pasien_mati_lebih48 / $total_pasien_keluar_hidup_mati * 1000;
                        $periode = date("d");
                        $toi1 = $jml_total_tt * $periode;
                        $toi2 =  $toi1 - $total_hari_rawat;
                        $toi3 = $toi2 / $total_pasien_keluar_hidup_mati;
                    ?>
                        <h3 style="background-color:#e91d63;color:white;padding:8px">BOR RS :<?= number_format($bor3_akhir_total,2).'%' ?></h3>
                        <h3 style="background-color:#1dd2e9;color:white;padding:8px">AVLOS : <?= ceil($avlos) ?></h3>
                        <h3 style="background-color:red;color:white;padding:8px">TOI : <?= ceil($toi3) ?></h3>
                        <h3 style="background-color:purple;color:white;padding:8px">BTO : <?= ceil($bto) ?></h3>
                        <h3 style="background-color:#00b050;color:white;padding:8px">GDR :  <?= ceil( $gdr) ?></h3>
                        <h3 style="background-color:blue;color:white;padding:8px">NDR : <?= ceil( $ndr) ?></h3>
                    <?php } ?>
                        

                        
                        </div>
                    </div>     
                <a href="<?php echo site_url('irj/Rjclaporan/excel_bor_los_toi_new/'.$bulannow);?>">
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
