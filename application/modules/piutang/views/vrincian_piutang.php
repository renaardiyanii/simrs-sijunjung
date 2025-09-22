<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 

<script type='text/javascript'>
	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
	});
</script>

	<div class="container-fluid">
		<section class="content">
			<div class="row">
			
                <?php echo validation_errors(); ?>
                <div class="col-md-12">
                    <div class="card card-outline-info">
                        <div class="card-header text-white" align="center">Rekap Biaya Angsuran</div>
                            <div class="card-block">
                                <br/>
                                <div style="display:block;overflow:auto;">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>No RM</th>
                                                <td>:</td>
                                                <td><?php echo $pasien_piutang_item->medrec;?></td>
                                                <th>Tanggal Piutang</th>
                                                <td>:</td>
                                                <td><?php echo date("d-m-Y | H:i", strtotime($pasien_piutang_item->created_date)); ?></td>
                                            </tr>
                                            <tr>
                                                <th>No. Register</th>
                                                <td>:</td>
                                                <td><?php echo $pasien_piutang_item->no_register;?></td>
												<th>Nama Pasien</th>
                                                <td>:</td>
                                                <td><?php echo strtoupper($pasien_piutang_item->nama);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
											<?php 
											if($pasien_piutang_item->jns_kwitansi == 'Rawat Jalan'){ ?>
												<form action="<?php echo site_url('piutang/cpiutang/insert_angsuran_piutang'); ?>" method="post">
														<tr>
															<th style="width:20%;">Total Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" value="<?php echo $pasien_piutang_item->total_tagihan ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Sisa Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="sisa_tagihan" id="sisa_tagihan" value="<?php echo  $sisa_akhir ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Biaya Angsuran</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="biaya_angsuran" id="biaya_angsuran">
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															
															<td colspan="4">
																<div class="form-group" align="left">
																	<input type="hidden" class="form-control" name="no_register" id="no_register" value ="<?= $pasien_piutang_item->no_register ?>">
																	<input type="hidden" class="form-control" name="id_piutang" id="id_piutang" value ="<?= $pasien_piutang_item->id ?>">
																	<input type="hidden" class="form-control" name="asal" id="asal" value ="<?= $pasien_piutang_item->asal ?>">
																	<button type="reset" class="btn btn-warning btn-sm">Reset</button>&nbsp;
																	<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
																</div>
															</td>
														
														</tr>
												</form>
											<?php }else if($pasien_piutang_item->jns_kwitansi == 'Laboratorium'){ ?>
												<form action="<?php echo site_url('piutang/cpiutang/insert_angsuran_piutang_lab'); ?>" method="post">
														<tr>
															<th style="width:20%;">Total Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" value="<?php echo $pasien_piutang_item->total_tagihan ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>
														
														<tr>
															<th style="width:20%;">Sisa Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<?php 
														//  var_dump($sisa_akhir);die();
														?>
																	<input type="text" class="form-control" name="sisa_tagihan" id="sisa_tagihan" value="<?php echo  $sisa_akhir ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Biaya Angsuran</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="biaya_angsuran" id="biaya_angsuran">
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															
															<td colspan="4">
																<div class="form-group" align="left">
																	<input type="hidden" class="form-control" name="no_register" id="no_register" value ="<?= $pasien_piutang_item->no_register ?>">
																	<input type="hidden" class="form-control" name="id_piutang" id="id_piutang" value ="<?= $pasien_piutang_item->id ?>">
																	<input type="hidden" class="form-control" name="asal" id="asal" value ="<?= $pasien_piutang_item->asal ?>">
																	<input type="hidden" class="form-control" name="no_lab" id="no_lab" value ="<?= $pasien_piutang_item->no_lab ?>">
																	<button type="reset" class="btn btn-warning btn-sm">Reset</button>&nbsp;
																	<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
																</div>
															</td>
														
														</tr>
												</form>
											<?php }else if($pasien_piutang_item->jns_kwitansi == 'Radiologi'){ ?>
												<form action="<?php echo site_url('piutang/cpiutang/insert_angsuran_piutang_rad'); ?>" method="post">
														<tr>
															<th style="width:20%;">Total Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" value="<?php echo $pasien_piutang_item->total_tagihan ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>
														
														<tr>
															<th style="width:20%;">Sisa Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<?php 
														//  var_dump($sisa_akhir);die();
														?>
																	<input type="text" class="form-control" name="sisa_tagihan" id="sisa_tagihan" value="<?php echo  $sisa_akhir ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Biaya Angsuran</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="biaya_angsuran" id="biaya_angsuran">
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															
															<td colspan="4">
																<div class="form-group" align="left">
																	<input type="hidden" class="form-control" name="no_register" id="no_register" value ="<?= $pasien_piutang_item->no_register ?>">
																	<input type="hidden" class="form-control" name="id_piutang" id="id_piutang" value ="<?= $pasien_piutang_item->id ?>">
																	<input type="hidden" class="form-control" name="asal" id="asal" value ="<?= $pasien_piutang_item->asal ?>">
																	<input type="hidden" class="form-control" name="no_rad" id="no_rad" value ="<?= $pasien_piutang_item->no_rad ?>">
																	<button type="reset" class="btn btn-warning btn-sm">Reset</button>&nbsp;
																	<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
																</div>
															</td>
														
														</tr>
												</form>
											<?php }else if($pasien_piutang_item->jns_kwitansi == 'Elektromedik'){ ?>
												<form action="<?php echo site_url('piutang/cpiutang/insert_angsuran_piutang_em'); ?>" method="post">
														<tr>
															<th style="width:20%;">Total Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" value="<?php echo $pasien_piutang_item->total_tagihan ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>
														
														<tr>
															<th style="width:20%;">Sisa Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<?php 
														//  var_dump($sisa_akhir);die();
														?>
																	<input type="text" class="form-control" name="sisa_tagihan" id="sisa_tagihan" value="<?php echo  $sisa_akhir ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Biaya Angsuran</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="biaya_angsuran" id="biaya_angsuran">
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															
															<td colspan="4">
																<div class="form-group" align="left">
																	<input type="hidden" class="form-control" name="no_register" id="no_register" value ="<?= $pasien_piutang_item->no_register ?>">
																	<input type="hidden" class="form-control" name="id_piutang" id="id_piutang" value ="<?= $pasien_piutang_item->id ?>">
																	<input type="hidden" class="form-control" name="asal" id="asal" value ="<?= $pasien_piutang_item->asal ?>">
																	<input type="hidden" class="form-control" name="no_em" id="no_em" value ="<?= $pasien_piutang_item->no_em ?>">
																	<button type="reset" class="btn btn-warning btn-sm">Reset</button>&nbsp;
																	<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
																</div>
															</td>
														
														</tr>
												</form>
											<?php }else if($pasien_piutang_item->jns_kwitansi == 'Rawat Inap'){?>
												<form action="<?php echo site_url('piutang/cpiutang/insert_angsuran_piutang_ranap'); ?>" method="post">
														<tr>
															<th style="width:20%;">Total Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" value="<?php echo $pasien_piutang_item->total_tagihan ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Sisa Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="sisa_tagihan" id="sisa_tagihan" value="<?php echo  $sisa_akhir ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Biaya Angsuran</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="biaya_angsuran" id="biaya_angsuran">
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															
															<td colspan="4">
																<div class="form-group" align="left">
																	<input type="hidden" class="form-control" name="no_register" id="no_register" value ="<?= $pasien_piutang_item->no_register ?>">
																	<input type="hidden" class="form-control" name="id_piutang" id="id_piutang" value ="<?= $pasien_piutang_item->id ?>">
																	<input type="hidden" class="form-control" name="asal" id="asal" value ="<?= $pasien_piutang_item->asal ?>">
																	<button type="reset" class="btn btn-warning btn-sm">Reset</button>&nbsp;
																	<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
																</div>
															</td>
														
														</tr>
												</form>
											<?php }else if($pasien_piutang_item->jns_kwitansi == 'Rawat Jalan (Sebelum Poli)'){?>
												<form action="<?php echo site_url('piutang/cpiutang/insert_angsuran_piutang_sblm_poli'); ?>" method="post">
														<tr>
															<th style="width:20%;">Total Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" value="<?php echo $pasien_piutang_item->total_tagihan ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Sisa Tagihan</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="sisa_tagihan" id="sisa_tagihan" value="<?php echo  $sisa_akhir ?>" readonly>
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															<th style="width:20%;">Biaya Angsuran</th>
															<td>:</td>
															<td style="width:40%;">
																<div class="input-group">
																	<span class="input-group-addon">Rp</span>
																	<input type="text" class="form-control" name="biaya_angsuran" id="biaya_angsuran">
																</div>
															</td>
															<td style="width:40%;"></td>
														</tr>

														<tr>
															
															<td colspan="4">
																<div class="form-group" align="left">
																	<input type="hidden" class="form-control" name="no_register" id="no_register" value ="<?= $pasien_piutang_item->no_register ?>">
																	<input type="hidden" class="form-control" name="id_piutang" id="id_piutang" value ="<?= $pasien_piutang_item->id ?>">
																	<input type="hidden" class="form-control" name="asal" id="asal" value ="<?= $pasien_piutang_item->asal ?>">
																	<button type="reset" class="btn btn-warning btn-sm">Reset</button>&nbsp;
																	<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
																</div>
															</td>
														
														</tr>
												</form>
											<?php }
											?>
											
										</thead>
                                       
                                    </table>
                                    <h4>Rincian Angsuran</h4>
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Sisa Awal</th>
                                            <th>Biaya Angsuran</th>
                                            <th>Sisa Akhir</th>
											<th>Aksi</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i=1;
                                            foreach($cicilan_piutang_item as $row){
                                            ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row->created_date;?></td>
                                                <td><?php echo $row->sisa_angsuran;?></td>
                                                <td><?php echo $row->biaya_angsuran;?></td>
                                                <td><?php echo $row->sisa_akhir;?></td>
												<td>
													<?php 
														if($pasien_piutang_item->jns_kwitansi == 'Rawat Inap'){ ?>
															<a href="<?php echo site_url('piutang/cpiutang/cetak_faktur_kt_piutang_ranap/'.$row->id.'/'.$row->id_piutang.'/'.$row->no_register); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i>Cetak</a>
														<?php }else{ ?>
															<a href="<?php echo site_url('irj/rjckwitansi/cetak_faktur_kt_piutang/'.$row->id.'/'.$row->id_piutang.'/'.$row->no_register); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i>Cetak</a>
														<?php }
													?>
												
												</td>
                                        
                                           </tr>
                                    <?php
                                        }
                                    ?>
                                        </tbody>


                                    </table>
									<?php echo form_open('piutang/cpiutang/verifikasi_lunas'); ?>
										<input type="hidden" name="no_register" id="no_register" value="<?= $pasien_piutang_item->no_register ?>">
										<input type="hidden" name="id_piutang" id="id_piutang" value="<?= $pasien_piutang_item->id ?>">
										<input type="hidden" name="jns_kwitansi" id="jns_kwitansi" value="<?= $pasien_piutang_item->jns_kwitansi ?>">
										<input type="hidden" name="no_lab" id="no_lab" value="<?= isset($pasien_piutang_item->no_lab)?$pasien_piutang_item->no_lab:null ?>">
										<input type="hidden" name="no_rad" id="no_rad" value="<?= isset($pasien_piutang_item->no_rad)?$pasien_piutang_item->no_rad:null ?>">
										<input type="hidden" name="no_em" id="no_em" value="<?= isset($pasien_piutang_item->no_em)?$pasien_piutang_item->no_em:null ?>">
										<button class="btn btn-primary" type="submit">Lunas</button>
									<?php echo form_close(); ?>
                                </div>
            
                        </div>
                </div>
                </div>
            </div>
		</section>
	</div>



<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
