<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<script type='text/javascript'>
	$(function() {
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();

		$('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>piutang/cperusahaan/tambah_saldo",                         
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
	} );

// 	function tambah_saldo(id) {
//     $.ajax({
//       type:'POST',
//       dataType: 'json',
//       url:"<?php echo base_url('piutang/cperusahaan/get_data_edit_obat')?>",
//       data: {
//         id: id
//       },
//       success: function(data){
//         $('#id_kontraktor').val(data[0].id_obat);
//       },
//       error: function(){
//         alert("error");
//       }
//     });
//   }
	
</script>
<section class="content">
	<div class="row">				
		<div class="card" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title">Daftar Pasien <?= $nm_perusahaan ?> Tanggal <?= $date1 ?> s/d <?= $date2 ?></h3>			
			</div>
			<div class="card-block">
				<hr>
				<br/>
				
					<table id="tabel_kwitansi" class="display table table-hover table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
                              <th>No</th>
							  <th>No Medrec</th>
							  <th>No Register</th>
							  <th>Tgl Kunjungan</th>
							  <th>Nama</th>
							  <th>Total Tagihan</th>
                              <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
							<?php
							//  print_r($pasien_piutang);
							$total_tagihan=0;
							$i=1;
							foreach($list_pasien as $row){
						?>
							<tr>
                              <td><?php echo $i++;?></td>
                              <td><?php echo $row->no_medrec;?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo date('d-m-Y',strtotime($row->tgl_kunjungan));?></td>
							  <td><?php echo $row->nama;?></td>
							  <?php 
							 	$tagihan_pasien =  $row->biaya_poli + $row->biaya_lab + $row->biaya_rad + $row->biaya_em + $row->biaya_ok + $row->biaya_resep;
							  ?>
							  <td><?php echo number_format($tagihan_pasien, 2 , ',' , '.' );?></td>
							  <td>
									<a href="<?php echo site_url('piutang/cperusahaan/pasien_lunas/'.$row->no_register.'/'.$id_kontraktor.'/'.$date1.'/'.$date2); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i>Lunas</a>
							  </td>
							</tr>
						<?php
							$total_tagihan += $tagihan_pasien;
							}
						?>
						</tbody>
					</table>

					<table class="table table-hover table-striped table-bordered">
						<!-- <tr>
							<th style="width:20%;">Total Saldo</th>
							<td>:</td>
							<td style="width:40%;">
								<div class="input-group">
									<span class="input-group-addon">Rp</span>
									<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" value="<?php echo number_format($saldo->saldo, 2 , ',' , '.' ) ?>" readonly>&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" title="Edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal">Tambah Saldo</button>
								</div>
							</td>
							<td style="width:40%;"></td>
						</tr> -->
						<tr>
							<th style="width:20%;">Total Tagihan</th>
							<td>:</td>
							<td style="width:40%;">
								<div class="input-group">
									<span class="input-group-addon">Rp</span>
									<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" value="<?php echo number_format($total_tagihan, 2 , ',' , '.' )  ?>" readonly> &nbsp;&nbsp;&nbsp;&nbsp;
									<a href="<?php echo site_url('piutang/cperusahaan/cetak_tagihan/'.$id_kontraktor.'/'.$date1.'/'.$date2); ?>" class="btn btn-primary btn-sm" target = "_blank">Cetak Tagihan</a>
								</div>
							</td>
							<td style="width:40%;"></td>
						</tr>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
			</div><!-- /panel body -->
        </div><!-- /.box-body -->
	
</section>


		<form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModal"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Saldo</h4>
                  </div>
                  <div class="modal-body">

                  <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label">Saldo</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="saldo" id="saldo">
						<input type="hidden" class="form-control" name="id_kontraktor" id="id_kontraktor" value="<?php echo $id_kontraktor ?>">
                      </div>
                    </div>

				</div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-edit">Save</button>
                  </div>
                </div>
              </div>
            </div>
          </form>

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>
