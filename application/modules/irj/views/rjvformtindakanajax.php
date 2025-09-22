<?php
$this->load->view('layout/header_form');
 include('script_rjvpelayanan.php'); ?>
<script type="text/javascript">
	function surat_tindakan_kesehatan()
	{	
			$("#MyModalSurat").modal('show');

	}
	function surat_tindakan_jiwa()
	{	
			$("#MyModalSuratJiwa").modal('show');

	}
  function surat_tindakan_narkoba()
	{	
			$("#MyModalSuratNarkoba").modal('show');

	}

//insert surat kesehatan 
	function insert(){
    console.log($('#MyModalSurat').serialize());
    var noreg = "<?php echo $no_register; ?>";
    var bb = $('#bb').val();
    var tb = $('#tb').val();
    var kondisi_pasien = $('input[name=kondisi_pasien]:checked').val();
    document.getElementById("submit_add").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('irj/rjcpelayanan/cetak_surat_keterangan_st')?>",
       // dataType: "JSON",
        data:{
          no_register:noreg, 
          bb:bb, 
          tb:tb,
          kondisi_pasien:kondisi_pasien
         
        },
        success: function(data){
          // console.log(noreg);
        	window.open("<?php echo site_url("irj/rjcpelayanan/cetak_surat_kesehatan/".$no_register)?>","_blank");window.focus();
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


// insert surat kesehatan jiwa
function insert2(){
    console.log($('#MyModalSuratJiwa').serialize());
    var noreg = "<?php echo $no_register; ?>";
    var pemeriksaan_jiwa = $('#pemeriksaan_jiwa').val();
    var tgl_hasil_jiwa = $('#tgl_hasil_jiwa').val();
    var hasil_pem_jiwa = $('#hasil_pem_jiwa').val();
    var surat_untuk = $('#surat_untuk').val();
    var kondisi_pasien = $('input[name=kondisi_pasien]:checked').val();

    if(tgl_hasil_jiwa != ''){
      document.getElementById("submit_add2").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'irj/rjcpelayanan/cetak_surat_keterangan_st_jiwa/';?>",
        // dataType: "JSON",
          data:{
            no_register:noreg, 
            pemeriksaan_jiwa:pemeriksaan_jiwa, 
            tgl_hasil_jiwa:tgl_hasil_jiwa,
            hasil_pem_jiwa:hasil_pem_jiwa,
            surat_untuk:surat_untuk
          
            },
          success: function(data){
            window.open("<?php echo site_url("irj/rjcpelayanan/cetak_surat_kesehatan_jiwa/".$no_register)?>","_blank");window.focus();
            $("#MyModalSuratJiwa").modal('hide');
          },
        error:function(event, textStatus, errorThrown) {
                // document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
                // document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          },
          timeout: 0
      });
    }else{
      alert('Tanggal harus diisi');
    }
   
  } 

// surat keterangan narkoba

  function insert3(){
      console.log($('#MyModalSuratNarkoba').serialize());
      var noreg = "<?php echo $no_register; ?>";
      var pemeriksaan_narkoba = $('input[name=pemeriksaan_narkoba]:checked').val();
      
      document.getElementById("submit_add3").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'irj/rjcpelayanan/cetak_surat_keterangan_st_narkoba/';?>",
        // dataType: "JSON",
          data:{
            no_register:noreg, 
            pemeriksaan_narkoba:pemeriksaan_narkoba 
           
          
            },
          success: function(data){
            window.open("<?php echo site_url("irj/rjcpelayanan/cetak_suket_bebas_narkoba/".$no_register)?>","_blank");window.focus();
            $("#MyModalSuratNarkoba").modal('hide');
          },
        error:function(event, textStatus, errorThrown) {
                // document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
                // document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          },
          timeout: 0
      });
    } 

//     function pilih_tindakan(tindakan) {
// 	//alert(tindakan);	
// 	if(tindakan!=''){
// 		var result = tindakan.split('@');
// 		var id_tindakan = result[0];
		
// 		if(id_tindakan.substring(0,2)=='1B') {
// 			$("#dokterDiv").hide();
// 			document.getElementById("id_dokter").required = false;
// 		} else {
// 			$("#dokterDiv").hide();
// 			document.getElementById("id_dokter").required = true;
// 		}
		
// 		$.ajax({
// 			type:'POST',
// 			dataType: 'json',
// 			url:"<?php echo base_url('irj/rjcpelayanan/get_biaya_tindakan')?>",
// 			data: {
// 				id_tindakan: id_tindakan,
// 				kelas : "<?php echo $kelas_pasien ?>",
//         cara_bayar : "<?php echo $cara_bayar ?>"
// 			},
// 			success: function(data){
// 				//alert(data);
// 				$('#biaya_tindakan').val(data[0]);
// 				$('#biaya_tindakan_hide').val(data[0]);
//         if(data[1] == '' || data[1] == null){
//           $('#biaya_alkes').val(0);
// 				  $('#biaya_alkes_hide').val(0);
//           vtot = parseInt(data[0])+parseInt(0);
//         }else{
//           $('#biaya_alkes').val(data[1]);
// 				  $('#biaya_alkes_hide').val(data[1]);
//           vtot = parseInt(data[0])+parseInt(data[1]);
//         }				
// 				$('#qtyind').val(1);

				
// 				$('#vtot').val(vtot);
// 				$('#vtot_hide').val(vtot);
// 			},
// 			error: function(xhr, status, error) {
// 				alert(xhr.responseText);
// 			}
// 	    });
// 	}else
// 		document.getElementById("id_dokter").required = true;
	
	
// }

// $("#form_add_tindakan").submit(function(event) {
// 	    document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
// 	    $.ajax({
// 	        type: "POST",
// 	        url: "<?php echo base_url().'irj/rjcpelayanan/insert_tindakan'; ?>",
// 	        dataType: "JSON",
// 	        data: $('#form_add_tindakan').serialize(),
// 	        success: function(data){   
// 			    if (data == true) {
// 			    	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
// 			    	$("#prop").val("").change();
// 			    	$("#id_dokter").prop("selected", false).change();
// 			    	$('#form_add_tindakan')[0].reset();
//             tabeltindakan(no_register);
//             // table_diagnosa.ajax.reload(); 

            
// 			        swal("Sukses", "Tindakan berhasil disimpan.", "success");
// 			    } else {
// 			    	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
// 					swal("Error", "Gagal menginput tindakan. Silahkan coba lagi.", "error");	        	
// 			    }
// 	        },
// 	        error:function(event, textStatus, errorThrown) { 
// 	        	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
// 	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
// 	        },
// 	        timeout: 0
// 	    });
// 	  event.preventDefault();
// 	});

function hapus() {
		swal({
			title: "",
			text: "MOHON REFRESH HALAMAN",
			type: "success",
			showConfirmButton: true,
			showCancelButton: false,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function () {
			// window.location.reload();
			window.location.reload();
			//location.href = '<?php //echo site_url('rad/radcdaftar');?>';
		});
	}

  $(document).ready(function() {
    // Fokus otomatis pada input pencarian saat dropdown terbuka
    $('#prop').on('select2:open', function() {
        document.querySelector('.select2-search__field').focus();  // Fokuskan kursor ke input pencarian
    });
  });
</script>
<div class="card m-5">
<div class="card-body">
										<form class="form" id="form_add_tindakan">
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" >Tindakan *</p>
											<div class="col-sm-6">
													
													<!-- <input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
													<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan"> -->
													
														<select id="prop" class="form-control select2" name="idtindakan" onchange="pilih_tindakan(this.value)" style="width:100%;" required>
															<option value="">-Pilih Tindakan-</option>
															<?php 
															foreach($tindakans as $row){
															
																  echo '<option value="'.$row->idtindakan.'@'.$row->nmtindakan.'">'.$row->nmtindakan.' | '.$row->tmno.' | '.'Rp. '.number_format($row->tarif, 2 , ',' , '.' ).'</option>';
                                
															}
															?>
														</select>
											</div>
										</div> <!-- end form group row -->

                    <div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_qtyind">Jenis</p>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="kualifikasi_tind" id="kualifikasi_tind">
											</div>
										</div>


										<!-- <div class="form-group row" id="dokterDiv" hidden>
											<p class="col-sm-2 form-control-label" id="label_dokter">Pelaksana Dokter *</p>
											<div class="col-sm-10">
													
													<select id="id_dokter" class="form-control select2" name="id_dokter" style="width:100%;" >
														<option value="">-Pilih Pelaksana-</option>
														<?php 
														foreach($dokter_tindakan as $row){
															
                              if ($id_poli == 'BW01') {
                                if($row->id_dokter==$id_dokterrawat){
                                  echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'" selected>'.$row->nm_dokter.'-'.$row->nm_poli.'</option>';
                                }else{
                                  echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'-'.$row->nm_poli.'</option>';
                                }  
                              }else{
                                if($row->id_dokter==$id_dokterrawat){
                                  echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'" selected>'.$row->nm_dokter.'</option>';
                                }else{
                                  echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';
                                }
                              }
															
															
														}
														
														?>
													</select>
											</div>
										</div>   -->

										<!-- <div class="form-group row" id="perawatDiv">
											<p class="col-sm-2 form-control-label" id="label_perawat">Pelaksana Perawat *</p>
											<div class="col-sm-10">
													
													<select id="id_perawat" class="form-control select2" name="id_perawat" style="width:100%;" >
														<option value="">-Pilih Pelaksana-</option>
														<?php 
														foreach($perawat_tindakan as $row){															
                              echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';	
														}
														
														?>
													</select>
											</div>
										</div> -->

                    <!-- <div class="form-group row">
                      <p class="col-sm-2 form-control-label" id="nmdokter">Jam Tindakan *</p>
                      <div class="col-sm-10">
                        <div class="form-inline">
                          <div class="form-group">
                                    <div class='input-group clockpicker' >
                              <input type="text" class="form-control"  name="jam_tindakan" required="" autocomplete="off">
                              <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                            </div>
                          </div>
                                 <div class="form-group">
                                    <div class='input-group date' id='jadwal_operasi'>
                                        <input type='text' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div> 
                        </div>
                      </div>
                    </div> -->

                    <!-- pelaksana by login -->
                    <!-- <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pelaksana</label>
                        <div class="col-md-6">
                           
                        <input type="text" class="form-control"  id="PelaksanaTindakan" value="<?= $users->name ?>" disabled>
                        <input type="hidden" class="form-control" name="operatorTindakanId"  value="<?= $users->userid ?>">
                        <input type="hidden" class="form-control" name="operatorTindakanName"  value="<?= $users->name ?>">
                        </div>
                    </div><br> -->

                    <div class="form-group row" id="dokterDiv">
                      <label class="col-md-2 col-form-label">Pelaksana</label>
                      <div class="col-md-6">
                        <select class="select2 form-control" name="pelaksana" id="pelaksana" required >
                          <option value="">-Pilih Pelaksana-</option>
                          <?php foreach($users as $r){
                            echo '<option value="'.$r->userid.'-'.$r->username.'">'.$r->name.'</option>';
                          } ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row" id="dokterDiv">
                      <label class="col-md-2 col-form-label">Asisten Pelaksana</label>
                      <div class="col-md-6">
                        <select class="select2 form-control" name="asis_pelaksana" id="asis_pelaksana"  >
                          <option value="">-Pilih Asisten Pelaksana-</option>
                          <?php foreach($users as $r){
                            echo '<option value="'.$r->userid.'-'.$r->username.'">'.$r->name.'</option>';
                          } ?>
                        </select>
                      </div>
                    </div>
										
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
										<div class="form-group row" hidden>
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
                    
                   

                    <br>
										<!--<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_dijamin">Dijamin</p>
											<div class="col-sm-10">
												<input type="text" class="form-control" value="" name="dijamin">
											</div>
										</div>
										-->
										<div class="form-group row" hidden>
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
                      <input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">	
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
										<table id="tabel_tindakan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>No</th>
													<th>Tindakan</th>
                          <th>Jenis</th>
													<th>Pelaksana</th>
                          <th>Asisten</th>
													<th>Biaya Tindakan</th>
													<th>Qtyind</th>
													<th>Total</th>
													<!-- <th>TTD</th> -->
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>			
											</tbody>
										</table>
											</div>
									<div class="pull-right">
                  <a href="<?php echo site_url('irj/rjcpelayananfdokter/form/assesment_medik_dok/'.$id_poli.'/'.$no_register); ?>" target="_self" class="btn btn-danger">Kembali Ke CPPT</a>
									</div>
								
					
                  <!-- SURAT KETERANGAN SEHAT -->
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
                                            <label for="nama" class="col-2 col-form-label">Jenis Kelamin</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->sex;?>">
                                            </div>
                                          </div>  

                                          <div class="form-group row">
                                            <label for="tgllhr" class="col-2 col-form-label">Umur</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" disabled="true" value="<?php echo $data_pasien_daftar_ulang->tgl_lahir;?>">
                                            </div>
                                          </div> 

                                          <div class="form-group row">
                                            <label for="tgllhr" class="col-2 col-form-label">Pekerjaan</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" disabled="true" value="<?php echo $data_pasien_daftar_ulang->pekerjaan;?>">
                                            </div>
                                          </div> 

                                          <div class="form-group row">
                                            <label for="almt" class="col-2 col-form-label">Alamat</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="alamat" name="alamat" disabled="true" value="<?php echo $data_pasien_daftar_ulang->alamat;?>">
                                            </div>
                                          </div>  

                                          <div class="form-group row">
                                            <label for="almt" class="col-2 col-form-label">Berat Badan</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="bb" name="bb"  value="<?= isset($get_suket->bb)?$get_suket->bb:'' ?>" ></input>
                                            </div>
                                          </div> 

                                          <div class="form-group row">
                                            <label for="almt" class="col-2 col-form-label">Tinggi Badan</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="tb" name="tb"  value="<?= isset($get_suket->tb)?$get_suket->tb:'' ?>">
                                            </div>
                                          </div> 

                                          <div class="form-group row"> 
                                          <p style="margin-left:15px">Kondisi Pasien</label>&nbsp;&nbsp;
                                          <div class="col-md-6 col-sm-6">
                                            <div class="input-group primary">
                                              <input name="kondisi_pasien" type="radio"  id="sehat"  class="with-gap" value="Sehat"  <?php echo isset($get_suket->kondisi_pasien)? $get_suket->kondisi_pasien == "Sehat" ? "checked":'':'' ?>/>
                                              <label for="sehat">Sehat</label>&nbsp;&nbsp;
                                              <input name="kondisi_pasien" type="radio"  id="tidak_sehat"  class="with-gap" value="Tidak Sehat" <?php echo isset($get_suket->kondisi_pasien)? $get_suket->kondisi_pasien == "Tidak Sehat" ? "checked":'':'' ?>/>
                                              <label for="tidak_sehat">Tidak Sehat</label>&nbsp;&nbsp;
                                            </div>
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
                             
                    
                     <!-- SURAT KETERANGAN SEHAT JIWA -->
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
                                      
                              
                                            <label for="nama" class="col-2 col-form-label">Nama</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->nama;?>">
                                            </div>
                                          

                                        
                                            <label for="nama" class="col-6 col-form-label">Jenis Kelamin</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->sex;?>">
                                            </div>
                                         

                                         
                                            <label for="almt" class="col-6 col-form-label">Alamat</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="alamat" name="alamat" disabled="true" value="<?php echo $data_pasien_daftar_ulang->alamat;?>">
                                            </div>

                                            <label for="almt" class="col-6 col-form-label">Surat digunakan untuk</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="surat_untuk" name="surat_untuk"  value="<?= isset($get_suket->surat_untuk)?$get_suket->surat_untuk:'' ?>">
                                            </div>
                                         

                                         
                                            <label for="almt" class="col-6 col-form-label">Pemeriksaan</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="pemeriksaan_jiwa" name="pemeriksaan_jiwa"  value="<?= isset($get_suket->pemeriksaan_jiwa)?$get_suket->pemeriksaan_jiwa:'' ?>" ></input>
                                            </div>
                                         

                                         
                                            <label for="almt" class="col-2 col-form-label">Tanggal</label>
                                            <div class="col-10">
                                            <input type="date" id="tgl_hasil_jiwa" class="form-control"  name="tgl_hasil_jiwa" value="<?= isset($get_suket->tgl_hasil_jiwa)?date('Y-m-d',strtotime($get_suket->tgl_hasil_jiwa)):'' ?>" required>
                                            </div>
                                         

                                         
                                            <label for="almt" class="col-2 col-form-label">Hasil</label>
                                            <div class="col-sm-10">
                                        
                                                  <textarea class="form-control" rows="5" cols="60" name="hasil_pem_jiwa" id="hasil_pem_jiwa" value=""><?= isset($get_suket->hasil_pem_jiwa)?$get_suket->hasil_pem_jiwa:'' ?></textarea>
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


                    <!-- SURAT NARKOBA-->

                    <div class="modal" id="MyModalSuratNarkoba" tabindex="-1" role="dialog" aria-labelledby="MyModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel1">Data Surat Keterangan </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>

                                <div class="modal-body">
                                  <div id="alert-modal-edit"></div>  
                                    <form class="form-horizontal" id="form_add"> 
                                      
                              
                                            <label for="nama" class="col-2 col-form-label">Nama</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->nama;?>">
                                            </div>
                                          

                                        
                                            <label for="nama" class="col-6 col-form-label">Jenis Kelamin</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->sex;?>">
                                            </div>
                                         

                                         
                                            <label for="almt" class="col-6 col-form-label">Alamat</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="alamat" name="alamat" disabled="true" value="<?php echo $data_pasien_daftar_ulang->alamat;?>">
                                            </div>

                                            <label for="almt" class="col-6 col-form-label">Pekerjaaan</label>
                                            <div class="col-10">
                                              <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" disabled="true"  value="<?= isset($data_pasien_daftar_ulang->pekerjaan)?$data_pasien_daftar_ulang->pekerjaan:'' ?>">
                                            </div>

                                            
                                           
                                            <p style="margin-left:15px">Hasil Pemeriksaan</label>&nbsp;&nbsp;
                                            <div class="col-md-8 col-sm-8">
                                              <div class="input-group primary">
                                                <input name="pemeriksaan_narkoba" type="radio"  id="terdapat"  class="with-gap" value="Terdapat"  <?php echo isset($get_suket->pemeriksaan_narkoba)? $get_suket->pemeriksaan_narkoba == "Terdapat" ? "checked":'':'' ?>/>
                                                <label for="terdapat">Terdapat</label>&nbsp;&nbsp;
                                                <input name="pemeriksaan_narkoba" type="radio"  id="tidak_terdapat"  class="with-gap" value="Tidak Terdapat" <?php echo isset($get_suket->pemeriksaan_narkoba)? $get_suket->pemeriksaan_narkoba == "Tidak Terdapat" ? "checked":'':'' ?>/>
                                                <label for="tidak_terdapat">Tidak Terdapat</label>&nbsp;&nbsp;
                                              </div>
                                            </div>
                                       
                                         

                                         
                                           

                                          
                                      
                                      
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>  
                                    <button type="button" class="btn btn-primary" id="submit_add3" onclick="insert3()"><i class="fa fa-floppy-o"></i>Cetak</button>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  </div>