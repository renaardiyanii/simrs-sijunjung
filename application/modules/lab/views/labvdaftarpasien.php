<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<html>
<style>
	.bebas{
		background-color:#ff8080!important;
	}
</style>
<script type='text/javascript'>
	$(function() {
		$('#example').DataTable();
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  
	});

	var intervalSetting = function () {
		location.reload();
	};
	setInterval(intervalSetting, 60000);

	function tindak(waktu_masuk,no_register){
		if(waktu_masuk==''){
			swal({
	         title: "Tindak Pasien",
	         text: "Apakah Pasien sudah masuk Ke Ruangan Laboratorium ?",
	         type: "info",
	         showCancelButton: true,
	         closeOnConfirm: false,
	         showLoaderOnConfirm: true,
	      },
	      function(){
	         location.href = '<?php echo site_url('lab/labcdaftar/pemeriksaan_lab');?>/'+no_register;         
	      });
		}else{
	      	location.href = '<?php echo site_url('lab/labcdaftar/pemeriksaan_lab');?>/'+no_register;
	   	}
	}
</script>

<?php
	echo $this->session->flashdata('success_msg');
?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
                <div class="row p-t-0">

                    <?php echo form_open('lab/labcdaftar/daftar_pasien_luar');?>
					<div class="col-md-4">
						<div class="input-group" align="right">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Registrasi Pasien Luar</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->

					<!-- Modal -->
					<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-success modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Registrasi Pasien Luar</h4>
								</div>
								<div class="modal-body">
									<!-- <div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_nama">NO RM</p>
										<div class="col-sm-7">
											<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
											<input type="text" class="form-control" name="no_cm" id="no_cm" placeholder="Isi Jika Ada">
										</div>
									</div> -->
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
										<p class="col-sm-3 control-label col-form-label">Tanggal Lahir</p>
										<div class="col-sm-7">
											<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir">
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
										<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="dokter" id="dokter" placeholder="Isi Jika Ada">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">RS Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="perujuk" id="perujuk">	
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">IKS</p>
										<div class="col-sm-7">
											<select name="iks" id="iks" class="form-control">
												<option selected="">--Pilih Kontraktor--</option>
												<?php 
													foreach($kontraktor as $row){
													echo '<option value="'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">No HP</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="no_hp" id="no_hp">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">Email</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="email" id="email">
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Simpan</button>
								</div>
							</div>

						</div>
					</div>
					<?php echo form_close();?>

                    <div class="col-md-4">
					<?php echo form_open('lab/labcdaftar');?>
						<div class="form-group row">
							<div class="">											
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</div>
						</div>
					<?php echo form_close();?>
                    </div>
                    <div class="col-md-4">
					<?php echo form_open('lab/labcdaftar');?>
                        <div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="No. Rekam Medik" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					<?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
            	<h3><?=$title?></h3>
                <div class="table-responsive m-t-0">
                    <table id="example" class="display nowrap table table-hover table-striped table-bordered">
                        <thead>
							<tr>
							  	<th>Aksi</th>
							  	<th>Tanggal & Waktu Kunjungan</th>
							  	<th>No Medrec</th>
							  	<th>No Registrasi</th>
							  	<th>Nama</th>
							  	<!-- <th>Kelas</th> -->
							  	<th>Ruangan</th>
							  	<th>CITO</th>
							  	<th>Bed</th>
							</tr>
                        </thead>
						<tbody>
							<?php
								$i=1;
									foreach($laboratorium as $row){
									$no_register=$row->no_register;
									$today =  date('Y-m-d H:i:s', strtotime($row->jadwal_lab . ' +1 day'));
									$harini = date("Y-m-d");
									//var_dump($today);
									//if($row->jadwal_lab < $harini) {
							?>
							
							<?php// } else { ?>
								<tr>
							  	<td>
									<a href="javascript:;" class="btn btn-primary btn-xs" onClick="return openUrl('<?php echo site_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register); ?>');">Tindak <i class="ti-pencil"></i></a>
									<a href="<?php echo base_url().'lab/labcdaftar/batal_kunjung/'.$row->no_register; ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a>
									<!-- <?php if(substr($no_register,0,2) == 'PL') { ?>
										<a href="<?php echo site_url().'irj/rjcregistrasi/cetak_label_pl/'.$row->no_register; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plusthick"></i>Cetak Label</a>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editDataModal" onclick="edit_data('<?php echo $row->no_register ; ?>')">Edit Data</button>
									<?php } else { ?>
										<a href="<?php echo site_url().'irj/rjcregistrasi/cetak_label/'.$row->no_register; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plusthick"></i>Cetak Label</a>
									<?php } ?> -->
									<!-- <br><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailPemeriksaan" onclick="detail_pemeriksaan('<?php echo $row->no_register ; ?>')">Detail Item Pemeriksaan</button> -->
							  	</td>
								<td><?php if($row->jadwal_lab != NULL) {
									echo date('Y-m-d',strtotime($row->jadwal_lab));
								} else{}
								?></td>
								<td><?php 
									if(substr($row->no_register,0,2) == 'PL'){
										echo 'PL-'.$row->no_medrec;									
									}else{
										echo $row->no_cm;									
									}
								?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nama;?></td>
								<!-- <td><?php echo $row->kelas;?></td> -->
								<td><?php echo $row->idrg;?></td>
								<td style="<?= $row->order_lab_cito!=null || $row->order_lab_cito!=''?'background-color:red;color:black':'' ?>"><?php echo $row->order_lab_cito?'CITO':'';?></td>
								<td><?php echo $row->bed;?></td>
							</tr>
							<?php // } ?>
							<?php } ?>
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" id="update_form" class="form-horizontal">
	<div class="modal fade" id="editDataModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-success modal-lg">
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
							<input type="hidden" class="form-control" name="no_register_hide" id="no_register_hide">
							<input type="text" class="form-control" name="nama_edit" id="nama_edit">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Jenis Kelamin</p>
						<div class="col-sm-7">
							<select name="jk_edit" id="jk_edit" class="form-control">
								<option value="L">Laki-laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<label class="col-sm-3 control-label col-form-label">Cara Bayar *</label>
						<div class="col-sm-7">
							<div class="form-inline">										
								<input type="radio" id="umum_edit" name="cara_bayar_edit" value="UMUM" class="detail_edit">
								<label for="umum_edit">Umum</label>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" id="bpjs_edit" name="cara_bayar_edit" value="BPJS" class="detail_edit">
								<label for="bpjs_edit">BPJS</label>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" id="kerjasama_edit" name="cara_bayar_edit" value="KERJASAMA" class="detail_edit">
								<label for="kerjasama_edit">Kerja Sama</label>
							</div>
						</div>
					</div>
					<div class="form-group row" id="input_kontraktor_edit">
						<div class="col-sm-1"></div>
						<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">RS Perujuk</label>
						<div class="col-sm-7">
							<div class="form-inline">
								<select id="id_kontraktor_edit_iks" class="form-control select2" style="width: 100%" name="iks_edit">
									<option value="">-- Pilih Penjamin --</option>	
									<?php 
									foreach($kontraktor as $row){
										echo '<option value="'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
									} ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row" id="input_kontraktor_bpjs_edit">
						<div class="col-sm-1"></div>
						<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">RS Perujuk</label>
						<div class="col-sm-7">
							<div class="form-inline">
								<select id="id_kontraktor_edit_bpjs" class="form-control select2" style="width: 100%" name="iks_bpjs">
									<option value="">-- Pilih Penjamin --</option>	
									<?php 
									foreach($kontraktor_bpjs as $row){
										echo '<option value="'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
									} ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 control-label col-form-label">Tanggal Lahir</p>
						<div class="col-sm-7">
							<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir_edit" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir_edit">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="alamat_edit" id="alamat_edit">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="dokter_edit" id="dokter_edit" placeholder="Isi Jika Ada">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="">Diagnosa</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="diagnosa_edit" id="diagnosa_edit">	
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="">No HP</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="no_hp_edit" id="no_hp_edit">	
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="">Email</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="email_edit" id="email_edit">	
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button class="btn btn-primary" type="submit" id="btn-update">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="modal fade" id="detailPemeriksaan" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Detail Pemeriksaan Pasien</h4>
			</div>
			<div class="modal-body">
				<div class="card">
            		<div class="card-block">
						<div class="form-group row">
							<div class="col-sm-1"></div>
							<div class="table-responsive m-t-0">
								<table id="tbl-pemeriksaan" class="display nowrap table table-hover table-striped table-bordered">
									<thead>
										<tr>
											<th>No</th>
											<th>Pemeriksaan</th>
										</tr>
									</thead>
									<tbody id="tbody-pemeriksaan"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
function edit_data(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('rad/radcdaftar/get_data_pasien_luar')?>",
      data: {
        id: id
      },
      success: function(data){
        console.log(data);
        $('#no_register_hide').val(data[0].no_register);
		$('#nama_edit').val(data[0].nama);
		$('#jk_edit').val(data[0].jk);
		$('#id_kontraktor_edit_iks').val(data[0].nmkontraktor);
		$('#id_kontraktor_edit_bpjs').val(data[0].nmkontraktor);
		$('#tgl_lahir_edit').val(data[0].tgl_lahir);
		$('#alamat_edit').val(data[0].alamat);
		$('#dokter_edit').val(data[0].dokter);
		$('#diagnosa_edit').val(data[0].diagnosa);
		$('#no_hp_edit').val(data[0].no_hp);
		$('#email_edit').val(data[0].email);
		if(data[0].cara_bayar === 'UMUM') {
			// $('#umum_edit').checked;
			document.getElementById("umum_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').hide();
		} else if(data[0].cara_bayar === 'BPJS') {
			// $('#bpjs_edit').checked;
			document.getElementById("bpjs_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').show();
			$('#input_kontraktor_edit').hide();
		} else {
			// $('#kerjasama_edit').checked;
			document.getElementById("kerjasama_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').show();
		}
      },
      error: function(){
        alert("error");
      }
    });
}

function detail_pemeriksaan2(noreg) {
	$.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('lab/labcdaftar/get_detail_pemeriksaan_lab')?>",
      data: {
        noreg: noreg
      },
      success: function(data){
        console.log(data);
        $('#no_register_hide').val(data[0].no_register);
      },
      error: function(){
        alert("error");
      }
    });
}

function detail_pemeriksaan(noreg) { 
    $.ajax({
        url: "<?php echo base_url();?>lab/labcdaftar/get_detail_pemeriksaan_lab/"+noreg,
        success: function(data) {
            // console.log(data);
            data = JSON.parse(data);
            $('#tbl-pemeriksaan').DataTable();
            $('#tbody-pemeriksaan').html('');
            let html = '';
            if(data.data.length>0){
                data.data.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.no}</td>
                        <td>${e.jenis_tindakan}</td>
                    </tr>
                    `;
                });
            $('#tbody-pemeriksaan').append(html);
            return;
            }
            $('#tbody-pemeriksaan').append('<tr><td colspan="6">Data Tidak ada.</td></tr>');

        },
        error: function(xhr) { // if error occured
            $('#tbody-pemeriksaan').append('<tr><td colspan="6">Data Tidak ada.</td></tr>');
            
        },
    });
}

$('#update_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-update").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>rad/radcdaftar/update_pasien_luar",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
           // document.getElementById("btn-update").innerHTML = 'Edit';
            $('#editDataModal').modal('hide'); 
            document.getElementById("update_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									//location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+no_register;
									window.location.reload();
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-update").innerHTML = 'Error';
           // $('#editDataModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });

$(document).ready(function(){
	$("#input_kontraktor").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	$("#input_perujuk").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	$("#input_kontraktor_bpjs").css("display","none");
	$(".detail").click(function(){ //Memberikan even ketika class detail di klik (class detail ialah class radio button)
		if ($("input[name='cara_bayar']:checked").val() == "BPJS" ) { //Jika radio button "berbeda" dipilih maka tampilkan form-inputan
			$("#input_kontraktor_bpjs").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$('#input_kontraktor').hide();
		} else if($("input[name='cara_bayar']:checked").val() == "KERJASAMA" ){
			$("#input_kontraktor").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$('#input_kontraktor_bpjs').hide();
		} else {
			$('#input_kontraktor_bpjs').hide();
			$('#input_kontraktor').hide();
		}
	});

	// $("#input_kontraktor_edit").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	// $("#input_perujuk").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	// $("#input_kontraktor_bpjs_edit").css("display","none");
	$(".detail_edit").click(function(){ //Memberikan even ketika class detail di klik (class detail ialah class radio button)
		if ($("input[name='cara_bayar_edit']:checked").val() == "BPJS" ) { //Jika radio button "berbeda" dipilih maka tampilkan form-inputan
			$("#input_kontraktor_bpjs_edit").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$('#input_kontraktor_edit').hide();
		} else if($("input[name='cara_bayar_edit']:checked").val() == "KERJASAMA" ){
			$("#input_kontraktor_edit").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$('#input_kontraktor_bpjs_edit').hide();
		} else {
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').hide();
		}
	});
});
</script>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 