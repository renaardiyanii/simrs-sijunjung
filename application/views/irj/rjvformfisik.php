
										<?php echo form_open('irj/rjcpelayanan/insert_fisik'); ?>			
										<div class="form-group row">
											<label for="td" class="col-2 col-form-label">Tekanan Darah</label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="td" id="td" placeholder="Contoh 120/80 mmHg" value="<?php 
														if ($td == null){
															echo '';
														} else {
															echo $td;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="bb" class="col-2 col-form-label">Berat Badan</label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="bb" id="bb" placeholder="Contoh 50 kg" value="<?php 
														if ($td == null){
															echo '';
														} else {
															echo $bb;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Tinggi Badan</label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="tb" id="tb" placeholder="Contoh 165 cm" value="<?php 
														if ($td == null){
															echo '';
														} else {
															echo $tb;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Nadi</label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="nadi" id="nadi" placeholder="x/mnt" value="<?php 
														if ($nadi == null){
															echo '';
														} else {
															echo $nadi;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Suhu</label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="suhu" id="suhu" placeholder="Celcius" value="<?php 
														if ($suhu == null){
															echo '';
														} else {
															echo $suhu;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">RR</label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="rr" id="rr" placeholder="Contoh : < 12" value="<?php 
														if ($rr == null){
															echo '';
														} else {
															echo $rr;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="catatan" class="col-2 col-form-label">Anamnesa</label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="catatan" id="catatan"><?php 
														if ($catatan == null){
															echo '';
														} else {
															echo $catatan;
														}?>
													
												</textarea>
											</div>
										</div>										
										
									
											<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
											<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
											<div class="form-group row">
											<div class="offset-sm-2 col-sm-8">	
												<button type="submit" class="btn btn-primary">Simpan</button>
												</div>
											</div>
									
									<?php echo form_close();?>
									
									

