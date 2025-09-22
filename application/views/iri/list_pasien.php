<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>

    <div class="row">
        <div class="col-lg-12 col-md-12">
					<?php echo $this->session->flashdata('pesan');?>
						<div class="card card-outline-info">
              <div class="card-header">
                            <h5 class="m-b-0 text-white text-center">Pasien Dalam Perawatan</h5>
                          </div>
							<div class="card-block">
              <h5 class="card-subtitle">Akses Ruangan : &nbsp;<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#roomModal" ><i class="fa fa-eye"></i></button></h5>
                 

						<div class="table-responsive m-t-15">
						<table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" id="list-pasien">
						  <thead>
							<tr>
								<th>No. Register</th>
								<th>No. MedRec</th>
								<th>Nama</th>
								<th>Kamar</th>
								<th>Kelas</th>
								<th>No. Bed</th>
								<th>Tgl. Masuk</th>
								<th>Dokter Yang Merawat</th>
								<th>Bayi</th>
								<th>PENJAMIN</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
							if($list_pasien!=''){
						  	foreach ($list_pasien as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['no_cm']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['nmruang']?></td>
						  		<td><?php echo $r['kelas']?></td>
						  		<td><?php echo $r['bed']?><br>
						  		
                  <?php //if($roleid != '32') {						
				           // } else {  ?>
                
                   <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onClick="edit_ruangan('<?php echo $r['no_ipd'];?>')">Ganti Ruangan</button> 
                
                 <?php// } ?>
						  	
                	</td>
						  		<td>
					  			<?php 						  		

						  		echo date('d-m-Y',strtotime($r['tglmasukrg']));
						  		?>
						  		</td>
						  		<td><?php echo $r['dokter']?></td>
						  		<td><?php 
						  			if($r['status_bayi'] == 0){
						  				echo "Tidak Punya";
						  			}else{
						  				echo "Punya";
						  			}
						  			?>
						  		</td>
						  		<!-- <td><?php //if($r['cara_bayar']=='BPJS' || $r['cara_bayar']=='DIJAMIN'){ echo $r['nmkontraktor']; } else echo $r['cara_bayar']; ?></td> -->
                  <td><?php echo $r['cara_bayar']?></td>
						  		<td>

                  <?php //if($roleid != '32') { ?>
						  		<a href="<?php echo base_url(); ?>iri/rictindakan/index/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plusthick"></i> Tindak</button></a>
						  		<a href="<?php echo base_url(); ?>iri/ricreservasi/index/<?php echo $r['no_ipd']?>/1"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-plusthick"></i> Mutasi</button></a>
						  		<a href="<?php echo base_url(); ?>iri/ricstatus/index/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-warning btn-sm"><i class="fa fa-plusthick"></i> Status</button></a>
                <?php// } else {?>
                <!--   <a href="<?php echo site_url();?>iri/ricpendaftaran/cetak_rawatinap/<?php echo $r['no_ipd']?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plusthick"></i>Rincian</a> -->
                  <a href="<?php echo site_url();?>iri/ricpasien/cetak_label/<?php echo $r['no_ipd']?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plusthick"></i>Cetak Label</a>
                  <a href="<?php echo site_url();?>iri/ricsjp/cetak_gelang/<?php echo $r['no_ipd']?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plusthick"></i>Cetak Gelang</a>
                 <?php //} ?>

                 
                  </td>
						  	</tr>
						  	<?php
						  	}}
						  	?>
							</tbody>
						</table>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
        </div>
				</div><!--- end row -->

  <!-- eDIT Modal -->
  <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Ruangan</h4>
        </div>
        <div class="modal-body">
          <form action="#" id="formedit" class="form-horizontal">
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">No Registrasi</p>
              <div class="col-sm-6">
                <input type="hidden" class="form-control" name="idrgiri" id="idrgiri">
                <input type="hidden" class="form-control" name="no_ipd" id="no_ipd">
                <input type="text" class="form-control" name="edit_no_ipd" id="edit_no_ipd"  disabled="">
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
              <p class="col-sm-3 form-control-label" id="lbl_nama">Kode Ruang / Bed</p>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="edit_bed" id="edit_bed"  disabled="">
                <input type="hidden" class="form-control" name="bed_asal" id="bed_asal">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Ruangan</p>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="edit_nmruang" id="edit_nmruang"  disabled="">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Kelas</p>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="edit_klsiri" id="edit_klsiri"  disabled="">
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Ganti Ruang</p>
              <div class="col-sm-6">
				<select id="ruang" class="form-control" name="ruang" onchange="get_bed(this.value)" required>
				</select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Ganti Bed</p>
              <div class="col-sm-6">
				<select class="form-control input-sm" id="bed" name="bed" required>
					
				</select>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="btnEdit" onclick="edit()" class="btn btn-primary">Edit Ruangan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- show access room-->
<!-- eDIT Modal -->
  <div class="modal fade" id="roomModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Akses Ruangan</h4>
        </div>
        <div class="modal-body">
          <?php foreach ($akses as $row) {
                  echo '<span class="badge badge-danger ml-auto m-b-5" style="padding:5px;">'.$row->akses_ruang.'</span> ';
                }
                ?> 
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<script>
	$(document).ready(function() {
		var dataTable = $('#list-pasien').DataTable( {
			
		});
	});
	$('#calendar-tgl').datepicker();



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
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/ricpasien/get_data_edit_ruangan')?>",
      data: {
        no_ipd: no_ipd
      },
      success: function(data){
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
      error: function(){
        alert("error");
      }
    });
  }



  function get_bed(val){
	$('#bed')
        .find('option')
        .remove()
        .end()
    ;
    $("#bed").append("<option value=''>Loading...</option>");
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select/",
        data:   {
                    val        : val
                },
    }).done(function(msg) {
    	$('#bed')
            .find('option')
            .remove()
            .end()
        ;
        $("#bed").append(msg);
    });
  }

  function edit()
  {
    $('#btnEdit').text('saving...'); //change button text
    $('#btnEdit').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('iri/ricpasien/edit_ruangan')?>";  

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formedit').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            // $('#editModal').modal('hide');

            $('#btnEdit').text('Edit Ruangan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 

            if(data.sukses){
            	location.reload(true);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#editModal').modal('hide');
            // alert('Error adding / update data');
            $('#btnEdit').text('Edit Ruangan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 

        }
    });
  }

</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 
