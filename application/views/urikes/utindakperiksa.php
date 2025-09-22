<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else { 
            $this->load->view("layout/header_horizontal");
        }
?>
<script src="<?php echo site_url('asset/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function() {

	CKEDITOR.replace('kesimpulan_saran');
	CKEDITOR.replace('conclution');

	$("#select_ktp").hide();
	$(".select2").select2({
	    placeholder: "",
	    allowClear: true
	}).on('select2:open',function(){
            $('.select2-dropdown--above').attr('id','fix');
            $('#fix').removeClass('select2-dropdown--above');
            $('#fix').addClass('select2-dropdown--below');

        });

	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();
	

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

	$('#data_anggota').hide();
	$('#chk1').change(function() {
	  if($(this).prop('checked')==false){
	  	$('#data_anggota').hide();
	  	}else{
	  	$('#data_anggota').show();	  }
	});
});	

</script>
	
<?php echo $this->session->flashdata('success_msg'); ?>

   
   <div class="card">
	   	<div class="card-block p-b-0">
			<ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#biodata_pasien" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">BIODATA PASIEN</span></a> </li>
                              
                              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">HASIL PEMERIKSAAN </span></a> </li> 
           	</ul>	
                             					 
   								<div class="tab-content">
				<div id="biodata_pasien" class="tab-pane active" role="tabpanel">
					<div class="col-lg-10" style="margin: 0 auto;">	
						<br>
						<br>
							<?php echo form_open('urikes/Curikes/update_data_pasien');?>
						<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no">No Kode</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="nomor_kode" id="nomor_kode" 
									value="<?php echo $urikkes_pasien->nomor_kode;?>" readonly>
									<input type="hidden" class="form-control" name="no_kode" id="no_kode" 
									value="<?php echo $urikkes_pasien->nomor_kode;?>" >
									<input type="hidden" class="form-control" name="idurikes" id="idurikes" 
									value="<?php echo $urikkes_pasien->idurikes;?>" >

								</div>
						</div>
						<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="namaleng">Nama Lengkap*</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="nama" name="nama" 
									value="<?php echo $urikkes_pasien->nama;?>" required>
								</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-3 control-label col-form-label" id="kes">NIP / NRP</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_nip" id="no_nip"
									 value="<?php echo $urikkes_pasien->nip;?>" readonly>
								</div>
						</div>
						<div id="data_anggota">
						</div>
						<!-- <div class="form-group row">
							<div class="offset-sm-3 col-sm-8">
									<div class="demo-checkbox">	
										<input type="checkbox" class="filled-in" value="ya" name="chk1" id="chk1" 
										<?php if($urikkes_pasien->nip!='' ) echo 'checked';?>/>
	                                    <label for="chk1">Anggota TNI/PNS</label>
	                          		</div>
							</div>
						</div>

						
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="kes">NIP / NRP</label> 
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_nrp" id="no_nrp" value="<?php echo $urikkes_pasien->nrp;?>">									
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="pkt">Pangkat/Gol</label>
								<div class="col-sm-8">
									
									<select name="pangkat" id="pangkat" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" >
										<option value=""></option>
										<?php 
											$group = '';
											foreach($pangkat as $row){													
												if ($row->jenis != $group) {
													// echo '<optgroup label="'.$row->jenis.'">';
												}	
												if ($urikkes_pasien->kdpangkat == $row->pangkat_id) {
													// echo '<option value="'.$row->pangkat_id.'" selected>'.$row->pangkat.'</option>';	
												// } else echo '<option value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';				
												$group = $row->jenis;
												if ($row->jenis != $group) {
													// echo '</optgroup>';
												}
											}
										?>															
									</select> 
								</div>
							</div> 
							<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label" id="kes">Keterangan Pangkat</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" placeholder="" id="kt_pangkat" name="kt_pangkat" value="<?php echo $urikkes_pasien->kt_pangkat;?>">
										</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="kes">Kesatuan </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" id="kesatuan" name="kesatuan" value="<?php echo $urikkes_pasien->kesatuan;?>" >
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="jbt"> Jabatan</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="jabatan" id="jabatan" value="<?php echo $urikkes_pasien->jabatan;?>" >
								</div>
							</div>
						</div>					
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="tl">Tempat Lahir</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" placeholder="" name="tmpt_lahir" value="<?php echo $urikkes_pasien->tmpt_lahir;?>" >
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="tgl_lhr">Tanggal Lahir</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="date_picker1" maxDate="0" id="tgl_lahir" name="tgl_lahir" value="<?php echo $urikkes_pasien->tgl_lahir;?>" required>
								<input type="hidden" class="form-control "   name="umur" id="umur" value="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="jk">Jenis Kelamin</label>
							<div class="col-sm-8">
								<select name="jenkel" id="jenkel" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" >
										<option value=""></option>
										<?php 
												if ($urikkes_pasien->jenkel == 'L') {
													// echo '<option value="L" selected> Pria</option>';	
												} 
												// else{ echo '<option value="P" selected> Wanita </option>';				
											}
										?>															
									</select> 

							</div>
						</div> -->
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="tgl_prks">Tanggal Pemeriksaan</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="date_picker2" maxDate="0" name="tgl_periksa" value="<?php echo $urikkes_pasien->tgl_pemeriksaan;?>" >
							</div>
						</div>
						<!-- pilihan dokter-->
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="dkt_prks">Dokter Pemeriksa</label>
							<div class="col-sm-8">
								<select name="dokter_pemeriksa" id="dokter_pemeriksa" class="js-states form-control form-control-line select2" style="width: 100%" required>
									<option value="">- Pilih Dokter -</option>
									<?php 
									foreach($dok_urikes as $row){	
										if ($urikkes_pasien->dokter_pemeriksa == $row->nm_dokter) {
											echo '<option value="'.$row->nm_dokter.'" selected>'.$row->nm_dokter.'</option>';
										} else {echo '<option value="'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="pn">Pangkat dan NRP Dokter</label>
									<div class="col-sm-8">
										<input type="text" class="form-control"  name="pangkat_nrp" id="pangkat_nrp" value="<?php echo $urikkes_pasien->pangkat_nrp;?>">
									</div>
						</div>

						<?php if ($urikkes_pasien->kelompok=='MT'||$urikkes_pasien->kelompok=='M' || $urikkes_pasien->kelompok=='KH') { ?>
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="dkt_prks">Ketua Tim Evaluasi</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="dokter_ttd" name="dokter_ttd" value="<?php echo $urikkes_pasien->dokter_ttd;?>">
							</div>
						</div>
						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="pn">Pangkat dan NRP Ketua</label>
									<div class="col-sm-8">
										<input type="text" class="form-control"  name="pangkat_nrp_ttd" id="pangkat_nrp_ttd" value="<?php echo $urikkes_pasien->pangkat_nrp_ttd;?>">
									</div>
						</div>
						<?php } else { }?>
						

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
						<hr>
							<div class="row-sm-1" >
						 <label>ANAMNESA DAN PEMERIKSAAN UMUM</label>
						 <div class="col-sm-12">
									<input type="text" class="form-control" placeholder="" name="anamnesa">
								</div>
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Pemeriksaan Spesialis</th>
                                    <th><center>I</center></th>
                                    <th><center>II</center></th>
                                    <th><center>III</center></th>
                                    <th><center>IV</center></th>
                                    <th><center>Diagnosa</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                	  
                                	<?php
		                                	 $k1=''; $k2=''; $k3=''; $k4=''; $k5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$k5=$urikkes_pemeriksaan_umum->kar_keterangan;
		                        
		                                if($urikkes_pemeriksaan_umum->kardiologi1=='I   '){
		                                	 $k1= $urikkes_pemeriksaan_umum->kardio;
		                                } else if ($urikkes_pemeriksaan_umum->kardiologi1=='II  '){
		                                	 $k2= $urikkes_pemeriksaan_umum->kardio;
		                               	} else if ($urikkes_pemeriksaan_umum->kardiologi1=='III '){
		                                	 $k3= $urikkes_pemeriksaan_umum->kardio;
		                                } else if ($urikkes_pemeriksaan_umum->kardiologi1=='IV '){
		                                	 $k4= $urikkes_pemeriksaan_umum->kardio; }
		                                	 else {

		                                	} }
		                                	?>

                                    <td width="17%">Kardiologi</td>
                                    <td width="5%"><input type="text" name="k1" class="form-control" value="<?php echo $k1; ?>" /></td>
                                    <td width="5%"><input type="text" name="k2" class="form-control" value="<?php echo $k2; ?>" /></td>
                                    <td width="5%"><input type="text" name="k3" class="form-control" value="<?php echo $k3; ?>" /></td>
                                    <td width="5%"><input type="text" name="k4" class="form-control" value="<?php echo $k4; ?>" /></td>
                                    <td width="40%"><input type="text" name="k5" class="form-control" value="<?php echo $k5; ?>" /></td>
                                  <!--   <select name="k5" id="k5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->kar_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr>
                            
                                <tr>

                                	<?php
		                                	 $pd1=''; $pd2=''; $pd3=''; $pd4='';$pd5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$pd5=$urikkes_pemeriksaan_umum->peda_keterangan;
		                                if($urikkes_pemeriksaan_umum->pd1=='I   '){
		                                	 $pd1= $urikkes_pemeriksaan_umum->pd;
		                                } else if ($urikkes_pemeriksaan_umum->pd1=='II  '){
		                                	 $pd2= $urikkes_pemeriksaan_umum->pd;
		                              } else if ($urikkes_pemeriksaan_umum->pd1=='III '){
		                                	 $pd3= $urikkes_pemeriksaan_umum->pd;
		                                } else if ($urikkes_pemeriksaan_umum->pd1=='IV  '){
		                                	 $pd4= $urikkes_pemeriksaan_umum->pd; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>Penyakit Dalam</td>
                                    <td><input type="text" name="pd1" class="form-control"
                                    	value="<?php echo $pd1; ?>"/></td>
                                    <td><input type="text" name="pd2" class="form-control"
                                    	value="<?php echo $pd2; ?>"/></td>
                                    <td><input type="text" name="pd3" class="form-control"
                                    	value="<?php echo $pd3; ?>"/></td>
                                    <td><input type="text" name="pd4" class="form-control"
                                    	value="<?php echo $pd4; ?>"/></td>
                                    <td width="40%"><input type="text" name="pd5" class="form-control" value="<?php echo $pd5; ?>" /></td>
                                    <!-- <select name="pd5" id="pd5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->peda_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr>
                                 <tr>
                                 	<?php
		                                	 $b1=''; $b2=''; $b3=''; $b4='';$b5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$b5=$urikkes_pemeriksaan_umum->bedah_keterangan;
		                                if($urikkes_pemeriksaan_umum->b1=='I   '){
		                                	 $b1= $urikkes_pemeriksaan_umum->b;
		                                } else if ($urikkes_pemeriksaan_umum->b1=='II  '){
		                                	 $b2= $urikkes_pemeriksaan_umum->b;
		                               	} else if ($urikkes_pemeriksaan_umum->b1=='III '){
		                                	 $b3= $urikkes_pemeriksaan_umum->b;
		                                } else if ($urikkes_pemeriksaan_umum->b1=='IV  '){
		                                	 $b4= $urikkes_pemeriksaan_umum->b; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>Bedah</td>
                                    <td><input type="text" name="b1" class="form-control" value="<?php echo $b1; ?>"/></td>
                                    <td><input type="text" name="b2" class="form-control" value="<?php echo $b2; ?>"/></td>
                                    <td><input type="text" name="b3" class="form-control" value="<?php echo $b3; ?>"/></td>
                                    <td><input type="text" name="b4" class="form-control" value="<?php echo $b4; ?>"/></td>
                                    <td width="40%"><input type="text" name="b5" class="form-control" value="<?php echo $b5; ?>" /></td>
                                    <!-- <select name="b5" id="b5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->bedah_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr> 
                                <tr>
                                	<?php
		                                	 $tht1=''; $tht2=''; $tht3=''; $tht4='';$tht5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$tht5=$urikkes_pemeriksaan_umum->tht_keterangan;
		                                if($urikkes_pemeriksaan_umum->tht1=='I   '){
		                                	 $tht1= $urikkes_pemeriksaan_umum->tht;
		                                } else if ($urikkes_pemeriksaan_umum->tht1=='II  '){
		                                	 $tht2= $urikkes_pemeriksaan_umum->tht;
		                               	} else if ($urikkes_pemeriksaan_umum->tht1=='III '){
		                                	 $tht3= $urikkes_pemeriksaan_umum->tht;
		                                } else if ($urikkes_pemeriksaan_umum->tht1=='IV  '){
		                                	 $tht4= $urikkes_pemeriksaan_umum->tht; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>THT dan Audiometri</td>
                                    <td><input type="text" name="tht1" class="form-control" value="<?php echo $tht1; ?>"/></td>
                                    <td><input type="text" name="tht2" class="form-control" value="<?php echo $tht2; ?>"/></td>
                                    <td><input type="text" name="tht3" class="form-control" value="<?php echo $tht3; ?>"/></td>
                                    <td><input type="text" name="tht4" class="form-control" value="<?php echo $tht4; ?>"/></td>
                                    <td width="40%"><input type="text" name="tht5" class="form-control" value="<?php echo $tht5; ?>" /></td>
                                    <!-- <select name="tht5" id="tht5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->tht_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr> 
                                <tr>
                                	<?php
		                                	 $m1=''; $m2=''; $m3=''; $m4='';$m5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$m5=$urikkes_pemeriksaan_umum->mata_keterangan;
		                                if($urikkes_pemeriksaan_umum->m1=='I   '){
		                                	 $m1= $urikkes_pemeriksaan_umum->m;
		                                } else if ($urikkes_pemeriksaan_umum->m1=='II  '){
		                                	 $m2= $urikkes_pemeriksaan_umum->m;
		                               	} else if ($urikkes_pemeriksaan_umum->m1=='III '){
		                                	 $m3= $urikkes_pemeriksaan_umum->m;
		                                } else if ($urikkes_pemeriksaan_umum->m1=='IV  '){
		                                	 $m4= $urikkes_pemeriksaan_umum->m; }
		                                	 else {

		                                	} }
		                                	?>
                                	
                                    <td>Mata</td>
                                    <td><input type="text" name="m1" class="form-control" value="<?php echo $m1; ?>"/></td>
                                    <td><input type="text" name="m2" class="form-control" value="<?php echo $m2; ?>"/></td>
                                    <td><input type="text" name="m3" class="form-control" value="<?php echo $m3; ?>"/></td>
                                    <td><input type="text" name="m4" class="form-control" value="<?php echo $m4; ?>"/></td>
                                    <td width="40%"><input type="text" name="m5" class="form-control" value="<?php echo $m5; ?>" /></td>
                                   <!--  <select name="m5" id="m5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->mata_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr> 
                                 <tr>
                                 	<?php
		                                	 $s1=''; $s2=''; $s3=''; $s4='';$s5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$s5=$urikkes_pemeriksaan_umum->saraf_keterangan;
		                                if($urikkes_pemeriksaan_umum->s1=='I   '){
		                                	 $s1= $urikkes_pemeriksaan_umum->s;
		                                } else if ($urikkes_pemeriksaan_umum->s1=='II  '){
		                                	 $s2= $urikkes_pemeriksaan_umum->s;
		                               	} else if ($urikkes_pemeriksaan_umum->s1=='III '){
		                                	 $s3= $urikkes_pemeriksaan_umum->s;
		                                } else if ($urikkes_pemeriksaan_umum->s1=='IV  '){
		                                	 $s4= $urikkes_pemeriksaan_umum->s; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>Saraf</td>
                                    <td><input type="text" name="s1" class="form-control" value="<?php echo $s1; ?>"/></td>
                                    <td><input type="text" name="s2" class="form-control" value="<?php echo $s2; ?>"/></td>
                                    <td><input type="text" name="s3" class="form-control" value="<?php echo $s3; ?>"/></td>
                                    <td><input type="text" name="s4" class="form-control" value="<?php echo $s4; ?>"/></td>
                                    <td width="40%"><input type="text" name="s5" class="form-control" value="<?php echo $s5; ?>" /></td>
                                   <!--  <select name="s5" id="s5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->saraf_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr> 
                                <tr>
                                	<?php
		                                	 $g1=''; $g2=''; $g3=''; $g4='';$g5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$g5=$urikkes_pemeriksaan_umum->gigi_keterangan;
		                                if($urikkes_pemeriksaan_umum->g1=='I   '){
		                                	 $g1= $urikkes_pemeriksaan_umum->g;
		                                } else if ($urikkes_pemeriksaan_umum->g1=='II  '){
		                                	 $g2= $urikkes_pemeriksaan_umum->g;
		                               	} else if ($urikkes_pemeriksaan_umum->g1=='III '){
		                                	 $g3= $urikkes_pemeriksaan_umum->g;
		                                } else if ($urikkes_pemeriksaan_umum->g1=='IV  '){
		                                	 $g4= $urikkes_pemeriksaan_umum->g; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>Gigi</td>
                                    <td><input type="text" name="g1" class="form-control" value="<?php echo $g1; ?>"/></td>
                                    <td><input type="text" name="g2" class="form-control" value="<?php echo $g2; ?>"/></td>
                                    <td><input type="text" name="g3" class="form-control" value="<?php echo $g3; ?>"/></td>
                                    <td><input type="text" name="g4" class="form-control" value="<?php echo $g4; ?>"/></td>
                                    <td width="40%"><input type="text" name="g5" class="form-control" value="<?php echo $g5; ?>" /></td>
                                   <!--  <select name="g5" id="g5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->gigi_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr> 
                                <tr>
                                	<?php
		                                	 $l1=''; $l2=''; $l3=''; $l4='';$l5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$l5=$urikkes_pemeriksaan_umum->lab_keterangan;
		                                if($urikkes_pemeriksaan_umum->l1=='I   '){
		                                	 $l1= $urikkes_pemeriksaan_umum->l;
		                                } else if ($urikkes_pemeriksaan_umum->l1=='II  '){
		                                	 $l2= $urikkes_pemeriksaan_umum->l;
		                               	} else if ($urikkes_pemeriksaan_umum->l1=='III '){
		                                	 $l3= $urikkes_pemeriksaan_umum->l;
		                                } else if ($urikkes_pemeriksaan_umum->l1=='IV  '){
		                                	 $l4= $urikkes_pemeriksaan_umum->l; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>Laboratorium</td>
                                    <td><input type="text" name="l1" class="form-control" value="<?php echo $l1; ?>" /></td>
                                    <td><input type="text" name="l2" class="form-control" value="<?php echo $l2; ?>"/></td>
                                    <td><input type="text" name="l3" class="form-control" value="<?php echo $l3; ?>"/></td>
                                    <td><input type="text" name="l4" class="form-control" value="<?php echo $l4; ?>"/></td>
                                    <td width="40%"><input type="text" name="l5" class="form-control" value="<?php echo $l5; ?>" /></td>
                                    <!-- <select name="l5" id="l5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->lab_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr> 

                                 <tr>
                                 	<?php
		                                	 $r1=''; $r2=''; $r3=''; $r4='';$r5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$r5=$urikkes_pemeriksaan_umum->rad_keterangan;
		                                if($urikkes_pemeriksaan_umum->r1=='I   '){
		                                	 $r1= $urikkes_pemeriksaan_umum->r;
		                                } else if ($urikkes_pemeriksaan_umum->r1=='II  '){
		                                	 $r2= $urikkes_pemeriksaan_umum->r;
		                               	} else if ($urikkes_pemeriksaan_umum->r1=='III '){
		                                	 $r3= $urikkes_pemeriksaan_umum->r;
		                                } else if ($urikkes_pemeriksaan_umum->r1=='IV  '){
		                                	 $r4= $urikkes_pemeriksaan_umum->r; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>Radiologi</td>
                                    <td><input type="text" name="r1" class="form-control" value="<?php echo $r1; ?>"/></td>
                                    <td><input type="text" name="r2" class="form-control" value="<?php echo $r2; ?>"/></td>
                                    <td><input type="text" name="r3" class="form-control" value="<?php echo $r3; ?>"/></td>
                                    <td><input type="text" name="r4" class="form-control" value="<?php echo $r4; ?>"/></td>
                                    <td width="40%"><input type="text" name="r5" class="form-control" value="<?php echo $r5; ?>" /></td>
                                   <!--  <select name="r5" id="r5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->rad_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr>
                            
                                <tr>
                                	<?php
		                                	 $u1=''; $u2=''; $u3=''; $u4='';$u5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$u5=$urikkes_pemeriksaan_umum->usg_keterangan;
		                                if($urikkes_pemeriksaan_umum->u1=='I   '){
		                                	 $u1= $urikkes_pemeriksaan_umum->u;
		                                } else if ($urikkes_pemeriksaan_umum->u1=='II  '){
		                                	 $u2= $urikkes_pemeriksaan_umum->u;
		                               	} else if ($urikkes_pemeriksaan_umum->u1=='III '){
		                                	 $u3= $urikkes_pemeriksaan_umum->u;
		                                } else if ($urikkes_pemeriksaan_umum->u1=='IV  '){
		                                	 $u4= $urikkes_pemeriksaan_umum->u; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>USG</td>
                                    <td><input type="text" name="u1" class="form-control" value="<?php echo $u1; ?>"/></td>
                                    <td><input type="text" name="u2" class="form-control" value="<?php echo $u2; ?>"/></td>
                                    <td><input type="text" name="u3" class="form-control" value="<?php echo $u3; ?>"/></td>
                                    <td><input type="text" name="u4" class="form-control" value="<?php echo $u4; ?>"/></td>
                                    <td width="40%"><input type="text" name="u5" class="form-control" value="<?php echo $u5; ?>" /></td>
                                    <!-- <select name="u5" id="u5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->usg_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr>
                            		
                                <tr> 
                                	<?php
		                                	 $sp1=''; $sp2=''; $sp3=''; $sp4='';$sp5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$sp5=$urikkes_pemeriksaan_umum->spiro_keterangan;
		                                if($urikkes_pemeriksaan_umum->sp1=='I   '){
		                                	 $sp1= $urikkes_pemeriksaan_umum->sp;
		                                } else if ($urikkes_pemeriksaan_umum->sp1=='II  '){
		                                	 $sp2= $urikkes_pemeriksaan_umum->sp;
		                               	} else if ($urikkes_pemeriksaan_umum->sp1=='III '){
		                                	 $sp3= $urikkes_pemeriksaan_umum->sp;
		                                } else if ($urikkes_pemeriksaan_umum->sp1=='IV  '){
		                                	 $sp4= $urikkes_pemeriksaan_umum->sp; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>Spiometri</td>
                                    <td><input type="text" name="sp1" class="form-control" value="<?php echo $sp1; ?>"/></td>
                                    <td><input type="text" name="sp2" class="form-control" value="<?php echo $sp2; ?>"/></td>
                                    <td><input type="text" name="sp3" class="form-control" value="<?php echo $sp3; ?>"/></td>
                                    <td><input type="text" name="sp4" class="form-control" value="<?php echo $sp4; ?>"/></td>
                                    <td width="40%"><input type="text" name="sp5" class="form-control" value="<?php echo $sp5; ?>" /></td>
                                   <!--  <select name="sp5" id="sp5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->spiro_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr> 

                                 <tr>
                                 	<?php
		                                	 $ps1=''; $ps2=''; $ps3=''; $ps4='';$ps5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$ps5=$urikkes_pemeriksaan_umum->pap_keterangan;
		                                if($urikkes_pemeriksaan_umum->ps1=='I   '){
		                                	 $ps1= $urikkes_pemeriksaan_umum->ps;
		                                } else if ($urikkes_pemeriksaan_umum->ps1=='II  '){
		                                	 $ps2= $urikkes_pemeriksaan_umum->ps;
		                               	} else if ($urikkes_pemeriksaan_umum->ps1=='III '){
		                                	 $ps3= $urikkes_pemeriksaan_umum->ps;
		                                } else if ($urikkes_pemeriksaan_umum->ps1=='IV  '){
		                                	 $ps4= $urikkes_pemeriksaan_umum->ps; }
		                                	 else {

		                                	} }
		                                	?>
                                    <td>Pap Semar</td>
                                    <td><input type="text" name="ps1" class="form-control" value="<?php echo $ps1; ?>"/></td>
                                    <td><input type="text" name="ps2" class="form-control" value="<?php echo $ps2; ?>"/></td>
                                    <td><input type="text" name="ps3" class="form-control" value="<?php echo $ps3; ?>"/></td>
                                    <td><input type="text" name="ps4" class="form-control" value="<?php echo $ps4; ?>"/></td>
                                    <td width="40%"><input type="text" name="ps5" class="form-control" value="<?php echo $ps5; ?>" /></td>
                                   <!--  <select name="ps5" id="ps5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->pap_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr>
                            
                                <tr>
                                	<?php
		                                	 $ll1=''; $ll2=''; $ll3=''; $ll4='';$ll5='';
		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$ll5=$urikkes_pemeriksaan_umum->lain_keterangan;
		                                if($urikkes_pemeriksaan_umum->ll1=='I   '){
		                                	 $ll1= $urikkes_pemeriksaan_umum->ll;
		                                } else if ($urikkes_pemeriksaan_umum->ll1=='II  '){
		                                	 $ll2= $urikkes_pemeriksaan_umum->ll;
		                               	} else if ($urikkes_pemeriksaan_umum->ll1=='III '){
		                                	 $ll3= $urikkes_pemeriksaan_umum->ll;
		                                } else if ($urikkes_pemeriksaan_umum->ll1=='IV  '){
		                                	 $ll4= $urikkes_pemeriksaan_umum->ll; }
		                                	 else {
		                                	} 
		                        	}        	?>
                                    <td width="17%">lain-lain</td>
                                    <td width="5%"><input type="text" name="ll1" class="form-control" value="<?php echo $ll1; ?>"/></td>
                                    <td width="5%"><input type="text" name="ll2" class="form-control" value="<?php echo $ll2; ?>"/></td>
                                    <td width="5%"><input type="text" name="ll3" class="form-control" value="<?php echo $ll3; ?>"/></td>
                                    <td width="5%"><input type="text" name="ll4" class="form-control" value="<?php echo $ll4; ?>"/></td>
                                    <td width="40%"><input type="text" name="ll5" class="form-control" value="<?php echo $ll5; ?>" /></td>
                                   <!--  <select name="ll5" id="l5" class="js-states form-control form-control-line select2" style="width: 100%" >
									<option value=""></option>
									<?php 
									foreach($diagnosa as $row){	
										if ($urikkes_pemeriksaan_umum->lain_keterangan == $row->id_icd) {
											echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
										} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
									}
									?>
									</select> -->
                                   </td>
                                </tr>
                               	
                            </tbody>
                        </table>
                   
                
							<div class="form-group row">
							<div class="form-group col">
									<label class="col-sm-5 control-label col-form-label" id="kesm">Kesimpulan / Saran</label>
									<div class="col-sm-11">
										<textarea rows="10" cols="115" name="kesimpulan_saran" id="kesimpulan_saran"> <?php echo $urikkes_pasien->kesimpulan_saran;?> </textarea>
									</div>
							</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 control-label col-form-label" id="kesm">Diagnosa</label>
									<div class="col-sm-11">
										<select name="diagnosa" id="diagnosas" class="js-states form-control form-control-line select2" style="width: 100%" >
											<option value="">- Pilih Diagnosa - </option>
											<?php 
											foreach($diagnosa as $row){	
												if ($urikkes_pemeriksaan_umum->diagnosa == $row->id_icd) {
													echo '<option value="'.$row->id_icd.'" selected>'.$row->nm_diagnosa.'</option>';
												} else {echo '<option value="'.$row->id_icd.'">'.$row->nm_diagnosa.'</option>';}
											}
											?>
										</select>
									</div>
							</div>
							<hr>
							
						
								<div class="form-group col">
								<label class="col-sm-6 control-label col-form-label" id="stat_gol">Golongan</label>
								<table class="table table-bordered" align="center">
		                            <thead>
		                                <tr>
		                                	<td colspan="7"><center> Status Fisik</td>
		                                	<td colspan="4"><center> Golongan</td>
		                                </tr>
		                                <tr align="center">
		                                	<td ><center> U </th>
		                                	<td ><center> A </th>
		                                	<td ><center> B </th>
		                                	<td ><center> D </th>
		                                	<td ><center> L </th>
		                                	<td ><center> G </th>
		                                	<td ><center> J </th>
		                                	<td ><center> I </th>
		                                	<td ><center> II </th>
		                                	<td ><center> III </th>
		                                	<td ><center> IV </th>
		                                </tr>
		                                <?php
		                                $u='';$a='';$b='';$d='';$l='';$g='';$j='';

		                        if (!empty($urikkes_pemeriksaan_umum)) {
		                        		$u=$urikkes_pemeriksaan_umum->sf_umum;
		                        		$a=$urikkes_pemeriksaan_umum->sf_atas;
		                        		$b=$urikkes_pemeriksaan_umum->sf_bawah;
		                        		$d=$urikkes_pemeriksaan_umum->sf_dengar;
		                        		$l=$urikkes_pemeriksaan_umum->sf_lihat;
		                        		$g=$urikkes_pemeriksaan_umum->sf_gigi;
		                        		$j=$urikkes_pemeriksaan_umum->sf_jiwa;
		                               } ?>
		                                <tr>
		                                	<td width="3%"><input type="text" name="sf_u" class="form-control" value="<?php echo $u ?>" />
		                                		 </td> 
		                                	<td width="3%"><input type="text" name="sf_a" class="form-control" value="<?php echo $a ?>"/></td>
		                                	<td width="3%"><input type="text" name="sf_b" class="form-control" value="<?php echo $b ?>"/></td>
		                                	<td width="3%"><input type="text" name="sf_d" class="form-control" value="<?php echo $d ?>"/></td>
		                                	<td width="3%"><input type="text" name="sf_l" class="form-control" value="<?php echo $l ?>"/></td>
		                                	<td width="3%"><input type="text" name="sf_g" class="form-control" value="<?php echo $g ?>"/></td>
		                                	<td width="3%"><input type="text" name="sf_j" class="form-control" value="<?php echo $j ?>"/></td>
		                                	 
		                                	 
		                                	 <?php
		                                	 $gol1=''; $gol2=''; $gol3=''; $gol4='';

		                                	 if($urikkes_pasien->golongan1=='I   '){
		                                	 $gol1= $urikkes_pasien->gol;
		                                	} else if ($urikkes_pasien->golongan1=='II  '){
		                                	 $gol2= $urikkes_pasien->gol;
		                                	} else if ($urikkes_pasien->golongan1=='III '){
		                                	 $gol3= $urikkes_pasien->gol;
		                                	 } else if ($urikkes_pasien->golongan1=='IV  '){
		                                	 $gol4= $urikkes_pasien->gol; }
		                                	 else {

		                                	} ?>

		                                	 <td width="3%"><input type="text" name="gol_1" class="form-control" value="<?php echo $gol1 ?>" readonly> </td>
		                                	<td width="3%"><input type="text" name="gol_2" class="form-control" value="<?php echo $gol2 ?>" readonly></td>
		                                	<td width="3%"><input type="text" name="gol_3" class="form-control" value="<?php echo $gol3 ?>" readonly></td>
		                                	<td width="3%"><input type="text" name="gol_4" class="form-control" value="<?php echo $gol4 ?>" readonly></td>
		                                	
		                                </tr>

		                                 
		                            </thead>
		                        </table>
							
						<hr>

               			</div>
               			<?php if ($urikkes_pasien->penyelam=='ya') { ?> 
               				<h3>Pengisian Peserta Penyelam</h3>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Portion of Fat</label>
								<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" id="sl_fat" name="sl_fat"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_fat;?>">
								</div>
								<label class="col-sm-2 control-label col-form-label" >Film No. Chest</label>
								<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" id="sl_film_chest" name="sl_film_chest"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_film_chest;?>">
								</div>
								<label class="col-sm-2 control-label col-form-label" >Film No. Big Joints</label>
								<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" id="sl_film_big" name="sl_film_big"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_film_big;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-1 control-label col-form-label" >Basophyl</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="sl_basophyl" name="sl_basophyl"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_basophyl;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" >Eosinophyl</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="sl_eosinophyl" name="sl_eosinophyl"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_eosinophyl;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" >Staf</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="sl_staf" name="sl_staf"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_staf;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" >Segmen</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="sl_segmen" name="sl_segmen"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_segmen;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" >Limphocyte</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="sl_limphocyte" name="sl_limphocyte"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_limphocyte;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" >Monocyte</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="sl_monocyte" name="sl_monocyte"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_monocyte;?>">
								</div>
							</div>
							<div class="form-group row">
							<div class="form-group col">
									<label class="col-sm-5 control-label col-form-label" id="kesm">Conclution</label>
									<div class="col-sm-11">
										<textarea rows="10" cols="115" name="conclution" id="conclution"> <?php echo $urikkes_resume_pemeriksaan_detail->conclution;?> </textarea>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Remarks</label>
								<div class="col-sm-5">
										<input type="text" class="form-control" placeholder="" id="sl_remarks" name="sl_remarks"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->sl_remarks;?>">
										<input type="hidden" class="form-control" placeholder="" id="penyelam" name="penyelam"
										value="<?php echo $urikkes_pasien->penyelam;?>">
								</div>
							</div>
							<?php } else {} ?>

               			<div class="form-group row">
							<div class="offset-sm-3 col-sm-8">
									<div class="demo-checkbox1">	
										<input type="checkbox" class="filled-in" name="luar_negri" id="luar_negri" 
										value="ya"/>
	                                    <label for="luar_negri">Luar Negri</label>
	                                    <input type="checkbox" class="filled-in" name="karumkit" id="karumkit" 
										value="ya"/>
	                                    <label for="karumkit">TTD Karumkit</label>
	                          		</div>
							</div>
						</div>
               			
               		</div>
               	 <!-- tab content biodata-->
					</div>
				</div>	

								
				<div id="hasil_pemeriksaan" class="tab-pane" role="tabpanel">
					<br>
					<h3>Pemeriksaan Umum</h3> <hr>					
						<div class="col-lg-10" style="margin: 0 auto;">

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="bb">Berat Badan</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="berat_badan" 
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_beratbadan;?>"/>
									</div>
								<label class="col-sm-1 control-label col-form-label" >Kg</label>	
								<label class="col-sm-2 control-label col-form-label" id="bb">Tinggi Badan</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="tinggi_badan"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_tinggibadan;?>"/>
								</div>
								<label class="col-sm-1 control-label col-form-label" id="bb">Cm</label>
								<label class="col-sm-2 control-label col-form-label" id="td">Tekanan Darah</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="tekanan_darah"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_tekanandarah;?>"/>
									</div>
								<label class="col-sm-1 control-label col-form-label" id="mmhg">mmHg</label>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="jt">Jantung</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="jantung"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_jantung;?>"/>
									</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
								<label class="col-sm-2 control-label col-form-label" id="p">Paru-Paru</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="paruparu"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_paruparu;?>"/>
								</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
								<label class="col-sm-2 control-label col-form-label" id="pr">Perut</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="perut"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_perut;?>"/>
									</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Hati</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="hati"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_hati;?>">
									</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
								<label class="col-sm-2 control-label col-form-label" id="lp">Limpa</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="limpa"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_limpa;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
								<label class="col-sm-2 control-label col-form-label" id="ag">Anggota Gerak</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="ang_gerak"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_anggotagerak;?>">
									</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ginjal</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="pu_ginjal"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_ginjal;?>">
									</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
								<label class="col-sm-2 control-label col-form-label" id="lp">Lain-Lain</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="pu_lainlain"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_lainlain;?>">
								</div>
							</div>
						</div>		
							<hr>	
							<h3>Pemeriksaan T.H.T </h3>
							<hr>
						<div class="col-lg-10" style="margin: 0 auto;">
							
							<div class="form-group row">
								<label class="col-sm-1 control-label col-form-label" id="ht">Hidung</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" name="hidung"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_hidung;?>">
									</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
								<label class="col-sm-1 control-label col-form-label" id="lp">Telinga</label>
								<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" name="telinga"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_telinga;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" > </label>
								<label class="col-sm-2 control-label col-form-label" id="ag">Tenggorokan</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" name="ternggorokan"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_tenggorokan;?>">
									</div>
								<!-- <label class="col-sm-1 control-label col-form-label" > </label> -->
							</div>	

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="audio">Audiometri</label>
								<label class="col-sm-2 control-label col-form-label" id="aud">Kanan</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="aud_kanan"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_audiometri_kanan;?>">
								</div>
								
							</div>	
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" id="aud">Kiri</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="aud_kiri"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_audiomteri_kiri;?>">
									</div> <label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" id="aud">Lain-lain</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" name="lainlaintht"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_lainlain;?>">
								</div>
							</div>
						</div>
						<hr>
						<h3>Pemeriksaan Mata</h3>
						<hr>

						<div class="col-lg-10" style="margin: 0 auto;">
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="audio">Refraksi</label>
								<label class="col-sm-2 control-label col-form-label" id="aud">OD</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="refraksi_od"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_refraksi_od;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" id="audio">Tajam Penglihatan</label>
								<label class="col-sm-2 control-label col-form-label" id="aud">Kanan</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="pm_kanan"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_kanan;?>">
								</div>
								
							</div>	
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" id="aud">OS</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="refraksi_os"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_refraksi_os;?>">
									</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" id="aud">Kiri</label>
									<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" name="pm_kiri"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_kiri;?>">
									</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="audio">Tonometri</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" name="pm_tonometri"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_tonometri;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" id="aud">Buta Warna</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" name="pm_butawarna"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_butawarna;?>">
								</div>
								
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="audio">Presbiyopia</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" name="presbiyopia"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_presbiyopia;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" id="aud">Lain-lain</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" name="lainlain_mata"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_lainlain;?>">
								</div>
								
							</div>	
						</div>
						<hr>
						<h3>Pemeriksaan Gigi</h3>
						<hr>
						<div class="col-lg-10" style="margin: 0 auto;">
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Pro Ekstrasi</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pro_ekstrasi" name="pro_ekstrasi"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_pro_ekstrasi;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Pro Konservasi</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pro_konservasi" name="pro_konservasi"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_pro_konservasi;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Pro Pembersihan Karang Gigi</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pro_pembersihan" name="pro_pembersihan"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_pro_kebersihan_gigi;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Pro Portese</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pro_portese" name="pro_portese"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_pro_portese;?>">
								</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Lain-lain</label>
								<div class="col-sm-10">
										<input type="text" class="form-control" placeholder="" id="lainlaingigi" name="lainlaingigi"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_lainlain;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
							</div>
						</div>
						<hr>
						<h3>Pemeriksaan Bedah</h3>
						<hr>
						<div class="col-lg-10" style="margin: 0 auto;">
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Mamae</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="mamae" name="mamae"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_mamae;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Prostat</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="prostat" name="prostat" value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_prostat;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Hernia</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="hernia" name="hernia" value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_hernia;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Anus</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="anus" name="anus" 
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_anus;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Dan Lain Lain</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="anggot_gerak" name="anggot_gerak"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_anggot_gerak;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Saraf</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="saraf" name="saraf" 
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_saraf;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Pemeriksaan Keswa</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="per_keswa" name="per_keswa"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_pemeriksaan_keswa;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" ></label>
							</div>
						</div>
						<hr>
						<h3>Pemeriksaan EKG</h3>
						<hr>
						<div class="col-lg-10" style="margin: 0 auto;">
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Istirahat</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="istirahat" name="istirahat"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pe_istirahat;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >M.S.T</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="mst" name="mst"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pe_mst;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Treadmill</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="treadmill" name="treadmill"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pe_treadmill;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Kesimpulan</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="kesimpulan" name="pe_kesimpulan"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pe_kesimpulan;?>">
								</div>
							</div>
						</div>
						<hr>
						<h3>Pemeriksaan Ginekologi</h3>
						<hr>
						<div class="col-lg-10" style="margin: 0 auto;">
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Introitus Vaginae</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pgk_introitus" name="pgk_introitus"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_introitus;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Cervix Uteri</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pgk_cerviks" name="pgk_cerviks"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_cerviks;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Uterus</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pgk_uterus" name="pgk_uterus"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_uterus;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Adnexa</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pgk_adnexa" name="pgk_adnexa"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_adnexa;?>">
								</div>
							</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >PAP SMEAR</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pgk_papsmear" name="pgk_papsmear"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_papsmear;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Lain- Lain</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="pgk_lainlain" name="pgk_lainlain"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_lainlain;?>">
								</div>
							</div>
						</div>
						<hr>
						<h3>Pemeriksaan Tinja</h3>
						<hr>
						<div class="col-lg-10" style="margin: 0 auto;">
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Makroskopik</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="t_makroskopik" name="t_makroskopik"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->t_makroskopik;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Mikroskopik</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="t_mikroskopik" name="t_mikroskopik"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->t_mikroskopik;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Lekosit</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="t_lekosit" name="t_lekosit"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->t_lekosit;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Eritrosit</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="t_eritrosit" name="t_eritrosit"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->t_eritrosit;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Telur Cacing</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="t_telurcacing" name="t_telurcacing"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->t_telurcacing;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Amoeba Coli</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="t_amoebacoli" name="t_amoebacoli"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->t_amoebacoli;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Parasit Lain</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="t_lainlain" name="t_lainlain"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->t_lainlain;?>">
								</div>
								
							</div>
						</div>
						<hr>
						<h3>Pemeriksaan Laboratorium</h3>
						<hr>
						<div class="col-lg-10" style="margin: 0 auto;">
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Golongan Darah</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="goldar" name="goldar"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_goldar;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>

							<label class="col-sm-2 control-label col-form-label" >L.E.D</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="led" name="led"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_led;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >(P:<10mm/jam W:20/jarr)</label>
								
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Hemoglobin</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="hemoglobin" name="hemoglobin"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_hemoglobin;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >(P:<10mm/jam W:20/jarr)</label>

								<label class="col-sm-2 control-label col-form-label" >Leukosit</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="leukosit" name="leukosit"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_leukosit;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >(5000 - 10000/mm<sup>3</sup>)</label>
							</div>
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Hitung Jenis</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="hitjen" name="hitjen"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_hitung_jenis;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>

							<label class="col-sm-2 control-label col-form-label" >Gula Darah Puasa</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="gudarp" name="gudarp" 
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_guladarah_puasa;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( <110 mg% )</label>
								
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Gula Darah 2 jam PP</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="gudarpp" name="gudarpp"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_guladarah_2jampp;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( <140 mg% )</label>

								<label class="col-sm-2 control-label col-form-label" >Kolestrol</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="kolestrol" name="kolestrol"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_kolestrol;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( <200 mg/dl )</label>
							</div>
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >HDL Kolestrol</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="hdl_kol" name="hdl_kol"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_hdl_kolestrol;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( 40-60mg/dl )</label>

							<label class="col-sm-2 control-label col-form-label" >LDL Kolestrol</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="ldl_kol" name="ldl_kol"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_ldl_kolestrol;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( <130 mg/dl )</label>
								
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Trigliserid</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="trigliserid" name="trigliserid"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_trigliserid;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( <170 mg/dl )</label>

								<label class="col-sm-2 control-label col-form-label" >SGOT</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="sgot" name="sgot"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_sgot;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( 5-34 u/l )</label>
							</div>

							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >SGPT</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="sgpt" name="sgpt"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_sgpt;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( <55 u/l )</label>

							<label class="col-sm-2 control-label col-form-label" >Alkali Fosfatase</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="alkali_fos" name="alkali_fos" 
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_alkali_fosfatase;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( <258 u/l )</label>
								
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Total Protein</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="tot_protein" name="tot_protein" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_total_protein;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( 6,6-8,8 g/dl )</label>

								<label class="col-sm-2 control-label col-form-label" >Albumin</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="albumin" name="albumin" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_alumin;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( 3,5-5,2 g/dl )</label>
							</div>
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Globulin</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="globulin" name="globulin" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_globulin;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( 2,6-3,4 g/dl )</label>

							<label class="col-sm-2 control-label col-form-label" >Kreatinin</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="kreatinin" name="kreatinin" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_kreatinin;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >(P:0,7-1,3mg/dl W:0,6-1,1mg/dl)</label>
								
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Ureum</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="ureum" name="ureum" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_ureum;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( 20-50 mg/dl )</label>

								<label class="col-sm-2 control-label col-form-label" >Asam Urat</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="asam_urat" name="asamurat" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_asamurat;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >(P:3,5-7,2mg/dl W:2,6-6,0mg/dl)</label>
							</div><div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Bilirubin Total</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="bilirubin_tot" name="bilirubin_tot" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_bilirubin_total;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( 0,1-60mg/dl )</label>

							<label class="col-sm-2 control-label col-form-label" >Bilirubin Direk</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="bilirubin_di" name="bilirubin_di" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_bilirubin_direk;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >( <0,5 mg/dl )</label>
								
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Bilirubin Indirek</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="bilirubin_in" name="bilirubin_in" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_bilirubin_indirek;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" > </label>

								<label class="col-sm-2 control-label col-form-label" >HBsAG</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="hbsag" name="hbsag" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_hbsag;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Troponin I</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pll_troponin" name="pll_troponin" value="<?php echo $urikkes_resume_pemeriksaan_detail->pll_troponin;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" > </label>

								<label class="col-sm-2 control-label col-form-label" >CK-MB</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pll_ckmb" name="pll_ckmb" value="<?php echo $urikkes_resume_pemeriksaan_detail->pll_ckmb;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
						</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >ANti HCV</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pl_antihcv" name="pl_antihcv" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_antihcv;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" > </label>

								<label class="col-sm-2 control-label col-form-label" >VDRL</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pl_vdrl" name="pl_vdrl" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_vdrl;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
						</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Anti HIV</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pl_antihiv" name="pl_antihiv" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_antihiv;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" > </label>

								<label class="col-sm-2 control-label col-form-label" >Malaria</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pl_malaria" name="pl_malaria" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_malaria;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
						</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Anti HBS</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pl_antihbs" name="pl_antihbs" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_antihbs;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" > </label>

								<label class="col-sm-2 control-label col-form-label" >PSA</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pl_psa" name="pl_psa" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_psa;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
						</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Eritrosit</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="pl_eritrosit" name="pl_eritrosit"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_eritrosit;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" >(5000 - 10000/mm<sup>3</sup>)</label>
						</div>
							
						<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" ><b>Urine</b></label>
						</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >pH</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="ph" name="ph" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_ph;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>

								<label class="col-sm-2 control-label col-form-label" >BJ</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="bj" name="bj" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_bj;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Reduksi</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="reduksi" name="reduksi" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_reduksi;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>

								<label class="col-sm-2 control-label col-form-label" >Protein</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="protein" name="protein" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_protein;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>
														<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Keton</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="keton" name="keton" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_keton;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>

								<label class="col-sm-2 control-label col-form-label" >Nitrite</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="nitrite" name="nitrite" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_nitrite;?>"> 
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>
														<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Bilirubin</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="bilirubin" name="bilirubin" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_bilirubin;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>

								<label class="col-sm-2 control-label col-form-label" >Urobilinogen</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="urobilinogen" name="urobilinogen" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_urobilinogen;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Warna</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="u_warna" name="u_warna" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_warna;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>

							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" ><b>Sedimen Urine</b>	</label>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Lekosit</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="lekosit_urin" name="lekosit_urin" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_lekosit;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>

								<label class="col-sm-2 control-label col-form-label" >Eritrosit</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="eritrosit" name="eritrosit" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_eritrosit;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Kristal</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="kristal" name="kristal" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_kristal;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>

								<label class="col-sm-2 control-label col-form-label" >Silinder</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="silinder" name="silinder" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_silinder;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Epitel</label>
								<div class="col-sm-1">
										<input type="text" class="form-control" placeholder="" id="epitel" name="epitel" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_epitel;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" ></label>
							</div>

						<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" ><b>Narkoba</b>	</label>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Morphin</label>
								<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" id="n_morphin" name="n_morphin" value="<?php echo $urikkes_resume_pemeriksaan_detail->n_morphin;?>">
								</div>
								<label class="col-sm-2 control-label col-form-label" ></label>

								<label class="col-sm-2 control-label col-form-label" >Amphetamin</label>
								<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" id="n_amphetamin" name="n_amphetamin" value="<?php echo $urikkes_resume_pemeriksaan_detail->n_amphetamin;?>">
								</div>
								<label class="col-sm-2 control-label col-form-label" ></label>
							</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Mariyuana</label>
								<div class="col-sm-2">
										<input type="text" class="form-control" placeholder="" id="n_mariyuana" name="n_mariyuana" value="<?php echo $urikkes_resume_pemeriksaan_detail->n_mariyuana;?>">
								</div>
						</div>
						</div>



						<hr>
						<h3>Pemeriksaan Rontgen</h3>
						<hr>
						<div class="col-lg-10" style="margin: 0 auto;">
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >Sin Diaph</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="sindiaph" name="sindiaph" value="<?php echo $urikkes_resume_pemeriksaan_detail->pr_sin_daph;?>"> 
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Jantung</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="jantung_ront" name="jantung_ront" value="<?php echo $urikkes_resume_pemeriksaan_detail->pr_jantung;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Paru-Paru</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="paruparu_ront" name="paruparu_ront" value="<?php echo $urikkes_resume_pemeriksaan_detail->pr_paruparu;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Lain-lain</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="lln_rontgen" name="lln_rontgen" value="<?php echo $urikkes_resume_pemeriksaan_detail->pr_lainlain;?>">
								</div>
							</div>
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" ><b>USG</b>	</label>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >USG Hati</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="usg_hati" name="usg_hati" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_hati;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >USG Empedu</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="usg_empedu" name="usg_empedu" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_empedu;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >USG Ginjal</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="usg_ginjal" name="usg_ginjal" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_ginjal;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >USG Limpa</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="usg_limpa" name="usg_limpa" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_limpa;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >USG Pankreas</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="usg_pankreas" name="usg_pankreas" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_pankreas;?>">
								</div>
								<label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >USG Lain-Lain</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="usg_lainlain" name="usg_lainlain" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_lainlain;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Hasil USG</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="usg" name="usg" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg;?>">
								</div>
							</div>
							

							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" ><b>Sprirometri</b>	</label>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >FVC Meas 1</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_fvc_meas1" name="spr_fvc_meas1"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_fvc_meas1;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >FVC PRED</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_fvc" name="spr_fvc"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_fvc;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >FEV Meas 1</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_fev_meas1" name="spr_fev_meas1"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_fev_meas1;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >FEV PRED</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_fev" name="spr_fev"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_fev;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >PEF Meas 1</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_pef_meas1" name="spr_pef_meas1"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_pef_meas1;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >PEF PRED</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_pef" name="spr_pef"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_pef;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Hasil Meas 1</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_hasil_meas1" name="spr_hasil_meas1"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_hasil_meas1;?>">
								</div><label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Hasil PRED</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_hasil" name="spr_hasil"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_hasil;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >OTT</label>
								<div class="col-sm-3">
										<input type="text" class="form-control" placeholder="" id="spr_ott" name="spr_ott" value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_ott;?>">
								</div>
							</div>
							
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
												<button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit">Simpan</button>

												
                                            </div>
                                        </div>
                                    </div>
                                </div>
             				 </div>

				<?php echo form_close();?>
			   <br><br>

		</div>
	</div>
</div>
<hr>


	
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 