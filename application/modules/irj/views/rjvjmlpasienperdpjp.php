<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>

<script type='text/javascript'>
$(function() {
	$('#dataTables-example').DataTable();

     $('#date_picker').show();
     $('#date_picker_months').hide();
     $('#date_picker_years').hide();
     $('#date_picker_months1').hide();
     $('#date_picker_months2').hide();
     
 });	
 
 function cek_tampil_per(val_tampil_per){
         if(val_tampil_per=='TGL'){
             document.getElementById("date_picker_months").value = '';
             document.getElementById("date_picker_months1").value = '';
             document.getElementById("date_picker_months2").value = '';
             document.getElementById("date_picker_years").value = '';
             document.getElementById("date_picker").required = true;
             document.getElementById("date_picker_months").required = false;
             document.getElementById("date_picker_months1").required = false;
             document.getElementById("date_picker_months2").required = false;
             document.getElementById("date_picker_years").required = false;
             $('#cara_bayar').show();
             $('#date_picker').show();			
             $('#date_picker_months').hide();
             $('#date_picker_months1').hide();
             $('#date_picker_months2').hide();
             $('#date_picker_years').hide();
         }else if(val_tampil_per=='BLN'){
             document.getElementById("date_picker").value = '';
             document.getElementById("date_picker_years").value = '';
             document.getElementById("date_picker_months1").value = '';
             document.getElementById("date_picker_months2").value = '';
             document.getElementById("date_picker").required = false;
             document.getElementById("date_picker_months").required = true;
             document.getElementById("date_picker_months1").required = false;
             document.getElementById("date_picker_months2").required = false;
             document.getElementById("date_picker_years").required = false;
             $('#date_picker').hide();
             $('#cara_bayar').hide();
             $('#date_picker_months').show();
             $('#date_picker_months1').hide();
             $('#date_picker_months2').hide();
             $('#date_picker_years').hide();
         } else if(val_tampil_per == "TRIWULAN") {
             document.getElementById("date_picker").value = '';
             document.getElementById("date_picker_years").value = '';
             document.getElementById("date_picker_months").value = '';
             document.getElementById("date_picker").required = false;
             document.getElementById("date_picker_months").required = false;
             document.getElementById("date_picker_months1").required = true;
             document.getElementById("date_picker_months2").required = true;
             document.getElementById("date_picker_years").required = false;
             $('#date_picker').hide();
             $('#cara_bayar').hide();
             $('#date_picker_months1').show();
             $('#date_picker_months2').show();
             $('#date_picker_months').hide();
             $('#date_picker_years').hide();
         }else{
             document.getElementById("date_picker").value = '';
             document.getElementById("date_picker_months").value = '';
             document.getElementById("date_picker_months1").value = '';
             document.getElementById("date_picker_months2").value = '';
             document.getElementById("date_picker").required = false;
             document.getElementById("date_picker_months").required = false;
             document.getElementById("date_picker_months1").required = false;
             document.getElementById("date_picker_months2").required = false;
             document.getElementById("date_picker_years").required = true;
             $('#date_picker').hide();
             $('#cara_bayar').hide();
             $('#date_picker_months1').hide();
             $('#date_picker_months2').hide();
             $('#date_picker_months').hide();
             $('#date_picker_years').show();
         }
 }


</script>
	
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
			<?php echo form_open('irj/Rjclaporan/lap_jml_pemeriksaan_dpjp');?>
				<div class="row p-t-20">
					<div class="col-md-2">
					<div class="form-group">
						<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
							<option value="TGL">Harian</option>
							<option value="BLN">Bulanan</option>
                            <option value="TRIWULAN">Triwulan</option>
							<option value="THN">Tahunan</option>
						</select>
					</div>
					</div>
					<div class="col-md-2">
					<div class="">
						<input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tgl" required>
						<input type="month" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
                        <input type="month" id="date_picker_months1" class="form-control" placeholder="yyyy-mm" name="bulan1">
						<input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun">
					</div>
                    </div>
					<div class="col-md-2">
					<div class="form-group">
                        <input type="month" id="date_picker_months2" class="form-control" placeholder="yyyy-mm" name="bulan2">
					</div>
					</div>						 
					<div class="col-md-2">
					<div class="form-group">
						<select name="id_poli" class="form-control" required  onchange="ajaxdokter(this.value)"> 
							<option value="" disabled selected>-Pilih Poli-</option>
							<option value="SEMUA">SEMUA</option>
							<?php 
							foreach($select_poli as $row){
								echo '<option value="'.$row->id_poli.'@'.$row->nm_poli.'">'.$row->nm_poli.'</option>';
							}
							?>
						</select>
					</div>
					</div>						
					<div class="col-md-2">
						<div class="form-group">
							<select name="id_dokter" id="id_dokter" class="form-control">
								<option value="SEMUA">SEMUA</option> 
							</select>
						</div>
					</div>
					<div class="col-md-1">
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">Cari</button>
					</div>
					</div>
				</div>
				<?php echo form_close();?>
			</div>			
		</div>						
	</div>
</div>
	
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Laporan Kunjungan Pasien IRJ Per DPJP <?php echo ($id_poli=="SEMUA" ? "Semua Poliklinik":"Poliklinik ".$nm_poli)." ".$date_title; ?></h4></div>
			
						<div class="panel-body">
							<div style="display:block;overflow:auto;">
						
								<?php 
								// if ($tampil_per=="TGL") {  
								// 	include("lapjml_perdpjp_harian.php");
								// } else if ($tampil_per=="BLN") {
								// 	include("lapjml_perdpjp_bulanan.php");
								// } else if ($tampil_per=="THN") {  
								// 	include("lapjml_perdpjp_tahunan.php");
								// } else if($tampil_per == "TRIWULAN") {
								// 	include("lapjml_perdpjp_triwulan.php");
								// } else if($tampil_per == "") {
								// 	include("lapjml_perdpjp_today.php");
								// }
								
								?>
								
								<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
									<thead>
										<tr>
											<th>Nama Dokter</th>
											<th>Poli</th>
											<!-- <th>Tanggal Kunjungan</th> -->
											<th>Jumlah Pasien</th>
										</tr>
									</thead>

									<tbody>
												<?php
													//$i=1;
													foreach($data_kunjungan as $r){

											//			print_r($data_kunjungan);exit();
													//$vtot=$vtot+$row->jumlah_kunj;
														// if ($row2->id_poli==$row1->id_poli) {						
													?>
									<!-- 				<tr>
														<td> <?php echo $i++;?></td>
														<td> <?php echo $row->tanggal;?></td>
														<td><?php echo $row->no_cm;?></td>
														<td><?php echo strtoupper($row->nama);?></td>					
														<td><?php echo $row->jenis_kelamin;?></td>
														<td><?php echo $row->nama_poli;?></td>
														<td><?php echo $row->nama_dokter;?></td>
														<td><?php echo $row->cara_bayar;?></td>						
													</tr> -->

													<tr>
														<!-- <td><?php echo $i++;?></td> -->
														<td><?php echo $r['nm_dokter'];?></td>
														<td><?php echo $r['nm_poli'];?></td>
														<!-- <td><?php echo $r['tgl'];?></td> -->
														<td><?php echo $r['jumlah'];?></td>							
													</tr>
												<?php
														}
												?>
													

									</tbody>
								</table>
								
							<div class="form-inline" align="right">
								<div class="form-group">
									<!--<a target="_blank" href="<?php // echo site_url('irj/rjclaporan/lap_kunj_poli/'.$tgl_awal.'/'.$tgl_akhir);?>"><input type="button" class="btn btn-primary" value="Cetak Detail"></a>-->
									
									<?php
									//SET PASSING PARAM
									// $param=$tampil_per;
									// if ($tampil_per=="TGL") {
									// 	$param .= "/".$id_poli."/".$tgl."/".$id_dokter;
									// } else if ($tampil_per=="BLN") {
									// 	$param .= "/".$id_poli."/".$bulan."/".$id_dokter;
									// } else if ($tampil_per=="THN") {
									// 	$param .= "/".$id_poli."/".$tahun."/".$id_dokter;
									// } else if($tampil_per == "TRIWULAN") {
									// 	$param .= "/".$id_poli."/".$bulan_awal."/".$bulan_akhir."/".$id_dokter;
									// }
										?>
									<!-- <a target="_blank" href="<?php echo site_url('irj/rjccetaklaporan/pdf_lapkunj/'.$param);?>"><input type="button" class="btn 
									btn-primary" value="PDF"></a> -->
									<?php
									if(($tampil_per == 'TGL') || ($tampil_per == 'BLN') || ($tampil_per == 'THN')) { ?>
										<a href="<?php echo site_url('irj/rjclaporan/excel_lapjml_dpjp');?><?php echo '/'.$tampil_per.'/'.$id_poli.'/'.$tgl.'/'.$id_dokter;?>"><input type="button" class="btn 
										" style="background-color: lime;color:white;" value="EXCEL"></a>
										&nbsp;
									<?php
									} else if($tampil_per == 'TRIWULAN') { ?>
										<a href="<?php echo site_url('irj/rjclaporan/excel_lapjml_dpjp_triwulan');?><?php echo '/'.$tampil_per.'/'.$id_poli.'/'.$tgl.'/'.$bulan_akhir.'/'.$id_dokter;?>"><input type="button" class="btn 
										" style="background-color: lime;color:white;" value="EXCEL"></a>
										&nbsp;
									<?php
									} else if($tampil_per == "") { ?>
										<a href="<?php echo site_url('irj/rjclaporan/excel_lapjml_dpjp_today');?><?php echo '/'.$tgl;?>"><input type="button" class="btn 
										" style="background-color: lime;color:white;" value="EXCEL"></a>
										&nbsp;
									<?php
									}
									?>
									<!-- <a href="<?php echo site_url('irj/rjclaporan/pdf_lap_kunj_irj/'.$param);?>" target="_blank"><input type="button" class="btn 
									" style="background-color: red;color:white;" value="PDF"></a> -->
									
									
									<!--<?php //echo form_open('irj/Rjclaporan/cetak_lap_kunj');?>
									<input type="hidden" value="<?php //echo (isset($tampil_per) ? $tampil_per:""); ?>" name="tampil_per">          
									<button class="btn btn-primary" type="submit">Cetak Laporan</button>
									<?php //echo form_close();?>
									-->
									</div>
								<?php 
							
								?>
						</div>							
				</div>
			</div>
		</div>	
	</div>
</div>

    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 


<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});

var ajaxku;
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function ajaxdokter(id_poli){
	var id = id_poli.substr(0,4);
	var pokpoli = id_poli.substr(5);
	console.log(id_poli);
	console.log(id);
	console.log(pokpoli);

	var val_cara_bayar = $('#cara_bayar').val();
	var cara_kunjungan = $('#cara_kunjungan').val();
	//var res=id.split("-");//it Works :D

    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjclaporan/data_dokter_poli'); ?>";
    url=url+"/"+id;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	//document.getElementById("id_provinsi").value = res[0];
	//document.getElementById("provinsi").value = res[1];  
	
}

function stateChangedDokter(){
    var data;
	console.log(ajaxku.readyState);
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;	
		if(data.length>=0){
			document.getElementById("id_dokter").innerHTML = data;
		}
    }
}
stateChangedDokter();
</script>