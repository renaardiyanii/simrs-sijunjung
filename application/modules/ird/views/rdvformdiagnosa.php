<?php include('script_rdvpelayanan.php'); ?>
<form class="form" id="form_add_diagnosa">
	<div class="form-group row">
        <label for="id_diagnosa" class="col-3 col-form-label">Diagnosa (ICD-10)</label>
        <div class="col-9">
            <input type="text" class="form-control input-sm autocomplete_diagnosa"  name="id_diagnosa" id="id_diagnosa" style="max-width:450px;font-size:15px;" required="true">
  			<input type="hidden" class="form-control" name="diagnosa_separate" id="diagnosa_separate">
        </div>
    </div>				
	<div class="form-group row">
        <label for="diagnosa_text" class="col-3 col-form-label">Catatan</label>
        <div class="col-9">
            <textarea class="form-control" name="diagnosa_text" id="diagnosa_text" cols="30" rows="5" style="resize:vertical"></textarea>
        </div>
    </div>           	
	<div class="form-group row">
		<div class="offset-sm-3 col-sm-9">									
			<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
			<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="noreg_diag">
			<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
			<input type="hidden" name="tgl_kunjungan" value="<?php echo $tgl_kunjungan;?>">
			<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
			<button type="button" class="btn btn-primary" id="btn-diagnosa" onclick="insert_diagnosa()"><i class="fa fa-floppy-o"></i> Simpan</button>
		</div>
	</div>										
</form>
<hr>							
<div class="table-responsive">
	<table id="table_diagnosa" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>No</th>
				<th>ID Diagnosa</th>
				<th>Catatan</th>
				<th class="text-center">Klasifikasi</th>
				<th class="text-center">Aksi</th>
			</tr>
		</thead>
		<tbody>
	
		</tbody>
	</table>
</div> <!-- table-responsive -->
