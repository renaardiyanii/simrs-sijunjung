<?php
$this->load->view('radvdatapemeriksaan');
?>
<script type="text/javascript">
var id_pemeriksaan = <?php echo $id_pemeriksaan_rad; ?>;
$(document).ready(function() {
    $('#nama_bhp').select2();
    $("#nama_bhp_edit").select2({
        dropdownParent: $("#editBhp")
    });
    $('#tabel_tindakan').DataTable();

    var no_register = "<?php echo $no_register;?>";
    var cekview = "<?php echo $view;?>";
	if(cekview==0){
		tabeltindakan(id_pemeriksaan);
	}else{
		tabeltindakan_view(id_pemeriksaan);
	}
    
    $("#form_add_tindakan").submit(function(event) {
        console.log($('#form_add_tindakan').serialize());
	    document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
	    $.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'rad/radcdaftar/insert_bhp'; ?>",
	        dataType: "JSON",
	        data: $('#form_add_tindakan').serialize(),
	        success: function(data){
			    if (data == true) {
			    	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			    	$('#form_add_tindakan')[0].reset();
                    tabeltindakan(id_pemeriksaan);
			        swal("Sukses", "Tindakan berhasil disimpan.", "success");
			    } else {
			    	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					swal("Error", "Gagal menginput tindakan. Silahkan coba lagi.", "error");
			    }
	        },
	        error:function(event, textStatus, errorThrown) {
	        	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        },
	        timeout: 0
	    });
	  event.preventDefault();
    });

    $("#edit_form").submit(function(event) {
	    document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
	    $.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'rad/radcdaftar/edit_bhp_pemeriksaan'; ?>",
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

});

function tabeltindakan(id_pemeriksaan){
    var id_pemeriksaan = document.getElementById('id_pemeriksaan_rad').value;
    table = $('#tabel_tindakan').DataTable({
        ajax: "<?php echo site_url();?>rad/radcdaftar/bhp_pasien/"+id_pemeriksaan,
        columns: [
            { data: "no" },
            { data: "nama_bhp" },
            { data: "satuan" },
            { data: "kategori" },
            { data: "qty" },
            { data: "aksi"}
        ],


        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
   	});
}

function tabeltindakan_view(id_pemeriksaan){
    table = $('#tabel_tindakan').DataTable({
        ajax: "<?php echo site_url();?>irj/rjcpelayanan/tindakan_pasien/"+id_pemeriksaan,
        columns: [
            { data: "no" },
            { data: "nama_bhp" },
            { data: "satuan" },
            { data: "kategori" },
            { data: "qty" },
            { data: "aksi"}
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
   	});
}

function edit_bhp(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('rad/radcdaftar/get_data_edit_bhp')?>",
      data: {
        id: id
      },
      success: function(data){
        //console.log(data);
        $('#id_bhp_edit').val(data[0].id_bhp_rad);
		$('#id_bhp_edit_hide').val(data[0].id_bhp_rad);
		$('#id_pemeriksaan_hide').val(data[0].id_pemeriksaan_rad);
		$('#nama_bhp_edit').val(data[0].nama_bhp+'@'+data[0].satuan+'@'+data[0].kategori).trigger("change");
        //console.log($('#nama_bhp_edit').val(data[0].nama_bhp+'@'+data[0].satuan+'@'+data[0].kategori));
        $('#qty_edit').val(data[0].qty);
      },
      error: function(){
        alert("error");
      }
    });
}
</script>
<div class="card m-5">
    <div class="card-body">
		<form class="form" id="form_add_tindakan">
			<div class="form-group row">
				<p class="col-sm-2 form-control-label" >BHP *</p> 
				<div class="col-sm-3">
					<div class="input-group">
						<select name="nama_bhp" id="nama_bhp" class="form-control select2">
                            <option>-- Pilih BHP --</option>
                            <?php 
                            foreach($master_bhp as $row) {
                                echo '<option value="'.$row->nama_bhp.'@'.$row->satuan_bhp.'@'.$row->kategori.'@'.$row->id_bhp.'">'.$row->nama_bhp.' | Satuan: '.$row->satuan_bhp.' | Kategori: '.$row->kategori.'</option>';
                            }
                            ?>
                        </select>
					</div>
				</div>
            </div><br>
			<div class="form-group row">
				<p class="col-sm-2 form-control-label">Qty</p>
				<div class="col-sm-3">
                    <div class="input-group">
                        <input type="number" class="form-control" name="qty" id="qty" value="0">
                    </div>
			    </div>	
            </div>
            <div class="form-group row">
				<!-- <p class="col-sm-2 form-control-label">Qty</p> -->
				<div class="col-sm-3">
                    <div class="demo-checkbox">	
                        <input type="checkbox" class="filled-in" value="1" name="ulang" id="ulang"  />
                        <label for="ulang">BHP Pengulangan</label>
                    </div>
			    </div>	
            </div><br>
            <div class="form-group row">
				<div class="offset-sm-2 col-sm-6">
                    <input type="hidden" class="form-control" name="no_register" id="no_register" value="<?php echo $no_register ?>">
                    <input type="hidden" class="form-control" name="id_pemeriksaan_rad" id="id_pemeriksaan_rad" value="<?php echo $id_pemeriksaan_rad ?>">
	                <button type="reset" class="btn btn-danger btn-sm">Reset</button>
	                <button type="submit" class="btn btn-primary btn-sm" id="btn-tindakan" name="btn-tindakan">Simpan</button>
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
						<th>BHP</th>
						<th>Satuan</th>
						<th>Kategori</th>
						<th>Qty</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>			
				</tbody>
			</table>
		</div>                         
    </div>
</div>

<form method="POST" id="edit_form" class="form-horizontal">
    <!-- Modal Edit Obat -->
    <div class="modal fade" id="editBhp" tabindex="1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit BHP</h4>
                </div>
                <div class="modal-body">
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Id BHP Pemeriksaan</p>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="id_bhp_edit" id="id_bhp_edit" disabled="">
							<input type="hidden" class="form-control" name="id_bhp_edit_hide" id="id_bhp_edit_hide">
							<input type="hidden" class="form-control" name="id_pemeriksaan_hide" id="id_pemeriksaan_hide">
						</div>
                  	</div><br>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Nama BHP</p>
						<div class="col-sm-8">
                            <select name="nama_bhp_edit" id="nama_bhp_edit" class="form-control select2" style="width: 80%;">
                                <option value="">-- Pilih BHP --</option>
                                <?php 
                                foreach($master_bhp as $row) {
                                    echo '<option value="'.$row->nama_bhp.'@'.$row->satuan_bhp.'@'.$row->kategori.'">'.$row->nama_bhp.' | '.$row->satuan_bhp.' | '.$row->kategori.'</option>';
                                }
                                ?>
                            </select>
						</div>
                  	</div><br>
                      <div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Qty</p>
						<div class="col-sm-6">
                            <input type="number" class="form-control" name="qty_edit" id="qty_edit">
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