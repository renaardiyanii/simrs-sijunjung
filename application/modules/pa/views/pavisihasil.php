<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<html>
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

</script>
	<?php include('pavdatapasien.php');
	$itot=0;?>
	
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-outline-info">
					<div class="card-header">
						<h4 class="m-b-0 text-white">Tindakan : <?php echo $jenis_tindakan ?></h4>
					</div>

					<div class="card-block">
						<form action="<?php echo site_url('pa/pacpengisianhasil/simpan_hasil'); ?>" id="pengisianhasilform" method="post">

							<div class="form-group row">
								<label for="inputFile_hasil" class="col-sm-12 col-lg-3 form-control-label">Upload Hasil</label>
								<div class="col-sm-12 col-lg-8">
									<input type="file" class="form-control" id="userFiles" name="userFiles[]" multiple accept="image/*" />
								</div>
							</div>

							<div class="form-group row">
								<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_pengirim">Deskripsi</p>
								<div class="col-sm-12 col-lg-8">
									<textarea rows="20" cols="110" name="hasil_pa" id="hasil_pa" class="form-control"></textarea>
								</div>
							</div>

							<div>
								<hr class="m-t-20">
							</div>
							<div class="col-md-12" align="right">
								<input type="hidden" class="form-control" value="<?php echo $id_pemeriksaan_pa; ?>" name="id_pemeriksaan_pa">
								<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
								<input type="hidden" class="form-control" value="<?php echo $no_pa; ?>" name="no_pa">
								<input type="hidden" class="form-control" value="<?php echo $jenis_tindakan; ?>" name="jenis_tindakan">
								<input type="hidden" class="form-control" value="<?php echo $id_tindakan; ?>" name="id_tindakan">
								<input type="hidden" class="form-control" value="<?php echo $no_cm; ?>" name="no_cm">
								<input type="hidden" class="form-control" value="<?php echo $nama; ?>" name="nama">
								<input type="hidden" class="form-control" value="<?php echo $asal; ?>" name="asal">
								<input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>" name="tgl_kun">
								<input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>" name="kelas">
								<a href="javascript:;" class="btn btn-danger" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/' . $no_pa); ?>');">Back</a>
								<button type="submit" class="btn btn-info">Simpan</button>
								
							</div>

						</form>


					</div>
				</div>
			</div>
			
		</div>
	


<?php
	$this->load->view('layout/footer_left.php');
?>