<div class="row">
    <div class="col-12">
    	<div class="row">
		    <div class="col-sm-12">
		        <div class="ribbon-wrapper card">
		            <div class="ribbon ribbon-info">Detail Transaksi
					
		            </div>
						<div class="ribbon-content">
							<div class="p-20">
								<div class="row">
									<!-- <?php
											$foto_link = site_url("upload/photo/unknown.png") ;
											echo'
											<div class="col-sm-2 text-center">
											<img height="100px" class="img-rounded" src="'.$foto_link.'">
											</div>';
									?>	 -->
									<div class="col-sm-12">
										<table class="table-sm table-striped" style="font-size:15" width="100%">
										  <tbody>
										  <tr>
												<th>Id Receiving</th>
												<td>:&nbsp;</td>
												<td><?php echo $id_receiving;?></td>
											</tr>
										  	<tr>
												<th>DO / FAKTUR</th>
												<td>:&nbsp;</td>
												<td><?php echo $do_faktur;?></td> 
												<!-- <td><button type="button" title="Edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_obat('<?php echo $id_receiving;?>')">Edit</button><td> 	 -->
											</tr>

											<tr>
												<th>No Faktur</th>
												<td>:&nbsp;</td>
												<td><?php echo $no_faktur;?></td>
											</tr>
											<tr>
												<th>No DO</th>
												<td>:&nbsp;</td>
												<td><?php echo $no_do;?></td>
											</tr>
											<tr>
												<th>PBF</th>
												<td>:&nbsp;</td>
												<td><?php echo $nm_supplier;?></td>
											</tr>
											<tr>
												<th>Tanggal DO/Faktur</th>
												<td>:</td>
												<td><?php echo $tgl_kontra_bon;?></td>
											</tr>
											
											<tr>
												<th>Tgl Jatuh Tempo</th>
												<td>:&nbsp;</td>
												<td><?php echo $jatuh_tempo;?></td>
											</tr>

											<tr>
												<th>Tgl Penerimaan Barang</th>
												<td>:&nbsp;</td>
												<td><?php echo $diterima_barang;?></td>
											</tr>

											<tr>
												<th>Keterangan</th>
												<td>:&nbsp;</td>
												<td><?php echo $comment;?></td>
											</tr>
											<tr>
												<th>Status</th>
												<td>:&nbsp;</td>
												<td><?php echo $status;?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
		        	</div>
		    	</div>
			</div>
		</div>
	</div>

	<form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModal"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <p class="col-sm-6 form-control-label">Id Receiving</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_id_rec" id="edit_id_rec" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_rec_hidden" id="edit_id_rec_hidden">
                      </div>
                    </div> 

					<div class="form-group row">
                      <p class="col-sm-6 form-control-label">No Faktur</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_no_faktur" id="edit_no_faktur">
                      </div>
                    </div> 


					<div class="form-group row">
                      <p class="col-sm-6 form-control-label">No DO</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_no_do" id="edit_no_do">
                      </div>
                    </div> 
    
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-edit">Edit</button>
                  </div>
                </div>
              </div>
            </div>
          </form>

<script>
	function edit_obat(id_rec) {
    		console.log(id_rec)
		$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('logistik_farmasi/Frmcpembelian/get_data_header_pembelian')?>",
		data: {
			id_rec: id_rec
		},
		success: function(data){
			//console.log(data);
			$('#edit_id_rec_hidden').val(data[0].receiving_id);
			$('#edit_id_rec').val(data[0].receiving_id);
			$('#edit_no_do').val(data[0].no_do);
			$('#edit_no_faktur').val(data[0].no_faktur);
		
		},
		error: function(){
			alert("error");
		}
		});
  }

  $('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>logistik_farmasi/Frmcpembelian/update_header_pembelian",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Obat';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									window.location.reload();
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit Obat';
            $('#editModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      }); 
</script>
