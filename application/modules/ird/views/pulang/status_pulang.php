<div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Kesimpulan Akhir</h5></div>
                    <div class="card-block">
						<?php echo form_open('ird/rdcpelayanan/update_pulang'); ?>
						<!-- <form method="POST" onsubmit="return validate(this)" action="<?php echo base_url('ird/rdcpelayanan/update_pulang')?>"> -->
						<!-- <input type="hidden" name="no_register" value="<?php// echo $no_register;?>"> -->
						<input type="hidden" name="sebagai" value="<?= $pelayan??""; ?>">
						<input type="hidden" name="id_dokter_asal" value="<?php  echo $dokter_tindakan2[0]->id_dokter;?>">
						<input type="hidden" name="id_dokter" value="<?php  echo $dokter_tindakan2[0]->id_dokter;?>">
						<input type="hidden" name="nama_dokter" value="<?php  echo $dokter_tindakan2[0]->nm_dokter;?>">
						<input type="hidden" name="id_poli_asal" value="<?php echo $id_poli;?>">
						<input type="hidden" name="nama_pasien" value="<?php echo strtoupper($data_pasien_daftar_ulang->nama);?>">
						<input type="hidden" name="no_register_lama" value="<?php echo $data_pasien_daftar_ulang->no_register_lama;?>">
                            <div class="form-group row">
                                <p class="col-sm-4 form-control-label" id="lbl_kondisi_pulang">Kondisi saat Pulang</p>
                                    <div class="col-sm-8">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <select class="form-control custom-select" name="tindak_lanjut" id="tindak_lanjut">
                                                    <option value="">-Pilih Kondisi-</option>
                                                    <!-- <option value="PULANG">Pulang</option> -->
                                                    <option value="sembuh">Sembuh</option>					
                                                    <option value="perbaikan">Perbaikan</option>
                                                    <option value="tidak_sembuh">Tidak Sembuh</option>
                                                    <option value="meninggal">Meninggal</option>
                                                    <option value="doa">D O A</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" id="lbl_ket_pulang">Status Pulang</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control custom-select" name="ket_pulang" id="ket_pulang" onchange="pilih_ket_pulang(this.value)" required>
													<option value="">-Pilih Ket Pulang-</option>
													<option value="DIRUJUK_RAWATINAP">Dirujuk Rawat Inap</option>
													<option value="izin_dokter">Izin Dokter</option>					
													<option value="atas_permintaan_sendiri">Atas Permintaan Sendiri</option>
													<option value="tindak_lanjut">Tindak Lanjut</option>
													<option value="rujuk_rs_lain">Dirujuk RS Lain</option>
													<option value="Puskesmas">Puskesmas</option>
													<option value="dirujuk">Dirujuk ke</option>
												</select>
											</div>
										</div>
									</div>
							</div>

							<!-- <div class="form-group row" id="div_rujukan">
								<label class="col-ms-4 form-control-label">Rujukan</label>
								<div class="col-sm-8">
									<select class="form-control custom-select" name="rujukan">
										<option value="regional">Regional</option>
										<option value="nasional">Nasional</option>
										<option value="rslain">RS Lain</option>
									</select>
								</div>
							</div> -->

                            <div class="form-group row" id="div_puskesmas">
									<p class="col-sm-4 form-control-label" >Tujuan Puskesmas</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="puskesmas_tujuan" id="tujuan_puskesmas" cols="25" rows="3" style="resize:vertical" ></textarea>
									</div>
							</div>
							<div class="form-group row" id="div_rujukrslain">
									<p class="col-sm-4 form-control-label" >Tujuan RS</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="tujuan_rs" id="tujuan_rs" cols="25" rows="3" style="resize:vertical" ></textarea>
									</div>
							</div>

							<div class="form-group row" id="dirujuk_rj_ke_poli">
								<p class="col-sm-4 form-control-label label-sm" id="dirujuk_ke">Dirujuk Ke:</p>
									<div class="col-sm-8">
											<div class="form-inline">
													<select id="id_poli_rujuk" class="form-control custom-select" name="id_poli_rujuk" onchange="ajaxdokter(this.value)">
														<option value="">-Pilih Nama Poli-</option>
														<?php 
														foreach($poliklinik as $row){
															echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
														}
														?>
													</select>
												
											</div>
											<!--
											<input type="search" style="width:300px" class="auto_search_poli form-control input-sm" id="nm_poli" placeholder="Nama Poli">
											
											<div class="form-inline">
											ID Poli : <input type="text" size="8" class="form-control input-sm" placeholder="" id="id_poli" readonly name="id_poli_rujuk">
											Ruang : <input type="text" size="8" class="form-control input-sm" placeholder="" id="kd_ruang" readonly name="kd_ruang_rujuk">
											</div>
											-->
									</div>
							</div>
							<div class="form-group row" id="pilih_dokter">
								<p class="col-sm-4 form-control-label label-sm">Dokter:</p>
									<div class="col-sm-8">
											<div class="form-inline">
													<select id="id_dokter_rujuk" class="form-control custom-select" name="dokter_kontrol_id">
														<option value="">-Pilih Dokter-</option>
														<?php 
														// foreach($dokter as $row){
														// 	echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
														// }
														?>
													</select>
												
											</div>
											
									</div>
							</div>
							
							<!-- add jam kontrol ulang -->

							<div class="form-group row" id="div_jam">
								<p class="col-sm-4 form-control-label" id="lbl_jam_kontrol">Jam</p>
									<div class="col-sm-8">
										<div class="form-inline">
										<div class='input-group clockpicker' >
												<input type="text" id="jam_kontrol_ulang" class="form-control" placeholder="Jam Kontrol Ulang" name="jam_kontrol_ulang">
												<span class="input-group-addon">
													<span class="fa fa-clock-o"></span>
												</span>
											</div>
										</div>
									</div>
							</div>

							

			

							


							<?php //tampilkan jika poli penyakit dalam BQ00
								// if ($id_poli=='BQ00'){
							?>
							<div class="form-group row" id="div_rujuk_penunjang" style="display:none">
								<p class="col-sm-3 form-control-label" id="lbl_tgl_kontrol">Rujuk Penunjang</p>
								<div class="col-sm-9">
									<div class="form-group col-sm-6">
										<div id="ok_refresh">
										 	<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->ok=='1'){
													if($rujukan_penunjang->status_ok=='0'){
														echo '<input type="checkbox" id="ok1" name="ok1" value=null unchecked disabled> Operasi<br>belum selesai.';
													} else if($rujukan_penunjang->status_ok=='1'){
														echo '<input type="checkbox" id="ok1" name="ok1" value=null checked disabled> Operasi | <a href="'.base_url('ok/okcdaftar/pemeriksaan_ok').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="ok1" name="ok1" value="2" onclick=ok_enable()> Operasi';
													}
												}else { 
													echo '<input type="checkbox" id="ok1" name="ok1" value="2" onclick=ok_enable()> Operasi';
												}
												?>										  
											</label> 
											<!--<div class="demo-checkbox">
										<?php if($rujukan_penunjang->ok=='1') { ?>
												<input type="checkbox" id="ok1" class="filled-in" value=null checked disabled name="ok1"/>
			                                    <label class="m-b-0" for="ok1">Operasi <?php if($rujukan_penunjang->status_ok=='1') echo '| Done';?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="ok1" class="filled-in" <?php if($rujukan_penunjang->status_ok=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="ok1" />
	                                    		<label class="m-b-0" for="ok1">Operasi <?php if($rujukan_penunjang->status_ok=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>-->
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="pa_refresh">
											<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->pa=='1'){
													if($rujukan_penunjang->status_pa=='0'){
														echo '<input type="checkbox" id="pa1" name="pa1" value=null unchecked disabled> Patologi Anatomi<br>belum selesai.';
													} else if($rujukan_penunjang->status_pa=='1'){
														echo '<input type="checkbox" id="pa1" name="pa1" value=null checked disabled> Patologi Anatomi | <a href="'.base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="pa1" name="pa1" value="2" onclick=pa_enable()> Patologi Anatomi';
													}
												}else { 
													echo '<input type="checkbox" id="pa1" name="pa1" value="2" onclick=pa_enable()> Patologi Anatomi';
												}
												?>										  
											</label>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="lab_refresh">
											<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->lab=='1'){
													if($rujukan_penunjang->status_lab=='0'){
														echo '<input type="checkbox" id="lab1" name="lab1" value=null unchecked disabled> Laboratorium<br>belum selesai.';
													} else if($rujukan_penunjang->status_lab=='1'){
														echo '<input type="checkbox" id="lab1" name="lab1" value=null checked disabled> Laboratorium | <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="lab1" name="lab1" value="2" onclick=lab_enable()> Laboratorium';
													}
												}else { 
													echo '<input type="checkbox" id="lab1" name="lab1" value="2" onclick=lab_enable()> Laboratorium';
												}
												?>										  
											</label>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="rad_refresh">
											<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->rad=='1'){
													if($rujukan_penunjang->status_rad=='0'){
														echo '<input type="checkbox" id="rad2" name="rad2" value=null unchecked disabled> Radiologi<br>belum selesai.';
													} else if($rujukan_penunjang->status_rad=='1'){
														echo '<input type="checkbox" id="rad2" name="rad2" value=null checked disabled> Radiologi | <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="rad2" name="rad2" value="2" onclick=rad_enable()> Radiologi';
													}
												}else { 
													echo '<input type="checkbox" id="rad2" name="rad2" value="2" onclick=rad_enable()> Radiologi';
												}
												?>										  
											</label>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="emr_refresh">
											<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->em=='1'){
													if($rujukan_penunjang->status_em=='0'){
														echo '<input type="checkbox" id="em2" name="em2" value=null unchecked disabled> Elektromedik<br>belum selesai.';
													} else if($rujukan_penunjang->status_em=='1'){
														echo '<input type="checkbox" id="em2" name="em2" value=null checked disabled> Elektromedik | <a href="'.base_url('em/emcdaftar/pemeriksaan_em').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="em2" name="em2" value="2" onclick=em_enable()> Elektromedik';
													}
												}else { 
													echo '<input type="checkbox" id="em2" name="em2" value="2" onclick=em_enable()> Elektromedik';
												}
												?>										  
											</label>
										</div>
									</div>
								</div>
							</div>
							<?php //end = tampilkan jika poli penyakit dalam
								// }
							?>
							<div class="form-group row" id="div_tgl_rujuk">
									<p class="col-sm-4 form-control-label" >Tanggal Rujuk</p>
									<div class="col-sm-8">
										<input type="date" class="form-control" name="tgl_rujuk"></input>
									</div>
							</div>
							<div class="form-group row" id="div_alasan">
									<p class="col-sm-4 form-control-label" >Alasan Rujuk</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="alasan_rujukan" id="note_pulang" cols="25" rows="3" style="resize:vertical" ><?= $data_pasien_daftar_ulang->alasan_berobat ?></textarea>
									</div>
							</div>
							<div class="form-group row" id="div_rawat_di">
									<p class="col-sm-4 form-control-label" >Dirawat Di : </p>
									<div class="col-sm-8">
									<input type="text" class="form-control" name="saran_rawat" cols="25" rows="3"></input>
									</div>
							</div>
							


							
							<?php if($statfisik != 'show'){ ?>  
							<div class="form-group row" id="div_cetak_prmrj">
								<input class="col-sm-4 form-control-label" type="checkbox" name="cetak_prmrj" id="cetak_prmrj">
								<label for="cetak_prmrj">Cetak PRMRJ</label>
							</div>
							<?php } ?>
								<input type="hidden" name="no_medrec" value="<?php echo $no_medrec ?>">
								<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<div class="form-group row">
									<div class="offset-sm-4 col-sm-8">
                                                        <button type="submit" class="btn btn-primary" id="btn-simpan-pulang">Simpan</button>
                                                        <button type="reset" class="btn btn-warning">Reset</button>
														<!-- <button type="button" onclick="cetak_resume()" class="btn btn-primary">Cetak</button> -->
                                                    </div>
								</div>
						<?php echo form_close();?>
					<!-- </form> -->
                    </div> <!-- card block -->
                </div>