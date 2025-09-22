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
        <h4 align="center"></h4></div>
            <div class="table-responsive col-sm-12">
                <table class="  table table-striped">
                    <thead>
                        <tr>
                            <th>BULAN</th>
                            <th>BOR</th>
                            <th>LOS</th>
                            <th>TOI</th>
                            <th>BTO</th>
                            <th>NDR</th>
                            <th>GDR</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                       $tahun_now = date('Y');
                       $jmlh_bed = $bed->bed;
                      ?>
                        <tr>
                                    <td>JANUARI</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHarijan = cal_days_in_month(CAL_GREGORIAN, 1, $tahun_now);
                                            $bulan_jan = $tahun_now.'-'.'01';
                                            if( date('Y-m') == $bulan_jan || date('Y-m') > $bulan_jan){ 
                                                $hari_perawatanjan = $hari_perawatan->hp_januari;
                                                $bawah_jan =  $jmlh_bed*$jumHarijan;
                                                $bor_blm_persen =  $hari_perawatanjan / $bawah_jan;
                                                $bor_fix = $bor_blm_persen * 100;
                                            ?>
                                            <td><?= number_format($bor_fix,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') == $bulan_jan || date('Y-m') > $bulan_jan){ 
                                                $lama_rawatjan = $lama_perawatan->lamrat_januari;
                                                $pasien_keluarjan = $pasien_keluar->keluar_januari;
                                                $los = $lama_rawatjan / $pasien_keluarjan;
                                                
                                            ?>
                                            <td><?= round($los).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') == $bulan_jan || date('Y-m') > $bulan_jan){
                                                $atasjan = $bawah_jan - $hari_perawatanjan;
                                                $toi =  $atasjan/$pasien_keluarjan ;
                                                // var_dump($toi);die();
                                                
                                            ?>
                                            <td><?= round($toi).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') == $bulan_jan || date('Y-m') > $bulan_jan){
                                                $bto = $pasien_keluarjan / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_jan){
                                                $pasien_meninggal48_jan = $pasien_meninggal_lbh_48->meninggal_lebih48_januari;
                                                $ndr_jan_blm_permil = $pasien_meninggal48_jan / $pasien_keluarjan;
                                                $ndr_jan_fix = $ndr_jan_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_jan_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_jan){
                                                $pasien_meninggal_jan = $pasien_meninggal->meninggal_januari;
                                                $gdr_jan_blm_permil = $pasien_meninggal_jan / $pasien_keluarjan;
                                                $gdr_jan_fix = $gdr_jan_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_jan_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>


                                 

                           
                        </tr>

                        <tr>
                                    <td>FEBRUARI</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHarifeb = cal_days_in_month(CAL_GREGORIAN, 2, $tahun_now);
                                            $bulan_feb = $tahun_now.'-'.'02';
                                            if( date('Y-m') >= $bulan_feb){ 
                                                $hari_perawatanfeb = $hari_perawatan->hp_februari;
                                                $bawahfeb =  $jmlh_bed*$jumHarifeb;
                                                $bor_blm_persen_feb =  $hari_perawatanfeb / $bawahfeb;
                                                $bor_fix_feb = $bor_blm_persen_feb * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_feb,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_feb){ 
                                                $lama_rawat_feb = $lama_perawatan->lamrat_februari;
                                                $pasien_keluar_feb = $pasien_keluar->keluar_februari;
                                                $los_feb = $lama_rawat_feb / $pasien_keluar_feb;
                                                
                                            ?>
                                            <td><?= round($los_feb).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_feb){
                                                $atas_feb = $bawahfeb - $hari_perawatanfeb;
                                                $toi_feb =  $atas_feb/$pasien_keluar_feb ;
                                                // var_dump($toi);die();
                                                
                                            ?>
                                            <td><?= round($toi_feb).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_feb){
                                                $bto_feb = $pasien_keluar_feb / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_feb).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                            
                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_feb){
                                                $pasien_meninggal48_feb = $pasien_meninggal_lbh_48->meninggal_lebih48_februari;
                                                $ndr_feb_blm_permil = $pasien_meninggal48_feb / $pasien_keluar_feb;
                                                $ndr_feb_fix = $ndr_feb_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_feb_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_feb){
                                                $pasien_meninggal_feb = $pasien_meninggal->meninggal_februari;
                                                $gdr_feb_blm_permil = $pasien_meninggal_feb / $pasien_keluar_feb;
                                                $gdr_feb_fix = $gdr_feb_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_feb_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>MARET</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHarimar = cal_days_in_month(CAL_GREGORIAN, 3, $tahun_now);
                                            $bulan_maret = $tahun_now.'-'.'03';
                                            if( date('Y-m') >= $bulan_maret){ 
                                                $hari_perawatan_mar = $hari_perawatan->hp_maret;
                                                $bawah_mar =  $jmlh_bed*$jumHarimar;
                                                $bor_blm_persen_mar =  $hari_perawatan_mar / $bawah_mar;
                                                $bor_fix_mar = $bor_blm_persen_mar * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_mar,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_maret){ 
                                                $lama_rawat_mar = $lama_perawatan->lamrat_maret;
                                                $pasien_keluar_mar = $pasien_keluar->keluar_maret;
                                                $los_mar = $lama_rawat_mar / $pasien_keluar_mar;
                                                
                                            ?>
                                            <td><?= round($los_mar).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_maret){
                                                $atas_mar = $bawah_mar - $hari_perawatan_mar;
                                                $toi_mar =  $atas_mar/$pasien_keluar_mar ;
                                                // var_dump($toi_mar);die();
                                                
                                            ?>
                                            <td><?= round($toi_mar).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_maret){
                                                $bto_mar = $pasien_keluar_mar / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_mar).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_maret){
                                                $pasien_meninggal48_mar = $pasien_meninggal_lbh_48->meninggal_lebih48_maret;
                                                $ndr_mar_blm_permil = $pasien_meninggal48_mar / $pasien_keluar_mar;
                                                $ndr_mar_fix = $ndr_mar_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_mar_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_maret){
                                                $pasien_meninggal_mar = $pasien_meninggal->meninggal_maret;
                                                $gdr_mar_blm_permil = $pasien_meninggal_mar / $pasien_keluar_mar;
                                                $gdr_mar_fix = $gdr_mar_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_mar_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>APRIL</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHariapril = cal_days_in_month(CAL_GREGORIAN, 4, $tahun_now);
                                            $bulan_april = $tahun_now.'-'.'04';
                                            if( date('Y-m') >= $bulan_april){ 
                                                $hari_perawatan_apr = $hari_perawatan->hp_april;
                                                $bawah_april =  $jmlh_bed*$jumHariapril;
                                                $bor_blm_persen_apr =  $hari_perawatan_apr / $bawah_april;
                                                $bor_fix_april = $bor_blm_persen_apr * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_april,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_april){ 
                                                $lama_rawat_apr = $lama_perawatan->lamrat_april;
                                                $pasien_keluar_apr = $pasien_keluar->keluar_april;
                                                $los_apr = $lama_rawat_apr / $pasien_keluar_apr;
                                                
                                            ?>
                                            <td><?= round($los_apr).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_april){
                                                $atas_april = $bawah_april - $hari_perawatan_apr;
                                                $toi_april =  $atas_april/$pasien_keluar_apr ;
                                                // var_dump($toi);die();
                                                
                                            ?>
                                            <td><?= round($toi_april).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_april){
                                                $bto_april = $pasien_keluar_apr / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_april).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_april){
                                                $pasien_meninggal48_apr = $pasien_meninggal_lbh_48->meninggal_lebih48_april;
                                                $ndr_apr_blm_permil = $pasien_meninggal48_apr / $pasien_keluar_apr;
                                                $ndr_apr_fix = $ndr_apr_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_apr_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_april){
                                                $pasien_meninggal_apr = $pasien_meninggal->meninggal_april;
                                                $gdr_apr_blm_permil = $pasien_meninggal_apr / $pasien_keluar_apr;
                                                $gdr_apr_fix = $gdr_apr_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_apr_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>MEI</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHariMei = cal_days_in_month(CAL_GREGORIAN, 5, $tahun_now);
                                            $bulan_mei = $tahun_now.'-'.'05';
                                            if( date('Y-m') >= $bulan_mei){ 
                                                $hari_perawatan_mei = $hari_perawatan->hp_mei;
                                                $bawah_mei =  $jmlh_bed*$jumHariMei;
                                                $bor_blm_persen_mei =  $hari_perawatan_mei / $bawah_mei;
                                                $bor_fix_mei = $bor_blm_persen_mei * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_mei,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_mei){ 
                                                $lama_rawat_mei = $lama_perawatan->lamrat_mei;
                                                $pasien_keluar_mei = $pasien_keluar->keluar_mei;
                                                $los_mei = $lama_rawat_mei / $pasien_keluar_mei;
                                                
                                            ?>
                                            <td><?= round($los_mei).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_mei){
                                                $atas_mei = $bawah_mei - $hari_perawatan_mei;
                                                $toi_mei =  $atas_mei/$pasien_keluar_mei ;
                                                // var_dump($toi);die();
                                                
                                            ?>
                                            <td><?= round($toi_mei).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_mei){
                                                $bto_mei = $pasien_keluar_mei / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_mei).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_mei){
                                                $pasien_meninggal48_mei = $pasien_meninggal_lbh_48->meninggal_lebih48_mei;
                                                $ndr_mei_blm_permil = $pasien_meninggal48_mei / $pasien_keluar_mei;
                                                $ndr_mei_fix = $ndr_mei_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_mei_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_mei){
                                                $pasien_meninggal_mei = $pasien_meninggal->meninggal_mei;
                                                $gdr_mei_blm_permil = $pasien_meninggal_mei / $pasien_keluar_mei;
                                                $gdr_mei_fix = $gdr_mei_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_mei_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>JUNI</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHariJuni = cal_days_in_month(CAL_GREGORIAN, 6, $tahun_now);
                                            $bulan_juni = $tahun_now.'-'.'06';
                                            if( date('Y-m') >= $bulan_juni){ 
                                                $hari_perawatan_jun = $hari_perawatan->hp_juni;
                                                $bawah_juni =  $jmlh_bed*$jumHariJuni;
                                                $bor_blm_persen_juni =  $hari_perawatan_jun / $bawah_juni;
                                                $bor_fix_juni = $bor_blm_persen_juni * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_juni,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_juni){ 
                                                $lama_rawat_juni = $lama_perawatan->lamrat_juni;
                                                $pasien_keluar_juni = $pasien_keluar->keluar_juni;
                                                $los_juni = $lama_rawat_juni / $pasien_keluar_juni;
                                                
                                            ?>
                                            <td><?= round($los_juni).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_juni){
                                                $atas_juni = $bawah_juni - $hari_perawatan_jun;
                                                $toi_juni =  $atas_juni/$pasien_keluar_juni ;
                                                // var_dump($toi_juni);die();
                                                
                                            ?>
                                            <td><?= round($toi_juni).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_juni){
                                                $bto_juni = $pasien_keluar_juni / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_juni).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_juni){
                                                $pasien_meninggal48_jun = $pasien_meninggal_lbh_48->meninggal_lebih48_juni;
                                                $ndr_jun_blm_permil = $pasien_meninggal48_jun / $pasien_keluar_juni;
                                                $ndr_jun_fix = $ndr_jun_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_jun_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_juni){
                                                $pasien_meninggal_jun = $pasien_meninggal->meninggal_juni;
                                                $gdr_jun_blm_permil = $pasien_meninggal_jun / $pasien_keluar_juni;
                                                $gdr_jun_fix = $gdr_jun_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_jun_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>JULI</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHariJuli = cal_days_in_month(CAL_GREGORIAN, 7, $tahun_now);
                                            $bulan_juli = $tahun_now.'-'.'07';
                                            if( date('Y-m') >= $bulan_juli){ 
                                                $hari_perawatan_juli = $hari_perawatan->hp_juli;
                                                $bawah_juli =  $jmlh_bed*$jumHariJuli;
                                                $bor_blm_persen_juli =  $hari_perawatan_juli / $bawah_juli;
                                                $bor_fix_juli = $bor_blm_persen_juli * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_juli,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_juli){ 
                                                $lama_rawat_juli = $lama_perawatan->lamrat_juli;
                                                $pasien_keluar_juli = $pasien_keluar->keluar_juli;
                                                $los_juli = $lama_rawat_juli / $pasien_keluar_juli;
                                                
                                            ?>
                                            <td><?= round($los_juli).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_juli){
                                                $atas_juli = $bawah_juli - $hari_perawatan_juli;
                                                $toi_juli =  $atas_juli/$pasien_keluar_juli ;
                                                // var_dump($toi_juli);die();
                                                
                                            ?>
                                            <td><?= round($toi_juli).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_juli){
                                                $bto_juli = $pasien_keluar_juli / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_juli).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_juli){
                                                $pasien_meninggal48_jul = $pasien_meninggal_lbh_48->meninggal_lebih48_juli;
                                                $ndr_jul_blm_permil = $pasien_meninggal48_jul / $pasien_keluar_juli;
                                                $ndr_jul_fix = $ndr_jul_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_jul_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_juli){
                                                $pasien_meninggal_jul = $pasien_meninggal->meninggal_juli;
                                                $gdr_jul_blm_permil = $pasien_meninggal_jul / $pasien_keluar_juli;
                                                $gdr_jul_fix = $gdr_jul_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_jul_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>AGUSTUS</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHariAgustus = cal_days_in_month(CAL_GREGORIAN, 8, $tahun_now);
                                            $bulan_agus = $tahun_now.'-'.'08';
                                            if( date('Y-m') >= $bulan_agus){ 
                                                $hari_perawatan_agus = $hari_perawatan->hp_agustus;
                                                $bawah_agus =  $jmlh_bed*$jumHariAgustus;
                                                $bor_blm_persen_agus =  $hari_perawatan_agus / $bawah_agus;
                                                $bor_fix_agus = $bor_blm_persen_agus * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_agus,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_agus){ 
                                                $lama_rawat_agus = $lama_perawatan->lamrat_agustus;
                                                $pasien_keluar_agus = $pasien_keluar->keluar_agustus;
                                                $los_agus = $lama_rawat_agus / $pasien_keluar_agus;
                                                
                                            ?>
                                            <td><?= round($los_agus).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_agus){
                                                $atas_agus = $bawah_agus - $hari_perawatan_agus;
                                                $toi_agus =  $atas_agus/$pasien_keluar_agus ;
                                                // var_dump($toi_agus);die();
                                                
                                            ?>
                                            <td><?= round($toi_agus).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_agus){
                                                $bto_agus = $pasien_keluar_agus / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_agus).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_agus){
                                                $pasien_meninggal48_agus = $pasien_meninggal_lbh_48->meninggal_lebih48_agustus;
                                                $ndr_agus_blm_permil = $pasien_meninggal48_agus / $pasien_keluar_agus;
                                                $ndr_agus_fix = $ndr_agus_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_agus_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_agus){
                                                $pasien_meninggal_agus = $pasien_meninggal->meninggal_agustus;
                                                $gdr_agus_blm_permil = $pasien_meninggal_agus / $pasien_keluar_agus;
                                                $gdr_agus_fix = $gdr_agus_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_agus_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>SEPTEMBER</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHarisep = cal_days_in_month(CAL_GREGORIAN, 9, $tahun_now);
                                            $bulan_sep = $tahun_now.'-'.'09';
                                            if( date('Y-m') >= $bulan_sep){ 
                                                $hari_perawatan_sep = $hari_perawatan->hp_september;
                                                $bawah_sep =  $jmlh_bed*$jumHarisep;
                                                $bor_blm_persen_sep =  $hari_perawatan_sep / $bawah_sep;
                                                $bor_fix_sep = $bor_blm_persen_sep * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_sep,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_sep){ 
                                                $lama_rawat_sep = $lama_perawatan->lamrat_september;
                                                $pasien_keluar_sep = $pasien_keluar->keluar_september;
                                                $los_sep = $lama_rawat_sep / $pasien_keluar_sep;
                                                
                                            ?>
                                            <td><?= round($los_sep).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_sep){
                                                $atas_sep = $bawah_sep - $hari_perawatan_sep;
                                                $toi_sep =  $atas_sep/$pasien_keluar_sep ;
                                                // var_dump($toi_sep);die();
                                                
                                            ?>
                                            <td><?= round($toi_sep).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_sep){
                                                $bto_sep = $pasien_keluar_sep / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_sep).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_sep){
                                                $pasien_meninggal48_sep = $pasien_meninggal_lbh_48->meninggal_lebih48_september;
                                                $ndr_sep_blm_permil = $pasien_meninggal48_sep / $pasien_keluar_sep;
                                                $ndr_sep_fix = $ndr_sep_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_sep_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_sep){
                                                $pasien_meninggal_sep = $pasien_meninggal->meninggal_september;
                                                $gdr_sep_blm_permil = $pasien_meninggal_sep / $pasien_keluar_sep;
                                                $gdr_sep_fix = $gdr_sep_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_sep_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>OKTOBER</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHariokt = cal_days_in_month(CAL_GREGORIAN, 10, $tahun_now);
                                            $bulan_okt = $tahun_now.'-'.'10';
                                            if( date('Y-m') >= $bulan_okt){ 
                                                $hari_perawatan_okt = $hari_perawatan->hp_oktober;
                                                $bawah_okt =  $jmlh_bed*$jumHariokt;
                                                $bor_blm_persen_okt =  $hari_perawatan_okt / $bawah_okt;
                                                $bor_fix_okt = $bor_blm_persen_okt * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_okt,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_okt){ 
                                                $lama_rawat_okt = $lama_perawatan->lamrat_oktober;
                                                $pasien_keluar_okt = $pasien_keluar->keluar_oktober;
                                                $los_okt = $lama_rawat_okt / $pasien_keluar_okt;
                                                
                                            ?>
                                            <td><?= round($los_okt).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_okt){
                                                $atas_okt = $bawah_okt - $hari_perawatan_okt;
                                                $toi_okt =  $atas_okt/$pasien_keluar_okt ;
                                                // var_dump($toi_okt);die();
                                                
                                            ?>
                                            <td><?= round($toi_okt).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_okt){
                                                $bto_okt = $pasien_keluar_okt / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_okt).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_okt){
                                                $pasien_meninggal48_okt = $pasien_meninggal_lbh_48->meninggal_lebih48_okt;
                                                $ndr_okt_blm_permil = $pasien_meninggal48_okt / $pasien_keluar_okt;
                                                $ndr_okt_fix = $ndr_okt_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_okt_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_okt){
                                                $pasien_meninggal_okt = $pasien_meninggal->meninggal_okt;
                                                $gdr_okt_blm_permil = $pasien_meninggal_okt / $pasien_keluar_okt;
                                                $gdr_okt_fix = $gdr_okt_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_okt_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>NOVEMBER</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHariNov = cal_days_in_month(CAL_GREGORIAN, 11, $tahun_now);
                                            $bulan_nov = $tahun_now.'-'.'11';
                                            if( date('Y-m') >= $bulan_nov){ 
                                                $hari_perawatan_nov = $hari_perawatan->hp_november;
                                                $bawah_nov =  $jmlh_bed*$jumHariNov;
                                                $bor_blm_persen_nov =  $hari_perawatan_nov / $bawah_nov;
                                                $bor_fix_nov = $bor_blm_persen_nov * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_nov,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_nov){ 
                                                $lama_rawat_nov = $lama_perawatan->lamrat_november;
                                                $pasien_keluar_nov = $pasien_keluar->keluar_november;
                                                $los_nov = $lama_rawat_nov / $pasien_keluar_nov;
                                                
                                            ?>
                                            <td><?= round($los_nov).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_nov){
                                                $atas_nov = $bawah_nov - $hari_perawatan_nov;
                                                $toi_nov =  $atas_nov/$pasien_keluar_nov ;
                                                // var_dump($toi_nov);die();
                                                
                                            ?>
                                            <td><?= round($toi_nov).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_nov){
                                                $bto_nov = $pasien_keluar_nov / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_nov).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_nov){
                                                $pasien_meninggal48_nov = $pasien_meninggal_lbh_48->meninggal_lebih48_nov;
                                                $ndr_nov_blm_permil = $pasien_meninggal48_nov / $pasien_keluar_nov;
                                                $ndr_nov_fix = $ndr_nov_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_nov_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_nov){
                                                $pasien_meninggal_nov = $pasien_meninggal->meninggal_nov;
                                                $gdr_nov_blm_permil = $pasien_meninggal_nov / $pasien_keluar_nov;
                                                $gdr_nov_fix = $gdr_nov_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_nov_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                        <tr>
                                    <td>DESEMBER</td>
                                    <!-- BOR -->
                                            <?php 
                                            $jumHariDes = cal_days_in_month(CAL_GREGORIAN, 12, $tahun_now);
                                            $bulan_des = $tahun_now.'-'.'12';
                                            if( date('Y-m') >= $bulan_des){ 
                                                $hari_perawatan_des = $hari_perawatan->hp_desember;
                                                $bawah_des =  $jmlh_bed*$jumHariDes;
                                                $bor_blm_persen_des =  $hari_perawatan_des / $bawah_des;
                                                $bor_fix_des = $bor_blm_persen_des * 100;
                                            ?>
                                            <td><?= number_format($bor_fix_des,2).'%' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- LOS -->
                                            <?php
                                            if( date('Y-m') >= $bulan_des){ 
                                                $lama_rawat_des = $lama_perawatan->lamrat_desember;
                                                $pasien_keluar_des = $pasien_keluar->keluar_desember;
                                                $los_des = $lama_rawat_des / $pasien_keluar_des;
                                                
                                            ?>
                                            <td><?= round($los_des).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!--  TOI -->
                                            <?php
                                            if( date('Y-m') >= $bulan_des){
                                                $atas_des = $bawah_des - $hari_perawatan_des;
                                                $toi_des =  $atas_des/$pasien_keluar_des ;
                                                // var_dump($toi_des);die();
                                                
                                            ?>
                                            <td><?= round($toi_des).' '.'Hari' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- BTO  -->

                                    <?php
                                            if( date('Y-m') >= $bulan_des){
                                                $bto_des = $pasien_keluar_des / $jmlh_bed;
                                                
                                            ?>
                                            <td><?= round($bto_des).' '.'Kali' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- NDR -->

                                    <?php
                                            if(date('Y-m') >= $bulan_des){
                                                $pasien_meninggal48_des = $pasien_meninggal_lbh_48->meninggal_lebih48_des;
                                                $ndr_des_blm_permil = $pasien_meninggal48_des / $pasien_keluar_des;
                                                $ndr_des_fix = $ndr_des_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($ndr_des_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>

                                    <!-- GDR -->

                                    <?php

                                            if(date('Y-m') >= $bulan_des){
                                                $pasien_meninggal_des = $pasien_meninggal->meninggal_des;
                                                $gdr_des_blm_permil = $pasien_meninggal_des / $pasien_keluar_des;
                                                $gdr_des_fix = $gdr_des_blm_permil * 1000;
                                                
                                            ?>
                                            <td><?= number_format($gdr_des_fix,2).'‰' ?></td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                            <?php   } ?>
                           
                        </tr>

                    </tbody>
                </table>   
            </div>     
                <a href="<?php echo site_url('irj/Rjclaporan/download_bor_los_toi');?>">
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
