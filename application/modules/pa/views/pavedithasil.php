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
                <h4 class="m-b-0 text-white">Edit Tindakan : <?php echo $jenis_tindakan?></h4>
            </div>
			<div class="card-block">
			<?php echo form_open('pa/pacpengisianhasil/edit_hasil_submit'); ?>
				<div class="form-group row">
					<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_pengirim">Deskripsi</p>
					<div class="col-sm-12 col-lg-8">
						<textarea rows="20" cols="110" name="hasil_pa" id="hasil_pa" class="form-control"><?php echo isset($get_data_edit_tindakan_pa->hasil_pa)?$get_data_edit_tindakan_pa->hasil_pa:''; ?></textarea>
					</div>
				</div>

				<div class="form-inline" align="right">
					<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
					<input type="hidden" class="form-control" value="<?php echo $no_pa;?>" name="no_pa">
					<input type="hidden" class="form-control" value="<?php echo $get_data_edit_tindakan_pa->id_hasil_pemeriksaan;?>" name="id_hasil_pemeriksaan">
					<a href="javascript:;" class="btn btn-danger" onClick="return openUrl('<?php echo site_url('pa/pacpengisianhasil/daftar_hasil/'.$no_pa); ?>');">Back</a>&nbsp;&nbsp;&nbsp;
					<button type="save" class="btn btn-primary">Simpan</button>
				</div>


			<?php echo form_close();?>

			</div>
		</div>
	</div>
</div>




<?php
	$this->load->view('layout/footer_left.php');
?>