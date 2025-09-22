<script type="text/javascript">
	function surat_tindakan()
	{	
			$("#MyModalSurat").modal('show');

	}
	function surat_tindakan_jiwa()
	{	
			$("#MyModalSuratJiwa").modal('show');

	}

	function insert(){
    console.log($('#MyModalSurat').serialize());
    var noreg = "<?php echo $no_register; ?>";
    var amphe = $('#amphetamin').val();
    var opiat = $('#opiat').val();
    var thc = $('#thc').val();
    var ket = $('#keterangan').val();
    var hasil = $('#hasil').val();
    var nosur = $('#nosur').val();
    var bulan = $('#bulan').val();
    
    //document.cookie = "no_register='"+noreg+"'"; 
    //document.cookie = "a='a'"; 
    //document.cookie = "id_loket='.$data9['id_loket'].'"; document.cookie = "no_kwitansi='.$data9['no_kwitansi'].'";'.$txtpilih.' 
    //window.open("<?php //echo site_url("irj/rjcpelayanan/cetak_surat_keterangan")?>", "_blank");
   // 	window.focus();
    document.getElementById("submit_add").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'irj/rjcpelayanan/cetak_surat_keterangan_st/';?>",
       // dataType: "JSON",
        data:{no_register:noreg, opiat:opiat, amphe:amphe, thc:thc, ket:ket, hasil:hasil, nosur:nosur, bulan:bulan},
        success: function(data){
        	window.open("<?php echo site_url("irj/rjcpelayanan/cetak_surat_keterangan")?>","_blank");window.focus();
        	$("#MyModalSurat").modal('hide');
        },
       error:function(event, textStatus, errorThrown) {
              // document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              // document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

function insert2(){
    console.log($('#MyModalSuratJiwa').serialize());
    var noreg = "<?php echo $no_register; ?>";
   
    var ket = $('#keterangan2').val();
    var hasil = $('#hasil2').val();
    var nosur = $('#nosur2').val();
    var bulan = $('#bulan2').val();
    
    //document.cookie = "no_register='"+noreg+"'"; 
    //document.cookie = "a='a'"; 
    //document.cookie = "id_loket='.$data9['id_loket'].'"; document.cookie = "no_kwitansi='.$data9['no_kwitansi'].'";'.$txtpilih.' 
    //window.open("<?php //echo site_url("irj/rjcpelayanan/cetak_surat_keterangan")?>", "_blank");
   // 	window.focus();
    document.getElementById("submit_add2").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'irj/rjcpelayanan/cetak_surat_keterangan_st_jiwa/';?>",
       // dataType: "JSON",
        data:{no_register:noreg, ket2:ket, hasil2:hasil, nosur2:nosur, bulan2:bulan},
        success: function(data){
        	window.open("<?php echo site_url("irj/rjcpelayanan/cetak_surat_keterangan_jiwa")?>","_blank");window.focus();
        	$("#MyModalSuratJiwa").modal('hide');
        },
       error:function(event, textStatus, errorThrown) {
              // document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              // document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

</script>

										<form class="form" id="form_add_tindakan">
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="tindakan">Tindakan *</p>
											<div class="col-sm-10">
													<!--
													<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
													<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
													-->
														<select id="prop" class="form-control select2" name="idtindakan" onchange="pilih_tindakan(this.value)" style="width:100%;" required>
															<option value="">-Pilih Tindakan-</option>
															<?php 
															foreach($tindakan as $row){
																echo '<option value="'.$row->idtindakan.'@'.$row->nmtindakan.'">'.$row->nmtindakan.' | Rp. '.number_format($row->total_tarif, 2 , ',' , '.' ).'</option>';
															}
															?>
														</select>
											</div>
										</div> <!-- end form group row -->

										<div class="form-group row" id="dokterDiv">
											<p class="col-sm-2 form-control-label" id="label_dokter">Pelaksana *</p>
											<div class="col-sm-10">
													
													<select id="id_dokter" class="form-control select2" name="id_dokter" style="width:100%;" required>
														<option value="">-Pilih Pelaksana-</option>
														<?php 
														foreach($dokter_tindakan as $row){
															echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';
														}
														
														?>
													</select>
											</div>
										</div> <!-- end form group row -->
										
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Biaya Tindakan</p>
											<div class="col-sm-3">
												<div class="input-group">
													<span class="input-group-addon">Rp</span>
													<input type="text" class="form-control" name="biaya_tindakan" id="biaya_tindakan" disabled>
													<input type="hidden" class="form-control" name="biaya_tindakan_hide" id="biaya_tindakan_hide">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Biaya Alkes</p>
											<div class="col-sm-3">
												<div class="input-group">
													<span class="input-group-addon">Rp</span>
													<input type="text" class="form-control" name="biaya_alkes" id="biaya_alkes" disabled>
													<input type="hidden" class="form-control" name="biaya_alkes_hide" id="biaya_alkes_hide">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qtyind *</p>
											<div class="col-sm-2">
												<input type="number" class="form-control" name="qtyind" id="qtyind" min=1 onchange="set_total(this.value)" required>
											</div>
										</div>
										<!--<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_dijamin">Dijamin</p>
											<div class="col-sm-10">
												<input type="text" class="form-control" value="" name="dijamin">
											</div>
										</div>
										-->
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
											<div class="col-sm-3">
												<div class="input-group">
													<span class="input-group-addon">Rp</span>
													<input type="text" class="form-control" name="vtot" id="vtot" disabled>
													<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
												</div>
											</div>
										</div>										
											<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="id_poli">
											<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
											<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">	
										<div class="form-group row">
												<div class="offset-sm-2 col-sm-6">
	                                               	<button type="reset" class="btn btn-warning">Reset</button>
	                                              	<button type="submit" class="btn btn-primary" id="btn-tindakan">Simpan</button>
	                                            </div>
										</div>		
									</form>
									
									<!-- table -->
									<br>
									<div class="table-responsive m-t-0">
										<table id="tabel_tindakan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
											<thead>
												<tr>
													<th>No</th>
													<th>Tindakan</th>
													<th>Dokter</th>
													<th>Biaya Tindakan</th>
													<th>Qtyind</th>
													<th>Biaya Alkes</th>
													<th>Total</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>			
											</tbody>
										</table>
											</div>
									<div class="pull-right">
									<?php if($unpaid!=''){?>
									<a href="<?php echo site_url('irj/rjcregistrasi/cetak_faktur_kt/'.$no_register); ?>" target="_blank" class="btn btn-danger">Cetak</a>
									<?php } else {?>
									<a href="javascript:void(0)" class="btn btn-danger" disabled>Cetak</a>
									<?php }?>
									</div>
								
						<!-- 
									 <?php 
									 // echo form_open('master/mcdiagnosa/insert_diagnosa');
									 ?>  -->

 						<div class="modal" id="MyModalSurat" tabindex="-1" role="dialog" aria-labelledby="MyModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Data Surat Keterangan </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                             <div id="alert-modal-edit"></div>  
                                                <form class="form-horizontal" id="form_add">  
                                                
                                                <div class="form-group row">
                                                  <label for="nama" class="col-2 col-form-label">Nama</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->nama;?>">
                                                  </div>
                                                </div>  

                                                <div class="form-group row">
                                                  <label for="tgllhr" class="col-2 col-form-label">Tanggal Lahir</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" disabled="true" value="<?php echo $data_pasien_daftar_ulang->tgl_lahir;?>">
                                                  </div>
                                                </div> 

                                                <div class="form-group row">
                                                  <label for="almt" class="col-2 col-form-label">Alamat</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="alamat" name="alamat" disabled="true" value="<?php echo $data_pasien_daftar_ulang->alamat;?>">
                                                  </div>
                                                </div>  
                                                
                                                <div class="form-group row">
                                                  <label for="thcc" class="col-2 col-form-label">THC</label>
                                                  <div class="col-10">
                                                     <select id="thc" class="form-control" name="thc" required>
														<option value="negatif">Negatif</option>
														<option value="positif">Positif</option>
													</select>
                                                  </div>
                                                </div>  
                                                
                                                <div class="form-group row">
                                                  <label for="add_nmtindakan" class="col-2 col-form-label">Opiat</label>
                                                  <div class="col-10">
                                                     <select id="opiat" class="form-control" name="opiat" required>
														<option value="negatif">Negatif</option>
														<option value="positif">Positif</option>
													</select>
                                                  </div>
                                                </div> 

                                                <div class="form-group row">
                                                  <label for="amph" class="col-2 col-form-label">Amphetamin</label>
                                                  <div class="col-10">
                                                     <select id="amphetamin" class="form-control" name="amphetamin" required>
														<option value="negatif">Negatif</option>
														<option value="positif">Positif</option>
													</select>
                                                  </div>
                                                </div>      
                                                <div class="form-group row">
                                                  <label for="thcc" class="col-2 col-form-label">Hasil</label>
                                                  <div class="col-10">
                                                    <select id="hasil" class="form-control" name="hasil" required>
														<option value="negatif">Negatif</option>
														<option value="positif">Positif</option>
													</select>
                                                  </div>
                                                </div>
                                                <div class="form-group row">
                                                  <label for="almt" class="col-2 col-form-label">Bulan</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="bulan" name="bulan">
                                                  </div>
                                                </div>
                                                <div class="form-group row">
                                                  <label for="almt" class="col-2 col-form-label">No. Surat</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="nosur" name="nosur">
                                                  </div>
                                                </div>  

                                                <div class="form-group row">
                                                  <label for="ket" class="col-3 col-form-label">Keterangan</label>
                                                  <div class="col-12">
                                                    <textarea class="form-control" id="keterangan" name="keterangan" required> </textarea>
                                                  </div>
                                                </div>           
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>  
                                                <button type="button" class="btn btn-primary" id="submit_add" onclick="insert()"><i class="fa fa-floppy-o"></i>Cetak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->

                <div class="modal" id="MyModalSuratJiwa" tabindex="-1" role="dialog" aria-labelledby="MyModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Data Surat Keterangan </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                             <div id="alert-modal-edit"></div>  
                                                <form class="form-horizontal" id="form_add">  
                                                
                                                <div class="form-group row">
                                                  <label for="nama" class="col-2 col-form-label">Nama</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->nama;?>">
                                                  </div>
                                                </div>  

                                                <div class="form-group row">
                                                  <label for="tgllhr" class="col-2 col-form-label">Tanggal Lahir</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" disabled="true" value="<?php echo $data_pasien_daftar_ulang->tgl_lahir;?>">
                                                  </div>
                                                </div> 

                                                <div class="form-group row">
                                                  <label for="almt" class="col-2 col-form-label">Alamat</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="alamat" name="alamat" disabled="true" value="<?php echo $data_pasien_daftar_ulang->alamat;?>">
                                                  </div>
                                                </div>  
                                               <div class="form-group row">
                                                  <label for="hasil" class="col-2 col-form-label">Hasil</label>
                                                  <div class="col-10">
                                                    <select id="hasil2" class="form-control" name="hasil" required>
														<option value="tidak">Tidak ada</option>
														<option value="ada">ada</option>
													</select>
                                                  </div>
                                                </div>
                                                <div class="form-group row">
                                                  <label for="bulan" class="col-2 col-form-label">Bulan</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="bulan2" name="bulan">
                                                  </div>
                                                </div>
                                                <div class="form-group row">
                                                  <label for="nosur" class="col-2 col-form-label">No. Surat</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="nosur2" name="nosur">
                                                  </div>
                                                </div>  

                                                <div class="form-group row">
                                                  <label for="ket" class="col-3 col-form-label">Keterangan</label>
                                                  <div class="col-12">
                                                    <textarea class="form-control" id="keterangan2" name="keterangan" required> </textarea>
                                                  </div>
                                                </div>           
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="submit_add2" onclick="insert2()"><i class="fa fa-floppy-o"></i>Cetak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->