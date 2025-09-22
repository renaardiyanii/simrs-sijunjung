<?php 
$this->load->view('layout/header_form');
?>
<script>
	$(document).ready(function(){
		$('.data-tindakan').DataTable({});
		// $("#edit_pelaksana").select2({
		// 	dropdownParent: $("#editModal")
		// });
		$('#edit_pelaksana').select2({
			dropdownParent: $("#editModal")
		});

		$('#pelaksana').select2();
		$('#prop').select2();

		$("#edit_form").submit(function(event) {
			document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'iri/rictindakan/edit_tindakan'; ?>",
				dataType: "JSON",
				data: $('#edit_form').serialize(),
				success: function(data){
					if (data == true) {
						document.getElementById("btn-edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
						// $('#form_add_tindakan')[0].reset();
						// tabeltindakan(id_pemeriksaan);
						// swal("Sukses", "Tindakan berhasil disimpan.", "success");
						window.location.reload();
					} else {
						document.getElementById("btn-edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
						swal("Error", "Gagal menginput tindakan. Silahkan coba lagi.", "error");
					}
				},
				error:function(event, textStatus, errorThrown) {
					document.getElementById("btn-edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				},
				timeout: 0
			});
		event.preventDefault();
		});
	})

	function pilih_tindakan(val) {
		var temp = val.split("-");
		var cara_bayar = "<?= $data_pasien[0]['carabayar'] ?>";
		temp[1] = (temp[1] == "" ? 0 : temp[1]);
		temp[3] = (temp[3] == "" ? 0 : temp[3]);
		$('#biaya_tindakan').val(temp[1]);
		$('#biaya_tindakan_hide').val(temp[1]);
		$('#paket').val(temp[2]);
		var qty = $('#qtyind').val();
		var total = ((parseInt(qty) * (parseInt(temp[1]) + parseInt(temp[3]))));
		$('#vtot').val(total);
	}

function edit(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/rictindakan/get_data_edit_tindakan')?>",
      data: {
        id: id
      },
      success: function(data){
        //console.log(data);
        $('#edit_tindakan').val(data[0].nmtindakan);
		$('#edit_id_hidden').val(data[0].id_jns_layanan);
		$('#edit_qty').val(data[0].qtyyanri);
		$('#edit_pelaksana').val(data[0].idoprtr+'-'+data[0].xuser).trigger("change");
      },
      error: function(){
        alert("error");
      }
    });
}
</script>
<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid">
            <h5>Tambah Tindakan</h5>
        </div>
    </div>
	<div class="card-body">	
		<div class="row">
			<div class="col-sm-12"> 								
				<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_tindakan'); ?>" method="post">
					<div class="form-group row mb-4">
						<label for="prop" class="col-md-2 col-form-label">Tindakan</label>
						<div class="col-md-6">
							<select id="prop" class="select2 form-control" name="idtindakan" id="idtindakan" onchange="pilih_tindakan(this.value)" required >
								<option value="">-Pilih Tindakan-</option>
								<?php foreach($list_tindakan as $r){?>	
									<?php if($data_pasien[0]['carabayar'] == 'KERJASAMA') { ?>
										<option value="<?php echo $r['idtindakan'].'-'.$r['tarif_iks'].'-'.$r['paket'].'-'.$r['tarif_alkes'] ; ?>"><?php echo $r['idtindakan']." - ".$r['nmtindakan']." | Rp.".number_format($r['tarif_iks'], 2 , ',' , '.' );?></option>;
									<?php
									} else { ?>
										<option value="<?php echo $r['idtindakan'].'-'.$r['total_tarif'].'-'.$r['paket'].'-'.$r['tarif_alkes'] ; ?>"><?php echo $r['idtindakan']." - ".$r['nmtindakan']." | Rp.".number_format($r['total_tarif'], 2 , ',' , '.' );?></option>;
									<?php
									} 
									?>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row mb-4">
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
					<!-- <div class="form-group row mb-4">
						<label class="col-md-2 col-form-label">Pelaksana</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  id="PelaksanaTindakan" value="<?= $user->name ?>" disabled>
							<input type="hidden" class="form-control" name="operatorTindakanId"  value="<?= $user->userid ?>">
							<input type="hidden" class="form-control" name="operatorTindakanName"  value="<?= $user->name ?>">
						</div>
					</div> -->
					
					<div class="form-group row mb-4">
						<label class="col-md-2 col-form-label">Waktu Tindakan</label>
						<div class="col-md-6">
							<div class=' date' id='tgl_tindakan'>
								<input type="datetime-local" id="tgl_tindakan" class="form-control" placeholder="Tanggal Tindakan" name="tgl_tindakan" value="<?php echo date("Y-m-d H:i:s") ?>" required="">
							</div>
						</div>
					</div>
					
					<div class="form-group row mb-4">
						<label class="col-md-2 col-form-label">Biaya Tindakan</label>
						<div class="col-md-6">
							<div class='input-group' >
								<span class="input-group-text">
									<span>Rp</span>
								</span>
								<input type="number" min=0 class="form-control"  name="biaya_tindakan" id="biaya_tindakan" disabled>
								<input type="hidden" class="form-control" name="biaya_tindakan_hide" id="biaya_tindakan_hide">
							</div>
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-md-2 col-form-label">Biaya Alkes</label>
						<div class="col-md-6">
							<div class='input-group' >
								<span class="input-group-text">
									<span>Rp</span>
								</span>
								<input type="number" min=0 class="form-control"  name="biaya_alkes" id="biaya_alkes" value= 0 disabled>
								<input type="hidden" class="form-control" name="biaya_alkes_hide" value = 0 id="biaya_alkes_hide">
							</div>
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-md-2 col-form-label">Qty</label>
						<div class="col-md-6">
							<input type="number" class="form-control" value="1" name="qtyind" id="qtyind" min=1 onchange="set_total(this.value)">
						</div>
					</div>	
					<div class="form-group row mb-4">
						<label class="col-md-2 col-form-label">Total</label>
						<div class="col-md-6">
							<div class='input-group' >
								<span class="input-group-text">
									<span>Rp</span>
								</span>
								<input type="text" class="form-control" name="vtot" id="vtot" disabled>	
								<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
							</div>	
						</div>
					</div>	
					<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
					<input type="hidden"  name="harga_satuan_jatah_kelas" id="harga_satuan_jatah_kelas" />
					<input type="hidden"  name="paket" id="paket" />
					<div class="form-group row">
						<div class="offset-md-2 col-md-10">
							<button type="reset" class="btn btn-danger">Reset</button>
							<button type="submit" class="btn btn-primary">Tambah</button>
						</div>
					</div>								
				</form>
			</div>
		</div>
	</div>
</div>

<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid">
            <h5>List Tindakan</h5>
        </div>
    </div>
	<div class="card-body">
		<table class="data-tindakan table table-hover table-striped table-bordered data-table" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Tanggal</th>
				<th>Tindakan</th>
				<th>Pelaksana</th>
				<th>Biaya Tindakan</th>
				<th>Biaya Alkes</th>
				<th>Qtyind</th>
				<th>Total</th>
				<th>TTD</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
				foreach($list_tindakan_pasien as $r){
			?>
				<tr>
					<td><?php echo $r['tgl_layanan'] ; ?></td>
					<td><?php echo $r['nmtindakan'] ; ?></td>
					<td><?php echo $r['nm_pelaksana'] ; ?></td>
					<td>Rp. <?php echo number_format($r['tumuminap'] - $r['harga_satuan_jatah_kelas'],0) ; ?></td>
					<td>Rp. <?php echo number_format($r['tarifalkes'],0) ; ?></td>
					<td><?php echo $r['qtyyanri'] ; ?></td>
					<td>Rp. <?php echo number_format($r['vtot'] - $r['vtot_jatah_kelas'] + $r['tarifalkes'],0) ; ?></td>
					<td>
						<?php 
							echo '<img src="'.$r['ttd_pelaksana'].'" alt="" width="50px" height="50px"/> ';
						?>
					</td>
					<td>
						<a href="<?php echo base_url(); ?>iri/rictindakan/hapus_tindakan_temp/<?php echo $r['id_jns_layanan'] ;?>/<?php echo $data_pasien[0]['no_ipd'];?>" class="btn btn-danger btn-xs">Hapus</a>
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="edit(<?php echo $r['id_jns_layanan'] ; ?>)">Edit</button>
					</td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
	<div class="card-footer">
		<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_tindakan_real'); ?>" method="post">
			<div class="form-inline" align="right" style="padding-right:20px;">
				<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>

<form method="POST" id="edit_form" class="form-horizontal">
    <!-- Modal Edit Obat -->
    <div class="modal fade"  id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Tindakan</h4>
                </div>
                <div class="modal-body">
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Tindakan</p>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="edit_tindakan" id="edit_tindakan" disabled="">
							<input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
							<!-- <input type="hidden" class="form-control" name="id_pemeriksaan_hide" id="id_pemeriksaan_hide"> -->
						</div>
                  	</div><br>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Pelaksana</p>
						<div class="col-sm-8">
                            <select name="edit_pelaksana" id="edit_pelaksana" class="form-control select2" style="width: 80%;">
                                <option value="">-- Pilih Pelaksana --</option>
                                <?php 
                                foreach($users as $row) {
                                    echo '<option value="'.$row->userid.'-'.$row->username.'">'.$row->name.'</option>';
                                }
                                ?>
                            </select>
						</div>
                  	</div><br>
                      <div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Qty</p>
						<div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_qty" id="edit_qty">
						</div>
                  	</div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>