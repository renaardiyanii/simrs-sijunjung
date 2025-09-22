<?php
$this->load->view('layout/header_form');
include('script_rjvpelayanan.php');
?>
<script>
//     function set_utama_diagnosa(id_diagnosa_pasien) {
// 	$.ajax({
//         type: "POST",
//         url: "<?php echo site_url('irj/diagnosa/set_utama')?>",
//         dataType: "JSON",
//         data: {"id_diagnosa_pasien" : id_diagnosa_pasien,"no_register" : '<?php echo $no_register ?>'},
               
     
//         success: function(result){   
//           if (result) {  
//             new swal("Sukses", "Diagnosa berhasil di set utama.", "success");
          
//             $('#id_procedure').val('');
//             $('#procedure_text').val('');
//             table_diagnosa.ajax.reload();          

                 
//           } 
//           else{
//             new swal("Error", "Gagal men-set utama Diagnosa. Silahkan coba lagi.", "error");
//             table_diagnosa.ajax.reload();   
//           }
//         },
//         error:function(event, textStatus, errorThrown) { 
//           new swal("Gagal men-set Utama Diagnosa", textStatus, "error");          
//           console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
//         }
//     });
    
// }

// function delete_diagnosa(id) {  

// 	$.ajax({
//         type: "POST",
// 		url: "<?php echo base_url().'irj/diagnosa/delete'; ?>",
//         dataType: "JSON",
// 		data: {"id_diagnosa_pasien" : id,"no_register" : '<?php echo $no_register ?>'},                            
     
//         success: function(result){   
//           if (result) {  
//             new swal("Sukses", "Diagnosa berhasil dihapus.", "success");
          
//             $('#id_procedure').val('');
//             $('#procedure_text').val('');
// 			table_diagnosa.ajax.reload();
       

                 
//           } 
//           else{
//             new swal("Error", "Diagnosa Gagal dihapus.", "warning");
//             $('#id_procedure').val('');
//             $('#procedure_text').val('');
// 			table_diagnosa.ajax.reload();
   
//           }
//         },
//         error:function(event, textStatus, errorThrown) { 
//           new swal("Gagal menghapus procedure", textStatus, "error");          
//           console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
//         }
//     });


      
// }

</script>
<div class="card m-5">
<div class="card-body">
<div class="p-20">
									<?php if($id_poli == 'BH00' || $id_poli == 'BH03') { ?>
										<a class="btn btn-success" href=" <?php echo site_url('irj/rjcpelayananfdokter/form/asesmen_medik_dok_mata/'.$id_poli.'/'.$no_register); ?>"><i class="fa fa-binoculars">&nbsp; kembali</i> </a>&nbsp;&nbsp;&nbsp;
									<?php } else { ?>
										<a class="btn btn-success" href=" <?php echo site_url('irj/rjcpelayananfdokter/form/assesment_medik_dok/'.$id_poli.'/'.$no_register); ?>"><i class="fa fa-binoculars">&nbsp; kembali</i> </a>&nbsp;&nbsp;&nbsp;
									<?php } ?>
											<div class="form-group row">
												<label for="id_procedure" class="col-3 col-form-label">Prosedur (ICD-9-CM)</label>
												<div class="col-9">
														<input type="text" class="form-control input-sm autocomplete_procedure"  name="id_procedure" id="id_procedure" style="max-width:450px;font-size:15px;">
														<input type="hidden" class="form-control " name="procedure_separate" id="procedure_separate">
												</div>
											</div><br>
											<div class="form-group row">
												<label for="procedure_text" class="col-3 col-form-label" id="catatan">Catatan</label>
												<div class="col-9">
														<textarea class="form-control" name="procedure_text" id="procedure_text" cols="30" rows="5" style="resize:vertical"></textarea>
												</div>
											</div><br>
											<div class="form-group row">
												<div class="offset-sm-3 col-sm-9">	
														<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
														<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
														<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
														<input type="hidden" name="tgl_kunjungan" value="<?php echo $tgl_kunjungan;?>">
														<!-- <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button> -->
														<button type="button" class="btn btn-primary" id="btn-procedure" onclick="insert_procedure()"><i class="fa fa-floppy-o"></i> Simpan</button>								
												</div>
											</div>		

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
										</div>
                                    </div>
</div>
</div>