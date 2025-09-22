
<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}?>

<script type='text/javascript'>
$(function() {
	 
	$('#dataTables-example').DataTable();

	// $('#date_picker1').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	// $('#date_picker2').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	

	// $('#date_picker_months').datepicker({
	// 	format: "yyyy-mm",
	// 	//endDate: "current",
	// 	autoclose: true,
	// 	todayHighlight: true,
	// 	viewMode: "months", 
	// 	minViewMode: "months",
	// }); 
	// $('#date_picker_years').datepicker({
	// 	format: "yyyy",
	// 	//endDate: "current",
	// 	autoclose: true,
	// 	todayHighlight: true,
	// 	format: "yyyy",
	// 	viewMode: "years", 
	// 	minViewMode: "years",
	// });
	// $('#date_picker1').show();
	// $('#date_picker2').show();
	// $('#date_picker_months').hide();
	// $('#date_picker_years').hide();
    $('#date_picker').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();
});	
// function cek_tgl_awal(tgl_awal){
// 		//var tgl_akhir=document.getElementById("date_picker2").value;
// 		var tgl_akhir=$('#date_picker2').val();
// 		if(tgl_akhir==''){
// 		//none :D just none
// 		}else if(tgl_akhir<tgl_awal){
// 			$('#date_picker2').val('');
// 			//document.getElementById("date_picker2").value = '';
// 		}
// 	}
// 	function cek_tgl_akhir(tgl_akhir){
// 		//var tgl_awal=document.getElementById("date_picker1").value;
// 		var tgl_awal=$('#date_picker1').val();
// 		if(tgl_akhir<tgl_awal){
// 			$('#date_picker1').val('');
// 			//document.getElementById("date_picker1").value = '';
// 		}
// 	}
function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#cara_bayar').show();
			$('#date_picker').show();			
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
			$('#id_dokter').show();	
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
			$('#id_dokter').hide();	
		}else{
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
			$('#id_dokter').hide();	
		}
}

</script>

<div >
	<div >
		
		<div class="container-fluid"><br/><br/>
			<div class="inline">
				<div class="row">
					<div class="form-inline">
						<form action="<?php echo base_url();?>iri/riclaporan/lap_data_pasien_pulang_iri" method="post" accept-charset="utf-8">
						<div class="col-lg-12">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
                                    <option value="BLN">Bulan</option>
                                    <!-- <option value="THN">Tahun</option> -->
								</select>
								<div class="">
                                    <input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tgl" required>
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun">
                                </div>
                                <button class="btn btn-primary" type="submit">Tampilkan</button>
								
							</div>
						</div><!-- /inline -->
					</div>
					</form>		</div>						
			</div>
		</div>
			
		<div class="container-fluid"><br/>
		<section class="content">
				<div class="row">
						<div class="card card-outline-info">
							<div class="card-header text-white" align="center" >Laporan Kunjungan Data Pasien Rawat Inap <br> 
							Per <?php echo $tgl; ?>
							</div>
							<div class="card-block">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
                                <th>No Register</th>
								<th>Nama</th>
								<th>No RM</th>
								<!-- <th>Jenis Pasien</th> -->
								<th>Umur</th>
								<th>Jenkel</th>
                                <!-- <th>Poli</th> -->
								<th>Jaminan</th>
								<th>Alamat</th>
                                <th>Diagnosa</th>
                                <th>Kode ICD 10</th>
                                <th>Dokter</th>
							</tr>
						  </thead>

						  	<tbody>
				<?php
					// $i=0;
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
                        <td><?php echo $r['no_ipd'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['no_cm'];?></td>
						<!-- <td><?php echo $r['jns_kunj'];?></td>					 -->
						<td><?php
                            $start = new DateTime($r['tgl_lahir']);//start
                            $end = new DateTime('today');//end
                            $y = $end->diff($start)->y;

                            echo $y.' Tahun';
                        ?></td>
						<td><?php echo $r['kelamin'];?></td>
                        <!-- <td><?php echo $r['nm_poli'];?></td> -->
						<td><?php echo $r['carabayar'];?></td>
						<td><?php echo $r['alamat'];?></td>
                        <td><?php echo $r['diag1'];?></td>	
                        <td><?php echo $r['id_diag'];?></td>   
                        <td><?php echo $r['nm_dokter'];?></td>						
					</tr>
				<?php
						}
					// }
					// $vtot=$vtot+($i-1);
				?>
					<!-- <tr>
						<td colspan="6"><p align="right"><b>Total</b></p></td>
						<td BGCOLOR="yellow"><p align="right"><b><?php echo $i-1;?></b></p></td>
					</tr> -->

							</tbody>
						</table>
						<br>
						<div class="form-inline" align="right">
							<div class="form-group">
								<!--<a target="_blank" href="<?php //echo site_url('iri/riclaporan/cetak_laporan_harian/');?><?php //echo '/'.$tgl_awal ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan PDF"></a>-->
                                <?php
                                if($tampil_per != "") { ?>
                                    <a target="_blank" href="<?php echo site_url('iri/Riclaporan/excel_lap_data_pasien_pulang_iri');?><?php echo '/'.$tampil_per.'/'.$tgl;?>"><input type="button" class="btn 
                                    btn-primary" value="Cetak Laporan Excel"></a>
                                <?php
                                } else if($tampil_per == "") { ?>
                                    <a target="_blank" href="<?php echo site_url('iri/Riclaporan/excel_lap_data_pasien_pulang_iri_today');?><?php echo '/'.$tgl;?>"><input type="button" class="btn 
                                    btn-primary" value="Cetak Laporan Excel"></a>
                                <?php
                                }
                                ?>
							</div>
						</div>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
		</section>
		<!-- /Main content -->
		</div>

	</div>
</div>
<script>
	$('#calendar-tgl').datepicker();

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

<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>


