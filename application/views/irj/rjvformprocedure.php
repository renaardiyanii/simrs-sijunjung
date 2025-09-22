			<!-- form -->
			<form class="form" id="form_add_procedure">
				<div class="form-group row">
	                <label for="id_procedure" class="col-3 col-form-label">Prosedur (ICD-9-CM)</label>
	                <div class="col-9">
	                    	<input type="text" class="form-control input-sm autocomplete_procedure"  name="id_procedure" id="id_procedure" style="max-width:450px;font-size:15px;">
	          				<input type="hidden" class="form-control " name="procedure_separate" id="procedure_separate">
	                </div>
	            </div>	
				<div class="form-group row">
	                <label for="procedure_text" class="col-3 col-form-label" id="catatan">Catatan</label>
	                <div class="col-9">
	                    	<textarea class="form-control" name="procedure_text" id="procedure_text" cols="30" rows="5" style="resize:vertical"></textarea>
	                </div>
            	</div>            	
				<div class="form-group row">
					<div class="offset-sm-3 col-sm-9">	
							<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
							<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="noreg_procedure">
							<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
							<input type="hidden" name="tgl_kunjungan" value="<?php echo $tgl_kunjungan;?>">
							<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
							<button type="button" class="btn btn-primary" id="btn-procedure" onclick="insert_procedure()"><i class="fa fa-floppy-o"></i> Simpan</button>								
					</div>
				</div>									
			</form>
								
		<!-- table -->
		<hr>
		<div class="table-responsive">
			<table id="tabel_procedure" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Prosedur</th>
						<th>Catatan</th>
						<th class="text-center">Klasifikasi</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
			
				</tbody>
			</table>
		</div> <!-- table-responsive -->
