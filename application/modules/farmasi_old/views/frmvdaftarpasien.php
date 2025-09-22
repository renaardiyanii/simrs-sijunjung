<?php
	$this->load->view('layout/header_left.php');
?>

<style>

    .modal-dialog {
        width: 100%;
        height: 100%;
        padding: 0;
        margin:5px;
    }
    .modal-content {
        width: 275%;
        height: 100%;
        border-radius: 0;
        color:#333;
        overflow:auto;
    }
    .close {
        color:black ! important;
        opacity:1.0;
    }

	.flex{
		display:flex;
	}
	.justify-arround{
		justify-content:space-around;
	}
</style>	
<script type='text/javascript'>
	var site = "<?php echo site_url();?>";
	
	function tableAjaxReload(table) {
			// location.reload();
			
		};
	
	//-----------------------------------------------Data Table
	$(document).ready(function() {
	    // var objTable, tableDetail;

        // objTable = $('#example2').DataTable( {
        //     ajax: "<?php echo site_url('farmasi/frmcdaftar/get_data_pasien'); ?>",
        //     columns: [
		// 		{
		// 			targets: -1,
		// 			data: null,
		// 			render:function(a,b,data,d){
		// 				let tambahanButton = '';
		// 				if(data.jml_resep!= 0){
		// 					tambahanButton +='<button type="button" class="btn btn-danger btn-sm selesai">Selesai</button>';
		// 				}
		// 				let button = `
		// 				<button class="btn btn-primary btn-sm resep">Resep</button><br>
		// 				<button class="btn btn-primary btn-sm telaah">Telaah Obat</button><br>
		// 				<button class="btn btn-primary btn-sm cetak_telaah" style="margin-top:3px;margin-bottom:3px;">Cetak Telaah Resep</button><br>
		// 				`;
		// 				return button+tambahanButton;
		// 			}
		// 		},
        //         { data: "tgl_kunjungan" },
        //         { data: "no_cm" },
        //         { data: "no_register" },
        //         { data: "nama" },
        //         { data: "kelas" },
        //     //    { data: "idrg" },
        //         { data: "bed" },
        //         { data: "cara_bayar" }
        //     ],
        //     columnDefs: [
        //         { targets: [ 0 ], visible: true }
        //     ] ,
        //     searching: true,
        //     paging: true,
        //     bDestroy : true,
        //     bSort : false,
        //     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        // } );

		
		
		// setInterval(()=>objTable.ajax.reload(), 60000);

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

		tableDetail = $('#tableDetail').DataTable({
            columns: [
                { data: "no" },
                { data: "tgl_kunjungan" },
                { data: "nama" },
                { data: "harga" },
                { data: "signa" },
                { data: "qty" },
                { data: "total" }
            ],
            columnDefs: [
                { targets: [ 0 ], orderable: false },
                { targets: [ 1 ], orderable: false },
                { targets: [ 2 ], orderable: false },
                { targets: [ 3 ], orderable: false },
                { targets: [ 4 ], orderable: false },
                { targets: [ 5 ], orderable: false },
                { targets: [ 6 ], orderable: false }
            ],
            bFilter: false,
            bPaginate: true,
            destroy: true
        });

        $('#detailModal').on('shown.bs.modal', function(e) {
            //get data-id attribute of the clicked element

            var no_register = $(e.relatedTarget).data('id');
            var ttd_dokter = $(e.relatedTarget).data('ttd_dokter');
            var ttd_apoteker = $(e.relatedTarget).data('ttd_apoteker');
            var nm_dokter = $(e.relatedTarget).data('nm_dokter');
            var nm_apoteker = $(e.relatedTarget).data('nm_apoteker');
            //tableDetail.clear().draw();
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: {no_register:no_register},
                url: "<?php echo site_url(); ?>farmasi/frmcdaftar/get_data_rekap_detail",
                success: function( response ) {

                    tableDetail.clear().draw();
                    tableDetail.rows.add(response.data);
                    tableDetail.columns.adjust().draw();

                    $("#total_rekap").html(response.total);
                }
            });
        });



		// datatable serverside
		tabel = $('#table-artikel').DataTable({
            "processing": true,
            "responsive":true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 1, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": "<?= base_url('farmasi/frmcdaftardatatable/view_data');?>", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[10, 10, 50],[ 10, 10, 50]], // Combobox Limit
            "columns": [
				{
					targets: -1,
					data: null,
					render:function(a,b,data,d){
						// console.log(data.jml_resep!== null || data.jml_resep !== '0');
						
						let button = `
						<button class="btn btn-primary btn-sm resep">Resep</button><br>
						<button class="btn btn-primary btn-sm telaah">Telaah Obat</button><br>
						<button class="btn btn-primary btn-sm cetak_telaah" style="margin-top:3px;margin-bottom:3px;">Cetak Telaah Resep</button><br>
						`;
						if(parseInt(data.farmasi) == 1){
							button +='<button type="button" class="btn btn-danger btn-sm selesai">Selesai</button>';
						}
						return button;
					}
				},
                { "data": "tgl_kunjungan" }, // Tampilkan judul
                { "data": "no_cm" },  // Tampilkan kategori
                { "data": "no_register" },  // Tampilkan penulis
                { "data": "nama" },  // Tampilkan tgl posting
                { "data": "kelas"},
				{
					'data':'bed'
				},
				{
					'data':'cara_bayar'
				}
            ],
        });

		$('#table-artikel tbody').on('click', 'button.resep', function () {
			var data = tabel.row($(this).parents('tr')).data();
			window.open(`<?= base_url('farmasi/frmcdaftar/permintaan_obat/') ?>/${data.no_register}/PETUGAS`,'_blank');
			
		});
		$('#table-artikel tbody').on('click', 'button.telaah', function () {
			var data = tabel.row($(this).parents('tr')).data();
			window.open(`<?= base_url('farmasi/Frmcdaftar/telaah_obat/') ?>/${data.no_register}`,'_blank');
			
		});
		$('#table-artikel tbody').on('click', 'button.cetak_telaah', function () {
			var data = tabel.row($(this).parents('tr')).data();
			window.open(`<?= base_url('emedrec/C_emedrec/cetak_Eresep_telaah/') ?>/${data.no_cm}/${data.no_register}/PETUGAS`,'_blank');
			
		});

		$('#table-artikel tbody').on('click', 'button.selesai', function () {
			var data = tabel.row($(this).parents('tr')).data();
			$.ajax({
                dataType: "json",
                type: 'POST',
                url: `<?php echo site_url('farmasi/Frmcdaftar/force_selesai/'); ?>/${data.no_register}`,
                success: function( response ) {
					swal({
						title: "Success",
						text: "Berhasil Simpan Data",
						type: "success",
						showConfirmButton: true
					},
					function () {
						tabel.ajax.reload();
					});
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
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true
		// });  
			
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

	function showswal() {
		var base = "<?php echo base_url();?>";
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
			window.open(base+'farmasi/Frmcdaftar/', '_self'); 
		});
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
						<div class="form-group row">
							<div class="">											
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>																			
							</div>
							<div class="input-group-btn">
									<button class="btn btn-primary" type="submit" id="find_by_date">Cari</button>
							</div>
						</div>					
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
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_nama">Nama</p>
										<div class="col-sm-7">
											<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
											<input type="text" class="form-control" name="nama" id="nama">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Usia</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="usia" id="usia">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Jenis Kelamin</p>
										<div class="col-sm-7">
											<select name="jk" id="jk" class="form-control">
												<option value="L">Laki-laki</option>
												<option value="P">Perempuan</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="alamat" id="alamat">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 control-label col-form-label">Tanggal Lahir</p>
										<div class="col-sm-7">
											<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="dokter" id="dokter" placeholder="Isi Jika Ada">
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
				
				<!-- example datatable server side -->
				<table class="table table-striped table-bordered" id="table-artikel">
					<thead>
						<tr>
							<th>Aksi</th>
							<th>Tanggal Kunjungan</th>
							<th>No CM</th>
							<th>No Registrasi</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>Ruang</th>
							<th>Cara Bayar</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

				
				<!-- <table id="example2" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Aksi</th>
							<th>Tanggal Kunjungan</th>
							<th>No CM</th>
							<th>No Registrasi</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>Ruang</th>
							<th>Cara Bayar</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>						 -->
			</div>
			</div>					
		</div>
	</div>
</div>

<div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-default" >

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Resep</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body table-responsive m-t-0">
                    <div class="form-group flex  justify-arround">
                        <div class="form-group">
                            <table id="tableDetail" class="display table table-hover table-bordered table-striped" cellspacing="0" style="width:40%;">
                                <thead>
                                <tr>
                                    <th align="center">No</th>
                                    <th align="center">Tgl.Resep</th>
                                    <th align="center">Nama Obat</th>
                                    <th align="center">Harga</th>
                                    <th align="center">Signa</th>
                                    <th align="center">Banyak</th>
                                    <th align="center">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                            </table>
                        </div>

                        <div class="form-groupflex justify-between">
							<div id="surveyContainerTelaahObat" style="width:100%"></div>
                            <!-- <div id="surveyContainer" style="width:100%;"></div> -->
                        </div>
                        
                    </div>
                    <div align="right" class="mt-2" id="total_rekap"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect" onclick="simpan_data()" >Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    var surveyJSON = <?php echo file_get_contents(__DIR__ ."/telaah_obat/survey/telaah_obat.json");?>;
    var survey = new Survey.Model(surveyJSON, "surveyContainerTelaahObat");


    $('#detailModal').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('id');
        survey.setValue('no_register',userid);
        
        // $(e.currentTarget).find('input[name="user_id"]').val(userid);
    });
    survey.showNavigationButtons = false;

    // survey.onComplete.add(sendDataToServer);


    function simpan_data(){
        // survey.onComplete.add(sendDataToServer);
        // alert(JSON.stringify(survey.data));

        $.ajax({
                type: "POST",
                url: '<?= base_url('farmasi/frmcdaftar/insert_telaah/') ?>',
                data: {
                    data:JSON.stringify(survey.data)
                },
                success: function(data)
                {
                    console.log(data)
                    swal('Sukses','Data Berhasil Disimpan','success');
                },
                error: function(data)
                {
                    swal('Error','Data Gagal Disimpan','warning');
                
                }
            });

    }
</script>

<?php
	$this->load->view('layout/footer_left.php');
?>