<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else { 
            $this->load->view("layout/header_horizontal");
        }
?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function() {
		

	$(".js-example-placeholder-single").select2({
	    placeholder: "Pilih Pangkat / Gol",
	    allowClear: true
	});

	$("#pemeriksaan").select2({
	    placeholder: "Pilih Jenis Pemeriksaan",
	    allowClear: true
	}).on('select2:open',function(){
            $('.select2-dropdown--above').attr('id','fix');
            $('#fix').removeClass('select2-dropdown--above');
            $('#fix').addClass('select2-dropdown--below');

        });
	$("#kesatuan").select2({
	    placeholder: "Pilih Kesatuan",
	    allowClear: true
	});

	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

	$('#date_picker1').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	}); 
	$('#date_picker2').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	}); 
	$('.auto_search_by_nonrp').autocomplete({
		serviceUrl: '<?php echo site_url();?>/urikes/curiautocomplete/data_pasien_by_nonrp',
		onSelect: function (suggestion) {
			$('#cari_no_nrp').val(''+suggestion.nrp);
		}
	});
	$('.auto_search_by_nama').autocomplete({
		serviceUrl: '<?php echo site_url();?>/urikes/curiautocomplete/data_pasien_by_nama'
		/*onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
		*/
	});
	$('.auto_search_by_no_urikes').autocomplete({
		serviceUrl: '<?php echo site_url();?>/urikes/curiautocomplete/data_pasien_by_no_urikes',
		onSelect: function (suggestion) {
			$('#cari_no_urikes').val(''+suggestion.no_urikes);
		}
	});

	$('#input_hasil').hide();
	$('#hsil13').change(function() {
	 // alert($(this).prop('checked'))
	  if($(this).prop('checked')==false){
	  	$('#input_hasil').hide();
	  }else{
	  	$('#input_hasil').show();
	  }
	});
	$('#input_hasil').hide();
	$('#hsil14').change(function() {
	 // alert($(this).prop('checked'))
	  if($(this).prop('checked')==false){
	  	$('#input_hasil').hide();
	  }else{
	  	$('#input_hasil').show();
	  }
	});

	document.getElementById("kel").required = true;
	$('#hidden').show();
	$('#data_anggota').hide();
	$('#data_skd').hide();
	$('#data_alamat').hide();
	$('#chk1').change(function() {
	  if($(this).prop('checked')==false){
	  	$('#data_anggota').hide();
	  	}else{
	  	$('#data_anggota').show();	  }
	});

	$('#tbl-pasien').DataTable({
  		"language": {
     	"emptyTable": "Data tidak tersedia."
    	}
	});
	

});	

function cek_search_per(val_search_per){
	
	if(val_search_per=='nama'){
		$("#cari_nama").css("display", ""); 
		$("#cari_no_urikes").css("display", "none");
		$("#cari_no_nrp").css("display", "none");
	} 
	else if(val_search_per=='no_urikes'){		
		$("#cari_no_urikes").css("display", "");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none");
	}
	else if(val_search_per=='nrp'){
		$("#cari_no_urikes").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display","");
	}
}

function cek_kelompok(val_kelompok){
	
	if(val_kelompok=='M'){
		$('#data_anggota').show();
		$('#data_alamat').hide();
		$('#data_skd').hide();
		document.getElementById("pangkat").required = true;
		document.getElementById("kesatuan").required = true;
		document.getElementById("pangkat").required = false;
	} 
	else if(val_kelompok=='X'){		
		$('#data_anggota').hide();
		$('#data_alamat').hide();
		$('#data_skd').hide();
		document.getElementById("pangkat").required = false;
		document.getElementById("kesatuan").required = false;
		document.getElementById("pangkat").required = false;
	}
	else if(val_kelompok=='Z'){
		$('#data_alamat').show();
		$('#data_anggota').hide();
		$('#data_skd').show();
		document.getElementById("alamat").required = true;
		document.getElementById("pangkat").required = false;
		document.getElementById("kesatuan").required = false;	
	}
} 

$(document).on("click",".get_datapasien",function() {
    var button = $(this);
    var idurikes = button.data('idurikes');
    button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('urikes/Curikes/get_datapasien'); ?>",
		dataType: "JSON",
		data: {"idurikes" : idurikes},
		success: function(result) { 
			button.html('<i class="fa fa-sign-in"></i> Daftar');
			console.log(result);
			
			if (result == '' || result == null) {
			// if (!$.trim(result)){
				swal("Gagal","Pasien Sudah Terdaftar", "warning");  
			} else {
				$('#nama').attr('readonly','true');
				$('#nama').val(result.nama);
				$('#tmpt_lahir').val(result.tmpt_lahir);
				$('#date_picker1').val(result.tgl_lahir);
				$('#no_nip').val(result.nip);
				$('#jenkel').val(result.jenkel);
				$("#kesatuan").val(result.kesatuan_gab).trigger('change');
				$("#pangkat_id").val(result.kdpangkat).trigger('change');
			  	
			}
		},
		error:function(event, textStatus, errorThrown) { 
			
			button.html('<i class="fa fa-sign-in"></i> Daftar');
			swal("Error",formatErrorMessage(event, errorThrown), "error");                   
			console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	  }
	});
});


function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}


</script>
	
<!-- <?php echo $this->session->flashdata('success_msg'); ?> -->

		 
  <div class="col-lg-12 col-md-12">
   <div class="card">
	   	<div class="card-block">
	   		<?php 
              		$attributes = array('class' => '');
					echo form_open('urikes/curikes/pasien', $attributes);?>
   			<div class="col-lg-7" style="margin: 0 auto;">	
				<br>
				<div class="row p-t-10 m-b-15">
                    <div class="col-md-3">
                        <div class="form-group">
                            <!-- <label class="control-label">Kategori</label> -->
                            <select name="search_per" id="search_per" class="form-control"  onchange="cek_search_per(this.value)">
								<option value="nama" selected>Nama</option>
								<option value="nrp">NIP / NRP</option>
								<option value="no_urikes">No. Urikes</option>
							</select>
                            <!-- <small class="form-control-feedback"> This is inline help </small> -->
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group has-danger">
							<!--auto_search_by_nama-->					
							<input type="search" style="width:450;" class="form-control" id="cari_nama" name="cari_nama" placeholder="Pencarian Nama">
							<!--auto_search_by_no_urikes-->					
							<input type="search" class="auto_search_by_no_urikes form-control" id="cari_no_urikes" name="cari_no_urikes" placeholder="Pencarian No Urikes" style="width:450; display:none">
							<!--auto_search_by_nonrp-->
							<input type="search" style="width:450; display:none" class="auto_search_by_nonrp form-control" id="cari_no_nrp" name="cari_no_nrp" placeholder="Pencarian No NRP">
                            <!-- <small class="form-control-feedback"> This field has error. </small> </div> -->
                        </div>
                    </div>
                        <?php $url=site_url('urikes/Curikes/regpasien_urikes'); ?>
                    <div class="col-md-3">
                        <div class="form-actions">
                        	<button type="submit" class="btn waves-effect waves-light btn-info" type="button">
                        		<i class="fa fa-search"></i> Cari Pasien
                        	</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo form_close();?>       
           	<div class="col-lg-12 col-md-12">     
                <div class="table-responsive m-t-0">
                    <table id="tbl-pasien" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
							<tr>
								<th>No. Urikes</th>
								<th>No. Kode</th>
								<th>Nama</th>
								<th>NIP/NRP</th>
								<th>Tgl Lahir</th>
								<th>Statkes</th>	
								<th class="text-center" width="7%">Aksi</th>
							</tr>
                        </thead>
						<tbody>
							<?php
							if ($data_pasien!="") {
								foreach($data_pasien as $row){
								?>
								<tr>
									<td><?php echo $row->idurikes;?></td>
									<td><?php echo $row->nomor_kode;?></td>	
									<td><?php echo strtoupper($row->nama);?></td>
									<td><?php echo $row->nip;?></td>
									<td><?php echo date('d-m-Y',strtotime($row->tgl_lahir));?></td>
									<td><?php echo $row->golongan;?></td>										
									<td width="7%">
									<button class="btn btn-danger btn-sm btn-block get_datapasien" data-idurikes="<?php echo $row->idurikes;?>"><i class="fa fa-sign-in"></i> Daftar</button>
										<!-- 
										<a href="<?php echo site_url('medrec/el_record/pasien/'.$row->no_medrec); ?>" class="btn btn-danger btn-xs" style='width:85px;'>Rekam Medik</a> -->
										<!--<a href="<?php echo site_url('medrec/Rme/histori/'.$row->no_cm); ?>" class="btn btn-danger btn-xs" target='_blank' style='width:85px;'>Rekam Medik</a>-->
									</td>
								</tr>
								<?php } 
								}
								?>
						</tbody>
                    </table>
                </div>
            </div>
            <br>
            <br>
            	<div id="div_daftar">
            		<?php echo form_open_multipart('urikes/curikes/insert_data_pasien');?>	
				<div class="card card-outline-info">
					<div class="card-header">
						<h4 class="m-b-0 text-white text-center">Data Pasien</h4>
					</div>
				</div>
					 <div class="form-group row">
					 		<div class="col-lg-11" style="margin: 0 auto;">
						<div class="col-lg-5" style="margin: 0 auto;">
							<div class="form-group row">
							<label class="col-sm-5 control-label col-form-label" >Kelompok Bagian</label>
								<div class="col-sm-6">
									<select class="form-control" onchange="cek_kelompok(this.value)" name="kel" id="kel" required>
										<option  class="form-control" value=""> -Pilih Kelompok- </option>
										<option  class="form-control" value="M"> Militer </option>
										<option  class="form-control" value="X"> Umum </option>
										<option  class="form-control" value="Z"> Surat Keterangan  </option>
										 <!-- <option  class="form-control" value="L"> Rutin Pama Kebawah </option> -->
									</select>
								</div>
							</div>
						</div>
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no">No Kode</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_kode" id="no_kode" value="" required>
								</div>
						</div> -->
						

						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="namaleng">Nama</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" id="nama" name="nama">
								</div>
								<div class="col-sm-1">
								</div>
								<label class="col-sm-1 control-label col-form-label" id="tl">Tempat Lahir</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" placeholder="" name="tmpt_lahir" id="tmpt_lahir">
								</div>
								<label class="col-sm-1 control-label col-form-label" id="tgl_lhr">Tgl Lahir</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="date_picker1" maxDate="0" name="tgl_lahir" required>
									<input type="hidden" class="form-control "   name="umur" id="umur" value="">
								</div>
						</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="jk">Jenis Kelamin</label>
								<div class="col-sm-3">
									<select class="form-control" name="jenkel" id="jenkel" required>
										<option  class="form-control" value="L"> Pria </option>
										<option  class="form-control" value="P"> Wanita</option>
									</select>
								</div>
								<div class="col-sm-1">
								</div>
								<label class="col-sm-2 control-label col-form-label" id="tgl_prks">Tanggal Pemeriksaan</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="date_picker2" maxDate="0" name="tgl_periksa" value="<?php echo date('Y-m-d')?>" required>
								</div>
						</div>
						
							
						
						<div class="form-group row" id="hidden">
							<label class="col-sm-2 control-label col-form-label" id="kes">NIP / NRP / NIK</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="no_nip" id="no_nip" >
								</div>
								<div class="col-sm-1">
								</div>
							<label class="col-sm-2 control-label col-form-label" id="dp">Paket Pemeriksaan</label>
								<div class="col-sm-4">
								<select name="pemeriksaan" id="pemeriksaan" class="js-states form-control form-control-line select2" style="width: 100%" required>
									<option value=""></option>
									<?php 
									foreach($pemeriksaan as $row){	
										echo '<option value="'.$row->id_tindakan.'">'.$row->nmtindakan.'</option>';
									}
									?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" id="kes">Keterangan Urikes</label>
								<div class="col-sm-3">
									<select name="ket_urikes" id="ket_urikes" class="js-states form-control form-control-line select2" style="width: 100%" required>
									<option value=""></option>
									<?php 
									foreach($ket_urikes as $row){	
										echo '<option value="'.$row->ket_urikes.'">'.$row->nama_ket_urikes.'</option>';
									}
									?>
									</select>
								</div>
								<div class="col-sm-1">
								</div>
								<!-- <div class="offset-sm-3 col-sm-8"> -->
									<label class="col-sm-2 control-label col-form-label" id="st">Keterangan Status Pasien</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" placeholder="anak anggota / Kenalan Karumkit " name="ket_status" required>
									</div>

						</div>		
						<div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="st">Jabatan</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" placeholder="jabatan" name="jabatan">
									</div>
							</div>
						</div>
						<div id="data_alamat">
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="st">Alamat Pasien</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" placeholder="alamat" name="alamat">
									</div>
							</div>
						</div>
						<div id="data_anggota">
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="pkt">Pangkat/Gol</label>
								<div class="col-sm-3">
									<select id="pangkat_id" name="pangkat_id" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" >
										<option value=""></option>
										<?php 
											$group = '';
											foreach($pangkat as $row){													
												if ($row->pokpangkat != $group) {
													echo '<optgroup label="'.$row->pokpangkat.'">';
												}	
												echo '<option value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';				
												$group = $row->pokpangkat;
												if ($row->pokpangkat != $group) {
													echo '</optgroup>';
												}
											}
										?>															
									</select>
								</div>
								<div class="col-sm-1">
								</div>
								<label class="col-sm-2 control-label col-form-label">Kesatuan</label>
									<div class="col-sm-4">
										<select name="kesatuan" id="kesatuan" class="js-example-placeholder-single js-states form-control  form-control-line select2" style="width: 100%" >
											<option value="">- Pilih Kesatuan -</option>
											<?php 										
												foreach ($kesatuan as $item) {		
													if ($item->kst2_id == '' && $item->kst3_id == '') {
														echo '<option value="'.$item->kst_id . '">'.$item->kst_nama.'</option>';
													} else if ($item->kst3_id == '') {
														echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '">'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
													} else {
														echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'">'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
													}													
												}
											?>														
										</select>
									</div>	
							</div>
						</div>
						<div id="data_skd">
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Berat Badan</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="berat_badan" value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_beratbadan;?>">
									</div>
									<label class="col-sm-1 control-label col-form-label" >Kg</label>	
								<label class="col-sm-2 control-label col-form-label" id="tb">Tinggi Badan</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="pu_tinggibadan" value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_tinggibadan;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" id="bb">Cm</label>
								<label class="col-sm-2 control-label col-form-label" id="td">Tekanan Darah</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="tekanan_darah" value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_tekanandarah;?>">
									</div>
								<label class="col-sm-1 control-label col-form-label" id="mmhg">mmHg</label>
							</div>
						</div>

							<div class="col-lg-3" style="margin: 0 auto;">
								<div class="form-group row">
									<div class="col-lg-6">
							        	<input type="checkbox" class="filled-in" value="ya" name="purn" id="purn"/>
		                                <label for="purn">Purnawirawan</label>
		                           	</div>
		                      		<div class="col-lg-6">
										<input type="checkbox" class="filled-in" name="penyelam" id="penyelam" value="ya"/>
	                                    <label for="penyelam">Penyelam</label>
									</div>
								</div>
							</div>
							
						
												
						<hr>

               			</div>
               		</div>
               			
               		
			
			<!-- end tab content -->
		
							<div class="form-actions">
								<?php echo form_open_multipart('urikes/curikes/insert_data_pasien');?>	
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                               <button type="reset" class="btn waves-effect waves-light btn-danger">Reset</button>
												<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
												<button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit">Simpan</button>
												<a href=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
             				 </div> <br> <br>

				
			<?php echo form_close();?>

		</div>
	</div>
	</div>
</div>
<hr>

	<!-- Card -->		
	<!-- sample modal content -->
      	
      	<!-- /.modal -->		
	
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 