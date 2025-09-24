<?php
	$this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
	//-----------------------------------------------Data Table
	$(document).ready(function() {
	    var objTable;

        objTable = $('#example2').DataTable( {
            ajax: "<?php echo site_url('farmasi/frmcdaftar/get_data_pasien'); ?>",
            columns: [
                { data: "no" },
                { data: "tgl_kunjungan" },
                { data: "no_cm" },
                { data: "no_register" },
                { data: "nama" },
                { data: "kelas" },
                { data: "idrg" },
                { data: "bed" },
                { data: "cara_bayar" },
                { data: "antrian" },
                { data: "aksi" }
            ],
            columnDefs: [
                { targets: [ 0 ], visible: true }
            ] ,
            searching: true,
            paging: true,
            bDestroy : true,
            bSort : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );

        $("#find_by_date").click(function () {
            var tgl = $("#date_picker").val();

            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { tgl: tgl },
                url: "<?php echo site_url('farmasi/frmcdaftar/get_data_pasien'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });
        });

        $("#find_by_noreg").click(function () {
            var key = $("#key").val();

            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { key: key },
                url: "<?php echo site_url('farmasi/frmcdaftar/get_data_pasien_noreg'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });
        });

	} );
	//---------------------------------------------------------

	$(function() {
		$('.auto_cek_obat').autocomplete({
			serviceUrl: site+'farmasi/Frmcdaftar/cek_harga_obat',
			onSelect: function (suggestion) {
				$('#nama_obat').val(''+suggestion.nama_obat);
			}
		});
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true
		});  
			
	});
			
	function cek_harga_obat() {
		var nama_obat = document.getElementById("nama_obat").value;
		$.ajax({
			type:'POST',
			url:"<?php echo base_url('farmasi/Frmcdaftar/cek_harga_obat')?>",
			data: {
				nama_obat: nama_obat
			},
			success: function(data){
				//alert(data);
				$('#tablemodal').html("");
				$('#tablemodal').append(data);
			},
			error: function(request, error){
				console.log(arguments);
				alert(error);
			}
	    });
	}

	// Fungsi untuk memanggil antrian farmasi
	function panggilAntrianFarmasi(no_register, no_antrian, nama_pasien) {
		if (confirm('Apakah Anda yakin ingin memanggil antrian ' + no_antrian + ' (' + nama_pasien + ')?')) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url('antrol/panggil_antrian_farmasi'); ?>',
				data: {
					no_register: no_register,
					no_antrian: no_antrian,
					nama_pasien: nama_pasien
				},
				dataType: 'json',
				success: function(response) {
					if (response.success) {
						alert('Berhasil: ' + response.message);
						// Refresh table
						objTable.ajax.reload();
					} else {
						alert('Error: ' + response.message);
					}
				},
				error: function(xhr, status, error) {
					alert('Terjadi kesalahan sistem: ' + error);
				}
			});
		}
	}

	// Fungsi untuk menyelesaikan antrian farmasi
	function selesaiAntrianFarmasi(no_register, no_antrian, nama_pasien) {
		if (confirm('Apakah Anda yakin ingin menyelesaikan antrian ' + no_antrian + ' (' + nama_pasien + ')?')) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url('antrol/selesai_antrian_farmasi'); ?>',
				data: {
					no_register: no_register,
					no_antrian: no_antrian,
					nama_pasien: nama_pasien
				},
				dataType: 'json',
				success: function(response) {
					if (response.success) {
						alert('Berhasil: ' + response.message);
						// Refresh table
						objTable.ajax.reload();
					} else {
						alert('Error: ' + response.message);
					}
				},
				error: function(xhr, status, error) {
					alert('Terjadi kesalahan sistem: ' + error);
				}
			});
		}
	}

</script>
<section class="content-header">
	<?php
		echo $this->session->flashdata('success_msg');
	?>
</section>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 align="center">DAFTAR ANTRIAN PASIEN FARMASI</h3>
			</div>
			<div class="card-block">
				<div class="row p-t-0">
					<div class="col-md-4">
						<div class="form-group">
							<div class="input-group">
								<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit" id="find_by_date">Cari</button>
								</span>
							</div><!-- /input-group -->
						</div><!-- /.col-lg-6 -->
					</div>
					<div class="col-md-4">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" name="key" id="key" placeholder="No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit" id="find_by_noreg">Cari</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->
					</div>

					<div class="col-xs-3" align="right">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#obatModal">Cek Harga Obat</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->
					<!-- Modal -->
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="obatModal">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">Daftar Harga Obat</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control auto_cek_obat" name="nama_obat" id="nama_obat" placeholder="Nama Obat">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit" onclick="cek_harga_obat()">Cari</button>
                                        </span>
                                    </div>
                                    <div class="col-lg-12" id="tablemodal">

                                    </div>
                                </div><br>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

					<div class="col-xs-3" align="right">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Registrasi Pasien Luar</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->
					<!-- Modal -->
					<?php echo form_open('farmasi/Frmcdaftar/daftar_pasien_luar');?>
					<div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog modal-success">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Registrasi Pasien Luar</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="lbl_nama">Nama</p>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="nama" id="nama">
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="lbl_alamat">Alamat</p>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="alamat" id="alamat">
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
									<button class="btn btn-primary" type="submit">Simpan</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo form_close();?>
			<div class="card-block">
			<div class="table-responsive m-t-0">				
				<table id="example2" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal Kunjungan</th>
							<th>No CM</th>
							<th>No Registrasi</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>Id Ruang</th>
							<th>Ruang</th>
							<th>Cara Bayar</th>
							<th>No. Antrian</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						/*$i=1;
						foreach($farmasi as $row){
						$no_register=$row->no_register;*/
						?>
						<!--<tr>
							<td><?php /*echo $i++;*/?></td>
							<td><?php /*echo date('d-m-Y | H:i',strtotime($row->tgl_kunjungan));*/?></td>
							<td><?php /*echo $row->no_cm;*/?></td>
							<td><?php /*echo $row->no_register;*/?></td>
							<td><?php /*echo $row->nama;*/?></td>
							<td><?php /*echo $row->kelas;*/?></td>
							<td><?php /*echo $row->idrg;*/?></td>
							<td><?php /*echo $row->bed;*/?></td>
							<td><?php /*echo $row->cara_bayar;*/?></td>
							<td>
				                <a href="<?php /*echo site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register); */?>" class="btn btn-primary btn-sm">Resep</a>
				                <?php /*$getrdrj=substr($no_register, 0,2);
				                if($getrdrj=='RJ'){*/?>
				                	<a href="<?php /*echo site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register); */?>" class="btn btn-danger btn-sm">Selesai</a>
				                <?php /*} */?>
							</td>
						</tr>-->
						<?php
						//}
						?>
					</tbody>
				</table>						
			</div>
			</div>					
		</div>
	</div>
</div>

<?php
	$this->load->view('layout/footer_left.php');
?>