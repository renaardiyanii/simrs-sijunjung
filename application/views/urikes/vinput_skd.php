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
	$("#select_ktp").hide();
	$(".select2").select2();
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();
	$(".js-example-placeholder-single").select2({
	    placeholder: "Pilih Pangkat / Gol",
	    allowClear: true
	});

	// $("#pemeriksaan").select2({
	//     placeholder: "Pilih Jenis Pemeriksaan",
	//     allowClear: true
	// }).on('select2:open',function(){
 //            $('.select2-dropdown--above').attr('id','fix');
 //            $('#fix').removeClass('select2-dropdown--above');
 //            $('#fix').addClass('select2-dropdown--below');

 //        });

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
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nonrp',
		onSelect: function (suggestion) {
			$('#no_nrp').val(''+suggestion.no_nrp);
			$('#hidden_no_nrp').val(''+suggestion.no_nrp);
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

	$('#hidden').show();
	$('#data_anggota').hide();
	$('#chk1').change(function() {
	  if($(this).prop('checked')==false){
	  	$('#data_anggota').hide();
	  	}else{
	  	$('#data_anggota').show();	  }
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
	
<?php echo $this->session->flashdata('success_msg'); ?>

   
   <div class="card">
	   	<div class="card-block p-b-0">
			<ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#biodata_pasien" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">BIODATA PASIEN</span></a> </li>
                              
                                         </ul>	
                            	<?php echo form_open_multipart('urikes/curikes/insert_data_pasien_skd');?>	   						 
   								<div class="tab-content">
				<div id="biodata_pasien" class="tab-pane active" role="tabpanel">
					<div class="col-lg-10" style="margin: 0 auto;">	
						<br>
						<br>
						<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no">No Kode</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_kode" id="no_kode" value="" required>
								</div>
						</div> -->
						<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="nosur">Nomor Surat</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="nosur" name="nosur">
								</div>
						</div> -->

						<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="namaleng">Nama Lengkap</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="nama" name="nama">
								</div>
						</div>
						

						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="tl">Tempat Lahir</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="tmpt_lahir">
									</div>
								</div>

						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="tgl_lhr">Tanggal Lahir</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="date_picker1" maxDate="0" id="tgl_lahir" name="tgl_lahir" required>
									
									<input type="hidden" class="form-control "   name="umur" id="umur" value="">
									
								</div>
						</div>

						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="alamat">Alamat</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="alamat">
									</div>
								</div>

						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="tgl_prks">Tanggal Pemeriksaan</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="date_picker2" maxDate="0" name="tgl_periksa" required>
								</div>
						</div>
						
						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="dp">Paket Pemeriksaan</label>
									<div class="col-sm-8">
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
						
						<!-- <div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" ></label>
									<div class="col-sm-8">
									<select name="pemeriksaan" id="pemeriksaan" class="js-states form-control form-control-line select2" style="width: 100%" required>
										<option value=""></option>
										<?php 
										foreach($pemeriksaan as $row){	
											echo '<option value="'.$row->id_tindakan.'">'.$row->nmtindakan.'</option>';
										}
										?>
										</select>
									</div>
						</div> -->
						<!-- <div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="st">Keterangan sehat </label>
									<div class="col-sm-8">
										<select class="form-control" name="ket_sehat" id="ket_sehat" >
										<option  class="form-control" value="0">Sehat</option>
										<option  class="form-control" value="1">Tidak Sehat</option>
									</select>
									</div>
								</div>

						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="st">THC</label>
								<div class="col-sm-8">
									<select class="form-control" name="thc" id="thc" >
										<option  class="form-control" value="0">Positif</option>
										<option  class="form-control" value="1">Negatif</option>
									</select>
								</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="st">OPIAT</label>
								<div class="col-sm-8">	
									<select class="form-control" name="opiat" id="opiat" >
										<option  class="form-control" value="0">Positif</option>
										<option  class="form-control" value="1">Negatif</option>
									</select>
								</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="st">Amphetamin</label>
								<div class="col-sm-8">
									<select class="form-control" name="amphetamin" id="amphetamin" >
										<option  class="form-control" value="0">Positif</option>
										<option  class="form-control" value="1">Negatif</option>
									</select>
								</div>
						</div> -->

						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="st">Keterangan pemeriksaan untuk</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="ket_status" required>
									</div>
								</div>

						<!-- <div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="dkt_prks">Dokter Pemeriksa</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="dokter_pemeriksa" name="dokter_pemeriksa" value="<?php echo $urikkes_pasien->dokter_pemeriksa;?>">
							</div>
						</div>
						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="pn">Pangkat dan NRP Dokter</label>
									<div class="col-sm-8">
										<input type="text" class="form-control"  name="pangkat_nrp" id="pangkat_nrp" value="<?php echo $urikkes_pasien->pangkat_nrp;?>">
									</div>
						</div> -->
						<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Berat Badan</label>
							<div class="col-sm-1">
									<input type="text" class="form-control" placeholder="" name="berat_badan" value="<?php echo $urikkes_pasien->beratbadan;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" >Kg</label>	
							<label class="col-sm-2 control-label col-form-label" id="tb">Tinggi Badan</label>
							<div class="col-sm-1">
									<input type="text" class="form-control" placeholder="" name="t_badan" value="<?php echo $urikkes_pasien->tinggi_badan;?>">
							</div>
							<label class="col-sm-1 control-label col-form-label" id="bb">Cm</label>
							<label class="col-sm-2 control-label col-form-label" id="td">Tekanan Darah</label>
								<div class="col-sm-1">
									<input type="text" class="form-control" placeholder="" name="tekanan_darah" value="<?php echo $urikkes_pasien->tensi;?>">
								</div>
							<label class="col-sm-1 control-label col-form-label" id="mmhg">mmHg</label>
						</div>
						<hr>

               			</div>
               			
               		
			
			<!-- end tab content -->
			</div>
		<div class="form-actions">
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                               <button type="reset" class="btn waves-effect waves-light btn-danger">Reset</button>
												<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
												<button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit">Simpan dan Cetak</button>
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