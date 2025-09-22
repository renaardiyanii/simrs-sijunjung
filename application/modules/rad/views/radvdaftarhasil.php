<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>

<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
} );
//---------------------------------------------------------

		
function isi_value(isi_value, id) {
	document.getElementById(id).value = isi_value;
}	
var site = "<?php echo site_url();?>";
function simpan_hasil(id) {
	var x = document.getElementById(id).value;
	dataString = 'id='+id+'&val='+x;
	$.ajax({
        type: "GET",
        url:"<?php echo base_url('rad/Radcpengisianhasil/simpan_hasil')?>",
		data: dataString,
        cache: false,
        success: function(html) {	
            location.reload();
        }
    });
}
function newform(id, no_rad) {
	var myWindow = window.open("<?php echo site_url('rad/Radcpengisianhasil/cetak_hasil_rad_pertindakan'); ?>/"+id+"/"+no_rad,"_blank");
		myWindow.focus();
}

function cetak_old(no_rad) {
	var myWindow = window.open("<?php echo base_url('rad/Radcpengisianhasil/cetak_hasil_rad')?>/"+no_rad, "_blank");
		myWindow.focus();
}

function cetak(id_pemeriksaan, no_rad) {
	var myWindow = window.open("<?php echo base_url('rad/Radcpengisianhasil/cetak_hasil_rad_tindakan')?>/"+id_pemeriksaan+"/"+no_rad, "_blank");
		myWindow.focus();
}
</script>
<style>
	.cetak_hasil {
		background-color: #50CB93 !important;
	}
</style>

<?php echo $this->session->flashdata('statusMsg'); ?>
<?php echo $this->session->flashdata('success_msg'); ?>
<?php include('radvdatapasien.php');?>


<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Pengisian Hasil Tes Radiologi : <?php echo $no_rad; ?></h4>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
						<a href="<?php echo base_url().'rad/radcpengisianhasil/'; ?>" class="btn btn-danger" style="padding-left: 10px;padding-right: 10px; margin-bottom:10px">Kembali</a>
							<?php //if($no_lab != null){ ?>
								<!-- <a href="<?php echo base_url().'lab/labcpengisianhasil/cetak_hasil_lab/'.$no_lab; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px; margin-bottom:10px">Hasil LAB Terakhir</a> -->
							<?php //}else{ ?>								
							<?php //} ?>
							<?php //if(substr($no_register, 0,2) == 'RJ') { 
									//if($id_poli == 'BA00') { ?>
										<!-- <a href="<?php echo base_url().'ird/rdcpelayanan/form/konsultasi/'.$no_register; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">Konsultasi</a> -->
										<!-- <a href="<?php echo base_url().'emedrec/C_emedrec/cetak_cppt_pasien_all/'.$no_medrec; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">History CPPT</a>&nbsp;&nbsp; -->
									<?php //} else { ?>
										<!-- <a href="<?php echo base_url().'irj/rjcpelayananfdokter/form/konsul/'.$id_poli.'/'.$no_register.'/'.$radio; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">Konsultasi</a> -->
										<!-- <a href="<?php echo base_url().'emedrec/C_emedrec/cetak_cppt_pasien_all/'.$no_medrec; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">History CPPT</a>&nbsp;&nbsp; -->
									<?php //} ?>
							<?php //} else if (substr($no_register, 0,2) == 'RI') { ?>
								<!-- <a href="<?php echo base_url().'iri/rictindakan/form/konsul/'.$no_register.'/'.$radio; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">Konsultasi</a> -->
								<!-- <a href="<?php echo base_url().'emedrec/C_emedrec_iri/get_cppt_iri_all/'.$no_register.'/'.$no_cm.'/'.$no_medrec; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">History CPPT</a>&nbsp;&nbsp; -->
							<?php  //} ?>
							<table id="example" class="table display table-bordered table-striped" cellspacing="0" width="100%"> 
								<thead>
									<tr>
									  <th>No Rad</th>
									  <th>Id Tind</th>
									  <th>Jenis Pemeriksaan</th>
									  <!-- <th>Hasil Pemeriksaan</th> -->
									  <th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									// print_r($pasien_daftar);
										$i=1;
										$jum=0;
										$cetak = sizeof($daftarpengisian);
										// echo json_encode($daftarpengisian);
										foreach($daftarpengisian as $row){
										//var_dump($daftarpengisian);die();
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
											if($row->cetak_hasil == 1) {
												$cetak_hasil = 'cetak_hasil';
											} else {
												$cetak_hasil = '';
											}
									?>
										<tr>
										  	<td class ="<?php echo $cetak_hasil;?>"><?php echo $row->no_rad;?></td>
										  	<td class ="<?php echo $cetak_hasil;?>"><?php echo $row->id_pemeriksaan_rad;?></td>
										  	<td class ="<?php echo $cetak_hasil;?>"><?php echo $row->jenis_tindakan;?></td>
										  	
									  		<?php 
								  				if($row->id_hasil_rad==''){
								  					// echo "<td>Hasil Belum di Isi</td>";
									  		?>
											  		<td class ="<?php echo $cetak_hasil;?>">
														<a href="<?php echo site_url('rad/radcpengisianhasil/isi_hasil/'.$row->id_pemeriksaan_rad); ?>" class="btn btn-primary">Isi Hasil</a>
													</td>
									  		<?php 
								  				} else if($row->id_hasil_rad!=''){
								  					$jum++;
								  					// echo "<td>Hasil <b>Sudah</b> di Isi</td>";
								  			?>
										  			<td class ="<?php echo $cetak_hasil;?>">
														<div class="form-inline">
															<a href="javascript:;" class="btn btn-danger" style="margin-right: 5px;" onClick="return openUrl('<?php echo site_url('rad/Radcpengisianhasil/edit_hasil/'.$row->id_pemeriksaan_rad); ?>');">Edit Hasil</a>
															<!-- <a href="javascript:;" class="btn btn-info" style="margin-right: 5px;" onClick="newform('<?php echo $this->hashData($row->id_pemeriksaan_rad) ?>', '<?php echo $this->hashData($row->no_rad) ?>');">Cetak Hasil</a> -->
															<form id="pengisianhasilform" method="post">
																<input type="hidden" name="id_dokter" id="id_dokter" value="<?php echo $row->id_dokter?>">
																<input type="hidden" name="nm_dokter" id="nm_dokter" value="<?php echo $row->nm_dokter?>">
																<input type="hidden" name="id_pemeriksaan_rad" id="id_pemeriksaan_rad" value="<?php echo $row->id_pemeriksaan_rad?>">
																<input type="hidden" name="no_cm" id="no_cm" value="<?php echo $no_cm?>">
																<input type="hidden" name="hasil_pengirim" id="hasil_pengirim" value="<?php echo $row->hasil_pengirim?>">
																<input type="hidden" name="accession_number" id="accession_number" value="<?php echo $row->accesion_number?>">
																<!-- <button type="button" onclick="sendtopacs('<?php echo $row->id_pemeriksaan_rad ?>')" class="btn btn-info">Kirim PACS</button> -->
															</form>
															<a href="<?php echo base_url('rad/radcpengisianhasil/st_cetak_hasil_rad/'.$row->id_pemeriksaan_rad.'/'.$row->no_rad);?>" class="btn btn-success" style="margin-left: 5px;" onClick="cetak('<?php echo $row->id_pemeriksaan_rad ?>','<?php echo $row->no_rad ?>');">SELESAI</a>
														</div>
													</td>
									  		<?php 
								  				}
									  		?>
										</tr>
									<?php
										}
									?>
								</tbody>
							</table>

							<?php
							// if($cetak==$jum){
							// 	echo form_open('rad/radcpengisianhasil/st_cetak_hasil_rad');
							
							?>
							<!-- <div>
			                    <hr class="m-t-20">
			                </div>
							<div class="col-md-12" align="right">
								<select hidden id="no_rad" class="form-control" name="no_rad"  required>
									<?php 
										//echo "<option value='$no_rad' selected>$no_rad</option>";
									?>
								</select>
								<input type="hidden" name="norad" id="norad" value="<?php //echo $no_rad ?>">
								<button type="submit" onClick="cetak('<?php //echo $no_rad ?>')" class="btn btn-info">SELESAI</button>
						
							</div> -->
							<?php 
							// 	echo form_close();
							// }
							?>	
                        </div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>
<script>
	var no_rad = <?php echo $no_rad; ?>;
	//var id = <?php //echo $id_pemeriksaan_rad; ?>;

	function sendtopacs() {
		// console.log(id_pemeriksaan);
		let data = $('#pengisianhasilform').serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('rad/radcpengisianhasil/sendpacs_luar') ?>',
			data: data,
			beforeSend: function() {},
			success: function(data) {},
			error: function(xhr) {

			},
			complete: function() {
				location.href = '<?php echo base_url() . 'rad/radcpengisianhasil/daftar_hasil/' ?>'+no_rad;
			},
			dataType: 'json'
		});
	}
</script>

<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>