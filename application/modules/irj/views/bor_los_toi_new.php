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
      
        $('#example').DataTable();
      

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
                <form method="post" action="<?= base_url('irj/rjclaporan/bor_los_toi_ruangan') ?>">
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

                            <a href="<?php echo site_url('irj/Rjclaporan/menu_monitoring_jmlh_bed_ruangan/');?>">
                            <input type="button" class="btn" style="background-color: grey;color:white;" value="HITUNG BED"></a>
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
                <!-- <h4 align="center" style="font-weight:bold">PELAYANAN RAWAT INAP</h4></div> -->
                    <div class="table-responsive col-sm-12">
                        <center><h4><b>PELAYANAN RAWAT INAP LIMPAPEH L2</b></h4></center>
                        <table   class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_limpapeh_l2 = "idrg = '0801'";
                                $total_pasien_awal = 0;
                                $total_pasien_masuk = 0;
                                $total_pasien_masuk_pindah = 0;
                                $total_pasien_dirawat_all = 0;
                                $total_pasien_keluar_pindah = 0;
                                $total_pasien_keluar_hidup = 0;
                                $total_pasien_keluar_mati = 0;
                                $total_pasien_keluar_all = 0;
                                $total_pasien_keluar_hidup_mati = 0;
                                $total_pasien_mati_krg48= 0;
                                $total_pasien_mati_lbh48 = 0;
                                $total_lama_rawat = 0;
                                $total_hari_rawat = 0;
                                $total_hari_rawat_vip = 0;
                                $total_hari_rawat_satu = 0;
                                $total_hari_rawat_dua = 0;
                                $total_hari_rawat_tiga = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $pasien_masuk = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $pasien_masuk_pindah = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $pasien_keluar_pindah = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $pasien_keluar_hidup = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $pasien_keluar_mati = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $pasien_keluar_hidup_mati = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $pasien_mati_krg_48 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $pasien_mati_lbh_48 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $lama_rawat = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $hari_rawat = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_limpapeh_l2)->row();
                                    $hari_rawat_vip = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_limpapeh_l2)->row();
                                    $hari_rawat_satu = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_limpapeh_l2)->row();
                                    $hari_rawat_dua = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_limpapeh_l2)->row();
                                    $hari_rawat_tiga = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_limpapeh_l2)->row();
                                   
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal->jml  ?></td>
                                    <td><?= $pasien_masuk->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat = $pasien_awal->jml + $pasien_masuk->jml + $pasien_masuk_pindah->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat  ?></td>
                                    <td><?= $pasien_keluar_pindah->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup->jml  ?></td>
                                    <td><?= $pasien_keluar_mati->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar = $pasien_keluar_pindah->jml + $pasien_keluar_hidup->jml + $pasien_keluar_mati->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48->jml  ?></td>
                                    <td><?php if($lama_rawat->jml != null){echo $lama_rawat->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat = $hari_rawat->jml;
                                        $harirawat_vip = $hari_rawat_vip->jml;
                                        $harirawat_satu = $hari_rawat_satu->jml;
                                        $harirawat_dua = $hari_rawat_dua->jml;
                                        $harirawat_tiga = $hari_rawat_tiga->jml;
                                    }else{
                                        $harirawat = 0;
                                        $harirawat_vip = 0;
                                        $harirawat_satu = 0;
                                        $harirawat_dua = 0;
                                        $harirawat_tiga = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat  ?></td>
                                    <td><?= $harirawat_vip ?></td>
                                    <td><?= $harirawat_satu  ?></td>
                                    <td><?= $harirawat_dua ?></td>
                                    <td><?= $harirawat_tiga ?></td>
                                    
                                </tr>
                                <?php
                                 $total_pasien_awal += $pasien_awal->jml;
                                 $total_pasien_masuk += $pasien_masuk->jml;
                                 $total_pasien_masuk_pindah += $pasien_masuk_pindah->jml;
                                 $total_pasien_keluar_pindah += $pasien_keluar_pindah->jml;
                                 $total_pasien_dirawat_all += $total_pasien_dirawat;
                                 $total_pasien_keluar_pindah += $pasien_keluar_pindah->jml;
                                 $total_pasien_keluar_mati += $pasien_keluar_mati->jml;
                                 $total_pasien_keluar_hidup += $pasien_keluar_hidup->jml;
                                 $total_pasien_keluar_all += $total_pasien_keluar;
                                 $total_pasien_keluar_hidup_mati += $pasien_keluar_hidup_mati->jml;
                                 $total_pasien_mati_krg48 += $pasien_mati_krg_48->jml;
                                 $total_pasien_mati_lbh48 += $pasien_mati_lbh_48->jml;
                                 $total_lama_rawat += $lama_rawat->jml;
                                 $total_hari_rawat += $harirawat;
                                 $total_hari_rawat_vip += $harirawat_vip;
                                 $total_hari_rawat_satu += $harirawat_satu;
                                 $total_hari_rawat_dua += $harirawat_dua;
                                 $total_hari_rawat_tiga += $harirawat_tiga;
                                } ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal;?></td>
                                        <td><?php echo $total_pasien_masuk;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah;?></td>
                                        <td><?php echo $total_pasien_dirawat_all;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup;?></td>
                                        <td><?php echo $total_pasien_keluar_mati;?></td>
                                        <td><?php echo $total_pasien_keluar_all;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati;?></td>
                                        <td><?php echo $total_pasien_mati_krg48;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48;?></td>
                                        <td><?php echo $total_lama_rawat;?></td>
                                        <td><?php echo $total_hari_rawat;?></td>
                                        <td><?php echo $total_hari_rawat_vip;?></td>
                                        <td><?php echo $total_hari_rawat_satu;?></td>
                                        <td><?php echo $total_hari_rawat_dua;?></td>
                                        <td><?php echo $total_hari_rawat_tiga;?></td>
                                    </tr>
                                <?php  }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>  
                        
                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP LIMPAPEH L3</b></h4></center>
                        <table  id="example1" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_limpapeh_l3 = "idrg IN ('0802','0804')";
                                $total_pasien_awal_limpapeh_l3 = 0;
                                $total_pasien_masuk_limpapeh_l3 = 0;
                                $total_pasien_masuk_pindah_limpapeh_l3 = 0;
                                $total_pasien_dirawat_all_limpapeh_l3 = 0;
                                $total_pasien_keluar_pindah_limpapeh_l3 = 0;
                                $total_pasien_keluar_hidup_limpapeh_l3 = 0;
                                $total_pasien_keluar_mati_limpapeh_l3 = 0;
                                $total_pasien_keluar_all_limpapeh_l3 = 0;
                                $total_pasien_keluar_hidup_mati_limpapeh_l3 = 0;
                                $total_pasien_mati_krg48_limpapeh_l3= 0;
                                $total_pasien_mati_lbh48_limpapeh_l3 = 0;
                                $total_lama_rawat_limpapeh_l3 = 0;
                                $total_hari_rawat_limpapeh_l3 = 0;
                                $total_hari_rawat_vip_limpapeh_l3 = 0;
                                $total_hari_rawat_satu_limpapeh_l3 = 0;
                                $total_hari_rawat_dua_limpapeh_l3 = 0;
                                $total_hari_rawat_tiga_limpapeh_l3 = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_limpapeh_l3 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $pasien_masuk_limpapeh_l3 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $pasien_masuk_pindah_limpapeh_l3 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $pasien_keluar_pindah_limpapeh_l3 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $pasien_keluar_hidup_limpapeh_l3 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $pasien_keluar_mati_limpapeh_l3 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $pasien_keluar_hidup_mati_limpapeh_l3 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $pasien_mati_krg_48_limpapeh_l3 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $pasien_mati_lbh_48_limpapeh_l3 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $lama_rawat_limpapeh_l3 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $hari_rawat_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_limpapeh_l3)->row();
                                    $hari_rawat_vip_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_limpapeh_l3)->row();
                                    $hari_rawat_satu_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_limpapeh_l3)->row();
                                    $hari_rawat_dua_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_limpapeh_l3)->row();
                                    $hari_rawat_tiga_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_limpapeh_l3)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_limpapeh_l3->jml  ?></td>
                                    <td><?= $pasien_masuk_limpapeh_l3->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_limpapeh_l3->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_limpapeh_l3 = $pasien_awal_limpapeh_l3->jml + $pasien_masuk_limpapeh_l3->jml + $pasien_masuk_pindah_limpapeh_l3->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_limpapeh_l3  ?></td>
                                    <td><?= $pasien_keluar_pindah_limpapeh_l3->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_limpapeh_l3->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_limpapeh_l3->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_limpapeh_l3 = $pasien_keluar_pindah_limpapeh_l3->jml + $pasien_keluar_hidup_limpapeh_l3->jml + $pasien_keluar_mati_limpapeh_l3->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_limpapeh_l3  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_limpapeh_l3->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_limpapeh_l3->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_limpapeh_l3->jml  ?></td>
                                    <td><?php if($lama_rawat_limpapeh_l3->jml != null){echo $lama_rawat_limpapeh_l3->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_limpapeh_l3 = $hari_rawat_limpapeh_l3->jml;
                                        $harirawat_vip_limpapeh_l3 = $hari_rawat_vip_limpapeh_l3->jml;
                                        $harirawat_satu_limpapeh_l3 = $hari_rawat_satu_limpapeh_l3->jml;
                                        $harirawat_dua_limpapeh_l3 = $hari_rawat_dua_limpapeh_l3->jml;
                                        $harirawat_tiga_limpapeh_l3 = $hari_rawat_tiga_limpapeh_l3->jml;
                                    }else{
                                        $harirawat_limpapeh_l3 = 0;
                                        $harirawat_vip_limpapeh_l3 = 0;
                                        $harirawat_satu_limpapeh_l3 = 0;
                                        $harirawat_dua_limpapeh_l3 = 0;
                                        $harirawat_tiga_limpapeh_l3 = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_limpapeh_l3  ?></td>
                                    <td><?= $harirawat_vip_limpapeh_l3 ?></td>
                                    <td><?= $harirawat_satu_limpapeh_l3  ?></td>
                                    <td><?= $harirawat_dua_limpapeh_l3 ?></td>
                                    <td><?= $harirawat_tiga_limpapeh_l3 ?></td>   
                                </tr>
                                <?php
                                
                                    $total_pasien_awal_limpapeh_l3 += $pasien_awal_limpapeh_l3->jml;
                                    $total_pasien_masuk_limpapeh_l3 += $pasien_masuk_limpapeh_l3->jml;
                                    $total_pasien_masuk_pindah_limpapeh_l3 += $pasien_masuk_pindah_limpapeh_l3->jml;
                                    $total_pasien_dirawat_all_limpapeh_l3 += $total_pasien_dirawat_limpapeh_l3;
                                    $total_pasien_keluar_pindah_limpapeh_l3 += $pasien_keluar_pindah_limpapeh_l3->jml;
                                    $total_pasien_keluar_mati_limpapeh_l3 += $pasien_keluar_mati_limpapeh_l3->jml;
                                    $total_pasien_keluar_hidup_limpapeh_l3 += $pasien_keluar_hidup_limpapeh_l3->jml;
                                    $total_pasien_keluar_all_limpapeh_l3 += $total_pasien_keluar_limpapeh_l3;
                                    $total_pasien_keluar_hidup_mati_limpapeh_l3 += $pasien_keluar_hidup_mati_limpapeh_l3->jml;
                                    $total_pasien_mati_krg48_limpapeh_l3 += $pasien_mati_krg_48_limpapeh_l3->jml;
                                    $total_pasien_mati_lbh48_limpapeh_l3 += $pasien_mati_lbh_48_limpapeh_l3->jml;
                                    $total_lama_rawat_limpapeh_l3 += $lama_rawat_limpapeh_l3->jml;
                                    $total_hari_rawat_limpapeh_l3 += $harirawat_limpapeh_l3;
                                    $total_hari_rawat_vip_limpapeh_l3 += $harirawat_vip_limpapeh_l3;
                                    $total_hari_rawat_satu_limpapeh_l3 += $harirawat_satu_limpapeh_l3;
                                    $total_hari_rawat_dua_limpapeh_l3 += $harirawat_dua_limpapeh_l3;
                                    $total_hari_rawat_tiga_limpapeh_l3 += $harirawat_tiga_limpapeh_l3;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_masuk_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_all_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_limpapeh_l3;?></td>
                                        <td><?php echo $total_lama_rawat_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_vip_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_satu_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_dua_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_limpapeh_l3;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table> 
                        
                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP LIMPAPEH L4</b></h4></center>
                        <table  id="example2" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_limpapeh_l4 = "idrg IN ('0803','0805')";
                                    $total_pasien_awal_limpapeh_l4 = 0;
                                    $total_pasien_masuk_limpapeh_l4 = 0;
                                    $total_pasien_masuk_pindah_limpapeh_l4 = 0;
                                    $total_pasien_dirawat_all_limpapeh_l4 = 0;
                                    $total_pasien_keluar_pindah_limpapeh_l4 = 0;
                                    $total_pasien_keluar_hidup_limpapeh_l4 = 0;
                                    $total_pasien_keluar_mati_limpapeh_l4 = 0;
                                    $total_pasien_keluar_all_limpapeh_l4 = 0;
                                    $total_pasien_keluar_hidup_mati_limpapeh_l4 = 0;
                                    $total_pasien_mati_krg48_limpapeh_l4= 0;
                                    $total_pasien_mati_lbh48_limpapeh_l4 = 0;
                                    $total_lama_rawat_limpapeh_l4 = 0;
                                    $total_hari_rawat_limpapeh_l4 = 0;
                                    $total_hari_rawat_vip_limpapeh_l4 = 0;
                                    $total_hari_rawat_satu_limpapeh_l4 = 0;
                                    $total_hari_rawat_dua_limpapeh_l4 = 0;
                                    $total_hari_rawat_tiga_limpapeh_l4 = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_limpapeh_l4 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $pasien_masuk_limpapeh_l4 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $pasien_masuk_pindah_limpapeh_l4 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $pasien_keluar_pindah_limpapeh_l4 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $pasien_keluar_hidup_limpapeh_l4 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $pasien_keluar_mati_limpapeh_l4 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $pasien_keluar_hidup_mati_limpapeh_l4 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $pasien_mati_krg_48_limpapeh_l4 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $pasien_mati_lbh_48_limpapeh_l4 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $lama_rawat_limpapeh_l4 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $hari_rawat_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_limpapeh_l4)->row();
                                    $hari_rawat_vip_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_limpapeh_l4)->row();
                                    $hari_rawat_satu_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_limpapeh_l4)->row();
                                    $hari_rawat_dua_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_limpapeh_l4)->row();
                                    $hari_rawat_tiga_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_limpapeh_l4)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_limpapeh_l4->jml  ?></td>
                                    <td><?= $pasien_masuk_limpapeh_l4->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_limpapeh_l4->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_limpapeh_l4 = $pasien_awal_limpapeh_l4->jml + $pasien_masuk_limpapeh_l4->jml + $pasien_masuk_pindah_limpapeh_l4->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_limpapeh_l4  ?></td>
                                    <td><?= $pasien_keluar_pindah_limpapeh_l4->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_limpapeh_l4->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_limpapeh_l4->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_limpapeh_l4 = $pasien_keluar_pindah_limpapeh_l4->jml + $pasien_keluar_hidup_limpapeh_l4->jml + $pasien_keluar_mati_limpapeh_l4->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_limpapeh_l4  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_limpapeh_l4->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_limpapeh_l4->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_limpapeh_l4->jml  ?></td>
                                    <td><?php if($lama_rawat_limpapeh_l4->jml != null){echo $lama_rawat_limpapeh_l4->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_limpapeh_l4 = $hari_rawat_limpapeh_l4->jml;
                                        $harirawat_vip_limpapeh_l4 = $hari_rawat_vip_limpapeh_l4->jml;
                                        $harirawat_satu_limpapeh_l4 =  $hari_rawat_satu_limpapeh_l4->jml;
                                        $harirawat_dua_limpapeh_l4 = $hari_rawat_dua_limpapeh_l4->jml;
                                        $harirawat_tiga_limpapeh_l4 = $hari_rawat_tiga_limpapeh_l4->jml;
                                    }else{
                                        $harirawat_limpapeh_l4 = 0;
                                        $harirawat_vip_limpapeh_l4 = 0;
                                        $harirawat_satu_limpapeh_l4 = 0;
                                        $harirawat_dua_limpapeh_l4 = 0;
                                        $harirawat_tiga_limpapeh_l4 = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_limpapeh_l4  ?></td>
                                    <td><?= $harirawat_vip_limpapeh_l4 ?></td>
                                    <td><?= $harirawat_satu_limpapeh_l4  ?></td>
                                    <td><?= $harirawat_dua_limpapeh_l4 ?></td>
                                    <td><?= $harirawat_tiga_limpapeh_l4 ?></td>                                
                                </tr>
                                <?php
                                
                                    $total_pasien_awal_limpapeh_l4 += $pasien_awal_limpapeh_l4->jml;
                                    $total_pasien_masuk_limpapeh_l4 += $pasien_masuk_limpapeh_l4->jml;
                                    $total_pasien_masuk_pindah_limpapeh_l4 += $pasien_masuk_pindah_limpapeh_l4->jml;
                                    $total_pasien_dirawat_all_limpapeh_l4 += $total_pasien_dirawat_limpapeh_l4;
                                    $total_pasien_keluar_pindah_limpapeh_l4 += $pasien_keluar_pindah_limpapeh_l4->jml;
                                    $total_pasien_keluar_mati_limpapeh_l4 += $pasien_keluar_mati_limpapeh_l4->jml;
                                    $total_pasien_keluar_hidup_limpapeh_l4 += $pasien_keluar_hidup_limpapeh_l4->jml;
                                    $total_pasien_keluar_all_limpapeh_l4 += $total_pasien_keluar_limpapeh_l4;
                                    $total_pasien_keluar_hidup_mati_limpapeh_l4 += $pasien_keluar_hidup_mati_limpapeh_l4->jml;
                                    $total_pasien_mati_krg48_limpapeh_l4 += $pasien_mati_krg_48_limpapeh_l4->jml;
                                    $total_pasien_mati_lbh48_limpapeh_l4 += $pasien_mati_lbh_48_limpapeh_l4->jml;
                                    $total_lama_rawat_limpapeh_l4 += $lama_rawat_limpapeh_l4->jml;
                                    $total_hari_rawat_limpapeh_l4 += $harirawat_limpapeh_l4;
                                    $total_hari_rawat_vip_limpapeh_l4 += $harirawat_vip_limpapeh_l4;
                                    $total_hari_rawat_satu_limpapeh_l4 += $harirawat_satu_limpapeh_l4;
                                    $total_hari_rawat_dua_limpapeh_l4 += $harirawat_dua_limpapeh_l4;
                                    $total_hari_rawat_tiga_limpapeh_l4 += $harirawat_tiga_limpapeh_l4;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_masuk_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_all_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_limpapeh_l4;?></td>
                                        <td><?php echo $total_lama_rawat_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_vip_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_satu_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_dua_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_limpapeh_l4;?></td>
                                    </tr>
                               <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP SINGGALANG L1 & L2</b></h4></center>
                        <table  id="example3" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_singgalangl1l2 = "idrg IN ('0601','0602')";
                                $total_pasien_awal_singgalangl1l2 = 0;
                                $total_pasien_masuk_singgalangl1l2 = 0;
                                $total_pasien_masuk_pindah_singgalangl1l2 = 0;
                                $total_pasien_dirawat_all_singgalangl1l2 = 0;
                                $total_pasien_keluar_pindah_singgalangl1l2 = 0;
                                $total_pasien_keluar_hidup_singgalangl1l2 = 0;
                                $total_pasien_keluar_mati_singgalangl1l2 = 0;
                                $total_pasien_keluar_all_singgalangl1l2 = 0;
                                $total_pasien_keluar_hidup_mati_singgalangl1l2 = 0;
                                $total_pasien_mati_krg48_singgalangl1l2= 0;
                                $total_pasien_mati_lbh48_singgalangl1l2 = 0;
                                $total_lama_rawat_singgalangl1l2 = 0;
                                $total_hari_rawat_singgalangl1l2 = 0;
                                $total_hari_rawat_vip_singgalangl1l2 = 0;
                                $total_hari_rawat_satu_singgalangl1l2 = 0;
                                $total_hari_rawat_dua_singgalangl1l2 = 0;
                                $total_hari_rawat_tiga_singgalangl1l2 = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_singgalangl1l2 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $pasien_masuk_singgalangl1l2 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $pasien_masuk_pindah_singgalangl1l2 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $pasien_keluar_pindah_singgalangl1l2 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $pasien_keluar_hidup_singgalangl1l2 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $pasien_keluar_mati_singgalangl1l2 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $pasien_keluar_hidup_mati_singgalangl1l2 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $pasien_mati_krg_48_singgalangl1l2 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $pasien_mati_lbh_48_singgalangl1l2 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $lama_rawat_singgalangl1l2 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $hari_rawat_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_singgalangl1l2)->row();
                                    $hari_rawat_vip_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_singgalangl1l2)->row();
                                    $hari_rawat_satu_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_singgalangl1l2)->row();
                                    $hari_rawat_dua_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_singgalangl1l2)->row();
                                    $hari_rawat_tiga_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_singgalangl1l2)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_singgalangl1l2->jml  ?></td>
                                    <td><?= $pasien_masuk_singgalangl1l2->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_singgalangl1l2->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_singgalangl1l2 = $pasien_awal_singgalangl1l2->jml + $pasien_masuk_singgalangl1l2->jml + $pasien_masuk_pindah_singgalangl1l2->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_singgalangl1l2  ?></td>
                                    <td><?= $pasien_keluar_pindah_singgalangl1l2->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_singgalangl1l2->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_singgalangl1l2->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_singgalangl1l2 = $pasien_keluar_pindah_singgalangl1l2->jml + $pasien_keluar_hidup_singgalangl1l2->jml + $pasien_keluar_mati_singgalangl1l2->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_singgalangl1l2  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_singgalangl1l2->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_singgalangl1l2->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_singgalangl1l2->jml  ?></td>
                                    <td><?php if($lama_rawat_singgalangl1l2->jml != null){echo $lama_rawat_singgalangl1l2->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_singgalangl1l2 = $hari_rawat_singgalangl1l2->jml;
                                        $harirawat_vip_singgalangl1l2 = $hari_rawat_vip_singgalangl1l2->jml;
                                        $harirawat_satu_singgalangl1l2 = $hari_rawat_satu_singgalangl1l2->jml;
                                        $harirawat_dua_singgalangl1l2 = $hari_rawat_dua_singgalangl1l2->jml;
                                        $harirawat_tiga_singgalangl1l2 = $hari_rawat_tiga_singgalangl1l2->jml;
                                    }else{
                                        $harirawat_singgalangl1l2 = 0;
                                        $harirawat_vip_singgalangl1l2 = 0;
                                        $harirawat_satu_singgalangl1l2 = 0;
                                        $harirawat_dua_singgalangl1l2 = 0;
                                        $harirawat_tiga_singgalangl1l2 = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_singgalangl1l2  ?></td>
                                    <td><?= $harirawat_vip_singgalangl1l2 ?></td>
                                    <td><?= $harirawat_satu_singgalangl1l2  ?></td>
                                    <td><?= $harirawat_dua_singgalangl1l2 ?></td>
                                    <td><?= $harirawat_tiga_singgalangl1l2 ?></td>   
                                </tr>
                                <?php
                                
                                    $total_pasien_awal_singgalangl1l2 += $pasien_awal_singgalangl1l2->jml;
                                    $total_pasien_masuk_singgalangl1l2 += $pasien_masuk_singgalangl1l2->jml;
                                    $total_pasien_masuk_pindah_singgalangl1l2 += $pasien_masuk_pindah_singgalangl1l2->jml;
                                    $total_pasien_dirawat_all_singgalangl1l2 += $total_pasien_dirawat_singgalangl1l2;
                                    $total_pasien_keluar_pindah_singgalangl1l2 += $pasien_keluar_pindah_singgalangl1l2->jml;
                                    $total_pasien_keluar_mati_singgalangl1l2 += $pasien_keluar_mati_singgalangl1l2->jml;
                                    $total_pasien_keluar_hidup_singgalangl1l2 += $pasien_keluar_hidup_singgalangl1l2->jml;
                                    $total_pasien_keluar_all_singgalangl1l2 += $total_pasien_keluar_singgalangl1l2;
                                    $total_pasien_keluar_hidup_mati_singgalangl1l2 += $pasien_keluar_hidup_mati_singgalangl1l2->jml;
                                    $total_pasien_mati_krg48_singgalangl1l2 += $pasien_mati_krg_48_singgalangl1l2->jml;
                                    $total_pasien_mati_lbh48_singgalangl1l2 += $pasien_mati_lbh_48_singgalangl1l2->jml;
                                    $total_lama_rawat_singgalangl1l2 += $lama_rawat_singgalangl1l2->jml;
                                    $total_hari_rawat_singgalangl1l2 += $harirawat_singgalangl1l2;
                                    $total_hari_rawat_vip_singgalangl1l2 += $harirawat_vip_singgalangl1l2;
                                    $total_hari_rawat_satu_singgalangl1l2 += $harirawat_satu_singgalangl1l2;
                                    $total_hari_rawat_dua_singgalangl1l2 += $harirawat_dua_singgalangl1l2;
                                    $total_hari_rawat_tiga_singgalangl1l2 += $harirawat_tiga_singgalangl1l2;
                                }
                                ?>

                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_masuk_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_all_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_singgalangl1l2;?></td>
                                        <td><?php echo $total_lama_rawat_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_vip_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_satu_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_dua_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_singgalangl1l2;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP SINGGALANG L3</b></h4></center>
                        <table  id="example4" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_singgalangl3 = "idrg = '0603'";
                                $total_pasien_awal_singgalangl3 = 0;
                                $total_pasien_masuk_singgalangl3 = 0;
                                $total_pasien_masuk_pindah_singgalangl3 = 0;
                                $total_pasien_dirawat_all_singgalangl3 = 0;
                                $total_pasien_keluar_pindah_singgalangl3 = 0;
                                $total_pasien_keluar_hidup_singgalangl3 = 0;
                                $total_pasien_keluar_mati_singgalangl3 = 0;
                                $total_pasien_keluar_all_singgalangl3 = 0;
                                $total_pasien_keluar_hidup_mati_singgalangl3 = 0;
                                $total_pasien_mati_krg48_singgalangl3= 0;
                                $total_pasien_mati_lbh48_singgalangl3 = 0;
                                $total_lama_rawat_singgalangl3 = 0;
                                $total_hari_rawat_singgalangl3 = 0;
                                $total_hari_rawat_vip_singgalangl3 = 0;
                                $total_hari_rawat_satu_singgalangl3 = 0;
                                $total_hari_rawat_dua_singgalangl3 = 0;
                                $total_hari_rawat_tiga_singgalangl3 = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_singgalangl3 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $pasien_masuk_singgalangl3 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $pasien_masuk_pindah_singgalangl3 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $pasien_keluar_pindah_singgalangl3 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $pasien_keluar_hidup_singgalangl3 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $pasien_keluar_mati_singgalangl3 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $pasien_keluar_hidup_mati_singgalangl3 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $pasien_mati_krg_48_singgalangl3 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $pasien_mati_lbh_48_singgalangl3 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $lama_rawat_singgalangl3 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $hari_rawat_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_singgalangl3)->row();
                                    $hari_rawat_vip_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_singgalangl3)->row();
                                    $hari_rawat_satu_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_singgalangl3)->row();
                                    $hari_rawat_dua_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_singgalangl3)->row();
                                    $hari_rawat_tiga_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_singgalangl3)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_singgalangl3->jml  ?></td>
                                    <td><?= $pasien_masuk_singgalangl3->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_singgalangl3->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_singgalangl3 = $pasien_awal_singgalangl3->jml + $pasien_masuk_singgalangl3->jml + $pasien_masuk_pindah_singgalangl3->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_singgalangl3  ?></td>
                                    <td><?= $pasien_keluar_pindah_singgalangl3->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_singgalangl3->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_singgalangl3->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_singgalangl3 = $pasien_keluar_pindah_singgalangl3->jml + $pasien_keluar_hidup_singgalangl3->jml + $pasien_keluar_mati_singgalangl3->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_singgalangl3  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_singgalangl3->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_singgalangl3->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_singgalangl3->jml  ?></td>
                                    <td><?php if($lama_rawat_singgalangl3->jml != null){echo $lama_rawat_singgalangl3->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_singgalangl3 = $hari_rawat_singgalangl3->jml;
                                        $harirawat_vip_singgalangl3 = $hari_rawat_vip_singgalangl3->jml;
                                        $harirawat_satu_singgalangl3 = $hari_rawat_satu_singgalangl3->jml;
                                        $harirawat_dua_singgalangl3 = $hari_rawat_dua_singgalangl3->jml;
                                        $harirawat_tiga_singgalangl3 = $hari_rawat_tiga_singgalangl3->jml;
                                    }else{
                                        $harirawat_singgalangl3 = 0;
                                        $harirawat_vip_singgalangl3 = 0;
                                        $harirawat_satu_singgalangl3 = 0;
                                        $harirawat_dua_singgalangl3 = 0;
                                        $harirawat_tiga_singgalangl3 = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_singgalangl3  ?></td>
                                    <td><?= $harirawat_vip_singgalangl3 ?></td>
                                    <td><?= $harirawat_satu_singgalangl3  ?></td>
                                    <td><?= $harirawat_dua_singgalangl3 ?></td>
                                    <td><?= $harirawat_tiga_singgalangl3 ?></td>
                                </tr>
                                <?php
                                
                                $total_pasien_awal_singgalangl3 += $pasien_awal_singgalangl3->jml;
                                $total_pasien_masuk_singgalangl3 += $pasien_masuk_singgalangl3->jml;
                                $total_pasien_masuk_pindah_singgalangl3 += $pasien_masuk_pindah_singgalangl3->jml;
                                $total_pasien_dirawat_all_singgalangl3 += $total_pasien_dirawat_singgalangl3;
                                $total_pasien_keluar_pindah_singgalangl3 += $pasien_keluar_pindah_singgalangl3->jml;
                                $total_pasien_keluar_mati_singgalangl3 += $pasien_keluar_mati_singgalangl3->jml;
                                $total_pasien_keluar_hidup_singgalangl3 += $pasien_keluar_hidup_singgalangl3->jml;
                                $total_pasien_keluar_all_singgalangl3 += $total_pasien_keluar_singgalangl3;
                                $total_pasien_keluar_hidup_mati_singgalangl3 += $pasien_keluar_hidup_mati_singgalangl3->jml;
                                $total_pasien_mati_krg48_singgalangl3 += $pasien_mati_krg_48_singgalangl3->jml;
                                $total_pasien_mati_lbh48_singgalangl3 += $pasien_mati_lbh_48_singgalangl3->jml;
                                $total_lama_rawat_singgalangl3 += $lama_rawat_singgalangl3->jml;
                                $total_hari_rawat_singgalangl3 += $harirawat_singgalangl3;
                                $total_hari_rawat_vip_singgalangl3 += $harirawat_vip_singgalangl3;
                                $total_hari_rawat_satu_singgalangl3 += $harirawat_satu_singgalangl3;
                                $total_hari_rawat_dua_singgalangl3 += $harirawat_dua_singgalangl3;
                                $total_hari_rawat_tiga_singgalangl3 += $harirawat_tiga_singgalangl3;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_masuk_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_all_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_singgalangl3;?></td>
                                        <td><?php echo $total_lama_rawat_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_vip_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_satu_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_dua_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_singgalangl3;?></td>
                                    </tr>
                               <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP MERAPI L1</b></h4></center>
                        <table  id="example5" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_merapil1 = "idrg = '0701'";
                                $total_pasien_awal_merapil1 = 0;
                                $total_pasien_masuk_merapil1 = 0;
                                $total_pasien_masuk_pindah_merapil1 = 0;
                                $total_pasien_dirawat_all_merapil1 = 0;
                                $total_pasien_keluar_pindah_merapil1 = 0;
                                $total_pasien_keluar_hidup_merapil1 = 0;
                                $total_pasien_keluar_mati_merapil1 = 0;
                                $total_pasien_keluar_all_merapil1 = 0;
                                $total_pasien_keluar_hidup_mati_merapil1 = 0;
                                $total_pasien_mati_krg48_merapil1= 0;
                                $total_pasien_mati_lbh48_merapil1 = 0;
                                $total_lama_rawat_merapil1 = 0;
                                $total_hari_rawat_merapil1 = 0;
                                $total_hari_rawat_vip_merapil1 = 0;
                                $total_hari_rawat_satu_merapil1 = 0;
                                $total_hari_rawat_dua_merapil1 = 0;
                                $total_hari_rawat_tiga_merapil1 = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_merapil1 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_merapil1)->row();
                                    $pasien_masuk_merapil1 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_merapil1)->row();
                                    $pasien_masuk_pindah_merapil1 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_merapil1)->row();
                                    $pasien_keluar_pindah_merapil1 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_merapil1)->row();
                                    $pasien_keluar_hidup_merapil1 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_merapil1)->row();
                                    $pasien_keluar_mati_merapil1 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_merapil1)->row();
                                    $pasien_keluar_hidup_mati_merapil1 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_merapil1)->row();
                                    $pasien_mati_krg_48_merapil1 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_merapil1)->row();
                                    $pasien_mati_lbh_48_merapil1 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_merapil1)->row();
                                    $lama_rawat_merapi_l1 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_merapil1)->row();
                                    $hari_rawat_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_merapil1)->row();
                                    $hari_rawat_vip_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_merapil1)->row();
                                    $hari_rawat_satu_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_merapil1)->row();
                                    $hari_rawat_dua_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_merapil1)->row();
                                    $hari_rawat_tiga_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_merapil1)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_merapil1->jml  ?></td>
                                    <td><?= $pasien_masuk_merapil1->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_merapil1->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_merapil1 = $pasien_awal_merapil1->jml + $pasien_masuk_merapil1->jml + $pasien_masuk_pindah_merapil1->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_merapil1  ?></td>
                                    <td><?= $pasien_keluar_pindah_merapil1->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_merapil1->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_merapil1->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_merapil1 = $pasien_keluar_pindah_merapil1->jml + $pasien_keluar_hidup_merapil1->jml + $pasien_keluar_mati_merapil1->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_merapil1  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_merapil1->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_merapil1->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_merapil1->jml  ?></td>
                                    <td><?php if($lama_rawat_merapi_l1->jml != null){echo $lama_rawat_merapi_l1->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_merapi_l1 = $hari_rawat_merapi_l1->jml;
                                        $harirawat_vip_merapi_l1 = $hari_rawat_vip_merapi_l1->jml;
                                        $harirawat_satu_merapi_l1 = $hari_rawat_satu_merapi_l1->jml;
                                        $harirawat_dua_merapi_l1 = $hari_rawat_dua_merapi_l1->jml;
                                        $harirawat_tiga_merapi_l1 = $hari_rawat_tiga_merapi_l1->jml;
                                    }else{
                                        $harirawat_merapi_l1 = 0;
                                        $harirawat_vip_merapi_l1 = 0;
                                        $harirawat_satu_merapi_l1 = 0;
                                        $harirawat_dua_merapi_l1 = 0;
                                        $harirawat_tiga_merapi_l1 = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_merapi_l1  ?></td>
                                    <td><?= $harirawat_vip_merapi_l1 ?></td>
                                    <td><?= $harirawat_satu_merapi_l1  ?></td>
                                    <td><?= $harirawat_dua_merapi_l1 ?></td>
                                    <td><?= $harirawat_tiga_merapi_l1 ?></td>   
                                </tr>
                                <?php
                                
                                $total_pasien_awal_merapil1 += $pasien_awal_merapil1->jml;
                                $total_pasien_masuk_merapil1 += $pasien_masuk_merapil1->jml;
                                $total_pasien_masuk_pindah_merapil1 += $pasien_masuk_pindah_merapil1->jml;
                                $total_pasien_dirawat_all_merapil1 += $total_pasien_dirawat_merapil1;
                                $total_pasien_keluar_pindah_merapil1 += $pasien_keluar_pindah_merapil1->jml;
                                $total_pasien_keluar_mati_merapil1 += $pasien_keluar_mati_merapil1->jml;
                                $total_pasien_keluar_hidup_merapil1 += $pasien_keluar_hidup_merapil1->jml;
                                $total_pasien_keluar_all_merapil1 += $total_pasien_keluar_merapil1;
                                $total_pasien_keluar_hidup_mati_merapil1 += $pasien_keluar_hidup_mati_merapil1->jml;
                                $total_pasien_mati_krg48_merapil1 += $pasien_mati_krg_48_merapil1->jml;
                                $total_pasien_mati_lbh48_merapil1 += $pasien_mati_lbh_48_merapil1->jml;
                                $total_lama_rawat_merapil1 += $lama_rawat_merapi_l1->jml;
                                $total_hari_rawat_merapil1 += $harirawat_merapi_l1;
                                $total_hari_rawat_vip_merapil1 += $harirawat_vip_merapi_l1;
                                $total_hari_rawat_satu_merapil1 += $harirawat_satu_merapi_l1;
                                $total_hari_rawat_dua_merapil1 += $harirawat_dua_merapi_l1;
                                $total_hari_rawat_tiga_merapil1 += $harirawat_tiga_merapi_l1;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_merapil1;?></td>
                                        <td><?php echo $total_pasien_masuk_merapil1;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_merapil1;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_all_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_merapil1;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_merapil1;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_merapil1;?></td>
                                        <td><?php echo $total_lama_rawat_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_vip_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_satu_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_dua_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_merapil1;?></td>
                                    </tr>
                               <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP MERAPI L2</b></h4></center>
                        <table  id="example6" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_merapil2 = "idrg IN ('0702','0705')";
                                $total_pasien_awal_merapil2 = 0;
                                $total_pasien_masuk_merapil2 = 0;
                                $total_pasien_masuk_pindah_merapil2 = 0;
                                $total_pasien_dirawat_all_merapil2 = 0;
                                $total_pasien_keluar_pindah_merapil2 = 0;
                                $total_pasien_keluar_hidup_merapil2 = 0;
                                $total_pasien_keluar_mati_merapil2 = 0;
                                $total_pasien_keluar_all_merapil2 = 0;
                                $total_pasien_keluar_hidup_mati_merapil2 = 0;
                                $total_pasien_mati_krg48_merapil2= 0;
                                $total_pasien_mati_lbh48_merapil2 = 0;
                                $total_lama_rawat_merapil2 = 0;
                                $total_hari_rawat_merapil2 = 0;
                                $total_hari_rawat_vip_merapil2 = 0;
                                $total_hari_rawat_satu_merapil2 = 0;
                                $total_hari_rawat_dua_merapil2 = 0;
                                $total_hari_rawat_tiga_merapil2 = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_merapil2 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_merapil2)->row();
                                    $pasien_masuk_merapil2 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_merapil2)->row();
                                    $pasien_masuk_pindah_merapil2 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_merapil2)->row();
                                    $pasien_keluar_pindah_merapil2 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_merapil2)->row();
                                    $pasien_keluar_hidup_merapil2 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_merapil2)->row();
                                    $pasien_keluar_mati_merapil2 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_merapil2)->row();
                                    $pasien_keluar_hidup_mati_merapil2 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_merapil2)->row();
                                    $pasien_mati_krg_48_merapil2 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_merapil2)->row();
                                    $pasien_mati_lbh_48_merapil2 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_merapil2)->row();
                                    $lama_rawat_merapi_l2 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_merapil2)->row();
                                    $hari_rawat_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_merapil2)->row();
                                    $hari_rawat_vip_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_merapil2)->row();
                                    $hari_rawat_satu_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_merapil2)->row();
                                    $hari_rawat_dua_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_merapil2)->row();
                                    $hari_rawat_tiga_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_merapil2)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_merapil2->jml  ?></td>
                                    <td><?= $pasien_masuk_merapil2->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_merapil2->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_merapil2 = $pasien_awal_merapil2->jml + $pasien_masuk_merapil2->jml + $pasien_masuk_pindah_merapil2->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_merapil2  ?></td>
                                    <td><?= $pasien_keluar_pindah_merapil2->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_merapil2->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_merapil2->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_merapil2 = $pasien_keluar_pindah_merapil2->jml + $pasien_keluar_hidup_merapil2->jml + $pasien_keluar_mati_merapil2->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_merapil2  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_merapil2->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_merapil2->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_merapil2->jml  ?></td>
                                    <td><?php if($lama_rawat_merapi_l2->jml != null){echo $lama_rawat_merapi_l2->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_merapi_l2 = $hari_rawat_merapi_l2->jml;
                                        $harirawat_vip_merapi_l2 = $hari_rawat_vip_merapi_l2->jml ;
                                        $harirawat_satu_merapi_l2 = $hari_rawat_satu_merapi_l2->jml;
                                        $harirawat_dua_merapi_l2 = $hari_rawat_dua_merapi_l2->jml;
                                        $harirawat_tiga_merapi_l2 = $hari_rawat_tiga_merapi_l2->jml;
                                    }else{
                                        $harirawat_merapi_l2 = 0;
                                        $harirawat_vip_merapi_l2 = 0;
                                        $harirawat_satu_merapi_l2 = 0;
                                        $harirawat_dua_merapi_l2 = 0;
                                        $harirawat_tiga_merapi_l2 = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_merapi_l2  ?></td>
                                    <td><?= $harirawat_vip_merapi_l2 ?></td>
                                    <td><?= $harirawat_satu_merapi_l2  ?></td>
                                    <td><?= $harirawat_dua_merapi_l2 ?></td>
                                    <td><?= $harirawat_tiga_merapi_l2 ?></td>
                                    
                                </tr>
                                <?php
                                
                                $total_pasien_awal_merapil2 += $pasien_awal_merapil2->jml;
                                $total_pasien_masuk_merapil2 += $pasien_masuk_merapil2->jml;
                                $total_pasien_masuk_pindah_merapil2 += $pasien_masuk_pindah_merapil2->jml;
                                $total_pasien_dirawat_all_merapil2 += $total_pasien_dirawat_merapil2;
                                $total_pasien_keluar_pindah_merapil2 += $pasien_keluar_pindah_merapil2->jml;
                                $total_pasien_keluar_mati_merapil2 += $pasien_keluar_mati_merapil2->jml;
                                $total_pasien_keluar_hidup_merapil2 += $pasien_keluar_hidup_merapil2->jml;
                                $total_pasien_keluar_all_merapil2 += $total_pasien_keluar_merapil2;
                                $total_pasien_keluar_hidup_mati_merapil2 += $pasien_keluar_hidup_mati_merapil2->jml;
                                $total_pasien_mati_krg48_merapil2 += $pasien_mati_krg_48_merapil2->jml;
                                $total_pasien_mati_lbh48_merapil2 += $pasien_mati_lbh_48_merapil2->jml;
                                $total_lama_rawat_merapil2 += $lama_rawat_merapi_l2->jml;
                                $total_hari_rawat_merapil2 += $harirawat_merapi_l2;
                                $total_hari_rawat_vip_merapil2 += $harirawat_vip_merapi_l2;
                                $total_hari_rawat_satu_merapil2 += $harirawat_satu_merapi_l2;
                                $total_hari_rawat_dua_merapil2 += $harirawat_dua_merapi_l2;
                                $total_hari_rawat_tiga_merapil2 += $harirawat_tiga_merapi_l2;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_merapil2;?></td>
                                        <td><?php echo $total_pasien_masuk_merapil2;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_merapil2;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_all_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_merapil2;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_merapil2;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_merapil2;?></td>
                                        <td><?php echo $total_lama_rawat_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_vip_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_satu_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_dua_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_merapil2;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP MERAPI L3</b></h4></center>
                        <table  id="example7" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_merapil3 = "idrg IN ('0703','0706')";
                                $total_pasien_awal_merapil3 = 0;
                                $total_pasien_masuk_merapil3 = 0;
                                $total_pasien_masuk_pindah_merapil3 = 0;
                                $total_pasien_dirawat_all_merapil3 = 0;
                                $total_pasien_keluar_pindah_merapil3 = 0;
                                $total_pasien_keluar_hidup_merapil3 = 0;
                                $total_pasien_keluar_mati_merapil3 = 0;
                                $total_pasien_keluar_all_merapil3 = 0;
                                $total_pasien_keluar_hidup_mati_merapil3 = 0;
                                $total_pasien_mati_krg48_merapil3= 0;
                                $total_pasien_mati_lbh48_merapil3 = 0;
                                $total_lama_rawat_merapil3 = 0;
                                $total_hari_rawat_merapil3 = 0;
                                $total_hari_rawat_vip_merapil3 = 0;
                                $total_hari_rawat_satu_merapil3 = 0;
                                $total_hari_rawat_dua_merapil3 = 0;
                                $total_hari_rawat_tiga_merapil3 = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_merapil3 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_merapil3)->row();
                                    $pasien_masuk_merapil3 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_merapil3)->row();
                                    $pasien_masuk_pindah_merapil3 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_merapil3)->row();
                                    $pasien_keluar_pindah_merapil3 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_merapil3)->row();
                                    $pasien_keluar_hidup_merapil3 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_merapil3)->row();
                                    $pasien_keluar_mati_merapil3 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_merapil3)->row();
                                    $pasien_keluar_hidup_mati_merapil3 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_merapil3)->row();
                                    $pasien_mati_krg_48_merapil3 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_merapil3)->row();
                                    $pasien_mati_lbh_48_merapil3 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_merapil3)->row();
                                    $lama_rawat_merapi_l3 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_merapil3)->row();
                                    $hari_rawat_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_merapil3)->row();
                                    $hari_rawat_vip_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_merapil3)->row();
                                    $hari_rawat_satu_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_merapil3)->row();
                                    $hari_rawat_dua_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_merapil3)->row();
                                    $hari_rawat_tiga_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_merapil3)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_merapil3->jml  ?></td>
                                    <td><?= $pasien_masuk_merapil3->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_merapil3->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_merapil3 = $pasien_awal_merapil3->jml + $pasien_masuk_merapil3->jml + $pasien_masuk_pindah_merapil3->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_merapil3  ?></td>
                                    <td><?= $pasien_keluar_pindah_merapil3->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_merapil3->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_merapil3->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_merapil3 = $pasien_keluar_pindah_merapil3->jml + $pasien_keluar_hidup_merapil3->jml + $pasien_keluar_mati_merapil3->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_merapil3  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_merapil3->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_merapil3->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_merapil3->jml  ?></td>
                                    <td><?php if($lama_rawat_merapi_l3->jml != null){echo $lama_rawat_merapi_l3->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_merapi_l3 = $hari_rawat_merapi_l3->jml;
                                        $harirawat_vip_merapi_l3 = $hari_rawat_vip_merapi_l3->jml ;
                                        $harirawat_satu_merapi_l3= $hari_rawat_satu_merapi_l3->jml;
                                        $harirawat_dua_merapi_l3 = $hari_rawat_dua_merapi_l3->jml;
                                        $harirawat_tiga_merapi_l3 = $hari_rawat_tiga_merapi_l3->jml;
                                    }else{
                                        $harirawat_merapi_l3 = 0;
                                        $harirawat_vip_merapi_l3 = 0;
                                        $harirawat_satu_merapi_l3= 0;
                                        $harirawat_dua_merapi_l3 = 0;
                                        $harirawat_tiga_merapi_l3 = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_merapi_l3  ?></td>
                                    <td><?= $harirawat_vip_merapi_l3 ?></td>
                                    <td><?= $harirawat_satu_merapi_l3 ?></td>
                                    <td><?= $harirawat_dua_merapi_l3 ?></td>
                                    <td><?= $harirawat_tiga_merapi_l3 ?></td>
                                </tr>
                                <?php
                                
                                $total_pasien_awal_merapil3 += $pasien_awal_merapil3->jml;
                                $total_pasien_masuk_merapil3 += $pasien_masuk_merapil3->jml;
                                $total_pasien_masuk_pindah_merapil3 += $pasien_masuk_pindah_merapil3->jml;
                                $total_pasien_dirawat_all_merapil3 += $total_pasien_dirawat_merapil3;
                                $total_pasien_keluar_pindah_merapil3 += $pasien_keluar_pindah_merapil3->jml;
                                $total_pasien_keluar_mati_merapil3 += $pasien_keluar_mati_merapil3->jml;
                                $total_pasien_keluar_hidup_merapil3 += $pasien_keluar_hidup_merapil3->jml;
                                $total_pasien_keluar_all_merapil3 += $total_pasien_keluar_merapil3;
                                $total_pasien_keluar_hidup_mati_merapil3 += $pasien_keluar_hidup_mati_merapil3->jml;
                                $total_pasien_mati_krg48_merapil3 += $pasien_mati_krg_48_merapil3->jml;
                                $total_pasien_mati_lbh48_merapil3 += $pasien_mati_lbh_48_merapil3->jml;
                                $total_lama_rawat_merapil3 += $lama_rawat_merapi_l3->jml;
                                $total_hari_rawat_merapil3 += $harirawat_merapi_l3;
                                $total_hari_rawat_vip_merapil3 += $harirawat_vip_merapi_l3;
                                $total_hari_rawat_satu_merapil3 += $harirawat_satu_merapi_l3;
                                $total_hari_rawat_dua_merapil3 += $harirawat_dua_merapi_l3;
                                $total_hari_rawat_tiga_merapil3 += $harirawat_tiga_merapi_l3;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_merapil3;?></td>
                                        <td><?php echo $total_pasien_masuk_merapil3;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_merapil3;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_all_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_merapil3;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_merapil3;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_merapil3;?></td>
                                        <td><?php echo $total_lama_rawat_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_vip_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_satu_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_dua_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_merapil3;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP ANAK</b></h4></center>
                        <table  id="example8" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_anak = "idrg IN ('0101','0501','0103')";
                                $total_pasien_awal_anak = 0;
                                $total_pasien_masuk_anak = 0;
                                $total_pasien_masuk_pindah_anak = 0;
                                $total_pasien_dirawat_all_anak = 0;
                                $total_pasien_keluar_pindah_anak = 0;
                                $total_pasien_keluar_hidup_anak = 0;
                                $total_pasien_keluar_mati_anak = 0;
                                $total_pasien_keluar_all_anak = 0;
                                $total_pasien_keluar_hidup_mati_anak = 0;
                                $total_pasien_mati_krg48_anak= 0;
                                $total_pasien_mati_lbh48_anak = 0;
                                $total_lama_rawat_anak = 0;
                                $total_hari_rawat_anak = 0;
                                $total_hari_rawat_vip_anak = 0;
                                $total_hari_rawat_satu_anak = 0;
                                $total_hari_rawat_dua_anak = 0;
                                $total_hari_rawat_tiga_anak = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_anak = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_anak)->row();
                                    $pasien_masuk_anak = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_anak)->row();
                                    $pasien_masuk_pindah_anak = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_anak)->row();
                                    $pasien_keluar_pindah_anak = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_anak)->row();
                                    $pasien_keluar_hidup_anak = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_anak)->row();
                                    $pasien_keluar_mati_anak = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_anak)->row();
                                    $pasien_keluar_hidup_mati_anak = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_anak)->row();
                                    $pasien_mati_krg_48_anak = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_anak)->row();
                                    $pasien_mati_lbh_48_anak = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_anak)->row();
                                    $lama_rawat_anak = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_anak)->row();
                                    $hari_rawat_anak = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_anak)->row();
                                    $hari_rawat_vip_anak = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_anak)->row();
                                    $hari_rawat_satu_anak = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_anak)->row();
                                    $hari_rawat_dua_anak = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_anak)->row();
                                    $hari_rawat_tiga_anak = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_anak)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_anak->jml  ?></td>
                                    <td><?= $pasien_masuk_anak->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_anak->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_anak = $pasien_awal_anak->jml + $pasien_masuk_anak->jml + $pasien_masuk_pindah_anak->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_anak  ?></td>
                                    <td><?= $pasien_keluar_pindah_anak->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_anak->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_anak->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_anak = $pasien_keluar_pindah_anak->jml + $pasien_keluar_hidup_anak->jml + $pasien_keluar_mati_anak->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_anak  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_anak->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_anak->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_anak->jml  ?></td>
                                    <td><?php if($lama_rawat_anak->jml != null){echo $lama_rawat_anak->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_anak = $hari_rawat_anak->jml;
                                        $harirawat_vip_anak = $hari_rawat_vip_anak->jml ;
                                        $harirawat_satu_anak = $hari_rawat_satu_anak->jml;
                                        $harirawat_dua_anak = $hari_rawat_dua_anak->jml;
                                        $harirawat_tiga_anak = $hari_rawat_tiga_anak->jml;
                                    }else{
                                        $harirawat_anak = 0;
                                        $harirawat_vip_anak = 0;
                                        $harirawat_satu_anak = 0;
                                        $harirawat_dua_anak = 0;
                                        $harirawat_tiga_anak = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_anak  ?></td>
                                    <td><?= $harirawat_vip_anak ?></td>
                                    <td><?= $harirawat_satu_anak  ?></td>
                                    <td><?= $harirawat_dua_anak ?></td>
                                    <td><?= $harirawat_tiga_anak ?></td>
                                </tr>
                                <?php
                                
                                $total_pasien_awal_anak += $pasien_awal_anak->jml;
                                $total_pasien_masuk_anak += $pasien_masuk_anak->jml;
                                $total_pasien_masuk_pindah_anak += $pasien_masuk_pindah_anak->jml;
                                $total_pasien_dirawat_all_anak += $total_pasien_dirawat_anak;
                                $total_pasien_keluar_pindah_anak += $pasien_keluar_pindah_anak->jml;
                                $total_pasien_keluar_mati_anak += $pasien_keluar_mati_anak->jml;
                                $total_pasien_keluar_hidup_anak += $pasien_keluar_hidup_anak->jml;
                                $total_pasien_keluar_all_anak += $total_pasien_keluar_anak;
                                $total_pasien_keluar_hidup_mati_anak += $pasien_keluar_hidup_mati_anak->jml;
                                $total_pasien_mati_krg48_anak += $pasien_mati_krg_48_anak->jml;
                                $total_pasien_mati_lbh48_anak += $pasien_mati_lbh_48_anak->jml;
                                $total_lama_rawat_anak += $lama_rawat_anak->jml;
                                $total_hari_rawat_anak += $harirawat_anak;
                                $total_hari_rawat_vip_anak += $harirawat_vip_anak;
                                $total_hari_rawat_satu_anak += $harirawat_satu_anak;
                                $total_hari_rawat_dua_anak += $harirawat_dua_anak;
                                $total_hari_rawat_tiga_anak += $harirawat_tiga_anak;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_anak;?></td>
                                        <td><?php echo $total_pasien_masuk_anak;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_anak;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_all_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_anak;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_anak;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_anak;?></td>
                                        <td><?php echo $total_lama_rawat_anak;?></td>
                                        <td><?php echo $total_hari_rawat_anak;?></td>
                                        <td><?php echo $total_hari_rawat_vip_anak;?></td>
                                        <td><?php echo $total_hari_rawat_satu_anak;?></td>
                                        <td><?php echo $total_hari_rawat_dua_anak;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_anak;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP BEDAH</b></h4></center>
                        <table  id="example9" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_bedah = "idrg = '0502'";
                                $total_pasien_awal_bedah = 0;
                                $total_pasien_masuk_bedah = 0;
                                $total_pasien_masuk_pindah_bedah = 0;
                                $total_pasien_dirawat_all_bedah = 0;
                                $total_pasien_keluar_pindah_bedah = 0;
                                $total_pasien_keluar_hidup_bedah = 0;
                                $total_pasien_keluar_mati_bedah = 0;
                                $total_pasien_keluar_all_bedah = 0;
                                $total_pasien_keluar_hidup_mati_bedah = 0;
                                $total_pasien_mati_krg48_bedah= 0;
                                $total_pasien_mati_lbh48_bedah = 0;
                                $total_lama_rawat_bedah = 0;
                                $total_hari_rawat_bedah = 0;
                                $total_hari_rawat_vip_bedah = 0;
                                $total_hari_rawat_satu_bedah = 0;
                                $total_hari_rawat_dua_bedah = 0;
                                $total_hari_rawat_tiga_bedah = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_bedah = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_bedah)->row();
                                    $pasien_masuk_bedah = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_bedah)->row();
                                    $pasien_masuk_pindah_bedah = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_bedah)->row();
                                    $pasien_keluar_pindah_bedah = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_bedah)->row();
                                    $pasien_keluar_hidup_bedah = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_bedah)->row();
                                    $pasien_keluar_mati_bedah = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_bedah)->row();
                                    $pasien_keluar_hidup_mati_bedah = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_bedah)->row();
                                    $pasien_mati_krg_48_bedah = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_bedah)->row();
                                    $pasien_mati_lbh_48_bedah = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_bedah)->row();
                                    $lama_rawat_bedah = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_bedah)->row();
                                    $hari_rawat_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_bedah)->row();
                                    $hari_rawat_vip_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_bedah)->row();
                                    $hari_rawat_satu_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_bedah)->row();
                                    $hari_rawat_dua_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_bedah)->row();
                                    $hari_rawat_tiga_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_bedah)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_bedah->jml  ?></td>
                                    <td><?= $pasien_masuk_bedah->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_bedah->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_bedah = $pasien_awal_bedah->jml + $pasien_masuk_bedah->jml + $pasien_masuk_pindah_bedah->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_bedah  ?></td>
                                    <td><?= $pasien_keluar_pindah_bedah->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_bedah->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_bedah->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_bedah = $pasien_keluar_pindah_bedah->jml + $pasien_keluar_hidup_bedah->jml + $pasien_keluar_mati_bedah->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_bedah  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_bedah->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_bedah->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_bedah->jml  ?></td>
                                    <td><?php if($lama_rawat_bedah->jml != null){echo $lama_rawat_bedah->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_bedah = $hari_rawat_bedah->jml;
                                        $harirawat_vip_bedah = $hari_rawat_vip_bedah->jml ;
                                        $harirawat_satu_bedah = $hari_rawat_satu_bedah->jml;
                                        $harirawat_dua_bedah = $hari_rawat_dua_bedah->jml;
                                        $harirawat_tiga_bedah = $hari_rawat_tiga_bedah->jml;
                                    }else{
                                        $harirawat_bedah = 0;
                                        $harirawat_vip_bedah = 0;
                                        $harirawat_satu_bedah = 0;
                                        $harirawat_dua_bedah = 0;
                                        $harirawat_tiga_bedah = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_bedah  ?></td>
                                    <td><?= $harirawat_vip_bedah ?></td>
                                    <td><?= $harirawat_satu_bedah  ?></td>
                                    <td><?= $harirawat_dua_bedah ?></td>
                                    <td><?= $harirawat_tiga_bedah ?></td> 
                                </tr>
                                <?php
                                
                                $total_pasien_awal_bedah += $pasien_awal_bedah->jml;
                                $total_pasien_masuk_bedah += $pasien_masuk_bedah->jml;
                                $total_pasien_masuk_pindah_bedah += $pasien_masuk_pindah_bedah->jml;
                                $total_pasien_dirawat_all_bedah += $total_pasien_dirawat_bedah;
                                $total_pasien_keluar_pindah_bedah += $pasien_keluar_pindah_bedah->jml;
                                $total_pasien_keluar_mati_bedah += $pasien_keluar_mati_bedah->jml;
                                $total_pasien_keluar_hidup_bedah += $pasien_keluar_hidup_bedah->jml;
                                $total_pasien_keluar_all_bedah += $total_pasien_keluar_bedah;
                                $total_pasien_keluar_hidup_mati_bedah += $pasien_keluar_hidup_mati_bedah->jml;
                                $total_pasien_mati_krg48_bedah += $pasien_mati_krg_48_bedah->jml;
                                $total_pasien_mati_lbh48_bedah += $pasien_mati_lbh_48_bedah->jml;
                                $total_lama_rawat_bedah += $lama_rawat_bedah->jml;
                                $total_hari_rawat_bedah += $harirawat_bedah;
                                $total_hari_rawat_vip_bedah += $harirawat_vip_bedah;
                                $total_hari_rawat_satu_bedah += $harirawat_satu_bedah;
                                $total_hari_rawat_dua_bedah += $harirawat_dua_bedah;
                                $total_hari_rawat_tiga_bedah += $harirawat_tiga_bedah;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_bedah;?></td>
                                        <td><?php echo $total_pasien_masuk_bedah;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_bedah;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_all_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_bedah;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_bedah;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_bedah;?></td>
                                        <td><?php echo $total_lama_rawat_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_vip_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_satu_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_dua_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_bedah;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP KEBIDANAN</b></h4></center>
                        <table  id="example10" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_bidan = "idrg IN ('0503','0107')";
                                $total_pasien_awal_bidan = 0;
                                $total_pasien_masuk_bidan = 0;
                                $total_pasien_masuk_pindah_bidan = 0;
                                $total_pasien_dirawat_all_bidan = 0;
                                $total_pasien_keluar_pindah_bidan = 0;
                                $total_pasien_keluar_hidup_bidan = 0;
                                $total_pasien_keluar_mati_bidan = 0;
                                $total_pasien_keluar_all_bidan = 0;
                                $total_pasien_keluar_hidup_mati_bidan = 0;
                                $total_pasien_mati_krg48_bidan= 0;
                                $total_pasien_mati_lbh48_bidan = 0;
                                $total_lama_rawat_bidan = 0;
                                $total_hari_rawat_bidan = 0;
                                $total_hari_rawat_vip_bidan = 0;
                                $total_hari_rawat_satu_bidan = 0;
                                $total_hari_rawat_dua_bidan = 0;
                                $total_hari_rawat_tiga_bidan = 0;

                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_bidan = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_bidan)->row();
                                    $pasien_masuk_bidan = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_bidan)->row();
                                    $pasien_masuk_pindah_bidan = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_bidan)->row();
                                    $pasien_keluar_pindah_bidan = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_bidan)->row();
                                    $pasien_keluar_hidup_bidan = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_bidan)->row();
                                    $pasien_keluar_mati_bidan = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_bidan)->row();
                                    $pasien_keluar_hidup_mati_bidan = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_bidan)->row();
                                    $pasien_mati_krg_48_bidan = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_bidan)->row();
                                    $pasien_mati_lbh_48_bidan = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_bidan)->row();
                                    $lama_rawat_bidan = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_bidan)->row();
                                    $hari_rawat_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_bidan)->row();
                                    $hari_rawat_vip_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_bidan)->row();
                                    $hari_rawat_satu_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_bidan)->row();
                                    $hari_rawat_dua_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_bidan)->row();
                                    $hari_rawat_tiga_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_bidan)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_bidan->jml  ?></td>
                                    <td><?= $pasien_masuk_bidan->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_bidan->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_bidan = $pasien_awal_bidan->jml + $pasien_masuk_bidan->jml + $pasien_masuk_pindah_bidan->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_bidan  ?></td>
                                    <td><?= $pasien_keluar_pindah_bidan->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_bidan->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_bidan->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_bidan = $pasien_keluar_pindah_bidan->jml + $pasien_keluar_hidup_bidan->jml + $pasien_keluar_mati_bidan->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_bidan  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_bidan->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_bidan->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_bidan->jml  ?></td>
                                    <td><?php if($lama_rawat_bidan->jml != null){echo $lama_rawat_bidan->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_bidan = $hari_rawat_bidan->jml;
                                        $harirawat_vip_bidan = $hari_rawat_vip_bidan->jml ;
                                        $harirawat_satu_bidan = $hari_rawat_satu_bidan->jml;
                                        $harirawat_dua_bidan = $hari_rawat_dua_bidan->jml;
                                        $harirawat_tiga_bidan = $hari_rawat_tiga_bidan->jml;
                                    }else{
                                        $harirawat_bidan = 0;
                                        $harirawat_vip_bidan = 0;
                                        $harirawat_satu_bidan = 0;
                                        $harirawat_dua_bidan = 0;
                                        $harirawat_tiga_bidan = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_bidan  ?></td>
                                    <td><?= $harirawat_vip_bidan ?></td>
                                    <td><?= $harirawat_satu_bidan  ?></td>
                                    <td><?= $harirawat_dua_bidan ?></td>
                                    <td><?= $harirawat_tiga_bidan ?></td>
                                </tr>
                                <?php
                                
                                $total_pasien_awal_bidan += $pasien_awal_bidan->jml;
                                $total_pasien_masuk_bidan += $pasien_masuk_bidan->jml;
                                $total_pasien_masuk_pindah_bidan += $pasien_masuk_pindah_bidan->jml;
                                $total_pasien_dirawat_all_bidan += $total_pasien_dirawat_bidan;
                                $total_pasien_keluar_pindah_bidan += $pasien_keluar_pindah_bidan->jml;
                                $total_pasien_keluar_mati_bidan += $pasien_keluar_mati_bidan->jml;
                                $total_pasien_keluar_hidup_bidan += $pasien_keluar_hidup_bidan->jml;
                                $total_pasien_keluar_all_bidan += $total_pasien_keluar_bidan;
                                $total_pasien_keluar_hidup_mati_bidan += $pasien_keluar_hidup_mati_bidan->jml;
                                $total_pasien_mati_krg48_bidan += $pasien_mati_krg_48_bidan->jml;
                                $total_pasien_mati_lbh48_bidan += $pasien_mati_lbh_48_bidan->jml;
                                $total_lama_rawat_bidan += $lama_rawat_bidan->jml;
                                $total_hari_rawat_bidan += $harirawat_bidan;
                                $total_hari_rawat_vip_bidan += $harirawat_vip_bidan;
                                $total_hari_rawat_satu_bidan += $harirawat_satu_bidan;
                                $total_hari_rawat_dua_bidan += $harirawat_dua_bidan;
                                $total_hari_rawat_tiga_bidan += $harirawat_tiga_bidan;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_bidan;?></td>
                                        <td><?php echo $total_pasien_masuk_bidan;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_bidan;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_all_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_bidan;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_bidan;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_bidan;?></td>
                                        <td><?php echo $total_lama_rawat_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_vip_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_satu_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_dua_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_bidan;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP ICU</b></h4></center>
                        <table  id="example11" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_icu = "idrg IN ('0404','0704')";
                                $total_pasien_awal_icu = 0;
                                $total_pasien_masuk_icu = 0;
                                $total_pasien_masuk_pindah_icu = 0;
                                $total_pasien_dirawat_all_icu = 0;
                                $total_pasien_keluar_pindah_icu = 0;
                                $total_pasien_keluar_hidup_icu = 0;
                                $total_pasien_keluar_mati_icu = 0;
                                $total_pasien_keluar_all_icu = 0;
                                $total_pasien_keluar_hidup_mati_icu = 0;
                                $total_pasien_mati_krg48_icu= 0;
                                $total_pasien_mati_lbh48_icu = 0;
                                $total_lama_rawat_icu = 0;
                                $total_hari_rawat_icu = 0;
                                $total_hari_rawat_vip_icu = 0;
                                $total_hari_rawat_satu_icu = 0;
                                $total_hari_rawat_dua_icu = 0;
                                $total_hari_rawat_tiga_icu = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_icu = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_icu)->row();
                                    $pasien_masuk_icu = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_icu)->row();
                                    $pasien_masuk_pindah_icu = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_icu)->row();
                                    $pasien_keluar_pindah_icu = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_icu)->row();
                                    $pasien_keluar_hidup_icu = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_icu)->row();
                                    $pasien_keluar_mati_icu = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_icu)->row();
                                    $pasien_keluar_hidup_mati_icu = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_icu)->row();
                                    $pasien_mati_krg_48_icu = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_icu)->row();
                                    $pasien_mati_lbh_48_icu = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_icu)->row();
                                    $lama_rawat_icu = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_icu)->row();
                                    $hari_rawat_icu = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_icu)->row();
                                    $hari_rawat_vip_icu = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_icu)->row();
                                    $hari_rawat_satu_icu = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_icu)->row();
                                    $hari_rawat_dua_icu = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_icu)->row();
                                    $hari_rawat_tiga_icu = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_icu)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_icu->jml  ?></td>
                                    <td><?= $pasien_masuk_icu->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_icu->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_icu = $pasien_awal_icu->jml + $pasien_masuk_icu->jml + $pasien_masuk_pindah_icu->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_icu  ?></td>
                                    <td><?= $pasien_keluar_pindah_icu->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_icu->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_icu->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_icu = $pasien_keluar_pindah_icu->jml + $pasien_keluar_hidup_icu->jml + $pasien_keluar_mati_icu->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_icu  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_icu->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_icu->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_icu->jml  ?></td>
                                    <td><?php if($lama_rawat_icu->jml != null){echo $lama_rawat_icu->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_icu = $hari_rawat_icu->jml;
                                        $harirawat_vip_icu = $hari_rawat_vip_icu->jml ;
                                        $harirawat_satu_icu = $hari_rawat_satu_icu->jml;
                                        $harirawat_dua_icu = $hari_rawat_dua_icu->jml;
                                        $harirawat_tiga_icu = $hari_rawat_tiga_icu->jml;
                                    }else{
                                        $harirawat_icu = 0;
                                        $harirawat_vip_icu = 0;
                                        $harirawat_satu_icu = 0;
                                        $harirawat_dua_icu = 0;
                                        $harirawat_tiga_icu = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_icu  ?></td>
                                    <td><?= $harirawat_vip_icu ?></td>
                                    <td><?= $harirawat_satu_icu  ?></td>
                                    <td><?= $harirawat_dua_icu ?></td>
                                    <td><?= $harirawat_tiga_icu ?></td>
                                    
                                </tr>
                                <?php
                                $total_pasien_awal_icu += $pasien_awal_icu->jml;
                                $total_pasien_masuk_icu += $pasien_masuk_icu->jml;
                                $total_pasien_masuk_pindah_icu += $pasien_masuk_pindah_icu->jml;
                                $total_pasien_dirawat_all_icu += $total_pasien_dirawat_icu;
                                $total_pasien_keluar_pindah_icu += $pasien_keluar_pindah_icu->jml;
                                $total_pasien_keluar_mati_icu += $pasien_keluar_mati_icu->jml;
                                $total_pasien_keluar_hidup_icu += $pasien_keluar_hidup_icu->jml;
                                $total_pasien_keluar_all_icu += $total_pasien_keluar_icu;
                                $total_pasien_keluar_hidup_mati_icu += $pasien_keluar_hidup_mati_icu->jml;
                                $total_pasien_mati_krg48_icu += $pasien_mati_krg_48_icu->jml;
                                $total_pasien_mati_lbh48_icu += $pasien_mati_lbh_48_icu->jml;
                                $total_lama_rawat_icu += $lama_rawat_icu->jml;
                                $total_hari_rawat_icu += $harirawat_icu;
                                $total_hari_rawat_vip_icu += $harirawat_vip_icu;
                                $total_hari_rawat_satu_icu += $harirawat_satu_icu;
                                $total_hari_rawat_dua_icu += $harirawat_dua_icu;
                                $total_hari_rawat_tiga_icu += $harirawat_tiga_icu;
                                }
                                ?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_icu;?></td>
                                        <td><?php echo $total_pasien_masuk_icu;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_icu;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_all_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_icu;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_icu;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_icu;?></td>
                                        <td><?php echo $total_lama_rawat_icu;?></td>
                                        <td><?php echo $total_hari_rawat_icu;?></td>
                                        <td><?php echo $total_hari_rawat_vip_icu;?></td>
                                        <td><?php echo $total_hari_rawat_satu_icu;?></td>
                                        <td><?php echo $total_hari_rawat_dua_icu;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_icu;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP NICU</b></h4></center>
                        <table  id="example12" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Pasien Awal</th>
                                    <th rowspan="2">Pasien Masuk</th> 
                                    <th rowspan="2">Pasien Pindah</th> 
                                    <th rowspan="2">Jumlah Pend Dirawat</th>
                                    <th colspan ="4"  style="text-align:center">Pasien Keluar</th>
                                    <th rowspan="2">Pasien Keluar H + M</th>
                                    <th colspan ="2"  style="text-align:center">Perincian Keluar Mati</th>
                                    <th rowspan="2">Total Lama dirawat</th>
                                    <th rowspan="2">Jumlah Hari Rawatan</th>
                                    <th colspan ="4"  style="text-align:center">Rincian Hari Rawatan Perkelas</th>
                                    
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
            
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php 
                             if($datanya != null){ 
                                $bulan_search = explode('-',$bulan_now);
                                $tahun = $bulan_search[0];
                                $bulan = $bulan_search[1];
                                $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                $where_nicu = "idrg = '0406'";
                                $total_pasien_awal_nicu = 0;
                                $total_pasien_masuk_nicu = 0;
                                $total_pasien_masuk_pindah_nicu = 0;
                                $total_pasien_dirawat_all_nicu = 0;
                                $total_pasien_keluar_pindah_nicu = 0;
                                $total_pasien_keluar_hidup_nicu = 0;
                                $total_pasien_keluar_mati_nicu = 0;
                                $total_pasien_keluar_all_nicu = 0;
                                $total_pasien_keluar_hidup_mati_nicu = 0;
                                $total_pasien_mati_krg48_nicu= 0;
                                $total_pasien_mati_lbh48_nicu = 0;
                                $total_lama_rawat_nicu = 0;
                                $total_hari_rawat_nicu = 0;
                                $total_hari_rawat_vip_nicu = 0;
                                $total_hari_rawat_satu_nicu = 0;
                                $total_hari_rawat_dua_nicu = 0;
                                $total_hari_rawat_tiga_nicu = 0;
        
                                for ($i=1; $i < $tanggal+1; $i++) { 
                                    $tgl = $tahun.'-'.$bulan.'-'.$i;
                                    $tgl_format = date('Y-m-d',strtotime($tgl));
                                    $pasien_awal_nicu = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_nicu)->row();
                                    $pasien_masuk_nicu = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_nicu)->row();
                                    $pasien_masuk_pindah_nicu = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_nicu)->row();
                                    $pasien_keluar_pindah_nicu = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_nicu)->row();
                                    $pasien_keluar_hidup_nicu = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_nicu)->row();
                                    $pasien_keluar_mati_nicu = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_nicu)->row();
                                    $pasien_keluar_hidup_mati_nicu = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_nicu)->row();
                                    $pasien_mati_krg_48_nicu = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_nicu)->row();
                                    $pasien_mati_lbh_48_nicu = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_nicu)->row();
                                    $lama_rawat_nicu = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_nicu)->row();
                                    $hari_rawat_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_nicu)->row();
                                    $hari_rawat_vip_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_nicu)->row();
                                    $hari_rawat_satu_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_nicu)->row();
                                    $hari_rawat_dua_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_nicu)->row();
                                    $hari_rawat_tiga_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_nicu)->row();
                
                                ?>
                                    
                                 <tr>
                                    <td><b><?=  $i ?></b></td>
                                    <td><?= $pasien_awal_nicu->jml  ?></td>
                                    <td><?= $pasien_masuk_nicu->jml  ?></td>
                                    <td><?= $pasien_masuk_pindah_nicu->jml  ?></td>
                                    <?php 
                                    $total_pasien_dirawat_nicu = $pasien_awal_nicu->jml + $pasien_masuk_nicu->jml + $pasien_masuk_pindah_nicu->jml;
                                    ?>
                                    <td><?= $total_pasien_dirawat_nicu  ?></td>
                                    <td><?= $pasien_keluar_pindah_nicu->jml  ?></td>
                                    <td><?= $pasien_keluar_hidup_nicu->jml  ?></td>
                                    <td><?= $pasien_keluar_mati_nicu->jml  ?></td>
                                    <?php 
                                    $total_pasien_keluar_nicu = $pasien_keluar_pindah_nicu->jml + $pasien_keluar_hidup_nicu->jml + $pasien_keluar_mati_nicu->jml;
                                    ?>
                                    <td><?= $total_pasien_keluar_nicu  ?></td>
                                    <td><?= $pasien_keluar_hidup_mati_nicu->jml  ?></td>
                                    <td><?= $pasien_mati_krg_48_nicu->jml  ?></td>
                                    <td><?= $pasien_mati_lbh_48_nicu->jml  ?></td>
                                    <td><?php if($lama_rawat_nicu->jml != null){echo $lama_rawat_nicu->jml;}else{echo '0';} ?></td>
                                    <?php 
                                    if($i <= date('j')){
                                        $harirawat_nicu = $hari_rawat_nicu->jml;
                                        $harirawat_vip_nicu = $hari_rawat_vip_nicu->jml ;
                                        $harirawat_satu_nicu = $hari_rawat_satu_nicu->jml;
                                        $harirawat_dua_nicu = $hari_rawat_dua_nicu->jml;
                                        $harirawat_tiga_nicu = $hari_rawat_tiga_nicu->jml;
                                    }else{
                                        $harirawat_nicu = 0;
                                        $harirawat_vip_nicu = 0;
                                        $harirawat_satu_nicu = 0;
                                        $harirawat_dua_nicu = 0;
                                        $harirawat_tiga_nicu = 0;
                                    }
                                    ?>
                                    <td><?= $harirawat_nicu  ?></td>
                                    <td><?= $harirawat_vip_nicu ?></td>
                                    <td><?= $harirawat_satu_nicu  ?></td>
                                    <td><?= $harirawat_dua_nicu ?></td>
                                    <td><?= $harirawat_tiga_nicu ?></td>
                                    
                                </tr>
                                <?php
                                 $total_pasien_awal_nicu += $pasien_awal_nicu->jml;
                                 $total_pasien_masuk_nicu += $pasien_masuk_nicu->jml;
                                 $total_pasien_masuk_pindah_nicu += $pasien_masuk_pindah_nicu->jml;
                                 $total_pasien_dirawat_all_nicu += $total_pasien_dirawat_nicu;
                                 $total_pasien_keluar_pindah_nicu += $pasien_keluar_pindah_nicu->jml;
                                 $total_pasien_keluar_mati_nicu += $pasien_keluar_mati_nicu->jml;
                                 $total_pasien_keluar_hidup_nicu += $pasien_keluar_hidup_nicu->jml;
                                 $total_pasien_keluar_all_nicu += $total_pasien_keluar_nicu;
                                 $total_pasien_keluar_hidup_mati_nicu += $pasien_keluar_hidup_mati_nicu->jml;
                                 $total_pasien_mati_krg48_nicu += $pasien_mati_krg_48_nicu->jml;
                                 $total_pasien_mati_lbh48_nicu += $pasien_mati_lbh_48_nicu->jml;
                                 $total_lama_rawat_nicu += $lama_rawat_nicu->jml;
                                 $total_hari_rawat_nicu += $harirawat_nicu;
                                 $total_hari_rawat_vip_nicu += $harirawat_vip_nicu;
                                 $total_hari_rawat_satu_nicu += $harirawat_satu_nicu;
                                 $total_hari_rawat_dua_nicu += $harirawat_dua_nicu;
                                 $total_hari_rawat_tiga_nicu += $harirawat_tiga_nicu;
                                }?>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td><?php echo $total_pasien_awal_nicu;?></td>
                                        <td><?php echo $total_pasien_masuk_nicu;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_nicu;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_all_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_nicu;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_nicu;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_nicu;?></td>
                                        <td><?php echo $total_lama_rawat_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_vip_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_satu_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_dua_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_nicu;?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>

                           <?php  }  ?>
                            </tbody>
                        </table>

                        <br><br>
                        <center><h4><b>PELAYANAN RAWAT INAP</b></h4></center>
                        <table   class="table table-striped" style="width:100%">
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
                                if($datanya != null){ ?>
                                    <tr>
                                        <td>LIMPAPEH L2</td>
                                        <td><?= $pasien_awal_all_ruangan->limpapeh_l2 ?></td>
                                        <td><?php echo $total_pasien_masuk;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah;?></td>
                                        <td><?php echo $total_pasien_dirawat_all;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup;?></td>
                                        <td><?php echo $total_pasien_keluar_mati;?></td>
                                        <td><?php echo $total_pasien_keluar_all;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati;?></td>
                                        <td><?php echo $total_pasien_mati_krg48;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48;?></td>
                                        <td><?php echo $total_lama_rawat;?></td>
                                        <?php
                                        $jml_pasien_akhir = $total_pasien_dirawat_all - $total_pasien_keluar_all;
                                        ?>
                                        <td><?= $jml_pasien_akhir ?></td>
                                        <td><?php echo $total_hari_rawat;?></td>
                                        <td><?php echo $total_hari_rawat_vip;?></td>
                                        <td><?php echo $total_hari_rawat_satu;?></td>
                                        <td><?php echo $total_hari_rawat_dua;?></td>
                                        <td><?php echo $total_hari_rawat_tiga;?></td>
                                        
                                        <?php 
                                        $total_bed_limpapeh_l2 = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'LIMPAPEH L2'){ 
                                                $total_bed_limpapeh_l2 += $tot_tt->bed;
                                            }
                                        } ?>

                                        <td><?=  $total_bed_limpapeh_l2 ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_limpapeh_l2 = $tot_tt->bed;
                                            }}

                                            if($tt_vip_limpapeh_l2 == '0'){
                                                $bor_limpapehl2_vip = 0;
                                            }else{
                                                $bor_kali_limpapeh_l2_vip =  $tt_vip_limpapeh_l2 * $periode;
                                                $bor_bagi_limpapeh_l2_vip = $total_hari_rawat_vip / $bor_kali_limpapeh_l2_vip;
                                                $bor_limpapehl2_vip =  $bor_bagi_limpapeh_l2_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapehl2_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_limpapeh_l2 = $tot_tt->bed;
                                            }}

                                            if($tt_satu_limpapeh_l2 == '0'){
                                                $bor_limpapeh_l2_satu = 0;
                                            }else{
                                                $bor_kali_limpapeh_l2_satu =  $tt_satu_limpapeh_l2 * $periode;
                                                $bor_bagi_limpapeh_l2_satu = $total_hari_rawat_satu / $bor_kali_limpapeh_l2_satu;
                                                $bor_limpapeh_l2_satu =  $bor_bagi_limpapeh_l2_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_limpapeh_l2_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_limpapeh_l2 = $tot_tt->bed;
                                            }}

                                            if($tt_dua_limpapeh_l2 == '0'){
                                                $bor_limpapeh_l2_dua = 0;
                                            }else{
                                                $bor_kali_limpapeh_l2_dua =  $tt_dua_limpapeh_l2 * $periode;
                                                $bor_bagi_limpapeh_l2_dua = $total_hari_rawat_dua / $bor_kali_limpapeh_l2_dua;
                                                $bor_limpapeh_l2_dua =  $bor_bagi_limpapeh_l2_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l2_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_limpapeh_l2 = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_limpapeh_l2 == '0'){
                                                $bor_limpapeh_l2_tiga = 0;
                                            }else{
                                                $bor_kali_limpapeh_l2_tiga =  $tt_tiga_limpapeh_l2 * $periode;
                                                $bor_bagi_limpapeh_l2_tiga = $total_hari_rawat_tiga / $bor_kali_limpapeh_l2_tiga;
                                                $bor_limpapeh_l2_tiga = $bor_bagi_limpapeh_l2_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l2_tiga,2).'%' ?></td>

                                        <?php 
                                            if( $total_bed_limpapeh_l2 == '0'){
                                                $bor_limpapeh_l2_all = 0;
                                            }else{
                                                $bor_kali_limpapeh_l2_all =  $total_bed_limpapeh_l2 * $periode;
                                                $bor_bagi_limpapeh_l2_all = $total_hari_rawat / $bor_kali_limpapeh_l2_all;
                                                $bor_limpapeh_l2_all = $bor_bagi_limpapeh_l2_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l2_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>LIMPAPEH L3</td>
                                        <td><?= $pasien_awal_all_ruangan->limpapeh_l3 ?></td>
                                        <td><?php echo $total_pasien_masuk_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_all_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_limpapeh_l3;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_limpapeh_l3;?></td>
                                        <td><?php echo $total_lama_rawat_limpapeh_l3;?></td>
                                        <?php
                                        $jml_pasien_akhir_limpapeh_l3 = $total_pasien_dirawat_all_limpapeh_l3 - $total_pasien_keluar_all_limpapeh_l3;
                                        ?>
                                        <td><?= $jml_pasien_akhir_limpapeh_l3 ?></td>
                                        <td><?php echo $total_hari_rawat_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_vip_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_satu_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_dua_limpapeh_l3;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_limpapeh_l3;?></td>
                                        
                                        <?php 
                                        $total_bed_limpapeh_l3 = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'LIMPAPEH L3'){ 
                                                $total_bed_limpapeh_l3 += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_limpapeh_l3 ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_limpapeh_l3 = $tot_tt->bed;
                                            }}

                                            if($tt_vip_limpapeh_l3 == '0'){
                                                $bor_limpapehl3_vip = 0;
                                            }else{
                                                $bor_kali_limpapeh_l3_vip =  $tt_vip_limpapeh_l3 * $periode;
                                                $bor_bagi_limpapeh_l3_vip = $total_hari_rawat_vip_limpapeh_l3 / $bor_kali_limpapeh_l3_vip;
                                                $bor_limpapehl3_vip =  $bor_bagi_limpapeh_l3_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapehl3_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_limpapeh_l3 = $tot_tt->bed;
                                            }}

                                            if($tt_satu_limpapeh_l3 == '0'){
                                                $bor_limpapeh_l3_satu = 0;
                                            }else{
                                                $bor_kali_limpapeh_l3_satu =  $tt_satu_limpapeh_l3 * $periode;
                                                $bor_bagi_limpapeh_l3_satu = $total_hari_rawat_satu_limpapeh_l3 / $bor_kali_limpapeh_l3_satu;
                                                $bor_limpapeh_l3_satu =  $bor_bagi_limpapeh_l3_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_limpapeh_l3_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_limpapeh_l3 = $tot_tt->bed;
                                            }}

                                            if($tt_dua_limpapeh_l3 == '0'){
                                                $bor_limpapeh_l3_dua = 0;
                                            }else{
                                                $bor_kali_limpapeh_l3_dua =  $tt_dua_limpapeh_l3 * $periode;
                                                $bor_bagi_limpapeh_l3_dua = $total_hari_rawat_dua_limpapeh_l3 / $bor_kali_limpapeh_l3_dua;
                                                $bor_limpapeh_l3_dua =  $bor_bagi_limpapeh_l3_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l3_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_limpapeh_l3 = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_limpapeh_l3 == '0'){
                                                $bor_limpapeh_l3_tiga = 0;
                                            }else{
                                                $bor_kali_limpapeh_l3_tiga =  $tt_tiga_limpapeh_l3 * $periode;
                                                $bor_bagi_limpapeh_l3_tiga = $total_hari_rawat_tiga_limpapeh_l3 / $bor_kali_limpapeh_l3_tiga;
                                                $bor_limpapeh_l3_tiga = $bor_bagi_limpapeh_l3_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l3_tiga,2).'%' ?></td>

                                        <?php 
                                            if( $total_bed_limpapeh_l3 == '0'){
                                                $bor_limpapeh_l3_all = 0;
                                            }else{
                                                $bor_kali_limpapeh_l3_all =  $total_bed_limpapeh_l3 * $periode;
                                                $bor_bagi_limpapeh_l3_all = $total_hari_rawat_limpapeh_l3 / $bor_kali_limpapeh_l3_all;
                                                $bor_limpapeh_l3_all = $bor_bagi_limpapeh_l3_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l3_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>LIMPAPEH L4</td>
                                        <td><?= $pasien_awal_all_ruangan->limpapeh_l4 ?></td>
                                        <td><?php echo $total_pasien_masuk_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_all_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_limpapeh_l4;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_limpapeh_l4;?></td>
                                        <td><?php echo $total_lama_rawat_limpapeh_l4;?></td>
                                        <?php
                                        $jml_pasien_akhir_limpapeh_l4 = $total_pasien_dirawat_all_limpapeh_l4 - $total_pasien_keluar_all_limpapeh_l4;
                                        ?>
                                        <td><?= $jml_pasien_akhir_limpapeh_l4 ?></td>
                                        <td><?php echo $total_hari_rawat_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_vip_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_satu_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_dua_limpapeh_l4;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_limpapeh_l4;?></td>
                                        
                                        <?php 
                                        $total_bed_limpapeh_l4 = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'LIMPAPEH L4'){ 
                                                $total_bed_limpapeh_l4 += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_limpapeh_l4 ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_limpapeh_l4 = $tot_tt->bed;
                                            }}

                                            if($tt_vip_limpapeh_l4 == '0'){
                                                $bor_limpapehl4_vip = 0;
                                            }else{
                                                $bor_kali_limpapeh_l4_vip =  $tt_vip_limpapeh_l4 * $periode;
                                                $bor_bagi_limpapeh_l4_vip = $total_hari_rawat_vip_limpapeh_l4 / $bor_kali_limpapeh_l4_vip;
                                                $bor_limpapehl4_vip =  $bor_bagi_limpapeh_l4_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapehl4_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_limpapeh_l4 = $tot_tt->bed;
                                            }}

                                            if($tt_satu_limpapeh_l4 == '0'){
                                                $bor_limpapeh_l4_satu = 0;
                                            }else{
                                                $bor_kali_limpapeh_l4_satu =  $tt_satu_limpapeh_l4 * $periode;
                                                $bor_bagi_limpapeh_l4_satu = $total_hari_rawat_satu_limpapeh_l4 / $bor_kali_limpapeh_l4_satu;
                                                $bor_limpapeh_l4_satu =  $bor_bagi_limpapeh_l4_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_limpapeh_l4_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_limpapeh_l4 = $tot_tt->bed;
                                            }}

                                            if($tt_dua_limpapeh_l4 == '0'){
                                                $bor_limpapeh_l4_dua = 0;
                                            }else{
                                                $bor_kali_limpapeh_l4_dua =  $tt_dua_limpapeh_l4 * $periode;
                                                $bor_bagi_limpapeh_l4_dua = $total_hari_rawat_dua_limpapeh_l4 / $bor_kali_limpapeh_l4_dua;
                                                $bor_limpapeh_l4_dua =  $bor_bagi_limpapeh_l4_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l4_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_limpapeh_l4 = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_limpapeh_l4 == '0'){
                                                $bor_limpapeh_l4_tiga = 0;
                                            }else{
                                                $bor_kali_limpapeh_l4_tiga =  $tt_tiga_limpapeh_l4 * $periode;
                                                $bor_bagi_limpapeh_l4_tiga = $total_hari_rawat_tiga_limpapeh_l4 / $bor_kali_limpapeh_l4_tiga;
                                                $bor_limpapeh_l4_tiga = $bor_bagi_limpapeh_l4_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l4_tiga,2).'%' ?></td>

                                        <?php 
                                            if( $total_bed_limpapeh_l4 == '0'){
                                                $bor_limpapeh_l4_all = 0;
                                            }else{
                                                $bor_kali_limpapeh_l4_all =  $total_bed_limpapeh_l4 * $periode;
                                                $bor_bagi_limpapeh_l4_all = $total_hari_rawat_limpapeh_l4 / $bor_kali_limpapeh_l4_all;
                                                $bor_limpapeh_l4_all = $bor_bagi_limpapeh_l4_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_limpapeh_l4_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>SINGGALANG L1 & L2</td>
                                        <td><?= $pasien_awal_all_ruangan->singgalang_l1_l2 ?></td>
                                        <td><?php echo $total_pasien_masuk_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_all_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_singgalangl1l2;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_singgalangl1l2;?></td>
                                        <td><?php echo $total_lama_rawat_singgalangl1l2;?></td>
                                        <?php
                                        $jml_pasien_akhir_singgalangl1l2 = $total_pasien_dirawat_all_singgalangl1l2 - $total_pasien_keluar_all_singgalangl1l2;
                                        ?>
                                        <td><?= $jml_pasien_akhir_singgalangl1l2 ?></td>
                                        <td><?php echo $total_hari_rawat_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_vip_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_satu_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_dua_singgalangl1l2;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_singgalangl1l2;?></td>
                                        
                                        <?php 
                                        $total_bed_singgalang_l1_l2 = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'SINGGALANG L1 & L2'){ 
                                                $total_bed_singgalang_l1_l2 += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_singgalang_l1_l2 ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_singgalangl1l2 = $tot_tt->bed;
                                            }}

                                            if($tt_vip_singgalangl1l2 == '0'){
                                                $bor_singgalangl1l2_vip = 0;
                                            }else{
                                                $bor_kali_singgalangl1l2_vip =  $tt_vip_singgalangl1l2 * $periode;
                                                $bor_bagi_singgalangl1l2_vip = $total_hari_rawat_vip_singgalangl1l2 / $bor_kali_singgalangl1l2_vip;
                                                $bor_singgalangl1l2_vip =  $bor_bagi_singgalangl1l2_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_singgalangl1l2_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_singgalangl1l2 = $tot_tt->bed;
                                            }}

                                            if($tt_satu_singgalangl1l2 == '0'){
                                                $bor_singgalangl1l2_satu = 0;
                                            }else{
                                                $bor_kali_singgalangl1l2_satu =  $tt_satu_singgalangl1l2 * $periode;
                                                $bor_bagi_singgalangl1l2_satu = $total_hari_rawat_satu_singgalangl1l2 / $bor_kali_singgalangl1l2_satu;
                                                $bor_singgalangl1l2_satu =  $bor_bagi_singgalangl1l2_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_singgalangl1l2_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_singgalangl1l2 = $tot_tt->bed;
                                            }}

                                            if($tt_dua_singgalangl1l2 == '0'){
                                                $bor_singgalangl1l2_dua = 0;
                                            }else{
                                                $bor_kali_singgalangl1l2_dua =  $tt_dua_singgalangl1l2 * $periode;
                                                $bor_bagi_singgalangl1l2_dua = $total_hari_rawat_dua_singgalangl1l2 / $bor_kali_singgalangl1l2_dua;
                                                $bor_singgalangl1l2_dua =  $bor_bagi_singgalangl1l2_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_singgalangl1l2_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_singgalangl1l2 = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_singgalangl1l2 == '0'){
                                                $bor_singgalangl1l2_tiga = 0;
                                            }else{
                                                $bor_kali_singgalangl1l2_tiga =  $tt_tiga_singgalangl1l2 * $periode;
                                                $bor_bagi_singgalangl1l2_tiga = $total_hari_rawat_tiga_singgalangl1l2 / $bor_kali_singgalangl1l2_tiga;
                                                $bor_singgalangl1l2_tiga = $bor_bagi_singgalangl1l2_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_singgalangl1l2_tiga,2).'%' ?></td>

                                        <?php 
                                            if( $total_bed_singgalang_l1_l2 == '0'){
                                                $bor_singgalangl1l2_all = 0;
                                            }else{
                                                $bor_kali_singgalangl1l2_all =  $total_bed_singgalang_l1_l2 * $periode;
                                                $bor_bagi_singgalangl1l2_all = $total_hari_rawat_singgalangl1l2 / $bor_kali_singgalangl1l2_all;
                                                $bor_singgalangl1l2_all = $bor_bagi_singgalangl1l2_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_singgalangl1l2_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>SINGGALANG L3</td>
                                        <td><?= $pasien_awal_all_ruangan->singgalang_l3 ?></td>
                                        <td><?php echo $total_pasien_masuk_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_all_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_singgalangl3;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_singgalangl3;?></td>
                                        <td><?php echo $total_lama_rawat_singgalangl3;?></td>
                                        <?php
                                        $jml_pasien_akhir_singgalangl3 = $total_pasien_dirawat_all_singgalangl3 - $total_pasien_keluar_all_singgalangl3;
                                        ?>
                                        <td><?= $jml_pasien_akhir_singgalangl3 ?></td>
                                        <td><?php echo $total_hari_rawat_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_vip_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_satu_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_dua_singgalangl3;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_singgalangl3;?></td>
                                        
                                        <?php 
                                        $total_bed_singgalang_l3 = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'SINGGALANG L3'){ 
                                                $total_bed_singgalang_l3 += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_singgalang_l3 ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_singgalangl3 = $tot_tt->bed;
                                            }}

                                            if($tt_vip_singgalangl3 == '0'){
                                                $bor_singgalangl3_vip = 0;
                                            }else{
                                                $bor_kali_singgalangl3_vip =  $tt_vip_singgalangl3 * $periode;
                                                $bor_bagi_singgalangl3_vip = $total_hari_rawat_vip_singgalangl3 / $bor_kali_singgalangl3_vip;
                                                $bor_singgalangl3_vip =  $bor_bagi_singgalangl3_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_singgalangl3_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_singgalangl3 = $tot_tt->bed;
                                            }}

                                            if($tt_satu_singgalangl3 == '0'){
                                                $bor_singgalangl3_satu = 0;
                                            }else{
                                                $bor_kali_singgalangl3_satu =  $tt_satu_singgalangl3 * $periode;
                                                $bor_bagi_singgalangl3_satu = $total_hari_rawat_satu_singgalangl3 / $bor_kali_singgalangl3_satu;
                                                $bor_singgalangl3_satu =  $bor_bagi_singgalangl3_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_singgalangl3_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_singgalangl3 = $tot_tt->bed;
                                            }}

                                            if($tt_dua_singgalangl3 == '0'){
                                                $bor_singgalangl3_dua = 0;
                                            }else{
                                                $bor_kali_singgalangl3_dua =  $tt_dua_singgalangl3 * $periode;
                                                $bor_bagi_singgalangl3_dua = $total_hari_rawat_dua_singgalangl3 / $bor_kali_singgalangl3_dua;
                                                $bor_singgalangl3_dua =  $bor_bagi_singgalangl3_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_singgalangl3_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_singgalangl3 = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_singgalangl3 == '0'){
                                                $bor_singgalangl3_tiga = 0;
                                            }else{
                                                $bor_kali_singgalangl3_tiga =  $tt_tiga_singgalangl3 * $periode;
                                                $bor_bagi_singgalangl3_tiga = $total_hari_rawat_tiga_singgalangl3 / $bor_kali_singgalangl3_tiga;
                                                $bor_singgalangl3_tiga = $bor_bagi_singgalangl3_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_singgalangl3_tiga,2).'%' ?></td>

                                        <?php 
                                            if( $total_bed_singgalang_l3 == '0'){
                                                $bor_singgalangl3_all = 0;
                                            }else{
                                                $bor_kali_singgalangl3_all =  $total_bed_singgalang_l3 * $periode;
                                                $bor_bagi_singgalangl3_all = $total_hari_rawat_singgalangl3 / $bor_kali_singgalangl3_all;
                                                $bor_singgalangl3_all = $bor_bagi_singgalangl3_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_singgalangl3_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>MERAPI L1</td>
                                        <td><?= $pasien_awal_all_ruangan->merapi_l1 ?></td>
                                        <td><?php echo $total_pasien_masuk_merapil1;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_merapil1;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_all_merapil1;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_merapil1;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_merapil1;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_merapil1;?></td>
                                        <td><?php echo $total_lama_rawat_merapil1;?></td>
                                        <?php
                                        $jml_pasien_akhir_merapi_l1 = $total_pasien_dirawat_all_merapil1 - $total_pasien_keluar_all_merapil1;
                                        ?>
                                        <td><?= $jml_pasien_akhir_merapi_l1 ?></td>
                                        <td><?php echo $total_hari_rawat_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_vip_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_satu_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_dua_merapil1;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_merapil1;?></td>
                                        
                                        <?php 
                                        $total_bed_merapi_l1 = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'MERAPI L1'){ 
                                                $total_bed_merapi_l1 += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_merapi_l1 ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_merapil1 = $tot_tt->bed;
                                            }}

                                            if($tt_vip_merapil1 == '0'){
                                                $bor_merapil1_vip = 0;
                                            }else{
                                                $bor_kali_merapil1_vip =  $tt_vip_merapil1 * $periode;
                                                $bor_bagi_merapil1_vip = $total_hari_rawat_vip_merapil1 / $bor_kali_merapil1_vip;
                                                $bor_merapil1_vip =  $bor_bagi_merapil1_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil1_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_merapil1 = $tot_tt->bed;
                                            }}

                                            if($tt_satu_merapil1 == '0'){
                                                $bor_merapil1_satu = 0;
                                            }else{
                                                $bor_kali_merapil1_satu =  $tt_satu_merapil1 * $periode;
                                                $bor_bagi_merapil1_satu = $total_hari_rawat_satu_merapil1 / $bor_kali_merapil1_satu;
                                                $bor_merapil1_satu =  $bor_bagi_merapil1_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_merapil1_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_merapil1 = $tot_tt->bed;
                                            }}

                                            if($tt_dua_merapil1 == '0'){
                                                $bor_merapil1_dua = 0;
                                            }else{
                                                $bor_kali_merapil1_dua =  $tt_dua_merapil1 * $periode;
                                                $bor_bagi_merapil1_dua = $total_hari_rawat_dua_merapil1 / $bor_kali_merapil1_dua;
                                                $bor_merapil1_dua =  $bor_bagi_merapil1_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil1_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_merapil1 = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_merapil1 == '0'){
                                                $bor_merapil1_tiga = 0;
                                            }else{
                                                $bor_kali_merapil1_tiga =  $tt_tiga_merapil1 * $periode;
                                                $bor_bagi_merapil1_tiga = $total_hari_rawat_tiga_merapil1 / $bor_kali_merapil1_tiga;
                                                $bor_merapil1_tiga = $bor_bagi_merapil1_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil1_tiga,2).'%' ?></td>

                                        <?php 
                                            if(  $total_bed_merapi_l1 == '0'){
                                                $bor_merapil1_all = 0;
                                            }else{
                                                $bor_kali_merapil1_all =   $total_bed_merapi_l1 * $periode;
                                                $bor_bagi_merapil1_all = $total_hari_rawat_merapil1 / $bor_kali_merapil1_all;
                                                $bor_merapil1_all = $bor_bagi_merapil1_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil1_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>MERAPI L2</td>
                                        <td><?= $pasien_awal_all_ruangan->merapi_l2 ?></td>
                                        <td><?php echo $total_pasien_masuk_merapil2;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_merapil2;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_all_merapil2;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_merapil2;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_merapil2;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_merapil2;?></td>
                                        <td><?php echo $total_lama_rawat_merapil2;?></td>
                                        <?php
                                        $jml_pasien_akhir_merapi_l2 = $total_pasien_dirawat_all_merapil2 - $total_pasien_keluar_all_merapil2;
                                        ?>
                                        <td><?= $jml_pasien_akhir_merapi_l2 ?></td>
                                        <td><?php echo $total_hari_rawat_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_vip_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_satu_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_dua_merapil2;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_merapil2;?></td>
                                        
                                        <?php 
                                        $total_bed_merapi_l2 = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'MERAPI L2'){ 
                                                $total_bed_merapi_l2 += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_merapi_l2 ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_merapil2 = $tot_tt->bed;
                                            }}

                                            if($tt_vip_merapil2 == '0'){
                                                $bor_merapil2_vip = 0;
                                            }else{
                                                $bor_kali_merapil2_vip =  $tt_vip_merapil2 * $periode;
                                                $bor_bagi_merapil2_vip = $total_hari_rawat_vip_merapil2 / $bor_kali_merapil2_vip;
                                                $bor_merapil2_vip =  $bor_bagi_merapil2_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil2_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_merapil2 = $tot_tt->bed;
                                            }}

                                            if($tt_satu_merapil2 == '0'){
                                                $bor_merapil2_satu = 0;
                                            }else{
                                                $bor_kali_merapil2_satu =  $tt_satu_merapil2 * $periode;
                                                $bor_bagi_merapil2_satu = $total_hari_rawat_satu_merapil2 / $bor_kali_merapil2_satu;
                                                $bor_merapil2_satu =  $bor_bagi_merapil2_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_merapil2_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_merapil2 = $tot_tt->bed;
                                            }}

                                            if($tt_dua_merapil2 == '0'){
                                                $bor_merapil2_dua = 0;
                                            }else{
                                                $bor_kali_merapil2_dua =  $tt_dua_merapil2 * $periode;
                                                $bor_bagi_merapil2_dua = $total_hari_rawat_dua_merapil2 / $bor_kali_merapil2_dua;
                                                $bor_merapil2_dua =  $bor_bagi_merapil2_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil2_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_merapil2 = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_merapil2 == '0'){
                                                $bor_merapil2_tiga = 0;
                                            }else{
                                                $bor_kali_merapil2_tiga =  $tt_tiga_merapil2 * $periode;
                                                $bor_bagi_merapil2_tiga = $total_hari_rawat_tiga_merapil2 / $bor_kali_merapil2_tiga;
                                                $bor_merapil2_tiga = $bor_bagi_merapil2_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil2_tiga,2).'%' ?></td>

                                        <?php 
                                            if(  $total_bed_merapi_l2 == '0'){
                                                $bor_merapil2_all = 0;
                                            }else{
                                                $bor_kali_merapil2_all =   $total_bed_merapi_l2 * $periode;
                                                $bor_bagi_merapil2_all = $total_hari_rawat_merapil2 / $bor_kali_merapil2_all;
                                                $bor_merapil2_all = $bor_bagi_merapil2_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil2_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>MERAPI L3</td>
                                        <td><?= $pasien_awal_all_ruangan->merapi_l3 ?></td>
                                        <td><?php echo $total_pasien_masuk_merapil3;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_merapil3;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_all_merapil3;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_merapil3;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_merapil3;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_merapil3;?></td>
                                        <td><?php echo $total_lama_rawat_merapil3;?></td>
                                        <?php
                                        $jml_pasien_akhir_merapi_l3 = $total_pasien_dirawat_all_merapil3 - $total_pasien_keluar_all_merapil3;
                                        ?>
                                        <td><?= $jml_pasien_akhir_merapi_l3 ?></td>
                                        <td><?php echo $total_hari_rawat_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_vip_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_satu_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_dua_merapil3;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_merapil3;?></td>
                                        
                                        <?php 
                                        $total_bed_merapi_l3 = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'MERAPI L3'){ 
                                                $total_bed_merapi_l3 += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_merapi_l3 ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_merapil3 = $tot_tt->bed;
                                            }}

                                            if($tt_vip_merapil3 == '0'){
                                                $bor_merapil3_vip = 0;
                                            }else{
                                                $bor_kali_merapil3_vip =  $tt_vip_merapil3 * $periode;
                                                $bor_bagi_merapil3_vip = $total_hari_rawat_vip_merapil3 / $bor_kali_merapil3_vip;
                                                $bor_merapil3_vip =  $bor_bagi_merapil3_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil3_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_merapil3 = $tot_tt->bed;
                                            }}

                                            if($tt_satu_merapil3 == '0'){
                                                $bor_merapil3_satu = 0;
                                            }else{
                                                $bor_kali_merapil3_satu =  $tt_satu_merapil3 * $periode;
                                                $bor_bagi_merapil3_satu = $total_hari_rawat_satu_merapil3 / $bor_kali_merapil3_satu;
                                                $bor_merapil3_satu =  $bor_bagi_merapil3_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_merapil3_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_merapil3 = $tot_tt->bed;
                                            }}

                                            if($tt_dua_merapil3 == '0'){
                                                $bor_merapil3_dua = 0;
                                            }else{
                                                $bor_kali_merapil3_dua =  $tt_dua_merapil3 * $periode;
                                                $bor_bagi_merapil3_dua = $total_hari_rawat_dua_merapil3 / $bor_kali_merapil3_dua;
                                                $bor_merapil3_dua =  $bor_bagi_merapil3_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil3_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_merapil3 = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_merapil3 == '0'){
                                                $bor_merapil3_tiga = 0;
                                            }else{
                                                $bor_kali_merapil3_tiga =  $tt_tiga_merapil3 * $periode;
                                                $bor_bagi_merapil3_tiga = $total_hari_rawat_tiga_merapil3 / $bor_kali_merapil3_tiga;
                                                $bor_merapil3_tiga = $bor_bagi_merapil3_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil3_tiga,2).'%' ?></td>

                                        <?php 
                                            if(  $total_bed_merapi_l3 == '0'){
                                                $bor_merapil3_all = 0;
                                            }else{
                                                $bor_kali_merapil3_all =   $total_bed_merapi_l3 * $periode;
                                                $bor_bagi_merapil3_all = $total_hari_rawat_merapil3 / $bor_kali_merapil3_all;
                                                $bor_merapil3_all = $bor_bagi_merapil3_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_merapil3_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>ANAK</td>
                                        <td><?= $pasien_awal_all_ruangan->anak ?></td>
                                        <td><?php echo $total_pasien_masuk_anak;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_anak;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_all_anak;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_anak;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_anak;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_anak;?></td>
                                        <td><?php echo $total_lama_rawat_anak;?></td>
                                        <?php
                                        $jml_pasien_akhir_anak = $total_pasien_dirawat_all_anak - $total_pasien_keluar_all_anak;
                                        ?>
                                        <td><?= $jml_pasien_akhir_anak ?></td>
                                        <td><?php echo $total_hari_rawat_anak;?></td>
                                        <td><?php echo $total_hari_rawat_vip_anak;?></td>
                                        <td><?php echo $total_hari_rawat_satu_anak;?></td>
                                        <td><?php echo $total_hari_rawat_dua_anak;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_anak;?></td>
                                        
                                        <?php 
                                        $total_bed_anak = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'ANAK'){ 
                                                $total_bed_anak += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_anak ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_anak = $tot_tt->bed;
                                            }}

                                            if($tt_vip_anak == '0'){
                                                $bor_anak_vip = 0;
                                            }else{
                                                $bor_kali_anak_vip =  $tt_vip_anak * $periode;
                                                $bor_bagi_anak_vip = $total_hari_rawat_vip_anak / $bor_kali_anak_vip;
                                                $bor_anak_vip =  $bor_bagi_anak_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_anak_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_anak = $tot_tt->bed;
                                            }}

                                            if($tt_satu_anak == '0'){
                                                $bor_anak_satu = 0;
                                            }else{
                                                $bor_kali_anak_satu =  $tt_satu_anak * $periode;
                                                $bor_bagi_anak_satu = $total_hari_rawat_satu_anak / $bor_kali_anak_satu;
                                                $bor_anak_satu =  $bor_bagi_anak_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_anak_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_anak = $tot_tt->bed;
                                            }}

                                            if($tt_dua_anak == '0'){
                                                $bor_anak_dua = 0;
                                            }else{
                                                $bor_kali_anak_dua =  $tt_dua_anak * $periode;
                                                $bor_bagi_anak_dua = $total_hari_rawat_dua_anak / $bor_kali_anak_dua;
                                                $bor_anak_dua =  $bor_bagi_anak_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_anak_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_anak = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_anak == '0'){
                                                $bor_anak_tiga = 0;
                                            }else{
                                                $bor_kali_anak_tiga =  $tt_tiga_anak * $periode;
                                                $bor_bagi_anak_tiga = $total_hari_rawat_tiga_anak / $bor_kali_anak_tiga;
                                                $bor_anak_tiga = $bor_bagi_anak_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_anak_tiga,2).'%' ?></td>

                                        <?php 
                                            if(  $total_bed_anak == '0'){
                                                $bor_anak_all = 0;
                                            }else{
                                                $bor_kali_anak_all =   $total_bed_anak * $periode;
                                                $bor_bagi_anak_all = $total_hari_rawat_anak / $bor_kali_anak_all;
                                                $bor_anak_all = $bor_bagi_anak_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_anak_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>BEDAH</td>
                                        <td><?= $pasien_awal_all_ruangan->bedah ?></td>
                                        <td><?php echo $total_pasien_masuk_bedah;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_bedah;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_all_bedah;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_bedah;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_bedah;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_bedah;?></td>
                                        <td><?php echo $total_lama_rawat_bedah;?></td>
                                        <?php
                                        $jml_pasien_akhir_bedah = $total_pasien_dirawat_all_bedah - $total_pasien_keluar_all_bedah;
                                        ?>
                                        <td><?= $jml_pasien_akhir_bedah ?></td>
                                        <td><?php echo $total_hari_rawat_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_vip_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_satu_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_dua_bedah;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_bedah;?></td>
                                        
                                        <?php 
                                        $total_bed_bedah = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'BEDAH'){ 
                                                $total_bed_bedah += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_bedah ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_bedah = $tot_tt->bed;
                                            }}

                                            if($tt_vip_bedah == '0'){
                                                $bor_bedah_vip = 0;
                                            }else{
                                                $bor_kali_bedah_vip =  $tt_vip_bedah * $periode;
                                                $bor_bagi_bedah_vip = $total_hari_rawat_vip_bedah / $bor_kali_bedah_vip;
                                                $bor_bedah_vip =  $bor_bagi_bedah_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_bedah_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_bedah = $tot_tt->bed;
                                            }}

                                            if($tt_satu_bedah == '0'){
                                                $bor_bedah_satu = 0;
                                            }else{
                                                $bor_kali_bedah_satu =  $tt_satu_bedah * $periode;
                                                $bor_bagi_bedah_satu = $total_hari_rawat_satu_bedah / $bor_kali_bedah_satu;
                                                $bor_bedah_satu =  $bor_bagi_bedah_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_bedah_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_bedah = $tot_tt->bed;
                                            }}

                                            if($tt_dua_bedah == '0'){
                                                $bor_bedah_dua = 0;
                                            }else{
                                                $bor_kali_bedah_dua =  $tt_dua_bedah * $periode;
                                                $bor_bagi_bedah_dua = $total_hari_rawat_dua_bedah / $bor_kali_bedah_dua;
                                                $bor_bedah_dua =  $bor_bagi_bedah_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_bedah_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_bedah = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_bedah == '0'){
                                                $bor_bedah_tiga = 0;
                                            }else{
                                                $bor_kali_bedah_tiga =  $tt_tiga_bedah * $periode;
                                                $bor_bagi_bedah_tiga = $total_hari_rawat_tiga_bedah / $bor_kali_bedah_tiga;
                                                $bor_bedah_tiga = $bor_bagi_bedah_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_bedah_tiga,2).'%' ?></td>

                                        <?php 
                                            if(  $total_bed_bedah == '0'){
                                                $bor_bedah_all = 0;
                                            }else{
                                                $bor_kali_bedah_all =   $total_bed_bedah * $periode;
                                                $bor_bagi_bedah_all = $total_hari_rawat_bedah / $bor_kali_bedah_all;
                                                $bor_bedah_all = $bor_bagi_bedah_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_bedah_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>KEBIDANAN</td>
                                        <td><?= $pasien_awal_all_ruangan->kebidanan ?></td>
                                        <td><?php echo $total_pasien_masuk_bidan;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_bidan;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_all_bidan;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_bidan;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_bidan;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_bidan;?></td>
                                        <td><?php echo $total_lama_rawat_bidan;?></td>
                                        <?php
                                        $jml_pasien_akhir_bidan = $total_pasien_dirawat_all_bidan - $total_pasien_keluar_all_bidan;
                                        ?>
                                        <td><?= $jml_pasien_akhir_bidan ?></td>
                                        <td><?php echo $total_hari_rawat_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_vip_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_satu_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_dua_bidan;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_bidan;?></td>
                                        
                                        <?php 
                                        $total_bed_bidan = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'KEBIDANAN'){ 
                                                $total_bed_bidan += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_bidan ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_bidan = $tot_tt->bed;
                                            }}

                                            if($tt_vip_bidan == '0'){
                                                $bor_bidan_vip = 0;
                                            }else{
                                                $bor_kali_bidan_vip =  $tt_vip_bidan * $periode;
                                                $bor_bagi_bidan_vip = $total_hari_rawat_vip_bidan / $bor_kali_bidan_vip;
                                                $bor_bidan_vip =  $bor_bagi_bidan_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_bidan_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_bidan = $tot_tt->bed;
                                            }}

                                            if($tt_satu_bidan == '0'){
                                                $bor_bidan_satu = 0;
                                            }else{
                                                $bor_kali_bidan_satu =  $tt_satu_bidan * $periode;
                                                $bor_bagi_bidan_satu = $total_hari_rawat_satu_bidan / $bor_kali_bidan_satu;
                                                $bor_bidan_satu =  $bor_bagi_bidan_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_bidan_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_bidan = $tot_tt->bed;
                                            }}

                                            if($tt_dua_bidan == '0'){
                                                $bor_bidan_dua = 0;
                                            }else{
                                                $bor_kali_bidan_dua =  $tt_dua_bidan * $periode;
                                                $bor_bagi_bidan_dua = $total_hari_rawat_dua_bidan / $bor_kali_bidan_dua;
                                                $bor_bidan_dua =  $bor_bagi_bidan_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_bidan_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_bidan = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_bidan == '0'){
                                                $bor_bidan_tiga = 0;
                                            }else{
                                                $bor_kali_bidan_tiga =  $tt_tiga_bidan * $periode;
                                                $bor_bagi_bidan_tiga = $total_hari_rawat_tiga_bidan / $bor_kali_bidan_tiga;
                                                $bor_bidan_tiga = $bor_bagi_bidan_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_bidan_tiga,2).'%' ?></td>

                                        <?php 
                                            if(  $total_bed_bidan == '0'){
                                                $bor_bidan_all = 0;
                                            }else{
                                                $bor_kali_bidan_all =   $total_bed_bidan * $periode;
                                                $bor_bagi_bidan_all = $total_hari_rawat_bidan / $bor_kali_bidan_all;
                                                $bor_bidan_all = $bor_bagi_bidan_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_bidan_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>ICU</td>
                                        <td><?= $pasien_awal_all_ruangan->icu ?></td>
                                        <td><?php echo $total_pasien_masuk_icu;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_icu;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_all_icu;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_icu;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_icu;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_icu;?></td>
                                        <td><?php echo $total_lama_rawat_icu;?></td>
                                        <?php
                                        $jml_pasien_akhir_icu = $total_pasien_dirawat_all_icu - $total_pasien_keluar_all_icu;
                                        ?>
                                        <td><?= $jml_pasien_akhir_icu ?></td>
                                        <td><?php echo $total_hari_rawat_icu;?></td>
                                        <td><?php echo $total_hari_rawat_vip_icu;?></td>
                                        <td><?php echo $total_hari_rawat_satu_icu;?></td>
                                        <td><?php echo $total_hari_rawat_dua_icu;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_icu;?></td>
                                        
                                        <?php 
                                        $total_bed_icu = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'ICU'){ 
                                                $total_bed_icu += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_icu ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_icu = $tot_tt->bed;
                                            }}

                                            if($tt_vip_icu == '0'){
                                                $bor_icu_vip = 0;
                                            }else{
                                                $bor_kali_icu_vip =  $tt_vip_icu * $periode;
                                                $bor_bagi_icu_vip = $total_hari_rawat_vip_icu / $bor_kali_icu_vip;
                                                $bor_icu_vip =  $bor_bagi_icu_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_icu_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_icu = $tot_tt->bed;
                                            }}

                                            if($tt_satu_icu == '0'){
                                                $bor_icu_satu = 0;
                                            }else{
                                                $bor_kali_icu_satu =  $tt_satu_icu * $periode;
                                                $bor_bagi_icu_satu = $total_hari_rawat_satu_icu / $bor_kali_icu_satu;
                                                $bor_icu_satu =  $bor_bagi_icu_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_icu_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_icu = $tot_tt->bed;
                                            }}

                                            if($tt_dua_icu == '0'){
                                                $bor_icu_dua = 0;
                                            }else{
                                                $bor_kali_icu_dua =  $tt_dua_icu * $periode;
                                                $bor_bagi_icu_dua = $total_hari_rawat_dua_icu / $bor_kali_icu_dua;
                                                $bor_icu_dua =  $bor_bagi_icu_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_icu_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_icu = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_icu == '0'){
                                                $bor_icu_tiga = 0;
                                            }else{
                                                $bor_kali_icu_tiga =  $tt_tiga_icu * $periode;
                                                $bor_bagi_icu_tiga = $total_hari_rawat_tiga_icu / $bor_kali_icu_tiga;
                                                $bor_icu_tiga = $bor_bagi_icu_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_icu_tiga,2).'%' ?></td>

                                        <?php 
                                            if(  $total_bed_icu == '0'){
                                                $bor_icu_all = 0;
                                            }else{
                                                $bor_kali_icu_all =   $total_bed_icu * $periode;
                                                $bor_bagi_icu_all = $total_hari_rawat_icu / $bor_kali_icu_all;
                                                $bor_icu_all = $bor_bagi_icu_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_icu_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>NICU</td>
                                        <td><?= $pasien_awal_all_ruangan->nicu ?></td>
                                        <td><?php echo $total_pasien_masuk_nicu;?></td>
                                        <td><?php echo $total_pasien_masuk_pindah_nicu;?></td>
                                        <td><?php echo $total_pasien_dirawat_all_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_pindah_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_mati_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_all_nicu;?></td>
                                        <td><?php echo $total_pasien_keluar_hidup_mati_nicu;?></td>
                                        <td><?php echo $total_pasien_mati_krg48_nicu;?></td>
                                        <td><?php echo $total_pasien_mati_lbh48_nicu;?></td>
                                        <td><?php echo $total_lama_rawat_nicu;?></td>
                                        <?php
                                        $jml_pasien_akhir_nicu = $total_pasien_dirawat_all_nicu - $total_pasien_keluar_all_nicu;
                                        ?>
                                        <td><?= $jml_pasien_akhir_nicu ?></td>
                                        <td><?php echo $total_hari_rawat_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_vip_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_satu_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_dua_nicu;?></td>
                                        <td><?php echo $total_hari_rawat_tiga_nicu;?></td>
                                        
                                        <?php 
                                        $total_bed_nicu = 0;
                                        foreach ($get_tt_ruangan as $tot_tt){
                                            if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'VIP'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                            } if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'I'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                            <?php 
                                             } if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'II'){ 
                                            ?>
                                             <td><?= $tot_tt->bed ?></td>
                                             <?php 
                                             } if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'III'){ 
                                            ?>
                                            <td><?= $tot_tt->bed ?></td>
                                        <?php }
                                            if( $tot_tt->ruangan == 'NICU'){ 
                                                $total_bed_nicu += $tot_tt->bed;
                                            }
                                        } ?>
                                        
                                        <td><?=  $total_bed_nicu ?></td>
                                        <?php 
                                            $periode = date('j');
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'VIP'){ 
                                                    $tt_vip_nicu = $tot_tt->bed;
                                            }}

                                            if($tt_vip_nicu == '0'){
                                                $bor_nicu_vip = 0;
                                            }else{
                                                $bor_kali_nicu_vip =  $tt_vip_nicu * $periode;
                                                $bor_bagi_nicu_vip = $total_hari_rawat_vip_nicu / $bor_kali_nicu_vip;
                                                $bor_nicu_vip =  $bor_bagi_nicu_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_nicu_vip,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'I'){ 
                                                    $tt_satu_nicu = $tot_tt->bed;
                                            }}

                                            if($tt_satu_nicu == '0'){
                                                $bor_nicu_satu = 0;
                                            }else{
                                                $bor_kali_nicu_satu =  $tt_satu_nicu * $periode;
                                                $bor_bagi_nicu_satu = $total_hari_rawat_satu_nicu / $bor_kali_nicu_satu;
                                                $bor_nicu_satu =  $bor_bagi_nicu_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_nicu_satu,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'II'){ 
                                                    $tt_dua_nicu = $tot_tt->bed;
                                            }}

                                            if($tt_dua_nicu == '0'){
                                                $bor_nicu_dua = 0;
                                            }else{
                                                $bor_kali_nicu_dua =  $tt_dua_nicu * $periode;
                                                $bor_bagi_nicu_dua = $total_hari_rawat_dua_nicu / $bor_kali_nicu_dua;
                                                $bor_nicu_dua =  $bor_bagi_nicu_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_nicu_dua,2).'%' ?></td>

                                        <?php 
                                            foreach ($get_tt_ruangan as $tot_tt){
                                                if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'III'){ 
                                                    $tt_tiga_nicu = $tot_tt->bed;
                                            }}

                                            if($tt_tiga_nicu == '0'){
                                                $bor_nicu_tiga = 0;
                                            }else{
                                                $bor_kali_nicu_tiga =  $tt_tiga_nicu * $periode;
                                                $bor_bagi_nicu_tiga = $total_hari_rawat_tiga_nicu / $bor_kali_nicu_tiga;
                                                $bor_nicu_tiga = $bor_bagi_nicu_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_nicu_tiga,2).'%' ?></td>

                                        <?php 
                                            if(  $total_bed_nicu == '0'){
                                                $bor_nicu_all = 0;
                                            }else{
                                                $bor_kali_nicu_all =   $total_bed_nicu * $periode;
                                                $bor_bagi_nicu_all = $total_hari_rawat_nicu / $bor_kali_nicu_all;
                                                $bor_nicu_all = $bor_bagi_nicu_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_nicu_all,2).'%' ?></td>
                                      
                                    </tr>

                                    <tr>
                                        <td>JUMLAH</td>
                                        <?php 
                                        $jmlh_pasien_awal = $total_pasien_awal +  $pasien_awal_all_ruangan->limpapeh_l3 + $pasien_awal_all_ruangan->limpapeh_l4 + $pasien_awal_all_ruangan->singgalang_l1_l2 + $pasien_awal_all_ruangan->singgalang_l3
                                        + $pasien_awal_all_ruangan->merapi_l1 + $pasien_awal_all_ruangan->merapi_l2 + $pasien_awal_all_ruangan->merapi_l3 + $pasien_awal_all_ruangan->anak + $pasien_awal_all_ruangan->bedah
                                        + $pasien_awal_all_ruangan->kebidanan + $pasien_awal_all_ruangan->icu + $pasien_awal_all_ruangan->nicu
                                        ?>
                                        <td><?= $jmlh_pasien_awal ?></td>
                                        <?php 
                                        $jmlh_pasien_masuk = $total_pasien_masuk + $total_pasien_masuk_limpapeh_l3 + $total_pasien_masuk_limpapeh_l4 + $total_pasien_masuk_singgalangl1l2 + $total_pasien_masuk_singgalangl3
                                        + $total_pasien_masuk_merapil1 + $total_pasien_masuk_merapil2 +  $total_pasien_masuk_merapil3 + $total_pasien_masuk_anak + $total_pasien_masuk_bedah
                                        + $total_pasien_masuk_bidan + $total_pasien_masuk_icu + $total_pasien_masuk_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_masuk;?></td>
                                        <?php 
                                        $jmlh_pasien_masuk_pindah = $total_pasien_masuk_pindah + $total_pasien_masuk_pindah_limpapeh_l3 + $total_pasien_masuk_pindah_limpapeh_l4 +  $total_pasien_masuk_pindah_singgalangl1l2 + $total_pasien_masuk_pindah_singgalangl3 
                                        + $total_pasien_masuk_pindah_merapil1 + $total_pasien_masuk_pindah_merapil2 + $total_pasien_masuk_pindah_merapil3 + $total_pasien_masuk_pindah_anak + $total_pasien_masuk_pindah_bedah + $total_pasien_masuk_pindah_bidan
                                        + $total_pasien_masuk_pindah_icu + $total_pasien_masuk_pindah_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_masuk_pindah;?></td>
                                        <?php 
                                        $jmlh_pasien_dirawat = $total_pasien_dirawat_all + $total_pasien_dirawat_all_limpapeh_l3 + $total_pasien_dirawat_all_limpapeh_l4 +  $total_pasien_dirawat_all_singgalangl1l2 + $total_pasien_dirawat_all_singgalangl3
                                        + $total_pasien_dirawat_all_merapil1 + $total_pasien_dirawat_all_merapil2 + $total_pasien_dirawat_all_merapil3 + $total_pasien_dirawat_all_anak + $total_pasien_dirawat_all_bedah + $total_pasien_dirawat_all_bidan
                                        + $total_pasien_dirawat_all_icu + $total_pasien_dirawat_all_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_dirawat;?></td>
                                        <?php 
                                        $jmlh_pasien_keluar_pindah = $total_pasien_keluar_pindah + $total_pasien_keluar_pindah_limpapeh_l3 + $total_pasien_keluar_pindah_limpapeh_l4 +  $total_pasien_keluar_pindah_singgalangl1l2 + $total_pasien_keluar_pindah_singgalangl3
                                        + $total_pasien_keluar_pindah_merapil1 + $total_pasien_keluar_pindah_merapil2 + $total_pasien_keluar_pindah_merapil3 + $total_pasien_keluar_pindah_anak + $total_pasien_keluar_pindah_bedah + $total_pasien_keluar_pindah_bidan
                                        + $total_pasien_keluar_pindah_icu + $total_pasien_keluar_pindah_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_keluar_pindah;?></td>
                                        <?php 
                                        $jmlh_pasien_keluar_hidup = $total_pasien_keluar_hidup + $total_pasien_keluar_hidup_limpapeh_l3 + $total_pasien_keluar_hidup_limpapeh_l4 +  $total_pasien_keluar_hidup_singgalangl1l2 +  $total_pasien_keluar_hidup_singgalangl3 
                                        + $total_pasien_keluar_hidup_merapil1 + $total_pasien_keluar_hidup_merapil2 + $total_pasien_keluar_hidup_merapil3 + $total_pasien_keluar_hidup_anak + $total_pasien_keluar_hidup_bedah + $total_pasien_keluar_hidup_bidan
                                        + $total_pasien_keluar_hidup_icu + $total_pasien_keluar_hidup_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_keluar_hidup;?></td>
                                        <?php 
                                        $jmlh_pasien_keluar_mati = $total_pasien_keluar_mati + $total_pasien_keluar_mati_limpapeh_l3 + $total_pasien_keluar_mati_limpapeh_l4 + $total_pasien_keluar_mati_singgalangl1l2 + $total_pasien_keluar_mati_singgalangl3
                                        + $total_pasien_keluar_mati_merapil1 + $total_pasien_keluar_mati_merapil2 + $total_pasien_keluar_mati_merapil3 + $total_pasien_keluar_mati_anak + $total_pasien_keluar_mati_bedah + $total_pasien_keluar_mati_bidan
                                        + $total_pasien_keluar_mati_icu + $total_pasien_keluar_mati_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_keluar_mati;?></td>
                                        <?php 
                                        $jmlh_pasien_keluar_all = $total_pasien_keluar_all + $total_pasien_keluar_all_limpapeh_l3 + $total_pasien_keluar_all_limpapeh_l4 +  $total_pasien_keluar_all_singgalangl1l2 + $total_pasien_keluar_all_singgalangl3
                                        + $total_pasien_keluar_all_merapil1 + $total_pasien_keluar_all_merapil2 + $total_pasien_keluar_all_merapil3 + $total_pasien_keluar_all_anak + $total_pasien_keluar_all_bedah + $total_pasien_keluar_all_bidan
                                        + $total_pasien_keluar_all_icu + $total_pasien_keluar_all_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_keluar_all;?></td>
                                        <?php 
                                        $jmlh_pasien_keluar_hidup_mati = $total_pasien_keluar_hidup_mati + $total_pasien_keluar_hidup_mati_limpapeh_l3 +  $total_pasien_keluar_hidup_mati_limpapeh_l4 + $total_pasien_keluar_hidup_mati_singgalangl1l2 + $total_pasien_keluar_hidup_mati_singgalangl3
                                        + $total_pasien_keluar_hidup_mati_merapil1 + $total_pasien_keluar_hidup_mati_merapil2 + $total_pasien_keluar_hidup_mati_merapil3 + $total_pasien_keluar_hidup_mati_anak + $total_pasien_keluar_hidup_mati_bedah + $total_pasien_keluar_hidup_mati_bidan
                                        + $total_pasien_keluar_hidup_mati_icu + $total_pasien_keluar_hidup_mati_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_keluar_hidup_mati;?></td>
                                        <?php 
                                        $jmlh_pasien_mati_krg48 = $total_pasien_mati_krg48 + $total_pasien_mati_krg48_limpapeh_l3 + $total_pasien_mati_krg48_limpapeh_l4 + $total_pasien_mati_krg48_singgalangl1l2 + $total_pasien_mati_krg48_singgalangl3
                                        + $total_pasien_mati_krg48_merapil1 + $total_pasien_mati_krg48_merapil2 + $total_pasien_mati_krg48_merapil3 +  $total_pasien_mati_krg48_anak + $total_pasien_mati_krg48_bedah + $total_pasien_mati_krg48_bidan
                                        + $total_pasien_mati_krg48_icu + $total_pasien_mati_krg48_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_mati_krg48;?></td>
                                        <?php 
                                        $jmlh_pasien_mati_lbh48 = $total_pasien_mati_lbh48 + $total_pasien_mati_lbh48_limpapeh_l3 + $total_pasien_mati_lbh48_limpapeh_l4 +  $total_pasien_mati_lbh48_singgalangl1l2 + $total_pasien_mati_lbh48_singgalangl3
                                        +  $total_pasien_mati_lbh48_merapil1 + $total_pasien_mati_lbh48_merapil2 + $total_pasien_mati_lbh48_merapil3 + $total_pasien_mati_lbh48_anak + $total_pasien_mati_lbh48_bedah + $total_pasien_mati_lbh48_bidan
                                        + $total_pasien_mati_lbh48_icu +  $total_pasien_mati_lbh48_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_mati_lbh48;?></td>
                                        <?php 
                                        $jmlh_pasien_lama_rawat = $total_lama_rawat + $total_lama_rawat_limpapeh_l3 + $total_lama_rawat_limpapeh_l4 + $total_lama_rawat_singgalangl1l2 + $total_lama_rawat_singgalangl3
                                        + $total_lama_rawat_merapil1 +  $total_lama_rawat_merapil2 +  $total_lama_rawat_merapil3 + $total_lama_rawat_anak + $total_lama_rawat_bedah + $total_lama_rawat_bidan
                                        + $total_lama_rawat_icu + $total_lama_rawat_nicu
                                        ?>
                                        <td><?php echo $jmlh_pasien_lama_rawat;?></td>
                                        <?php 
                                        $jmlh_pasien_akhir = $jml_pasien_akhir + $jml_pasien_akhir_limpapeh_l3 +  $jml_pasien_akhir_limpapeh_l4 + $jml_pasien_akhir_singgalangl1l2 + $jml_pasien_akhir_singgalangl3
                                        + $jml_pasien_akhir_merapi_l1 + $jml_pasien_akhir_merapi_l2 + $jml_pasien_akhir_merapi_l3 + $jml_pasien_akhir_anak + $jml_pasien_akhir_bedah + $jml_pasien_akhir_bidan
                                        + $jml_pasien_akhir_icu + $jml_pasien_akhir_nicu
                                        ?>
                                        <td><?= $jmlh_pasien_akhir ?></td>
                                        <?php 
                                        $jmlh_hari_perawatan = $total_hari_rawat + $total_hari_rawat_limpapeh_l3 + $total_hari_rawat_limpapeh_l4 + $total_hari_rawat_singgalangl1l2 + $total_hari_rawat_singgalangl3
                                        + $total_hari_rawat_merapil1 + $total_hari_rawat_merapil2 + $total_hari_rawat_merapil3 + $total_hari_rawat_anak + $total_hari_rawat_bedah + $total_hari_rawat_bidan
                                        + $total_hari_rawat_icu + $total_hari_rawat_nicu
                                        ?>
                                        <td><?php echo $jmlh_hari_perawatan;?></td>
                                        <?php 
                                        $jmlh_hari_rawat_vip = $total_hari_rawat_vip + $total_hari_rawat_vip_limpapeh_l3 + $total_hari_rawat_vip_limpapeh_l4 + $total_hari_rawat_vip_singgalangl1l2 + $total_hari_rawat_vip_singgalangl3
                                        + $total_hari_rawat_vip_merapil1 + $total_hari_rawat_vip_merapil2 + $total_hari_rawat_vip_merapil3 + $total_hari_rawat_vip_anak + $total_hari_rawat_vip_bedah + $total_hari_rawat_vip_bidan
                                        + $total_hari_rawat_vip_icu + $total_hari_rawat_vip_nicu
                                        ?>
                                        <td><?php echo $jmlh_hari_rawat_vip;?></td>
                                        <?php 
                                        $jmlh_hari_rawat_satu = $total_hari_rawat_satu + $total_hari_rawat_satu_limpapeh_l3 + $total_hari_rawat_satu_limpapeh_l4 + $total_hari_rawat_satu_singgalangl1l2 + $total_hari_rawat_satu_singgalangl3
                                        + $total_hari_rawat_satu_merapil1 + $total_hari_rawat_satu_merapil2 + $total_hari_rawat_satu_merapil3 + $total_hari_rawat_satu_anak + $total_hari_rawat_satu_bedah + $total_hari_rawat_satu_bidan
                                        + $total_hari_rawat_satu_icu + $total_hari_rawat_satu_nicu
                                        ?>
                                        <td><?php echo $jmlh_hari_rawat_satu;?></td>
                                        <?php 
                                        $jmlh_hari_rawat_dua = $total_hari_rawat_dua + $total_hari_rawat_dua_limpapeh_l3 + $total_hari_rawat_dua_limpapeh_l4 + $total_hari_rawat_dua_singgalangl1l2 + $total_hari_rawat_dua_singgalangl3
                                        + $total_hari_rawat_dua_merapil1 + $total_hari_rawat_dua_merapil2 + $total_hari_rawat_dua_merapil3 + $total_hari_rawat_dua_anak + $total_hari_rawat_dua_bedah + $total_hari_rawat_dua_bidan
                                        + $total_hari_rawat_dua_icu + $total_hari_rawat_dua_nicu
                                        ?>
                                        <td><?php echo $jmlh_hari_rawat_dua;?></td>
                                        <?php 
                                        $jmlh_hari_rawat_tiga =  $total_hari_rawat_tiga + $total_hari_rawat_tiga_limpapeh_l3 + $total_hari_rawat_tiga_limpapeh_l4 + $total_hari_rawat_tiga_singgalangl1l2 + $total_hari_rawat_tiga_singgalangl3
                                        + $total_hari_rawat_tiga_merapil1 + $total_hari_rawat_tiga_merapil2 + $total_hari_rawat_tiga_merapil3 + $total_hari_rawat_tiga_anak + $total_hari_rawat_tiga_bedah + $total_hari_rawat_tiga_bidan
                                        + $total_hari_rawat_tiga_icu + $total_hari_rawat_tiga_nicu
                                        ?>
                                        <td><?php echo $jmlh_hari_rawat_tiga;?></td>
                                        <?php
                                        $jumlah_bed_all = 0;
                                        $jumlah_bed_all_vip = 0;
                                        $jumlah_bed_all_satu = 0;
                                        $jumlah_bed_all_dua = 0;
                                        $jumlah_bed_all_tiga = 0;
                                        $jumlah_bed_all_rg = 0;
                                            foreach ($get_tt_ruangan as $tot_tt){
                                            if($tot_tt->kelas == 'VIP'){ 
                                                $jumlah_bed_all_vip += $tot_tt->bed;
                                            }}
                                            ?>
                                            <td><?= $jumlah_bed_all_vip ?></td>

                                            <?php
                                            foreach ($get_tt_ruangan as $tot_tt){
                                            if($tot_tt->kelas == 'I'){ 
                                                $jumlah_bed_all_satu += $tot_tt->bed;
                                            }}
                                            ?>
                                            <td><?= $jumlah_bed_all_satu ?></td>

                                            <?php
                                            foreach ($get_tt_ruangan as $tot_tt){
                                            if($tot_tt->kelas == 'II'){ 
                                                $jumlah_bed_all_dua += $tot_tt->bed;
                                            }}
                                            ?>
                                            <td><?= $jumlah_bed_all_dua ?></td>

                                            <?php
                                            foreach ($get_tt_ruangan as $tot_tt){
                                            if($tot_tt->kelas == 'III'){ 
                                                $jumlah_bed_all_tiga += $tot_tt->bed;
                                            }}
                                            ?>
                                            <td><?= $jumlah_bed_all_tiga ?></td>
                                           
                                            <?php
                                            foreach ($get_tt_ruangan as $tot_tt){
                                            
                                                $jumlah_bed_all_rg += $tot_tt->bed;
                                            }
                                            ?>
                                            <td><?= $jumlah_bed_all_rg ?></td>


                                          <?php 
                                            $periode = date('j');
                                            if($jumlah_bed_all_vip == '0'){
                                                $bor_all_vip = 0;
                                            }else{
                                                $bor_kali_all_vip =  $jumlah_bed_all_vip * $periode;
                                                $bor_bagi_all_vip = $jmlh_hari_rawat_vip / $bor_kali_all_vip;
                                                $bor_all_vip =  $bor_bagi_all_vip * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_all_vip,2).'%' ?></td>

                                        <?php 

                                            if($jumlah_bed_all_satu == '0'){
                                                $bor_all_satu = 0;
                                            }else{
                                                $bor_kali_all_satu =  $jumlah_bed_all_satu * $periode;
                                                $bor_bagi_all_satu = $jmlh_hari_rawat_satu / $bor_kali_all_satu;
                                                $bor_all_satu =  $bor_bagi_all_satu * 100;
                                            }
                                        ?>
                                        <td><?=  number_format($bor_all_satu,2).'%' ?></td>

                                        <?php 
                                         
                                            if($jumlah_bed_all_dua == '0'){
                                                $bor_all_dua = 0;
                                            }else{
                                                $bor_kali_all_dua =  $jumlah_bed_all_dua * $periode;
                                                $bor_bagi_all_dua = $jmlh_hari_rawat_dua / $bor_kali_all_dua;
                                                $bor_all_dua =  $bor_bagi_all_dua * 100;                                           
                                            }
                                        ?>
                                        <td><?= number_format($bor_all_dua,2).'%' ?></td>

                                        <?php 
                                            
                                            if($jumlah_bed_all_tiga == '0'){
                                                $bor_all_tiga = 0;
                                            }else{
                                                $bor_kali_all_tiga =  $jumlah_bed_all_tiga * $periode;
                                                $bor_bagi_all_tiga = $jmlh_hari_rawat_tiga / $bor_kali_all_tiga;
                                                $bor_all_tiga = $bor_bagi_all_tiga * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_all_tiga,2).'%' ?></td>

                                        <?php 
                                            if( $jumlah_bed_all_rg == '0'){
                                                $bor_fix_all = 0;
                                            }else{
                                                $bor_kali_fix_all =  $jumlah_bed_all_rg * $periode;
                                                $bor_bagi_fix_all = $jmlh_hari_perawatan / $bor_kali_fix_all;
                                                $bor_fix_all = $bor_bagi_fix_all * 100;
                                            }
                                        ?>
                                        <td><?= number_format($bor_fix_all,2).'%' ?></td>
                                      
                                    </tr>

                               <?php  }else{ ?>
                                    <tr>
                                        <td colspan="29" style="text-align:center">TIDAK ADA DATA</td>
                                    </tr>
                              <?php }  ?>
                                
                            </tbody>
                        </table>
                        <div style="margin-right:1000px">
                        </div>
                    </div>     
                <!-- <a href="<?php echo site_url('irj/Rjclaporan/excel_bor_los_toi_new/'.$bulannow);?>">
                <input type="button" class="btn" style="background-color: lime;color:white;margin:5px" value="EXCEL"></a> -->
            </div>
        </div>
    </div>
</div>

<?php 
if($datanya != null){ ?>



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
                <?php 
                    if( $jumlah_bed_all_rg == '0'){
                        $bor_fix_all = 0;
                    }else{
                        $bor_kali_fix_all =  $jumlah_bed_all_rg * $periode;
                        $bor_bagi_fix_all = $jmlh_hari_perawatan / $bor_kali_fix_all;
                        $bor_fix_all = $bor_bagi_fix_all * 100;
                    }
                    $periode = date('j');
                    $avlos = $jmlh_pasien_lama_rawat / $jmlh_pasien_keluar_hidup_mati;
                    $toi_kali =  $jumlah_bed_all_rg * $periode;
                    $toi_kurang = $toi_kali - $jmlh_hari_perawatan;
                    $toi_fix =  $toi_kurang / $jmlh_pasien_keluar_hidup_mati;
                    $bto = $jmlh_pasien_keluar_hidup_mati / $jumlah_bed_all_rg;
                    $gdr = $jmlh_pasien_keluar_mati / $jmlh_pasien_keluar_hidup_mati;
                    $gdr_fix =  $gdr * 1000;
                    $ndr = $jmlh_pasien_mati_krg48 / $jmlh_pasien_keluar_hidup_mati;
                    $ndr_fix =  $ndr * 1000;

                ?>
                <td></td>
                <div  style="background-color:#e91d63;width:250px;padding:5px;color:white;margin:2px">BOR RS : <?= number_format($bor_fix_all,2).'%' ?></div>
                <div  style="background-color:#1dd2e9;width:250px;padding:5px;color:white;margin:2px">AVLOS : <?=  ceil($avlos) ?></div>
                <div  style="background-color:red;width:250px;padding:5px;color:white;margin:2px">TOI : <?= ceil($toi_fix) ?></div>
                <div  style="background-color:purple;width:250px;padding:5px;color:white;margin:2px">BTO : <?= ceil($bto) ?></div>
                <div  style="background-color:#00b050;width:250px;padding:5px;color:white;margin:2px">GDR : <?= ceil($gdr_fix) ?></div>
                <div  style="background-color:blue;width:250px;padding:5px;color:white;margin:2px">NDR : <?= ceil($ndr_fix) ?></div>
            </div>
            <a href="<?php echo site_url('irj/Rjclaporan/bor_los_toi_ruangan_excel/'.$bln);?>">
                <input type="button" class="btn" style="background-color: lime;color:white;margin:5px" value="EXCEL"></a>
        </div>
    </div>
</div>
<?php
}
?>






<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
    $('.datatable').DataTable({});
    $('#example').DataTable();
    $('#example1').DataTable();
    $('#example2').DataTable();
    $('#example3').DataTable();
    $('#example4').DataTable();
    $('#example5').DataTable();
    $('#example6').DataTable();
    $('#example7').DataTable();
    $('#example8').DataTable();
    $('#example9').DataTable();
    $('#example10').DataTable();
    $('#example11').DataTable();
    $('#example12').DataTable();
    $('#example13').DataTable();
	});
</script>
<?php

    $this->load->view("layout/footer_left");

?>
