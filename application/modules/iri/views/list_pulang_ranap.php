<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<?php // include('script_laprdpendapatan.php');	?>

<style>
hr {
	border-color:#7DBE64 !important;
}

</style>	

<script type='text/javascript'>
	$(document).ready(function () {	
		$('#tanggal_laporan').daterangepicker({
			autoUpdateInput: false,
			dateFormat:'YYYY-MM-DD',
			Format:'YYYY-MM-DD',
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('#tanggal_laporan').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
		});

		$('#tanggal_laporan').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});

		$('#dataTables-example').DataTable();

        $('#id_dokter').select2(); // Apply Select2 to your select element



    });
	function download(){	
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Keuangan Rawat Jalan!",
		  type: "warning",
		  showCancelButton: true,
	  	  showLoaderOnConfirm: false,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Ya!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
		 //    $.ajax({
			// 	type:'POST',
			// 	dataType: 'json',
			// 	url:"<?php echo base_url('irj/rjcexcel/export_excel')?>",
			// 	data: {
			// 		tanggal_awal : startDate,
			// 		tanggal_akhir : endDate
			// 	},
			// 	success: function(data){
		 //    swal("Download", "Sukses", "success");
			// 	},
			// 	error: function(){
			// 		alert("error");
			// 	}
			// });
			///TGL/$id_poli/$tgl0/$status/$cara_bayar/$tgl1
			poli = document.getElementById("id_poli").value;
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('irj/rjcexcel/excel_lapkeu/TGL')?>/"+poli+"/"+startDate+"/10/SEMUA/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}	

	function edit_ruangan(no_ipd) {
      $('#edit_no_ipd').val('');
      $('#edit_no_ipd_hide').val('');
      $('#edit_no_cm').val('');
      $('#edit_nama').val('');
      $('#edit_bed').val('');
      $('#edit_nmruang').val('');
      $('#edit_klsiri').val('');
      $('#bed').val('');
      // $('#edit_paket').iCheck('uncheck');
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "<?php echo base_url('iri/ricpasien/get_data_edit_ruangan') ?>",
        data: {
          no_ipd: no_ipd
        },
        success: function(data) {
          $('#idrgiri_ruang').val(data.response[0].idrgiri);
          $('#no_ipd_ruang').val(data.response[0].no_ipd);
          $('#edit_no_ipd_ruang').val(data.response[0].no_ipd);
          $('#edit_no_cm_ruang').val(data.response[0].no_cm);
          $('#edit_nama_ruang').val(data.response[0].nama);

          $('#edit_dpjp').val(data.response[0].nm_dokter);
          $('#dpjp_asal').val(data.response[0].id_dokter);

          $('#idrgiri').val(data.response[0].idrgiri);
          $('#no_ipd').val(data.response[0].no_ipd);
          $('#edit_no_ipd').val(data.response[0].no_ipd);
          $('#edit_no_cm').val(data.response[0].no_cm);
          $('#edit_nama').val(data.response[0].nama);
          $('#edit_bed').val(data.response[0].bed);
          $('#bed_asal').val(data.response[0].bed);
          $('#edit_nmruang').val(data.response[0].nmruang);
          $('#edit_klsiri').val(data.response[0].klsiri);

          var options, index, select, option;

          // Get the raw DOM object for the select box
          select = document.getElementById('ruang');

          // Clear the old options
          select.options.length = 0;

          // Load the new options
          options = data.options; // Or whatever source information you're working with
          select.options.add(new Option('Pilih Ruangan', ''));
          for (index = 0; index < options.length; ++index) {
            option = options[index];
            select.options.add(new Option(option.text, option.idrg));
          }
        },
        error: function() {
          alert("error");
        }
      });
    }

	function gantiDPJP() {
      $('#btnEdit').text('saving...'); //change button text
      $('#btnEdit').attr('disabled', true); //set button disable 
      var url;

      url = "<?php echo site_url('iri/ricpasien/gantiDPJP') ?>";

      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        data: $('#formDokter').serialize(),
        dataType: "JSON",
        success: function(data) {

          // $('#editModal').modal('hide');

          $('#btnEdit').text('Ganti DPJP'); //change button text
          $('#btnEdit').attr('disabled', false); //set button enable 

          if (data.code === 200) {
            location.reload(true);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#editModal').modal('hide');
          // alert('Error adding / update data');
          $('#btnEdit').text('Edit Ruangan'); //change button text
          $('#btnEdit').attr('disabled', false); //set button enable 

        }
      });
    }

	  function buatajax() {
    if (window.XMLHttpRequest) {
      return new XMLHttpRequest();
    }
    if (window.ActiveXObject) {
      return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

	 function ajaxdokter(id_poli) {
    var id = id_poli.substr(0, 4);
    var pokpoli = id_poli.substr(4, 4);

    ajaxku = buatajax();
    var url = "<?php echo site_url('iri/rictindakan/data_dokter_poli'); ?>";
    url = url + "/" + id;
    url = url + "/" + Math.random();
    ajaxku.onreadystatechange = stateChangedDokter;
    ajaxku.open("GET", url, true);
    ajaxku.send(null);

  }

function stateChangedDokter() {
    var data;
    if (ajaxku.readyState == 4) {
      data = ajaxku.responseText;
      if (data.length >= 0) {
        document.getElementById("id_dokter").innerHTML = data;
      }
    }
  }
</script>

<section class="content-header">
	<?php //include('pend_cari.php');	?>

</section>

<section class="content">
	<div class="row">
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<div class="card-header">		
				
					<h4  class="text-white" align="center">Pasien Pulang Rawat Inap</h4>

			</div>
			<div class="card-block">
				<div class="row">
					<form action="<?php echo base_url();?>iri/ricmedrec/list_pasien_pulang_ranap" method="post" accept-charset="utf-8">
						<div class="form-group row">
							
							<div class="col-md-8">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control" id="tanggal_laporan" name="tanggal_laporan" autocomplete="off" placeholder="Pilih Tanggal">
								</div>    
							</div>

							<div class="col-md-4">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div> 

							

						</div> 
					</form> 		
				</div>
				<div style="overflow:auto;">
						<table class="table table-striped" id="dataTables-example">
							<thead>
								<tr>
									<th>No</th>
									<th>Aksi</th>
									<th>Tanggal Masuk</th>
									<th>Tanggal Keluar</th>
									<th>Nama</th>
									<th>No RM</th>
									<th>No Register</th>
									<th>No SEP</th>
									<th>Ruang</th>
								</tr>

							</thead>
							<tbody>

							<?php 
								$i = 1;
								foreach($data_tind as $val){ 
									?>
									<tr>
										<td><?php echo $i++ ?></td>
										<td>
											<a href="<?php echo base_url(); ?>iri/rictindakan/form/tindakan/<?php echo $val->no_ipd?>" target="_blank"><button type="button" class="btn btn-danger btn-sm" ><i class="fa fa-plusthick"></i> Tindakan</button></a>
											<a href="<?php echo base_url(); ?>lab/labcdaftar/pemeriksaan_lab/<?php echo $val->no_ipd?>" target="_blank"><button type="button" class="btn btn-warning btn-sm" ><i class="fa fa-plusthick"></i> Lab</button></a>
											<a href="<?php echo base_url(); ?>iri/rictindakan/form/tindakan/<?php echo $val->no_ipd?>" target="_blank"><button type="button" class="btn btn-success btn-sm" ><i class="fa fa-plusthick"></i> Rad</button></a>
											<a href="<?php echo base_url(); ?>farmasi/frmcdaftar/permintaan_obat_petugas?no_register=<?php echo $val->no_ipd?>" target="_blank"><button type="button" class="btn btn-info btn-sm" ><i class="fa fa-plusthick"></i> Resep</button></a>
											<a href="<?php echo base_url(); ?>utdrs/utdcdaftar/pemeriksaan_utdrs/<?php echo $val->no_ipd?>" target="_blank"><button type="button" class="btn btn-info btn-sm" ><i class="fa fa-plusthick"></i> UTDRS</button></a>
											<a href="<?php echo base_url(); ?>pa/pacdaftar/pemeriksaan_pa/<?php echo $val->no_ipd?>" target="_blank"><button type="button" class="btn btn-info btn-sm" ><i class="fa fa-plusthick"></i> PA</button></a>
											<a href="<?php echo base_url(); ?>iri/rictindakan/form/operasi/<?php echo $val->no_ipd?>" target="_blank"><button type="button" class="btn btn-info btn-sm" ><i class="fa fa-plusthick"></i> Operasi</button></a>
											  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editDokter" onClick="edit_ruangan('<?php echo $val->no_ipd; ?>')">Ganti Dokter</button>
											
										</td>
										<td><?php echo date('d-m-Y',strtotime($val->tgl_masuk)) ?></td>
										<td><?php echo date('d-m-Y',strtotime($val->tgl_keluar)) ?></td>
										<td><?php echo $val->nama ?></td>
										<td><?php echo $val->no_cm ?></td>	
										<td><?php echo $val->no_ipd ?></td>							
										<td><?php echo $val->no_sep ?></td>	
										<td><?= $val->ruang ?></td>
										
									</tr>
								<?php 
									 }
									
								?>
								
							</tbody>
						</table>
				</div>

			
			</div>
		</div>
</section>


<div class="modal fade" id="editDokter" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-success">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ganti Dokter</h4>
      </div>
      <div class="modal-body">
        <form action="#" id="formDokter" class="form-horizontal">
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">No Registrasi</p>
            <div class="col-sm-6">
              <input type="hidden" class="form-control" name="idrgiri" id="idrgiri">
              <input type="hidden" class="form-control" name="no_ipd" id="no_ipd">
              <input type="text" class="form-control" name="edit_no_ipd" id="edit_no_ipd" disabled="">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">No Medrec</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_no_cm" id="edit_no_cm" disabled="">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Pasien</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_nama" id="edit_nama" disabled="">
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Dokter Dpjp Sekarang</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_dpjp" id="edit_dpjp" disabled="">
              <input type="hidden" class="form-control" name="dpjp_asal" id="dpjp_asal">
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Dokter Spesialis</p>
            <div class="col-sm-6">
              <select id="id_poli" class="form-control js-example-basic-single" style="width: 100%" name="id_poli_tujuan" onchange="ajaxdokter(this.value)" required>
                <option value="">-- Pilih Nama Poli --</option>
                <?php
                foreach ($poli as $row) {
                  echo '<option value="' . $row->id_poli . '' . $row->nm_pokpoli . '">' . $row->nm_poli . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Dokter DPJP</p>
            <div class="col-sm-6">
              <select id="id_dokter" class="form-control js-example-basic-single" style="width: 100%" name="id_dokter_penerima" required>
                <option value="">-- Pilih Dokter --</option>
                <?php
                foreach ($dokter as $row) {
                  echo '<option value="' . $row->id_dokter . '">' . $row->nm_dokter . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Keterangan</p>
            <div class="col-sm-6">
              <textarea name="ket_ganti_dpjp" id="ket_ganti_dpjp" cols="30" rows="5" required></textarea>
            </div>
          </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" id="btnEdit" onclick="gantiDPJP()" class="btn btn-primary">Ganti DPJP</button>
      </div>
    </div>
  </div>
</div>

<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>

<script>
$(document).ready(function () {	
		$('#tanggal_laporan').daterangepicker({
			autoUpdateInput: false,
			dateFormat:'YYYY-MM-DD',
			Format:'YYYY-MM-DD',
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('#tanggal_laporan').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
		});

		$('#tanggal_laporan').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});

		$('#dataTables-example').DataTable();

        $('#id_dokter').select2(); // Apply Select2 to your select element



    });
</script>
