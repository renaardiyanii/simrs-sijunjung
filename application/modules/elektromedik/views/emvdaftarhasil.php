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
        url:"<?php echo base_url('elektromedik/Emcpengisianhasil/simpan_hasil')?>",
		data: dataString,
        cache: false,
        success: function(html) {	
            location.reload();
        }
    });
}
function newform(id, no_em) {
	var myWindow = window.open("<?php echo site_url('elektromedik/Emcpengisianhasil/cetak_hasil_em_pertindakan/'); ?>"+id+"/"+no_em,"_blank");
		myWindow.focus();
}

function cetak(no_em) {
	var myWindow = window.open("<?php echo base_url('elektromedik/Emcpengisianhasil/cetak_hasil_em')?>/"+no_em,"_blank");
		myWindow.focus();
}

</script>

<?php echo $this->session->flashdata('statusMsg'); ?>
<?php echo $this->session->flashdata('success_msg'); ?>
<?php include('emvdatapasien.php');?>


<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Pengisian Hasil Tes Elektromedik : <?php echo $no_em; ?></h4>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">

							<table id="example" class="table display table-bordered table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
									  <th>No Em</th>
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
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
										
									?>
										<tr>
										  	<td><?php echo $row->no_em;?></td>
										  	<td><?php echo $row->id_pemeriksaan_em;?></td>
										  	<td><?php echo $row->jenis_tindakan;?></td>
										  	
									  		<?php 
								  				if($row->id_hasil_em==''){
								  					// echo "<td>Hasil Belum di Isi</td>";
									  		?>
											  		<td>
														<a href="<?php echo site_url('elektromedik/Emcpengisianhasil/isi_hasil/'.$row->id_pemeriksaan_em); ?>" class="btn btn-primary">Isi Hasil</a>
													</td>
									  		<?php 
								  				} else if($row->id_hasil_em!=''){
								  					$jum++;
								  					// echo "<td>Hasil <b>Sudah</b> di Isi</td>";
								  			?>
										  			<td>
														<a href="javascript:;" class="btn btn-danger" onClick="return openUrl('<?php echo site_url('elektromedik/Emcpengisianhasil/edit_hasil/'.$row->id_pemeriksaan_em); ?>');">Edit Hasil</a>
														<a href="javascript:;" class="btn btn-info" onClick="newform('<?php echo $row->id_pemeriksaan_em ?>', '<?php echo $row->no_em ?>');">Cetak Hasil</a>
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
							if($cetak==$jum){
								echo form_open('elektromedik/Emcpengisianhasil/st_cetak_hasil_em');
							
							?>
							<div>
			                    <hr class="m-t-20">
			                </div>
							<div class="col-md-12" align="right">
								<select hidden id="no_em" class="form-control" name="no_em"  required>
									<?php 
										echo "<option value='$no_em' selected>$no_em</option>";
									?>
								</select>
								<input type="hidden" name="noem" id="noem" value="<?php echo $no_em ?>">
								<button type="submit" onClick="cetak('<?php echo $no_em ?>')" class="btn btn-info">SELESAI</button>
						
							</div>
							<?php 
								echo form_close();
							}
							?>	
                        </div>
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